<a href=" {{ $url }} " class="group bg-white dark:bg-stone-800 rounded-3xl shadow-warm hover:shadow-warm-lg p-8 flex flex-col items-center border border-stone-100 dark:border-stone-700 hover:-translate-y-1 transition duration-300">
    <div class="w-14 h-14 rounded-2xl bg-brand-100 dark:bg-brand-900/50 flex items-center justify-center text-brand-600 dark:text-brand-300">
        <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-width="2" d="{{ $svg }}"/>
        </svg>
    </div>
    <h2 class="mt-4 text-xl font-bold text-stone-900 dark:text-white mb-2 text-center">{{ $title }}</h2>
    <p class="text-stone-600 dark:text-stone-300 text-center">{{ $description }}</p>
</a>
