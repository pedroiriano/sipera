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
                        Monitoring Capaian Kinerja Kegiatan
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{ route('realization') }}">
                        <i class="me-1" data-feather="arrow-left"></i>
                        Kembali ke Tabel Realisasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<form action="{{ route('get-performance') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="container-fluid px-4">
        @include('inc.alert-message')
        <div class="row gx-4">
            <div class="col-lg-8">
                @if (($user->role_id == 1) || ($user->role_id == 2))
                <div class="card mb-4">
                    <div class="card-header">Perangkat Daerah</div>
                    <div class="card-body">
                        <select class="form-control js-example-basic-single" id="region" name="region">
                            @foreach ($regs as $reg_id => $reg)
                            <option value="{{ $reg_id }}">{{ $reg }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @else
                {{-- Other Users --}}
                @endif
                <div class="card mb-4">
                    <div class="card-header">Bulan</div>
                    <div class="card-body">
                        <select class="form-control" id="month" name="month">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                </div>
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
                            <div class="d-grid"><button type="submit" class="fw-500 btn btn-primary">Cari</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
@endsection
