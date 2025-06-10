@extends('layouts.app')

@section('title', 'Dashboard - Bank BTPN Automatic Shifting')

@section('content')
    @include('partials.navbar')

<main class="flex-grow py-6 sm:py-8">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="mb-8 sm:mb-12">
            <div class="bg-[#F5F5F5] text-black px-3 sm:px-4 py-2 rounded-md text-xs sm:text-sm font-semibold tracking-wide inline-block shadow-[inset_0_4px_4px_rgba(0,0,0,0.25)]">
                AUTOMATIC SHIFTING | AS
            </div>
        </div>

        <div class="flex flex-col space-y-4 sm:space-y-6 max-w-xs sm:max-w-md mx-auto">
            <a href="{{ route('employee.onboarding') }}" class="bg-white border border-gray-200 rounded-lg shadow-md p-3 sm:p-4 flex items-center space-x-3 sm:space-x-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-200 text-decoration-none group">
                <div class="flex-shrink-0">
                    <img src="{{ asset('img/iconKaryawanOnboarding.png') }}" alt="Karyawan Onboarding" class="w-5 h-5 sm:w-6 sm:h-6">
                </div>
                <span class="text-gray-700 font-semibold group-hover:text-gray-900 text-sm sm:text-base">KARYAWAN ONBOARDING</span>
            </a>

            <a href="#" class="bg-white border border-gray-200 rounded-lg shadow-md p-3 sm:p-4 flex items-center space-x-3 sm:space-x-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-200 text-decoration-none group">
                <div class="flex-shrink-0">
                    <img src="{{ asset('img/iconCutiOnboarding.png') }}" alt="Cuti Onboarding" class="w-5 h-5 sm:w-6 sm:h-6">
                </div>
                <span class="text-gray-700 font-semibold group-hover:text-gray-900 text-sm sm:text-base">CUTI ONBOARDING</span>
            </a>

            <a href="/request-shifting" class="bg-white border border-gray-200 rounded-lg shadow-md p-3 sm:p-4 flex items-center space-x-3 sm:space-x-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-200 text-decoration-none group">
                <div class="flex-shrink-0">
                    <img src="{{ asset('img/iconRequestShifting.png') }}" alt="Request Shifting" class="w-5 h-5 sm:w-6 sm:h-6">
                </div>
                <span class="text-gray-700 font-semibold group-hover:text-gray-900 text-sm sm:text-base">REQUEST SHIFTING</span>
            </a>

            <a href="/report" class="bg-white border border-gray-200 rounded-lg shadow-md p-3 sm:p-4 flex items-center space-x-3 sm:space-x-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-200 text-decoration-none group">
                <div class="flex-shrink-0">
                    <img src="{{ asset('img/iconReport.png') }}" alt="Report" class="w-5 h-5 sm:w-6 sm:h-6">
                </div>
                <span class="text-gray-700 font-semibold group-hover:text-gray-900 text-sm sm:text-base">REPORT</span>
            </a>
        </div>
    </div>
</main>

    @include('partials.footer')
@endsection
