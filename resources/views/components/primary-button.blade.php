<button {{ $attributes->merge(['type' => 'submit', 'class' => 
'inline-flex items-center px-4 py-2 bg-blue-800 dark:bg-gray-800 
border border-transparent rounded-md font-semibold text-xs text-white dark:text-white
uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 
dark:focus:bg-gray-900 dark:focus:text-gray-900 dark:hover:text-gray-900 active:bg-gray-900 
dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
