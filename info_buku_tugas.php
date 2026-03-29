<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Informasi Buku</h1>

        <div class="row">

        <?php
        // Buku 1
        $judul = "Laravel: From Beginner to Advanced";
        $pengarang = "Budi Raharjo";
        $penerbit = "Informatika";
        $tahun_terbit = 2023;
        $harga = 125000;
        $stok = 8;
        $isbn = "978-602-1234-56-7";
        $kategori = "Programming";
        $bahasa = "Indonesia";
        $halaman = 450;
        $berat = 700;
        ?>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><?php echo $judul; ?></h5>
                    <span class="badge bg-success"><?php echo $kategori; ?></span>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Pengarang</th>
                            <td>: <?php echo $pengarang; ?></td>
                        </tr>
                        <tr>
                            <th>Penerbit</th>
                            <td>: <?php echo $penerbit; ?></td>
                        </tr>
                        <tr>
                            <th>Tahun Terbit</th>
                            <td>: <?php echo $tahun_terbit; ?></td>
                        </tr>
                        <tr>
                            <th>ISBN</th>
                            <td>: <?php echo $isbn; ?></td>
                        </tr>
                        <tr>
                            <th>Bahasa</th>
                            <td>: <?php echo $bahasa; ?></td>
                        </tr>
                        <tr>
                            <th>Jumlah Halaman</th>
                            <td>: <?php echo $halaman; ?></td>
                        </tr>
                        <tr>
                            <th>Berat Buku</th>
                            <td>: <?php echo $berat; ?> gram</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>: Rp <?php echo number_format($harga,0,',','.'); ?></td>
                        </tr>
                        <tr>
                            <th>Stok</th>
                            <td>: <?php echo $stok; ?> buku</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <?php
        // Buku 2
        $judul2 = "MySQL Database Administration";
        $pengarang2 = "Andi Setiawan";
        $penerbit2 = "Elex Media";
        $tahun_terbit2 = 2022;
        $harga2 = 110000;
        $stok2 = 5;
        $isbn2 = "978-602-8899-21-3";
        $kategori2 = "Database";
        $bahasa2 = "Indonesia";
        $halaman2 = 380;
        $berat2 = 600;
        ?>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><?php echo $judul2; ?></h5>
                    <span class="badge bg-warning text-dark"><?php echo $kategori2; ?></span>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr><th width="200">Pengarang</th><td>: <?php echo $pengarang2; ?></td></tr>
                        <tr><th>Penerbit</th><td>: <?php echo $penerbit2; ?></td></tr>
                        <tr><th>Tahun Terbit</th><td>: <?php echo $tahun_terbit2; ?></td></tr>
                        <tr><th>ISBN</th><td>: <?php echo $isbn2; ?></td></tr>
                        <tr><th>Bahasa</th><td>: <?php echo $bahasa2; ?></td></tr>
                        <tr><th>Jumlah Halaman</th><td>: <?php echo $halaman2; ?></td></tr>
                        <tr><th>Berat Buku</th><td>: <?php echo $berat2; ?> gram</td></tr>
                        <tr><th>Harga</th><td>: Rp <?php echo number_format($harga2,0,',','.'); ?></td></tr>
                        <tr><th>Stok</th><td>: <?php echo $stok2; ?> buku</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <?php
        // Buku 3
        $judul3 = "Belajar HTML & CSS";
        $pengarang3 = "Rina Putri";
        $penerbit3 = "Gramedia";
        $tahun_terbit3 = 2021;
        $harga3 = 95000;
        $stok3 = 10;
        $isbn3 = "978-602-7788-11-4";
        $kategori3 = "Web Design";
        $bahasa3 = "Indonesia";
        $halaman3 = 300;
        $berat3 = 500;
        ?>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><?php echo $judul3; ?></h5>
                    <span class="badge bg-info text-dark"><?php echo $kategori3; ?></span>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr><th width="200">Pengarang</th><td>: <?php echo $pengarang3; ?></td></tr>
                        <tr><th>Penerbit</th><td>: <?php echo $penerbit3; ?></td></tr>
                        <tr><th>Tahun Terbit</th><td>: <?php echo $tahun_terbit3; ?></td></tr>
                        <tr><th>ISBN</th><td>: <?php echo $isbn3; ?></td></tr>
                        <tr><th>Bahasa</th><td>: <?php echo $bahasa3; ?></td></tr>
                        <tr><th>Jumlah Halaman</th><td>: <?php echo $halaman3; ?></td></tr>
                        <tr><th>Berat Buku</th><td>: <?php echo $berat3; ?> gram</td></tr>
                        <tr><th>Harga</th><td>: Rp <?php echo number_format($harga3,0,',','.'); ?></td></tr>
                        <tr><th>Stok</th><td>: <?php echo $stok3; ?> buku</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <?php
        // Buku 4
        $judul4 = "JavaScript untuk Pemula";
        $pengarang4 = "Dian Pratama";
        $penerbit4 = "Informatika";
        $tahun_terbit4 = 2024;
        $harga4 = 130000;
        $stok4 = 6;
        $isbn4 = "978-602-1111-22-9";
        $kategori4 = "Programming";
        $bahasa4 = "Inggris";
        $halaman4 = 420;
        $berat4 = 650;
        ?>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><?php echo $judul4; ?></h5>
                    <span class="badge bg-primary"><?php echo $kategori4; ?></span>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr><th width="200">Pengarang</th><td>: <?php echo $pengarang4; ?></td></tr>
                        <tr><th>Penerbit</th><td>: <?php echo $penerbit4; ?></td></tr>
                        <tr><th>Tahun Terbit</th><td>: <?php echo $tahun_terbit4; ?></td></tr>
                        <tr><th>ISBN</th><td>: <?php echo $isbn4; ?></td></tr>
                        <tr><th>Bahasa</th><td>: <?php echo $bahasa4; ?></td></tr>
                        <tr><th>Jumlah Halaman</th><td>: <?php echo $halaman4; ?></td></tr>
                        <tr><th>Berat Buku</th><td>: <?php echo $berat4; ?> gram</td></tr>
                        <tr><th>Harga</th><td>: Rp <?php echo number_format($harga4,0,',','.'); ?></td></tr>
                        <tr><th>Stok</th><td>: <?php echo $stok4; ?> buku</td></tr>
                    </table>
                </div>
            </div>
        </div>

        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>