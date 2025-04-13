<x-default-layout>
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Kategori Barang</h1>
            <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-800">Kembali ke daftar</a>
        </div>
    
        <div class="bg-gray-50 p-4 rounded-md mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">ID Kategori</h3>
                    <p class="mt-1 text-lg">{{ $category->id }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Nama Kategori</h3>
                    <p class="mt-1 text-lg font-medium">{{ $category->nama_kategori }}</p>
                </div>
            </div>
        </div>
    
        <div class="flex space-x-2">
            <a href="{{ route('categories.edit', $category->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white py-2 px-4 rounded-md">
                Edit Kategori
            </a>
            
            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                    Hapus Kategori
                </button>
            </form>
        </div>
    </div>
</x-default-layout>