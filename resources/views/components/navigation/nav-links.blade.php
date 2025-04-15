@props([
    'activeTextColor' => 'text-nextjob-blue',
    'defaultTextColor' => 'text-nextjob-black',
    'hoverState' => 'hover:text-nextjob-blue hover:scale-105',
    'activeFontWeight' => 'font-semibold',
    'defaultFontWeight' => 'font-light',
    'transitionDuration' => 'duration-500',
    'activeClasses' => 'scale-105'
])

<div class="flex items-start space-x-4">
    <a href="/" class="px-3 transition-all {{ $transitionDuration }} ease-in-out">
        <span class="{{ request()->is('/') ? $activeTextColor.' '.$activeFontWeight.' '.$activeClasses : $defaultTextColor.' '.$defaultFontWeight }} {{ $hoverState }} text-md transition-all {{ $transitionDuration }} ease-in-out transform inline-block">
            Home
            @if(request()->is('/'))
                <span class="block bg-nextjob-blue transition-all {{ $transitionDuration }}"></span>
            @endif
        </span>
    </a>
    <a href="{{ route('jobs.index') }}" class="px-3 transition-all {{ $transitionDuration }} ease-in-out">
        <span class="{{ request()->routeIs('jobs.index') ? $activeTextColor.' '.$activeFontWeight.' '.$activeClasses : $defaultTextColor.' '.$defaultFontWeight }} {{ $hoverState }} text-md transition-all {{ $transitionDuration }} ease-in-out transform inline-block">
            Find jobs
            @if(request()->routeIs('jobs.index'))
                <span class="block bg-nextjob-blue transition-all {{ $transitionDuration }}"></span>
            @endif
        </span>
    </a>

    {{ $slot ?? '' }}
</div>
