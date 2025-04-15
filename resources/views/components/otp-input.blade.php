@props(['name' => 'otp', 'placeholder' => 'Enter 6-digit OTP', 'digits' => 6])

<div class="space-y-4">
    <!-- Hidden input to store the combined OTP value -->
    <input type="hidden" name="{{ $name }}" id="otp-hidden" {{ $attributes->whereStartsWith('wire:model') }}>

    <!-- Individual digit inputs -->
    <div class="flex justify-center gap-2">
        @for ($i = 0; $i < $digits; $i++)
            <input
                type="text"
                maxlength="1"
                inputmode="numeric"
                pattern="[0-9]*"
                class="otp-input w-12 h-12 text-center text-xl border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                required
                {{ $i === 0 ? 'autofocus' : '' }}
            >
        @endfor
    </div>
</div>
