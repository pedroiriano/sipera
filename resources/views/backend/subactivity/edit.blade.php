@extends('layouts.backend')

@section('css')
<link rel="stylesheet" href="{{ asset('css/backend/styles.css') }}">
@endsection

@section('content')
<!-- Main Content-->
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="file-plus"></i></div>
                        Ubah Sub Kegiatan
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{ route('sub') }}">
                        <i class="me-1" data-feather="arrow-left"></i>
                        Kembali ke Tabel Sub Kegiatan
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<form action="{{ route('sub-update', $sub->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="container-fluid px-4">
    @include('inc.alert-message')
    <div class="row gx-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">Sub Kegiatan</div>
                <div class="card-body">
                    <input class="form-control" id="subact" name="subact" type="text" placeholder="Masukkan Nama Sub Kegiatan (contoh: Belanja Pegawai)" value="{{ $sub->sub_activity }}" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Anggaran</div>
                <div class="card-body">
                    <input class="form-control" id="budget" name="budget" type="number" placeholder="Masukkan Anggaran dalam Rupiah (contoh: 1000000)" value="{{ $sub->budget }}" required />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Fisik</div>
                <div class="card-body">
                    <input class="form-control" id="physic" name="physic" type="number" placeholder="Masukkan Jumlah Fisik (contoh: 83)" value="{{ $sub->physic }}" required />
                </div>
            </div>
            @if ($user->role_id == 1)
            <div class="card mb-4">
                <div class="card-header">Kegiatan</div>
                <div class="card-body">
                    <select class="form-control" id="activity" name="activity">
                        @foreach ($acts as $act_id => $act)
                        <option value="{{ $act_id }}" {{ $act_id == $sub->activity_id ? 'selected' : '' }}>{{ $act }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @else
            {{-- Other Users --}}
            @endif
        </div>
        <!-- Sticky Navigation-->
        <div class="col-lg-4">
            <div class="nav-sticky">
                <div class="card card-header-actions">
                    <div class="card-header">
                        Aksi
                        <i class="text-muted" data-feather="info" data-bs-toggle="tooltip" data-bs-placement="left" title="Tombol Ulang untuk mengosongkan formulir isian, sedangkan tombol Simpan untuk menyimpan data."></i>
                    </div>
                    <div class="card-body">
                        <div class="d-grid mb-3"><button type="reset" class="fw-500 btn btn-primary-soft text-primary">Ulang</button></div>
                        <div class="d-grid"><button type="submit" class="fw-500 btn btn-primary">Simpan</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
@endsection
