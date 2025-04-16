<x-default-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Tambah Pengiriman Barang</h2>
            </div>

            @if (session('error'))
            <div class="p-4 mb-4 text-red-700 bg-red-100 border-l-4 border-red-500 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
            @endif
    
            <form action="{{ route('pengiriman-barang.store') }}" method="POST">
                @csrf
    
                <div class="space-y-6">
                    <!-- Data Pengiriman -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Data Pengiriman</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Gudang -->
                            <div>
                                <label for="id_gudang" class="block text-sm font-medium text-gray-700">Gudang</label>
                                <select id="id_gudang" name="id_gudang" class="p-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
    
                            <!-- Tanggal Pengiriman -->
                            <div>
                                <label for="tanggal_pengiriman" class="block text-sm font-medium text-gray-700">Tanggal Pengiriman</label>
                                <input type="datetime-local" id="tanggal_pengiriman" name="tanggal_pengiriman" value="{{ old('tanggal_pengiriman') ?? now() }}" 
                                    class="p-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('tanggal_pengiriman')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
    
                            <!-- Kurir -->
                            <div>
                                <label for="id_kurir" class="block text-sm font-medium text-gray-700">Kurir</label>
                                <select id="id_kurir" name="id_kurir" class="p-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Pilih Kurir</option>
                                    @foreach($kurirs as $kurir)
                                        <option value="{{ $kurir->id }}" {{ old('id_kurir') == $kurir->id ? 'selected' : '' }}>
                                            {{ $kurir->nama_kurir }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kurir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
    
                            <!-- Toko -->
                            <div>
                                <label for="id_toko" class="block text-sm font-medium text-gray-700">Toko</label>
                                <select id="id_toko" name="id_toko" class="p-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Pilih Toko</option>
                                    @foreach($tokos as $toko)
                                        <option value="{{ $toko->id }}" {{ old('id_toko') == $toko->id ? 'selected' : '' }}>
                                            {{ $toko->nama_toko }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_toko')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
    
                    <!-- Detail Barang -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Barang</h3>
                        
                        <div id="detail-barang-container">
                            <div class="detail-barang-item mb-4 p-4 border border-gray-200 rounded-md">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Barang -->
                                    <div>
                                        <label for="barang_id_0" class="block text-sm font-medium text-gray-700">Barang</label>
                                        <select id="barang_id_0" name="barang_id[]" class="p-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="">Pilih Barang</option>
                                            @foreach($barangs as $barang)
                                                <option value="{{ $barang->id }}">
                                                    {{ $barang->nama_barang }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
    
                                    <!-- Jumlah -->
                                    <div>
                                        <label for="jumlah_0" class="block text-sm font-medium text-gray-700">Jumlah</label>
                                        <input type="number" id="jumlah_0" name="jumlah[]" min="1" value="1" 
                                            class="p-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
    
                                    <!-- Hapus Button -->
                                    <div class="flex items-end">
                                        <button type="button" class="remove-detail-btn px-3 py-2 text-sm text-white bg-red-600 rounded-md hover:bg-red-700" style="display: none;">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="mt-2">
                            <button type="button" id="add-detail-btn" class="px-4 py-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-700">
                                + Tambah Barang
                            </button>
                        </div>
                        
                        @error('barang_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('jumlah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('pengiriman-barang.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let detailCounter = 1;
        const container = document.getElementById('detail-barang-container');
        const addButton = document.getElementById('add-detail-btn');
        
        // Handle add detail button click
        addButton.addEventListener('click', function() {
            const newDetail = document.createElement('div');
            newDetail.classList.add('detail-barang-item', 'mb-4', 'p-4', 'border', 'border-gray-200', 'rounded-md');
            
            newDetail.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Barang -->
                    <div>
                        <label for="barang_id_${detailCounter}" class="block text-sm font-medium text-gray-700">Barang</label>
                        <select id="barang_id_${detailCounter}" name="barang_id[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Pilih Barang</option>
                            ${Array.from(document.querySelectorAll('#barang_id_0 option')).map(opt => 
                                `<option value="${opt.value}">${opt.textContent}</option>`
                            ).join('')}
                        </select>
                    </div>
    
                    <!-- Jumlah -->
                    <div>
                        <label for="jumlah_${detailCounter}" class="block text-sm font-medium text-gray-700">Jumlah</label>
                        <input type="number" id="jumlah_${detailCounter}" name="jumlah[]" min="1" value="1" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
    
                    <!-- Hapus Button -->
                    <div class="flex items-end">
                        <button type="button" class="remove-detail-btn px-3 py-2 text-sm text-white bg-red-600 rounded-md hover:bg-red-700">
                            Hapus
                        </button>
                    </div>
                </div>
            `;
            
            container.appendChild(newDetail);
            detailCounter++;
            
            // Show remove button on first item if there's more than one item
            if (container.querySelectorAll('.detail-barang-item').length > 1) {
                const firstItemRemoveBtn = container.querySelector('.detail-barang-item:first-child .remove-detail-btn');
                if (firstItemRemoveBtn) {
                    firstItemRemoveBtn.style.display = 'block';
                }
            }
        });
        
        // Handle remove detail button click using event delegation
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-detail-btn')) {
                const detailItem = e.target.closest('.detail-barang-item');
                if (detailItem) {
                    detailItem.remove();
                    
                    // Hide remove button on first item if there's only one item left
                    if (container.querySelectorAll('.detail-barang-item').length === 1) {
                        const firstItemRemoveBtn = container.querySelector('.detail-barang-item:first-child .remove-detail-btn');
                        if (firstItemRemoveBtn) {
                            firstItemRemoveBtn.style.display = 'none';
                        }
                    }
                }
            }
        });
    });
    </script>
</x-default-layout>