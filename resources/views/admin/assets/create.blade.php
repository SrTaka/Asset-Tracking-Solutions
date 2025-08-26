<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Asset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Back to Dashboard Button -->
                    <div class="mb-6">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Dashboard
                        </a>
                    </div>

                    <h3 class="text-lg font-medium mb-6">Create New Asset</h3>

                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.assets.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Asset Name -->
                        <div>
                            <x-input-label for="name" :value="__('Asset Name')" />
                            <x-text-input id="name" 
                                         class="block mt-1 w-full" 
                                         type="text" 
                                         name="name" 
                                         :value="old('name')" 
                                         required 
                                         autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" 
                                      name="description" 
                                      rows="3" 
                                      class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div>
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select id="category_id" 
                                    name="category_id" 
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Select a category</option>
                                @if($categories->count() > 0)
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" disabled>No categories available. Please add categories first.</option>
                                @endif
                            </select>
                            @if($categories->count() == 0)
                                <p class="mt-1 text-sm text-yellow-600 dark:text-yellow-400">
                                    ⚠️ No asset categories found. Please add categories to the database first.
                                </p>
                            @endif
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Purchase Date -->
                        <div>
                            <x-input-label for="purchase_date" :value="__('Purchase Date')" />
                            <x-text-input id="purchase_date" 
                                         class="block mt-1 w-full" 
                                         type="date" 
                                         name="purchase_date" 
                                         :value="old('purchase_date')" 
                                         required />
                            <x-input-error :messages="$errors->get('purchase_date')" class="mt-2" />
                        </div>

                        <!-- Purchase Price -->
                        <div>
                            <x-input-label for="purchase_price" :value="__('Purchase Price')" />
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 dark:text-gray-400">
                                    $
                                </span>
                                <x-text-input id="purchase_price" 
                                             class="block mt-1 w-full pl-7" 
                                             type="number" 
                                             name="purchase_price" 
                                             :value="old('purchase_price')" 
                                             step="0.01" 
                                             min="0" 
                                             required />
                            </div>
                            <x-input-error :messages="$errors->get('purchase_price')" class="mt-2" />
                        </div>

                        <!-- Asset Image -->
                        <div>
                            <x-input-label for="asset_image" :value="__('Asset Image (Optional)')" />
                            <input type="file" 
                                   id="asset_image" 
                                   name="asset_image" 
                                   accept="image/*" 
                                   class="block mt-1 w-full text-sm text-gray-900 dark:text-gray-300
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-indigo-50 file:text-indigo-700
                                          hover:file:bg-indigo-100
                                          dark:file:bg-indigo-900 dark:file:text-indigo-300" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 10MB</p>
                            <x-input-error :messages="$errors->get('asset_image')" class="mt-2" />
                        </div>

                        <!-- QR Code Generation Info -->
                        <div class="mt-6 p-4 bg-indigo-50 dark:bg-indigo-900 rounded-md flex items-center">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7V5a2 2 0 012-2h2m10 0h2a2 2 0 012 2v2m0 10v2a2 2 0 01-2 2h-2m-10 0H5a2 2 0 01-2-2v-2" />
                            </svg>
                            <span class="text-sm text-indigo-700 dark:text-indigo-200">
                                A unique QR code will be automatically generated and saved for this asset after creation.
                            </span>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button class="ml-3">
                                {{ __('Create Asset') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
