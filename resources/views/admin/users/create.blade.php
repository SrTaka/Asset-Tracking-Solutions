<x-app-layout>
    <div class="max-w-2xl mx-auto p-8 shadow rounded-lg mt-10">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">
            Create {{ $source === 'admins' ? 'Admin' : 'User' }}
        </h1>
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="source" value="{{ $source }}">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    autocomplete="off"
                />
                @error('name')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    autocomplete="off"
                />
                @error('email')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                @error('password')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center">
                <input
                    id="email_verified"
                    name="email_verified"
                    type="checkbox"
                    value="1"
                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    {{ old('email_verified') ? 'checked' : '' }}
                />
                <label for="email_verified" class="ml-2 text-sm text-gray-700">Mark email as verified</label>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a
                    href="{{ route('admin.users.index', ['source' => $source]) }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition"
                >
                    Cancel
                </a>
                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                >
                    Create
                </button>
            </div>
        </form>
    </div>
</x-app-layout>


