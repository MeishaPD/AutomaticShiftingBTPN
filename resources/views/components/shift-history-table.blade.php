@props(['shiftRows'])
<div class="overflow-x-auto">
    <table class="min-w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th scope="col"
                    class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    NIK
                </th>
                <th scope="col"
                    class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    Nama
                </th>
                <th scope="col"
                    class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    Jenis Kelamin
                </th>
                <th scope="col"
                    class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    Lokasi
                </th>
                <th scope="col"
                    class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    Tanggal Shift
                </th>
                <th scope="col"
                    class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    Tipe Shift
                </th>
                <th scope="col"
                    class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border border-gray-300 bg-green-500">
                    Status
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($shiftRows as $row)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                        {{ $row['nik'] }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                        {{ $row['name'] }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                        {{ $row['gender'] }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                        {{ $row['location'] }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                        {{ $row['shift_date'] }}
                    </td>
                    <td class="px-4 py-2 text-center text-sm border border-gray-300">
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $row['shift_type'] }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center text-sm border border-gray-300">
                        @php
                            $statusValue = is_object($row['status']) ? $row['status']->value : $row['status'];
                        @endphp
                        @if($statusValue === 'approved')
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Diterima
                            </span>
                        @elseif($statusValue === 'rejected')
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Ditolak
                            </span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                -
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-2 text-center text-sm text-gray-500 border border-gray-300">
                        Tidak ada data shift
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="py-3 border-t border-gray-200">
    {{ $shiftRows->appends(request()->query())->links() }}
</div>