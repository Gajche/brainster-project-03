{{-- resources/views/components/map-section.blade.php --}}
<section {{ $attributes->merge(['class' => 'relative py-20 bg-cream overflow-visible']) }}>
    
    {{-- Droplet --}}
    {{-- Layered Decorative SVG --}}
    <div class="decorative-wrapper">
      <div class="decorative-svg ac-droplet-pos">
          @include('partials.svg.droplet')
      </div>
    </div>

    <div class="relative z-30 max-w-7xl mx-auto px-6">
        <h2 class="text-lg md:text-2xl font-bold uppercase text-center text-ev-dark mb-8">
            Мапа
        </h2>

        <div class="relative rounded-xl overflow-hidden shadow-xl border-4 border-white bg-white">
            {{-- Floating Label --}}
            {{-- <div class="absolute top-4 right-4 bg-white/95 px-3 py-2 rounded-lg font-bold text-sm text-right leading-snug z-1000 shadow-sm border border-gray-100">
                Кавадарци<br>5-15 Август
            </div> --}}

						<div id="map-label" class="absolute top-4 right-4 bg-white/80 px-3 py-2 rounded-lg font-bold text- text-right text-sm md:text-base z-100 shadow-sm border border-gray-100 transition-all duration-300">
                За детали,<br>одбери локација
						</div>

            {{-- The Map Target --}}
            <div id="map" class="w-full h-112.5 md:h-137.5 z-10"></div>
        </div>
    </div>
</section>

@push('scripts')
    @vite('resources/js/map-init.js')
@endpush