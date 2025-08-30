@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-md bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white">Login</h2>

        <!-- Normal Login Form -->
        <form method="POST" action="{{ route('login') }}" class="mt-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input id="email" type="email" name="email" required autofocus
                       class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <div class="mt-4 flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-600 text-red-600 shadow-sm focus:ring-red-500">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-red-600 hover:text-red-800">Forgot Password?</a>
                @endif
            </div>

            <button type="submit"
                class="mt-6 w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg shadow-md transition">
                Login
            </button>
        </form>
        <div class="my-6 flex items-center">
            <hr class="w-full border-gray-300 dark:border-gray-600">
            <span class="px-2 text-gray-500 dark:text-gray-400 text-sm">OR</span>
            <hr class="w-full border-gray-300 dark:border-gray-600">
        </div>

         @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="w-full flex items-center justify-center bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg shadow-md transition">
                Register
            </a>
        @endif
        <!-- Divider -->
        <div class="my-6 flex items-center">
            <hr class="w-full border-gray-300 dark:border-gray-600">
            <span class="px-2 text-gray-500 dark:text-gray-400 text-sm">OR</span>
            <hr class="w-full border-gray-300 dark:border-gray-600">
        </div>


        <!-- Social Login -->
        <div class="space-y-3">
            <a href="{{ route('oauth.redirect', 'google') }}"
               class="w-full flex items-center justify-center bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg shadow-md transition">
                <i class="fab fa-google mr-2"></i> Login with Google
            </a>
            <div class="my-6 flex items-center">
                <hr class="w-full border-gray-300 dark:border-gray-600">
                <span class="px-2 text-gray-500 dark:text-gray-400 text-sm">OR</span>
                <hr class="w-full border-gray-300 dark:border-gray-600">
            </div>
            <a href="{{ route('oauth.redirect', 'facebook') }}"
               class="w-full flex items-center justify-center bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg shadow-md transition">
                <i class="fab fa-facebook mr-2"></i> Login with Facebook
            </a>
        </div>
    </div>
</div>
@endsection
