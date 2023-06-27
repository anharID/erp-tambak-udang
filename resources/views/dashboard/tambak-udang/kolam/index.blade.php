<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">

            {{-- Alert --}}
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <h1 class="mb-4 font-bold text-xl">Informasi Siklus</h1>
            <div class="w-full md:w-1/2 p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if ($siklusAktif)
                <p>Tanggal mulai : {{ $siklusAktif->tanggal_mulai }}</p>
                <p>DOC : {{ $doc }}</p>
                <p>Jumlah kolam aktif: {{ $siklusAktif->kolam->count() }}</p>
                <p class="mb-4">Total Tebar : {{ $siklusAktif->kolam->sum('pivot.jumlah_tebar') }}</p>
                <div class="mt-4 flex items-center justify-center">
                    <a href="{{ route('edit_siklus', ['siklus'=>$siklusAktif->id]) }}"
                        class="mr-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit Siklus
                    </a>
                    <form action="{{ route('tutup_siklus', ['siklus' => $siklusAktif->id]) }}" method="POST">
                        @csrf
                        @method('put')
                        <button type="submit"
                            class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded "
                            onclick="return confirm('Apakah Anda yakin ingin menutup siklus saat ini?')">Tutup
                            Siklus</button>
                    </form>
                </div>
                @else
                <p class="text-sm italic mb-4">Saat ini tidak ada siklus yang berjalan. Untuk memulai siklus
                    silahkan klik mulai siklus
                    dibawah.</p>
                <a href="{{ route('buat_siklus') }}"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                    Mulai Siklus
                </a>
                @endif
            </div>


            <h1 class="my-4 font-bold text-xl">Daftar Kolam Udang</h1>
            <div class="w-full p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">


                {{-- Tombol tambah kolam --}}
                <a href="{{ route('kolam.create') }}"
                    class="px-4 mr-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                    Tambah Kolam
                </a>

                <div class="w-full overflow-x-auto mt-4">
                    <table class="min-w-full table-auto mt-4 datatable hover">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nama</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Lokasi</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tipe</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Luas</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Kedalaman</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                            @foreach($kolam as $row)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><a
                                        href="{{ $row->siklus->count() > 0 ? route('data_kolam', ['kolam'=>$row->id, 'siklus'=>$row->siklus->last()->id]) : route('kolam.show', $row->id) }}">{{
                                        $row->nama }}</a></td>

                                <td class="px-6 py-4 whitespace-nowrap">{{ $row->lokasi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $row->tipe }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $row->luas }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $row->kedalaman }}</td>
                                @if ($row->status)
                                <td class="px-6 py-4 whitespace-nowrap "><span
                                        class="px-1 py-1 rounded-md bg-green-200 dark:bg-green-600 text-sm">Aktif</span>
                                </td>
                                @else
                                <td class="px-6 py-4 whitespace-nowrap"><span
                                        class="px-1 py-1 rounded-md bg-red-200 dark:bg-red-500 text-sm">Tidak
                                        Aktif</span></td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap flex">
                                    <a href="{{ route('kolam.edit', $row->id) }}" class="text-yellow-600 mr-4"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="{{ route('kolam.destroy', $row->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Aksi ini tidak dapat dibatalkan! Apakah Anda yakin ingin menghapus kolam ini? ')"
                                            class="text-red-600"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-admin>