<x-default-layout>
    <div class="py-12">
        <div class="w-2xl max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Daftar Role</h2>
                        <a href="{{ route('roles.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                            Tambah Role Baru
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Nama Role</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @foreach ($roles as $role)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 text-left">{{ $role->id }}</td>
                                        <td class="py-3 px-6 text-left">{{ $role->nama_role }}</td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center gap-4">
                                                <a href="{{ route('roles.show', $role->id) }}" class="text-blue-500 hover:text-blue-900">
                                                    Detail
                                                </a>
                                                <a href="{{ route('roles.edit', $role->id) }}" class="text-yellow-500 hover:text-amber-900">
                                                    Edit
                                                </a>
                                                {{-- <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-900 cursor-pointer" onclick="return confirm('Apakah Anda yakin ingin menghapus role ini?')">
                                                        Delete
                                                    </button>
                                                </form> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                
                                @if($roles->isEmpty())
                                    <tr>
                                        <td colspan="5" class="py-6 px-6 text-center text-gray-500">Tidak ada data role yang tersedia</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>