@if(session('success'))
    <div class="mb-4 font-medium text-sm bg-green-100 text-green-800 rounded-md px-4 py-2">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 font-medium text-sm bg-red-100 text-red-800 rounded-md px-4 py-2">
        {{ session('error') }}
    </div>
@endif
