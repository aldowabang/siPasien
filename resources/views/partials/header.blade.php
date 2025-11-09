
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
                <li class="nav-item ">
                    <a href="" class="nav-link"><i class="typcn typcn-chart-area-outline"></i> Dashboard</a>
                </li>
                <li class="nav-item {{ $title == 'Medicines List' || $title == 'Add Penduduk' || $title == 'Edit Penduduk' ? 'active' : '' }}">
                        <a href="" class="nav-link"><i class="typcn typcn-user"></i>Data Pasien</a>
                </li>
                
                
            </li>
            
            </ul>
            </div><!-- az-header-menu -->
            <div class="az-header-right">
            
            </div><!-- az-header-notification -->
            <div class="dropdown az-profile-menu">
                <a href="" class="az-img-user"><img src="Azia/img/faces/face1.jpg" alt=""></a>
                <div class="dropdown-menu">
                <div class="az-dropdown-header d-sm-none">
                    <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                </div>
                <div class="az-header-profile">
                    <div class="az-img-user">
                    <img src="Azia/img/faces/face1.jpg" alt="">
                    </div><!-- az-img-user -->
                    <h6></h6>
                    <span></span>
                </div><!-- az-header-profile -->

                <a href="" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My Profile</a>
                <form method="POST" class="logout-form" action="">
                    <button type="submit" class="dropdown-item"><i class="typcn typcn-power-outline"></i> Sign Out</button>
                </form>
                </div><!-- dropdown-menu -->
            </div>
            </div><!-- az-header-right -->
        </div><!-- container -->
        </div><!-- az-header -->