<x-default-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6 gap-12">
                <h2 class="text-2xl font-semibold text-gray-800">Detail Pengiriman Barang</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('pengiriman-barang.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">
                        Kembali
                    </a>
                    <a href="{{ route('pengiriman-barang.edit', $pengirimanBarang->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                        Edit
                    </a>
                    <form action="{{ route('pengiriman-barang.destroy', $pengirimanBarang->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengiriman ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            <!-- Data Pengiriman -->
            <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pengiriman</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">ID Pengiriman</p>
                        <p class="text-lg font-medium">#{{ $pengirimanBarang->id }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Pengiriman</p>
                        <p class="text-lg font-medium">{{ $pengirimanBarang->tanggal_pengiriman->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Gudang</p>
                        <p class="text-lg font-medium">{{ $pengirimanBarang->gudang?->nama_gudang ?? 'Tidak ada' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Kurir</p>
                        <p class="text-lg font-medium">{{ $pengirimanBarang->kurir?->nama_kurir ?? 'Tidak ada' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Toko Tujuan</p>
                        <p class="text-lg font-medium">{{ $pengirimanBarang->toko?->nama_toko ?? 'Tidak ada' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Status Pengiriman</p>
                        <p class="itext-lg font-medium">
                            {{ $pengirimanBarang->statusPengiriman?->nama_status ?? 'Tidak ada' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Detail Barang</h3>
                    <a href="{{ route('pengiriman-barang.detail.create', $pengirimanBarang->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        + Tambah Barang
                    </a>
                </div>
                
                @if($pengirimanBarang->detailPengirimanBarangs->isEmpty())
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <p class="text-gray-500">Belum ada detail barang.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pengirimanBarang->detailPengirimanBarangs as $index => $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $detail->barang?->nama_barang ?? 'Tidak ada' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($detail->jumlah) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('pengiriman-barang.detail.show', $detail->id) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                                <a href="{{ route('pengiriman-barang.detail.edit', $detail->id) }}" class="text-green-600 hover:text-green-900">Edit</a>
                                                <form action="{{ route('pengiriman-barang.detail.destroy', $detail->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-default-layout>