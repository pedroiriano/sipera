<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Informasi Utama</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dasbor
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseDashboards" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavDashboards">
                        <a class="nav-link" href="">
                            Statistik Umum
                        </a>
                        <a class="nav-link" href="">
                            Statistik Capaian Kinerja
                        </a>
                    </nav>
                </div>
                <!-- Sidenav Heading (Management)-->
                <div class="sidenav-menu-heading">Manajemen Data</div>
                <!-- Sidenav Accordion (Commodity)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseCommodities" aria-expanded="false" aria-controls="collapseCommodities">
                    <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
                    Realisasi
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCommodities" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link" href="">
                            Tabel Realisasi
                        </a>
                        @if (auth()->user()->role_id == 1)
                        <a class="nav-link" href="">
                            Perbarui Realisasi
                        </a>
                        @endif
                    </nav>
                </div>
                <!-- Sidenav Accordion (Sub)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseSubs" aria-expanded="false" aria-controls="collapseSubs">
                    <div class="nav-link-icon"><i data-feather="package"></i></div>
                    Sub Kegiatan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseSubs" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link" href="{{ route('sub') }}">
                            Tabel Sub Kegiatan
                        </a>
                        <a class="nav-link" href="{{ route('sub-form') }}">
                            Tambah Sub Kegiatan
                        </a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Act)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseActs" aria-expanded="false" aria-controls="collapseActs">
                    <div class="nav-link-icon"><i data-feather="package"></i></div>
                    Kegiatan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseActs" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link" href="{{ route('activity') }}">
                            Tabel Kegiatan
                        </a>
                        <a class="nav-link" href="{{ route('activity-form') }}">
                            Tambah Kegiatan
                        </a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Program)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePrograms" aria-expanded="false" aria-controls="collapsePrograms">
                    <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
                    Program
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePrograms" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link" href="{{ route('program') }}">
                            Tabel Program
                        </a>
                        <a class="nav-link" href="{{ route('program-form') }}">
                            Tambah Program
                        </a>
                    </nav>
                </div>
                @if (auth()->user()->role_id == 1)
                <!-- Sidenav Accordion (Region)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseRegions" aria-expanded="false" aria-controls="collapseRegions">
                    <div class="nav-link-icon"><i data-feather="map"></i></div>
                    Wilayah
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseRegions" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link" href="{{ route('district') }}">
                            Tabel Kecamatan
                        </a>
                        <a class="nav-link" href="{{ route('district-form') }}">
                            Tambah Kecamatan
                        </a>
                        <a class="nav-link" href="{{ route('ward') }}">
                            Tabel Kelurahan
                        </a>
                        <a class="nav-link" href="{{ route('ward-form') }}">
                            Tambah Kelurahan
                        </a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (User)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Pengguna
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseUsers" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('role') }}">
                            Tabel Wewenang
                        </a>
                        <a class="nav-link" href="{{ route('role-form') }}">
                            Tambah Wewenang
                        </a>
                        <a class="nav-link" href="{{ route('user') }}">
                            Tabel Pengguna
                        </a>
                        <a class="nav-link" href="{{ route('user-form') }}">
                            Tambah Pengguna
                        </a>
                    </nav>
                </div>
                @endif
                <!-- Sidenav Heading (Pages)-->
                <div class="sidenav-menu-heading">Laman</div>
                <!-- Sidenav Link (Home)-->
                <a class="nav-link" href="{{ route('backend') }}">
                    <div class="nav-link-icon"><i data-feather="home"></i></div>
                    Beranda
                </a>
                <a class="nav-link" href="{{ route('home') }}">
                    <div class="nav-link-icon"><i data-feather="globe"></i></div>
                    Halaman Depan
                </a>
            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Masuk sebagai:</div>
                <div class="sidenav-footer-title">{{ auth()->user()->name }}</div>
            </div>
        </div>
    </nav>
</div>
