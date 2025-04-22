<x-default-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6 gap-12">
                @php
                    $title = '';

                    if (auth()->user()->hasRole('Buyer')) {
                        $title = 'Orderan saya';
                    } else {
                        $title = 'Pengiriman Barang';
                    }
                @endphp
                <h2 class="text-2xl font-semibold text-gray-800">{{ $title }}</h2>
                @if(auth()->user()->hasRole('Admin', 'Staff'))
                    <a href="{{ route('pengiriman-barang.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Tambah Pengiriman
                    </a>
                @endif
            </div>

            @if($pengirimanBarangs->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">Belum ada data pengiriman barang.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asal Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan Pengiriman</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kurir</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Item</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pengirimanBarangs as $index => $pengirimanBarang)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $pengirimanBarangs->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $pengirimanBarang->tanggal_pengiriman->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $pengirimanBarang->lokasiAsal->gudang->nama_gudang ?? $pengirimanBarang->lokasiAsal->toko->nama_toko ?? 'Tidak ada' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $pengirimanBarang->lokasiTujuan->gudang->nama_gudang ?? $pengirimanBarang->lokasiTujuan->toko->nama_toko ?? 'Tidak ada' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $pengirimanBarang->kurir->nama_kurir ?? 'Tidak ada' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ $pengirimanBarang->statusPengiriman?->nama_status ?? 'Tidak ada' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $pengirimanBarang->detailPengirimanBarangs->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('pengiriman-barang.show', $pengirimanBarang->id) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                            @if(auth()->user()->hasRole('Admin', 'Staff'))
                                                <a href="{{ route('pengiriman-barang.edit', $pengirimanBarang->id) }}" class="text-green-600 hover:text-green-900">Edit</a>
                                                <form action="{{ route('pengiriman-barang.destroy', $pengirimanBarang->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengiriman ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
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
                    {{ $pengirimanBarangs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-default-layout>