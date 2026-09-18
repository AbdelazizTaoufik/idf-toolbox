<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-brand-600 border border-transparent rounded-full font-semibold text-sm text-white hover:bg-brand-500 focus:bg-brand-500 active:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-400 focus:ring-offset-2 dark:focus:ring-offset-brand-950 shadow-warm transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
