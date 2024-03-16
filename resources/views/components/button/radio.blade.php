@props(['id','name', 'check'])

@php
$id = $id ?? md5($attributes->wire('model'));
$check = $check ?? '' ;
$name = $name ?? 'buttonGroup' ;

@endphp

<div {{ $attributes->merge(['class'=>'px-1 flex w-max']) }}>
  <input
    class="border-2 dark:checked:bg-indigo-600 focus:ring-0 focus:outline-none dark:border-gray-300"
    type="radio"
    id="{{ $id }}"
    name = "{{ $name }}"
    {{ $check }}
/>
</div>