<?php
// modules/anggota/index.php
session_start();
require_once '../../koneksi.php';

// Export to Excel Logic (Bonus)
if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data_Anggota_Perpustakaan.xls");
    $export_mode = true;
} else {
    $export_mode = false;
}

// Fitur Search & Filter
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$filter_status = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';
$filter_jk = isset($_GET['jk']) ? $conn->real_escape_string($_GET['jk']) : '';

$where_clause = "WHERE 1=1";
if ($search != '') {
    $where_clause .= " AND (nama LIKE '%$search%' OR email LIKE '%$search%' OR telepon LIKE '%$search%')";
}
if ($filter_status != '') {
    $where_clause .= " AND status = '$filter_status'";
}
if ($filter_jk != '') {
    $where_clause .= " AND jenis_kelamin = '$filter_jk'";
}

// Pagination Logic
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_data_query = $conn->query("SELECT COUNT(*) as total FROM anggota $where_clause");
$total_data = $total_data_query->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);

// Fetch Data
$query = "SELECT * FROM anggota $where_clause ORDER BY id_anggota DESC " . ($export_mode ? "" : "LIMIT $limit OFFSET $offset");
$result = $conn->query($query);

// Dashboard Statistics (Bonus)
$stat_total = $conn->query("SELECT COUNT(*) as c FROM anggota")->fetch_assoc()['c'];
$stat_aktif = $conn->query("SELECT COUNT(*) as c FROM anggota WHERE status='Aktif'")->fetch_assoc()['c'];
$stat_nonaktif = $conn->query("SELECT COUNT(*) as c FROM anggota WHERE status='Nonaktif'")->fetch_assoc()['c'];

if ($export_mode) {
    echo "<table border='1'>
            <tr><th>No</th><th>Kode</th><th>Nama</th><th>Email</th><th>Telepon</th><th>L/P</th><th>Status</th><th>Tanggal Daftar</th></tr>";
    $no = 1;
    while($row = $result->fetch_assoc()){
        echo "<tr>
                <td>".$no++."</td>
                <td>".htmlspecialchars($row['kode_anggota'])."</td>
                <td>".htmlspecialchars($row['nama'])."</td>
                <td>".htmlspecialchars($row['email'])."</td>
                <td>".htmlspecialchars($row['telepon'])."</td>
                <td>".htmlspecialchars($row['jenis_kelamin'])."</td>
                <td>".htmlspecialchars($row['status'])."</td>
                <td>".htmlspecialchars($row['tanggal_daftar'])."</td>
              </tr>";
    }
    echo "</table>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">Data Anggota Perpustakaan</h2>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary"><div class="card-body">Total Anggota: <?= htmlspecialchars($stat_total) ?></div></div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success"><div class="card-body">Aktif: <?= htmlspecialchars($stat_aktif) ?></div></div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-secondary"><div class="card-body">Nonaktif: <?= htmlspecialchars($stat_nonaktif) ?></div></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama/Email/Telepon" value="<?= htmlspecialchars($search) ?>">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Aktif" <?= $filter_status == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Nonaktif" <?= $filter_status == 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="jk" class="form-select">
                        <option value="">Semua Gender</option>
                        <option value="Laki-laki" <?= $filter_jk == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $filter_jk == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="index.php" class="btn btn-secondary">Reset</a>
                    <a href="?export=excel&search=<?= htmlspecialchars($search) ?>&status=<?= htmlspecialchars($filter_status) ?>&jk=<?= htmlspecialchars($filter_jk) ?>" class="btn btn-success">Export Excel</a>
                </div>
            </form>
        </div>
    </div>

    <div class="mb-3">
        <a href="create.php" class="btn btn-primary">+ Tambah Anggota</a>
    </div>

    <div class="table-responsive bg-white shadow-sm">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Foto</th>
                    <th>Kode</th>
                    <th>Nama & Info</th>
                    <th>Gender</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if(isset($row['foto']) && $row['foto'] && file_exists("uploads/".htmlspecialchars($row['foto']))): ?>
                                <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" width="60" class="img-thumbnail">
                            <?php else: ?>
                                <span class="text-muted">No Photo</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['kode_anggota']) ?></td>
                        <td>
                            <strong><?= htmlspecialchars($row['nama']) ?></strong><br>
                            <small><?= htmlspecialchars($row['email']) ?> | <?= htmlspecialchars($row['telepon']) ?></small>
                        </td>
                        <td>
                            <?php if($row['jenis_kelamin'] == 'Laki-laki'): ?>
                                <span class="badge bg-info text-dark">Laki-laki</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Perempuan</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($row['status'] == 'Aktif'): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= htmlspecialchars($row['id_anggota']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete.php?id=<?= htmlspecialchars($row['id_anggota']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">Data tidak ditemukan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($total_pages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for($i=1; $i<=$total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= htmlspecialchars($search) ?>&status=<?= htmlspecialchars($filter_status) ?>&jk=<?= htmlspecialchars($filter_jk) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>

</div>
</body>
</html>