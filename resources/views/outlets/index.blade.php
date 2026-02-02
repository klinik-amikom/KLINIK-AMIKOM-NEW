@extends('layouts.app')

@section('title', 'Kelola Outlet')

@section('page-title', 'Kelola Outlet')

@section('content')
<!-- Page Header -->
<div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0 mb-6 sm:mb-8">
    <div>
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-1 sm:mb-2">
            Kelola Outlet
        </h2>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
            Kelola outlet milik merchant dalam sistem
        </p>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <!-- Total Outlet -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div class="p-2 sm:p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg sm:rounded-xl">
                <i class="fas fa-store text-white text-lg sm:text-xl"></i>
            </div>
            <span class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">127</span>
        </div>
        <h3 class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 mt-2 sm:mt-3">
            Total Outlet
        </h3>
        <p class="text-xs text-blue-600 dark:text-blue-400">
            Semua outlet aktif
        </p>
    </div>

    <!-- Outlet Aktif -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div class="p-2 sm:p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-lg sm:rounded-xl">
                <i class="fas fa-check-circle text-white text-lg sm:text-xl"></i>
            </div>
            <span class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">119</span>
        </div>
        <h3 class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 mt-2 sm:mt-3">
            Outlet Aktif
        </h3>
        <p class="text-xs text-green-600 dark:text-green-400">
            94% dari total outlet
        </p>
    </div>

    <!-- Total Saldo -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div class="p-2 sm:p-3 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg sm:rounded-xl">
                <i class="fas fa-wallet text-white text-lg sm:text-xl"></i>
            </div>
            <span class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Rp 847M</span>
        </div>
        <h3 class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 mt-2 sm:mt-3">
            Total Saldo
        </h3>
        <p class="text-xs text-yellow-600 dark:text-yellow-400">
            Saldo semua outlet
        </p>
    </div>

    <!-- Outlet Nonaktif -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div class="p-2 sm:p-3 bg-gradient-to-br from-red-500 to-red-600 rounded-lg sm:rounded-xl">
                <i class="fas fa-times-circle text-white text-lg sm:text-xl"></i>
            </div>
            <span class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">8</span>
        </div>
        <h3 class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 mt-2 sm:mt-3">
            Outlet Nonaktif
        </h3>
        <p class="text-xs text-red-600 dark:text-red-400">
            6% dari total outlet
        </p>
    </div>
</div>

<!-- Filters and Search -->
<div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-4 sm:p-6 mb-4 sm:mb-6 border border-gray-200 dark:border-gray-700">
    <div class="space-y-4">
        <!-- Search -->
        <div class="w-full">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="outlet-search" placeholder="Cari nama outlet atau pemilik..." 
                    class="block w-full pl-10 pr-3 py-2 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 text-sm sm:text-base">
            </div>
        </div>

        <!-- Filters -->
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
            <div class="flex-1 sm:flex-none">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status:</label>
                <select id="status-filter" 
                    class="block w-full pl-3 pr-8 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>

            <div class="flex-1 sm:flex-none">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Saldo:</label>
                <select id="balance-filter" 
                    class="block w-full pl-3 pr-8 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                    <option value="">Semua Saldo</option>
                    <option value="high">Tinggi (>5jt)</option>
                    <option value="medium">Sedang (1-5jt)</option>
                    <option value="low">Rendah (<1jt)</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Outlets Table -->
<div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                Daftar Outlet
            </h3>
            <div class="flex items-center justify-between sm:justify-end space-x-3">
                <!-- View Toggle (Mobile Only) -->
                <div class="flex items-center space-x-2 sm:hidden">
                    <button id="table-view-btn" onclick="switchView('table')" 
                        class="view-toggle active p-2 rounded-lg bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400">
                        <i class="fas fa-table"></i>
                    </button>
                    <button id="card-view-btn" onclick="switchView('card')" 
                        class="view-toggle p-2 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-th-large"></i>
                    </button>
                </div>
                
                <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                    <span>Menampilkan</span>
                    <select class="border-0 bg-transparent text-gray-900 dark:text-white font-medium text-xs sm:text-sm">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    <span>dari 127 outlet</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Table View -->
    <div id="table-view" class="table-container overflow-x-auto">
        <table class="w-full text-left min-w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-700">
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider sticky left-0 bg-gray-50 dark:bg-gray-700 z-10 sm:static">
                        #
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider sticky left-8 bg-gray-50 dark:bg-gray-700 z-10 sm:static min-w-[200px]">
                        Pemilik
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider min-w-[200px]">
                        Nama Outlet
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden lg:table-cell min-w-[150px]">
                        Saldo
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell min-w-[100px]">
                        Status
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden xl:table-cell min-w-[120px]">
                        Bergabung
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider text-right sticky right-0 bg-gray-50 dark:bg-gray-700 z-10 sm:static min-w-[100px]">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="outlets-table-body">
                <!-- Outlet 1 -->
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 outlet-row" 
                    data-status="active" data-balance="high">
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 dark:text-white font-medium sticky left-0 bg-white dark:bg-gray-800 z-10 sm:static">
                        1
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap sticky left-8 bg-white dark:bg-gray-800 z-10 sm:static">
                        <div class="flex items-center">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                BK
                            </div>
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white truncate">Kang Adi</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">kang.adi@email.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                        <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">Bakso Kang Adi</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden lg:table-cell">
                        <div class="text-xs sm:text-sm font-bold text-green-600 dark:text-green-400">Rp 8.500.000</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden md:table-cell">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                            Aktif
                        </span>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden xl:table-cell">
                        <div class="text-xs sm:text-sm text-gray-900 dark:text-white">15 Jan 2024</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium sticky right-0 bg-white dark:bg-gray-800 z-10 sm:static">
                        <div class="flex items-center justify-end space-x-1">
                            <button onclick="editOutlet(1)" 
                                class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 p-1.5 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors duration-200"
                                title="Edit Outlet">
                                <i class="fas fa-edit text-xs sm:text-sm"></i>
                            </button>
                            <button onclick="toggleOutletStatus(1)" 
                                class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 p-1.5 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors duration-200 hidden sm:inline-flex"
                                title="Toggle Status">
                                <i class="fas fa-power-off text-xs sm:text-sm"></i>
                            </button>
                            <button onclick="deleteOutlet(1)" 
                                class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                                title="Delete Outlet">
                                <i class="fas fa-trash text-xs sm:text-sm"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Outlet 2 -->
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 outlet-row" 
                    data-status="active" data-balance="medium">
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 dark:text-white font-medium sticky left-0 bg-white dark:bg-gray-800 z-10 sm:static">
                        2
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap sticky left-8 bg-white dark:bg-gray-800 z-10 sm:static">
                        <div class="flex items-center">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                WS
                            </div>
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white truncate">Sari</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">sari.rasa@email.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                        <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">Warung Sari Rasa</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden lg:table-cell">
                        <div class="text-xs sm:text-sm font-bold text-blue-600 dark:text-blue-400">Rp 3.200.000</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden md:table-cell">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                            Aktif
                        </span>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden xl:table-cell">
                        <div class="text-xs sm:text-sm text-gray-900 dark:text-white">22 Feb 2024</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium sticky right-0 bg-white dark:bg-gray-800 z-10 sm:static">
                        <div class="flex items-center justify-end space-x-1">
                            <button onclick="editOutlet(2)" 
                                class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 p-1.5 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors duration-200"
                                title="Edit Outlet">
                                <i class="fas fa-edit text-xs sm:text-sm"></i>
                            </button>
                            <button onclick="toggleOutletStatus(2)" 
                                class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 p-1.5 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors duration-200 hidden sm:inline-flex"
                                title="Toggle Status">
                                <i class="fas fa-power-off text-xs sm:text-sm"></i>
                            </button>
                            <button onclick="deleteOutlet(2)" 
                                class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                                title="Delete Outlet">
                                <i class="fas fa-trash text-xs sm:text-sm"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Outlet 3 -->
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 outlet-row" 
                    data-status="active" data-balance="low">
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 dark:text-white font-medium sticky left-0 bg-white dark:bg-gray-800 z-10 sm:static">
                        3
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap sticky left-8 bg-white dark:bg-gray-800 z-10 sm:static">
                        <div class="flex items-center">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                MA
                            </div>
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white truncate">Pak Kumis</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">pakumis@email.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                        <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">Mie Ayam Pak Kumis</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden lg:table-cell">
                        <div class="text-xs sm:text-sm font-bold text-orange-600 dark:text-orange-400">Rp 750.000</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden md:table-cell">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                            Aktif
                        </span>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden xl:table-cell">
                        <div class="text-xs sm:text-sm text-gray-900 dark:text-white">10 Mar 2024</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium sticky right-0 bg-white dark:bg-gray-800 z-10 sm:static">
                        <div class="flex items-center justify-end space-x-1">
                            <button onclick="editOutlet(3)" 
                                class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 p-1.5 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors duration-200"
                                title="Edit Outlet">
                                <i class="fas fa-edit text-xs sm:text-sm"></i>
                            </button>
                            <button onclick="toggleOutletStatus(3)" 
                                class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 p-1.5 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors duration-200 hidden sm:inline-flex"
                                title="Toggle Status">
                                <i class="fas fa-power-off text-xs sm:text-sm"></i>
                            </button>
                            <button onclick="deleteOutlet(3)" 
                                class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                                title="Delete Outlet">
                                <i class="fas fa-trash text-xs sm:text-sm"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Outlet 4 (Inactive) -->
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 outlet-row opacity-60" 
                    data-status="inactive" data-balance="medium">
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 dark:text-white font-medium sticky left-0 bg-white dark:bg-gray-800 z-10 sm:static">
                        4
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap sticky left-8 bg-white dark:bg-gray-800 z-10 sm:static">
                        <div class="flex items-center">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                CS
                            </div>
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white truncate">Citra</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">citra.sate@email.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                        <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">Sate Citra</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden lg:table-cell">
                        <div class="text-xs sm:text-sm font-bold text-blue-600 dark:text-blue-400">Rp 2.100.000</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden md:table-cell">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                            Nonaktif
                        </span>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden xl:table-cell">
                        <div class="text-xs sm:text-sm text-gray-900 dark:text-white">05 Apr 2024</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium sticky right-0 bg-white dark:bg-gray-800 z-10 sm:static">
                        <div class="flex items-center justify-end space-x-1">
                            <button onclick="editOutlet(4)" 
                                class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 p-1.5 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors duration-200"
                                title="Edit Outlet">
                                <i class="fas fa-edit text-xs sm:text-sm"></i>
                            </button>
                            <button onclick="toggleOutletStatus(4)" 
                                class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 p-1.5 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors duration-200 hidden sm:inline-flex"
                                title="Activate Outlet">
                                <i class="fas fa-power-off text-xs sm:text-sm"></i>
                            </button>
                            <button onclick="deleteOutlet(4)" 
                                class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                                title="Delete Outlet">
                                <i class="fas fa-trash text-xs sm:text-sm"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Card View (Mobile Alternative) -->
    <div id="card-view" class="hidden">
        <div class="p-4 space-y-4" id="outlets-card-body">
            <!-- Outlet Card 1 -->
            <div class="user-card bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600" 
                data-status="active" data-balance="high">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-semibold">
                            BK
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">Bakso Kang Adi</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Pemilik: Kang Adi</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <button onclick="editOutlet(1)" 
                            class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 p-2 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors duration-200">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="toggleOutletStatus(1)" 
                            class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 p-2 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors duration-200">
                            <i class="fas fa-power-off"></i>
                        </button>
                        <button onclick="deleteOutlet(1)" 
                            class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Email:</span>
                        <span class="text-gray-900 dark:text-white">kang.adi@email.com</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Kategori:</span>
                        <span class="text-gray-900 dark:text-white">Kuliner Indonesia</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Saldo:</span>
                        <span class="text-green-600 dark:text-green-400 font-bold">Rp 8.500.000</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 dark:text-gray-400">Status:</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                            Aktif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Bergabung:</span>
                        <span class="text-gray-900 dark:text-white">15 Jan 2024</span>
                    </div>
                </div>
            </div>

            <!-- Outlet Card 2 -->
            <div class="user-card bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600" 
                data-status="active" data-balance="medium">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center text-white font-semibold">
                            WS
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">Warung Sari Rasa</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Pemilik: Sari</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <button onclick="editOutlet(2)" 
                            class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 p-2 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors duration-200">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="toggleOutletStatus(2)" 
                            class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 p-2 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors duration-200">
                            <i class="fas fa-power-off"></i>
                        </button>
                        <button onclick="deleteOutlet(2)" 
                            class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Email:</span>
                        <span class="text-gray-900 dark:text-white">sari.rasa@email.com</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Kategori:</span>
                        <span class="text-gray-900 dark:text-white">Nasi Padang</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Saldo:</span>
                        <span class="text-blue-600 dark:text-blue-400 font-bold">Rp 3.200.000</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 dark:text-gray-400">Status:</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                            Aktif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Bergabung:</span>
                        <span class="text-gray-900 dark:text-white">22 Feb 2024</span>
                    </div>
                </div>
            </div>

            <!-- Outlet Card 3 -->
            <div class="user-card bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600" 
                data-status="active" data-balance="low">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                            MA
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">Mie Ayam Pak Kumis</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Pemilik: Pak Kumis</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <button onclick="editOutlet(3)" 
                            class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 p-2 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors duration-200">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="toggleOutletStatus(3)" 
                            class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 p-2 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors duration-200">
                            <i class="fas fa-power-off"></i>
                        </button>
                        <button onclick="deleteOutlet(3)" 
                            class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Email:</span>
                        <span class="text-gray-900 dark:text-white">pakumis@email.com</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Kategori:</span>
                        <span class="text-gray-900 dark:text-white">Mie & Bakso</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Saldo:</span>
                        <span class="text-orange-600 dark:text-orange-400 font-bold">Rp 750.000</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 dark:text-gray-400">Status:</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                            Aktif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Bergabung:</span>
                        <span class="text-gray-900 dark:text-white">10 Mar 2024</span>
                    </div>
                </div>
            </div>

            <!-- Outlet Card 4 (Inactive) -->
            <div class="user-card bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 opacity-60" 
                data-status="inactive" data-balance="medium">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center text-white font-semibold">
                            CS
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">Sate Citra</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Pemilik: Citra</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <button onclick="editOutlet(4)" 
                            class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 p-2 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors duration-200">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="toggleOutletStatus(4)" 
                            class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 p-2 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors duration-200">
                            <i class="fas fa-power-off"></i>
                        </button>
                        <button onclick="deleteOutlet(4)" 
                            class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Email:</span>
                        <span class="text-gray-900 dark:text-white">citra.sate@email.com</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Kategori:</span>
                        <span class="text-gray-900 dark:text-white">Sate & Gule</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Saldo:</span>
                        <span class="text-blue-600 dark:text-blue-400 font-bold">Rp 2.100.000</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 dark:text-gray-400">Status:</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                            Nonaktif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Bergabung:</span>
                        <span class="text-gray-900 dark:text-white">05 Apr 2024</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center sm:text-left">
                Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">10</span> dari <span class="font-medium">127</span> outlet
            </div>
            <div class="flex items-center justify-center sm:justify-end space-x-1 sm:space-x-2">
                <button class="px-2 sm:px-3 py-1 sm:py-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                    <i class="fas fa-chevron-left sm:hidden"></i>
                    <span class="hidden sm:inline">Sebelumnya</span>
                </button>
                <button class="px-2 sm:px-3 py-1 sm:py-2 text-xs sm:text-sm text-white bg-green-600 border border-green-600 rounded-lg">
                    1
                </button>
                <button class="px-2 sm:px-3 py-1 sm:py-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                    2
                </button>
                <button class="px-2 sm:px-3 py-1 sm:py-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                    3
                </button>
                <button class="px-2 sm:px-3 py-1 sm:py-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                    <i class="fas fa-chevron-right sm:hidden"></i>
                    <span class="hidden sm:inline">Selanjutnya</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Outlet Modal -->
<div id="edit-outlet-modal" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-50 hidden backdrop-blur-sm transition-all duration-300">
    <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 w-full max-w-sm sm:max-w-md transform transition-all duration-300 scale-95 max-h-[90vh] overflow-y-auto">
            <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800 z-10">
                <div class="flex items-center justify-between">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                        Edit Outlet
                    </h3>
                    <button onclick="closeEditOutletModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <form id="edit-outlet-form" class="p-4 sm:p-6">
                <input type="hidden" id="edit-outlet-id" name="outlet_id">
                <div class="space-y-3 sm:space-y-4">
                    <!-- Nama Outlet -->
                    <div>
                        <label for="edit-outlet-name" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nama Outlet <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit-outlet-name" name="outlet_name" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                            placeholder="Masukkan nama outlet">
                    </div>

                    <!-- Status Outlet -->
                    <div>
                        <label for="edit-outlet-status" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Status Outlet
                        </label>
                        <select id="edit-outlet-status" name="outlet_status"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                            <option value="active">Aktif</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>

                    <!-- Info Pemilik (Read Only) -->
                    <div class="pt-2 sm:pt-4 border-t border-gray-200 dark:border-gray-600">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Informasi Pemilik</h4>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Nama Pemilik
                                </label>
                                <input type="text" id="edit-owner-name" readonly
                                    class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                            </div>

                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Email Pemilik
                                </label>
                                <input type="email" id="edit-owner-email" readonly
                                    class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                            </div>

                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Saldo Saat Ini
                                </label>
                                <input type="text" id="edit-outlet-balance" readonly
                                    class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 rounded-b-xl">
                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                    <button type="button" onclick="closeEditOutletModal()"
                        class="w-full sm:w-auto px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="button" onclick="updateOutlet()"
                        class="w-full sm:w-auto px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 transition-colors duration-200">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Search functionality with support for both table and card views
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('outlet-search');
        const statusFilter = document.getElementById('status-filter');
        const balanceFilter = document.getElementById('balance-filter');

        function filterOutlets() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedStatus = statusFilter.value;
            const selectedBalance = balanceFilter.value;
            
            // Filter table rows
            const rows = document.querySelectorAll('.outlet-row');
            // Filter card views
            const cards = document.querySelectorAll('.user-card');

            [...rows, ...cards].forEach(item => {
                let name, owner, status, balance;
                
                if (item.classList.contains('outlet-row')) {
                    // Table row filtering
                    const outletNameCell = item.querySelector('td:nth-child(3)');
                    const ownerNameCell = item.querySelector('td:nth-child(2)');
                    name = outletNameCell ? outletNameCell.textContent.toLowerCase() : '';
                    owner = ownerNameCell ? ownerNameCell.textContent.toLowerCase() : '';
                    status = item.dataset.status;
                    balance = item.dataset.balance;
                } else {
                    // Card filtering
                    name = item.querySelector('h4').textContent.toLowerCase();
                    const ownerElement = item.querySelector('p');
                    owner = ownerElement ? ownerElement.textContent.toLowerCase() : '';
                    status = item.dataset.status;
                    balance = item.dataset.balance;
                }

                const matchesSearch = name.includes(searchTerm) || owner.includes(searchTerm);
                const matchesStatus = !selectedStatus || status === selectedStatus;
                const matchesBalance = !selectedBalance || balance === selectedBalance;

                if (matchesSearch && matchesStatus && matchesBalance) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterOutlets);
        statusFilter.addEventListener('change', filterOutlets);
        balanceFilter.addEventListener('change', filterOutlets);

        // Auto switch to card view on mobile
        function checkViewMode() {
            const tableView = document.getElementById('table-view');
            const cardView = document.getElementById('card-view');
            const tableBtn = document.getElementById('table-view-btn');
            const cardBtn = document.getElementById('card-view-btn');
            
            if (window.innerWidth < 640) { // sm breakpoint
                // Auto switch to card view on mobile
                if (!cardView.classList.contains('hidden')) return; // Already in card view
                
                tableView.classList.add('hidden');
                cardView.classList.remove('hidden');
                
                if (tableBtn && cardBtn) {
                    tableBtn.classList.remove('active', 'bg-green-100', 'text-green-600', 'dark:bg-green-900/30', 'dark:text-green-400');
                    tableBtn.classList.add('text-gray-400', 'hover:text-gray-600', 'dark:hover:text-gray-300');
                    
                    cardBtn.classList.add('active', 'bg-green-100', 'text-green-600', 'dark:bg-green-900/30', 'dark:text-green-400');
                    cardBtn.classList.remove('text-gray-400', 'hover:text-gray-600', 'dark:hover:text-gray-300');
                }
            } else {
                // Auto switch to table view on desktop
                if (!tableView.classList.contains('hidden')) return; // Already in table view
                
                cardView.classList.add('hidden');
                tableView.classList.remove('hidden');
                
                if (tableBtn && cardBtn) {
                    cardBtn.classList.remove('active', 'bg-green-100', 'text-green-600', 'dark:bg-green-900/30', 'dark:text-green-400');
                    cardBtn.classList.add('text-gray-400', 'hover:text-gray-600', 'dark:hover:text-gray-300');
                    
                    tableBtn.classList.add('active', 'bg-green-100', 'text-green-600', 'dark:bg-green-900/30', 'dark:text-green-400');
                    tableBtn.classList.remove('text-gray-400', 'hover:text-gray-600', 'dark:hover:text-gray-300');
                }
            }
        }

        // Initial check
        checkViewMode();
        
        // Check on resize
        window.addEventListener('resize', checkViewMode);
    });

    // View switching function
    function switchView(viewType) {
        const tableView = document.getElementById('table-view');
        const cardView = document.getElementById('card-view');
        const tableBtn = document.getElementById('table-view-btn');
        const cardBtn = document.getElementById('card-view-btn');

        if (viewType === 'table') {
            tableView.classList.remove('hidden');
            cardView.classList.add('hidden');
            
            tableBtn.classList.add('active', 'bg-green-100', 'text-green-600', 'dark:bg-green-900/30', 'dark:text-green-400');
            tableBtn.classList.remove('text-gray-400', 'hover:text-gray-600', 'dark:hover:text-gray-300');
            
            cardBtn.classList.remove('active', 'bg-green-100', 'text-green-600', 'dark:bg-green-900/30', 'dark:text-green-400');
            cardBtn.classList.add('text-gray-400', 'hover:text-gray-600', 'dark:hover:text-gray-300');
        } else {
            cardView.classList.remove('hidden');
            tableView.classList.add('hidden');
            
            cardBtn.classList.add('active', 'bg-green-100', 'text-green-600', 'dark:bg-green-900/30', 'dark:text-green-400');
            cardBtn.classList.remove('text-gray-400', 'hover:text-gray-600', 'dark:hover:text-gray-300');
            
            tableBtn.classList.remove('active', 'bg-green-100', 'text-green-600', 'dark:bg-green-900/30', 'dark:text-green-400');
            tableBtn.classList.add('text-gray-400', 'hover:text-gray-600', 'dark:hover:text-gray-300');
        }
    }

    // Modal Functions
    function openEditOutletModal() {
        const modal = document.getElementById('edit-outlet-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.transform').classList.remove('scale-95');
            modal.querySelector('.transform').classList.add('scale-100');
        }, 10);
    }

    function closeEditOutletModal() {
        const modal = document.getElementById('edit-outlet-modal');
        modal.querySelector('.transform').classList.add('scale-95');
        modal.querySelector('.transform').classList.remove('scale-100');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.getElementById('edit-outlet-form').reset();
        }, 300);
    }

    // Outlet Management Functions
    function editOutlet(outletId) {
        const loadingToast = showToast('Memuat data outlet...', 'info', 0);

        setTimeout(() => {
            // Sample data - in real app, fetch from API
            const outletData = {
                1: { 
                    name: 'Bakso Kang Adi', 
                    status: 'active',
                    owner: 'Kang Adi',
                    email: 'kang.adi@email.com',
                    balance: 'Rp 8.500.000'
                },
                2: { 
                    name: 'Warung Sari Rasa', 
                    status: 'active',
                    owner: 'Sari',
                    email: 'sari.rasa@email.com',
                    balance: 'Rp 3.200.000'
                },
                3: { 
                    name: 'Mie Ayam Pak Kumis', 
                    status: 'active',
                    owner: 'Pak Kumis',
                    email: 'pakumis@email.com',
                    balance: 'Rp 750.000'
                },
                4: { 
                    name: 'Sate Citra', 
                    status: 'inactive',
                    owner: 'Citra',
                    email: 'citra.sate@email.com',
                    balance: 'Rp 2.100.000'
                }
            };

            const outlet = outletData[outletId];
            if (outlet) {
                document.getElementById('edit-outlet-id').value = outletId;
                document.getElementById('edit-outlet-name').value = outlet.name;
                document.getElementById('edit-outlet-status').value = outlet.status;
                document.getElementById('edit-owner-name').value = outlet.owner;
                document.getElementById('edit-owner-email').value = outlet.email;
                document.getElementById('edit-outlet-balance').value = outlet.balance;
                
                window.dismissToast(loadingToast);
                openEditOutletModal();
            }
        }, 1000);
    }

    function updateOutlet() {
        const form = document.getElementById('edit-outlet-form');
        const formData = new FormData(form);
        const updateButton = document.querySelector('#edit-outlet-modal button[onclick="updateOutlet()"]');

        // Validation
        const outletName = formData.get('outlet_name');
        if (!outletName.trim()) {
            showToast('Nama outlet tidak boleh kosong!', 'error');
            return;
        }

        // Add loading state
        const originalText = updateButton.innerHTML;
        updateButton.innerHTML = '<span class="loading-spinner mr-2"></span>Memperbarui...';
        updateButton.disabled = true;

        // Show loading toast
        const loadingToast = showToast('Memperbarui data outlet...', 'info', 0);

        // Simulate API call
        setTimeout(() => {
            // Restore button state
            updateButton.innerHTML = originalText;
            updateButton.disabled = false;
            
            // Dismiss loading toast
            window.dismissToast(loadingToast);
            
            showToast('Data outlet berhasil diperbarui!', 'success');
            closeEditOutletModal();
            
            // In real app, update table row with new data
        }, 2000);
    }

    function toggleOutletStatus(outletId) {
        // In real implementation, get current status from row or API
        const isActive = Math.random() > 0.5; // Simulate current status
        const action = isActive ? 'nonaktifkan' : 'aktifkan';
        const message = `Apakah Anda yakin ingin ${action} outlet ini?`;

        window.showConfirmation({
            title: 'Konfirmasi Status Outlet',
            text: message,
            icon: 'question',
            confirmButtonText: `Ya, ${action.charAt(0).toUpperCase() + action.slice(1)}`,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const loadingToast = showToast(`Memproses perubahan status...`, 'info', 0);
                
                setTimeout(() => {
                    window.dismissToast(loadingToast);
                    showToast(`Outlet berhasil di${action}!`, 'success');
                    
                    // In real app, update status via API and refresh table row
                }, 1500);
            }
        });
    }

    function deleteOutlet(outletId) {
        window.confirmDelete({
            title: 'Hapus Outlet',
            text: 'Outlet yang dihapus tidak dapat dikembalikan! Semua data terkait termasuk menu dan transaksi akan ikut terhapus.',
        }).then((result) => {
            if (result.isConfirmed) {
                const loadingToast = showToast('Menghapus outlet...', 'info', 0);

                setTimeout(() => {
                    window.dismissToast(loadingToast);
                    showToast('Outlet berhasil dihapus!', 'success');
                    
                    // In real app, delete via API and remove row from table
                }, 2000);
            }
        });
    }

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEditOutletModal();
        }
    });
</script>
@endpush