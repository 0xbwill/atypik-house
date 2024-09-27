@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-noir']) }}>
    {{ $value ?? $slot }}
</label>
