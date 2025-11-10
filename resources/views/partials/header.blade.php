<div class="az-header">
    <div class="container">
        <div class="az-header-left">
            <a href="index.html" class="az-logo"><span>SI Data Pasien</span></a>
            <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
        </div><!-- az-header-left -->
        
        <div class="az-header-menu">
            <div class="az-header-menu-header">
                <a href="index.html" class="az-logo"><span></span> SI Data Pasien</a>
                <a href="" class="close">&times;</a>
            </div><!-- az-header-menu-header -->
            
            <ul class="nav">
                <!-- Menu Dashboard - Semua role bisa akses -->
                <li class="nav-item {{ in_array($title, ['Dashboard']) ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="typcn typcn-chart-area-outline"></i> Dashboard
                    </a>
                </li>

                <!-- Menu Data Pasien - Untuk: admin, registrasi, dokter, perawat -->
                @if(in_array(auth()->user()->role, ['admin', 'registrasi', 'dokter', 'perawat']))
                <li class="nav-item {{ $title == 'Data Pasien' || $title == 'Add Pasien' || $title == 'Edit Pasien' || $title == 'Detail Pasien' || $title == 'Data Pasien Terhapus' ? 'active' : '' }}">
                    <a href="{{ route('Pasien') }}" class="nav-link">
                        <i class="typcn typcn-user"></i> Data Pasien
                    </a>
                </li>
                @endif

                <!-- Menu Data Kunjungan - Untuk: admin, perawat -->
                @if(in_array(auth()->user()->role, ['admin', 'perawat']))
                <li class="nav-item {{ $title == 'Data Kunjungan' || $title == 'Tambah Kunjungan' || $title == 'Edit Kunjungan' || $title == 'Detail Kunjungan' || $title == 'Kunjungan Terhapus' ? 'active' : '' }}">
                    <a href="{{ route('visits.index') }}" class="nav-link">
                        <i class="typcn typcn-calendar"></i> Data Kunjungan
                    </a>
                </li>
                @endif

                <!-- Menu Rekam Medis - Untuk: admin, dokter -->
                @if(in_array(auth()->user()->role, ['admin', 'dokter']))
                <li class="nav-item {{ $title == 'Rekam Medis' || $title == 'Riwayat Rekam Medis' || $title == 'Rekam Medis' || $title == 'Edit Rekam Medis' ? 'active' : '' }}">
                    <a href="{{ route('medical-records.index') }}" class="nav-link">
                        <i class="fas fa-file-medical mr-2"></i>
                        <span>Rekam Medis</span>
                    </a>
                </li>
                @endif

                <!-- Menu Master Data - Hanya Admin -->
                @if(auth()->user()->role === 'admin')
                <li class="nav-item dropdown {{ in_array($title, ['Data User']) ? 'active' : '' }}">
                    <a href="" class="nav-link with-sub">
                        <i class="typcn typcn-cog-outline"></i> Master Data
                    </a>
                    <div class="az-menu-sub">
                        <div class="container">
                            <div>
                                <a href="{{ route('users.index') }}" class="nav-link">Data User</a>
                            </div>
                        </div>
                    </div>
                </li>
                @endif

                <!-- Menu khusus untuk role Registrasi -->
                @if(auth()->user()->role === 'registrasi')
                <li class="nav-item {{ $title == 'Pendaftaran Pasien' ? 'active' : '' }}">
                    <a href="{{ route('Pasien') }}" class="nav-link">
                        <i class="typcn typcn-document-add"></i> Pendaftaran Pasien
                    </a>
                </li>
                @endif

                <!-- Menu khusus untuk role Dokter -->
                @if(auth()->user()->role === 'dokter')
                <li class="nav-item dropdown {{ in_array($title, ['Data Pasien', 'Rekam Medis']) ? 'active' : '' }}">
                    <a href="" class="nav-link with-sub">
                        <i class="typcn typcn-stethoscope"></i> Tindakan Medis
                    </a>
                    <div class="az-menu-sub">
                        <div class="container">
                            <div>
                                <a href="{{ route('Pasien') }}" class="nav-link">Data Pasien</a>
                                <a href="{{ route('medical-records.index') }}" class="nav-link">Rekam Medis</a>
                            </div>
                        </div>
                    </div>
                </li>
                @endif

                <!-- Menu khusus untuk role Perawat -->
                @if(auth()->user()->role === 'perawat')
                <li class="nav-item dropdown {{ in_array($title, ['Data Pasien', 'Data Kunjungan']) ? 'active' : '' }}">
                    <a href="" class="nav-link with-sub">
                        <i class="typcn typcn-heart-outline"></i> Perawatan
                    </a>
                    <div class="az-menu-sub">
                        <div class="container">
                            <div>
                                <a href="{{ route('Pasien') }}" class="nav-link">Data Pasien</a>
                                <a href="{{ route('visits.index') }}" class="nav-link">Data Kunjungan</a>
                            </div>
                        </div>
                    </div>
                </li>
                @endif
            </ul>
        </div><!-- az-header-menu -->
        
        <div class="az-header-right">
            <!-- Notifications dan lainnya -->
        </div><!-- az-header-right -->
        
        <div class="dropdown az-profile-menu">
            <a href="" class="az-img-user">
                <img src="{{ asset('Azia/img/faces/face1.jpg') }}" alt="">
            </a>
            <div class="dropdown-menu">
                <div class="az-dropdown-header d-sm-none">
                    <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                </div>
                <div class="az-header-profile">
                    <div class="az-img-user">
                        <img src="{{ asset('Azia/img/faces/face1.jpg') }}" alt="">
                    </div><!-- az-img-user -->
                    <h6>{{ auth()->user()->name }}</h6>
                    <span class="text-capitalize">{{ auth()->user()->role }}</span>
                </div><!-- az-header-profile -->

                <a href="" class="dropdown-item">
                    <i class="typcn typcn-user-outline"></i> My Profile
                </a>
                <form method="POST" class="logout-form" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="typcn typcn-power-outline"></i> Sign Out
                    </button>
                </form>
            </div><!-- dropdown-menu -->
        </div>
    </div><!-- container -->
</div><!-- az-header -->