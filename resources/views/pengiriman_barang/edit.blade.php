<x-default-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Edit Pengiriman Barang</h1>
                        <a href="{{ route('pengiriman-barang.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Kembali</a>
                    </div>
    
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    <form action="{{ route('pengiriman-barang.update', $pengirimanBarang->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-8">
                            <h2 class="text-lg font-medium text-gray-700 mb-4">Informasi Pengiriman</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="id_gudang" class="block text-sm font-medium text-gray-700 mb-1">Gudang</label>
                                    <select name="id_gudang" id="id_gudang" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="">Pilih Gudang</option>
                                        @foreach($gudangs as $gudang)
                                            <option value="{{ $gudang->id }}" {{ $pengirimanBarang->id_gudang == $gudang->id ? 'selected' : '' }}>
                                                {{ $gudang->nama_gudang ?? $gudang->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_gudang')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="tanggal_pengiriman" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengiriman</label>
                                    <input type="datetime-local" name="tanggal_pengiriman" id="tanggal_pengiriman" value="{{ \Carbon\Carbon::parse($pengirimanBarang->tanggal_pengiriman)->format('Y-m-d\TH:i') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @error('tanggal_pengiriman')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="id_kurir" class="block text-sm font-medium text-gray-700 mb-1">Kurir</label>
                                    <select name="id_kurir" id="id_kurir" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="">Pilih Kurir</option>
                                        @foreach($kurirs as $kurir)
                                            <option value="{{ $kurir->id }}" {{ $pengirimanBarang->id_kurir == $kurir->id ? 'selected' : '' }}>
                                                {{ $kurir->nama_kurir ?? $kurir->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_kurir')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="id_toko" class="block text-sm font-medium text-gray-700 mb-1">Toko Tujuan</label>
                                    <select name="id_toko" id="id_toko" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="">Pilih Toko</option>
                                        @foreach($tokos as $toko)
                                            <option value="{{ $toko->id }}" {{ $pengirimanBarang->id_toko == $toko->id ? 'selected' : '' }}>
                                                {{ $toko->nama_toko ?? $toko->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_toko')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="id_status_pengiriman" class="block text-sm font-medium text-gray-700 mb-1">Status Pengiriman</label>
                                    <select name="id_status_pengiriman" id="id_status_pengiriman" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="">Pilih Status</option>
                                        @foreach($statusPengirimanBarangs as $status)
                                            <option value="{{ $status->id }}" {{ $pengirimanBarang->id_status_pengiriman == $status->id ? 'selected' : '' }}>
                                                {{ $status->nama_status ?? $status->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_status_pengiriman')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h2 class="text-lg font-medium text-gray-700 mb-4">Detail Barang</h2>
                            
                            <div id="detail-container">
                                @foreach($pengirimanBarang->detailPengirimanBarangs as $index => $detail)
                                    <div class="detail-item border border-gray-200 rounded p-4 mb-4">
                                        <input type="hidden" name="detail_id[]" value="{{ $detail->id }}">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Barang</label>
                                                <select name="barang_id[]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="">Pilih Barang</option>
                                                    @foreach($barangs as $barang)
                                                        <option value="{{ $barang->id }}" {{ $detail->id_barang == $barang->id ? 'selected' : '' }}>
                                                            {{ $barang->nama_barang ?? $barang->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                                                <input type="number" name="jumlah[]" value="{{ $detail->jumlah }}" min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            </div>
                                            <div class="flex items-end">
                                                <button type="button" class="remove-detail px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600 mt-4">Hapus</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4">
                                <button type="button" id="add-detail" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Tambah Detail Barang
                                </button>
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
    
    <template id="detail-template">
        <div class="detail-item border border-gray-200 rounded p-4 mb-4">
            <input type="hidden" name="detail_id[]" value="">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Barang</label>
                    <select name="barang_id[]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Pilih Barang</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}">{{ $barang->nama_barang ?? $barang->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" name="jumlah[]" value="1" min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="flex items-end">
                    <button type="button" class="remove-detail px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600 mt-4">Hapus</button>
                </div>
            </div>
        </div>
    </template>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addDetailBtn = document.getElementById('add-detail');
            const detailContainer = document.getElementById('detail-container');
            const detailTemplate = document.getElementById('detail-template').innerHTML;
    
            // Add new detail
            addDetailBtn.addEventListener('click', function() {
                detailContainer.insertAdjacentHTML('beforeend', detailTemplate);
                attachRemoveEvents();
            });
    
            // Remove detail
            function attachRemoveEvents() {
                document.querySelectorAll('.remove-detail').forEach(button => {
                    button.addEventListener('click', function() {
                        const detailItem = this.closest('.detail-item');
                        detailItem.remove();
                    });
                });
            }
    
            // Attach events to existing remove buttons
            attachRemoveEvents();
        });
    </script>
</x-default-layout>