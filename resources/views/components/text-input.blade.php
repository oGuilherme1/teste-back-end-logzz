@props(['disabled' => false])

<input 
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge([
        'class' => 'border-gray-300 dark:border-gray-700 dark:bg-off-white dark:text-gray-500 
                    focus:border-green-700 dark:focus:border-green-700 
                    focus:ring-2 focus:ring-green-700 dark:focus:ring-green-700 
                    rounded-md shadow-sm'
    ]) !!} 
/>