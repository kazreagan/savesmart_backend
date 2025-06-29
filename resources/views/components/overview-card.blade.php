<div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-[#8CB240]">
    <div class="flex justify-between items-center">
        <h3 class="text-gray-600 text-sm font-medium">{{ $title }}</h3>
        @if($icon)
            <span class="text-[#8CB240]">
                <i class="fas fa-{{ $icon }}"></i>
            </span>
        @endif
    </div>
    <div class="mt-2">
        <p class="text-2xl font-semibold text-gray-800">${{ number_format($amount, 2) }}</p>
        @if($trend)
            <p class="text-sm {{ $trend > 0 ? 'text-[#8CB240]' : 'text-red-500' }}">
                {{ $trend > 0 ? '+' : '' }}{{ $trend }}% from last month
            </p>
        @endif
    </div>
</div>