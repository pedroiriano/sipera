@extends('layouts.frontend')

@section('css')
<link rel="stylesheet" href="{{ asset('css/frontend/styles.css') }}">
@endsection

@section('content')
<!-- Page Header-->
<header class="page-header-ui page-header-ui-light" style="background-image: url({{ asset('images/bg/monitoring.png') }}); background-size: auto 100%">
    <div class="page-header-ui-content">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-xl-8 col-lg-10 text-center">
                    @include('inc.alert-message')
                    <h1 class="page-header-ui-title fw-bold text-white" style="background-color: rgba(128, 128, 128, 0.5); display: inline; text-shadow: 2px 2px #000000">SIPERA</h1>
                    <p class="page-header-ui-text fw-bold mb-5 text-white" style="background-color: rgba(128, 128, 128, 0.5); display: inline; text-shadow: 2px 2px #000000">Sistem Informasi Pelaporan Capaian Kinerja</p>
                    <p class="page-header-ui-text fw-bold mb-5 text-white" style="background-color: rgba(128, 128, 128, 0.5); display: inline; text-shadow: 2px 2px #000000">Kecamatan Pancoran Mas</p>
                    @auth
                    <a class="btn btn-teal fw-bold me-2" href="">Masuk Sistem</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>
@endsection
