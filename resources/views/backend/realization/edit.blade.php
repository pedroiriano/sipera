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
                        Tambah Realisasi
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
<form action="{{ route('realization-update', $rea->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="container-fluid px-4">
    @include('inc.alert-message')
    <div class="row gx-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">Sub Kegiatan</div>
                <div class="card-body">
                    <input class="form-control" id="subact_show" name="subact_show" type="text" value="{{ $rea->subactivity->sub_activity }} - {{ $rea->subactivity->activity->activity }} - {{ $rea->subactivity->activity->program->program }} - {{ $rea->subactivity->activity->program->year }}" disabled />
                </div>
            </div>
            <input type="hidden" id="subact" name="subact" value="{{ $rea->sub_activity_id }}" />
            <div class="card mb-4">
                <div class="card-header">Bulan</div>
                <div class="card-body">
                    <input class="form-control" id="month_show" name="month_show" type="text" value="{{ $rea->month }}" disabled />
                </div>
            </div>
            <input type="hidden" id="month" name="month" value="{{ $rea->month }}" />
            <div class="card mb-4">
                <div class="card-header">Anggaran yang Tersedia</div>
                <div class="card-body">
                    <input class="form-control" id="budget_available" name="budget_available" type="text" placeholder="Anggaran Kas Tersedia" value="{{ $budget_available }}" disabled />
                </div>
            </div>
            <input type="hidden" id="available" name="available" value="{{ $budget_available }}" />
            <div class="card mb-4">
                <div class="card-header">Anggaran Kas yang Telah Digunakan</div>
                <div class="card-body">
                    <input class="form-control" id="budget_cash" name="budget_cash" type="text" placeholder="Anggaran Kas Sampai dengan Bulan Realisasi" value="{{ $sumBudget }}" disabled />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Realisasi Anggaran</div>
                <div class="card-body">
                    <input class="form-control" id="budget_use" name="budget_use" type="number" placeholder="Masukkan Realisasi Anggaran (contoh: 15000000)" value="{{ $rea->budget_use }}" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Target Kinerja</div>
                <div class="card-body">
                    <input class="form-control" id="physic" name="physic" type="text" placeholder="Target Kinerja" value="{{ $performanceTarget }}" disabled />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Realisasi Kinerja</div>
                <div class="card-body">
                    <input class="form-control" id="physic_use" name="physic_use" type="text" placeholder="Masukkan Realisasi Kinerja (contoh: 17 Dokumen atau 45 Pegawai)" value="{{ $rea->physic_use }}" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Fisik (%)</div>
                <div class="card-body">
                    <input class="form-control" id="performance" name="performance" type="number" placeholder="Masukkan Realisasi Fisik dalam Persentase (contoh: 15)" value="{{ $rea->performance }}" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Kategori Masalah</div>
                <div class="card-body">
                    <input class="form-control" id="problem_category" name="problem_category" type="text" placeholder="Masukkan Kategori Masalah (contoh: Lain-lain)" value="{{ $rea->problem_category }}" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Deskripsi Masalah</div>
                <div class="card-body">
                    <input class="form-control" id="problem_description" name="problem_description" type="text" placeholder="Masukkan Deskripsi Masalah (contoh: Dibayarkan sesuai kebutuhan)" value="{{ $rea->problem_description }}" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Solusi Masalah</div>
                <div class="card-body">
                    <input class="form-control" id="problem_solution" name="problem_solution" type="text" placeholder="Masukkan Solusi Masalah (contoh: Dibayarkan sesuai kebutuhan)" value="{{ $rea->problem_solution }}" />
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
                        <div class="d-grid"><button type="submit" class="fw-500 btn btn-primary">Simpan</button></div>
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
var budgetUseInput = document.getElementById("budget_use");
var budgetAvailableInput = document.getElementById("budget_available");

budgetUseInput.addEventListener("input", function() {
    var budgetUseValue = parseFloat(budgetUseInput.value);
    var budgetAvailableValue = parseFloat(budgetAvailableInput.value);

    if (budgetUseValue > budgetAvailableValue) {
        alert("Realisasi anggaran tidak dapat melebihi anggaran yang tersedia.");
        budgetUseInput.value = "";
    }
});
</script>
@endsection
