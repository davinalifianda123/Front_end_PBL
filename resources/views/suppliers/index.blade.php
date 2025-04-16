<x-default-layout>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Supplier</h1>
            <a href="{{ route('suppliers.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded">
                Tambah Supplier
            </a>
        </div>

        <div class="overflow-x-auto p-4">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Toko</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Person</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($suppliers as $index => $supplier)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $supplier->nama_toko_supplier }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $supplier->contact_person }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $supplier->no_telepon }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $supplier->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('suppliers.show', $supplier->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data supplier</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-default-layout>