@section('page-title', 'Aktivitas Gudang')
@section('page-subtitle', 'Pengiriman Barang')

<x-default-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">

            {{-- ✅ Pesan Feedback --}}
            @if (session('success'))
                <div class="mb-4 text-green-700 bg-green-100 border border-green-300 px-4 py-3 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 text-red-700 bg-red-100 border border-red-300 px-4 py-3 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6 gap-12">
                <h2 class="text-2xl font-bold text-gray-800">{{ $title ?? 'Daftar Pengiriman Barang' }}</h2>

                @if(auth()->user()->hasRole('Admin', 'Staff'))
                    <a href="{{ route('pengiriman-barang.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Tambah Pengiriman
                    </a>
                @endif
            </div>

            @if($pusatKeCabang->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">Belum ada data pengiriman barang.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <livewire:pusat-ke-cabang-table />
                </div>
            @endif
        </div>
    </div>
</x-default-layout>
