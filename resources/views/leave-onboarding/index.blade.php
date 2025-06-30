@extends('layouts.app')

@section('title', 'Cuti Onboarding - Bank BTPN Automatic Shifting')

@section('content')
    <main class="min-h-screen relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('img/building-bg.png') }}" alt="Building Background" class="w-full h-full object-cover">
        </div>

        <a href="/" class="absolute top-6 left-6 z-20">
            <img src="{{ asset('img/logo-orange.png') }}" alt="Bank BTPN Logo" class="h-16 sm:h-20 w-auto">
        </a>

        <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4 sm:px-6">
            <div class="w-full max-w-sm space-y-6 bg-black/40 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-white text-center">Cuti Onboarding</h2>

                @if ($errors->any())
                    <div class="bg-red-500/90 text-white px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('request-shifting.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-2">
                        <label for="nik" class="block text-white text-sm font-semibold tracking-wide">
                            NIK
                        </label>
                        <input type="text" id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" pattern="\d{16}"
                            class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                            placeholder="Masukkan 16 digit NIK" required>
                    </div>

                    <div class="space-y-2">
                        <label for="shift_date" class="block text-white text-sm font-semibold tracking-wide">
                            Tanggal
                        </label>
                        <input type="date" id="shift_date" name="shift_date"
                            value="{{ old('shift_date', now()->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}"
                            class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                            required>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-transparent">
                            Submit
                        </button>
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

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
    </style>
@endpush