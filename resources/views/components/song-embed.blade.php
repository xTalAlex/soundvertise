@props(['id', 'compact' => false, 'dark' => false])

<iframe style="border-radius:12px"
    src="https://open.spotify.com/embed/track/{{ $id }}?utm_source=generator{{ $dark ? '&theme=0' : '' }}"
    width="100%" height="{{ $compact ? 152 : 352 }}" frameBorder="0" allowfullscreen=""
    allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
