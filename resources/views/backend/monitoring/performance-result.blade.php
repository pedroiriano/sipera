@extends('layouts.backend')

@section('css')
<link rel="stylesheet" href="{{ asset('css/backend/styles.css') }}">
<!-- Include DataTables CSS and JavaScript libraries -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<!-- Include DataTables Buttons extension -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
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
            <div class="table-responsive">
                <table id="datatablesPrint">
                    <thead>
                        <tr>
                            <th class="text-center">Nama Kegiatan</th>
                            <th class="text-center">Anggaran</th>
                            <th class="text-center">Rencana Anggaran</th>
                            <th class="text-center">Realisasi</th>
                            <th class="text-center">Kesesuaian Pelaksanaan (%)</th>
                            <th class="text-center">Kategori Masalah</th>
                            <th class="text-center">Rincian Masalah</th>
                            <th class="text-center">Solusi</th>
                            <th class="text-center">Bulan</th>
                            <th class="text-center">Tahun</th>
                            <th class="text-center">Perangkat Daerah</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="text-center">Nama Kegiatan</th>
                            <th class="text-center">Anggaran</th>
                            <th class="text-center">Rencana Anggaran</th>
                            <th class="text-center">Realisasi</th>
                            <th class="text-center">Kesesuaian Pelaksanaan (%)</th>
                            <th class="text-center">Kategori Masalah</th>
                            <th class="text-center">Rincian Masalah</th>
                            <th class="text-center">Solusi</th>
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
                                        <td>{{ $rea->budget }}</td>
                                        <td>{{ $rea->physic }}</td>
                                        <td>{{ $rea->physic_use }}</td>
                                        <td>{{ $rea->performance }}</td>
                                        <td>{{ $rea->problem_category }}</td>
                                        <td>{{ $rea->problem_description }}</td>
                                        <td>{{ $rea->problem_solution }}</td>
                                        <td>{{ $month_string }}</td>
                                        <td>{{ $rea->year }}</td>
                                        <td>{{ $rea->name }}</td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="11" class="text-center">Data Masih Kosong</td>
                            </tr>
                            @endif
                        @else

                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function () {
    $('#datatablesPrint').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel'
        ]
    });
});
</script>
@endsection
