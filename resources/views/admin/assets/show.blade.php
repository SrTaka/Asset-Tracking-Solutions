<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Asset Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <a href="{{ route('admin.assets.index') }}" class="text-sm text-indigo-600">&larr; Back to Assets</a>
                    </div>

                    <div class="space-y-3">
                        <div class="flex flex-col sm:flex-row gap-6 mb-4">
                            <!-- Asset Image -->
                            <div class="flex-1 flex flex-col items-center">
                                @if(!empty($asset->image) && \Illuminate\Support\Facades\Storage::exists('public/' . $asset->image))
                                    <img src="{{ asset('storage/' . $asset->image) }}" alt="{{ $asset->name }}" class="w-48 h-48 object-contain rounded-lg border mb-2">
                                    <a href="{{ asset('storage/' . $asset->image) }}" download class="text-xs text-indigo-600 hover:underline mt-1">Download Image</a>
                                @else
                                    <div class="w-48 h-48 flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded-lg border mb-2">
                                        <span class="text-gray-500 dark:text-gray-300 text-sm">No Image</span>
                                    </div>
                                @endif
                                <span class="text-xs text-gray-500 mt-1">Asset Image</span>
                            </div>
                            <!-- QR Code -->
                            <div class="flex-1 flex flex-col items-center">
                                @if(!empty($asset->qr_code) && \Illuminate\Support\Facades\Storage::exists('public/' . $asset->qr_code))
                                    <img src="{{ asset('storage/' . $asset->qr_code) }}" alt="{{ $asset->name }} QR Code" class="w-48 h-48 object-contain rounded-lg border mb-2">
                                    <a href="{{ asset('storage/' . $asset->qr_code) }}" download class="text-xs text-indigo-600 hover:underline mt-1">Download QR Code</a>
                                @else
                                    <div class="w-48 h-48 flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded-lg border mb-2">
                                        <span class="text-gray-500 dark:text-gray-300 text-sm">No QR Code</span>
                                    </div>
                                @endif
                                <span class="text-xs text-gray-500 mt-1">QR Code</span>
                            </div>
                        </div>
                        <div><span class="font-semibold">ID:</span> {{ $asset->id }}</div>
                        <div><span class="font-semibold">Name:</span> {{ $asset->name }}</div>
                        <div><span class="font-semibold">Category:</span> {{ $asset->category->name ?? 'N/A' }}</div>
                        <div><span class="font-semibold">Purchase Date:</span> {{ $asset->purchase_date }}</div>
                        <div><span class="font-semibold">Purchase Price:</span> {{ $asset->purchase_price }}</div>
                        <div><span class="font-semibold">Description:</span> {{ $asset->description ?? '—' }}</div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


