<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles / Edit') }}
            </h2>
            <a href="{{ route('roles.index') }}" class="bg-gray-800 text-white rounded-md px-2 py-1">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                            <div class="my-2">
                                <input value="{{ old('name', $role->name) }}" placeholder="Enter Role Name" type="text" name="name" id="name" class="mt-1 block w-1/2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div>
                            <label for="permissions" class="block text-sm font-medium text-gray-700">Permissions</label>
                            <div class="my-2">
                                @if($permissions->isNotEmpty())
                                    <div class="grid grid-cols-4 gap-4">
                                        @foreach($permissions as $permission)
                                            <div>
                                                <input @checked($hasPermissions->contains($permission->name)) type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}" class="mr-2">
                                                <label for="permission_{{ $permission->id }}" class="text-sm text-gray-700">{{ $permission->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('permissions')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                @endif
                            </div>
                        </div>

                        <button class="bg-gray-800 text-white rounded-md px-2 py-1">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
