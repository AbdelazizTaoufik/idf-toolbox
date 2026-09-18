@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-stone-700 dark:text-stone-300']) }}>
    {{ $value ?? $slot }}
</label>
