<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sample Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white">
                    This is a sample page using the app layout.
                </div>
                
            </div>
               
        </div>

        {{-- Chart rendering section --}}
        <div style="padding: 20px; width: 600px; margin: auto;">
        {{$chart -> container()}}
       </div>
     <script src ="{{$chart ->cdn()}}"></script>
        {{$chart -> script()}}
</x-app-layout>