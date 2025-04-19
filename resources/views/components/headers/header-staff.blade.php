<nav class="bg-blue-800 text-white shadow-lg w-full">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <div class="text-xl font-bold">
                Sistem Manajemen Gudang
            </div>
            <div class="flex justify-center items-center gap-2 space-x-4">
                <a href="{{ route('categories.index') }}" class="hover:text-blue-200">Category</a>
                <a href="{{ route('gudangs.index') }}" class="hover:text-blue-200">Gudang</a>
                <a href="{{ route('tokos.index') }}" class="hover:text-blue-200">Toko</a>
                <a href="{{ route('barangs.index') }}" class="hover:text-blue-200">Barang</a>
                <a href="{{ route('penerimaan-barang.index') }}" class="hover:text-blue-200">Penerimaan Barang</a>
                <a href="{{ route('pengiriman-barang.index') }}" class="hover:text-blue-200">Pengiriman Barang</a>
                <a href="{{ route('retur-barang.index') }}" class="hover:text-blue-200">Retur Barang</a>
                <!-- Tambahkan menu lain di sini -->
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