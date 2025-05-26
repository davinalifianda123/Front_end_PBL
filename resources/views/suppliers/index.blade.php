@section('page-title', 'Management Supplier')
<x-default-layout>
    <div class="overflow-hidden">
        <div class="flex justify-between items-center px-6 py-4">
            <h1 class="text-2xl font-semibold text-gray-800">Daftar Supplier</h1>
            <a href="{{ route('suppliers.create') }}"
               class="bg-[#E3E3E3] hover:bg-[#161A30] text-[#777777] hover:text-white px-4 py-2 rounded-lg transition duration-200">
                + Tambah Supplier
            </a>
        </div>

        <div class="px-6 py-4 overflow-x-auto">
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <livewire:suppliers-table />
        </div>
    </div>
</x-default-layout>
