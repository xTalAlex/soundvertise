<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-song-embed id="{{ $getRecord()?->spotify_id }}"></x-song-embed>
</x-dynamic-component>
