<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles/List') }}
            </h2>
            <a href="{{ route('roles.create') }}" class="bg-gray-800 text-white rounded-md px-2 py-1">Create</a>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />

            <table class="w-full">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="px-4 py-2" width="5%">#</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Permissions</th>
                        <th class="px-4 py-2" width="20%">Created At</th>
                        <th class="px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $role->id }}</td>
                            <td class="px-4 py-2">{{ $role->name }}</td>
                            <td class="px-4 py-2">{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                            <td class="px-4 py-2">{{ $role->created_at->format('d M, Y') }}</td>
                            <td class="px-4 py-2 text-center flex space-x-2 justify-center">
                                <a href="{{ route('roles.edit', $role->id) }}" class="bg-gray-800 text-white rounded-md px-2 py-1">Edit</a>
                                <a href="javascript:void(0)"
                                onclick="deleteRole({{ $role->id }})" class="bg-red-800 text-white rounded-md px-2 py-1">Delete</a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type=text/javascript>
        function deleteRole(id) {
            if (confirm("Are you sure you want to delete?")) {
                $.ajax({
                    url: '{{ route("roles.destroy") }}',
                    type: 'DELETE',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        // On success, reload the page or remove the deleted row from the table
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while deleting the role.');
                    }
                });
            }
        }
        </script>
    </x-slot>
</x-app-layout>
