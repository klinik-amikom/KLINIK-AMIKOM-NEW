@extends('layouts.app')

@section('title', 'Detail Master Identity')
@section('page-title', 'Detail Master Identity')

@section('content')

<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

    {{-- HEADER --}}
    <div class="mb-4 flex justify-between items-center">

        <h2 class="text-xl font-bold">
            Detail Master Identity
        </h2>

        <a href="{{ route('master-identity.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm rounded transition">

            ← Kembali
        </a>

    </div>

    {{-- IDENTITAS UTAMA --}}
    <div class="bg-gray-50 border rounded-xl p-5 shadow-sm">

        <h3 class="text-lg font-semibold mb-4 text-gray-700">

            Informasi Identity

        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-3 text-sm">

            {{-- NIK --}}
            <div class="flex justify-between">
                <span class="text-gray-500">
                    NIK / NIM
                </span>

                <span class="font-medium">
                    {{ $identity->identity_number }}
                </span>
            </div>

            {{-- Nama --}}
            <div class="flex justify-between">
                <span class="text-gray-500">
                    Nama
                </span>

                <span class="font-medium">
                    {{ $identity->name }}
                </span>
            </div>

            {{-- Jenis --}}
            <div class="flex justify-between">
                <span class="text-gray-500">
                    Jenis Identity
                </span>

                <span class="font-medium capitalize">
                    {{ $identity->identity_type }}
                </span>
            </div>

            {{-- Gender --}}
            <div class="flex justify-between">
                <span class="text-gray-500">
                    Gender
                </span>

                <span class="font-medium">
                    @if($identity->gender == 'L')
                        Laki-laki
                    @else
                        Perempuan
                    @endif
                </span>
            </div>

            {{-- Tanggal Lahir --}}
            <div class="flex justify-between">
                <span class="text-gray-500">
                    Tanggal Lahir
                </span>

                <span class="font-medium">
                    {{ $identity->birth_date 
                        ? \Carbon\Carbon::parse($identity->birth_date)->format('d M Y') 
                        : '-' }}
                </span>
            </div>

            {{-- No Telp --}}
            <div class="flex justify-between">
                <span class="text-gray-500">
                    No Telepon
                </span>

                <span class="font-medium">
                    {{ $identity->no_telp ?? '-' }}
                </span>
            </div>

            {{-- Email --}}
            <div class="flex justify-between md:col-span-2">
                <span class="text-gray-500">
                    Email
                </span>

                <span class="font-medium">
                    {{ $identity->email ?? '-' }}
                </span>
            </div>

            {{-- Alamat --}}
            <div class="flex justify-between md:col-span-2">

                <span class="text-gray-500">
                    Alamat
                </span>

                <span class="font-medium text-right">
                    {{ $identity->address }}
                </span>

            </div>

            {{-- Created --}}
            <div class="flex justify-between">
                <span class="text-gray-500">
                    Dibuat
                </span>

                <span class="font-medium">
                    {{ $identity->created_at 
                        ? \Carbon\Carbon::parse($identity->created_at)->format('d M Y H:i') 
                        : '-' }}
                </span>
            </div>

            {{-- Updated --}}
            <div class="flex justify-between">
                <span class="text-gray-500">
                    Diupdate
                </span>

                <span class="font-medium">
                    {{ $identity->updated_at 
                        ? \Carbon\Carbon::parse($identity->updated_at)->format('d M Y H:i') 
                        : '-' }}
                </span>
            </div>

        </div>

    </div>

</div>

@endsection