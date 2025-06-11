@props(['shiftRows'])

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
                    Shift
                </th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    Tanggal
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($shiftRows as $row)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                        {{ $row['nik'] }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                        {{ $row['name'] }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                        {{ $row['gender']->value }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                        {{ $row['location']->value }}
                    </td>
                    <td class="px-4 py-2 text-center text-sm border border-gray-300">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $row['shift_type']->value === 'WFO' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ $row['shift_type']->value }}
                        </span>
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                        {{ \Carbon\Carbon::parse($row['shift_date'])->format('d M Y') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-2 text-center text-sm text-gray-500 border border-gray-300">
                        Tidak ada data shift karyawan onboarding.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="py-3 border-t border-gray-200">
    {{ $shiftRows->appends(request()->query())->links() }}
</div>
