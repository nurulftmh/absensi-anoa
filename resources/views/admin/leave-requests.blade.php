<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto">

        <h1 class="text-2xl font-bold mb-4">Pengajuan Izin Karyawan</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border bg-white">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Nama</th>
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Alasan</th>
                    <th class="border p-2">Bukti</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $item)
                    <tr>
                        <td class="border p-2">{{ $item->user->name }}</td>
                        <td class="border p-2">{{ $item->date }}</td>
                        <td class="border p-2">{{ $item->reason }}</td>
                        <td class="border p-2">
                            @if($item->proof_file)
                                <a href="{{ asset('storage/' . $item->proof_file) }}" target="_blank">
                                    Lihat File
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="border p-2">{{ strtoupper($item->status) }}</td>
                        <td class="border p-2">
                            @if($item->status == 'pending')
                                <form action="{{ route('admin.leave.approve', $item->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button class="bg-green-600 text-white px-3 py-1 rounded">Setujui</button>
                                </form>

                                <form action="{{ route('admin.leave.reject', $item->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button class="bg-red-600 text-white px-3 py-1 rounded">Tolak</button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>