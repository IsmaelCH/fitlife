@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-light text-sm text-gray-700 dark:text-gray-300 mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>
