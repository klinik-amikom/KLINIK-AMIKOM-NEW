@extends('templates.layoutAdmin')

@section('judul')
    <i class="fas fa-user-cog" style="margin-right: 8px; color: #000000;"></i> <strong>DATA ADMIN</strong>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection

@section('konten')

<form style="margin-bottom: 20px;" method="get" action="{{ url('admin') }}">
    <label style="margin-right: 10px;">Masukkan Kode</label>
    <input type="text" name="cari" value="{{ old('cari', request('cari')) }}">

    <label style="margin-right: 10px; margin-left: 20px;">Masukkan Nama</label>
    <input type="text" name="cari_nama" value="{{ old('cari_nama', request('cari_nama')) }}">
    
    <input type="submit" value="Cari Admin">
</form>

<p style="margin-top: 20px;">
    <b>Total: {{ count($data ?? []) }} admin</b>
</p>

<div style="background-color: #f8f9fa; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 20px; margin-top: 20px;">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="text-center fs-5" style="background-color: #b1a2d0; color: white;">No.</th>
                <th class="text-center fs-5" style="background-color: #b1a2d0; color: white;">Kode</th>
                <th class="text-center fs-5" style="background-color: #b1a2d0; color: white;">Nama</th>
                <th class="text-center fs-5" style="background-color: #b1a2d0; color: white;">No Telp</th>
                <th class="text-center fs-5" style="background-color: #b1a2d0; color: white;">Alamat</th>
                <th class="text-center fs-5" style="background-color: #b1a2d0; color: white;">Opsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data ?? [] as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $row->kode_admin ?? '-' }}</td>
                    <td class="text-center">{{ $row->nama_admin ?? '-' }}</td>
                    <td class="text-center">{{ $row->no_telp ?? '-' }}</td>
                    <td class="text-center">{{ $row->alamat ?? '-' }}</td>
                    <td class="text-center">
                        <a href="{{ url('admin/form/ubah/' . $row->id_admin) }}" class="btn btn-sm btn-warning">Ubah</a>
                        <a href="{{ url('admin/hapus/' . $row->id_admin) }}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus data?')">Hapus</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data admin yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
