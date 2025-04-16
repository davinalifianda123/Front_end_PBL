<x-default-layout>
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Detail Status Pengiriman</h2>
            <div class="flex space-x-2">
                <a href="{{ route('status-pengiriman.edit', $statusPengiriman->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">
                    Edit
                </a>
                <form action="{{ route('status-pengiriman.destroy', $statusPengiriman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus status ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <dt class="text-sm font-medium text-gray-500">ID</dt>
                    <dd class="mt-1 text-lg font-medium text-gray-900">{{ $statusPengiriman->id }}</dd>
                </div>
                
                <div class="mb-4">
                    <dt class="text-sm font-medium text-gray-500">Nama Status</dt>
                    <dd class="mt-1 text-lg font-medium text-gray-900">{{ $statusPengiriman->nama_status }}</dd>
                </div>
                
                <div class="mb-4">
                    <dt class="text-sm font-medium text-gray-500">Flag</dt>
                    <dd class="mt-1 text-lg font-medium text-gray-900">{{ $statusPengiriman->flag }}</dd>
                </div>
                
                <div class="mb-4">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Dibuat</dt>
                    <dd class="mt-1 text-lg font-medium text-gray-900">{{ $statusPengiriman->created_at->format('d M Y H:i:s') }}</dd>
                </div>
                
                <div class="mb-4 md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate</dt>
                    <dd class="mt-1 text-lg font-medium text-gray-900">{{ $statusPengiriman->updated_at->format('d M Y H:i:s') }}</dd>
                </div>
            </dl>
        </div>

        <div class="mt-6">
            <a href="{{ route('status-pengiriman.index') }}" class="text-blue-500 hover:text-blue-700">
                &larr; Kembali ke daftar status pengiriman
            </a>
        </div>
    </div>
</x-default-layout>