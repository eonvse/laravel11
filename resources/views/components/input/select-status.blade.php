@props(['items','disabled'=>false,  'none'=>true, 'noneTxt'=>'Без категории'])

@if ($items)
<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'py-1 pl-1 pr-5 bg-right border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:border-blue-400 focus:border-1 focus:ring-0 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full disabled:text-black disabled:border-none disabled:shadow-none disabled:font-bold disabled:cursor-pointer']) !!} >
  @for ($i=0; $i<count($items); $i++)
  <option value="{{ $i }}">{{ $items[$i] }}</option>
  @endfor
</select>
@endif