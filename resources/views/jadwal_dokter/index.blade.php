@extends('layouts.app')

@section('title', 'Kelola Jadwal Dokter')
@section('page-title', 'Kelola Jadwal Dokter')

@section('content')

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="alert-auto-hide mb-4 bg-purple-100 border border-purple-400 text-purple-700 px-4 py-3 rounded relative dark:bg-purple-900/30 dark:border-purple-600 dark:text-purple-300"
            role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg onclick="this.parentElement.parentElement.remove()"
                    class="fill-current h-6 w-6 text-purple-500 cursor-pointer" role="button"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
    @endif

    @if (session('error'))
        <div class="alert-auto-hide mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900/30 dark:border-red-600 dark:text-red-300"
            role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg onclick="this.parentElement.parentElement.remove()"
                    class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-auto-hide mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900/30 dark:border-red-600 dark:text-red-300"
            role="alert">
            <strong class="font-bold">Validasi Error!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg onclick="this.parentElement.parentElement.remove()"
                    class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Kelola Jadwal Dokter
            </h2>
            <p class="text-gray-600 dark:text-gray-400">
                Kelola jadwal praktik dokter
            </p>
        </div>

        <button onclick="openCreateModal()" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg">
            <i class="fas fa-plus mr-2"></i> Tambah Jadwal
        </button>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-xs uppercase">#</th>
                        <th class="px-6 py-3 text-xs uppercase">Nama Dokter</th>
                        <th class="px-6 py-3 text-xs uppercase">Poli</th>
                        <th class="px-6 py-3 text-xs uppercase">Hari Praktik</th>
                        <th class="px-6 py-3 text-xs uppercase">Jam Praktik</th>
                        <th class="px-6 py-3 text-xs uppercase text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($jadwal as $j)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">

                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $j->dokter->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $j->poli }}</td>
                            <td class="px-6 py-4">{{ $j->hari }}</td>
                            <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                            <td class="px-6 py-4 text-right">

                                <div class="flex justify-end space-x-3">

                                    <button
                                        onclick="editJadwal(
                                        '{{ $j->id }}',
                                        '{{ $j->dokter_id }}',
                                        '{{ $j->poli }}',
                                        '{{ $j->hari }}',
                                        '{{ $j->jam_mulai }} - {{ $j->jam_selesai }}'
                                    )"
                                        class="text-purple-600 hover:text-purple-800">

                                        <i class="fas fa-edit"></i>

                                    </button>


                                    <form action="{{ route('jadwal_dokter.destroy', $j->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button 
                                            type="button"
                                            data-action="{{ route('jadwal_dokter.destroy', $j->id) }}"
                                            data-method="DELETE"
                                            data-confirm-type="delete"
                                            data-confirm-text="Data ini akan dihapus permanen!"
                                            onclick="handleActionWithConfirmation(this)"
                                            class="flex items-center justify-center w-6 h-6 text-red-600 hover:text-red-800">
                                            
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-500">
                                Data jadwal belum tersedia
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

    <!-- MODAL CREATE -->
    <div id="create-modal" class="fixed inset-0 bg-black/50 hidden backdrop-blur-sm flex items-center justify-center p-4">

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md">

            <!-- HEADER -->
            <div class="p-4 border-b flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Tambah Dokter
                </h3>

                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('jadwal_dokter.store') }}" method="POST" class="p-6 space-y-4">
                @csrf


                <!-- NAMA DOKTER -->
                <div>
                    <label>Dokter</label>
                    <select name="dokter_id" class="w-full px-3 py-2 border rounded-lg" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach ($dokters as $dokter)
                            <option value="{{ $dokter->id }}">
                                {{ $dokter->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <!-- POLI -->
                <!-- kirim ke backend -->
                <div>
                    <label>Poli</label>
                    <select name="poli" class="w-full px-3 py-2 border rounded-lg" required>
                        @foreach ($polis as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->nama_poli }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <!-- HARI -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Hari Praktik
                    </label>

                    <div class="grid grid-cols-2 gap-2">

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari[]" value="Senin">
                            <span>Senin</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari[]" value="Selasa">
                            <span>Selasa</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari[]" value="Rabu">
                            <span>Rabu</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari[]" value="Kamis">
                            <span>Kamis</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari[]" value="Jumat">
                            <span>Jumat</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari[]" value="Sabtu">
                            <span>Sabtu</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari[]" value="Minggu">
                            <span>Minggu</span>
                        </label>

                    </div>
                </div>


                <!-- JAM PRAKTIK -->
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Jam Praktik
                    </label>

                    <div class="flex items-center gap-2">

                        <input type="time" name="jam_mulai" class="w-full px-3 py-2 border rounded-lg">

                        <span class="text-gray-500">-</span>

                        <input type="time" name="jam_selesai" class="w-full px-3 py-2 border rounded-lg">

                    </div>

                </div>


                <!-- BUTTON -->
                <div class="flex justify-end space-x-3 pt-2">

                    <button type="button" onclick="closeCreateModal()"
                        class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                        Batal
                    </button>

                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Simpan
                    </button>

                </div>

            </form>

        </div>
    </div>

    <!-- MODAL EDIT -->
    <div id="edit-modal"
        class="fixed inset-0 bg-black/50 hidden backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md overflow-y-auto max-h-[90vh]">
            <!-- HEADER -->
            <div class="p-4 border-b flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Data Dokter</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- FORM -->
            <form id="edit-form" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <!-- NAMA DOKTER -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Dokter</label>
                    <select id="edit-dokter" name="dokter_id">
                        @foreach ($dokters as $dokter)
                            <option value="{{ $dokter->id }}">
                                {{ $dokter->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <select id="edit-poli" name="poli" class="w-full px-3 py-2 border rounded-lg">
                    @foreach ($polis as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->nama_poli }}
                        </option>
                    @endforeach
                </select>


                <!-- HARI PRAKTIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hari Praktik</label>
                    <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto p-2 border rounded-lg">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari[]" value="Senin" class="edit-hari"><span>Senin</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari[]" value="Selasa" class="edit-hari"><span>Selasa</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari[]" value="Rabu" class="edit-hari"><span>Rabu</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari[]" value="Kamis" class="edit-hari"><span>Kamis</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari[]" value="Jumat" class="edit-hari"><span>Jumat</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari[]" value="Sabtu" class="edit-hari"><span>Sabtu</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari[]" value="Minggu" class="edit-hari"><span>Minggu</span>
                        </label>
                    </div>
                </div>

                <!-- JAM PRAKTIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Praktik</label>
                    <div class="flex gap-2">
                        <input id="edit-jam-mulai" type="time" name="jam_mulai"
                            class="w-full px-3 py-2 border rounded-lg">
                        <span class="self-center">-</span>
                        <input id="edit-jam-selesai" type="time" name="jam_selesai"
                            class="w-full px-3 py-2 border rounded-lg">
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection


@push('scripts')
    <script>
        function openCreateModal() {
            document.getElementById('create-modal').classList.remove('hidden')
        }

        function closeCreateModal() {
            document.getElementById('create-modal').classList.add('hidden')
        }

        function openEditModal() {
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        function editJadwal(id, dokter_id, poli_id, hari, jam) {
            let form = document.getElementById('edit-form');
            form.action = "/jadwal_dokter/" + id;

            document.getElementById('edit-dokter').value = dokter_id;
            document.getElementById('edit-poli').value = poli_id;

            let hariArray = hari.split(',').map(h => h.trim());
            document.querySelectorAll('.edit-hari').forEach(cb => {
                cb.checked = hariArray.includes(cb.value);
            });

            let jamArray = jam.split(' - ');
            document.getElementById('edit-jam-mulai').value = jamArray[0] || '';
            document.getElementById('edit-jam-selesai').value = jamArray[1] || '';

            openEditModal();
        }
    </script>
@endpush