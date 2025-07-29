
<x-guest-layout>
    <div class="flex flex-col items-center mb-8">
        <div class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 via-pink-500 to-yellow-400 drop-shadow mb-2">Ten-Quiz-App</div>
        <div class="text-xl font-semibold text-gray-700 mb-2 tracking-wide">ログイン</div>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">メールアドレス</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12l-4-4-4 4m8 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0V6a2 2 0 00-2-2H6a2 2 0 00-2 2v6" /></svg>
                </span>
                <input id="email" name="email" type="email" autocomplete="username" required autofocus value="{{ old('email') }}"
                    class="pl-10 pr-4 py-2 w-full rounded-lg border border-gray-300 shadow focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 bg-gradient-to-r from-yellow-50 to-pink-50 placeholder-gray-400 text-gray-900 transition" placeholder="メールアドレスを入力" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">パスワード</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm0 0v2m0 4h.01" /></svg>
                </span>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                    class="pl-10 pr-4 py-2 w-full rounded-lg border border-gray-300 shadow focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 bg-gradient-to-r from-yellow-50 to-pink-50 placeholder-gray-400 text-gray-900 transition" placeholder="パスワードを入力" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
            <label for="remember_me" class="ml-2 block text-sm text-gray-600">ログイン状態を保持する</label>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-2">
            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-500 hover:underline hover:text-pink-500 transition" href="{{ route('password.request') }}">
                    パスワードをお忘れですか？
                </a>
            @endif

            <button type="submit"
                class="w-full sm:w-auto px-6 py-2 rounded-lg font-bold text-white bg-gradient-to-r from-indigo-500 via-pink-500 to-yellow-400 shadow-lg hover:from-pink-500 hover:to-indigo-500 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400">
                ログイン
            </button>
        </div>
    </form>
</x-guest-layout>
