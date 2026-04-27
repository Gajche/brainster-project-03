<footer class="bg-white border-t-4 border-gray-400 lg:py-6 xs:py-3 relative overflow-visible z-10">

	<div class="relative max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-6 md:gap-4">

		{{-- Dandelion Logo --}}
		<div class="dandelion-footer-wrap">
			@include('partials.svg.dandelion-footer')
		</div>

		{{-- Contact --}}
		<div class="flex items-center gap-2 text-sm text-ev-dark text-center md:text-center lg:ml-30 md:ml-20">
			<!-- <span class="hidden md:inline text-gray-400">|</span> -->
			<span>
				| Контактирај не
				<a href="mailto:evolucijanasonot@gmail.com" class="font-semibold hover:text-ev-blue transition">
					evolucijanasonot@gmail.com
				</a>
			</span>
		</div>

		{{-- Socials --}}
		<div class="flex items-center justify-center gap-6 lg:gap-12">
			<a href="https://www.youtube.com/" target="_blank" class="hover:opacity-75 transition">
				@include('partials.icons.youtube')
			</a>
			<a href="https://www.instagram.com/evolucija.na.sonot/" target="_blank" class="hover:opacity-75 transition">
				@include('partials.icons.instagram')
			</a>
			<a href="https://www.facebook.com/" target="_blank" class="hover:opacity-75 transition">
				@include('partials.icons.facebook')
			</a>
		</div>

	</div>
</footer>