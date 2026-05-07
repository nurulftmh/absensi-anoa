@php
    use Illuminate\Support\Str;
@endphp
<x-app-layout>

<div class="p-6 max-w-7xl mx-auto">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-green-950">
            Manajemen Manuscript
        </h1>

        <p class="text-gray-500 mt-1">
            Input dan kelola data manuscript karyawan.
        </p>
        
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 mb-8">

        <h2 class="text-xl font-bold mb-4 text-gray-800">
            Tambah Manuscript
        </h2>

        <form action="{{ route('manuscripts.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-700">
                        Nama Penulis
                    </label>

                    <input type="text"
                           name="author_name"
                           class="w-full rounded-xl border-gray-200"
                           required>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-700">
                        Jurnal
                    </label>

                    <input type="text"
                           name="journal"
                           class="w-full rounded-xl border-gray-200"
                           required>
                </div>

            </div>

            <div class="mt-4">
                <label class="block mb-1 font-medium text-sm text-gray-700">
                    Judul Manuscript
                </label>

                <textarea name="title"
                          rows="3"
                          class="w-full rounded-xl border-gray-200"
                          required></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-700">
                        Status
                    </label>

                    <select name="status"
                            class="w-full rounded-xl border-gray-200">

                        <option value="On Progress">On Progress</option>
                        <option value="Draft">Draft</option>
                        <option value="Submitted">Submitted</option>
                        <option value="Under Review">Under Review</option>
                        <option value="Accepted">Accepted</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Published">Published</option>

                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-700">
                        Keterangan
                    </label>

                    <input type="text"
                           name="description"
                           class="w-full rounded-xl border-gray-200">
                </div>

            </div>

            <div class="mt-4">
                <label class="block mb-1 font-medium text-sm text-gray-700">
                    Upload Foto
                </label>

                <input type="file"
                       name="photo"
                       class="w-full rounded-xl border-gray-200">
            </div>

            <button class="mt-5 bg-green-800 hover:bg-green-900 text-white px-5 py-3 rounded-xl font-semibold transition">
                Simpan Manuscript
            </button>

        </form>

    </div>
    

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
<form action="{{ route('admin.manuscripts.index') }}" method="GET" class="mt-5">
    <div class="flex flex-col md:flex-row gap-3">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari karyawan, penulis, judul, jurnal, status, atau keterangan..."
               class="w-full rounded-2xl border-gray-200 shadow-sm focus:border-green-700 focus:ring-green-700">

        <button type="submit"
                class="bg-green-800 hover:bg-green-900 text-white px-6 py-3 rounded-2xl font-semibold transition">
            Cari
        </button>

        @if(request('search'))
            <a href="{{ route('admin.manuscripts.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-2xl font-semibold transition text-center">
                Reset
            </a>
        @endif
    </div>
</form>
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-green-950 text-white">
                    <tr>
                        <th class="p-4 text-left">Foto</th>
                        <th class="p-4 text-left">Penulis</th>
                        <th class="p-4 text-left">Judul</th>
                        <th class="p-4 text-left">Jurnal</th>
                        <th class="p-4 text-left">Status</th>
                        <th class="p-4 text-left">Keterangan</th>
                        <th class="p-4 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($manuscripts as $item)

                        <tr class="hover:bg-gray-50 transition">

                            <!-- FOTO -->
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

                            <!-- PENULIS -->
                            <td class="p-4 font-semibold text-gray-800">
                                {{ $item->author_name }}
                            </td>

                            <!-- JUDUL -->
                            <td class="p-4 text-gray-700 max-w-md">
                                {{ $item->title }}
                            </td>

                            <!-- JURNAL -->
                           <td class="p-4 text-gray-700">

    @if(Str::startsWith($item->journal, ['http://', 'https://']))

        <a href="{{ $item->journal }}"
           target="_blank"
           class="text-blue-600 hover:text-blue-800 underline font-medium">
            Buka Jurnal
        </a>

    @else

        {{ $item->journal }}

    @endif

</td>

                            <!-- STATUS -->
                            <td class="p-4">

                                @if($item->status == 'On Progress')

                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700 border border-indigo-200 shadow-sm">
                                        🚧 On Progress
                                    </span>

                                @elseif($item->status == 'Draft')

                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200 shadow-sm">
                                        📝 Draft
                                    </span>

                                @elseif($item->status == 'Submitted')

                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200 shadow-sm">
                                        📤 Submitted
                                    </span>

                                @elseif($item->status == 'Under Review')

                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 border border-yellow-200 shadow-sm">
                                        🔍 Under Review
                                    </span>

                                @elseif($item->status == 'Accepted')

                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200 shadow-sm">
                                        ✅ Accepted
                                    </span>

                                @elseif($item->status == 'Rejected')

                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200 shadow-sm">
                                        ❌ Rejected
                                    </span>

                                @elseif($item->status == 'Published')

                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 border border-purple-200 shadow-sm">
                                        🚀 Published
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200 shadow-sm">
                                        {{ $item->status }}
                                    </span>

                                @endif

                            </td>

                            <!-- KETERANGAN -->
                            <td class="p-4 text-gray-600">
                                {{ $item->description ?? '-' }}
                            </td>

                            <!-- AKSI -->
                            <td class="p-4">

                                <div class="flex gap-2 flex-wrap">

                                    <button onclick="document.getElementById('edit-{{ $item->id }}').classList.toggle('hidden')"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-xl text-sm">
                                        Edit
                                    </button>

                                    <form action="{{ route('manuscripts.destroy', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-xl text-sm">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        <!-- FORM EDIT -->
                        <tr id="edit-{{ $item->id }}" class="hidden bg-gray-50">

                            <td colspan="7" class="p-5">

                                <form action="{{ route('manuscripts.update', $item->id) }}"
                                      method="POST"
                                      enctype="multipart/form-data">

                                    @csrf
                                    @method('PATCH')

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                        <input type="text"
                                               name="author_name"
                                               value="{{ $item->author_name }}"
                                               class="rounded-xl border-gray-200">

                                        <input type="text"
                                               name="journal"
                                               value="{{ $item->journal }}"
                                               class="rounded-xl border-gray-200">

                                    </div>

                                    <textarea name="title"
                                              rows="3"
                                              class="w-full rounded-xl border-gray-200 mt-4">{{ $item->title }}</textarea>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

                                        <select name="status"
                                                class="rounded-xl border-gray-200">

                                            <option value="On Progress" {{ $item->status == 'On Progress' ? 'selected' : '' }}>On Progress</option>
                                            <option value="Draft" {{ $item->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="Submitted" {{ $item->status == 'Submitted' ? 'selected' : '' }}>Submitted</option>
                                            <option value="Under Review" {{ $item->status == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                                            <option value="Accepted" {{ $item->status == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                                            <option value="Rejected" {{ $item->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                            <option value="Published" {{ $item->status == 'Published' ? 'selected' : '' }}>Published</option>

                                        </select>

                                        <input type="text"
                                               name="description"
                                               value="{{ $item->description }}"
                                               class="rounded-xl border-gray-200">

                                    </div>

                                    <div class="mt-4">

                                        <label class="block mb-2 text-sm font-medium text-gray-700">
                                            Ganti Foto
                                        </label>

                                        <input type="file"
                                               name="photo"
                                               class="rounded-xl border-gray-200">

                                    </div>

                                    <button class="mt-4 bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 rounded-xl">
                                        Update
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-500">
                                Belum ada data manuscript.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
            <div class="p-6">
    {{ $manuscripts->links() }}
</div>

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