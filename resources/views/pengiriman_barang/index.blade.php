<x-default-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6 gap-12">
                @php
                    $title = '';

                    if (auth()->user()->hasRole('Buyer')) {
                        $title = 'Orderan saya';
                    } else {
                        $title = 'Pengiriman Barang';
                    }
                @endphp
                <h2 class="text-2xl font-semibold text-gray-800">{{ $title }}</h2>
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