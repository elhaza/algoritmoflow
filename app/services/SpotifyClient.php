<?php

namespace App\services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SpotifyClient
{
    private const TOKEN_URL = 'https://accounts.spotify.com/api/token';
    private const API_BASE  = 'https://api.spotify.com/v1';
    protected string $market;

    public function __construct()
    {
        $this->market = config('services.spotify.market', 'US');
    }

    protected function clientId(): string
    {
        $id = config('services.spotify.client_id');
        if (empty($id)) {
            throw new \RuntimeException('Missing config: services.spotify.client_id');
        }
        return $id;
    }

    protected function clientSecret(): string
    {
        $secret = config('services.spotify.client_secret');
        if (empty($secret)) {
            throw new \RuntimeException('Missing config: services.spotify.client_secret');
        }
        return $secret;
    }

    public function getAccessToken(): string
    {
        return Cache::remember('spotify.token', now()->addMinutes(50), function () {
            $resp = Http::asForm()
                ->withBasicAuth($this->clientId(), $this->clientSecret())
                ->post(self::TOKEN_URL, [
                    'grant_type' => 'client_credentials',
                ]);

            if (!$resp->successful()) {
                throw new \RuntimeException('Spotify token error: HTTP '.$resp->status().' - '.$resp->body());
            }

            $token = $resp->json('access_token');
            if (!$token) {
                throw new \RuntimeException('Spotify token error: access_token missing');
            }

            return $token;
        });
    }

    protected function authHeaders(): array
    {
        return [
            'Authorization' => 'Bearer '.$this->getAccessToken(),
            'Accept'        => 'application/json',
        ];
    }

    /** ========== Helpers ========== */

    /**
     * Hace una solicitud GET con manejo básico de 429 (Retry-After).
     */
    protected function get(string $url, array $query = [])
    {
        $resp = Http::withHeaders($this->authHeaders())->get($url, $query);

        // Retry sencillo si 429
        if ($resp->status() === 429) {
            $retryAfter = (int) ($resp->header('Retry-After') ?? 1);
            usleep(max($retryAfter, 1) * 1000000);
            $resp = Http::withHeaders($this->authHeaders())->get($url, $query);
        }

        if (!$resp->successful()) {
            throw new \RuntimeException('Spotify GET error: '.$url.' | HTTP '.$resp->status().' - '.$resp->body());
        }

        return $resp->json();
    }

    /**
     * Pagina sobre respuestas de Spotify que tienen { items, next, limit, offset, total }.
     * Retorna un arreglo plano con todos los items.
     */
    protected function paginate(string $path, array $query = []): array
    {
        $query = array_merge([
            'limit'  => 50,       // máx 50
            'offset' => 0,
        ], $query);

        $items = [];
        $next  = self::API_BASE.$path;

        while ($next) {
            // Si next trae query completa, úsala; si no, usa path+query
            if (str_starts_with($next, 'http')) {
                $resp = $this->get($next);
            } else {
                $resp = $this->get(self::API_BASE.$path, $query);
            }

            $batch = $resp['items'] ?? [];
            $items = array_merge($items, $batch);

            $next  = $resp['next'] ?? null;

            // Si no hay 'next', se acabó
            if (!$next) {
                break;
            }

            // Si hay next, Spotify ya incluye limit/offset en ese URL;
            // el siguiente ciclo entrará por la rama que usa $next absoluta
        }

        return $items;
    }

    /** ========== Endpoints usados ========== */

    public function getArtist(string $spotifyId): array
    {
        return $this->get(self::API_BASE.'/artists/'.$spotifyId);
    }

    /**
     * Lista TODOS los álbumes del artista (paginando).
     * $opts:
     *  - include_groups: "album,single,appears_on,compilation"
     *  - market: p.ej. "MX" o "US" (recomendado para normalizar disponibilidad)
     */
    public function getArtistAlbums(string $artistId, array $opts = []): array
    {
        $query = array_merge([
            'include_groups' => 'album,single,appears_on,compilation',
            'market'         => 'MX',  // ajusta si prefieres 'US' u otro
        ], $opts);

        return $this->paginate('/artists/'.$artistId.'/albums', $query);
    }

    /**
     * Lista TODOS los tracks de un álbum (paginando).
     * $opts:
     *  - market: p.ej. "MX"
     */
    public function getAlbumTracks(string $albumId, array $opts = []): array
    {
        $query = array_merge([
            'market' => 'MX',
        ], $opts);

        return $this->paginate('/albums/'.$albumId.'/tracks', $query);
    }

    /**
     * (Opcional) Obtener detalles completos de un álbum (portadas, etc.).
     */
    public function getAlbum(string $albumId, array $opts = []): array
    {
        $query = array_merge([
            'market' => 'MX',
        ], $opts);

        return $this->get(self::API_BASE.'/albums/'.$albumId, $query);
    }

    /**
     * Busca artistas por nombre usando /v1/search (type=artist).
     *
     * @param string $query  Nombre o parte del nombre a buscar
     * @param int    $limit  Máximo de resultados (1-50)
     * @param int    $offset Desplazamiento para paginar
     * @return array Lista de items de artistas (cada item es un array con datos del artista)
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function searchArtist(string $query, int $limit = 10, int $offset = 0): array
    {
        $limit = max(1, min(50, $limit)); // Spotify permite 1..50

        $resp = $this->request('GET', 'https://api.spotify.com/v1/search', [
            'q' => $query,
            'type' => 'artist',
            'limit' => $limit,
            'offset' => $offset,
            'market' => $this->market,
        ]);

        $data = $resp->json();

        return $data['artists']['items'] ?? [];
    }

    /**
     * Helper centralizado para llamadas con token y manejo de 429.
     */
    protected function request(string $method, string $url, array $query = [], array $body = [])
    {
        $token = $this->getAccessToken();

        $request = Http::withToken($token);

        // Si $url ya viene con query (paginación "next"), no añadimos params duplicados
        $isAbsoluteWithQuery = str_starts_with($url, 'http') && str_contains($url, '?');

        $request = $request->acceptJson()->retry(1, 0); // un reintento simple para errores transitorios

        $response = match (strtoupper($method)) {
            'GET' => $isAbsoluteWithQuery
                ? $request->get($url)
                : $request->get($url, $query),
            'POST' => $request->asForm()->post($url, $body ?: $query),
            default => throw new \InvalidArgumentException("HTTP method no soportado: {$method}")
        };

        // Manejo explícito de 429 (rate limit)
        if ($response->status() === 429) {
            $retryAfter = (int)($response->header('Retry-After', 1));
            sleep(max(1, $retryAfter));
            // Reintentar una vez más
            $response = match (strtoupper($method)) {
                'GET' => $isAbsoluteWithQuery
                    ? $request->get($url)
                    : $request->get($url, $query),
                'POST' => $request->asForm()->post($url, $body ?: $query),
            };
        }

        if ($response->failed()) {
            // Lanza excepción con body de error para depurar
            $response->throw();
        }

        return $response;
    }
}
