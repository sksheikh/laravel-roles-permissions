<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Articles / Create') }}
            </h2>
            <a href="{{ route('articles.index') }}" class="bg-gray-800 text-white rounded-md px-2 py-1">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('articles.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <div class="my-2">
                                <input value="{{ old('title') }}" placeholder="Enter Article Title" type="text" name="title" id="title" class="mt-1 block w-1/2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('title')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                            <div class="my-2">
                               <textarea name="content" placeholder="Enter Article Content" id="content" cols="30" rows="10" class="mt-1 block w-1/2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                @error('content')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
                            <div class="my-2">
                                <input value="{{ old('author') }}" placeholder="Enter Author Name" type="text" name="author" id="author" class="mt-1 block w-1/2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('author')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                        <button class="bg-gray-800 text-white rounded-md px-2 py-1">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
