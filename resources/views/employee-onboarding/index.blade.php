@extends('layouts.app')

@section('title', 'Employee Onboarding - Bank BTPN Automatic Shifting')

@section('content')
    @include('partials.navbar', [
        'actions' => auth()->user()->isAdmin() ? [
            [
                'label' => 'HAPUS',
                'route' => route('employee.delete')
            ]
        ] : []
    ])

    <main class="flex-grow py-6 sm:py-8 flex items-center justify-center">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="overflow-hidden">
                <x-employee-shift-filter
                    :search="$search"
                    :start-date="$startDate"
                    :end-date="$endDate"
                    :shift-type="$shiftType"
                    :per-page="$perPage"
                    :per-page-options="$perPageOptions"
                />

                @if(session('success'))
                    <div class="p-4 bg-green-50 border-b border-green-200 text-green-600">
                        {{ session('success') }}
                    </div>
                @endif

                <x-employee-shift-table :shift-rows="$shiftRows" />
            </div>
        </div>
    </main>

    @include('partials.footer')
@endsection

@push('styles')
<style>
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
