<x-app-layout>
<div class="max-w-xl mx-auto p-6">
    <h1 class="text-xl font-semibold mb-4">{{ $source === 'admins' ? 'Admin' : 'User' }} Details</h1>
    <div class="bg-white shadow rounded p-4 space-y-2">
        <div><span class="font-semibold">Name:</span> {{ $record->name }}</div>
        <div><span class="font-semibold">Email:</span> {{ $record->email }}</div>
        <div class="pt-4 flex gap-2">
            <a href="{{ route('admin.users.edit', ['id' => $record->id, 'source' => $source]) }}" class="px-3 py-2 bg-yellow-500 text-white rounded">Edit</a>
            <a href="{{ route('admin.users.index', ['source' => $source]) }}" class="px-3 py-2 bg-gray-200 rounded">Back</a>
        </div>
    </div>
</div>
 </x-app-layout>


