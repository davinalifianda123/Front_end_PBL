<!-- resources/views/users/index.blade.php -->
<x-default-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Tombol Tambah Pengguna -->
                    <div class="mb-4">
                        <h2 class="text-xl font-semibold leading-tight text-gray-800 mb-8">
                            Manajemen Pengguna
                        </h2>
                        <a href="{{ route('users.create') }}" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 inline-block">
                            Tambah Pengguna Baru
                        </a>
                    </div>

                    <!-- Notifikasi -->
                    @if (session('success'))
                        <div class="p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-4 mb-4 text-red-700 bg-red-100 border-l-4 border-red-500 rounded-lg" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Filter dan Pencarian -->
                    <div class="mb-4">
                        <form action="{{ route('users.index') }}" method="GET" class="flex items-center space-x-4">
                            <div class="flex-1">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full px-4 py-2 border rounded">
                            </div>
                            <div>
                                <select name="role" class="px-4 py-2 border rounded">
                                    <option value="">Semua Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                                            {{ ucfirst($role->nama_role) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">
                                Filter
                            </button>
                            <a href="{{ route('users.index') }}" class="px-4 py-2 text-white bg-gray-300 rounded hover:bg-gray-400">
                                Reset
                            </a>
                        </form>
                    </div>

                    <!-- Tabel Pengguna -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Role
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $user->id }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                            {{ $user->nama }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ ucfirst($user->role->nama_role ?? 'Tidak ada role')  }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('users.show', $user->id) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('users.edit', $user->id) }}" class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-4 transform hover:text-red-500 hover:scale-110 transition" onclick="return confirm('Apakah Anda yakin ingin menghapus role ini?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                            Tidak ada data pengguna yang tersedia
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $users->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>