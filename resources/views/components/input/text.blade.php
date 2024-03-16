@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'p-1 border border-gray-300 shadow bg-white rounded focus:outline-none focus:border-blue-400 focus:border-2 focus:ring-0 block w-full disabled:text-black  disabled:shadow-none disabled:font-bold disabled:cursor-pointer']) !!} />

