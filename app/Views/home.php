 <?php include('layout/header.php'); ?>
 <?php include('layout/menu.php'); ?>
 <div id="layoutSidenav_content">
     <main>
         <div class="container-fluid px-4">
             <?php if (session()->getFlashdata('error')): ?>
                 <div class="alert alert-danger">
                     <?= session()->getFlashdata('error') ?>
                 </div>
             <?php endif; ?>
             <h1 class="mt-4"><?php echo $judul; ?></h1>
             <ol class="breadcrumb mb-4">
                 <li class="breadcrumb-item active"><?php echo $sub_judul; ?></li>
             </ol>
             <div class="row">
                 <div class="col-xl-3 col-md-6">
                     <div class="card bg-success text-white mb-4">
                         <div class="card-body">
                             <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>Data RAB Kecamatan
                         </div>
                         <div class="card-footer d-flex align-items-center bg-white  justify-content-between">
                             <a class="small text-black stretched-link" href="/rab">Lihat</a>
                             <div class="small text-black"><i class="fas fa-angle-right"></i></div>
                         </div>
                     </div>
                 </div>

             </div>

             <div class="row">
                 <div class="col-xl-3 col-md-6">
                     <div class="card bg-primary text-white mb-4">
                         <div class="card-body">
                             <div class="sb-nav-link-icon"><i class="fas fa-briefcase"></i></div>Buat Kuitansi
                         </div>
                         <div class="card-footer d-flex align-items-center bg-white  justify-content-between">
                             <a class="small text-black stretched-link" href="/kuitansi">Lihat</a>
                             <div class="small text-black"><i class="fas fa-angle-right"></i></div>
                         </div>
                     </div>
                 </div>
             </div>


             <div class="row">
                 <div class="col-xl-3 col-md-6">
                     <div class="card bg-danger text-white mb-4">
                         <div class="card-body">
                             <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>Setting SPK Kecamatan
                         </div>
                         <div class="card-footer d-flex align-items-center bg-white  justify-content-between">
                             <a class="small text-black stretched-link" href="/setting/pejabat">Lihat</a>
                             <div class="small text-black"><i class="fas fa-angle-right"></i></div>
                         </div>
                     </div>
                 </div>
                 <div class="col-xl-3 col-md-6">
                     <div class="card bg-danger text-white mb-4">
                         <div class="card-body">
                             <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>Setting User
                         </div>
                         <div class="card-footer d-flex align-items-center bg-white  justify-content-between">
                             <a class="small text-black stretched-link" href="/setting/user">Lihat</a>
                             <div class="small text-black"><i class="fas fa-angle-right"></i></div>
                         </div>
                     </div>
                 </div>
             </div> <!-- row -->

         </div>
     </main>
     <?php include('layout/footer.php'); ?>