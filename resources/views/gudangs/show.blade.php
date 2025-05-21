<x-default-layout>
    <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Gudang</h1>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">ID</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $gudang->id }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nama Gudang</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $gudang->nama_gudang_toko }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $gudang->alamat }}</dd>
                </div>
            </dl>
        </div>

        <div class="flex justify-start">
            <a href="{{ route('gudang.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                &larr; Kembali ke Daftar Gudang
            </a>
        </div>
    </div>
</x-default-layout>
