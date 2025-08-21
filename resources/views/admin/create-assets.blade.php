<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Create New Asset') }}
    </h2>
</x-slot>

<x-slot name="content">
    <form method="POST" action="{{ route('admin.assets.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-label for="name" :value="__('Asset Name')" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
            </div>

            <div>
                <x-label for="description" :value="__('Description')" />
                <x-textarea id="description" class="block mt-1 w-full" name="description" required></x-textarea>
            </div>

            <div>
                <x-label for="category" :value="__('Category')" />
                <x-select id="category" class="block mt-1 w-full" name="category" required>
                    <option value="">{{ __('Select Category') }}</option>
                    <option value="electronics">{{ __('Electronics') }}</option>
                    <option value="furniture">{{ __('Furniture') }}</option>
                    <option value="vehicles">{{ __('Vehicles') }}</option>
                </x-select>
            </div>

            <div>
                <x-label for="location" :value="__('Location')" />
                <x-input id="location" class="block mt-1 w-full" type="text" name="location" required />
            </div>

            <div>
                <x-label for="image" :value="__('Asset Image')" />
                <x-input id="image" class="block mt-1 w-full" type="file" name="image" accept="image/*" required />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button class="ml-4">
                {{ __('Create Asset') }}
            </x-button>
        </div>
    </form>
</x-slot>

















</x-app-layout>