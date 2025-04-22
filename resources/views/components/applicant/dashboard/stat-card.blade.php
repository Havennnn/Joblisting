@props(['type', 'count', 'label', 'color'])

@php
    $iconClass = 'w-5 h-5 text-white';
    $icon = '';

    switch($type) {
        case 'candidates':
            $icon = '<path d="M7 8a3 3 0 100-6 3 3 0 000 6zM14.5 8a2.5 2.5 0 100-5 2.5 2.5 0 000 5zM1.615 11.321C.731 11.865.088 12.718.033 13.711c-.021.368-.011.755-.011 1.153 0 .128.099.236.228.236h7.5c.13 0 .228-.108.228-.236 0-.398.01-.785-.01-1.153a2.87 2.87 0 00-1.582-2.39C5.421 10.608 4.252 10 3 10c-.851 0-1.657.249-2.385.671zM14.5 10.5c-.803 0-1.587.189-2.354.53-.088.046-.177.094-.265.144a2.89 2.89 0 00-1.558 2.384c-.02.367-.01.753-.01 1.15 0 .13.099.241.228.241h7.5c.13 0 .228-.112.228-.24 0-.398.01-.784-.01-1.151-.05-.992-.694-1.845-1.577-2.39a5.095 5.095 0 00-2.182-.669z"></path>';
            break;
        case 'schedule':
            $icon = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>';
            break;
        case 'messages':
            $icon = '<path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>';
            break;
        default:
            $icon = '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>';
    }
@endphp

<div class="bg-white overflow-hidden shadow-sm">
    <div class="relative p-5">
        <div class="flex items-center">
            <div class="flex-1">
                <h2 class="text-4xl font-bold">{{ $count }}</h2>
                <p class="text-gray-600 mt-1 pr-12 text-sm">{{ $label }}</p>
            </div>
            <div class="{{ $color }} rounded-full p-3 ml-auto">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="{{ $iconClass }}">
                    {!! $icon !!}
                </svg>
            </div>
        </div>
        <a href="#" class="block text-sm text-{{ explode('-', $color)[1] }}-600 font-medium mt-4 flex items-center">
            <span>View Details</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 ml-1">
                <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
            </svg>
        </a>
    </div>
</div>
