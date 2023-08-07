@extends('layouts.frontend')

@section('css')
<link rel="stylesheet" href="{{ asset('css/frontend/styles.css') }}">
@endsection

@section('content')
<!-- Page Header-->
<header class="page-header-ui page-header-ui-light" style="background-image: url({{ asset('images/bg/monitoring.png') }}); background-size: auto 100%">
    <div class="page-header-ui-content">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-xl-8 col-lg-10 text-end">
                    <h1 class="page-header-ui-title text-black"></h1>
                    <p class="page-header-ui-text mb-5 text-black"></p>
                    <a class="btn btn-link fw-500 text-black"></a>
                </div>
            </div>
        </div>
    </div>
</header>
@endsection
