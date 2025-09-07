<!-- SECCIÓN MÚSICA / Albums -->
  <section id="musica" class="py-16 border-t border-white/10 bg-slate-900/50">
    <div class="max-w-6xl mx-auto px-4">
      <div class="flex items-end justify-between gap-6 flex-wrap">
        <div>
          <h2 class="text-3xl md:text-4xl font-bold">Canciones didácticas</h2>
          <p class="text-slate-300 mt-2 max-w-2xl">Cada tema explica un concepto real con definiciones claras, ejemplos y buenas prácticas, usando analogías y rimas memorables.</p>
        </div>
        
        <a href="https://open.spotify.com/intl-es/artist/{{$artistId}}" target="_blank" class="text-cyan-300 hover:underline">Ver todo en Spotify →</a>
      </div>

      <div class="mt-8 grid md:grid-cols-3 gap-6">
        <!-- Puedes duplicar estos embeds para destacar singles/álbums concretos -->
        <x-partials.album-single album-id="4cLDJhZcKF4SGgIK43M5RQ" />
        <x-partials.album-single album-id="6ye6ZwBb3Xxn1hZpHqZP8C" />
        <x-partials.album-single album-id="3HkOzS1Do4ZbmWU3czzaSn" />    
        <x-partials.album-single album-id="7k6OuXl3v8EEgbRebntovF" />
        <x-partials.album-single album-id="6JD8nIv9szXSalHId14bDN" />
        <x-partials.track track-id="1k0hGG4yePLy14XUE3aU8s" />
      </div>
    </div>
  </section>
