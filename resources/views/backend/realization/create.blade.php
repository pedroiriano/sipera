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
<form action="{{ route('realization-store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="container-fluid px-4">
    @include('inc.alert-message')
    <div class="row gx-4">
        <div class="col-lg-8">
            @if ($user->role_id == 1)
            <div class="card mb-4">
                <div class="card-header">Sub Kegiatan</div>
                <div class="card-body">
                    <select class="form-control" id="subact" name="subact">
                        @foreach ($subs as $sub_id => $sub)
                        <option value="{{ $sub_id }}">{{ $sub }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @else
            {{-- Other Users --}}
            @endif
            <div class="card mb-4">
                <div class="card-header">Jumlah Bulan yang Telah Diinput Realisasi</div>
                <div class="card-body">
                    <input class="form-control" id="realization_count" name="realization_count" type="number" placeholder="Jumlah Bulan yang Sudah Realisasi (contoh: 3)" disabled />
                </div>
            </div>
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
            <div class="card mb-4">
                <div class="card-header">Anggaran Kas yang Telah Digunakan</div>
                <div class="card-body">
                    <input class="form-control" id="budget_cash" name="budget_cash" type="text" placeholder="Anggaran Kas Sampai dengan Bulan Realisasi" disabled />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Realisasi Anggaran</div>
                <div class="card-body">
                    <input class="form-control" id="budget_use" name="budget_use" type="number" placeholder="Masukkan Realisasi Anggaran (contoh: 15000000)" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Target Kinerja</div>
                <div class="card-body">
                    <input class="form-control" id="physic" name="physic" type="text" placeholder="Target Kinerja" disabled />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Realisasi Kinerja</div>
                <div class="card-body">
                    <input class="form-control" id="physic_use" name="physic_use" type="text" placeholder="Masukkan Realisasi Kinerja (contoh: 17 Dokumen atau 45 Pegawai)" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Fisik (%)</div>
                <div class="card-body">
                    <input class="form-control" id="performance" name="performance" type="number" placeholder="Masukkan Realisasi Fisik dalam Persentase (contoh: 15)" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Kategori Masalah</div>
                <div class="card-body">
                    <input class="form-control" id="problem_category" name="problem_category" type="text" placeholder="Masukkan Kategori Masalah (contoh: Lain-lain)" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Deskripsi Masalah</div>
                <div class="card-body">
                    <input class="form-control" id="problem_description" name="problem_description" type="text" placeholder="Masukkan Deskripsi Masalah (contoh: Dibayarkan sesuai kebutuhan)" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Solusi Masalah</div>
                <div class="card-body">
                    <input class="form-control" id="problem_solution" name="problem_solution" type="text" placeholder="Masukkan Solusi Masalah (contoh: Dibayarkan sesuai kebutuhan)" />
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
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$("#subact").change(function() {
    var subId = $(this).val();

    $.ajax({
        url: "{{ route('get-target') }}",
        type: "POST",
        data: { sub_id: subId },
        success: function(response) {
            // var formattedDueAmount = formatToRupiah(response.due_amount);
            // var formattedDailyRetribution = formatToRupiah(response.daily_retribution);
            // $('#due_amount').val(formattedDueAmount);
            // $('#daily_retribution').val(formattedDailyRetribution);
            $('#physic').val(response.performance_target);
            $('#budget_cash').val(response.sum_budget);
            $('#realization_count').val(response.realization_count);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});

$("#subact").trigger("change");

function formatToRupiah(number) {
    return number.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
}
</script>
@endsection
