@extends('layouts.frontend')

@section('css')
<link rel="stylesheet" href="{{ asset('css/frontend/styles.css') }}">
@endsection

@section('content')
<!-- Page Header-->
<header class="page-header-ui page-header-ui-light" style="background-image: url({{ asset('images/bg/monitoring.png') }}); background-size: auto 100%">
    <div class="page-header-ui-content">
        <div class="container px-5">
            <div class="row gx-0 justify-content-end">
                <div class="col-xl-8 col-lg-10 text-center">
                    @include('inc.alert-message')
                    <h1 class="page-header-ui-title text-black">SIPERA</h1>
                    <p class="page-header-ui-text mb-5 text-black">Sistem Informasi Pelaporan Capaian Kinerja</p>
                    @auth
                    <a class="btn btn-teal fw-500 me-2" href="">Masuk Sistem</a>
                    @endauth
                    <a class="btn btn-link fw-500 text-black" href="#commodity-price">Jelajahi</a>
                </div>
            </div>
        </div>
    </div>
</header>
@endsection
