<x-app-layout>
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">Data Absensi</h1>

        <table class="w-full border bg-white">
            <thead>
                <tr>
                    <th class="border p-2">Nama</th>
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Masuk</th>
                    <th class="border p-2">Pulang</th>
                    <th class="border p-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $item)
                    <tr>
                        <td class="border p-2">{{ $item->user->name }}</td>
                        <td class="border p-2">{{ $item->date }}</td>
                        <td class="border p-2">{{ $item->check_in ?? '-' }}</td>
                        <td class="border p-2">{{ $item->check_out ?? '-' }}</td>
                        <td class="border p-2">{{ strtoupper($item->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>