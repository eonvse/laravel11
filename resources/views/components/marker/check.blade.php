@props(['value', 'type'=>'cell'])

@php
    $size = 'h-4 w-4';
    if($type=='form') $size = 'h-6 w-6';
@endphp

<div {{ $attributes->merge(['class'=>'flex h-full justify-center items-center cursor-pointer']) }}>
@if ($value!=1)
    <div><svg class="{{ $size }} text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="4" y="4" width="16" height="16" rx="2" /></svg></div>
@else
    <svg class="{{ $size }} text-green-700"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="9 11 12 14 20 6" />  <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
@endif
</div>
