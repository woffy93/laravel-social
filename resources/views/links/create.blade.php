
<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('links.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="title" class="block font-medium text-sm text-gray-700">Title</label>
                        <input type="text" name="title" id="title" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                    </div>

                    <div class="mt-4">
                        <label for="url" class="block font-medium text-sm text-gray-700">Link</label>
                        <input type="text" name="url" id="url" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                    </div>
                    <div class="mt-4">
                        <label for="tags" class="block font-medium text-sm text-gray-700">Tags</label>
                        <input type="text" name="tags" id="tags" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="hashtags, remember the #" />
                    </div>

                    <x-primary-button class="ms-4">
                        {{ __('Post link') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
