<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Post') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="bg-primary text-white px-6 py-4">
                    <h3 class="text-lg font-semibold">Create a New Post</h3>
                </div>
                <div class="px-6 py-4">
                    <form action="{{ route('posts.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                            <input type="text" id="title" name="title" class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Enter the title" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea id="content" name="content" rows="5" class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Write the description here..." required></textarea>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Submit</button>
                            <a href="{{ route('posts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
