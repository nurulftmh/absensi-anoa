<x-app-layout>
    <div class="p-6 max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Dashboard User</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded shadow mb-6">
            <h2 class="text-lg font-semibold mb-3">Absensi Hari Ini</h2>

            @if(!$attendance)
                <form action="{{ route('attendance.checkin') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Masuk
                    </button>
                </form>
            @else
                <p class="mb-2">Jam Masuk: <strong>{{ $attendance->check_in ?? '-' }}</strong></p>
                <p class="mb-2">Jam Pulang: <strong>{{ $attendance->check_out ?? '-' }}</strong></p>
                <p>Status: <strong>{{ strtoupper($attendance->status) }}</strong></p>

                @if(!$attendance->check_out && $attendance->status === 'hadir')
                    <form action="{{ route('attendance.checkout') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">
                            Absen Pulang
                        </button>
                    </form>
                @endif
            @endif
        </div>

@if($attendance && $attendance->status === 'hadir')
<div class="bg-white p-6 rounded shadow mb-6">
    <h2 class="text-lg font-semibold mb-3">Progres Kerja</h2>

    <form action="{{ route('work.progress.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <textarea name="description" rows="4" class="w-full border rounded p-2 mb-3"
            placeholder="Deskripsi pekerjaan hari ini"></textarea>

        <input type="file" name="files[]" multiple class="mb-3">

        <br>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Simpan Progres
        </button>
    </form>
</div>
@endif

<div class="bg-white p-6 rounded shadow mb-6">
    <h2 class="text-lg font-semibold mb-3">Ajukan Izin</h2>

    <form action="{{ route('leave.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label class="block mb-1">Tanggal Izin</label>
        <input type="date" name="date" class="w-full border rounded p-2 mb-3">

        <label class="block mb-1">Alasan Izin</label>
        <textarea name="reason" rows="3" class="w-full border rounded p-2 mb-3"
            placeholder="Contoh: Sakit / keperluan keluarga"></textarea>

        <label class="block mb-1">Upload Bukti (opsional)</label>
        <input type="file" name="proof_file" class="mb-3">

        <br>

        <button class="bg-yellow-600 text-white px-4 py-2 rounded">
            Kirim Izin
        </button>
    </form>
</div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-3">Riwayat Absensi</h2>

            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Tanggal</th>
                        <th class="border p-2">Jam Masuk</th>
                        <th class="border p-2">Jam Pulang</th>
                        <th class="border p-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $item)
                        <tr>
                            <td class="border p-2">{{ $item->date }}</td>
                            <td class="border p-2">{{ $item->check_in ?? '-' }}</td>
                            <td class="border p-2">{{ $item->check_out ?? '-' }}</td>
                            <td class="border p-2">{{ strtoupper($item->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border p-2 text-center">
                                Belum ada data absensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>