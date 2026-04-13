<?php
// ngambil/manggil dari file functions_anggota.php
require_once 'functions_anggota.php';

// data anggota
$anggota_list = [
    ["id"=>"AGT-001","nama"=>"Budi Santoso","email"=>"budi@email.com","status"=>"Aktif","total_pinjaman"=>5,"tanggal_daftar"=>"2024-01-15"],
    ["id"=>"AGT-002","nama"=>"Siti Aminah","email"=>"siti@email.com","status"=>"Non-Aktif","total_pinjaman"=>2,"tanggal_daftar"=>"2024-02-10"],
    ["id"=>"AGT-003","nama"=>"Andi Saputra","email"=>"andi@email.com","status"=>"Aktif","total_pinjaman"=>8,"tanggal_daftar"=>"2024-03-05"],
    ["id"=>"AGT-004","nama"=>"Dewi Lestari","email"=>"dewi@email.com","status"=>"Aktif","total_pinjaman"=>4,"tanggal_daftar"=>"2024-01-20"],
    ["id"=>"AGT-005","nama"=>"Rizky Pratama","email"=>"rizky@email.com","status"=>"Non-Aktif","total_pinjaman"=>1,"tanggal_daftar"=>"2024-02-25"]
];

// search
$keyword = $_GET['search'] ?? '';
if ($keyword != '') {
    $anggota_list = search_nama($anggota_list, $keyword);
}

// sort
$sort = $_GET['sort'] ?? '';

if ($sort == 'nama') {
    $anggota_list = sort_by_nama($anggota_list);
} elseif ($sort == 'id') {
    $anggota_list = sort_by_id($anggota_list);
}

// statisik
$total = hitung_total_anggota($anggota_list);
$aktif = hitung_anggota_aktif($anggota_list);
$nonaktif = $total - $aktif;
$rata = hitung_rata_rata_pinjaman($anggota_list);
$teraktif = cari_anggota_teraktif($anggota_list);
// SORT
$sort = $_GET['sort'] ?? '';

if ($sort == 'nama') {
    $anggota_list = sort_by_nama($anggota_list);
} elseif ($sort == 'id') {
    $anggota_list = sort_by_id($anggota_list);
}

// filter status
$aktif_list = filter_by_status($anggota_list, "Aktif");
$nonaktif_list = filter_by_status($anggota_list, "Non-Aktif");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4"><i class="bi bi-people"></i> Sistem Anggota Perpustakaan</h1>
    
    <!-- statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white p-3">
                Total Anggota <br> <?= $total ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white p-3">
                Aktif <br> <?= $aktif ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white p-3">
                Non-Aktif <br> <?= $nonaktif ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning p-3">
                Rata-rata Pinjaman <br> <?= round($rata,2) ?>
            </div>
        </div>
    </div>

    <!-- search -->
    <form method="GET" class="mb-3">
        <input type="text" name="search" class="form-control w-25 d-inline" placeholder="Cari nama..." value="<?= $keyword ?>">
        <button class="btn btn-primary">Search</button>
    
    <select name="sort" class="form-select w-25 d-inline">
        <option value="">-- Urutkan --</option>
        <option value="nama" <?= ($sort=='nama')?'selected':'' ?>>Nama A-Z</option>
        <option value="id" <?= ($sort=='id')?'selected':'' ?>>ID</option>
    </select>

    <button class="btn btn-primary">Urutkan</button>
    </form>
    <!-- tabel anggota -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Anggota</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Pinjaman</th>
                        <th>Tanggal</th>
                        <th>Valid Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($anggota_list as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= $a['nama'] ?></td>
                        <td><?= $a['email'] ?></td>
                        <td>
                            <span class="badge bg-<?= $a['status']=="Aktif"?"success":"secondary" ?>">
                                <?= $a['status'] ?>
                            </span>
                        </td>
                        <td><?= $a['total_pinjaman'] ?></td>
                        <td><?= format_tanggal_indo($a['tanggal_daftar']) ?></td>
                        <td>
                            <?= validasi_email($a['email']) ? 
                                '<span class="text-success">Valid</span>' : 
                                '<span class="text-danger">Tidak Valid</span>' ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- anggota teraktif -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Anggota Teraktif</h5>
        </div>
        <div class="card-body">
            <h4><?= $teraktif['nama'] ?></h4>
            <p>Total Pinjaman: <?= $teraktif['total_pinjaman'] ?></p>
        </div>
    </div>

    <!-- lis aktif -->
    <div class="card mb-3">
        <div class="card-header bg-success text-white">Anggota Aktif</div>
        <div class="card-body">
            <?php foreach ($aktif_list as $a) echo $a['nama']."<br>"; ?>
        </div>
    </div>

    <!-- list non aktif -->
    <div class="card">
        <div class="card-header bg-danger text-white">Anggota Non-Aktif</div>
        <div class="card-body">
            <?php foreach ($nonaktif_list as $a) echo $a['nama']."<br>"; ?>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>