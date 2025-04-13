<x-default-layout>
    <div class="bg-white rounded-lg shadow-md p-6 w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Gudang Baru</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('gudangs.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nama_gudang" class="block text-gray-700 font-medium mb-2">Nama Gudang</label>
                <input type="text" name="nama_gudang" id="nama_gudang" value="{{ old('nama_gudang') }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required>
            </div>

            <div class="mb-6">
                <label for="lokasi" class="block text-gray-700 font-medium mb-2">Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('gudangs.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    &larr; Kembali
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded transition duration-300">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-default-layout>