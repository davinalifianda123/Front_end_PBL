<x-default-layout>
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6 gap-12">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Kategori Barang</h1>
            @if(auth()->check() && auth()->user()->hasRole('SuperAdmin'))
                <a href="{{ route('categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                    Tambah Kategori
                </a>
            @endif
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
    
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                @if(!$categories->isEmpty())
                <tbody class="divide-y divide-gray-200">
                    @foreach($categories as $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category->nama_kategori_barang }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            @if ($category->flag == 1)
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Aktif</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            <a href="{{ route('categories.show', $category->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                            @if(auth()->check() && auth()->user()->hasRole('SuperAdmin'))
                                <a href="{{ route('categories.edit', $category->id) }}" class="text-amber-600 hover:text-amber-900">Edit</a>
                                @if ($category->flag == 1)
                                    <form action="{{ route('categories.deactivate', $category->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menonaktifkan kategori ini?')">Nonaktifkan</button>
                                    </form>
                                @else
                                    <form action="{{ route('categories.activate', $category->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Apakah Anda yakin ingin mengaktifkan kategori ini?')">Aktifkan</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @endif
            </table>
        </div>

        @if($categories->isEmpty())
        <div class="text-center py-8">
            <p class="text-gray-500">Tidak ada data kategori barang.</p>
        </div>
        @endif
    </div>
</x-default-layout>