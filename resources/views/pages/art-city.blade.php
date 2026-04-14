{{-- resources/views/art-city.blade.php --}}
@extends('layouts.app')
@section('title', 'Арт Сити - Еволуција на Сонот')

@section('content')

<!-- HERO TOPO -->
<section class="relative bg-white overflow-visible">

	<div class="absolute inset-0 max-w-7xl mx-auto w-full px-6 pointer-events-none z-50">

		<div x-data class="dandelion-wrap pointer-events-none ">
			@include('partials.svg.dandelion')
		</div>

	</div>

	<div class="max-w-7xl mx-auto lg:px-6">

		<div class="relative h-[calc(100dvh-89px)] lg:h-[calc(100dvh-85px)] flex items-center bg-[#5B89A3] overflow-hidden">

			<!-- Background Image -->
			<div class="absolute inset-0 z-0">
				<img
					src="{{ asset('storage/images/art-city-hero.png') }}"
					loading="lazy"
					alt="Art City Topo Background"
					class="w-full h-full object-cover">
			</div>

			<!-- Content -->
			<div class="relative z-10 w-full px-6 md:px-16">
				<div class="max-w-4xl">
					<h1 class="text-5xl font-semibold uppercase text-white mb-5">
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

<!-- НАШАТА ВИЗИЈА -->
<section class="py-20 bg-cream">
	<div class="max-w-4xl mx-auto px-6 text-center">
		<h2 class="text-lg font-bold uppercase text-ev-dark mb-6">
			Нашата визија
		</h2>
		<p class="text-base leading-relaxed">
			Еволуција на сонот 4 е уметнички и културен фестивал замислен да се одвива во срцето на централна Македонија, Кавадарци како природна точка на поврзување помеѓу локалната заедница и меѓународната културна сцена. Преку современи уметнички форми, интердисциплинарни програми и меѓународни соработки, фестивалот има за цел да поттикне културен дијалог и да придонесе кон развојот на културниот туризам во, фестивалот создава простор за културна размена и современо уметничко изразување.
		</p>
	</div>
</section>

{{-- ПРОГРАМА --}}
<section class="relative py-10 bg-white overflow-visible">

	{{-- Clouds --}}
	<div class="hidden lg:block absolute -left-5 bottom-0 translate-y-1/2
                w-[60%] pointer-events-none z-20">
		@include('partials.svg.cloudsleft')
	</div>

	{{-- Програма content --}}
	<div class="relative z-30 max-w-7xl mx-auto px-6">
		<div class="relative max-w-5xl mx-auto min-h-112.5 flex flex-col items-center
                    justify-center bg-ev-blue-light rounded-[40px] px-8 py-6
                    lg:bg-transparent lg:rounded-none lg:px-0 lg:py-6">

			<h2 class="relative z-10 text-xl font-bold uppercase text-center text-ev-dark mb-8 lg:mb-10">
				Програма
			</h2>

			<div class="absolute inset-0 z-0 hidden lg:flex lg:items-center lg:justify-center">
				<img src="{{ asset('storage/images/program-sub.svg') }}"
					alt="" class="w-full h-full object-contain">
			</div>

			<div class="relative z-10 w-full grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-12">
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
					<h3 class="font-black text-ev-blue text-xl mb-2">{{ $day['name'] }}</h3>
					<p class="text-ev-dark text-xs md:text-sm leading-relaxed mb-2">
						Lorem Ipsum has been the industry's standard dummy
					</p>
					<p class="font-black text-ev-blue text-lg mb-2">{{ $day['time'] }}</p>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</section>


<!-- МАПА -->
<section class="relative py-20 bg-cream overflow-visible">

	{{-- Droplet --}}
	<div class="hidden lg:block absolute right-0 bottom-0 translate-y-1/2
                w-[25%] pointer-events-none z-20">
		@include('partials.svg.droplet')
	</div>

	{{-- Мапа content --}}
	<div class="relative z-30 max-w-7xl mx-auto px-6">
		<h2 class="text-lg font-bold uppercase text-center text-ev-dark mb-8">
			Мапа
		</h2>

		<div class="relative rounded-xl overflow-hidden shadow-lg">
			<div class="absolute top-4 right-4 bg-white/90 px-3 py-2 rounded-lg
                        font-bold text-sm text-right leading-snug z-10">
				Кавадарци<br>5-15 Август
			</div>
			<iframe
				src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d46982.76!2d22.0069!3d41.4330!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x135757e7e2323f5d%3A0x400dc5ad8f7a6b0!2sKavadarci%2C%20North%20Macedonia!5e0!3m2!1sen!2smk!4v1620000000000"
				width="100%" height="450"
				style="border:0; display:block;"
				allowfullscreen loading="lazy"
				referrerpolicy="no-referrer-when-downgrade"
				title="Кавадарци карта">
			</iframe>
		</div>
	</div>

</section>


<!-- УМЕТНИЦИ -->
<section class="relative py-20 bg-cream overflow-visible">

	{{-- Уметници content --}}
	<div class="relative z-30 max-w-7xl mx-auto px-6">
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
					<div class="group relative rounded-3xl overflow-hidden
                        w-60 md:w-70 aspect-[1/1.3] cursor-pointer">
						<img src="{{ asset('storage/images/' . $artist['img']) }}"
							class="w-full h-full object-cover transition-transform
                      duration-500 ease-out group-hover:scale-110">
						<div class="absolute inset-0 bg-linear-to-t from-black/20
                          to-transparent opacity-0 group-hover:opacity-100
                          transition-opacity duration-500">
						</div>
						<div class="absolute inset-0 flex items-end justify-center pb-4">
							<span class="block w-[80%] text-center bg-white text-ev-dark
                  font-bold text-[14px] leading-4.5 uppercase
                  py-3 rounded-lg shadow-lg transition-transform
                  duration-500 group-hover:-translate-y-1 whitespace-normal">
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



<!-- ШТО МОЖЕШ ДА ОЧЕКУВАШ -->
<section class="pt-20 pb-40 bg-cream relative">
	<div class="max-w-7xl mx-auto px-6 overflow-visible">
		<h2 class="text-lg font-bold uppercase text-center text-ev-dark mb-10">
			Што можеш да очекуваш
		</h2>

		<div class="grid grid-cols-2 md:flex md:items-center md:w-full lg:flex lg:items-center lg:w-full gap-3">

			@for($i = 1; $i <= 5; $i++)
				<div
				class="
            rounded-xl overflow-hidden relative 

            {{ $i === 3 ? 'col-span-2 md:col-span-2' : '' }}

            lg:h-95
						md:h-55
						
            lg:flex-1
						md:flex-1

            {{ $i === 3 ? 'lg:flex-[1.5] lg:z-20 md:flex-[1.5] md:z-20' : '' }}

            <!-- LEFT OVERLAP -->
            {{ $i === 2 ? 'lg:-ml-12 md:-ml-8' : '' }}

            <!-- RIGHT OVERLAP -->
            {{ $i === 4 ? 'lg:-mr-12 md:-mr-8' : '' }}
        ">
				<img
					src="{{ asset('storage/images/art-city-' . $i . '.png') }}"
					class="w-full h-full object-contain">
		</div>

		@endfor

	</div>


	<div class="hidden lg:block absolute left-[11%] bottom-10 w-[15%] pointer-events-none z-0">
		@include('partials.svg.insta-blob-1')
	</div>

	<div class="hidden lg:block absolute left-[26%] bottom-0 w-[15%] pointer-events-none z-0">
		@include('partials.svg.insta-blob-2')
	</div>
</section>

@endsection