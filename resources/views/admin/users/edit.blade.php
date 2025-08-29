<x-app-layout>
<div class="max-w-xl mx-auto p-6">
    <h1 class="text-xl font-semibold mb-4">Edit {{ $source === 'admins' ? 'Admin' : 'User' }}</h1>
    <form method="POST" action="{{ route('admin.users.update', ['id' => $record->id]) }}" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="source" value="{{ $source }}">

        <div>
            <label class="block text-sm">Name</label>
            <input name="name" value="{{ old('name', $record->name) }}" class="w-full border rounded px-3 py-2" />
            @error('name')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="block text-sm">Email</label>
            <input name="email" type="email" value="{{ old('email', $record->email) }}" class="w-full border rounded px-3 py-2" />
            @error('email')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="block text-sm">Password (leave blank to keep)</label>
            <input name="password" type="password" class="w-full border rounded px-3 py-2" />
            @error('password')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.index', ['source' => $source]) }}" class="px-3 py-2 bg-gray-200 rounded">Cancel</a>
            <button class="px-3 py-2 bg-blue-600 text-white rounded">Save</button>
        </div>
    </form>
</div>
 </x-app-layout>


