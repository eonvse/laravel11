@props(['size'=>6])
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center transition ease-in-out duration-150 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500']) }}>
<svg class="h-{{ $size }} w-{{ $size }}"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />  <line x1="9" y1="9" x2="15" y2="15" />  <line x1="15" y1="9" x2="9" y2="15" /></svg>  
</button>