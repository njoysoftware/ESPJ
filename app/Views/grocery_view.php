 <?php include('layout/header.php'); ?>
 <?php include('layout/menu.php'); ?>
 <?php foreach ($css_files as $file): ?>
     <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
 <?php endforeach; ?>
 <div id="layoutSidenav_content">
     <main>
         <?php if (session()->getFlashdata('error')): ?>
             <div class="alert alert-danger">
                 <?= session()->getFlashdata('error') ?>
             </div>
         <?php endif; ?>
         <div class="container-fluid px-4">

             <h1 class="mt-4"><?php echo $judul; ?></h1>
             <ol class="breadcrumb mb-4">
                 <li class="breadcrumb-item active"> <?= session()->get('username') ? session()->get('username') : 'username' ?></li>
             </ol>
             <div class="row">
                 <div class="col-xl-12 col-md-6">
                     <?php echo $output; ?>
                 </div>

             </div> <!-- row -->

         </div>
     </main>
     <?php foreach ($js_files as $file): ?>
         <script src="<?php echo $file; ?>"></script>
     <?php endforeach; ?>
     <?php include('layout/footer.php'); ?>