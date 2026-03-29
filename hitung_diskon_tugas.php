<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perhitungan Diskon - Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <h2 class="mb-4 text-center">Sistem Perhitungan Diskon Bertingkat</h2>
        
        <?php
        // data pembeli dan buku
        $nama_pembeli = "Budi Santoso";
        $judul_buku = "Laravel Advanced";
        $harga_satuan = 150000;
        $jumlah_beli = 4;
        $is_member = true; 
        
        // subtotal sebelum diskon
        $subtotal = $harga_satuan * $jumlah_beli;
        
        // persentase diskon berdasarkan jumlah
        $persentase_diskon = 0;
        if ($jumlah_beli > 10) {
            $persentase_diskon = 20;
        } elseif ($jumlah_beli >= 6 && $jumlah_beli <= 10) {
            $persentase_diskon = 15;
        } elseif ($jumlah_beli >= 3 && $jumlah_beli <= 5) {
            $persentase_diskon = 10;
        } else {
            $persentase_diskon = 0; // 1-2 buku
        }
        
        // hitung diskon
        $diskon = $subtotal * ($persentase_diskon / 100);
        
        // total setelah diskon prtama
        $total_setelah_diskon1 = $subtotal - $diskon;
        
        // diskon member (jika member)
        $diskon_member = 0;
        if ($is_member) {
            $diskon_member = $total_setelah_diskon1 * 0.05;
        }
        
        // total setelah semua diskon
        $total_setelah_diskon = $total_setelah_diskon1 - $diskon_member;
        
        // PPN (11%)
        $ppn = $total_setelah_diskon * 0.11;
        
        // total akhir
        $total_akhir = $total_setelah_diskon + $ppn;
        
        // total penghematan
        $total_hemat = $diskon + $diskon_member;

        // format biar rupiah
        function formatRupiah($angka) {
            return "Rp " . number_format($angka, 0, ',', '.');
        }
        ?>

        
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Rincian Pembelian</h5>
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-4">
                            <p><strong>Nama Pembeli:</strong> <?= $nama_pembeli ?> </p>
                            <p><strong>Status:</strong>
                            <?php if($is_member): ?>
                                <span class="badge bg-success ms-2">Member</span>
                            <?php else: ?>
                                <span class="badge bg-secondary ms-2">Non-Member</span>
                            <?php endif; ?>
                            </p>
                        </div>

                        <table class="table table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <td width="50%">Judul Buku</td>
                                    <td><?= $judul_buku ?></td>
                                </tr>
                                <tr>
                                    <td>Harga Satuan</td>
                                    <td><?= formatRupiah($harga_satuan) ?></td>
                                </tr>
                                <tr>
                                    <td>Jumlah Dibeli</td>
                                    <td><?= $jumlah_beli ?> buku</td>
                                </tr>
                                <tr class="table-secondary">
                                    <th>Subtotal</th>
                                    <th><?= formatRupiah($subtotal) ?></th>
                                </tr>
                                <tr>
                                    <td>Diskon (<?= $persentase_diskon ?>%)</td>
                                    <td class="text-danger">- <?= formatRupiah($diskon) ?></td>
                                </tr>
                                
                                <?php if($is_member): ?>
                                <tr>
                                    <td>
                                        Diskon Member (5%)<br>
                                        <small class="text-muted">(dari <?= formatRupiah($total_setelah_diskon1) ?>)</small>
                                    </td>
                                    <td class="text-danger align-middle">- <?= formatRupiah($diskon_member) ?></td>
                                </tr>
                                <?php endif; ?>

                                <tr class="table-light">
                                    <th>Total Setelah Diskon</th>
                                    <th><?= formatRupiah($total_setelah_diskon) ?></th>
                                </tr>
                                <tr>
                                    <td>PPN (11%)</td>
                                    <td>+ <?= formatRupiah($ppn) ?></td>
                                </tr>
                                <tr class="table-primary fs-5">
                                    <th>Total Akhir</th>
                                    <th><?= formatRupiah($total_akhir) ?></th>
                                </tr>
                            </tbody>
                        </table>

                        <div class="alert alert-success mt-4 d-flex justify-content-between align-items-center">
                            <strong>Total Penghematan Anda:</strong>
                            <span class="fs-5 fw-bold"><?= formatRupiah($total_hemat) ?></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>