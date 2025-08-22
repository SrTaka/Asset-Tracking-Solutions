<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Create New Asset') }}
    </h2>
</x-slot>

<x-slot name="content">
    <form method="POST" action="{{ route('admin.assets.store') }}">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-input-label for="name" :value="__('Asset Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" rows="4">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="category_id" :value="__('Category ID')" />
                <x-text-input id="category_id" class="block mt-1 w-full" type="number" name="category_id" value="{{ old('category_id') }}" required />
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="purchase_date" :value="__('Purchase Date')" />
                <x-text-input id="purchase_date" class="block mt-1 w-full" type="date" name="purchase_date" value="{{ old('purchase_date') }}" required />
                <x-input-error :messages="$errors->get('purchase_date')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="purchase_price" :value="__('Purchase Price')" />
                <x-text-input id="purchase_price" class="block mt-1 w-full" type="number" step="0.01" min="0" name="purchase_price" value="{{ old('purchase_price') }}" required />
                <x-input-error :messages="$errors->get('purchase_price')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Create Asset') }}
            </x-primary-button>
        </div>
    </form>
</x-slot>

















</x-app-layout>