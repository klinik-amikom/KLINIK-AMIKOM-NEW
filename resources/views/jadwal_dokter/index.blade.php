@extends('layouts.app')

@section('title', 'Kelola Jadwal Dokter')
@section('page-title', 'Kelola Jadwal Dokter')

@section('content')

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
                            <td class="px-6 py-4">{{ $j->nama_dokter }}</td>
                            <td class="px-6 py-4">{{ $j->poli }}</td>
                            <td class="px-6 py-4">{{ $j->hari_praktik }}</td>
                            <td class="px-6 py-4">{{ $j->jam_praktik }}</td>

                            <td class="px-6 py-4 text-right">

                                <div class="flex justify-end space-x-3">

                                    <button
                                        onclick="editJadwal(
                                        '{{ $j->id_jadwal }}',
                                        '{{ $j->nama_dokter }}',
                                        '{{ $j->poli }}',
                                        '{{ $j->hari_praktik }}',
                                        '{{ $j->jam_praktik }}'
                                        )"
                                        class="text-purple-600 hover:text-purple-800">

                                        <i class="fas fa-edit"></i>

                                    </button>

                                    <form action="{{ route('jadwal_dokter.destroy', $j->id_jadwal) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="text-red-600 hover:text-red-800">
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Dokter
                    </label>

                    <input name="nama_dokter" placeholder="Masukkan nama dokter" class="w-full px-3 py-2 border rounded-lg">
                </div>


                <!-- POLI -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Poli
                    </label>

                    <select name="poli" class="w-full px-3 py-2 border rounded-lg">

                        <option value="">Pilih Poli</option>
                        <option value="Umum">Poli Umum</option>
                        <option value="Gigi">Poli Gigi</option>

                    </select>
                </div>


                <!-- HARI -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Hari Praktik
                    </label>

                    <div class="grid grid-cols-2 gap-2">

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari_praktik[]" value="Senin">
                            <span>Senin</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari_praktik[]" value="Selasa">
                            <span>Selasa</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari_praktik[]" value="Rabu">
                            <span>Rabu</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari_praktik[]" value="Kamis">
                            <span>Kamis</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari_praktik[]" value="Jumat">
                            <span>Jumat</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari_praktik[]" value="Sabtu">
                            <span>Sabtu</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari_praktik[]" value="Minggu">
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
                    <input id="edit-nama" name="nama_dokter" class="w-full px-3 py-2 border rounded-lg">
                </div>

                <!-- POLI -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Poli</label>
                    <select id="edit-poli" name="poli" class="w-full px-3 py-2 border rounded-lg">
                        <option value="Umum">Poli Umum</option>
                        <option value="Gigi">Poli Gigi</option>
                    </select>
                </div>

                <!-- HARI PRAKTIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hari Praktik</label>
                    <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto p-2 border rounded-lg">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari_praktik[]" value="Senin"
                                class="edit-hari"><span>Senin</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari_praktik[]" value="Selasa"
                                class="edit-hari"><span>Selasa</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari_praktik[]" value="Rabu"
                                class="edit-hari"><span>Rabu</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari_praktik[]" value="Kamis"
                                class="edit-hari"><span>Kamis</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari_praktik[]" value="Jumat"
                                class="edit-hari"><span>Jumat</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari_praktik[]" value="Sabtu"
                                class="edit-hari"><span>Sabtu</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hari_praktik[]" value="Minggu"
                                class="edit-hari"><span>Minggu</span>
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

        function editJadwal(id, nama, poli, hari, jam) {
            let form = document.getElementById('edit-form');
            form.action = "/jadwal_dokter/" + id;

            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-poli').value = poli;

            // pecah hari
            let hariArray = hari.split(', ');
            document.querySelectorAll('.edit-hari').forEach(cb => cb.checked = hariArray.includes(cb.value));

            // pecah jam
            let jamArray = jam.split(' - ');
            document.getElementById('edit-jam-mulai').value = jamArray[0] || '';
            document.getElementById('edit-jam-selesai').value = jamArray[1] || '';

            openEditModal();
        }
    </script>
@endpush
