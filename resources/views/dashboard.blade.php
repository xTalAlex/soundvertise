<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
                <div class="space-y-4">
                    @foreach ($submissions as $submission)
                        <div class="flex space-x-2">
                            <div>{{ $submission->song->name }}</div>
                            <div>{{ $submission->playlist->name }}</div>
                            <div>{{ $submission->created_at }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
