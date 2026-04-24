{{-- resources/views/blog.blade.php --}}
@extends('layouts.app')
@section('title', 'Повеќе за нас - Еволуција на Сонот')

@section('content')

{{-- LATEST NEWS HERO --}}
<section class="relative min-h-[calc(100vh-89px)]  py-6 bg-cream" x-data="eventSlider()">
  <div class="absolute inset-0 max-w-7xl mx-auto w-full px-6 pointer-events-none z-50">
    <div x-data class="dandelion-wrap pointer-events-none">
      @include('partials.svg.dandelion')
    </div>
  </div>

  <div class="relative z-10 max-w-7xl mx-auto px-6">
    <h2 class="text-lg lg:text-3xl font-semibold uppercase text-center text-ev-dark mb-16">
      Најнови новости
    </h2>

    {{-- Slider Wrapper --}}
    <div class="relative w-full h-112.5 md:h-137.5 lg:h-162.5 group">
      
      @php
      $news = [
        ['title' => 'Еволуција на Сонот - 1', 'location' => 'Скопје, Македонија', 'image' => 'storage/images/latest-news-1.svg'],
        ['title' => 'Еволуција на Сонот - 2', 'location' => 'Скопје, Македонија', 'image' => 'storage/images/latest-news-2.svg'],
        ['title' => 'Еволуција на Сонот - 3', 'location' => 'Скопје, Македонија', 'image' => 'storage/images/latest-news-3.svg'],
      ];
      @endphp

      {{-- Prev Button --}}
      <button @click="prev()" 
              class="absolute left-4 top-1/2 -translate-y-1/2 z-40 w-10 h-10 md:w-14 md:h-14 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white flex items-center justify-center hover:bg-ev-dark hover:text-white transition-all shadow-lg active:scale-95">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
      </button>

      {{-- Next Button --}}
      <button @click="next()" 
              class="absolute right-4 top-1/2 -translate-y-1/2 z-40 w-10 h-10 md:w-14 md:h-14 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white flex items-center justify-center hover:bg-ev-dark hover:text-white transition-all shadow-lg active:scale-95">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
      </button>

      @foreach($news as $index => $item)
      <div class="event-card absolute inset-0" :class="getCardClass({{ $index }})">
        <div class="relative rounded-3xl overflow-hidden shadow-lg h-full border border-gray-100">
          <img src="{{ asset($item['image']) }}" 
                alt="{{ $item['title'] }}"
                loading="lazy"
                class="w-full h-full object-cover">

          {{-- Info Overlay --}}
          <div class="absolute bottom-0 left-0 right-0 px-6 py-4 bg-white/80  uppercase">
            <h5 class="font-bold text-base text-ev-dark mb-1">{{ $item['title'] }}</h5>
            <small class="text-gray-600 text-xs flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="red">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
              </svg>
              {{ $item['location'] }}
            </small>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    {{-- Bottom Action Button --}}
    <div class="flex justify-start mt-6">
      <x-ui.button href="https://www.instagram.com/evolucija.na.sonot/" target="_blank" rel="noopener">
        Повеќе
      </x-ui.button>
    </div>
  </div>
</section>

{{-- PREVIOUS EDITIONS --}}
<section class="py-10 lg:py-20 bg-cream relative">

  {{-- Clouds --}}
  <div class="hidden lg:block absolute left-0 -top-35 w-[70%] pointer-events-none z-0">
    @include('partials.svg.cloudsleft1')
  </div>

  <div class="max-w-6xl mx-auto px-6 relative z-10">
    <h2 class="text-center text-lg lg:text-3xl font-bold uppercase tracking-wide text-ev-dark mb-12">
      Погледни што се случуваше изминатите години
    </h2>

    @php
      $editions = [
          [
              'id' => 3, 
              'img' => 'edition-3.webp', 
              'rev' => false,
              'paragraphs' => [
                  'Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam velit voluptatum, iste facere laborum assumenda sed nihil sit unde natus, minus illum recusandae mollitia quam voluptatibus deleniti doloribus consequuntur corrupti. Doloribus pariatur exercitationem ullam, suscipit iure velit repellat officiis repudiandae natus aperiam facilis quibusdam quos. Repudiandae deserunt labore, repellendus molestiae est facere!',
                  'Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam velit voluptatum, iste facere laborum assumenda sed nihil sit unde natus, minus illum recusandae mollitia quam voluptatibus deleniti doloribus consequuntur corrupti. Doloribus pariatur exercitationem ullam, suscipit iure velit repellat officiis repudiandae natus aperiam facilis quibusdam quos. Repudiandae deserunt labore, repellendus molestiae est facere!',
              ]
          ],
          [
              'id' => 2, 
              'img' => 'edition-2.webp', 
              'rev' => true,
              'paragraphs' => [
                    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam velit voluptatum, iste facere laborum assumenda sed nihil sit unde natus, minus illum recusandae mollitia quam voluptatibus deleniti doloribus consequuntur corrupti. Doloribus pariatur exercitationem ullam, suscipit iure velit repellat officiis repudiandae natus aperiam facilis quibusdam quos. Repudiandae deserunt labore, repellendus molestiae est facere!',
                    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam velit voluptatum, iste facere laborum assumenda sed nihil sit unde natus, minus illum recusandae mollitia quam voluptatibus deleniti doloribus consequuntur corrupti. Doloribus pariatur exercitationem ullam, suscipit iure velit repellat officiis repudiandae natus aperiam facilis quibusdam quos. Repudiandae deserunt labore, repellendus molestiae est facere!',
              ]
          ],
          [
              'id' => 1, 
              'img' => 'edition-1.webp', 
              'rev' => false,
              'paragraphs' => [
                  'Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam velit voluptatum, iste facere laborum assumenda sed nihil sit unde natus, minus illum recusandae mollitia quam voluptatibus deleniti doloribus consequuntur corrupti. Doloribus pariatur exercitationem ullam, suscipit iure velit repellat officiis repudiandae natus aperiam facilis quibusdam quos. Repudiandae deserunt labore, repellendus molestiae est facere!',
                  'Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam velit voluptatum, iste facere laborum assumenda sed nihil sit unde natus, minus illum recusandae mollitia quam voluptatibus deleniti doloribus consequuntur corrupti. Doloribus pariatur exercitationem ullam, suscipit iure velit repellat officiis repudiandae natus aperiam facilis quibusdam quos. Repudiandae deserunt labore, repellendus molestiae est facere!',
              ]
          ],
      ];
    @endphp

    @foreach($editions as $edition)
      <div class="flex flex-col {{ $edition['rev'] ? 'md:flex-row-reverse' : 'md:flex-row' }} items-stretch rounded-3xl bg-white mb-10 overflow-hidden shadow-xl border border-gray-200">

        {{-- Image Side --}}
        <div class="w-full lg:w-[40%] md:w-[45%] shrink-0">
          <img src="{{ asset('storage/images/' . $edition['img']) }}"
            alt="Еволуција на Сонот {{ $edition['id'] }}"
            loading="lazy"
            decoding="async"
            class="w-full h-full object-cover">
        </div>

        {{-- Content Side --}}
        <div class="flex-1 p-8 md:p-12 flex flex-col justify-center">
          <h3 class="font-semibold text-2xl uppercase mb-6">
            Еволуција на Сонот {{ $edition['id'] }}
          </h3>
          
          <div class="space-y-8">
            @foreach($edition['paragraphs'] as $text)
              <p>{{ $text }}</p>
            @endforeach
          </div>

          <div class="mt-8">
            <x-ui.button href="https://www.instagram.com/evolucija.na.sonot/" target="_blank" rel="noopener">
              Повеќе →
            </x-ui.button>
          </div>
        </div>

      </div>
    @endforeach

  </div>
</section>

{{-- CTA --}}
<section class="py-40 bg-cream text-center relative">

	{{-- Clouds --}}
	<div class="hidden lg:block absolute right-0 -top-60 w-[35%] pointer-events-none z-0">
		@include('partials.svg.clouds-blog')
	</div>

	<div class="max-w-7xl mx-auto px-6 relative z-10">
		<h2 class="text-xl md:text-3xl font-bold uppercase mb-6">
			Сакаш да бидеш дел од нашиот колектив?
		</h2>
		{{-- Bottom CTA Button --}}
		<x-ui.button href="{{ route('work-with-us') }}">
			Пријави се
		</x-ui.button>
	</div>

	{{-- Leaf --}}
	<div class="absolute inset-0 overflow-hidden pointer-events-none">
		<div class="hidden lg:block absolute -left-75 -bottom-45 w-[45%] z-0">
			@include('partials.svg.leaf-blog')
		</div>
	</div>

</section>

@endsection