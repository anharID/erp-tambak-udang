<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
            <h1 class="mb-4 font-bold text-2xl">Pakan Udang Kolam {{ $kolam->nama }}</h1>

            {{-- Kembali --}}
            <a href="{{ route('data_kolam', ['kolam'=>$kolam->id, 'siklus'=>$siklus->id]) }}"
                class="mr-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>

            @if ($siklusTerpilih)
            <div class="my-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-full p-6">

                    {{-- Alert --}}
                    @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Success</p>
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif

                    @if ($siklusBerjalan)
                    <a href="{{ route('pakan.create',  ['kolamId' => $kolam->id,'siklus'=>$siklus->id]) }}"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Tambah Catatan
                    </a>
                    @endif

                    <div class="w-full overflow-x-auto mt-4">
                        <table class="min-w-full table-auto mt-4 datatable">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Waktu</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Jenis Pakan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Jumlah (Kg)</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Catatan</th>
                                    @if ($siklusBerjalan)
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                @foreach($siklusTerpilih as $row)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->tanggal }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->waktu_pemberian }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->no_pakan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->jumlah_kg }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->catatan }}</td>
                                    @if ($siklusBerjalan)
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('monitoring.edit', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id, 'monitoring'=>$row->id]) }}"
                                            class="text-yellow-600">Edit</a>
                                        <form
                                            action="{{ route('monitoring.destroy', ['kolamId'=>$kolam->id,'siklus'=>$siklus->id,'monitoring'=>$row->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Aksi ini tidak dapat dibatalkan! Apakah Anda yakin ingin menghapus kolam ini? ')"
                                                class="text-red-600">Hapus Data</button>
                                        </form>

                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <h1>tidak ada siklus berjalan</h1>
            @endif
        </div>
    </div>
</x-admin>