<x-default-layout>
    <div class="bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center p-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Penerimaan Barang</h1>
            <a href="{{ route('penerimaan-barang.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Penerimaan
            </a>
        </div>

        @if (session('success'))
            <div class="mx-4 p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mx-4 p-4 mb-4 text-red-700 bg-red-100 border-l-4 border-red-500 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="px-6">
            <form action="{{ route('penerimaan-barang.index') }}" method="GET">
                <div class="flex mb-4">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" name="search" value="{{ request('search') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Cari berdasarkan supplier, gudang, atau tanggal...">
                    </div>
                    <button type="submit" class="ml-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('penerimaan-barang.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        <div class="overflow-x-auto px-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gudang</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Penerimaan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Item</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($penerimaanBarangs as $penerimaan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $penerimaan->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $penerimaan->supplier ? $penerimaan->supplier->nama_toko_supplier : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $penerimaan->gudang ? $penerimaan->gudang->nama_gudang : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $penerimaan->tanggal_penerimaan ? $penerimaan->tanggal_penerimaan->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $penerimaan->detailPenerimaanBarang->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-4">
                                    <a href="{{ route('penerimaan-barang.show', $penerimaan) }}" class="text-green-600 hover:text-green-900">Detail</a>
                                    <a href="{{ route('penerimaan-barang.edit', $penerimaan) }}" class="text-amber-600 hover:text-amber-900">Edit</a>
                                    <form action="{{ route('penerimaan-barang.destroy', $penerimaan) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus data ini dan semua detailnya?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4">
            {{ $penerimaanBarangs->withQueryString()->links() }}
        </div>
    </div>
</x-default-layout>