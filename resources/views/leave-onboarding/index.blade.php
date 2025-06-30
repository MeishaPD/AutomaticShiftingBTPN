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

                <form action="{{ route('employee.leave.store') }}" method="POST" class="space-y-4">
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
                        <label for="employee_name" class="block text-white text-sm font-semibold tracking-wide">
                            Nama Karyawan
                        </label>
                        <input type="text" id="employee_name" name="employee_name" value="{{ old('employee_name') }}"
                            class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                            placeholder="Masukkan nama karyawan" required>
                    </div>

                    <div class="space-y-2">
                        <label for="leave_start" class="block text-white text-sm font-semibold tracking-wide">
                            Tanggal Cuti Dimulai
                        </label>
                        <input type="date" id="leave_start" name="leave_start"
                            value="{{ old('leave_start', now()->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}"
                            class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                            required>
                    </div>

                    <div class="space-y-2">
                        <label for="leave_end" class="block text-white text-sm font-semibold tracking-wide">
                            Tanggal Cuti Berakhir
                        </label>
                        <input type="date" id="leave_end" name="leave_end"
                            value="{{ old('leave_end', now()->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}"
                            class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                            required>
                    </div>

                    <div class="space-y-2">
                        <label for="leave_type" class="block text-white text-sm font-semibold tracking-wide">
                            Tipe Cuti
                        </label>
                        <select
                            id="leave_type"
                            name="leave_type"
                            class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                            required
                        >
                            <option value="">Pilih tipe cuti</option>
                            <option value="yearly" {{ old('leave_type') === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                            <option value="special" {{ old('leave_type') === 'special' ? 'selected' : '' }}>Khusus</option>
                        </select>
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