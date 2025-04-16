<x-default-layout>
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Tambah Status Pengiriman Baru</h2>
            <p class="text-gray-600 mt-1">Silakan lengkapi form di bawah ini untuk membuat status pengiriman baru.</p>
        </div>

        <form action="{{ route('status-pengiriman.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="nama_status" class="block text-sm font-medium text-gray-700 mb-1">Nama Status</label>
                <input type="text" name="nama_status" id="nama_status" 
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('nama_status') ? 'border-red-500' : 'border-gray-300' }}" 
                    value="{{ old('nama_status') }}" required>
                
                @error('nama_status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-between">
                <a href="{{ route('status-pengiriman.index') }}" class="text-gray-600 hover:text-gray-800">
                    Kembali ke daftar
                </a>
                
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md">
                    Simpan Status
                </button>
            </div>
        </form>
    </div>
</x-default-layout>