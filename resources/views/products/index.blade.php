<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-2xl flex justify-between items-center">
                    <span>{{ __('Choose status') }}</span>
                    <x-primary-button class="ms-6">
                        <a href="{{ route('products.create') }}">{{ __('Create new product') }}</a>
                    </x-primary-button>
                </div>

                <form action="{{ route('products.index') }}" method="GET">
                    
                    
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div>
                            <input type="radio" id="all" name="status" value="" @if(!$status) checked @endif>
                            <label for="all">All Products</label>
                        </div>
                        <div>
                            <input type="radio" id="available" name="status" value="available" @if($status === 'available') checked @endif>
                            <label for="available">Available</label>
                        </div>
                        <div class="mb-5">
                            <input type="radio" id="unavailable" name="status" value="unavailable" @if($status === 'unavailable') checked @endif>
                            <label for="unavailable">Unavailable</label>
                        </div>
                        <x-primary-button class="mt-6">
                            <a href="{{ route('products.index') }}">{{ __('Show') }}
                            </a>
                        </x-primary-button>
                </form>

                <table class="min-w-full divide-y divide-gray-200 mt-6">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $product->article }}</td>
                                <td class="px-6 py-4 whitespace-nowrap"><a class="text-lg" href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $product->status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                    <div class="flex items-center space-x-4">
                                        <x-primary-button>
                                            <a href="{{ route('products.edit', $product) }}">{{ __('Edit') }}</a>
                                        </x-primary-button>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-md">Delete</button>
                                        </form>
                                    </div>
                                </td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap" colspan="4">No products.
                                    <a href="{{ route('products.create') }}">Create?</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                {{ $products->links() }}

            </div>
        </div>
    </div>
</x-app-layout>



