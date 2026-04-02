<!-- Admin Dashboard Sidebar -->
@php
    $prefix = auth()->user()->role;
@endphp

@php
    $user = auth()->user();
@endphp

<div id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-lg transform lg:translate-x-0 -translate-x-full lg:block transition-transform duration-300 ease-in-out flex flex-col border-r border-gray-200 dark:border-gray-700">

    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center space-x-2">
            <div
                class="w-8 h-8 bg-gradient-to-br from-grey-500 to-purple-600 rounded-lg flex items-center justify-center">
                <img src="{{ asset('landingpage') }}/img/abstract/logo_UAYO.png" alt="logo AMIKOM">
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-900 dark:text-white">Klinik Amikom</h1>
                <p class="text-xs text-purple-600 dark:text-purple-400 font-medium">Sistem Informasi</p>
            </div>
        </div>
        <button id="close-sidebar"
            class="lg:hidden p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>

    <!-- Admin Info Section -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center space-x-3">
            <div
                class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr($user->position->position, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">

                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                    {{ $user->name }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                    {{ $user->position->position }}
                </p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 mt-4 px-4 space-y-1 overflow-y-auto scrollbar-hide">
        <!-- Dashboard -->
        <a href="{{ route($prefix . '.dashboard') }}"
            class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200
            {{ Request::routeIs($prefix . '.dashboard') ? 'ACTIVE CLASS' : 'NORMAL CLASS' }}
                ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 border-r-2 border-purple-500'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}
            ">
            <i class="fas fa-tachometer-alt mr-3 text-gray-400 group-hover:text-gray-500"></i>
            <span>Dashboard</span>
        </a>

        @if (auth()->user()->position_id == 1)
            <!-- Master Pasien -->
            <a href="{{ route($prefix . '.pasien.index') }}"
                class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200
                {{ Request::routeIs($prefix . '.pasien.*')
                    ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 border-r-2 border-purple-500'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <i class="fas fa-bed mr-3 text-gray-400 group-hover:text-gray-500"></i>
                <span>Master Pasien</span>
            </a>
        @endif

        @if (auth()->user()->position_id == 4)
            <!-- Pendaftaran Pasien -->
            <a href="{{ route($prefix . '.pasien.index') }}"
                class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200
                {{ Request::routeIs($prefix . '.pasien.*')
                    ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 border-r-2 border-purple-500'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <i class="fas fa-bed mr-3 text-gray-400 group-hover:text-gray-500"></i>
                <span>Pendaftaran Pasien</span>
            </a>
        @endif

        <a href="{{ route($prefix . '.obat.index') }}"
            class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200
            {{ Request::routeIs($prefix . '.obat.*')
                ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 border-r-2 border-purple-500'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
            <i class="fas fa- fa-capsules mr-3 text-gray-400 group-hover:text-gray-500"></i>
            <span>Data Obat</span>
        </a>

        <!-- Rekam Medis -->
        <a href="{{ route('rekammedis.index') }}"
            class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200
            {{ Request::routeIs($prefix . 'rekammedis.*')
                ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 border-r-2 border-purple-500'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
            <i class="fas fa-file-waveform mr-3 text-gray-400 group-hover:text-gray-500"></i>
            <span>Rekam Medis</span>
        </a>

        @if (auth()->user()->position_id == 1)
            <!-- User Management -->
            <a href="{{ route('users.index') }}"
                class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200
                {{ Request::routeIs('users.index')
                    ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 border-r-2 border-purple-500'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <i class="fas fa-user-tie mr-3 text-gray-400 group-hover:text-gray-500"></i>
                <span>Kelola User</span>
            </a>
        @endif

        @if (auth()->user()->position_id == 1)
        <div x-data="{ open: {{ Request::routeIs('jadwal_dokter.*') || Request::routeIs('jadwal_klinik.*') ? 'true' : 'false' }} }" class="w-full">

            <button @click="open = !open"
                class="nav-item group w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200
                {{ Request::routeIs('jadwal_dokter.*') || Request::routeIs('jadwal_klinik.*')
                    ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 border-r-2 border-purple-500'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">

                <div class="flex items-center">

                    <i class="fas fa-calendar-alt mr-3 text-gray-400 group-hover:text-gray-500"></i>

                    <span>Kelola Jadwal</span>

                </div>

                <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>

            </button>

            <div x-show="open" x-transition
                class="ml-6 mt-2 space-y-2 pl-4 border-l-2 border-gray-200 dark:border-gray-700">

                <a href="{{ route('jadwal_dokter.index') }}"
                    class="block px-4 py-2 rounded-lg text-sm transition-all duration-200
                    {{ Request::routeIs('jadwal_dokter.*')
                        ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-600 font-medium'
                        : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-purple-600' }}">
                    Jadwal Dokter
                </a>

                <a href="{{ route('jadwal_klinik.index') }}"
                    class="block px-4 py-2 rounded-lg text-sm transition-all duration-200
                    {{ Request::routeIs('jadwal_klinik.*')
                        ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-600 font-medium'
                        : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-purple-600' }}">
                    Jadwal Klinik
                </a>

            </div>

        </div>
        @endif

        @if (auth()->user()->position_id == 1)
            <!-- Tim Medis Management -->
            <a href="{{ route('tim_medis.index') }}"
                class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200
                {{ Request::routeIs('tim_medis.index')
                    ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 border-r-2 border-purple-500'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <i class="fas fa-user-tie mr-3 text-gray-400 group-hover:text-gray-500"></i>
                <span>Kelola Tim Medis</span>
            </a>
        @endif

        <!-- Divider -->
        <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-gray-200 dark:border-gray-700 space-y-3">
        <!-- Logout Button -->
        <button onclick="logout()"
            class="w-full flex items-center px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 dark:hover:text-red-300 rounded-lg transition-all duration-200 transform hover:scale-[1.02]">
            <i class="fas fa-sign-out-alt mr-3"></i>
            <span class="text-sm font-medium">Keluar</span>
        </button>
    </div>
</div>

<script>
    // System Info Modal
    function showSystemInfo() {
        window.showConfirmation({
            title: 'Informasi Sistem',
            html: `
            <div class="text-left space-y-3">
                <div class="flex justify-between">
                    <span class="font-medium">Versi:</span>
                    <span>2.1.0</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Status:</span>
                    <span class="text-purple-600">Online</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Total Merchant:</span>
                    <span>127</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Transaksi Hari Ini:</span>
                    <span>856</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Server:</span>
                    <span>99.9% Uptime</span>
                </div>
            </div>
        `,
            icon: 'info',
            showCancelButton: false,
            confirmButtonText: 'Tutup'
        });
    }

    // Backup Status Modal
    function showBackupStatus() {
        window.showConfirmation({
            title: 'Status Backup',
            html: `
            <div class="text-left space-y-3">
                <div class="flex justify-between">
                    <span class="font-medium">Backup Terakhir:</span>
                    <span class="text-purple-600">2 jam lalu</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Status:</span>
                    <span class="text-purple-600">Berhasil</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Ukuran File:</span>
                    <span>247 MB</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Auto Backup:</span>
                    <span class="text-blue-600">Aktif (Harian)</span>
                </div>
            </div>
        `,
            icon: 'success',
            showCancelButton: false,
            confirmButtonText: 'Tutup'
        });
    }
</script>
