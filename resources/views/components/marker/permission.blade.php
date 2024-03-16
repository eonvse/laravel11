@props(['name'])

@php
$type = empty($name) ? 'default' : explode('.',$name)[0];
$types = [
    'default' => 'bg-blue-500 text-white',
    'role' => 'bg-yellow-200 text-black',
    'task' => 'bg-sky-200 text-black',
    'user' => 'bg-green-200 text-black',
];
$css = isset($types[$type]) ? $types[$type] : $types['default'];
@endphp

<span class="{{ $css }} rounded p-1">{{ $name }}</span>
