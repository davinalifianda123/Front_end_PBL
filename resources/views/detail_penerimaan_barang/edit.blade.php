<x-default-layout>
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Edit Detail Penerimaan Barang</h1>
        </div>
        
        <div class="p-6">
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            
            <form action="{{ route('penerimaan-barang.update-detail', $detailPenerimaan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3">Informasi Penerimaan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Barang</label>
                            <select name="barang_id" class="barang-select bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="">Pilih Barang</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}" data-satuan="{{ $barang->satuan }}">
                                        {{ $barang->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="number" name="jumlah" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" min="1" required value="{{ $detailPenerimaan->jumlah }}">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Harga Beli</label>
                            <input type="text" name="harga_beli" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ $detailPenerimaan->harga_beli }}">
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 border-t pt-6 flex justify-end">
                    <a href="{{ URL::previous() }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded mr-2">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>