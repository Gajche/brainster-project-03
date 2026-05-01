<x-guest-layout>

    {{-- Logo --}}
    <div class="flex justify-center mb-0">
        <a href="/">
            <img src="{{ asset('storage/images/nav-logo.svg') }}"
                  alt="Еволуција на Сонот"
                  class="h-24 w-auto">
        </a>
    </div>

    {{-- Title --}}
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold uppercase text-ev-dark">
            Еволуција на Сонот
        </h1>
        <p class="text-lg text-ev-dark font-bold mt-1 uppercase">
            - Администрација -
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-ev-dark mb-1">
                Е-пошта
            </label>
            <input id="email"
										type="email"
										name="email"
										value="{{ old('email') }}"
										required
										autofocus
										autocomplete="email"
										class="w-full px-4 py-2.5 rounded-lg border text-ev-dark text-sm bg-white 
													focus:outline-none focus:ring-2 focus:ring-ev-blue focus:border-transparent 
													transition duration-200 
              {{ $errors->has('email') ? 'border-red-500 focus:ring-red-400' : 'border-gray-300' }}">
            @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-semibold text-ev-dark mb-1">
                Лозинка
            </label>
            <input id="password"
										type="password"
										name="password"
										required
										autocomplete="current-password"
										class="w-full px-4 py-2.5 rounded-lg border text-ev-dark text-sm bg-white 
													focus:outline-none focus:ring-2 focus:ring-ev-blue focus:border-transparent 
													transition duration-200 
              {{ $errors->has('password') ? 'border-red-500 focus:ring-red-400' : 'border-gray-300' }}">
            @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember me + Forgot password --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                        class="w-4 h-4 rounded border-gray-300 text-ev-blue focus:ring-ev-blue cursor-pointer">
                <label for="remember_me" class="ml-2 text-sm text-gray-600 cursor-pointer select-none">
                    Запомни ме
                </label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-sm text-ev-blue hover:text-ev-blue-dark underline underline-offset-2 transition-colors duration-200">
                    Ја заборавивте лозинката?
                </a>
            @endif
        </div>

				{{-- Submit Button --}}
				<div class="pt-2">
						<x-ui.button 
								type="submit"
								class="btn-prijavi-nav w-full h-10 py-3 text-base font-bold shadow-md hover:shadow-lg active:scale-[0.98] transition-all"
						>
								Најави се
						</x-ui.button>
				</div>

    </form>
</x-guest-layout>