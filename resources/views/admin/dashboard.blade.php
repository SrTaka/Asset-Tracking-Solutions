<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
<!-- Hamburger Sidebar with Tabbed Content (Tailwind + Alpine.js) -->
<div x-data="{ sidebarOpen: false, activeTab: 'dashboard' }" class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'block' : 'hidden md:block'" class="fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-gray-800 shadow-lg md:relative md:translate-x-0 transition-transform duration-200 ease-in-out">
        
        <nav class="mt-4 flex flex-col gap-2 px-4">
            <button @click="activeTab = 'dashboard'; sidebarOpen = false" :class="activeTab === 'dashboard' ? 'bg-indigo-100 dark:bg-indigo-700 text-indigo-700 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700'" class="flex items-center px-4 py-2 rounded transition">
                <span class="mr-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"/></svg></span>
                Dashboard
            </button>
            <button @click="activeTab = 'assets'; sidebarOpen = false" :class="activeTab === 'assets' ? 'bg-indigo-100 dark:bg-indigo-700 text-indigo-700 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700'" class="flex items-center px-4 py-2 rounded transition">
                <span class="mr-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6"/></svg></span>
                Asset Management
            </button>
            <button @click="activeTab = 'users'; sidebarOpen = false" :class="activeTab === 'users' ? 'bg-indigo-100 dark:bg-indigo-700 text-indigo-700 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700'" class="flex items-center px-4 py-2 rounded transition">
                <span class="mr-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"/></svg></span>
                User Management
            </button>
            <button @click="activeTab = 'assignments'; sidebarOpen = false" :class="activeTab === 'assignments' ? 'bg-indigo-100 dark:bg-indigo-700 text-indigo-700 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700'" class="flex items-center px-4 py-2 rounded transition">
                <span class="mr-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                Asset Assignments
            </button>
            <button @click="activeTab = 'settings'; sidebarOpen = false" :class="activeTab === 'settings' ? 'bg-indigo-100 dark:bg-indigo-700 text-indigo-700 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700'" class="flex items-center px-4 py-2 rounded transition">
                <span class="mr-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 10c-4.41 0-8-1.79-8-4V6c0-2.21 3.59-4 8-4s8 1.79 8 4v8c0 2.21-3.59 4-8 4z"/></svg></span>
                Settings
            </button>
            <form method="POST" action="{{ route('admin.logout') }}" class="mt-8">
                @csrf
                <button type="submit" class="flex items-center px-4 py-2 w-full text-left text-red-600 hover:bg-red-100 dark:hover:bg-red-900 rounded transition">
                    <span class="mr-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/></svg></span>
                    {{ __('Log Out') }}
                </button>
            </form>
        </nav>
    </div>
    <!-- Hamburger Button -->
    <div class="md:hidden fixed top-4 left-4 z-40">
        <button @click="sidebarOpen = true" class="p-2 rounded bg-white dark:bg-gray-800 shadow focus:outline-none">
            <svg class="w-7 h-7 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
    <!-- Main Content (Tabs) -->
    <div class="flex-1 ml-0 md:ml-64 overflow-y-auto transition-all duration-200">
        <div class="py-12 px-4 md:px-8 max-w-7xl mx-auto">
            <!-- Dashboard Tab (Asset Movement via Modal) -->
            <div x-show="activeTab === 'dashboard'" x-transition x-data="movementModal()">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h4 class="text-lg font-medium mb-6">Welcome to the Admin Dashboard</h4>
                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        <p class="text-gray-700 dark:text-gray-300 mb-4">Use the button below to view recent asset movement.</p>
                        <button @click="open()" class="px-4 py-2 bg-indigo-600 text-white rounded">View Asset Movement</button>
                    </div>
                </div>

                <!-- Asset Movement Modal -->
                <div x-show="isOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                    <div class="absolute inset-0 bg-black/50" @click="close()"></div>
                    <div class="relative bg-white dark:bg-gray-800 rounded shadow-lg w-full max-w-5xl mx-4 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Asset Movement Overview</h3>
                            <button @click="close()" class="text-gray-500 hover:text-gray-800 dark:hover:text-gray-200">✕</button>
                        </div>
                        <template x-if="loading">
                            <div class="text-gray-600 dark:text-gray-300">Loading...</div>
                        </template>
                        <template x-if="!loading">
                            <div>
                                <div class="mb-4 text-gray-700 dark:text-gray-300">
                                    <div>Default range: <span x-text="summary.range.start"></span> → <span x-text="summary.range.end"></span></div>
                                    <div class="mt-1 flex gap-4">
                                        <div>Total assignments: <span class="font-semibold" x-text="summary.total_assignments"></span></div>
                                        <div>Unique assets: <span class="font-semibold" x-text="summary.unique_assets"></span></div>
                                        <div>Unique users: <span class="font-semibold" x-text="summary.unique_users"></span></div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="bg-gray-50 dark:bg-gray-900 rounded p-4">
                                        <h4 class="font-medium mb-2 text-gray-700 dark:text-gray-200">Assignments Over Time</h4>
                                        <canvas id="movementChart" height="160"></canvas>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-900 rounded p-4 overflow-x-auto">
                                        <h4 class="font-medium mb-2 text-gray-700 dark:text-gray-200">Recent Assignments</h4>
                                        <table class="min-w-full text-sm">
                                            <thead class="text-left text-gray-600 dark:text-gray-300 border-b dark:border-gray-700">
                                                <tr>
                                                    <th class="py-2 pr-4">When</th>
                                                    <th class="py-2 pr-4">Asset</th>
                                                    <th class="py-2 pr-4">User</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template x-for="row in rows" :key="row.id">
                                                    <tr class="border-b last:border-0 dark:border-gray-700">
                                                        <td class="py-2 pr-4" x-text="row.assigned_at"></td>
                                                        <td class="py-2 pr-4" x-text="row.asset_name ? row.asset_name + ' (' + row.asset_id + ')' : row.asset_id"></td>
                                                        <td class="py-2 pr-4" x-text="row.user_name"></td>
                                                    </tr>
                                                </template>
                                                <tr x-show="rows.length === 0">
                                                    <td colspan="3" class="py-4 text-gray-500 dark:text-gray-400">No movements in this period.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <!-- End Asset Movement Modal -->
            </div>
            <!-- Asset Management Tab -->
            <div x-show="activeTab === 'assets'" x-transition>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h5 class="text-md font-medium mb-4 text-gray-700 dark:text-gray-300">Asset Management</h5>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('admin.assets.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Create New Asset
                            </a>
                            <a href="{{ route('admin.assets.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                View All Assets
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Asset Assignments Tab -->
            <div x-show="activeTab === 'assignments'" x-transition>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h5 class="text-md font-medium mb-4 text-gray-700 dark:text-gray-300">Asset Assignments</h5>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('admin.assignments.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Assign Asset
                            </a>
                            <a href="{{ route('admin.assignments.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                View Assignments
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- User Management Tab -->
            <div x-show="activeTab === 'users'" x-transition>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h5 class="text-md font-medium mb-4 text-gray-700 dark:text-gray-300">User Management</h5>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('admin.users.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                View All Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Settings Tab -->
            <div x-show="activeTab === 'settings'" x-transition>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h5 class="text-md font-medium mb-4 text-gray-700 dark:text-gray-300">Settings</h5>
                        <p class="text-gray-700 dark:text-gray-300">Settings content goes here.</p>
                    </div>
                </div>
            </div>
            <!-- Placeholder for Modals -->
            <div id="modal-root"></div>
        </div>
    </div>
</div>
<!-- Alpine.js for sidebar and tab logic -->
<script src="//unpkg.com/alpinejs" defer></script>
<!-- End Hamburger Sidebar Layout -->
</x-app-layout>
