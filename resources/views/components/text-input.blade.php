@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-bovi-green-600 focus:ring-bovi-green-600 rounded-md shadow-sm']) }}>
