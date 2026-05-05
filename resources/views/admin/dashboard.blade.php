<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            <!-- Absensi -->
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-lg font-semibold">Data Absensi</h2>
                <p class="text-gray-600 mt-2">Lihat seluruh absensi karyawan.</p>
                <a href="{{ route('admin.attendance.index') }}"
                   class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                    Lihat Absensi
                </a>
            </div>

            <!-- Izin -->
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-lg font-semibold">Pengajuan Izin</h2>
                <p class="text-gray-600 mt-2">Kelola izin karyawan.</p>
                <a href="{{ route('admin.leave.index') }}"
                   class="inline-block mt-4 bg-yellow-600 text-white px-4 py-2 rounded">
                    Lihat Izin
                </a>
            </div>

            <!-- Progres -->
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-lg font-semibold">Progres Kerja</h2>
                <p class="text-gray-600 mt-2">Pantau progres kerja karyawan.</p>
                <a href="{{ route('admin.progress.index') }}"
                   class="inline-block mt-4 bg-green-600 text-white px-4 py-2 rounded">
                    Lihat Progres
                </a>
            </div>

        </div>
    </div>
</x-app-layout>