@extends('layouts.app')

@section('title', 'Login - Bank BTPN Automatic Shifting')

@section('content')
    <main class="min-h-screen relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('img/building-bg.png') }}" alt="Building Background" class="w-full h-full object-cover">
        </div>
        <a href="{{ route('login') }}" class="absolute top-6 left-6 z-20">
            <img src="{{ asset('img/logo-orange.png') }}" alt="Bank BTPN Logo" class="h-16 sm:h-20 w-auto">
        </a>
        <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4 sm:px-6">
            <div class="w-full max-w-sm space-y-6 bg-black/40 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-white text-center">LOGIN</h2>

                @if (session('success'))
                    <div class="bg-green-500/90 text-white px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-500/90 text-white px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-2">
                        <label for="email" class="block text-white text-sm font-semibold tracking-wide">
                            Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                            placeholder="Masukkan email" required>
                    </div>
                    <div class="space-y-2">
                        <label for="password" class="block text-white text-sm font-semibold tracking-wide">
                            Password
                        </label>
                        <input type="password" id="password" name="password"
                            class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                            placeholder="Masukkan password" required>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                            class="h-4 w-4 text-orange-400 focus:ring-orange-400 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-white">
                            Remember me
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-transparent">
                            Login
                        </button>
                    </div>
                    <div class="text-center">
                        <p class="text-white text-sm">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="text-orange-400 hover:text-orange-300 font-semibold">
                                Daftar disini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <style>
        .bg-opacity-90 {
            background-color: rgba(255, 255, 255, 0.9);
        }

        input::placeholder {
            opacity: 0.7;
        }
    </style>
@endpush
