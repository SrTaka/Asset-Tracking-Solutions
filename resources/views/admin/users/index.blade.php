<x-app-layout>
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Manage {{ $source === 'admins' ? 'Admins' : 'Users' }}</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.index', ['source' => 'users']) }}" class="px-3 py-1 rounded {{ $source==='users' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">Users</a>
            <a href="{{ route('admin.users.index', ['source' => 'admins']) }}" class="px-3 py-1 rounded {{ $source==='admins' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">Admins</a>
            <a href="{{ route('admin.users.create', ['source' => $source]) }}" class="ml-4 bg-green-600 text-white px-3 py-1 rounded">Create</a>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('admin.dashboard') }}" class="inline-block bg-gray-700 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded shadow transition">Back to Dashboard</a>
    </div>
</br>

    @if(session('status'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $row)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $row->name }}</td>
                    <td class="px-4 py-2">{{ $row->email }}</td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('admin.users.edit', ['id' => $row->id, 'source' => $source]) }}" class="px-2 py-1 bg-yellow-500 text-white rounded">Edit</a>
                        <form method="POST" action="{{ route('admin.users.destroy', ['id' => $row->id, 'source' => $source]) }}" onsubmit="return confirm('Delete this record?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-2 py-1 bg-red-600 text-white rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-6 text-center text-gray-500">No records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $items->links() }}</div>
</div>
 </x-app-layout>


