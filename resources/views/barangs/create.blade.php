<x-default-layout>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                Tambah Barang Baru
            </h2>
        </div>
    
        <div class="border-t border-gray-200">
            <form action="{{ route('barangs.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}" required 
                            class="py-2 px-3 border mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('nama_barang')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <div>
                        <label for="id_kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="id_kategori" id="id_kategori" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('id_kategori') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <div>
                        <label for="id_gudang" class="block text-sm font-medium text-gray-700">Gudang</label>
                        <select name="id_gudang" id="id_gudang" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
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
                        <label for="berat" class="block text-sm font-medium text-gray-700">Berat (gram)</label>
                        <input type="number" name="berat" id="berat" value="{{ old('berat') }}" required min="0"
                            class="py-2 px-3 border mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('berat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <div>
                        <label for="harga_jual" class="block text-sm font-medium text-gray-700">Harga Jual</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="harga_jual" id="harga_jual" value="{{ old('harga_jual') }}" required min="0"
                                class="py-2 px-3 border focus:ring-blue-500 focus:border-blue-500 block w-full pl-12 sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('harga_jual')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
    
                <div class="mt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('barangs.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>