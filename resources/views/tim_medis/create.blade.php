@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Tim Medis</h4>

    <form action="{{ route('tim_medis.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-2">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control">
        </div>

        <div class="mb-2">
            <label>Spesialis</label>
            <input type="text" name="spesialis" class="form-control">
        </div>

        <div class="mb-2">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>

        <div class="mb-2">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection