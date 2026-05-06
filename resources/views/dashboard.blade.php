<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-green-950">Dashboard User</h1>
            <p class="text-gray-500 mt-1">
                Kelola absensi, progres kerja, dan pengajuan izin harian.
            </p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-2xl mb-5">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl mb-5">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl mb-5">
                <ul class="list-disc ms-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

            <div class="lg:col-span-2 bg-gradient-to-r from-green-950 to-green-800 text-white rounded-3xl p-8 shadow">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo.png') }}" class="w-16 h-16 object-contain bg-white rounded-2xl p-2">
                    <div>
                        <h2 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}</h2>
                        <p class="text-green-100 text-sm mt-1">PT Anoa Sejahtera Mandiri</p>
                    </div>
                </div>

                <p class="text-green-100 mt-6">
                    Pastikan absen masuk, isi progres kerja, dan lakukan absen pulang setelah 8 jam kerja.
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-4">Status Hari Ini</h3>

                @if(!$attendance)
                    <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm font-semibold">
                        Belum Absen
                    </span>
                @elseif($attendance->status == 'hadir')
                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                        HADIR
                    </span>
                @elseif($attendance->status == 'izin')
                    <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-semibold">
                        IZIN
                    </span>
                @else
                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold">
                        ALPA
                    </span>
                @endif

                <div class="mt-5 space-y-3 text-sm">
                    <div class="flex justify-between bg-gray-50 rounded-xl p-3">
                        <span class="text-gray-500">Jam Masuk</span>
                        <strong>{{ $attendance->check_in ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between bg-gray-50 rounded-xl p-3">
                        <span class="text-gray-500">Jam Pulang</span>
                        <strong>{{ $attendance->check_out ?? '-' }}</strong>
                    </div>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-2">Absensi Hari Ini</h2>
                <p class="text-gray-500 text-sm mb-5">
                    Lakukan absen masuk sebelum bekerja dan absen pulang setelah 8 jam kerja.
                </p>

                @if(!$attendance)
                    <form action="{{ route('attendance.checkin') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full bg-green-800 hover:bg-green-900 text-white font-semibold py-3 rounded-xl shadow transition">
                            Absen Masuk
                        </button>
                    </form>
                @else
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-green-50 rounded-2xl p-4">
                            <p class="text-sm text-gray-500">Jam Masuk</p>
                            <p class="text-xl font-bold text-green-900">{{ $attendance->check_in ?? '-' }}</p>
                        </div>
                        <div class="bg-red-50 rounded-2xl p-4">
                            <p class="text-sm text-gray-500">Jam Pulang</p>
                            <p class="text-xl font-bold text-red-700">{{ $attendance->check_out ?? '-' }}</p>
                        </div>
                    </div>

                    @if(!$attendance->check_out && $attendance->status === 'hadir')
                        <form action="{{ route('attendance.checkout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-xl shadow transition">
                                Absen Pulang
                            </button>
                        </form>
                    @else
                        <div class="bg-gray-50 text-gray-600 p-4 rounded-2xl text-sm">
                            Absensi hari ini sudah tercatat.
                        </div>
                    @endif
                @endif
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-2">Progres Kerja</h2>
                <p class="text-gray-500 text-sm mb-5">
                    Upload dan lihat riwayat progres kerja pada halaman khusus.
                </p>

                @if($attendance && $attendance->status === 'hadir')
                    <div class="bg-green-50 text-green-800 p-4 rounded-2xl text-sm mb-4">
                        Kamu sudah absen masuk hari ini. Form progres kerja sudah aktif.
                    </div>
                @else
                    <div class="bg-gray-50 text-gray-500 p-4 rounded-2xl text-sm mb-4">
                        Form progres kerja aktif setelah kamu melakukan absen masuk.
                    </div>
                @endif

                <a href="{{ route('work.progress.page') }}"
                   class="inline-block w-full text-center bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 rounded-xl shadow transition">
                    Buka Halaman Progres Kerja
                </a>

         <a href="{{ route('manuscripts.index') }}"
   class="block p-4 rounded-xl bg-gray-50 hover:bg-indigo-50 transition">
    Manajemen Manuscript
</a>


            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-2">Ajukan Izin</h2>
                <p class="text-gray-500 text-sm mb-5">
                    Kirim pengajuan izin kepada admin untuk diproses.
                </p>

                <form action="{{ route('leave.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Izin</label>
                    <input type="date" name="date"
                           class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-green-700 focus:ring-green-700 mb-4">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Izin</label>
                    <textarea name="reason" rows="4"
                              class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-green-700 focus:ring-green-700 mb-4"
                              placeholder="Contoh: Sakit / keperluan keluarga"></textarea>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Bukti</label>
                    <input type="file" name="proof_file"
                           class="w-full border border-gray-200 rounded-2xl p-3 text-sm mb-4">

                    <button class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-3 rounded-xl shadow transition">
                        Kirim Izin
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800">Riwayat Absensi</h2>
                    <p class="text-gray-500 text-sm mt-1">Data absensi terbaru kamu.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-green-950 text-white">
                            <tr>
                                <th class="p-4 text-left">Tanggal</th>
                                <th class="p-4 text-left">Masuk</th>
                                <th class="p-4 text-left">Pulang</th>
                                <th class="p-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($attendances as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 text-gray-700">{{ $item->date }}</td>
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
                                    <td colspan="4" class="p-6 text-center text-gray-500">
                                        Belum ada data absensi.
                                    </td>
                                </tr>
                            @endforelse

                   
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>