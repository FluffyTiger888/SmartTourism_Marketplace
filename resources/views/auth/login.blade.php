<x-guest-layout>
    <section class="auth-card">
        <div class="auth-logo-area">
            <x-application-logo />
            <p class="auth-logo-subtitle">
                Sign in to access your tourism dashboard
            </p>
        </div>

        @if (session('status'))
            <div class="auth-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="auth-group">
                <label for="email" class="auth-label">Email Address</label>

                <input
                    id="email"
                    class="auth-input"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="user@example.com"
                >

                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-group">
                <label for="password" class="auth-label">Password</label>

                <input
                    id="password"
                    class="auth-input"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                >

                @error('password')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-row">
                <label for="remember_me" class="remember-label">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                    >
                    <span>Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="auth-button">
                Secure Login <i class="fas fa-arrow-right"></i>
            </button>

            <div class="auth-bottom-text">
                New to TravelMarket?
                <a href="{{ route('register') }}" class="auth-link">Create an account</a>
            </div>
        </form>
    </section>
</x-guest-layout>