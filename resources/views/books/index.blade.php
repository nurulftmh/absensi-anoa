<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto">

        {{-- HEADER --}}
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-green-950">
                Manajemen Buku
            </h1>

            <p class="text-gray-500 mt-1">
                Input dan kelola data buku dengan tampilan yang lebih rapi dan modern.
            </p>
        </div>

        {{-- ALERT --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-2xl mb-5 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl mb-5 shadow-sm">
                <ul class="list-disc ms-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM TAMBAH COMPACT --}}
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 mb-8">

    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-lg font-bold text-gray-800">
                Tambah Buku
            </h2>

            <p class="text-xs text-gray-500 mt-1">
                Tambahkan data buku secara lebih ringkas dan rapi.
            </p>
        </div>

        <div class="hidden md:flex w-11 h-11 rounded-2xl bg-orange-100 text-orange-700 items-center justify-center text-xl">
            📚
        </div>
    </div>

    <form action="{{ route('books.store') }}" method="POST">
        @csrf

        {{-- ROW 1 --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

            {{-- TANGGAL --}}
            <div>
                <label class="block mb-1.5 font-semibold text-xs text-gray-600">
                    Tanggal
                </label>

                <input type="date"
                       name="entry_date"
                       class="w-full rounded-xl border-gray-200 text-sm py-2.5 focus:border-orange-500 focus:ring-orange-500"
                       required>
            </div>

            {{-- PENULIS --}}
            <div>
                <label class="block mb-1.5 font-semibold text-xs text-gray-600">
                    Penulis
                </label>

                <input type="text"
                       name="author_name"
                       placeholder="Nama penulis"
                       class="w-full rounded-xl border-gray-200 text-sm py-2.5 focus:border-orange-500 focus:ring-orange-500"
                       required>
            </div>

            {{-- STATUS --}}
            <div>
                <label class="block mb-1.5 font-semibold text-xs text-gray-600">
                    Status
                </label>

                <select name="status"
                        class="w-full rounded-xl border-gray-200 text-sm py-2.5 focus:border-orange-500 focus:ring-orange-500"
                        required>

                    <option value="On Progress">On Progress</option>
                    <option value="Draft">Draft</option>
                    <option value="Pending">Pending</option>
                    <option value="Selesai">Selesai</option>

                </select>
            </div>

            {{-- CATATAN --}}
            <div>
                <label class="block mb-1.5 font-semibold text-xs text-gray-600">
                    Catatan
                </label>

                <input type="text"
                       name="note"
                       placeholder="Catatan singkat"
                       class="w-full rounded-xl border-gray-200 text-sm py-2.5 focus:border-orange-500 focus:ring-orange-500">
            </div>

        </div>

        {{-- JUDUL --}}
        <div class="mt-3">
            <label class="block mb-1.5 font-semibold text-xs text-gray-600">
                Judul Buku
            </label>

            <textarea name="title"
                      rows="2"
                      placeholder="Masukkan judul buku"
                      class="w-full rounded-xl border-gray-200 text-sm py-2.5 focus:border-orange-500 focus:ring-orange-500"
                      required></textarea>
        </div>

        {{-- BUTTON --}}
        <div class="mt-4 flex justify-end">
            <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition">
                Simpan Buku
            </button>
        </div>

    </form>
</div>
        {{-- SEARCH --}}
        <div class="mb-5">
            <form action="{{ route('books.index') }}" method="GET">

                <div class="flex flex-col md:flex-row gap-3">

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari penulis, judul, status, atau catatan..."
                           class="w-full rounded-2xl border-gray-200 shadow-sm focus:border-green-700 focus:ring-green-700">

                    <button class="bg-green-800 hover:bg-green-900 text-white px-6 py-3 rounded-2xl font-semibold shadow-sm">
                        Cari
                    </button>

                    @if(request('search'))
                        <a href="{{ route('books.index') }}"
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-2xl font-semibold text-center">
                            Reset
                        </a>
                    @endif

                </div>

            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-green-950 text-white">
                        <tr>
                            <th class="p-4 text-left">Tanggal Masuk</th>
                            <th class="p-4 text-left">Penulis</th>
                            <th class="p-4 text-left">Judul Buku</th>
                            <th class="p-4 text-left">Status</th>
                            <th class="p-4 text-left">Catatan</th>
                            <th class="p-4 text-left">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($books as $book)

                            <tr class="hover:bg-gray-50 transition">

                                {{-- TANGGAL --}}
                                <td class="p-4 text-gray-700">
                                    {{ \Carbon\Carbon::parse($book->entry_date)->format('d-m-Y') }}
                                </td>

                                {{-- PENULIS --}}
                                <td class="p-4 font-semibold text-gray-800">
                                    {{ $book->author_name }}
                                </td>

                                {{-- JUDUL --}}
                                <td class="p-4 text-gray-700 max-w-md">
                                    {{ $book->title }}
                                </td>

                                {{-- STATUS --}}
                                <td class="p-4">

                                    @if($book->status == 'On Progress')

                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            ✍️ On Progress
                                        </span>

                                    @elseif($book->status == 'Draft')

                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            📝 Draft
                                        </span>

                                    @elseif($book->status == 'Pending')

                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            🚧 Pending
                                        </span>

                                    @elseif($book->status == 'Selesai')

                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            ✅ Selesai
                                        </span>

                                    @else

                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ $book->status }}
                                        </span>

                                    @endif

                                </td>

                                {{-- CATATAN --}}
                                <td class="p-4 text-gray-600">
                                    {{ $book->note ?? '-' }}
                                </td>

                                {{-- AKSI --}}
                                <td class="p-4">

                                    <div class="flex gap-2 flex-wrap">

                                        {{-- EDIT --}}
                                        <button type="button"
                                                onclick="document.getElementById('edit-book-{{ $book->id }}').classList.toggle('hidden')"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-xl text-sm shadow-sm">
                                            Edit
                                        </button>

                                        {{-- DELETE --}}
                                        <form action="{{ route('books.destroy', $book->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data buku ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-xl text-sm shadow-sm">
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                            {{-- FORM EDIT --}}
                            <tr id="edit-book-{{ $book->id }}" class="hidden bg-gray-50">

                                <td colspan="6" class="p-5">

                                    <form action="{{ route('books.update', $book->id) }}" method="POST">

                                        @csrf
                                        @method('PATCH')

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                            <input type="date"
                                                   name="entry_date"
                                                   value="{{ $book->entry_date }}"
                                                   class="rounded-2xl border-gray-200">

                                            <input type="text"
                                                   name="author_name"
                                                   value="{{ $book->author_name }}"
                                                   class="rounded-2xl border-gray-200">

                                        </div>

                                        <textarea name="title"
                                                  rows="3"
                                                  class="w-full rounded-2xl border-gray-200 mt-4">{{ $book->title }}</textarea>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

                                            {{-- STATUS --}}
                                            <select name="status"
                                                    class="rounded-2xl border-gray-200">

                                                <option value="On Progress"
                                                    {{ $book->status == 'On Progress' ? 'selected' : '' }}>
                                                    On Progress
                                                </option>

                                                <option value="Draft"
                                                    {{ $book->status == 'Draft' ? 'selected' : '' }}>
                                                    Draft
                                                </option>

                                                <option value="Pending"
                                                    {{ $book->status == 'Pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>

                                                <option value="Selesai"
                                                    {{ $book->status == 'Selesai' ? 'selected' : '' }}>
                                                    Selesai
                                                </option>

                                            </select>

                                            {{-- NOTE --}}
                                            <input type="text"
                                                   name="note"
                                                   value="{{ $book->note }}"
                                                   class="rounded-2xl border-gray-200">

                                        </div>

                                        {{-- BUTTON --}}
                                        <button class="mt-4 bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 rounded-2xl shadow-sm">
                                            Update
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="p-10 text-center text-gray-500">

                                    <div class="flex flex-col items-center">

                                        <div class="text-5xl mb-3">
                                            📚
                                        </div>

                                        <p class="font-semibold">
                                            Belum ada data buku.
                                        </p>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

                {{-- PAGINATION --}}
                <div class="p-6 border-t border-gray-100">
                    {{ $books->links() }}
                </div>

            </div>

        </div>

    </div>
</x-app-layout>