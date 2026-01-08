<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-2.5 bg-gray-900 dark:bg-white border border-gray-900 dark:border-white rounded-lg font-light text-sm text-white dark:text-gray-900 tracking-wide hover:bg-gray-800 dark:hover:bg-gray-100 focus:bg-gray-800 dark:focus:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:ring-offset-2 transition duration-200']) }}>
    {{ $slot }}
</button>
