<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Colors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-neutral-800">
                Models color bg    
                <div class="grid grid-cols-2">
                    <!-- build colors -->
                    <div class="border-1 bg-gray-100 dark:bg-gray-200 border-gray-100 dark:border-gray-200">gray-100</div>
                    <div class="border-1 bg-gray-300 dark:bg-gray-400 border-gray-300 dark:border-gray-400">gray-300</div>
                    <div class="border-1 bg-red-100 dark:bg-red-200 border-red-100   dark:border-red-200">red-100</div>
                    <div class="border-1 bg-red-300 dark:bg-red-400 border-red-300 dark:border-red-400">red-300</div>
                    <div class="border-1 bg-orange-100 dark:bg-orange-200 border-orange-100 dark:border-orange-200">orange-100</div>
                    <div class="border-1 bg-orange-300 dark:bg-orange-400 border-orange-300 dark:border-orange-400">orange-300</div>
                    <div class="border-1 bg-yellow-100 dark:bg-yellow-200 border-yellow-100 dark:border-yellow-200">yellow-100</div>
                    <div class="border-1 bg-yellow-300 dark:bg-yellow-400 border-yellow-300 dark:border-yellow-400">yellow-300</div>
                    <div class="border-1 bg-lime-100 dark:bg-lime-200 border-lime-100 dark:border-lime-200">lime-100</div>
                    <div class="border-1 bg-lime-300 dark:bg-lime-400 border-lime-300 dark:border-lime-400">lime-300</div>
                    <div class="border-1 bg-green-100 dark:bg-green-200 border-green-100 dark:border-green-200">green-100</div>
                    <div class="border-1 bg-green-300 dark:bg-green-400 border-green-300 dark:border-green-400">green-300</div>
                    <div class="border-1 bg-cyan-100 dark:bg-cyan-200 border-cyan-100 dark:border-cyan-200">cyan-100</div>
                    <div class="border-1 bg-cyan-300 dark:bg-cyan-400 border-cyan-300 dark:border-cyan-400">cyan-300</div>
                    <div class="border-1 bg-sky-100 dark:bg-sky-200 border-sky-100 dark:border-sky-200">sky-100</div>
                    <div class="border-1 bg-sky-300 dark:bg-sky-400 border-sky-300 dark:border-sky-400">sky-300</div>
                    <div class="border-1 bg-indigo-100 dark:bg-indigo-200 border-indigo-100 dark:border-indigo-200">indigo-100</div>
                    <div class="border-1 bg-indigo-300 dark:bg-indigo-400 border-indigo-300 dark:border-indigo-400">indigo-300</div>
                    <div class="border-1 bg-fuchsia-100 dark:bg-fuchsia-200 border-fuchsia-100 dark:border-fuchsia-200">fuchsia-100</div>
                    <div class="border-1 bg-fuchsia-300 dark:bg-fuchsia-400 border-fuchsia-300 dark:border-fuchsia-400">fuchsia-300</div>

                </div>
                <div class="mt-5">
                    Markers
                    <div>
                        <span class="bg-yellow-200 text-black m-2 p-1 rounded">role</span>
                        <span class="bg-sky-200 text-black m-2 p-1 rounded">task</span>
                        <span class="bg-green-200 text-black m-2 p-1 rounded">user</span>
                        <span class="bg-orange-100 text-black m-2 p-1 rounded">note</span>
                        
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
