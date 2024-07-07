<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}'s Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p><strong>Email:</strong> {{ $user->email }}</p>

                    @if(auth()->user() && auth()->user()->id !== $user->id)
                        @if(auth()->user()->isFollowing($user))
                            <form action="{{ route('unfollow', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Unfollow</button>
                            </form>
                        @else
                            <form action="{{ route('follow', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Follow</button>
                            </form>
                        @endif
                    @endif

                    <hr class="my-4">

                    <h3 class="text-xl font-semibold">Followers</h3>
                    @if($user->followers->isEmpty())
                        <p>No followers yet.</p>
                    @else
                        <ul>
                            @foreach($user->followers()->cursor() as $follower)
                                <li>
                                    <a href="{{ route('profile.show', $follower->follower->id) }}" class="text-blue-500">
                                        {{ $follower->follower->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
