<x-guest-layout>
    {{-- Logo --}}
    <div class="flex justify-center mb-8">
        <a href="/">
            <img src="{{ asset('storage/images/nav-logo.svg') }}"
                  alt="Еволуција на Сонот"
                  class="h-24 w-auto">
        </a>
    </div>

    {{-- Title --}}
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold uppercase text-ev-dark">
            Нова лозинка
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Ве молиме внесете ја вашата нова лозинка подолу.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-ev-dark mb-1">
                Е-пошта
            </label>
            <input id="email" type="email" name="email" 
                    value="{{ old('email', $request->email) }}" 
                    required autofocus autocomplete="email"
                    class="w-full px-4 py-2.5 rounded-lg border text-ev-dark text-sm bg-white focus:outline-none focus:ring-2 focus:ring-ev-blue focus:border-transparent transition duration-200 {{ $errors->has('email') ? 'border-red-500 focus:ring-red-400' : 'border-gray-300' }}">
            @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-ev-dark mb-1">
                Нова лозинка
            </label>
            <input id="password" type="password" name="password" 
                    required autocomplete="new-password"
                    class="w-full px-4 py-2.5 rounded-lg border text-ev-dark text-sm bg-white focus:outline-none focus:ring-2 focus:ring-ev-blue focus:border-transparent transition duration-200 {{ $errors->has('password') ? 'border-red-500 focus:ring-red-400' : 'border-gray-300' }}">
            @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-ev-dark mb-1">
                Потврди лозинка
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" 
                    required autocomplete="new-password"
                    class="w-full px-4 py-2.5 rounded-lg border text-ev-dark text-sm bg-white focus:outline-none focus:ring-2 focus:ring-ev-blue focus:border-transparent transition duration-200 {{ $errors->has('password_confirmation') ? 'border-red-500 focus:ring-red-400' : 'border-gray-300' }}">
            @error('password_confirmation')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <div class="pt-2">
            <x-ui.button type="submit"
                        class="btn-prijavi-nav w-full h-10 py-3 text-base font-bold shadow-md hover:shadow-lg active:scale-[0.98] transition-all">
                Ресетирај лозинка
            </x-ui.button>
        </div>
    </form>
</x-guest-layout>