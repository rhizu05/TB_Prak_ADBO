<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-semibold text-white">Welcome Back</h2>
        <p class="text-blue-100 mt-1">Sign in to your account</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-400">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-blue-100">Email</label>
            <input id="email" class="block mt-1 w-full rounded-md border-white/20 bg-white/10 text-white placeholder-blue-200 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@restoqr.com" />
            @error('email')
                <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-blue-100">Password</label>
            <input id="password" class="block mt-1 w-full rounded-md border-white/20 bg-white/10 text-white placeholder-blue-200 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            @error('password')
                <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ml-2 text-sm text-blue-100">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="w-full py-2 px-4 bg-blue-500 hover:bg-blue-400 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out transform hover:scale-[1.02]">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</x-guest-layout>
