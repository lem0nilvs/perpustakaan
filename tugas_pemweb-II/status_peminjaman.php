<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Status Peminjaman Anggota</h1>

    <?php
    // Data
    $nama_anggota = "Budi Santoso";
    $total_pinjaman = 2;
    $buku_terlambat = 1;
    $hari_keterlambatan = 5;

    $max_pinjam = 3;
    $denda_per_hari = 1000;
    $max_denda = 50000;

    // Status pinjam
    if ($buku_terlambat > 0) {
        $status = "Tidak bisa meminjam (ada keterlambatan)";
        $badge = "danger";
    } elseif ($total_pinjaman >= $max_pinjam) {
        $status = "Tidak bisa meminjam (mencapai batas)";
        $badge = "warning";
    } else {
        $status = "Boleh meminjam";
        $badge = "success";
    }

    // Denda
    if ($buku_terlambat > 0) {
        $total_denda = $buku_terlambat * $hari_keterlambatan * $denda_per_hari;
        if ($total_denda > $max_denda) {
            $total_denda = $max_denda;
        }
    } else {
        $total_denda = 0;
    }

    // Level (SWITCH)
    switch (true) {
        case ($total_pinjaman <= 5):
            $level = "Bronze";
            break;
        case ($total_pinjaman <= 15):
            $level = "Silver";
            break;
        default:
            $level = "Gold";
    }
    ?>

    <!-- Card Informasi -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><?= $nama_anggota ?></h5>
            <p>Total Pinjaman: <?= $total_pinjaman ?> buku</p>
            <p>Buku Terlambat: <?= $buku_terlambat ?></p>
            <p>Hari Keterlambatan: <?= $hari_keterlambatan ?> hari</p>
        </div>
    </div>

    <!-- Status -->
    <div class="alert alert-<?= $badge ?>">
        <?= $status ?>
    </div>

    <!-- Denda -->
    <div class="card mb-4">
        <div class="card-body">
            <h5>Total Denda</h5>
            <h3>Rp <?= number_format($total_denda, 0, ',', '.') ?></h3>
            <?php if ($buku_terlambat > 0): ?>
                <div class="alert alert-danger mt-2">
                    Segera kembalikan buku!
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Level Member -->
    <div class="card">
        <div class="card-body">
            <h5>Level Member</h5>
            <span class="badge bg-primary"><?= $level ?></span>
        </div>
    </div>

</div>
</body>
</html>