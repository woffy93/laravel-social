<x-app-layout>
    <form action="{{ route(Route::currentRouteName()) }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="tags" class="form-control" placeholder="Search by tag...">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
    <div class="max-w-5xl mx-auto py-6 px-2">
        <ul class="divide-y">
            @foreach($links as $link)
                <li class="py-4 px-2">
                    <a href="{{ route('links.show', $link) }}" class="text-xl font-semibold block">{{ $link->title }}</a>
                    <div>
                    @foreach ($link->tags as $tag)
                        <span class="badge badge-primary">{{ $tag->name }}</span>
                    @endforeach
                    </div>
                    <span class="text-sm text-gray-600">
                        {{ $link->created_at->diffForHumans() }} by <a href="{{ route('profile.show', $link->user->id) }}" class="text-blue-500">{{ $link->user->name }}
                    </span>
                    <p>{{ $link->likes->count() }} Like</p>
                    @if(auth()->user()->hasLiked($link))
                        <form action="{{ route('removeLike', ['likable_type' => get_class($link), 'likable_id' =>$link->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary">Remove Like</button>
                        </form>
                    @else
                        <form action="{{ route('like', ['likable_type' => get_class($link), 'likable_id' =>$link->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Like</button>
                        </form>
                    @endif

                </li>
            @endforeach
        </ul>

        <div class="mt-2">
            {{ $links->links() }}
        </div>
    </div>
</x-app-layout>
