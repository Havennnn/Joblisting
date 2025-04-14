@extends('layouts.app')

@section('title', 'NextJob')

@section('content')
<!-- Main Banner Carousel -->
@if($featured->count() > 0)
<div class="relative mt-8 w-[90%] mx-auto h-[500px] overflow-hidden rounded-xl shadow-lg">
    <div class="flex transition-transform duration-500 h-full" id="carousel-inner">
        @foreach ($featured as $index => $item)
            <div class="min-w-full h-full relative {{ $loop->first ? 'active' : '' }}">
                <img src="{{ asset($item->imagePath) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent"></div>

                <!-- Text Overlay -->
                <div class="absolute left-24 top-1/2 transform -translate-y-1/2 max-w-2xl">
                    <div class="flex flex-col space-y-4">
                        @if(isset($item->title))
                            <h1 class="text-5xl font-bold text-white leading-tight">
                                {{ $item->title }}
                            </h1>
                        @endif

                        @if(isset($item->subtitle))
                            <h2 class="text-3xl font-semibold text-white/90">
                                {{ $item->subtitle }}
                            </h2>
                        @endif
                    </div>

                    @if($item->button_text)
                        <a href="{{ $item->button_link }}" class="mt-8 inline-block px-8 py-4 bg-white text-gray-900 rounded-full text-lg font-semibold hover:bg-red-600 hover:text-white transition-all duration-300 transform hover:scale-105 shadow-lg">
                            {{ $item->button_text }}
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Carousel Navigation -->
    <button class="absolute top-1/2 left-5 transform -translate-y-1/2 z-10 text-white hover:text-red-500 transition-colors bg-black/30 p-2 rounded-full" id="prev">
        <i class="fas fa-chevron-left text-3xl"></i>
    </button>
    <button class="absolute top-1/2 right-5 transform -translate-y-1/2 z-10 text-white hover:text-red-500 transition-colors bg-black/30 p-2 rounded-full" id="next">
        <i class="fas fa-chevron-right text-3xl"></i>
    </button>
</div>

<!-- Carousel Dots -->
<div class="flex justify-center gap-3 mt-6" id="carousel-dots">
    @foreach ($featured as $index => $item)
        <span class="w-3 h-3 rounded-full bg-gray-300 cursor-pointer hover:bg-gray-700 transition-colors {{ $loop->first ? 'bg-gray-700' : '' }}" data-index="{{ $index }}"></span>
    @endforeach
</div>
@endif

<!-- Events Section -->
<div class="px-4 md:px-16 py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900">JOB EVENTS FOR YOU</h1>
            <a href="/interview" class="text-red-600 hover:text-red-700 font-semibold flex items-center gap-2">
                See More
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($events as $event)
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                    <div class="relative">
                        <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                        @if($event->is_promoted)
                            <span class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full">
                                Promoted
                            </span>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-gray-900">{{ $event->title }}</h3>
                        <div class="space-y-2 mb-4">
                            <p class="text-sm text-gray-600 flex items-center gap-2">
                                <i class="far fa-calendar text-red-600"></i>
                                {{ \Carbon\Carbon::parse($event->date)->format('D, M d') }}
                            </p>
                            <p class="text-sm text-gray-600 flex items-center gap-2">
                                <i class="far fa-clock text-red-600"></i>
                                {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }} GMT+8
                            </p>
                            <p class="text-sm text-gray-600 flex items-center gap-2">
                                <i class="far fa-building text-red-600"></i>
                                {{ $event->company }}
                            </p>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-lg font-semibold text-red-600">
                                @if($event->price === 'Free')
                                    Free
                                @else
                                    Php {{ number_format($event->price, 2) }}
                                @endif
                            </p>
                            <p class="text-sm text-gray-600 flex items-center gap-1">
                                <i class="fas fa-user text-gray-400"></i>
                                {{ $event->followers }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-white rounded-xl shadow-sm">
            <i class="fas fa-calendar-times text-5xl text-gray-300 mb-4"></i>
            <p class="text-gray-600 text-lg">No upcoming events at the moment. Please check back later.</p>
        </div>
        @endif
    </div>
</div>

<!-- Jobs Section -->
<div class="px-4 md:px-16 py-16 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold mb-4">Find your <span class="text-red-600">Neksjob</span></h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Explore exciting job openings and take the next step in your career journey.</p>
        </div>

        @if($jobs->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            @foreach ($jobs as $job)
                <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="text-red-600 text-3xl mb-6">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-900">{{ $job->title }}</h3>
                        <div class="space-y-2">
                            <p class="text-gray-600 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                                {{ $job->location }}
                            </p>
                            <p class="text-gray-600 flex items-center gap-2">
                                <i class="fas fa-money-bill-wave text-gray-400"></i>
                                PHP {{ number_format($job->min_salary, 0) }} - PHP {{ number_format($job->max_salary, 0) }}
                            </p>
                            <p class="text-gray-600 flex items-center gap-2">
                                <i class="fas fa-briefcase text-gray-400"></i>
                                {{ $job->work_experience_level }} Experience
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="/jobs" class="inline-block px-8 py-4 border-2 border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white transition-colors font-semibold rounded-lg">
                See More Jobs
            </a>
        </div>
        @else
        <div class="text-center py-12 bg-gray-50 rounded-xl">
            <i class="fas fa-briefcase text-5xl text-gray-300 mb-4"></i>
            <p class="text-gray-600 text-lg">No job listings available at the moment. Please check back later.</p>
        </div>
        @endif
    </div>
</div>

<!-- Blogs Section -->
<div class="px-4 md:px-16 py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold mb-4 text-red-600">Latest Blog Posts</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Stay updated with the latest career advice and industry insights.</p>
        </div>

        @if($blogs->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($blogs as $blog)
            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-full h-56 object-cover">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-3 text-gray-900">{{ $blog->title }}</h2>
                    <p class="text-gray-600 mb-6 line-clamp-3">{{ $blog->description }}</p>
                    <a href="#" class="inline-flex items-center text-red-600 hover:text-red-700 font-semibold">
                        Read More
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-white rounded-xl shadow-sm">
            <i class="fas fa-newspaper text-5xl text-gray-300 mb-4"></i>
            <p class="text-gray-600 text-lg">No blog posts available at the moment. Please check back later.</p>
        </div>
        @endif
    </div>
</div>

@if($featured->count() > 0)
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const carouselInner = document.getElementById("carousel-inner");
        const items = carouselInner.children;
        const totalItems = items.length;
        let currentIndex = 0;
        let autoplayInterval;
        const dots = document.querySelectorAll("#carousel-dots span");

        function moveSlide(direction) {
            currentIndex = (currentIndex + direction + totalItems) % totalItems;
            carouselInner.style.transform = `translateX(-${currentIndex * 100}%)`;
            updateDots();
        }

        function updateDots() {
            dots.forEach(dot => dot.classList.remove("bg-gray-700"));
            dots.forEach(dot => dot.classList.add("bg-gray-300"));
            dots[currentIndex].classList.remove("bg-gray-300");
            dots[currentIndex].classList.add("bg-gray-700");
        }

        function startAutoplay() {
            autoplayInterval = setInterval(() => moveSlide(1), 5000);
        }

        function stopAutoplay() {
            clearInterval(autoplayInterval);
        }

        document.getElementById("next").addEventListener("click", () => {
            moveSlide(1);
            stopAutoplay();
            startAutoplay();
        });

        document.getElementById("prev").addEventListener("click", () => {
            moveSlide(-1);
            stopAutoplay();
            startAutoplay();
        });

        dots.forEach(dot => {
            dot.addEventListener("click", (event) => {
                currentIndex = parseInt(event.target.getAttribute("data-index"));
                carouselInner.style.transform = `translateX(-${currentIndex * 100}%)`;
                updateDots();
                stopAutoplay();
                startAutoplay();
            });
        });

        // Start autoplay
        startAutoplay();

        // Pause autoplay on hover
        carouselInner.addEventListener("mouseenter", stopAutoplay);
        carouselInner.addEventListener("mouseleave", startAutoplay);
    });
</script>
@endif

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection
