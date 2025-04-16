<x-default-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Edit Detail Pengiriman Barang</h1>
                        <a href="{{ route('pengiriman-barang.show', $detailPengirimanBarang->id_pengiriman_barang) }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Kembali</a>
                    </div>
    
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-600">Info Pengiriman</h3>
                        <p class="text-gray-600">Pengiriman ID: {{ $detailPengirimanBarang->id_pengiriman_barang }}</p>
                        <p class="text-gray-600">Tanggal: {{ \Carbon\Carbon::parse($detailPengirimanBarang->pengirimanBarang->tanggal_pengiriman)->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <form action="{{ route('detail-pengiriman-barang.update', $detailPengirimanBarang->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="id_barang" class="block text-sm font-medium text-gray-700 mb-1">Barang</label>
                                <select name="id_barang" id="id_barang" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Pilih Barang</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}" {{ $detailPengirimanBarang->id_barang == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->nama_barang ?? $barang->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_barang')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" value="{{ $detailPengirimanBarang->jumlah }}" min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('jumlah')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-8">
                            <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>