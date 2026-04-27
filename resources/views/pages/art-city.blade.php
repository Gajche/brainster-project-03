@extends('layouts.app')
@section('title', 'Арт Сити - Еволуција на Сонот')

@section('content')

{{-- HERO TOPO --}}
<section class="relative bg-cream">
	
    {{-- Dandelion --}}
    <div class="absolute inset-0 max-w-7xl mx-auto w-full px-6 pointer-events-none z-100">
        <div x-data class="dandelion-wrap pointer-events-none">
            @include('partials.svg.dandelion')
        </div>
    </div>

    <div class="max-w-7xl mx-auto lg:px-6">
        <div class="relative min-h-[calc(50vh-89px)] lg:h-[calc(100vh-81px)] flex items-center overflow-hidden">
            {{-- Background Image --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('storage/images/art-city-hero.webp') }}" 
                      alt="Art City Topo Background" 
                      fetchpriority="high" 
                      decoding="async" 
                      class="w-full h-full object-cover">
            </div>

            {{-- CONTENT LAYER --}}
            <div class="relative z-20 w-full px-6 md:px-16">
                <div class="max-w-4xl">
                    <h1 class="text-2xl lg:text-5xl font-semibold uppercase text-white mb-5">
                        Еволуција на Сонот 4
                    </h1>
                    <p class="text-sm md:text-base font-semibold uppercase text-ev-dark">
                        5-15 АВГУСТ
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- НАШАТА ВИЗИЈА --}}
<section class="relative py-10 lg:py-20 bg-cream">
    <div class="relative z-20 max-w-4xl mx-auto px-6 text-start lg:text-center">
        <h2 class="text-3xl lg:text-lg font-bold uppercase text-ev-dark mb-6">
            Нашата визија
        </h2>
        <p class="text-base text-ev-dark">
            Еволуција на сонот 4 е уметнички и културен фестивал замислен да се одвива во срцето на централна Македонија, Кавадарци како природна точка на поврзување помеѓу локалната заедница и меѓународната културна сцена. Преку современи уметнички форми, интердисциплинарни програми и меѓународни соработки, фестивалот има за цел да поттикне културен дијалог и да придонесе кон развојот на културниот туризам во, фестивалот создава простор за културна размена и современо уметничко изразување.
        </p>
    </div>
</section>

{{-- ПРОГРАМА --}}
<section class="relative py-10 bg-cream">
    {{-- Clouds --}}
    <div class="hidden lg:block absolute -left-5 bottom-0 translate-y-1/2 w-[60%] pointer-events-none z-10">
        @include('partials.svg.cloudsleft')
    </div>

    {{-- Програма content --}}
    <div class="relative z-20 max-w-7xl mx-auto px-6">
        <div class="relative max-w-5xl mx-auto min-h-112.5 flex flex-col items-center justify-center bg-ev-blue-light rounded-[40px] px-8 py-6 lg:bg-transparent lg:rounded-none lg:px-0 lg:py-6">

            <h2 class="relative z-30 text-3xl md:text-xl font-bold uppercase text-center text-ev-dark mb-8 lg:mb-10">
                Програма
            </h2>

            {{-- Background SVG --}}
            <div class="absolute inset-0 z-0 hidden lg:flex lg:items-center lg:justify-center">
                <img src="{{ asset('storage/images/program-sub.svg') }}" alt="" class="w-full h-full object-contain">
            </div>

            <div class="relative z-30 w-full grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-12">
                @php
                $days = [
                    ['name' => 'СРЕДА', 'time' => '20.00h'],
                    ['name' => 'ЧЕТВРТОК', 'time' => '20.00h'],
                    ['name' => 'ПЕТОК', 'time' => '20.00h'],
                    ['name' => 'САБОТА', 'time' => '20.00h'],
                ];
                @endphp
                @foreach($days as $day)
                <div class="text-center px-4">
                    <h3 class="font-bold text-ev-blue text-xl md:text-xl mb-2">{{ $day['name'] }}</h3>
                    <p class="text-ev-dark text-base md:text-sm leading-relaxed mb-2">
                        Lorem Ipsum has been the industry's standard dummy
                    </p>
                    <p class="font-bold text-ev-blue text-lg mb-2">{{ $day['time'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- МАПА --}}
<x-map-section />

{{-- УМЕТНИЦИ --}}
<section class="relative py-20 bg-cream">
    <div class="relative z-20 max-w-7xl mx-auto px-6">
        <h2 class="text-lg font-bold uppercase text-center text-ev-dark mb-12">
            Запознај ги уметниците
        </h2>

        <div class="relative flex overflow-hidden">
            @foreach([1, 2] as $loopCount)
            <div class="flex animate-marquee whitespace-nowrap">
                @php
                $artists = [
                    ['name' => 'ЛЕНА ЈАРИЌ', 'img' => 'artist-1.png'],
                    ['name' => 'МИХАИЛ ПЕТРОВ', 'img' => 'artist-2.png'],
                    ['name' => 'АЛБА НОТО', 'img' => 'artist-3.png'],
                    ['name' => 'ЛЕОН КРИСТО', 'img' => 'artist-4.png'],
                ];
                @endphp
                @foreach($artists as $artist)
                <div class="inline-block px-2">
                    <div class="group relative rounded-3xl overflow-hidden w-60 md:w-70 aspect-[1/1.3] cursor-pointer">
                        <img src="{{ asset('storage/images/' . $artist['img']) }}" class="w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-linear-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="absolute inset-0 flex items-end justify-center pb-4">
                            <span class="block w-[80%] text-center bg-white text-ev-dark font-bold text-[14px] leading-4.5 uppercase py-3 rounded-lg shadow-lg transition-transform duration-500 group-hover:-translate-y-1 whitespace-normal">
                                {{ $artist['name'] }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ШТО МОЖЕШ ДА ОЧЕКУВАШ --}}
<section class="pt-20 pb-40 bg-cream relative">
    <div class="max-w-7xl mx-auto px-6 relative z-20">
        <h2 class="text-lg font-bold uppercase text-center text-ev-dark mb-10">
            Што можеш да очекуваш
        </h2>

        {{-- GRID LOGIC --}}
        <div class="grid grid-cols-2 md:flex md:items-center md:w-full lg:flex lg:items-center lg:w-full gap-y-3 lg:gap-0 md:gap-2">
            @for($i = 1; $i <= 5; $i++)
                <div class="rounded-xl overflow-hidden relative z-10 
									{{ $i === 3 ? 'col-span-2 md:col-span-2 lg:flex-[1.5] lg:z-20 md:flex-[1.5] flex-1 md:z-20' : 'lg:flex-1 md:flex-1' }} xl:h-96 lg:h-78 md:h-74 xs:h-100 

									{{ $i === 1 ? '-mr-5 lg:-mr-6' : '' }} 

									{{ $i === 2 ? '-ml-5 md:-ml-4' : '' }} 

									{{ $i === 4 ? '-mr-5 md:-mr-4' : '' }} 

									{{ $i === 5 ? '-ml-5 lg:-ml-6' : '' }}">

                    <img src="{{ asset('storage/images/art-city-' . $i . '.webp') }}" class="w-full h-full lg:object-contain">
                </div>
            @endfor
        </div>
    </div>

    {{-- Blobs --}}
    <div class="hidden lg:block absolute left-[11%] bottom-[2.8vw] w-[15%] pointer-events-none z-10">
        @include('partials.svg.insta-blob-1')
    </div>

    <div class="hidden lg:block absolute left-[26%] bottom-0 w-[15%] pointer-events-none z-10">
        @include('partials.svg.insta-blob-2')
    </div>
</section>

@endsection