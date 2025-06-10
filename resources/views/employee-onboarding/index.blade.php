@extends('layouts.app')

@section('title', 'Employee Onboarding - Bank BTPN Automatic Shifting')

@section('content')
    @include('partials.navbar')

    <main class="flex-grow py-6 sm:py-8 flex items-center justify-center">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="bg-white overflow-hidden">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center space-x-2">
                        <label for="per_page" class="text-sm text-gray-600">Show:</label>
                        <select id="per_page" name="per_page" class="border border-gray-300 rounded-md text-sm py-1 px-2 focus:outline-none focus:ring-1 focus:ring-green-500" onchange="window.location.href='{{ request()->url() }}?per_page=' + this.value">
                            @foreach($perPageOptions as $option)
                                <option value="{{ $option }}" {{ $perPage == $option ? 'selected' : '' }}>
                                    {{ $option }} entries
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border border-gray-300">
                        <thead>
                            <tr>
                                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                                    NIK
                                </th>
                                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                                    Name
                                </th>
                                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                                    Gender
                                </th>
                                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                                    Religion
                                </th>
                                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                                    Location
                                </th>
                                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                                    Created At
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        {{ $employee->nik }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        {{ $employee->name }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        {{ $employee->gender->value }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        {{ $employee->religion }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        {{ $employee->location->value }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        {{ $employee->created_at->format('d M Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-2 text-center text-sm text-gray-500 border border-gray-300">
                                        No onboarding employees found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="py-4">
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
@endsection
