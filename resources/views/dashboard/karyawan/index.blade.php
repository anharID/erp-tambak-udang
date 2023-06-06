<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
            <h1 class="mb-4 font-bold text-xl">Manajemen Karyawan</h1>
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w- full p-6 overflow-hidden">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Success</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <a href="{{ route('karyawan.create') }}"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Tambah Karyawan
                    </a>
                    <div class="w-full mt-4">
                        <table class="w-full table-auto mt-4 datatable hover">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Alamat</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tempat Lahir</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal Lahir</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Nomor HP</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Jabatan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Gaji</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                @foreach ($karyawan as $row)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->nama }}</td>
                                        <td class="px-6 py-4">{{ $row->alamat }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->tempat_lahir }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->tanggal_lahir }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->no_hp }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->jabatan }}</td>
                                        @if ($row->status)
                                            <td class="px-6 py-4 whitespace-nowrap">Bekerja</td>
                                        @else
                                            <td class="px-6 py-4 whitespace-nowrap">Cuti</td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ 'Rp ' . number_format($row->gaji, 2, ',', '.') }}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('karyawan.edit', $row->id) }}"
                                                class="text-yellow-600">Edit</a>
                                            <form action="{{ route('karyawan.destroy', $row->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"
                                                    class="text-red-600">Hapus Data</button>
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
