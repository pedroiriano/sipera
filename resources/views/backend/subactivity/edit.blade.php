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
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">Anggaran bulan Januari</div>
                        <div class="card-body">
                            <input class="form-control" id="budget_01" name="budget_01" type="number" placeholder="Dalam Rupiah (contoh: 1000000)" value="{{ $sub->budget_01 }}" required />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">Anggaran bulan Februari</div>
                        <div class="card-body">
                            <input class="form-control" id="budget_02" name="budget_02" type="number" placeholder="Dalam Rupiah (contoh: 1000000)" value="{{ $sub->budget_02 }}" required />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">Anggaran bulan Maret</div>
                        <div class="card-body">
                            <input class="form-control" id="budget_03" name="budget_03" type="number" placeholder="Dalam Rupiah (contoh: 1000000)" value="{{ $sub->budget_03 }}" required />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">Anggaran bulan April</div>
                        <div class="card-body">
                            <input class="form-control" id="budget_04" name="budget_04" type="number" placeholder="Dalam Rupiah (contoh: 1000000)" value="{{ $sub->budget_04 }}" required />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">Anggaran bulan Mei</div>
                        <div class="card-body">
                            <input class="form-control" id="budget_05" name="budget_05" type="number" placeholder="Dalam Rupiah (contoh: 1000000)" value="{{ $sub->budget_05 }}" required />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">Anggaran bulan Juni</div>
                        <div class="card-body">
                            <input class="form-control" id="budget_06" name="budget_06" type="number" placeholder="Dalam Rupiah (contoh: 1000000)" value="{{ $sub->budget_06 }}" required />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">Anggaran bulan Juli</div>
                        <div class="card-body">
                            <input class="form-control" id="budget_07" name="budget_07" type="number" placeholder="Dalam Rupiah (contoh: 1000000)" value="{{ $sub->budget_07 }}" required />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">Anggaran bulan Agustus</div>
                        <div class="card-body">
                            <input class="form-control" id="budget_08" name="budget_08" type="number" placeholder="Dalam Rupiah (contoh: 1000000)" value="{{ $sub->budget_08 }}" required />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">Anggaran bulan September</div>
                        <div class="card-body">
                            <input class="form-control" id="budget_09" name="budget_09" type="number" placeholder="Dalam Rupiah (contoh: 1000000)" value="{{ $sub->budget_09 }}" required />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">Anggaran bulan Oktober</div>
                        <div class="card-body">
                            <input class="form-control" id="budget_10" name="budget_10" type="number" placeholder="Dalam Rupiah (contoh: 1000000)" value="{{ $sub->budget_10 }}" required />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">Anggaran bulan November</div>
                        <div class="card-body">
                            <input class="form-control" id="budget_11" name="budget_11" type="number" placeholder="Dalam Rupiah (contoh: 1000000)" value="{{ $sub->budget_11 }}" required />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">Anggaran bulan Desember</div>
                        <div class="card-body">
                            <input class="form-control" id="budget_12" name="budget_12" type="number" placeholder="Dalam Rupiah (contoh: 1000000)" value="{{ $sub->budget_12 }}" required />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Fisik</div>
                <div class="card-body">
                    <input class="form-control" id="physic" name="physic" type="text" placeholder="Masukkan Jumlah Fisik (contoh: 83 Orang atau 17 Dokumen)" value="{{ $sub->physic }}" required />
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
