@props([
    'activeTextColor' => 'text-nextjob-blue',
    'defaultTextColor' => 'text-nextjob-black',
    'hoverState' => 'hover:text-nextjob-blue',
    'activeFontWeight' => 'font-semibold',
    'defaultFontWeight' => 'font-light',
    'transitionDuration' => 'duration-300',
    'activeClasses' => 'scale-105'
])

<div class="flex items-start space-x-12 ml-4">
    <a href="/" class="relative group transition-all {{ $transitionDuration }} ease-in-out">
        <span class="{{ request()->is('/') ? $activeTextColor.' '.$activeFontWeight.' '.$activeClasses : $defaultTextColor.' '.$defaultFontWeight }} {{ $hoverState }} text-md transition-all {{ $transitionDuration }} ease-in-out transform inline-block">
            Home
        </span>
        @if(request()->is('/'))
            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-nextjob-blue transition-all {{ $transitionDuration }}"></span>
        @else
            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-nextjob-blue group-hover:w-full transition-all {{ $transitionDuration }} ease-in-out"></span>
        @endif
    </a>
    <a href="{{ route('jobs.index') }}" class="relative group transition-all {{ $transitionDuration }} ease-in-out">
        <span class="{{ request()->routeIs('jobs.index') ? $activeTextColor.' '.$activeFontWeight.' '.$activeClasses : $defaultTextColor.' '.$defaultFontWeight }} {{ $hoverState }} text-md transition-all {{ $transitionDuration }} ease-in-out transform inline-block">
            Find jobs
        </span>
        @if(request()->routeIs('jobs.index'))
            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-nextjob-blue transition-all {{ $transitionDuration }}"></span>
        @else
            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-nextjob-blue group-hover:w-full transition-all {{ $transitionDuration }} ease-in-out"></span>
        @endif
    </a>

    {{ $slot ?? '' }}
</div>
