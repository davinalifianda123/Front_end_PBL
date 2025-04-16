<x-default-layout>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Detail Barang Retur</h1>
        </div>
    
        <form action="{{ route('detail-retur-barang.store') }}" method="POST" class="p-4">
            @csrf
            <input type="hidden" name="id_retur" value="{{ $returId }}">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="id_barang" class="block text-sm font-medium text-gray-700 mb-1">Barang</label>
                    <select id="id_barang" name="id_barang" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('id_barang') border-red-500 @enderror">
                        <option value="">Pilih Barang</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}" {{ old('id_barang') == $barang->id ? 'selected' : '' }}>{{ $barang->nama_barang }}</option>
                        @endforeach
                    </select>
                    @error('id_barang')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
    
                <div>
                    <label for="jumlah_barang_retur" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Barang Retur</label>
                    <input type="number" id="jumlah_barang_retur" name="jumlah_barang_retur" min="1" value="{{ old('jumlah_barang_retur', 1) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('jumlah_barang_retur') border-red-500 @enderror">
                    @error('jumlah_barang_retur')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
    
            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ route('retur-barang.show', $returId) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Simpan Detail Barang</button>
            </div>
        </form>
    </div>
</x-default-layout>