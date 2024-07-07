<x-app-layout>
    <div class="max-w-5xl mx-auto py-6 px-2">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold mb-2">{{ $link->title }}</h1>
                <div>
                @foreach ($link->tags as $tag)
                    <span class="badge badge-primary">{{ $tag->name }}</span>
                @endforeach
                </div>
                <a href="{{ $link->url }}" class="text-blue-500 hover:underline" target="_blank">{{ $link->url }}</a>
            </div>
        </div>
    </div>
</x-app-layout>
