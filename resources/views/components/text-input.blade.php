@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#FF2121] focus:ring-[#FF2121] rounded-md shadow-sm']) }}>