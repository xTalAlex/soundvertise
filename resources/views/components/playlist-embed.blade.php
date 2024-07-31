@props(['id', 'compact' => false, 'dark' => false])

{{-- compact: height="152",  &theme=0 per tema nero --}}
<iframe style="border-radius:12px"
    src="https://open.spotify.com/embed/playlist/{{ $id }}?utm_source=generator{{ $dark ? '&theme=0' : '' }}"
    width="100%" height="{{ $compact ? 80 : 352 }}" frameBorder="0" allowfullscreen=""
    allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
