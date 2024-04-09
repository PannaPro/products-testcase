<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-2xl">
                    <x-primary-button class="ms-6">
                        <a href="{{ url()->previous() }}">{{ __('Back') }}</a>
                    </x-primary-button>
                </div>
                <div class="p-6">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="article" class="block text-sm font-medium text-gray-700">Article</label>
                            <div class="flex items-center">
                                <input type="text" name="article" id="article"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Enter article" required value="{{ old('article') }}">
                                <button type="button" id="generate-article"
                                    class="px-3 py-1 bg-gray-300 text-gray-800 rounded-md ml-2">
                                    Generate
                                </button>
                            </div>
                            @error('article')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Enter name" required minlength="10" value="{{ old('name') }}">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <div class="mt-1">
                                <div class="flex items-center">
                                    <input type="radio" id="available" name="status" value="available" {{ old('status') === 'available' ? 'checked' : '' }} required class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="available" class="ml-3 block text-sm font-medium text-gray-700">Available</label>
                                </div>
                                <div class="flex items-center mt-2">
                                    <input type="radio" id="unavailable" name="status" value="unavailable" {{ old('status') === 'unavailable' ? 'checked' : '' }} required class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="unavailable" class="ml-3 block text-sm font-medium text-gray-700">Unavailable</label>
                                </div>
                            </div>                                                       
                        </div>
                        <div class="mb-4">
                            <label for="attribute" class="block text-sm font-medium text-gray-700">Product attributes</label>
                            <div class="flex items-center">
                                <input type="text" name="attribute_name[]"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-1/2 sm:text-sm border-gray-300 rounded-md"
                                placeholder="Parameter name" required value="{{ old('attribute_name')[0] ?? '' }}">
                                <input type="text" name="attribute_value[]"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-1/2 sm:text-sm border-gray-300 rounded-md ml-2"
                                placeholder="Parameter value" required value="{{ old('attribute_value')[0] ?? '' }}">
                                <button type="button" class="px-2 py-1 bg-red-500 text-white rounded-md ml-2" onclick="this.parentNode.remove()">Remove</button>
                            </div>
                            
                            <div id="attribute">
                                <!-- Additional attributes will be added from JS here -->
                            </div>
                            <button type="button" id="add-attribute" class="mt-2 px-2 py-2 bg-red-500 text-white rounded-md">Add Attribute</button>
                        </div>
                        <div class="flex justify-center">
                                <x-primary-button>{{ __('Create') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/add-attributes.js') }}"></script>
    <script src="{{ asset('js/generate-article.js') }}"></script>

</x-app-layout>
