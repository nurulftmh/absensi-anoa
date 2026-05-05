<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-green-950">Dashboard Admin</h1>
            <p class="text-gray-500 mt-1">
                Kelola absensi, izin, progres kerja, dan user karyawan PT Anoa Sejahtera Mandiri.
            </p>
        </div>

        <!-- MAIN MENU -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

            <!-- ABSENSI -->
            <a href="{{ route('admin.attendance.index') }}"
               class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition">
                <div class="w-12 h-12 bg-green-100 text-green-800 rounded-xl flex items-center justify-center mb-4 text-xl font-bold">
                    ✓
                </div>

                <h2 class="text-lg font-bold text-gray-800">Data Absensi</h2>
                <p class="text-gray-500 mt-2 text-sm">
                    Lihat seluruh data hadir, izin, dan alpa karyawan.
                </p>

                <span class="inline-block mt-5 text-green-800 font-semibold">
                    Lihat Absensi →
                </span>
            </a>

            <!-- IZIN -->
            <a href="{{ route('admin.leave.index') }}"
               class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition">
                <div class="w-12 h-12 bg-yellow-100 text-yellow-700 rounded-xl flex items-center justify-center mb-4 text-xl font-bold">
                    !
                </div>

                <h2 class="text-lg font-bold text-gray-800">Pengajuan Izin</h2>
                <p class="text-gray-500 mt-2 text-sm">
                    Setujui atau tolak pengajuan izin dari karyawan.
                </p>

                <span class="inline-block mt-5 text-yellow-700 font-semibold">
                    Kelola Izin →
                </span>
            </a>

            <!-- PROGRES -->
            <a href="{{ route('admin.progress.index') }}"
               class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition">
                <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-xl flex items-center justify-center mb-4 text-xl font-bold">
                    ↑
                </div>

                <h2 class="text-lg font-bold text-gray-800">Progres Kerja</h2>
                <p class="text-gray-500 mt-2 text-sm">
                    Pantau progres kerja dan file yang diunggah karyawan.
                </p>

                <span class="inline-block mt-5 text-blue-700 font-semibold">
                    Lihat Progres →
                </span>
            </a>

            <!-- USER MANAGEMENT -->
            <a href="{{ route('admin.users.index') }}"
               class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition">
                <div class="w-12 h-12 bg-purple-100 text-purple-700 rounded-xl flex items-center justify-center mb-4 text-xl font-bold">
                    👤
                </div>

                <h2 class="text-lg font-bold text-gray-800">Kelola karyawan</h2>
                <p class="text-gray-500 mt-2 text-sm">
                    Ubah role user menjadi admin atau hapus akun user.
                </p>

                <span class="inline-block mt-5 text-purple-700 font-semibold">
                    Kelola Karyawan →
                </span>
            </a>

        </div>

        <!-- BOTTOM SECTION -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- COMPANY INFO -->
            <div class="lg:col-span-2 bg-gradient-to-r from-green-950 to-green-800 text-white rounded-3xl p-8 shadow">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo.png') }}" class="w-16 h-16 object-contain bg-white rounded-2xl p-2">
                    <div>
                        <h2 class="text-2xl font-bold">PT Anoa Sejahtera Mandiri</h2>
                        <p class="text-green-100 text-sm mt-1">
                            Sistem Absensi & Manajemen Kerja
                        </p>
                    </div>
                </div>

                <p class="text-green-100 mt-6 max-w-2xl">
                    Dashboard ini membantu admin memantau kehadiran, izin, alpa, progres kerja, dan pengelolaan user secara lebih rapi, cepat, dan transparan.
                </p>
            </div>

            <!-- QUICK MENU -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-4">Menu Cepat</h3>

                <div class="space-y-3">
                    <a href="{{ route('admin.attendance.index') }}"
                       class="block p-4 rounded-xl bg-gray-50 hover:bg-green-50 transition">
                        Data Absensi
                    </a>

                    <a href="{{ route('admin.leave.index') }}"
                       class="block p-4 rounded-xl bg-gray-50 hover:bg-yellow-50 transition">
                        Pengajuan Izin
                    </a>

                    <a href="{{ route('admin.progress.index') }}"
                       class="block p-4 rounded-xl bg-gray-50 hover:bg-blue-50 transition">
                        Progres Kerja
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                       class="block p-4 rounded-xl bg-gray-50 hover:bg-purple-50 transition">
                        Kelola User
                    </a>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>