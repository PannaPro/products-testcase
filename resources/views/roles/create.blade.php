<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create new user role') }}
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
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                       
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Role name</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Enter name" required value="{{ old('name') }}">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            @foreach ($permissions as $permission)
                                <div class="form-group form-check">
                                    <input type="checkbox" value="{{$permission->id}}" class="form-check-input"
                                        name="permissions[]" id="exampleCheck{{$permission->id}}"
                                        @if(old('permissions') !== null && in_array($permission->id, old('permissions'))) 
                                        checked 
                                    @endif>
                                    <label class="form-check-label" for="exampleCheck{{$permission->id}}">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                            @error('permissions')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-center">
                                <x-primary-button>{{ __('Create') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
