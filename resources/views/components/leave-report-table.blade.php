@props(['leaveRows'])

<div class="overflow-x-auto">
    <table class="min-w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    NIK
                </th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    Nama
                </th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    Jenis Kelamin
                </th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    Lokasi Kerja
                </th>
                <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    Tanggal Mulai
                </th>
                <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    Tanggal Selesai
                </th>
                <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    Tipe Cuti
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaveRows as $row)

                @php
                    $typeValue = $row['type'] ? (is_object($row['type']) ? $row['type']->value : $row['type']) : null;
                @endphp

                <tr class="hover:bg-gray-50 {{ !$row['has_leave'] ? 'bg-gray-100' : '' }}">
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                        {{ $row['nik'] }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                        {{ $row['name'] }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                        {{ is_object($row['gender']) ? $row['gender']->value : $row['gender'] }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                        {{ is_object($row['location']) ? $row['location']->value : $row['location'] }}
                    </td>
                    <td class="px-4 py-2 text-center text-sm border border-gray-300">
                        {{ $row['leave_start'] ?? '-' }}
                    </td>
                    <td class="px-4 py-2 text-center text-sm border border-gray-300">
                        {{ $row['leave_end'] ?? '-' }}
                    </td>
                    <td class="px-4 py-2 text-center text-sm border border-gray-300">
                        {{ $typeValue === 'yearly' ? 'Tahunan' : ($typeValue === 'special' ? 'Khusus' : '-') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-2 text-center text-sm text-gray-500 border border-gray-300">
                        Tidak ada data yang ditemukan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="py-3 border-t border-gray-200">
    {{ $leaveRows->appends(request()->query())->links() }}
</div>