<x-default-layout>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Detail Supplier</h1>
            <div class="space-x-2">
                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded">
                    Edit
                </a>
                <a href="{{ route('suppliers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium px-4 py-2 rounded">
                    Kembali
                </a>
            </div>
        </div>

        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border-b md:border-b-0 md:border-r pb-4 md:pb-0 md:pr-4">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Informasi Toko</h2>
                    
                    <div class="mb-4">
                        <span class="block text-gray-500 text-sm">Nama Toko</span>
                        <span class="block text-lg font-medium">{{ $supplier->nama_toko_supplier }}</span>
                    </div>
                    
                    <div class="mb-4">
                        <span class="block text-gray-500 text-sm">Alamat</span>
                        <span class="block text-lg">{{ $supplier->alamat }}</span>
                    </div>
                    
                    <div class="mb-4">
                        <span class="block text-gray-500 text-sm">Terdaftar Pada</span>
                        <span class="block text-lg">{{ $supplier->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
                
                <div class="pt-4 md:pt-0 md:pl-4">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Kontak</h2>
                    
                    <div class="mb-4">
                        <span class="block text-gray-500 text-sm">Contact Person</span>
                        <span class="block text-lg font-medium">{{ $supplier->contact_person }}</span>
                    </div>
                    
                    <div class="mb-4">
                        <span class="block text-gray-500 text-sm">Nomor Telepon</span>
                        <span class="block text-lg">{{ $supplier->no_telepon }}</span>
                    </div>
                    
                    <div class="mb-4">
                        <span class="block text-gray-500 text-sm">Email</span>
                        <span class="block text-lg">{{ $supplier->email }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>