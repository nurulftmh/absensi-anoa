<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto">
        <h1 class="text-xl font-bold mb-4">Progres Kerja</h1>

        @if($progress->count() == 0)
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
                Belum ada progres kerja yang masuk.
            </div>
        @endif

        @foreach($progress as $item)
            <div class="bg-white p-4 mb-4 rounded shadow">
                <p>
                    <strong>Nama:</strong>
                    {{ $item->attendance->user->name ?? 'User tidak ditemukan' }}
                </p>

                <p>
                    <strong>Tanggal:</strong>
                    {{ $item->created_at->format('d-m-Y H:i') }}
                </p>

                <p class="mt-2">
                    <strong>Deskripsi:</strong><br>
                    {{ $item->description }}
                </p>

                @if($item->files && $item->files->count())
                    <div class="mt-3">
                        <p class="font-semibold">File:</p>

                        @foreach($item->files as $file)
                            <a href="{{ asset('storage/' . $file->file_path) }}"
                               target="_blank"
                               class="text-blue-600 block">
                                {{ $file->file_name }}
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 mt-2">Tidak ada file.</p>
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>