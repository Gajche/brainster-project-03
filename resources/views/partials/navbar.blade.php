{{-- resources/views/partials/navbar.blade.php --}}

<nav class="bg-white lg:sticky top-0 z-50 border-b border-black/5 py-6 h-auto w-full">

	<div class="relative z-10 max-w-7xl mx-auto h-full flex items-center justify-between ps-36 pe-6">

		<a href="{{ route('home') }}"
			class="hidden lg:block shrink-0 no-underline text-ev-dark font-bold uppercase tracking-tight whitespace-nowrap leading-tight text-sm xl:text-lg 2xl:text-[24px]">
			Еволуција на Сонот
		</a>

		<div class="lg:hidden flex-1"></div>

		<div class="hidden lg:flex items-center gap-6 xl:gap-8">
			<div class="flex items-center gap-6 xl:gap-8">
				@foreach([
				['route' => 'home', 'label' => 'Дома'],
				['route' => 'art-city', 'label' => 'Арт Сити'],
				['route' => 'blog', 'label' => 'Повеќе за нас'],
				] as $link)
				<a href="{{ route($link['route']) }}"
					class="text-ev-dark text-sm xl:text-base 2xl:text-[20px] font-medium hover:opacity-60 transition-all whitespace-nowrap
            {{ request()->routeIs($link['route']) ? 'underline decoration-2' : '' }}">
					{{ $link['label'] }}
				</a>
				@endforeach
			</div>

			<x-ui.button href="{{ route('work-with-us') }}" class="shrink-0">
				Пријави се
			</x-ui.button>

			<button class="text-ev-dark hover:opacity-60 transition-all shrink-0" aria-label="Јазик">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
					<circle cx="12" cy="12" r="10" />
					<line x1="2" y1="12" x2="22" y2="12" />
					<path d="M12 2a15 15 0 0 1 4 10 15 15 0 0 1-4 10 15 15 0 0 1-4-10 15 15 0 0 1 4-10z" />
				</svg>
			</button>
		</div>

		{{-- mobile-menu-btn --}}
		<button id="mobile-menu-btn"
			class="lg:hidden flex flex-col justify-center items-center w-10 h-10 gap-1.5 focus:outline-none z-60">
			<span class="w-8 h-1 bg-black block"></span>
			<span class="w-8 h-1 bg-black block"></span>
			<span class="w-8 h-1 bg-black block"></span>
		</button>

	</div>

	{{-- mobile-menu --}}
	<div id="mobile-menu"
		class="fixed inset-0 bg-white translate-x-full transition-transform duration-300 lg:hidden z-100 flex flex-col items-center justify-center gap-8">

		{{-- close-menu-btn --}}
		<button id="close-menu-btn"
			class="absolute top-6 right-6 w-10 h-10 flex items-center justify-center">
			<span class="block w-6 h-1 bg-black rotate-45 absolute"></span>
			<span class="block w-6 h-1 bg-black -rotate-45 absolute"></span>
		</button>

		@foreach([
		['route' => 'home', 'label' => 'Дома'],
		['route' => 'art-city', 'label' => 'Арт Сити'],
		['route' => 'blog', 'label' => 'Повеќе за нас'],
		] as $link)
		<a href="{{ route($link['route']) }}" class="text-xl font-bold uppercase text-ev-dark">
			{{ $link['label'] }}
		</a>
		@endforeach

		<x-ui.button href="{{ route('work-with-us') }}">
			Пријави се
		</x-ui.button>
	</div>

</nav>