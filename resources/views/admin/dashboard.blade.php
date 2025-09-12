<x-app-layout>
    <div x-data="{ sidebarOpen: false, activeTab: 'dashboard' }" class="flex h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Hamburger Button for Mobile -->
        <div class="md:hidden fixed top-4 left-4 z-40">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded bg-white dark:bg-gray-800 shadow focus:outline-none">
                <svg class="w-7 h-7 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Sidebar Overlay for Mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" 
             class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 md:hidden" x-cloak>
        </div>

        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-gray-800 shadow-lg md:relative md:translate-x-0 sidebar-transition flex flex-col md:inset-0">
            <!-- Close button for mobile -->
            <div class="flex items-center justify-between md:hidden px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <span class="font-semibold text-lg text-gray-700 dark:text-gray-200">Menu</span>
                <button @click="sidebarOpen = false" class="p-2 rounded bg-gray-100 dark:bg-gray-700 focus:outline-none">
                    <svg class="w-6 h-6 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <nav class="mt-4 flex flex-col gap-2 px-4 flex-1">
                <button @click="activeTab = 'dashboard'; sidebarOpen = false" :class="activeTab === 'dashboard' ? 'bg-indigo-100 dark:bg-indigo-700 text-indigo-700 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700'" class="flex items-center px-4 py-2 rounded transition">
                    <span class="mr-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"/></svg></span>
                    Dashboard
                </button>
                <button @click="activeTab = 'assets'; sidebarOpen = false" :class="activeTab === 'assets' ? 'bg-indigo-100 dark:bg-indigo-700 text-indigo-700 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700'" class="flex items-center px-4 py-2 rounded transition">
                    <span class="mr-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6"/></svg></span>
                    Asset Management
                </button>
                <button @click="activeTab = 'assignments'; sidebarOpen = false" :class="activeTab === 'assignments' ? 'bg-indigo-100 dark:bg-indigo-700 text-indigo-700 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700'" class="flex items-center px-4 py-2 rounded transition">
                    <span class="mr-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                    Asset Assignments
                </button>
                <button @click="activeTab = 'users'; sidebarOpen = false" :class="activeTab === 'users' ? 'bg-indigo-100 dark:bg-indigo-700 text-indigo-700 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700'" class="flex items-center px-4 py-2 rounded transition">
                    <span class="mr-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"/></svg></span>
                    User Management
                </button>
                <button @click="activeTab = 'maintenance'; sidebarOpen = false" :class="activeTab === 'maintenance' ? 'bg-indigo-100 dark:bg-indigo-700 text-indigo-700 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700'" class="flex items-center px-4 py-2 rounded transition">
                    <span class="mr-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232a3 3 0 104.243 4.243l-7.071 7.071a3 3 0 11-4.243-4.243l7.071-7.071z"/>
                        </svg>
                    </span>
                    Maintenance Plan
                </button>
                <button @click="activeTab = 'mailbox'; sidebarOpen = false" :class="activeTab === 'mailbox' ? 'bg-indigo-100 dark:bg-indigo-700 text-indigo-700 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700'" class="flex items-center px-4 py-2 rounded transition ">
                    <span class="mr-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    Mailbox
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

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto transition-all duration-200 md:ml-0">
            <div class="py-12 px-4 md:px-8 max-w-7xl mx-auto">

                <!-- Dashboard Tab -->
                <div x-show="activeTab === 'dashboard'" x-transition>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Total Users Card -->
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex items-center">
                            <div class="flex-shrink-0 bg-indigo-100 dark:bg-indigo-700 rounded-full p-3">
                                <svg class="w-6 h-6 text-indigo-600 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">Total Users</div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white" id="total_users">{{ \App\Models\User::count() + \App\Models\Admin::count()}}</div>
                            </div>
                        </div>
                        <!-- Total Assets Card -->
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex items-center">
                            <div class="flex-shrink-0 bg-green-100 dark:bg-green-700 rounded-full p-3">
                                <svg class="w-6 h-6 text-green-600 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">Total Assets</div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white" id="total_assets">
                                    {{ \App\Models\Asset::count() }}
                                </div>
                            </div>
                        </div>
                        <!-- Assigned Assets Card -->
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 dark:bg-yellow-700 rounded-full p-3">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">Assigned Assets</div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white" id="assigned_assets">{{ \App\Models\Assignment::whereNotNull('user_id')->count() }}</div>
                            </div>
                        </div>
                        <!-- Assets in Maintenance Card -->
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex items-center">
                            <div class="flex-shrink-0 bg-red-100 dark:bg-red-700 rounded-full p-3">
                                <svg class="w-6 h-6 text-red-600 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 10c-4.41 0-8-1.79-8-4V6c0-2.21 3.59-4 8-4s8 1.79 8 4v8c0 2.21-3.59 4-8 4z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">Assets in Maintenance</div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white" id="maintenance_assets">{{ \App\Models\Asset::where('status', 'maintenance')->count() }}</div>
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
                                <button class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Assign Asset
                                </button>
                                <button class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    View Assignments
                                </button>
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
                                <button class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    View All Users
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Maintenance Tab -->
                <div x-show="activeTab === 'maintenance'" x-transition>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h5 class="text-md font-medium mb-4 text-gray-700 dark:text-gray-300">Maintenance Plan</h5>
                            <p class="text-gray-700 dark:text-gray-300">Maintenance content goes here.</p>
                        </div>
                    </div>
                </div>

                <!-- Mailbox Tab -->
                <div x-show="activeTab === 'mailbox'" x-transition>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h5 class="text-md font-medium mb-4 text-gray-700 dark:text-gray-300">Mailbox</h5>
                            <p class="text-gray-700 dark:text-gray-300">Mailbox content goes here.</p>
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
            </div>
        </div>
    </div>
</x-app-layout>