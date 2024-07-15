<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-playlist-embed id="{{ $getRecord()?->spotify_id }}"></x-playlist-embed>
</x-dynamic-component>
