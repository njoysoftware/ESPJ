    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading"></div>
                        <a class="nav-link" href="/">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Perencanaan</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-bars"></i></div>
                            Perencanaan
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">

                                <?php
                                //     if (session()->get('role') === 'admin') { 
                                ?>
                                <a class="nav-link" href="/akun">
                                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>Data Akun
                                </a>
                                <?php // } 
                                ?>
                                <a class="nav-link" href="/rab">
                                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div> RAB
                                </a>
                                <?php
                                if (session()->get('role') === 'admin') {
                                ?>
                                    <a class="nav-link" href="/UploadController">
                                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div> Upload RAB
                                    </a>
                                <?php  }
                                ?>
                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading">Pembukuan</div>
                        <a class="nav-link" href="/kuitansi">
                            <div class="sb-nav-link-icon"><i class="fas fa-briefcase"></i></div>
                            Buat Kuitansi
                        </a>
                        <a class="nav-link" href="/pelaporan">
                            <div class="sb-nav-link-icon"><i class="fas fa-briefcase"></i></div>
                            Buat BKU
                        </a>
                        <div class="sb-sidenav-menu-heading">Setting</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutssetting" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-gears"></i></div>
                            Setting
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutssetting" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="/setting/kecamatan">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    Kecamatan
                                </a>
                                <a class="nav-link" href="/setting/user">
                                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                    User Kecamatan
                                </a>
                                <a class="nav-link" href="/setting/pejabat">
                                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                    SPK Kecamatan
                                </a>
                                <a class="nav-link" href="/setting/pejabat_kabupaten">
                                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                    PPK dan BP
                                </a>


                            </nav>
                        </div>
                        <?php
                        if (session()->get('role') === 'admin') { ?>
                            <div class="sb-sidenav-menu-heading">Setting admin</div>
                            <a class="nav-link" href="/user">
                                <div class="sb-nav-link-icon"><i class="fas fa-briefcase"></i></div>
                                Setting Profile
                            </a>
                        <?php  } ?>
                    </div>

                </div>

                <div class="sb-sidenav-footer">
                    <div class="small">Masuk Sebagai:</div>
                    <?= session()->get('role') ? session()->get('role') : 'role' ?>
                </div>

            </nav>
        </div>