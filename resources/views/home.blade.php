<x-layout>
    <main>
        <x-partials.hero artist-name="AlgoRitmo" artist-id="5gkzdmNQ7rGN27mIzJxg4H" brand-tagline="Música que enseña programación web, sin aburrirte."/>
        <x-partials.albums artist-id="5gkzdmNQ7rGN27mIzJxg4H" />
        <x-partials.testimonials />
    </main>
@foreach ($albums as $album)
     <x-partials.album-single :album-id="$album->spotify_id" />
@endforeach
</x-layout>
