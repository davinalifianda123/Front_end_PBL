<x-default-layout>
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Detail Barang</h1>
        </div>
        
        <div class="p-6">
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            
            <form action="{{ route('penerimaan-barang.store-detail', $penerimaanBarang->id) }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="barang_id" class="block mb-2 text-sm font-medium text-gray-700">Barang</label>
                        <select id="barang_id" name="barang_id" class="barang-select bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <option value="">Pilih Barang</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}" data-satuan="{{ $barang->satuan }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                    {{ $barang->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-700">Jumlah</label>
                        <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" min="1" required>
                        @error('jumlah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="harga_beli" class="block mb-2 text-sm font-medium text-gray-700">Harga Beli</label>
                        <input type="text" id="harga_beli" name="harga_beli" value="{{ old('harga_beli') }}" class="harga_beli-display border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        @error('harga_beli')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end">
                    <a href="{{ route('penerimaan-barang.show', $penerimaanBarang->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded mr-2">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const barangSelect = document.getElementById('barang_id');
            const satuanDisplay = document.getElementById('satuan');
            
            barangSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                satuanDisplay.value = selectedOption.dataset.satuan || '';
            });
            
            // Set initial value if selected
            if (barangSelect.selectedIndex > 0) {
                const selectedOption = barangSelect.options[barangSelect.selectedIndex];
                satuanDisplay.value = selectedOption.dataset.satuan || '';
            }
        });
    </script>
</x-default-layout>