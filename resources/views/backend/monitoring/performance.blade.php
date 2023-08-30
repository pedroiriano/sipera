@extends('layouts.backend')

@section('css')
<link rel="stylesheet" href="{{ asset('css/backend/styles.css') }}">
@endsection

@section('content')
<!-- Main Content-->
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="filter"></i></div>
                        Tabel Monitoring Capaian Kinerja Kegiatan
                    </h1>
                    <div class="page-header-subtitle">Data Utama Monitoring Capaian Kinerja Kegiatan</div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-xl px-4 mt-n10">
    @include('inc.alert-message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-12 text-start">
                    Monitoring Capaian Kinerja Kegiatan
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th class="text-center">Nama Kegiatan</th>
                        <th class="text-center">Target Kinerja Kegiatan</th>
                        <th class="text-center">Realisasi</th>
                        <th class="text-center">Fisik (%)</th>
                        <th class="text-center">Kategori Masalah</th>
                        <th class="text-center">Rincian Masalah</th>
                        <th class="text-center">Bulan</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Perangkat Daerah</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">Nama Kegiatan</th>
                        <th class="text-center">Target Kinerja Kegiatan</th>
                        <th class="text-center">Realisasi</th>
                        <th class="text-center">Fisik (%)</th>
                        <th class="text-center">Kategori Masalah</th>
                        <th class="text-center">Rincian Masalah</th>
                        <th class="text-center">Bulan</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Perangkat Daerah</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if (((auth()->user()->role_id) == 1) || ((auth()->user()->role_id) == 2))
                        @if (count($reas) > 0)
                            @foreach ($reas as $rea)
                                @php
                                    switch ($rea->month) {
                                        case 1:
                                            $month_string = 'Januari';
                                            break;
                                        case 2:
                                            $month_string = 'Februari';
                                            break;
                                        case 3:
                                            $month_string = 'Maret';
                                            break;
                                        case 4:
                                            $month_string = 'April';
                                            break;
                                        case 5:
                                            $month_string = 'Mei';
                                            break;
                                        case 6:
                                            $month_string = 'Juni';
                                            break;
                                        case 7:
                                            $month_string = 'Juli';
                                            break;
                                        case 8:
                                            $month_string = 'Agustus';
                                            break;
                                        case 9:
                                            $month_string = 'September';
                                            break;
                                        case 10:
                                            $month_string = 'Oktober';
                                            break;
                                        case 11:
                                            $month_string = 'November';
                                            break;
                                        case 12:
                                            $month_string = 'Desember';
                                            break;
                                        default:
                                            $month_string = 'Terjadi Kesalahan Data';
                                            break;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $rea->sub_activity }}</td>
                                    <td>{{ $rea->physic }}</td>
                                    <td>{{ $rea->physic_use }}</td>
                                    <td>{{ $rea->performance }}</td>
                                    <td>{{ $rea->problem_category }}</td>
                                    <td>{{ $rea->problem_description }}</td>
                                    <td>{{ $month_string }}</td>
                                    <td>{{ $rea->year }}</td>
                                    <td>{{ $rea->name }}</td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="9" class="text-center">Data Masih Kosong</td>
                        </tr>
                        @endif
                    @else

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
