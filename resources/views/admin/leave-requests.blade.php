<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-green-950">Pengajuan Izin</h1>
            <p class="text-gray-500 mt-1">Kelola pengajuan izin karyawan.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-2xl mb-5">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-green-950 text-white">
                        <tr>
                            <th class="p-4 text-left">Nama</th>
                            <th class="p-4 text-left">Tanggal</th>
                            <th class="p-4 text-left">Alasan</th>
                            <th class="p-4 text-left">Bukti</th>
                            <th class="p-4 text-left">Status</th>
                            <th class="p-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($requests as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-semibold text-gray-800">{{ $item->user->name }}</td>
                                <td class="p-4 text-gray-600">{{ $item->date }}</td>
                                <td class="p-4 text-gray-600">{{ $item->reason }}</td>
                                <td class="p-4">
                                    @if($item->proof_file)
                                        <a href="{{ asset('storage/' . $item->proof_file) }}"
                                           target="_blank"
                                           class="text-blue-700 font-semibold">
                                            Lihat File
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if($item->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">PENDING</span>
                                    @elseif($item->status == 'approved')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">APPROVED</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">REJECTED</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if($item->status == 'pending')
                                        <div class="flex gap-2">
                                            <form action="{{ route('admin.leave.approve', $item->id) }}" method="POST">
                                                @csrf
                                                <button class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-xl text-sm">
                                                    Setujui
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.leave.reject', $item->id) }}" method="POST">
                                                @csrf
                                                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-gray-500">
                                    Belum ada pengajuan izin.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>