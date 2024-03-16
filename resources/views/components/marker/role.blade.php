@props(['name'])

@php
$type = empty($name) ? 'default' : explode(' ',$name)[0];
$types = [
    'default' => 'bg-blue-500 text-white',
    'Roles' => 'bg-yellow-200 text-black',
    'Tasks' => 'bg-sky-200 text-black',
    'Users' => 'bg-green-200 text-black',
];
$css = isset($types[$type]) ? $types[$type] : $types['default'];
@endphp

<span class="{{ $css }} rounded p-1">{{ $name }}</span>
