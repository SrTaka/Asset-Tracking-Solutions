<x-app-layout>
    <x-slot name="header">
        <h2>Asset Assignments</h2>
    </x-slot>
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Asset</th>
                <th>Assigned At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignments as $assignment)
                <tr>
                    <td>{{ $assignment->user->name }}</td>
                    <td>{{ $assignment->asset->name }}</td>
                    <td>{{ $assignment->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>