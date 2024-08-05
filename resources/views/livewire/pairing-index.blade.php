<div>
    <x-slot name="header">
        {{ __('Pairings') }}
    </x-slot>

    @forelse ($pairings as $pairing)
        <div>{{ $pairing->submission->song->name }} {{ $pairing->submission->playlist->name }} |
            {{ $pairing->pairedSubmission->song->name }} {{ $pairing->pairedSubmission->playlist->name }}</div>
    @empty
        <div>NO PAIRINGS</div>
    @endforelse

    <div>
        {{ $submission?->id ?? 'NO SUBMISSION' }}
    </div>
</div>
