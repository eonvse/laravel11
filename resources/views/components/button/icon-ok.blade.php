@props(['size'=>6])
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center transition ease-in-out duration-150 text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400']) }}>
<svg class="h-{{ $size }} w-{{ $size }}"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="9 11 12 14 22 4" />  <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" /></svg>    
</button>