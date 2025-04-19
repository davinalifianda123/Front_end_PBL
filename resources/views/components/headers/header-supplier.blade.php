<nav class="bg-blue-800 text-white shadow-lg w-full">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <div class="text-xl font-bold">
                Sistem Manajemen Gudang
            </div>
            <div class="flex justify-center items-center gap-2 space-x-4">
                <a href="{{ route('barangs.index') }}" class="hover:text-blue-200">Barang</a>
                <a href="{{ route('pengiriman-barang.index') }}" class="hover:text-blue-200">Pengiriman Barang</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf 
                    <button type="submit" class="bg-red-500 text-white hover:bg-red-600 py-1 px-2 rounded-lg" class="inline">
                        {{ Auth::user()->nama_user }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>