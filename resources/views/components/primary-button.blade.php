<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center justify-center px-6 py-3 rounded-lg font-medium text-sm md:text-base text-white uppercase tracking-wide transition-all duration-200 ease-out shadow-md hover:shadow-lg focus:shadow-outline disabled:opacity-70 disabled:cursor-not-allowed',
    'style' => 'background: linear-gradient(to right, #4f46e5, #7c3aed);'
]) }}>
    <span class="flex items-center">
        @if(isset($icon))
            <span class="mr-2">{!! $icon !!}</span>
        @endif
        {{ $slot }}
    </span>
</button>