<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show product') }}
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

                <div class="p-6 bg-white border-b border-gray-200">
                    <p><strong>Name:</strong> {{ $product->name }}</p>
                    <p><strong>Article:</strong> {{ $product->article }}</p>
                    <p><strong>Status:</strong> {{ $product->status }}</p>
                    <br>
                    <p><strong>Attributes</strong></p>
                    <ul>
                        @forelse ($product->attributes as $name => $value)
                            <li><strong>{{ $name }}:</strong> {{ $value }}</li>
                        @empty
                            <p>No attributes</p>
                        @endforelse
                    </ul>
                </div>

                <div class="py-4 flex gap-4">

                    
                    <x-primary-button>
                        <a href="{{ route('products.edit', $product) }}">{{ __('Edit') }}</a>
                    </x-primary-button>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Удалить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
