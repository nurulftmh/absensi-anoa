<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-green-950">
                Data Manuscript Karyawan
            </h1>
            <p class="text-gray-500 mt-1">
                Lihat seluruh manuscript yang diunggah oleh karyawan.
            </p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-green-950 text-white">
                        <tr>
                            <th class="p-4 text-left">Foto</th>
                            <th class="p-4 text-left">Karyawan</th>
                            <th class="p-4 text-left">Penulis</th>
                            <th class="p-4 text-left">Judul</th>
                            <th class="p-4 text-left">Jurnal</th>
                            <th class="p-4 text-left">Status</th>
                            <th class="p-4 text-left">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($manuscripts as $item)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="p-4">
                                    @if($item->photo)
                                        <div class="flex flex-col items-start gap-2">
                                            <img src="{{ asset('storage/' . $item->photo) }}"
                                                 class="w-20 h-20 object-cover rounded-xl border cursor-pointer"
                                                 onclick="openImage('{{ asset('storage/' . $item->photo) }}')">

                                            <button type="button"
                                                    onclick="openImage('{{ asset('storage/' . $item->photo) }}')"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded-lg">
                                                Lihat
                                            </button>
                                        </div>
                                    @else
                                        <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 text-xs">
                                            No Image
                                        </div>
                                    @endif
                                </td>

                                <td class="p-4 text-gray-700">
                                    {{ $item->user->name ?? '-' }}
                                </td>

                                <td class="p-4 font-semibold text-gray-800">
                                    {{ $item->author_name }}
                                </td>

                                <td class="p-4 text-gray-700 max-w-md">
                                    {{ $item->title }}
                                </td>

                                <td class="p-4 text-gray-700">
                                    {{ $item->journal }}
                                </td>

                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        {{ $item->status }}
                                    </span>
                                </td>

                                <td class="p-4 text-gray-600">
                                    {{ $item->description ?? '-' }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-6 text-center text-gray-500">
                                    Belum ada data manuscript yang diunggah karyawan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- MODAL PREVIEW FOTO -->
    <div id="imageModal"
         class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50 p-6">

        <div class="relative max-w-5xl w-full flex justify-center">

            <button type="button"
                    onclick="closeImage()"
                    class="absolute top-0 right-0 -mt-10 text-white text-4xl font-bold hover:text-red-400">
                &times;
            </button>

            <img id="previewImage"
                 src=""
                 class="max-h-[90vh] rounded-2xl shadow-2xl border-4 border-white">
        </div>
    </div>

    <script>
        function openImage(src) {
            document.getElementById('previewImage').src = src;

            const modal = document.getElementById('imageModal');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeImage() {
            const modal = document.getElementById('imageModal');

            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.getElementById('previewImage').src = '';
        }
    </script>
</x-app-layout>