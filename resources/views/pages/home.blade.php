{{-- resources/views/home.blade.php --}}
@extends('layouts.app')
@section('title', 'Дома - Еволуција на Сонот')

@section('content')

{{-- -- HERO -- --}}
<section class="relative lg:h-[calc(100dvh-85px)] flex items-center overflow-visible bg-cream">

	<div class="absolute inset-0 max-w-7xl mx-auto w-full px-6 pointer-events-none z-50">
		<div x-data class="dandelion-wrap pointer-events-none ">
			@include('partials.svg.dandelion')
		</div>
	</div>

	{{-- Hero Image --}}
	<div class="absolute inset-0 max-w-7xl mx-auto w-full lg:px-6 pointer-events-none flex">
		<div class="ml-auto w-full lg:w-[60%]">
			<img
				src="{{ asset('storage/images/hero-face.webp') }}"
				alt="hero"
				fetchpriority="high"
				decoding="async"
				class="w-full h-auto object-contain lg:object-top-right">
		</div>
	</div>



	{{-- Content Container --}}
	<div class="relative z-10 max-w-7xl mx-auto w-full px-6 py-20">

		<div class="relative w-full  flex flex-col lg:bg-transparent lg:p-2 pt-12 md:pt-16 px-6 pb-10 xs:mt-48 md:mt-100 lg:mt-0">

			<div class="absolute inset-0 lg:hidden -z-10 mx-0 px-0">
				<img src="{{ asset('storage/images/bg-mobile-home-white.svg') }}"
					class="w-full h-full object-fill"
					alt="">
			</div>

			{{-- 2. Tablet SVG Background (Visible ONLY on 768px up to 1023px) --}}
			<div class="absolute inset-0 hidden md:block lg:hidden -z-10">
				@include('partials.svg.ipad-bg')
			</div>

			{{-- Text content --}}
			<p class="hidden md:block uppercase font-bold text-ev-dark mb-4">
				Редефинирај ја реалноста
			</p>

			<h1 class="text-2xl md:text-5xl lg:text-6xl font-bold uppercase text-ev-dark mb-6 leading-tight">
				Еволуција на Сонот
			</h1>

			<p class="lg:text-base text-sm text-ev-dark max-w-115 mb-8">
				Ако сакаш да бидеш дел и ти, приклучи се кон заедницата
				што создава, соработува и ја обликува современата
				културна сцена.
			</p>

			<div class="w-fit lg:hidden">
				<x-ui.button href="{{ route('work-with-us') }}">
					Пријави се
				</x-ui.button>
			</div>
		</div>
	</div>
</section>

{{-- -- ЗА НАС -- --}}
<section class="relative py-10 bg-cream"> {{-- Removed overflow-hidden so the blob can bleed upward --}}

	<div class="hidden lg:block absolute left-0 -top-20 w-[35%] pointer-events-none z-0">
		@include('partials.svg.blueblob')
	</div>

	<div class="relative z-10 max-w-7xl mx-auto px-6">
		<div class="flex">
			<div class="ml-auto w-full lg:w-[60%]">

				<h2 class="text-2xl font-semibold mb-6 uppercase text-ev-dark">
					ЗА НАС
				</h2>

				<p class="lg:text-base xs:text-sm text-ev-dark">
					Еволуција на сонот е независна културна организација посветена на развојот на современата уметност и креативните практики во јавен простор. Преку интердисциплинарни проекти, фестивали и меѓународни соработки, организацијата создава платформа за културна размена, уметничко изразување и одржлив културен развој, со фокус на локалната заедница и нејзиното поврзување со глобалната уметничка сцена.
				</p>

			</div>
		</div>
	</div>
</section>

{{-- VIDEO SECTION via alpine.js --}}
@php
    $videoBg = asset('storage/images/video-bg.svg');
    
    // SWITCHING LOGIC: 
    // To use YouTube: set type to 'youtube' and use the /embed/ link.
    // To use Local: set type to 'local' and use the asset() link.
    
    $videoType = 'youtube'; // Change to 'youtube' to switch
    // $videoUrl = asset('storage/video/video.mp4'); 
    
    
    $videoUrl = 'https://www.youtube.com/embed/oQbgZ8DcG8U?si=Li9ZAfhJoQgD6hQO';
@endphp

<div class="relative z-10 max-w-7xl mx-auto px-6 py-6" x-data="{ playing: false }">
    
    {{-- Main Placeholder Card --}}
    <div class="relative rounded-lg overflow-hidden min-h-125 flex flex-col items-center justify-center bg-[#33322f] shadow-xl">
        
        {{-- LAYER 1: The Poster/Placeholder (Visible by default) --}}
        <div x-show="!playing" 
              class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-cover bg-center transition-opacity duration-500"
              style="background-image: url('{{ $videoBg }}');">
            
            {{-- Play Button --}}
            <button @click="playing = true"
                    class="relative z-30 w-24 h-24 md:w-37.5 md:h-37.5 rounded-full border-[3px] border-white/80 bg-white/15 flex items-center justify-center py-8 hover:scale-110 hover:bg-white/25 transition-all duration-300 group">
                <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 24 24" fill="white">
                    <path d="M8 5v14l11-7z" />
                </svg>
            </button>

            {{-- Project Titles --}}
            {{-- <div class="relative z-10 text-center mt-4">
                <h2 class="text-2xl md:text-5xl lg:text-5xl font-black uppercase tracking-widest text-white">
                    Еволуција на Сонот
                </h2>
                <p class="text-white font-black uppercase tracking-widest text-xl md:text-2xl">Ден 2</p>
            </div> --}}

            {{-- Overlay Gradient --}}
            <div class="absolute inset-0 bg-black/20 pointer-events-none"></div>
        </div>

        {{-- LAYER 2: The Player (Injected only when 'playing' is true) --}}
        <template x-if="playing">
            <div class="absolute inset-0 z-10 w-full h-full bg-black">
                @if($videoType === 'youtube')
                    <iframe class="w-full h-full"
                            src="{{ $videoUrl }}?autoplay=1&rel=0"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                @else
                    <video controls autoplay class="w-full h-full object-cover">
                        <source src="{{ $videoUrl }}" type="video/mp4">
                        Вашиот прелистувач не поддржува видео.
                    </video>
                @endif
            </div>
        </template>

        {{-- Close/Stop Button --}}
        <button x-show="playing" 
                @click="playing = false" 
                class="absolute top-6 right-6 z-40 bg-black/50 hover:bg-black/80 text-white p-2 rounded-full transition-all"
                title="Затвори видео">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

    </div>
</div>

{{-- ПРЕТХОДНИ НАСТАНИ --}}
<section class="relative py-20 bg-white" x-data="eventSlider()">

	{{--Clouds--}}
	<div class="hidden lg:block absolute right-0 -top-65 w-[35%] pointer-events-none z-0">
		@include('partials.svg.clouds')
	</div>

	<div class="relative z-10 max-w-7xl mx-auto px-6">

		<h2 class="text-lg font-bold uppercase text-center text-ev-dark mb-20">
			Претходни настани
		</h2>

		{{-- Slider Wrapper: height must be set to prevent layout collapse --}}
		<div class="relative w-full h-87.5 md:h-137.5 lg:h-162.5">
			@php
			// Example data array
			$events = [
			['title' => 'Еволуција на Сонот - 1', 'location' => 'Скопје, Македонија', 'image' => 'storage/images/event-1.svg'],
			['title' => 'Еволуција на Сонот - 2', 'location' => 'Скопје, Македонија', 'image' => 'storage/images/event-2.svg'],
			['title' => 'Еволуција на Сонот - 3', 'location' => 'Скопје, Македонија', 'image' => 'storage/images/event-3.svg'],
			];
			@endphp

			@foreach($events as $index => $event)
			<div
				class="event-card absolute inset-0"
				:class="getCardClass({{ $index }})">
				<div class="relative rounded-3xl overflow-hidden shadow-lg h-full border border-gray-100">
					<img 
						src="{{ asset($event['image']) }}" 
						alt="{{ $event['title'] }}" 
						loading="lazy"
						decoding="async"
						class="w-full h-full object-cover">

					{{-- Info Overlay --}}
					<div class="absolute bottom-0 left-0 right-0 px-6 py-4 bg-white md:py-6 uppercase">
						<h5 class="font-bold text-base text-ev-dark mb-1">{{ $event['title'] }}</h5>
						<small class="text-gray-600 text-xs flex items-center gap-1">
							<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="red">
								<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
							</svg>
							{{ $event['location'] }}
						</small>
					</div>
				</div>
			</div>
			@endforeach
		</div>

		{{-- Navigation Controls --}}
		<div class="flex justify-between items-center mt-6">
			{{-- Previous Events Button --}}
			<x-ui.button href="https://www.instagram.com/evolucija.na.sonot/" target="_blank" rel="noopener">
				Повеќе
			</x-ui.button>

			<div class="flex gap-3">
				<button @click="prev()" class="w-12 h-12 rounded-full border border-black flex items-center justify-center hover:bg-black hover:text-white transition-all">
					<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
					</svg>
				</button>
				<button @click="next()" class="w-12 h-12 rounded-full border border-black flex items-center justify-center hover:bg-black hover:text-white transition-all">
					<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
					</svg>
				</button>
			</div>
		</div>
	</div>

</section>

{{-- ИНСТАГРАМ --}}
<section class="relative pt-20 pb-40 bg-cream overflow-hidden">

	{{-- Main Container --}}
	<div class="relative z-10 max-w-7xl mx-auto px-6">

		{{-- Header Content --}}
		<div class="flex flex-col md:flex-row items-center justify-center gap-6 text-center mb-12">
			<h2 class="text-lg font-bold uppercase text-ev-dark">
				Најнови објави од Инстаграм
			</h2>
			<x-ui.button href="https://www.instagram.com/evolucija.na.sonot/" target="_blank" rel="noopener">
				Заследи не
			</x-ui.button>
		</div>

		{{-- The Marquee Wrapper --}}
		<div class="relative flex overflow-hidden marquee-mask">
			@foreach([1, 2] as $loopCount)
			<div class="flex animate-marquee whitespace-nowrap pause-on-hover">
				@php
				$images = [1, 2, 3, 4];
				// We only shuffle once so both tracks match for a seamless loop
				@endphp

				@foreach($images as $i)
				<div class="inline-block pr-4">
					<div class="w-60 md:w-70 aspect-[1/1.3] rounded-3xl overflow-hidden shadow-sm">
						<a href="https://www.instagram.com/evolucija.na.sonot/" target="_blank" rel="noopener">
							<img 
								src="{{ asset('storage/images/insta-' . $i . '.svg') }}"
								alt="Instagram пост {{ $i }}"
								loading="lazy"
								decoding="async"
								class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
						</a>
					</div>
				</div>
				@endforeach
			</div>
			@endforeach
		</div>
	</div>

	{{-- SVGs (Blobs & Leaves) --}}
	{{-- Blob 1 --}}
	<div class="hidden lg:block absolute right-[40%] bottom-10 w-[15%] pointer-events-none z-0">
		@include('partials.svg.insta-blob-1')
	</div>
	{{-- Blob 2 --}}
	<div class="hidden lg:block absolute right-[25%] bottom-0 w-[15%] pointer-events-none z-0">
		@include('partials.svg.insta-blob-2')
	</div>
</section>

@endsection