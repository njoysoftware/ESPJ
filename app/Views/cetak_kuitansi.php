<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul_browser ?></title>
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 0.5cm;

            }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 2px;
            padding: 0;
            font-size: 11px;
        }

        .kwitansi {
            border: 1px solid #000;
            padding: 20px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            margin: 20px 0;
        }

        .info-table,
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px;
            vertical-align: top;
        }

        .terbilang-box {
            border: 1px solid #000;
            padding: 5px;
        }

        .ttd-table td {
            text-align: center;
            vertical-align: top;
            padding-top: 60px;
        }

        .footer {
            margin-top: 30px;
            margin-right: 10%;
            text-align: right;
        }
    </style>
</head>

<body>
    <table class="info-table">
        <tr>
            <td style="width: 150px;">TA</td>
            <td>: <?= $kuitansi['tahun_anggaran'] ?></td>
        </tr>
        <tr>
            <td>Nomor Bukti</td>
            <td>: <?= $kuitansi['nomor'] ?></td>
        </tr>
        <tr>
            <td>Akun</td>
            <td>: <?= $kuitansi['akun'] ?></td>
        </tr>
    </table>

    <div class="judul">Kwitansi / Bukti Pembayaran</div>

    <table class="info-table">
        <tr>
            <td style="width: 150px;">Sudah terima dari</td>
            <td>: Kuasa Pengguna Anggaran/Pejabat Pembuat Komitmen Bawaslu Kabupaten/Kota <?= $nama_kabupaten ?></td>
        </tr>
        <tr>
            <td>Jumlah Uang :</td>
            <td>Rp. <?= number_format($kuitansi['bruto'], 2, ',', '.') ?>,-</td>
        </tr>
        <tr>
            <td>Terbilang :</td>
            <td>
                <div class="terbilang-box">
                    <i> <?= strtoupper($bruto_terbilang) ?> RUPIAH ,- </i>
                </div>
            </td>
        </tr>
        <tr>
            <td>Untuk Pembayaran :</td>
            <td><?= $kuitansi['keterangan'] ?></td>
        </tr>
        <tr>
            <td>Telah Dipungut :</td>
            <td>
                <table>
                    <tr>
                        <td>Pajak Penghasilan (PPh)</td>
                        <td>: Rp. <?= number_format($kuitansi['pph'], 2, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td>PPN</td>
                        <td>: Rp. <?= number_format($kuitansi['ppn'], 2, ',', '.') ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>Jumlah yang diterima :</td>
            <td>Rp. <?= number_format($kuitansi['netto'], 2, ',', '.') ?>
                (<i> <?= strtoupper($bruto_terbilang) ?> RUPIAH ,- </i>)</td>
        </tr>
    </table>
    <div class="footer">
        <?= $kecamatan ?>, <?= date('d-m-Y', strtotime($kuitansi['tanggal'])) ?>
    </div>

    <table class="ttd-table">
        <tr>
            <td>Menyetujui<br>PPK Bawaslu Kabupaten/Kota <?= $nama_kabupaten ?></td>
            <td>Yang Membayar<br>BP/BPP Bawaslu Kabupaten/Kota <?= $nama_kabupaten ?></td>
            <td>Yang Menyerahkan<br>SPK Panwaslu <?= $kecamatan ?></td>
            <td>Yang Menerima</td>
        </tr>
        <tr>
            <td><br><br><u><?= $nama_ppk ?></u><br>NIP.<?= $nip_ppk ?></td>
            <td><br><br><u><?= $nama_bp ?></u><br>NIP.<?= $nip_bp ?></td>
            <td><br><br><u><?= $kuitansi['pejabat'] ?></u><br>NIP.<?= $kuitansi['nip_pejabat'] ?></td>
            <td><br><br><u><?= $kuitansi['nama_penerima'] ?></u><br><?= $kuitansi['nama_toko'] ?></td>
        </tr>
    </table>

    <div class="footer">
        <p>Catatan: Simpan kuitansi ini sebagai bukti pembayaran yang sah.</p>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
<?php
// End of file: app/Views/cetak_kuitansi.php
// This file is used to generate a printable kuitansi (receipt) in HTML format.


// It includes the kuitansi details such as nomor, nama toko, nama penerima, keterangan, bruto, pajak, and netto.
// The script also includes a print function that allows the user to print the kuitansi directly from
// the browser.
// The HTML structure includes a header with the kuitansi title and details, and a content section
// that displays the kuitansi information in a table format.
// The CSS styles are applied to format the kuitansi layout, including text alignment and table borders.
