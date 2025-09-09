<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Asset Assignments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm text-gray-600 dark:text-gray-300">Total: {{ $assignments->count() }}</div>
                        <a href="{{ route('admin.assignments.create') }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded text-xs font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            {{ __('Assign Asset') }}
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-600 dark:text-gray-300 border-b dark:border-gray-700">
                                <tr>
                                    <th class="py-2 pr-4">User</th>
                                    <th class="py-2 pr-4">Asset</th>
                                    <th class="py-2 pr-4">Assigned At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assignments as $assignment)
                                    <tr class="border-b last:border-0 dark:border-gray-700">
                                        <td class="py-2 pr-4">{{ $assignment->user->name }}</td>
                                        <td class="py-2 pr-4">{{ $assignment->asset->name }} ({{ $assignment->asset_id }})</td>
                                        <td class="py-2 pr-4">{{ optional($assignment->created_at)->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-4 text-gray-500 dark:text-gray-400">No assignments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>