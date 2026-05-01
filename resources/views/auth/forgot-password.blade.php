<x-guest-layout>
    {{-- Logo --}}
    <div class="flex justify-center mb-8">
        <a href="/">
            <img src="{{ asset('storage/images/nav-logo.svg') }}"
                  alt="Еволуција на Сонот"
                  class="h-24 w-auto">
        </a>
    </div>

    {{-- Title & Instructions --}}
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold uppercase text-ev-dark">
            Заборавена лозинка?
        </h1>
        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
            Внесете ја вашата е-пошта и ќе ви испратиме линк за ресетирање на лозинката.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
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

        {{-- Action Buttons --}}
        <div class="space-y-4 pt-2">
            <x-ui.button 
                type="submit"
                class="btn-prijavi-nav w-full h-10 py-3 text-base font-bold shadow-md hover:shadow-lg active:scale-[0.98] transition-all"
            >
                Испрати линк
            </x-ui.button>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-ev-blue transition-colors">
                    ← Назад кон најава
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>