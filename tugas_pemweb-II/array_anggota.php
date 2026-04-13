<?php
// data anggota
$anggota_list = [
    [
        "id" => "AGT-001",
        "nama" => "Budi Santoso",
        "email" => "budi@email.com",
        "telepon" => "081234567890",
        "alamat" => "Jakarta",
        "tanggal_daftar" => "2024-01-15",
        "status" => "Aktif",
        "total_pinjaman" => 5
    ],
    [
        "id" => "AGT-002",
        "nama" => "Siti Aminah",
        "email" => "siti@email.com",
        "telepon" => "081234567891",
        "alamat" => "Bandung",
        "tanggal_daftar" => "2024-02-10",
        "status" => "Non-Aktif",
        "total_pinjaman" => 2
    ],
    [
        "id" => "AGT-003",
        "nama" => "Andi Saputra",
        "email" => "andi@email.com",
        "telepon" => "081234567892",
        "alamat" => "Surabaya",
        "tanggal_daftar" => "2024-03-05",
        "status" => "Aktif",
        "total_pinjaman" => 8
    ],
    [
        "id" => "AGT-004",
        "nama" => "Dewi Lestari",
        "email" => "dewi@email.com",
        "telepon" => "081234567893",
        "alamat" => "Yogyakarta",
        "tanggal_daftar" => "2024-01-20",
        "status" => "Aktif",
        "total_pinjaman" => 4
    ],
    [
        "id" => "AGT-005",
        "nama" => "Rizky Pratama",
        "email" => "rizky@email.com",
        "telepon" => "081234567894",
        "alamat" => "Semarang",
        "tanggal_daftar" => "2024-02-25",
        "status" => "Non-Aktif",
        "total_pinjaman" => 1
    ]
];

// proses data anggota
$total_anggota = count($anggota_list);

$aktif = 0;
$non_aktif = 0;
$total_pinjaman = 0;
$terbanyak = $anggota_list[0];

foreach ($anggota_list as $anggota) {
    if ($anggota['status'] == "Aktif") {
        $aktif++;
    } else {
        $non_aktif++;
    }

    $total_pinjaman += $anggota['total_pinjaman'];

    if ($anggota['total_pinjaman'] > $terbanyak['total_pinjaman']) {
        $terbanyak = $anggota;
    }
}

$rata_rata = $total_pinjaman / $total_anggota;
$persen_aktif = ($aktif / $total_anggota) * 100;
$persen_non_aktif = ($non_aktif / $total_anggota) * 100;

//filter anggota berdasar status
$status_filter = $_GET['status'] ?? '';

$filtered_data = [];

foreach ($anggota_list as $anggota) {
    if ($status_filter == "" || $anggota['status'] == $status_filter) {
        $filtered_data[] = $anggota;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2 class="mb-4">Data Anggota Perpustakaan</h2>

<!-- statistik -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white p-3">
            Total Anggota <br> <?= $total_anggota ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white p-3">
            Aktif (<?= round($persen_aktif) ?>%) <br> <?= $aktif ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white p-3">
            Non-Aktif (<?= round($persen_non_aktif) ?>%) <br> <?= $non_aktif ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark p-3">
            Rata-rata Pinjaman <br> <?= round($rata_rata, 2) ?>
        </div>
    </div>
</div>

<!-- anggota teraktif -->
<div class="alert alert-info">
    <b>Anggota Teraktif:</b> <?= $terbanyak['nama'] ?> 
    (<?= $terbanyak['total_pinjaman'] ?> pinjaman)
</div>

<!--- filter anggota --->
<form method="GET" class="mb-3">
    <select name="status" class="form-select w-25 d-inline">
        <option value="">Semua</option>
        <option value="Aktif">Aktif</option>
        <option value="Non-Aktif">Non-Aktif</option>
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
</form>

<!-- tabel buat anggota -->
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Tanggal Daftar</th>
            <th>Status</th>
            <th>Total Pinjaman</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filtered_data as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= $a['nama'] ?></td>
            <td><?= $a['email'] ?></td>
            <td><?= $a['telepon'] ?></td>
            <td><?= $a['alamat'] ?></td>
            <td><?= $a['tanggal_daftar'] ?></td>
            <td>
                <span class="badge bg-<?= $a['status']=="Aktif" ? "success":"secondary" ?>">
                    <?= $a['status'] ?>
                </span>
            </td>
            <td><?= $a['total_pinjaman'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>