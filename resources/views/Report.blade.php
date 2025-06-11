@extends('layouts.app')

@section('title', 'Report - Bank BTPN Automatic Shifting')

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
            @if ($errors->any())
                <div class="bg-red-500/90 text-white px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('report.download') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label for="report_type" class="block text-white text-sm font-semibold tracking-wide">
                        TIPE LAPORAN
                    </label>
                    <select
                        id="report_type"
                        name="report_type"
                        class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                        required
                    >
                        <option value="">Pilih Tipe Laporan</option>
                        <option value="semua" {{ old('report_type') === 'semua' ? 'selected' : '' }}>Semua</option>
                        <option value="individu" {{ old('report_type') === 'individu' ? 'selected' : '' }}>Individu</option>
                    </select>
                </div>

                <div id="nik_field" class="space-y-2 hidden">
                    <label for="nik" class="block text-white text-sm font-semibold tracking-wide">
                        NIK
                    </label>
                    <input
                        type="text"
                        id="nik"
                        name="nik"
                        value="{{ old('nik') }}"
                        pattern="[0-9]{16}"
                        maxlength="16"
                        class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                        placeholder="Masukkan NIK (16 digit)"
                    >
                </div>

                <div class="space-y-2">
                    <label for="start_date" class="block text-white text-sm font-semibold tracking-wide">
                        TANGGAL MULAI
                    </label>
                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        value="{{ old('start_date') }}"
                        class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                        required
                    >
                </div>

                <div class="space-y-2">
                    <label for="end_date" class="block text-white text-sm font-semibold tracking-wide">
                        TANGGAL SELESAI
                    </label>
                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ old('end_date') }}"
                        class="w-full px-2 py-3 bg-white bg-opacity-90 border-0 rounded-lg text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 transition-all duration-200"
                        required
                    >
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                         class="w-full py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-transparent"
                    >
                        Download Excel
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
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const reportTypeSelect = document.getElementById('report_type');
    const nikField = document.getElementById('nik_field');
    const nikInput = document.getElementById('nik');

    reportTypeSelect.addEventListener('change', function() {
        if (this.value === 'individu') {
            nikField.classList.remove('hidden');
            nikInput.setAttribute('required', 'required');
        } else {
            nikField.classList.add('hidden');
            nikInput.removeAttribute('required');
            nikInput.value = '';
        }
    });

    if (reportTypeSelect.value === 'individu') {
        nikField.classList.remove('hidden');
        nikInput.setAttribute('required', 'required');
    }
});
</script>
@endpush
