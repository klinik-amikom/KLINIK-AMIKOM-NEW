@extends('layouts.app')

@section('title', 'Kelola Jadwal Klinik')
@section('page-title', 'Kelola Jadwal Klinik')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Kelola Jadwal Klinik
            </h2>
            <p class="text-gray-600 dark:text-gray-400">
                Kelola jam operasional klinik
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
                        <th class="px-6 py-3 text-xs uppercase">Hari Praktik</th>
                        <th class="px-6 py-3 text-xs uppercase">Jam Praktik</th>
                        <th class="px-6 py-3 text-xs uppercase text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($jadwal as $j)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $j->hari }}</td>
                            <td class="px-6 py-4">{{ $j->jam_buka }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-3">
                                    <button type="button"
                                        onclick="editJadwal('{{ $j->id_jadwal }}', '{{ $j->hari }}', '{{ $j->jam_buka }}')"
                                        class="text-purple-600 hover:text-purple-800">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('jadwal_klinik.destroy', $j->id_jadwal) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-10 text-gray-500">
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
            <div class="p-4 border-b flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Jadwal Klinik</h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('jadwal_klinik.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <!-- HARI -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hari Praktik</label>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="hari[]" value="{{ $hari }}">
                                <span>{{ $hari }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- JAM PRAKTIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Praktik</label>
                    <div class="flex items-center gap-2">
                        <input type="time" id="create-jam-mulai" name="jam_mulai"
                            class="w-full px-3 py-2 border rounded-lg">
                        <span>-</span>
                        <input type="time" id="create-jam-selesai" name="jam_selesai"
                            class="w-full px-3 py-2 border rounded-lg">
                        <label class="flex items-center gap-1 ml-2">
                            <input type="checkbox" id="create-tutup" name="tutup" value="1"> TUTUP
                        </label>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="closeCreateModal()"
                        class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div id="edit-modal"
        class="fixed inset-0 bg-black/50 hidden backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md overflow-y-auto max-h-[90vh]">
            <div class="p-4 border-b flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Jadwal Klinik</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="edit-form" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <!-- HARI -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hari Praktik</label>
                    <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto p-2 border rounded-lg">
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="hari[]" value="{{ $hari }}" class="edit-hari">
                                <span>{{ $hari }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- JAM PRAKTIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Praktik</label>
                    <div class="flex items-center gap-2">
                        <input type="time" id="edit-jam-mulai" name="jam_mulai"
                            class="w-full px-3 py-2 border rounded-lg">
                        <span>-</span>
                        <input type="time" id="edit-jam-selesai" name="jam_selesai"
                            class="w-full px-3 py-2 border rounded-lg">
                        <label class="flex items-center gap-1 ml-2">
                            <input type="checkbox" id="edit-tutup" name="tutup" value="1"> TUTUP
                        </label>
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
        // CREATE MODAL TUTUP
        document.getElementById('create-tutup').addEventListener('change', function() {
            let jamMulai = document.getElementById('create-jam-mulai');
            let jamSelesai = document.getElementById('create-jam-selesai');
            if (this.checked) {
                jamMulai.value = '';
                jamSelesai.value = '';
                jamMulai.disabled = true;
                jamSelesai.disabled = true;
            } else {
                jamMulai.disabled = false;
                jamSelesai.disabled = false;
            }
        });

        // EDIT MODAL TUTUP
        document.getElementById('edit-tutup').addEventListener('change', function() {
            let jamMulai = document.getElementById('edit-jam-mulai');
            let jamSelesai = document.getElementById('edit-jam-selesai');
            if (this.checked) {
                jamMulai.value = '';
                jamSelesai.value = '';
                jamMulai.disabled = true;
                jamSelesai.disabled = true;
            } else {
                jamMulai.disabled = false;
                jamSelesai.disabled = false;
            }
        });

        function openCreateModal() {
            document.getElementById('create-modal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('create-modal').classList.add('hidden');
        }

        function openEditModal() {
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        function editJadwal(id, hari, jam_buka) {
            let form = document.getElementById('edit-form');
            form.action = "/jadwal_klinik/" + id;

            // set checkbox hari
            let hariArray = hari.split(', ');
            document.querySelectorAll('.edit-hari').forEach(cb => cb.checked = hariArray.includes(cb.value));

            // set jam
            let tutupCheckbox = document.getElementById('edit-tutup');
            let jamMulai = document.getElementById('edit-jam-mulai');
            let jamSelesai = document.getElementById('edit-jam-selesai');

            if (jam_buka === 'TUTUP') {
                tutupCheckbox.checked = true;
                jamMulai.value = '';
                jamSelesai.value = '';
                jamMulai.disabled = true;
                jamSelesai.disabled = true;
            } else {
                tutupCheckbox.checked = false;
                let jamArray = jam_buka.split(' - ');
                jamMulai.value = jamArray[0] || '';
                jamSelesai.value = jamArray[1] || '';
                jamMulai.disabled = false;
                jamSelesai.disabled = false;
            }

            openEditModal();
        }
    </script>
@endpush
