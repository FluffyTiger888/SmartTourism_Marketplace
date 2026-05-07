<x-guest-layout>
    <section class="auth-card">
        <div class="auth-logo-area">
            <x-application-logo />
            <p class="auth-logo-subtitle">
                Create your account and start exploring tours
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="auth-group">
                <label for="name" class="auth-label">Full Name</label>

                <input
                    id="name"
                    class="auth-input"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Enter your full name"
                >

                @error('name')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-group">
                <label for="email" class="auth-label">Email Address</label>

                <input
                    id="email"
                    class="auth-input"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    placeholder="user@example.com"
                >

                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-group">
                <label for="role" class="auth-label">Register As</label>

                <select id="role" name="role" class="auth-select" required>
                    <option value="customer">Customer / Traveler</option>
                    <option value="agency_owner">Travel Agency Owner</option>
                    <option value="tour_guide">Tour Guide</option>
                </select>

                @error('role')
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
                    autocomplete="new-password"
                    placeholder="Create a password"
                >

                @error('password')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-group">
                <label for="password_confirmation" class="auth-label">Confirm Password</label>

                <input
                    id="password_confirmation"
                    class="auth-input"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Re-enter your password"
                >

                @error('password_confirmation')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="auth-button">
                Create Account
            </button>

            <div class="auth-bottom-text">
                Already registered?
                <a href="{{ route('login') }}" class="auth-link">Login here</a>
            </div>
        </form>
    </section>
</x-guest-layout>