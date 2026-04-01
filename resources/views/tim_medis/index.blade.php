@extends('layouts.app')

@section('title', 'Kelola Tim Medis')
@section('page-title', 'Kelola Tim Medis')

@section('content')

    {{-- Alert Messages --}}
    @if (session('success'))
        <div
            class="alert-auto-hide mb-4 bg-purple-100 border border-purple-400 text-purple-700 px-4 py-3 rounded relative dark:bg-purple-900/30 dark:border-purple-600 dark:text-purple-300">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div
            class="alert-auto-hide mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900/30 dark:border-red-600 dark:text-red-300">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Kelola Tim Medis
            </h2>
            <p class="text-gray-600 dark:text-gray-400">
                Kelola data tim medis dalam sistem
            </p>
        </div>
        <div class="w-full sm:w-auto">
            <button onclick="openCreateUserModal()"
                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg">
                <i class="fas fa-plus mr-2"></i> Tambah Tim Medis
            </button>
        </div>
    </div>

    <div class="mb-6">
        <div class="relative max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </span>
            <input type="text" id="users-search" placeholder="Cari Nama, Username, atau Email..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-purple-500 focus:border-purple-500 text-sm">
        </div>
    </div>

    <!-- Tabel Tim Medis -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-10">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium uppercase">#</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase">Foto</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase">Nama</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase">Spesialis</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase">Deskripsi</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                </tbody> 
            </table>
        </div>
    </div>
@endsection