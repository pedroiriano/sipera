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
                        <div class="page-header-icon"><i data-feather="coffee"></i></div>
                        Detail Sub Kegiatan
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="/sub/{{ $sub->id }}/edit">
                        <i class="me-1" data-feather="edit"></i>
                        Ubah
                    </a>
                    <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="me-1" data-feather="trash-2"></i>
                        Hapus
                    </a>
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
<div class="container-fluid px-4">
    @include('inc.alert-message')
    <div class="card">
        <div class="card-header">Sub Kegiatan</div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ms-0">
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                                ID Sub Kegiatan
                            </div>
                            <div class="col-6">
                                {{ $sub->id }}
                            </div>
                        </div>
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                                Nama Sub Kegiatan
                            </div>
                            <div class="col-6">
                                {{ $sub->sub_activity }}
                            </div>
                        </div>
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                                Anggaran Sub Kegiatan
                            </div>
                            <div class="col-6">
                                {{ $sub->budget_total }}
                            </div>
                        </div>
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                                Nama Kegiatan
                            </div>
                            <div class="col-6">
                                {{ $sub->activity->activity }}
                            </div>
                        </div>
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                                Nama Program
                            </div>
                            <div class="col-6">
                                {{ $sub->activity->program->program }}
                            </div>
                        </div>
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                                Tahun Anggaran
                            </div>
                            <div class="col-6">
                                {{ $sub->activity->program->year }}
                            </div>
                        </div>
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                                Perangkat Daerah
                            </div>
                            <div class="col-6">
                                {{ $sub->activity->program->region->name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalTitle">Hapus Data</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Yakin Ingin Menghapus Data?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                    Tidak
                </button>
                <form class="btn" action="{{ route('sub-delete', $sub->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">
                        <a class="text-decoration-none text-white">
                            Ya
                        </a>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
