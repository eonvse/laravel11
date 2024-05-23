@props(['items','disabled'=>false, 'selected'=>0,  'none'=>true, 'noneTxt'=>'Без категории'])

@if ($items)
<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'py-0 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 ']) !!} >
  @if (!$none)  
  <option value="">{{ $noneTxt }}</option>
  @endif
  @foreach ((array) $items as $item)
  <option value="{{$item ?? '' }}" {{ $item==$selected ? 'selected' : '' }}>{{ $item ?? '' }}</option>
  @endforeach
</select>
@endif
