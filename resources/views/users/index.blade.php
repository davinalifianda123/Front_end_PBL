<!-- resources/views/users/index.blade.php -->
@section('page-title', 'Manajemen User')
<x-default-layout>
            <div class="overflow-hidden">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Tombol Tambah Pengguna -->
                    <div class="mb-4">
                        <h2 class="text-2xl font-bold text-gray-800 mb-8">
                            Manajemen Pengguna
                        </h2>
                        @if(auth()->user()->hasRole('SuperAdmin'))
                            <a href="{{ route('users.create') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                                Tambah Pengguna
                            </a>
                        @endif
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

                    <!-- Livewire Table -->
                    <livewire:users-table/>
                </div>
            </div>
</x-default-layout>
