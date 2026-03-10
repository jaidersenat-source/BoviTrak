<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-bovi-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-bovi-green-600 focus:bg-bovi-green-700 active:bg-bovi-green-900 focus:outline-none focus:ring-2 focus:ring-bovi-green-600 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
