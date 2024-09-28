<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            @if($errors->has('email'))
            <x-input-error :messages="['Por favor, insira um endereço de email válido.']" class="mt-2" />
            @endif
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />

            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="current-password" />

            @if($errors->has('password'))
            <x-input-error :messages="['Por favor, insira uma senha válida.']" class="mt-2" />
            @endif
        </div>


        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('register') }}" class="ms-3 underline text-sm text-gray-600 dark:text-gray-500 hover:text-gray-900 dark:hover:text-black rounded-md">
                {{ __('Registrar-se') }}
            </a>

            <x-primary-button class="ms-3">
                {{ __('Entrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>