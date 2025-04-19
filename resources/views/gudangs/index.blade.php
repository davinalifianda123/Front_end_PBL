<x-default-layout>
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Gudang</h1>
            <a href="{{ route('gudangs.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded transition duration-300">
                Tambah Gudang Baru
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if ($gudangs->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left font-semibold text-gray-600">ID</th>
                            <th class="py-3 px-4 text-left font-semibold text-gray-600">Nama Gudang</th>
                            <th class="py-3 px-4 text-left font-semibold text-gray-600">Alamat</th>
                            <th class="py-3 px-4 text-left font-semibold text-gray-600">Status</th>
                            <th class="py-3 px-4 text-center font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gudangs as $gudang)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $gudang->id }}</td>
                                <td class="py-3 px-4">{{ $gudang->nama_gudang }}</td>
                                <td class="py-3 px-4">{{ $gudang->alamat }}</td>
                                <td class="py-3 px-4">                                            
                                    @if ($gudang->flag == 1)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Aktif</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('gudangs.show', $gudang->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white text-sm py-1 px-3 rounded transition duration-300">
                                            Detail
                                        </a>
                                        <a href="{{ route('gudangs.edit', $gudang->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm py-1 px-3 rounded transition duration-300">
                                            Edit
                                        </a>
                                        @if ($gudang->flag == 1)
                                            <form action="{{ route('gudangs.deactivate', $gudang->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan gudang ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm py-1 px-3 rounded transition duration-300 w-30">
                                                    Nonaktifkan
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('gudangs.activate', $gudang->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengaktifkan gudang ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-sm py-1 px-3 rounded transition duration-300 w-30">
                                                    Aktifkan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $gudangs->links() }}
            </div>
        @else
            <div class="bg-yellow-100 rounded-lg p-4 text-yellow-700">
                Belum ada data gudang. Silakan tambahkan gudang baru.
            </div>
        @endif
    </div>
</x-default-layout>