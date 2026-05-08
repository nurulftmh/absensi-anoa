<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-green-950">Progres Kerja</h1>
            <p class="text-gray-500 mt-1">
                Pantau laporan kerja, file, dan waktu pembaruan progres karyawan.
            </p>
        </div>

        @if($progress->count() == 0)
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-5 rounded-2xl">
                Belum ada progres kerja yang masuk.
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($progress as $item)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition">

                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="font-bold text-gray-800">
                                {{ $item->attendance->user->name ?? 'User tidak ditemukan' }}
                            </h2>

                            <div class="text-sm text-gray-500 mt-1 space-y-1">
                                <p>
                                    Diunggah:
                                    {{ $item->created_at->format('d-m-Y H:i') }}
                                </p>

                                <p>
                                    Terakhir diedit:
                                    {{ $item->updated_at->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        </div>

                        <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                            Progres
                        </span>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 text-gray-700 text-sm leading-relaxed">
                        {{ $item->description }}
                    </div>

                    <div class="mt-4">
                        <p class="font-semibold text-gray-700 mb-2">Lampiran File</p>

                        @if($item->files && $item->files->count())
                            <div class="space-y-2">
                                @foreach($item->files as $file)
                                    <a href="{{ asset('storage/' . $file->file_path) }}"
                                       target="_blank"
                                       class="flex items-center justify-between bg-green-50 text-green-800 px-4 py-2 rounded-xl hover:bg-green-100 transition">
                                        <span class="truncate">📎 {{ $file->file_name }}</span>
                                        <span class="text-xs">Buka →</span>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-400 text-sm">Tidak ada file.</p>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>