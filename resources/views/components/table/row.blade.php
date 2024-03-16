<tr {{ $attributes->merge(['class'=>'odd:bg-white even:bg-slate-200 hover:bg-gray-300 hover:text-black border-b dark:odd:bg-gray-700 dark:even:bg-gray-600 dark:border-gray-700 dark:hover:text-white dark:hover:bg-gray-500 dark:text-gray-300']) }}'>
    {{$slot}}
</tr>