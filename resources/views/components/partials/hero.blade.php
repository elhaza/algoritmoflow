
  <!-- HERO -->
  <section class="relative overflow-hidden">
    <div class="absolute inset-0 grad opacity-20 blur-3xl"></div>
    <div class="max-w-6xl mx-auto px-4 py-20 relative">
      <div class="grid md:grid-cols-2 items-center gap-10">
        <div>
          <h1 class="text-4xl md:text-6xl font-black leading-tight">
            Aprende <span class="text-cyan-300">programación web</span><br>
            con ritmo: {{ $artistName }}
          </h1>
          <p class="mt-5 text-lg text-slate-300 max-w-xl">
            {{$brandTagline}} Letras con conceptos reales: HTML, CSS, JavaScript, PHP y Laravel, Git, APIs REST, seguridad, pruebas y más.
          </p>
          <div class="mt-8 flex flex-wrap gap-4">
            <a href="https://open.spotify.com/embed/artist/{{$artistId}}" target="_blank" rel="noopener" class="inline-flex items-center gap-3 px-5 py-3 rounded-xl bg-cyan-500 text-slate-900 font-semibold hover:opacity-95">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M12 0a12 12 0 100 24A12 12 0 0012 0zm5.356 17.356a.937.937 0 01-1.287.312c-3.527-2.154-7.966-2.646-13.19-1.457a.937.937 0 01-.41-1.826c5.708-1.283 10.595-.718 14.46 1.622.447.273.59.862.327 1.349zM17.9 13.9a1.17 1.17 0 01-1.604.39c-3.023-1.854-7.63-2.4-11.224-1.327a1.17 1.17 0 01-.663-2.24c4.2-1.245 9.338-.63 12.887 1.51a1.17 1.17 0 01.604 1.667zM18.134 10.1c-3.64-2.163-9.665-2.361-13.136-1.307a1.405 1.405 0 01-.8-2.695c4.145-1.234 10.922-1 15.234 1.55a1.405 1.405 0 01-1.298 2.452z"/></svg>
              Escúchalo en Spotify
            </a>

          </div>

        </div>
        <div class="rounded-2xl overflow-hidden glow border border-white/10">
          <!-- Embed del artista: muestra top tracks automáticamente -->
          <iframe style="border-radius:0"
          src="https://open.spotify.com/embed/artist/{{$artistId}}?utm_source=generator&theme=0" width="100%" height="480" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </section>
