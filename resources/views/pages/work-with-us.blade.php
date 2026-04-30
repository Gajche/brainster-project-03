@extends('layouts.app')
@section('title', 'Работи со нас - Еволуција на Сонот')

@section('content')

<section class="relative min-h-[calc(100vh-89px)] lg:min-h-[calc(100vh-81px)] py-20 bg-cream overflow-visible">

  {{-- Dandelion --}}
  <div class="absolute inset-0 max-w-7xl mx-auto w-full px-6 pointer-events-none z-100">
    <div x-data class="dandelion-wrap pointer-events-none">
      @include('partials.svg.dandelion')
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-6">
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

      {{-- LEFT: Contact Info --}}
      <div>
        <h1 class="text-2xl md:text-3xl lg:text-6xl text-center md:text-start lg:text-start font-bold uppercase mb-10">
          Биди дел од нашиот тим
        </h1>

        @php
        $contacts = [
          ['icon' => 'mail', 'text' => 'xxxxxxxxxxxxx@mail.com'],
          ['icon' => 'mail', 'text' => 'xxxxxxxxxxxxx@mail.com'],
          ['icon' => 'mail', 'text' => 'xxxxxxxxxxxxx@mail.com'],
          ['icon' => 'pin', 'text' => 'Ул. 1, Ѓорче Петров Бр.55, Скопје'],
          ['icon' => 'phone', 'text' => '07X XXX XXX'],
        ];
        @endphp

        @foreach($contacts as $c)
        <div class="flex items-start gap-3 mb-4 justify-center md:justify-start">
          @if($c['icon'] === 'mail')
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
            <polyline points="22,6 12,13 2,6" />
          </svg>
          @elseif($c['icon'] === 'pin')
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
            <circle cx="12" cy="10" r="3" />
          </svg>
          @else
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.42 2 2 0 0 1 3.6 1.25h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9a16 16 0 0 0 6 6l.92-1.14a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 16a2 2 0 0 1 .27.92z" />
          </svg>
          @endif
          <span>{{ $c['text'] }}</span>
        </div>
        @endforeach
      </div>

      {{-- RIGHT: Application Form --}}
      <div>
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 mb-6 text-sm">
          <ul class="mb-0 list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form id="artist-application-form"
          action="{{ route('apply') }}"
          method="POST"
          enctype="multipart/form-data">
          @csrf

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
            <div>
              <label for="name" class="block text-sm font-semibold text-ev-dark mb-1">Име</label>
              <input type="text" id="name" name="name" class="input-underline" value="{{ old('name') }}" autocomplete="given-name" required>
            </div>
            <div>
              <label for="surname" class="block text-sm font-semibold text-ev-dark mb-1">Презиме</label>
              <input type="text" id="surname" name="surname" class="input-underline" value="{{ old('surname') }}" autocomplete="family-name" required>
            </div>
          </div>

          <div class="mb-6">
            <label for="email" class="block text-sm font-semibold text-ev-dark mb-1">E-Mail</label>
            <input type="email" id="email" name="email" class="input-underline" value="{{ old('email') }}" autocomplete="email" required>
          </div>

          <div class="mb-6">
            <label for="collaboration_area" class="block text-sm font-semibold text-ev-dark mb-1">Во која област сакаш да соработуваш со нас?</label>
            <input type="text" id="collaboration_area" name="collaboration_area" class="input-underline" value="{{ old('collaboration_area') }}" required>
          </div>

          <div class="mb-6">
            <label for="message" class="block text-sm font-semibold text-ev-dark mb-1">Остави кратка порака</label>
            <textarea id="message" name="message" rows="4" class="input-underline resize-y min-h-25" required>{{ old('message') }}</textarea>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
            <div>
              <label for="phone" class="block text-sm font-semibold text-ev-dark mb-1">Телефон</label>
              <input type="tel" id="phone" name="phone" class="input-underline" value="{{ old('phone') }}" autocomplete="tel">
            </div>
            <div>
              <label for="social_media" class="block text-sm font-semibold text-ev-dark mb-1">Социјална мрежа</label>
              <input type="url" id="social_media" name="social_media" class="input-underline" value="{{ old('social_media') }}" placeholder="https://...">
            </div>
          </div>

					{{-- Portfolio Section: File OR URL --}}
					<div class="mb-10">
						<label for="portfolio" class="block text-sm font-semibold text-ev-dark mb-4">Твоето портфолио (фајл или линк)</label>
						
						<div class="grid grid-cols-1 sm:grid-cols-2 gap-8 items-end">
							{{-- File Upload --}}
							<div>
								<label for="portfolio" class="block text-xs font-medium text-gray-500 mb-2 italic">Прикачи фајл:</label>
								<input type="file" id="portfolio" name="portfolio" accept=".pdf,.doc,.docx" class="hidden">
								<x-ui.button type="button" variant="secondary" id="choose-file-btn" class="w-full">
									<span id="file-label" class="text-sm">Одбери</span>
								</x-ui.button>
								@error('portfolio')
									<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
								@enderror
							</div>

							{{-- Portfolio URL --}}
							<div>
								<label for="portfolio_url" class="block text-xs font-medium text-gray-500 mb-2 italic">ИЛИ внеси линк (Behance, Portfolio...):</label>
								<input type="url" id="portfolio_url" name="portfolio_url" 
											class="input-underline" 
											value="{{ old('portfolio_url') }}" 
											placeholder="https://...">
								@error('portfolio_url')
									<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
								@enderror
							</div>
						</div>
						
						{{-- Hint text for the artist --}}
						<p class="text-[10px] text-gray-400 mt-3 text-center sm:text-left">
							* Задолжително е да прикачите фајл или да внесете валиден линк до вашето портфолио.
						</p>
					</div>

          <div class="flex justify-center">
            <x-ui.button type="submit" id="submit-btn">Испрати</x-ui.button>
          </div>
        </form>
      </div>
    </div>
  </div>

	<div class="decorative-wrapper">
    <div class="decorative-svg wwu-blob-pos">
      @include('partials.svg.work-with-us-blob')
    </div>
  </div>

</section>

@endsection