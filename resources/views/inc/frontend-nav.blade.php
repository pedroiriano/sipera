<!-- Navbar-->
<nav class="navbar navbar-marketing navbar-expand-lg bg-white navbar-light">
    <div class="container px-5">
        <a class="navbar-brand text-dark" href="/">
            <div class="brand-container">
                <img src="{{ asset('images/brand/lambang-depok.png') }}" alt="" class="d-inline-block align-text-top" style="height: 48px">
                <div class="brand-text fs-6">
                    Sistem Informasi Pelaporan Capaian Kinerja <br>
                    Kecamatan Pancoran Mas
                </div>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto me-lg-5">
                <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
                <li class="nav-item dropdown dropdown-md no-caret">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownDemos" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Panduan
                        <i class="fas fa-chevron-right dropdown-arrow"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end animated--fade-in-up me-lg-n25 me-xl-n15" aria-labelledby="navbarDropdownDemos">
                        <div class="row g-0">
                            <div class="col-lg-7 p-lg-5">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h6 class="dropdown-header text-primary">Buku Penggunaan</h6>
                                            <a class="dropdown-item" href="{{ asset('download/book.pdf') }}" target="_blank">Unduh</a>
                                        <div class="dropdown-divider border-0 d-lg-none"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
            {{-- @guest
            <a class="btn fw-500 ms-lg-4 btn-teal" href="{{ route('login') }}">
                Masuk
                <i class="ms-2" data-feather="arrow-right"></i>
            </a>
            @endguest --}}
            {{-- @auth
            <a class="btn fw-500 ms-lg-4 btn-teal" href="{{ route('backend') }}">
                Masuk
                <i class="ms-2" data-feather="arrow-right"></i>
            </a>
            @endauth --}}
        </div>
    </div>
</nav>
