<!-- resources/views/users/show.blade.php -->
<x-default-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Detail Pengguna') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">
                            &larr; Kembali ke Daftar Pengguna
                        </a>
                    </div>

                    <div class="p-4 mb-6 bg-gray-50 rounded-lg">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <h3 class="text-lg font-semibold">Informasi Pengguna</h3>
                                <div class="mt-2">
                                    <p><span class="font-medium">ID:</span> {{ $user->id }}</p>
                                    <p><span class="font-medium">Nama:</span> {{ $user->nama }}</p>
                                    <p><span class="font-medium">Email:</span> {{ $user->email }}</p>
                                    <p><span class="font-medium">Role:</span> {{ ucfirst($user->role->nama_role ?? 'Tidak ada role') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex mt-6">
                        <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 mr-2 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                            Edit Pengguna
                        </a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                Hapus Pengguna
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>