<x-default-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Tambah Role Baru</h2>
                    </div>

                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="nama_role" class="block text-sm font-medium text-gray-700 mb-2">Nama Role</label>
                            <input type="text" name="nama_role" id="nama_role" value="{{ old('nama_role') }}" 
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('nama_role') ? 'border-red-500' : 'border-gray-300' }}" 
                                placeholder="Masukkan nama role">
                            
                            @error('nama_role')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                                Kembali
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>