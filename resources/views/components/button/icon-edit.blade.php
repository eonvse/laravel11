@props(['size'=>6])
<a {{ $attributes }}><span class="text-gray-400 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-green-600 hover:cursor-pointer">
    <svg class="h-{{ $size }} w-{{ $size }}"  fill="none" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor">
        <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" />  <line x1="13.5" y1="6.5" x2="17.5" y2="10.5" />
    </svg>
</span></a>

