<div>
    @forelse ($pairings as $pairing)
        <div>{{ $pairing->submission->song->name }} {{ $pairing->submission->playlist->name }} |
            {{ $pairing->relatedSubmission->song->name }} {{ $pairing->relatedSubmission->playlist->name }}</div>
    @empty
        <div>NO PAIRINGS</div>
    @endforelse

    <div>
        {{ $submission?->id ?? 'NO SUBMISSION' }}
    </div>
</div>
