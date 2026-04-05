<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Transaksi Peminjaman</h1>
        
        <?php
        // hitung statistik dengan loop
        $total_transaksi = 0;
        $total_dipinjam = 0;
        $total_dikembalikan = 0;
        
        // loop pertama untuk hitung statistik
        for ($i = 1; $i <= 10; $i++) {

            // logika
            $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";

            $total_transaksi++;

            if ($status == "Dipinjam") {
                $total_dipinjam++;
            } else {
                $total_dikembalikan++;
            }
        }
        ?>
        
        <!-- statistik dalam cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-bg-primary p-3">
                    <h5>Total Transaksi</h5>
                    <p><?= $total_transaksi ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-warning p-3">
                    <h5>Dipinjam</h5>
                    <p><?= $total_dipinjam ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-success p-3">
                    <h5>Dikembalikan</h5>
                    <p><?= $total_dikembalikan ?></p>
                </div>
            </div>
        </div>
        
        <!-- tabel transaksi -->
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Hari</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // loop untuk tampilkan data
                for ($i = 1; $i <= 10; $i++) {

                    // stop di transaksi ke-8
                    if ($i == 8) {
                        break;
                    }

                    // skip genap
                    if ($i % 2 == 0) {
                        continue;
                    }

                    // Generate data transaksi 
                    $id_transaksi = "TRX-" . str_pad($i, 4, "0", STR_PAD_LEFT);
                    $nama_peminjam = "Anggota " . $i;
                    $judul_buku = "Buku Teknologi Vol. " . $i;
                    $tanggal_pinjam = date('Y-m-d', strtotime("-$i days"));
                    $tanggal_kembali = date('Y-m-d', strtotime("+7 days", strtotime($tanggal_pinjam)));
                    $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";

                    // hitung selisih hari
                    $hari = (strtotime($tanggal_kembali) - strtotime($tanggal_pinjam)) / (60 * 60 * 24);

                    // badge warna
                    if ($status == "Dikembalikan") {
                        $badge = "success";
                    } else {
                        $badge = "warning";
                    }

                    echo "<tr>
                            <td>$i</td>
                            <td>$id_transaksi</td>
                            <td>$nama_peminjam</td>
                            <td>$judul_buku</td>
                            <td>$tanggal_pinjam</td>
                            <td>$tanggal_kembali</td>
                            <td>$hari</td>
                            <td><span class='badge bg-$badge'>$status</span></td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>