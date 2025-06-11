@extends('layouts.app')

@section('title', 'Employee Onboarding - Bank BTPN Automatic Shifting')

@section('content')
    @include('partials.navbar', [
        'actions' => [
            [
                'label' => 'INPUT',
                'route' => route('employee.create')
            ],
            [
                'label' => 'DELETE',
                'route' => route('employee.delete')
            ]
        ]
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
