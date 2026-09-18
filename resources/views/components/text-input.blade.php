@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-stone-300 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-200 focus:border-brand-500 dark:focus:border-brand-500 focus:ring-brand-400 rounded-xl shadow-sm']) !!}>
