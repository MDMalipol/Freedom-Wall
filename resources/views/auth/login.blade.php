<x-guest-layout>
    <h1 class="form-title">Welcome Back</h1>

    <!-- Session Status -->
    <x-auth-session-status class="session-status mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <x-input-label for="email" :value="__('Email')" class="input-label" />
            <x-text-input id="email" class="text-input block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="input-error mt-2" />
        </div>

        <!-- Password -->
        <div class="form-group mt-4">
            <x-input-label for="password" :value="__('Password')" class="input-label" />
            <x-text-input id="password" class="text-input block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="Enter your password" />
            <x-input-error :messages="$errors->get('password')" class="input-error mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="checkbox-container">
            <input id="remember_me" type="checkbox" class="checkbox" name="remember">
            <label for="remember_me" class="checkbox-label">{{ __('Remember me') }}</label>
        </div>

        <div class="form-actions">
            @if (Route::has('password.request'))
                <a class="forgot-password" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit" class="primary-button">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</x-guest-layout>
