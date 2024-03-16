@props(['id' => null, 'maxWidth' => null, 'type' =>'info'])

<x-modal-wire :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="">
        <div class="flex items-center justify-center text-lg font-medium text-gray-900 w-full text-center
        {{ $type=='info' ? 'bg-blue-500 text-white dark:bg-indigo-600 dark:text-gray-300' : '' }} 
        {{ $type=='warn' ? 'bg-red-600 text-white dark:bg-rose-500 dark:text-gray-200' : '' }}">
            {{ $title }}
        </div>

        <div class="px-6 py-4 mt-4 text-sm text-gray-600">
            {{ $content }}
        </div>
    </div>

    @isset($footer)
    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-right">
        {{ $footer }}
    </div>
    @endisset
</x-modal-wire>
