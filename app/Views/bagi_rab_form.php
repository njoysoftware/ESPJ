 <?php include('layout/header.php'); ?>
 <?php include('layout/menu.php'); ?>
 <div id="layoutSidenav_content">
     <main>
         <div class="container-fluid px-4">
             <h1 class="mt-4"><?php echo $judul; ?></h1>
             <ol class="breadcrumb mb-4">
                 <li class="breadcrumb-item active"><?php echo $sub_judul; ?></li>
             </ol>
             <?php if (session()->getFlashdata('message')): ?>
                 <div class="alert alert-default">
                     <?= session()->getFlashdata('message') ?>
                 </div>
             <?php endif; ?>

             <div class="row">
                 <form method="post" action="bagirab" enctype="multipart/form-data" class="form-control">
                     <div class="form-group form-control">
                         <label>Kecamatan</label>
                         <select name="kecamatan" class="form-control" id="kecamatan">
                             <option value="">------- Pilih Kecamatan -----</option>
                             <?php
                                foreach ($kecamatan as $key => $value): ?>
                                 <option value="<?= $value['id_kecamatan'] ?>"><?= $value['nama_kecamatan'] ?></option>
                             <?php endforeach; ?>
                         </select>
                     </div>
                     <div class="form-group form-control">
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
                     <div class="form-group form-control">
                         <label>Tahun Anggaran</label>
                         <?php $tahun_awal =  date('Y') - 2; ?>
                         <?php $tahun_akhir = date('Y') + 5; ?>
                         <select name="ta" class="form-control" id="ta">
                             <option value="">----- Tahun Anggaran ------</option>
                             <?php for ($tahun = $tahun_awal; $tahun <= $tahun_akhir; $tahun++) { ?>
                                 <option value="<?= $tahun ?>"> <?= $tahun ?> </option>
                             <?php } ?>
                         </select>
                     </div>
                     <div class="form-control">
                         <button class="btn btn-primary" type="submit">Export</button>
                     </div>
             </div>

             <div class="row">
                 <div class="col-xl-12 col-md-12">

                     <h1 class="mt-4"> <label class="caption-top">Data RAB Kecamatan</label></h1>

                     <table class="table datatable-table table-bordered" id="">
                         <thead>
                             <th>
                                 Nomor
                             </th>
                             <th>
                                 Nama Kecamatan
                             </th>
                             <th>
                                 id akun
                             </th>
                             <th>
                                 Bulan
                             </th>
                         </thead>
                         <?php
                            $no = 1;
                            foreach ($akun as $key => $value): ?>
                             <tbody>
                                 <tr>
                                     <td><?= $no ?></td>
                                     <td><?= $value['nama_kecamatan'] ?></td>
                                     <td><?= $value['kementerian'] ?>.<?= $value['program'] ?>.<?= $value['kegiatan'] ?>.<?= $value['output'] ?>.<?= $value['komponen'] ?>.<?= $value['sub_komponen'] ?>.<?= $value['kode_akun'] ?>.<?= $value['akun'] ?>.<?= $value['detail'] ?></td>
                                     <td><?= $value['bulan'] ?></td>

                                 </tr>
                             </tbody>
                         <?php
                                $no++;
                            endforeach; ?>

                     </table>
                 </div>
             </div>


         </div>
     </main>
     <?php include('layout/footer.php'); ?>