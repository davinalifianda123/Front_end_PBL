<x-default-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col gap-6">
                <div class="flex justify-between items-center gap-12">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                        Daftar Toko
                    </h2>
                    @if(auth()->check() && auth()->user()->hasRole('Admin'))
                        <a href="{{ route('tokos.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Tambah Toko
                        </a>
                    @endif
                </div>

                <div class="bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 text-left">ID</th>
                                    <th class="py-3 px-4 text-left">Nama Toko</th>
                                    <th class="py-3 px-4 text-left">Jenis Toko</th>
                                    <th class="py-3 px-4 text-left">Alamat</th>
                                    <th class="py-3 px-4 text-left">No. Telepon</th>
                                    <th class="py-3 px-4 text-left">Status</th>
                                    <th class="py-3 px-4 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tokos as $toko)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="py-3 px-4">{{ $toko->id }}</td>
                                        <td class="py-3 px-4">{{ $toko->nama_toko }}</td>
                                        <td class="py-3 px-4">{{ $toko->jenisToko->nama_jenis_toko ?? 'N/A' }}</td>
                                        <td class="py-3 px-4">{{ $toko->alamat }}</td>
                                        <td class="py-3 px-4">{{ $toko->no_telepon }}</td>
                                        <td class="py-3 px-4">
                                            @if ($toko->flag == 1)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Aktif</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('tokos.show', $toko) }}" class="text-blue-600 hover:text-blue-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                @if(auth()->check() && auth()->user()->hasRole('Admin'))
                                                    <a href="{{ route('tokos.edit', $toko) }}" class="text-yellow-600 hover:text-yellow-800">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    @if ($toko->flag == 1)
                                                        <form action="{{ route('tokos.deactivate', $toko) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan toko ini?');">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @else 
                                                        <form action="{{ route('tokos.activate', $toko) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin mengaktifkan toko ini?');">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="text-green-600 hover:text-green-800">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-3 px-4 text-center text-gray-500">Tidak ada data toko</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $tokos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>