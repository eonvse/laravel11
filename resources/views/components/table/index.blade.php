<table {{ $attributes->merge(['class'=>'w-full text-sm text-left text-gray-500 dark:text-gray-400']) }}>
    @isset($header)
    <thead class="text-xs text-gray-700 bg-indigo-200 dark:bg-indigo-900 dark:text-gray-400">
        <tr class="uppercase">
            {{$header}}
        </tr>
        @isset($searching)
        <tr>
            {{$searching}}
        </tr>
        @endisset
    </thead>
    @endisset
    <tbody>
        {{$slot}}
    </tbody>
</table>
