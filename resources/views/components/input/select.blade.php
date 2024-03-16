@props(['items','disabled'=>false,  'none'=>true, 'noneTxt'=>'Без категории'])

@if ($items)
<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'p-1 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:border-blue-400 focus:border-2 focus:ring-0 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full disabled:text-black disabled:border-none disabled:shadow-none disabled:font-bold disabled:cursor-pointer']) !!} >
  <option value="">{{ $noneTxt }}</option>
  @foreach ((array) $items as $item)
  <option value="{{$item['id'] ?? '' }}">{{ $item['name'] ?? '' }}</option>
  @endforeach
</select>
@endif
