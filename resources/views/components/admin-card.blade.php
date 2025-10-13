<a href=" {{ $url }} " class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition-transform duration-200">
    <svg class="w-14 h-14 text-red-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-width="2" d="{{ $svg }}"/>
    </svg>
    <h2 class="text-xl dark:text-white font-semibold mb-2">{{ $title }}</h2>
    <p class="text-gray-600 dark:text-gray-300 text-center">{{ $description }}</p>
</a>