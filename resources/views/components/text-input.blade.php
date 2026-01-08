@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-gray-900 dark:focus:border-gray-400 focus:ring-1 focus:ring-gray-900 dark:focus:ring-gray-400 rounded-lg font-light transition duration-200']) }}>
