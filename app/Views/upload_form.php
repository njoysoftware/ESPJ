 <?php include('layout/header.php'); ?>
 <?php include('layout/menu.php'); ?>
 <div id="layoutSidenav_content">
     <main>
         <div class="container-fluid px-4">
             <h1 class="mt-4"><?php echo $judul; ?></h1>
             <ol class="breadcrumb mb-4">
                 <li class="breadcrumb-item active"><?php echo $sub_judul; ?></li>
             </ol>
             <div class="row">
                 <form method="post" action="UploadController/uploadrab" enctype="multipart/form-data">
                     <?php if (session()->getFlashdata('message')): ?>
                         <div class="alert alert-default">
                             <?= session()->getFlashdata('message') ?>
                         </div>
                     <?php endif; ?>

                     <div class="form-group">
                         <label>Bulan</label>
                         <select name="bulan" class="form-control" id="bulan">
                             <option value="Januari">Januari</option>
                             <option value="Februari">Februari</option>
                             <option value="Maret">Maret</option>
                             <option value="April">April</option>
                             <option value="Mei">Mei</option>
                             <option value="Juni">Juni</option>
                             <option value="Juli">Juli</option>
                             <option value="Agustus">Agustus</option>
                             <option value="September">September</option>
                             <option value="Oktober">Oktober</option>
                             <option value="Nopember">Nopember</option>
                             <option value="Desember">Desember</option>

                         </select>
                     </div>
                     <div class="form-group">
                         <label>File Excel</label>
                         <input type="file" name="upload_file" class="form-control" id="upload_file" required accept=".xls, .xlsx" /></p>
                     </div>
                     <div class="form-group">
                         <button class="btn btn-primary" type="submit">Upload</button>
                     </div>
                 </form>
             </div>


         </div>
     </main>
     <?php include('layout/footer.php'); ?>