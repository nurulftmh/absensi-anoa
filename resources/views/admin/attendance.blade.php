<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-green-950">Data Absensi</h1>
            <p class="text-gray-500 mt-1">Rekap kehadiran, izin, dan alpa karyawan.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-green-950 text-white">
                        <tr>
                            <th class="p-4 text-left">Nama</th>
                            <th class="p-4 text-left">Tanggal</th>
                            <th class="p-4 text-left">Masuk</th>
                            <th class="p-4 text-left">Pulang</th>
                            <th class="p-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($attendances as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-semibold text-gray-800">{{ $item->user->name }}</td>
                                <td class="p-4 text-gray-600">{{ $item->date }}</td>
                                <td class="p-4 text-gray-600">{{ $item->check_in ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $item->check_out ?? '-' }}</td>
                                <td class="p-4">
                                    @if($item->status == 'hadir')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">HADIR</span>
                                    @elseif($item->status == 'izin')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">IZIN</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">ALPA</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-500">
                                    Belum ada data absensi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>