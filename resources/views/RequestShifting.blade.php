@extends('layouts.app')

@section('title', 'Request Shifting - Bank BTPN Automatic Shifting')

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
            <div class="space-y-2">
                <label for="nik" class="block text-white text-sm font-semibold tracking-wide">
                    NIK
                </label>
                <input 
                    type="text" 
                    id="nik" 
                    name="nik"
                    class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                >
            </div>

            <div class="space-y-2">
                <label for="nama" class="block text-white text-sm font-semibold tracking-wide">
                    NAMA
                </label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                >
            </div>

            <div class="space-y-2">
                <label for="tanggal" class="block text-white text-sm font-semibold tracking-wide">
                    Tanggal
                </label>
                <input 
                    type="text"
                    id="tanggal"
                    name="tanggal"
                    class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                >
            </div>

            <div class="space-y-2">
                <label for="request" class="block text-white text-sm font-semibold tracking-wide">
                    Request
                </label>
                <input
                    type="text"
                    id="request"
                    name="request"
                    class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                >
            </div>

            <div class="pt-2">
                <button 
                    type="button"
                    class="w-full py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-transparent"
                >
                    Submit
                </button>
            </div>
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