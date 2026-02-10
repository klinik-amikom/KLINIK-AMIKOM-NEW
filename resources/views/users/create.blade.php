@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-6">

        {{-- Back --}}
        <a href="{{ route('users.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-6">
            ← Kembali
        </a>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

            <h2 class="text-xl font-semibold text-gray-800 mb-6">
                Tambah User
            </h2>

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-600">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500" required>
                </div>

                {{-- Username --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}"
                        class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500" required>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500" required>
                </div>

                {{-- Identity --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Identity</label>
                    <select name="identity_id"
                        class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500" required>
                        <option value="">-- Pilih Identity --</option>
                        <option value="1" {{ old('identity_id') == 1 ? 'selected' : '' }}>Admin</option>
                        <option value="2" {{ old('identity_id') == 2 ? 'selected' : '' }}>Dokter</option>
                        <option value="3" {{ old('identity_id') == 3 ? 'selected' : '' }}>Apoteker</option>
                    </select>
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500" required>
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500" required>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('users.index') }}"
                        class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">Batal</a>
                    <button type="submit" class="px-5 py-2 rounded-lg bg-purple-600 text-white hover:bg-purple-700">Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
