<x-default-layout>
    <div class="bg-white rounded-lg shadow-md m-6">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Penerimaan Barang</h1>
        </div>
        
        <div class="p-6">
            <form action="{{ route('penerimaan-barang.store') }}" method="POST" id="penerimaanForm">
                @csrf
                
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3">Informasi Penerimaan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="id_supplier" class="block mb-2 text-sm font-medium text-gray-700">Supplier</label>
                            <select id="id_supplier" name="id_supplier" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="">Pilih Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('id_supplier') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama_toko_supplier}}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_supplier')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="id_gudang" class="block mb-2 text-sm font-medium text-gray-700">Gudang</label>
                            <select id="id_gudang" name="id_gudang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="">Pilih Gudang</option>
                                @foreach($gudangs as $gudang)
                                    <option value="{{ $gudang->id }}" {{ old('id_gudang') == $gudang->id ? 'selected' : '' }}>
                                        {{ $gudang->nama_gudang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_gudang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="tanggal_penerimaan" class="block mb-2 text-sm font-medium text-gray-700">Tanggal Penerimaan</label>
                            <input type="datetime-local" id="tanggal_penerimaan" name="tanggal_penerimaan" value="{{ old('tanggal_penerimaan') ?? now()->format('Y-m-d\TH:i') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            @error('tanggal_penerimaan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-lg font-semibold text-gray-700">Detail Barang</h2>
                        <button type="button" id="addBarangButton" class="bg-green-600 hover:bg-green-700 text-white font-medium py-1 px-3 rounded text-sm">
                            + Tambah Barang
                        </button>
                    </div>
                    
                    <div id="detailBarangContainer">
                        <div class="detail-barang-item bg-gray-50 p-4 rounded-lg mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Barang</label>
                                    <select name="barang_id[]" class="barang-select bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
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
                                    <input type="number" name="jumlah[]" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" min="1" required>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Harga Beli</label>
                                    <input type="text" name="harga_beli[]" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                            </div>
                            
                            <div class="mt-3 text-right">
                                <button type="button" class="remove-item bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-3 rounded text-sm" disabled>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 border-t pt-6 flex justify-end">
                    <a href="{{ route('penerimaan-barang.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded mr-2">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Template for new detail barang item -->
    <template id="detailBarangTemplate">
        <div class="detail-barang-item bg-gray-50 p-4 rounded-lg mb-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Barang</label>
                    <select name="barang_id[]" class="barang-select bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
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
                    <input type="number" name="jumlah[]" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" min="1" required>
                </div>
                
                {{-- <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Satuan</label>
                    <input type="text" name="satuan[]" class="satuan-display bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" readonly>
                </div> --}}

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Harga Beli</label>
                    <input type="text" name="harga_beli[]" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
            </div>
            
            <div class="mt-3 text-right">
                <button type="button" class="remove-item bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-3 rounded text-sm">
                    Hapus
                </button>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addBarangButton = document.getElementById('addBarangButton');
            const detailBarangContainer = document.getElementById('detailBarangContainer');
            const detailBarangTemplate = document.getElementById('detailBarangTemplate');
            
            // Initialize handlers for the first item
            initBarangSelectHandlers(document.querySelector('.detail-barang-item'));
            updateRemoveButtonState();
            
            // Add new barang item
            addBarangButton.addEventListener('click', function() {
                const newItem = detailBarangTemplate.content.cloneNode(true);
                detailBarangContainer.appendChild(newItem);
                
                const lastItem = detailBarangContainer.lastElementChild;
                initBarangSelectHandlers(lastItem);
                updateRemoveButtonState();
            });
            
            // Event delegation for remove buttons
            detailBarangContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-item')) {
                    const item = event.target.closest('.detail-barang-item');
                    item.remove();
                    updateRemoveButtonState();
                }
            });
            
            // Initialize select handlers for newly created items
            function initBarangSelectHandlers(item) {
                const select = item.querySelector('.barang-select');
                const satuanDisplay = item.querySelector('.satuan-display');
                
                select.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    satuanDisplay.value = selectedOption.dataset.satuan || '';
                });
            }
            
            // Update state of remove buttons - disable if only one item remains
            function updateRemoveButtonState() {
                const items = document.querySelectorAll('.detail-barang-item');
                const isDisabled = items.length <= 1;
                
                items.forEach(item => {
                    item.querySelector('.remove-item').disabled = isDisabled;
                });
            }
        });
    </script>
</x-default-layout>