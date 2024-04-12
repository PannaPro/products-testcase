<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit user permissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-2xl">
                    <x-primary-button class="ms-6">
                        <a href="{{ route('roles.index') }}">{{ __('Back') }}</a>
                    </x-primary-button>
                </div>
                @if ($errors->any())
                    <div class="p-6 text-sm text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="p-6">
                    <form action="{{ route('roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Role name</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" value="{{ $role->name }}"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Enter name" required value="{{ old('name') }}">
                            </div>
                        </div>
                        <div>
                            @foreach ($permissions as $permission)
                                <div class="form-group form-check">
                                    <input type="checkbox" value="{{$permission->id}}" class="form-check-input"
                                        name="permissions[]" id="exampleCheck{{$permission->id}}"
                                        @if($role->hasPermissionTo($permission->name)) checked @endif>
                                    <label class="form-check-label" for="exampleCheck{{$permission->id}}">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                            
                        </div>
                        <div class="flex justify-center">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
