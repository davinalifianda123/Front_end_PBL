<x-default-layout>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg m-6">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                    Daftar Barang
                </h2>
            </div>
            @if(auth()->check() && auth()->user()->hasRole('Admin'))
                <div>
                    <a href="{{ route('barangs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Tambah Barang
                    </a>
                </div>
            @endif
        </div>

        <div class="px-4 py-5 sm:px-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            
            <div class="border-t border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Barang
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kategori
                                </th>
                                @if(auth()->check())
                                    @if(auth()->user()->gudang || auth()->user()->hasRole('Admin'))
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Gudang
                                        </th>
                                    @endif
                                    @if(auth()->user()->toko || auth()->user()->hasRole('Admin'))
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Toko
                                        </th>
                                    @endif
                                @endif
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stok
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Berat
                                </th>
                                @if(auth()->check() && !auth()->user()->hasRole('Supplier') && !auth()->user()->hasRole('Buyer'))
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($barangs as $barang)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $barang->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $barang->nama_barang }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $barang->kategori->nama_kategori_barang ?? 'N/A' }}
                                </td>
                                @if(auth()->check())
                                    @if(auth()->user()->gudang || auth()->user()->hasRole('Admin'))
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $barang->gudang->nama_gudang ?? '-' }}
                                        </td>
                                    @endif
                                    @if(auth()->user()->toko || auth()->user()->hasRole('Admin'))
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $barang->toko->nama_toko ?? '-' }}
                                        </td>
                                    @endif
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($barang->jumlah_stok) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($barang->berat) }}
                                </td>
                                @if(auth()->check() && !auth()->user()->hasRole('Supplier') && !auth()->user()->hasRole('Buyer'))
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium space-x-4">
                                        <a href="{{ route('barangs.show', $barang->id) }}" class="text-blue-600 hover:text-blue-900">
                                            Detail
                                        </a>
                                        @if(auth()->check() && auth()->user()->hasRole('Admin'))
                                            <a href="{{ route('barangs.edit', $barang->id) }}" class="text-amber-600 hover:text-amber-900">
                                                Edit
                                            </a>
                                            @if($barang->flag == 1)
                                                <form action="{{ route('barangs.deactivate', $barang->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    @php
                                                        $message = '';
                                                        if ($barang->childBarang && $barang->childBarang->count() > 0) {
                                                            $message = 'Barang ini memiliki data turunan. Apakah Anda yakin ingin menonaktifkan semua data ini?';
                                                            $shortMessage = 'Nonaktifkan semua';
                                                        } else {
                                                            $message = 'Apakah Anda yakin ingin menonaktifkan data ini?';
                                                            $shortMessage = 'Nonaktifkan';
                                                        }
                                                    @endphp
                                                    <button type="submit" onclick="return confirm(`{{ $message }}`)" class="text-red-600 hover:text-red-900">
                                                        {{ $shortMessage }}
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('barangs.activate', $barang->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    @php
                                                        $message = '';
                                                        $shortMessage = '';
                                                        if ($barang->childBarang && $barang->childBarang->count() > 0) {
                                                            $message = 'Barang ini memiliki data turunan. Apakah Anda yakin ingin mengaktifkan semua data ini?';
                                                            $shortMessage = 'Aktifkan semua';
                                                        } else {
                                                            $message = 'Apakah Anda yakin ingin mengaktifkan data ini?';
                                                            $shortMessage = 'Aktifkan';
                                                        }
                                                    @endphp
                                                    <button type="submit" onclick="return confirm(`{{ $message }}`)" class="text-green-600 hover:text-green-900">
                                                        {{ $shortMessage }}
                                                    </button>
                                                </form>   
                                            @endif
                                        @endif
                                    </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                @php
                                    $colspan = 0;
                                    if (auth()->check() && auth()->user()->hasRole('Admin', 'Supervisor', 'Buyer')) {
                                        $colspan = 9;
                                    } else {
                                        $colspan = 8;
                                    }
                                @endphp
                                <td colspan="{{ $colspan }}" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Tidak ada data barang
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                    {{ $barangs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-default-layout>