@props([
    'search' => '',
    'startDate' => '',
    'endDate' => '',
    'shiftType' => '',
    'perPage' => 10,
    'perPageOptions' => [10, 25, 50, 100]
])

<div class="pb-4 border-b border-gray-200">
    <form action="{{ route('employee.onboarding') }}" method="GET" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text"
                       name="search"
                       id="search"
                       value="{{ $search }}"
                       placeholder="Cari NIK atau nama..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1">
            </div>

            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date"
                       name="start_date"
                       id="start_date"
                       value="{{ $startDate }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1">
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date"
                       name="end_date"
                       id="end_date"
                       value="{{ $endDate }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1">
            </div>

            <div>
                <label for="shift_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Shift</label>
                <select name="shift_type"
                        id="shift_type"
                        class="w-full px-3 py-2 border bg-white border-gray-300 rounded-md focus:outline-none focus:ring-1">
                    <option value="">Semua</option>
                    <option value="WFO" {{ $shiftType === 'WFO' ? 'selected' : '' }}>WFO</option>
                    <option value="WFH" {{ $shiftType === 'WFH' ? 'selected' : '' }}>WFH</option>
                </select>
            </div>
        </div>

        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <label for="per_page" class="text-sm text-gray-600">Show:</label>
                <select id="per_page"
                        name="per_page"
                        class="min-w-[240px] bg-white border border-gray-300 rounded-md text-sm py-1 px-2 focus:outline-none focus:ring-1">
                    @foreach($perPageOptions as $option)
                        <option value="{{ $option }}" {{ $perPage == $option ? 'selected' : '' }}>
                            {{ $option }} entries
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                    class="px-4 py-2 bg-green-500 text-white rounded-md text-sm font-medium hover:bg-green-600 focus:outline-none focus:ring-1">
                Filter
            </button>
        </div>
    </form>
</div>
