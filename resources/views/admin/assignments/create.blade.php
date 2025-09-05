<x-app-layout>
    <x-slot name="header">
        <h2>Assign Asset to User</h2>
    </x-slot>
    <form method="POST" action="{{ route('admin.assignments.store') }}">
        @csrf
        <label>User:</label>
        <select name="user_id" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        <label>Asset:</label>
        <select name="asset_id" required>
            @foreach($assets as $asset)
                <option value="{{ $asset->id }}">{{ $asset->name }}</option>
            @endforeach
        </select>
        <button type="submit">Assign</button>
    </form>
</x-app-layout>