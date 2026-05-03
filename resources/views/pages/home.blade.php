@extends('layouts.app')
@section('title', 'Дома - Еволуција на Сонот')

@section('content')

{{-- HERO --}}
<section class="relative min-h-[calc(100vh-89px)] lg:min-h-[calc(100vh-81px)] qhd flex items-center bg-cream">

	{{-- Dandelion --}}
	<div class="absolute inset-0 max-w-7xl mx-auto w-full px-6 pointer-events-none z-100">
		<div x-data class="dandelion-wrap pointer-events-none ">
			@include('partials.svg.dandelion')
		</div>
	</div>

	{{-- Hero Image --}}
	<div class="absolute inset-0 max-w-7xl mx-auto w-full lg:px-6 pointer-events-none flex z-0">
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
	<div class="relative z-20 max-w-7xl mx-auto w-full px-6 py-20">

		<div class="relative w-full flex flex-col lg:bg-transparent lg:p-0 pt-8 md:pt-16 px-6 pb-0 xxs:mt-30 xs:mt-34 md:mt-100 lg:mt-0 lg:-translate-y-10">

			{{-- Tablet SVG Background --}}
			<div class="absolute inset-0 hidden md:block xs:block lg:hidden -z-10 mx-0 px-0">
				@include('partials.svg.ipad-bg')
			</div>

			{{-- Text content --}}
			<p class="hidden lg:block uppercase text-lg font-bold text-ev-dark mb-4">
				Редефинирај ја реалноста
			</p>

			<h1 class="text-2xl md:text-5xl lg:text-6xl font-bold uppercase text-ev-dark mb-6">
				Еволуција на Сонот
			</h1>

			<p class="lg:text-base md:text-base xs:text-md xxs:text-sm text-ev-dark max-w-115 mb-8">
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

{{-- ЗА НАС --}}
<section class="relative py-10 bg-cream">

	{{-- Layered Decorative SVG --}}
	<div class="decorative-wrapper">
      <div class="decorative-svg blob-pos">
          @include('partials.svg.blueblob')
      </div>
  </div>

	{{-- Layered Decorative SVG Mobile --}}
	{{-- <div class="absolute decorative-wrapper-mobile md:hidden right-0 -top-30 w-50">
      <div class="decorative-svg blob-mobile-pos">
          @include('partials.svg.blueblob')
      </div>
  </div> --}}

		{{-- Layered Decorative SVG Mobile --}}
	<div class="decorative-wrapper-mobile">
      <div class="decorative-svg-mobile blob-mobile-pos">
          @include('partials.svg.blueblob')
      </div>
  </div>

	<div class="relative z-20 max-w-7xl mx-auto px-6 md:px-12">
		<div class="flex">
			<div class="ml-auto w-full lg:w-[60%]">

				<h2 class="text-2xl font-bold mb-6 uppercase text-ev-dark">
					ЗА НАС
				</h2>

				<p class="lg:text-base md:text-base xs:text-sm text-ev-dark">
					Еволуција на сонот е независна културна организација посветена на развојот на современата уметност и креативните практики во јавен простор. Преку интердисциплинарни проекти, фестивали и меѓународни соработки, организацијата создава платформа за културна размена, уметничко изразување и одржлив културен развој, со фокус на локалната заедница и нејзиното поврзување со глобалната уметничка сцена.
				</p>

			</div>
		</div>
	</div>
</section>

{{-- VIDEO SECTION via alpine.js --}}
@php
    $videoType = 'local'; 
    $videoUrl = asset('storage/video/video-insta.mp4'); 

    if ($videoType === 'youtube') {
        preg_match('/(?:embed\/|v=)([\w-]+)/', $videoUrl, $matches);
        $youtubeId = $matches[1] ?? '';
        $posterUrl = "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg";
    } else {
        $videoUrlWithFragment = $videoUrl . '#t=0.001';
    }
@endphp

<div class="relative z-20 max-w-7xl mx-auto px-6 py-6" 
      x-data="{ 
        playing: false,
        toggleVideo() {
            this.playing = !this.playing;
            if (this.$refs.localVideo) {
                this.playing ? this.$refs.localVideo.play() : this.$refs.localVideo.pause();
            }
        }
    }">
    
    <div class="relative rounded-lg overflow-hidden min-h-75 md:min-h-125 flex flex-col items-center justify-center bg-[#33322f] shadow-xl">
        
        @if($videoType === 'youtube')
            <div x-show="!playing" 
                  class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-cover bg-center transition-opacity duration-500"
                  style="background-image: url('{{ $posterUrl }}');">
                
                <button @click="playing = true"
                        class="relative z-30 w-24 h-24 md:w-32 md:h-32 rounded-full border-[3px] border-white/80 bg-white/15 flex items-center justify-center hover:scale-110 hover:bg-white/25 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="white">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                </button>
                <div class="absolute inset-0 bg-black/30 pointer-events-none"></div>
            </div>

            <template x-if="playing">
                <div class="absolute inset-0 z-10 w-full h-full bg-black">
                    <iframe class="w-full h-full"
                            src="{{ $videoUrl }}?autoplay=1&rel=0"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                </div>
            </template>

        @else
            <div class="absolute inset-0 z-10 w-full h-full bg-black">
                <video x-ref="localVideo"
                        :controls="playing"
                        playsinline
                        preload="metadata"
                        class="w-full h-full object-cover">
                    <source src="{{ $videoUrlWithFragment }}" type="video/mp4">
                    Вашиот прелистувач не поддржува видео.
                </video>
            </div>

            <div x-show="!playing" 
                  class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-black/20 transition-opacity duration-500">
                <button @click="toggleVideo()"
                        class="relative z-30 w-24 h-24 md:w-32 md:h-32 rounded-full border-[3px] border-white/80 bg-white/15 flex items-center justify-center hover:scale-110 hover:bg-white/25 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="white">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                </button>
            </div>
        @endif

        <button x-show="playing" 
                @click="toggleVideo()" 
                class="absolute top-4 right-4 z-40 bg-black/50 hover:bg-black/80 text-white p-2 rounded-full transition-all"
                title="Затвори видео">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>

{{-- ПРЕТХОДНИ НАСТАНИ SECTION --}}
<section class="relative py-20 bg-cream" x-data="eventSlider()">

    {{-- Layered Decorative SVG --}}
    <div class="decorative-wrapper">
      <div class="decorative-svg clouds-pos">
          @include('partials.svg.clouds')
      </div>
    </div>

    <div class="relative z-20 max-w-7xl mx-auto px-6">
        <h2 class="text-lg md:text-2xl font-bold uppercase text-center text-ev-dark mb-20">
            Претходни настани
        </h2>

        <div class="relative w-full h-112.5 md:h-137.5 lg:h-162.5 group">

            @php
                $events = [
                    ['title' => 'Еволуција на Сонот - 1', 'location' => 'Скопје, Македонија', 'image' => 'storage/images/event-1.svg'],
                    ['title' => 'Еволуција на Сонот - 2', 'location' => 'Скопје, Македонија', 'image' => 'storage/images/event-2.svg'],
                    ['title' => 'Еволуција на Сонот - 3', 'location' => 'Скопје, Македонија', 'image' => 'storage/images/event-3.svg'],
                ];
            @endphp

            <button @click="prev()"
                class="absolute left-4 top-1/2 -translate-y-1/2 z-40 w-10 h-10 md:w-14 md:h-14 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white flex items-center justify-center hover:bg-ev-dark hover:text-white transition-all shadow-lg active:scale-95">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button @click="next()"
                class="absolute right-4 top-1/2 -translate-y-1/2 z-40 w-10 h-10 md:w-14 md:h-14 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white flex items-center justify-center hover:bg-ev-dark hover:text-white transition-all shadow-lg active:scale-95">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            @foreach($events as $index => $event)
                <div class="event-card absolute inset-0" :class="getCardClass({{ $index }})">
                    <div class="relative rounded-3xl overflow-hidden shadow-lg h-full border border-gray-100">
                        <img src="{{ asset($event['image']) }}" 
                              alt="{{ $event['title'] }}"
															loading="lazy"
															decoding="async" 
                              class="w-full h-full object-cover">

                        <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-6 pb-6 md:hidden">
                            <h5 class="text-white text-xl font-bold mb-3 tracking-wide">
                                {{ $event['title'] }}
                            </h5>

                            <div class="flex gap-4 mb-4">
                                @foreach(['00', '00', '00'] as $unit)
                                    <div class="flex gap-1">
                                        @foreach(str_split($unit) as $digit)
                                            <div class="bg-white text-black font-semibold px-0 py-0 rounded-lg text-xl min-w-6 text-center shadow-sm">
                                                {{ $digit }}
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex items-center gap-2 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#ef4444">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                </svg>
                                <span class="text-sm font-xs">{{ $event['location'] }}</span>
                            </div>
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 px-6 py-4 bg-white/80 uppercase hidden md:block">
                            <h5 class="font-bold text-base text-ev-dark mb-1">
                                {{ $event['title'] }}
                            </h5>
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

        <div class="flex justify-start mt-6">
            <x-ui.button href="https://www.instagram.com/evolucija.na.sonot/" target="_blank" rel="noopener">
                Повеќе
            </x-ui.button>
        </div>
    </div>
</section>

{{-- ИНСТАГРАМ --}}
<section class="relative pt-20 pb-40 bg-cream">

	<div class="relative z-20 max-w-7xl mx-auto px-6">

		<div class="flex flex-col md:flex-row items-center justify-center gap-6 text-center mb-12">
			<h2 class="text-lg md:text-2xl font-bold uppercase text-ev-dark">
				Најнови објави од Инстаграм
			</h2>
			<x-ui.button href="https://www.instagram.com/evolucija.na.sonot/" target="_blank" rel="noopener">
				Заследи не
			</x-ui.button>
		</div>

		<div class="relative flex overflow-hidden marquee-mask">
			@foreach([1, 2] as $loopCount)
			<div class="flex animate-marquee whitespace-nowrap pause-on-hover">
				@php
				$images = [1, 2, 3, 4];
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

	{{-- Layered Decorative SVGs --}}
  


			<div class="decorative-wrapper">
        <div class="decorative-svg leaf-pos">
          @include('partials.svg.leaf')
        </div>
        <div class="decorative-svg clouds-insta-pos">
          @include('partials.svg.clouds-blog')
        </div>
				<div class="decorative-svg insta-blob-1-pos">
          @include('partials.svg.insta-blob-1')
        </div>
				<div class="decorative-svg insta-blob-2-pos">
          @include('partials.svg.insta-blob-2')
        </div>
      </div>

</section>

@endsection