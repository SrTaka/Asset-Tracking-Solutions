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
                                @php
                                    $qrData = route('admin.assets.show', $asset->id);
                                @endphp
                                <div class="w-48 h-48 flex items-center justify-center bg-white dark:bg-gray-900 rounded-lg border mb-2">
                                    {!! QrCode::size(180)->margin(2)->generate($qrData) !!}
                                </div>
                                <span class="text-xs text-gray-500 mt-1">QR Code</span>
                                <a href="{{ route('admin.assets.qr.download', $asset->id) }}" class="text-xs text-indigo-600 hover:underline mt-1">Download QR Code</a>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">ID:</span>
                                <span class="ml-2">{{ $asset->id }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Name:</span>
                                <span class="ml-2">{{ $asset->name }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Category:</span>
                                <span class="ml-2">{{ $asset->category->name ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Purchase Date:</span>
                                <span class="ml-2">{{ $asset->purchase_date }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Purchase Price:</span>
                                <span class="ml-2">{{ $asset->purchase_price }}</span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Description:</span>
                                <span class="ml-2">{{ $asset->description ?? '—' }}</span>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg shadow p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <span class="block text-xs text-gray-500 mb-1">Asset ID</span>
                                <span class="font-semibold text-lg text-gray-800 dark:text-gray-200">{{ $asset->id }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-500 mb-1">Name</span>
                                <span class="font-semibold text-lg text-gray-800 dark:text-gray-200">{{ $asset->name }}</span>
                            </div>                            
                            <div>
                                <span class="block text-xs text-gray-500 mb-1">Category</span>
                                <span class="font-semibold text-lg text-gray-800 dark:text-gray-200">{{ $asset->category->name ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-500 mb-1">Status</span>
                                <span class="font-semibold text-lg 
                                    @if($asset->status === 'available') text-green-600 
                                    @elseif($asset->status === 'repairs') text-orange-500 
                                    @elseif($asset->status === 'assigned') text-red-600 
                                    @else text-gray-800 dark:text-gray-200 @endif">
                                    {{ ucfirst($asset->status) }}
                                </span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-500 mb-1">Purchase Date</span>
                                <span class="font-semibold text-lg text-gray-800 dark:text-gray-200">{{ $asset->purchase_date }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-500 mb-1">Purchase Price</span>
                                <span class="font-semibold text-lg text-gray-800 dark:text-gray-200">{{ $asset->purchase_price }}</span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="block text-xs text-gray-500 mb-1">Description</span>
                                <span class="text-gray-700 dark:text-gray-300">{{ $asset->description ?? '—' }}</span>
                            </div>
                            
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


