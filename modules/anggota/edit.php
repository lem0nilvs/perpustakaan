<?php
// modules/anggota/edit.php
session_start();
require_once '../../koneksi.php';

if(!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];
$anggota = $conn->query("SELECT * FROM anggota WHERE id_anggota = $id")->fetch_assoc();

if(!$anggota) {
    header("Location: index.php");
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = $_POST['kode_anggota'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telp = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $tgl_lahir = $_POST['tanggal_lahir'];
    $jk = $_POST['jenis_kelamin'];
    $pekerjaan = $_POST['pekerjaan'];
    $status = $_POST['status'];

    // Validasi
    if(empty($kode) || empty($nama) || empty($email) || empty($telp) || empty($alamat) || empty($tgl_lahir) || empty($jk)) {
        $errors[] = "Semua field yang ditandai * wajib diisi.";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Format email tidak valid.";
    if(!preg_match('/^08[0-9]{7,13}$/', $telp)) $errors[] = "Nomor telepon harus diawali 08.";
    
    $dob = new DateTime($tgl_lahir);
    $now = new DateTime();
    if($now->diff($dob)->y < 10) $errors[] = "Umur minimal harus 10 tahun.";

    // Validasi Unik
    $stmt_cek = $conn->prepare("SELECT id_anggota FROM anggota WHERE (kode_anggota=? OR email=?) AND id_anggota != ?");
    $stmt_cek->bind_param("ssi", $kode, $email, $id);
    $stmt_cek->execute();
    if($stmt_cek->get_result()->num_rows > 0) {
        $errors[] = "Kode Anggota atau Email sudah dipakai pengguna lain.";
    }

    // Handle Upload Foto
    $foto_name = isset($anggota['foto']) ? $anggota['foto'] : '';

    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_name_baru = time() . "_" . uniqid() . "." . $ext;

        if(move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto_name_baru)) {

            // hapus foto lama
            if(isset($anggota['foto']) && $anggota['foto'] && file_exists("uploads/".$anggota['foto'])) {
                unlink("uploads/".$anggota['foto']);
            }

            $foto_name = $foto_name_baru;
        }
    }

    // Update data
    if(empty($errors)) {
        $stmt = $conn->prepare("UPDATE anggota SET kode_anggota=?, nama=?, email=?, telepon=?, alamat=?, tanggal_lahir=?, jenis_kelamin=?, pekerjaan=?, status=?, foto=? WHERE id_anggota=?");
        $stmt->bind_param("ssssssssssi", $kode, $nama, $email, $telp, $alamat, $tgl_lahir, $jk, $pekerjaan, $status, $foto_name, $id);

        if($stmt->execute()) {
            $_SESSION['success'] = "Data anggota berhasil diupdate!";
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Gagal update data: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4 mb-5">
    <div class="card shadow-sm" style="max-width: 600px; margin:auto;">
        
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Edit Data Anggota</h4>
        </div>

        <div class="card-body">

            <?php if(!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach($errors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label>Kode Anggota *</label>
                    <input type="text" name="kode_anggota" class="form-control" required value="<?= htmlspecialchars($anggota['kode_anggota']) ?>">
                </div>

                <div class="mb-3">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" class="form-control" required value="<?= htmlspecialchars($anggota['nama']) ?>">
                </div>

                <div class="mb-3">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($anggota['email']) ?>">
                </div>

                <div class="mb-3">
                    <label>Telepon *</label>
                    <input type="text" name="telepon" class="form-control" required value="<?= htmlspecialchars($anggota['telepon']) ?>">
                </div>

                <div class="mb-3">
                    <label>Alamat *</label>
                    <textarea name="alamat" class="form-control" required><?= htmlspecialchars($anggota['alamat']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Tanggal Lahir *</label>
                    <input type="date" name="tanggal_lahir" class="form-control" required value="<?= htmlspecialchars($anggota['tanggal_lahir']) ?>">
                </div>

                <div class="mb-3">
                    <label>Jenis Kelamin *</label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="Laki-laki" <?= $anggota['jenis_kelamin']=='Laki-laki' ? 'selected':'' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $anggota['jenis_kelamin']=='Perempuan' ? 'selected':'' ?>>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="Aktif" <?= $anggota['status']=='Aktif' ? 'selected':'' ?>>Aktif</option>
                        <option value="Nonaktif" <?= $anggota['status']=='Nonaktif' ? 'selected':'' ?>>Nonaktif</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" value="<?= htmlspecialchars($anggota['pekerjaan']) ?>">
                </div>

                <div class="mb-3">
                    <label>Ganti Foto (opsional)</label><br>

                    <?php if(isset($anggota['foto']) && $anggota['foto']): ?>
                        <img src="uploads/<?= htmlspecialchars($anggota['foto']) ?>" width="100" class="mb-2 img-thumbnail">
                    <?php endif; ?>

                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-warning w-100">Update Data</button>
                <a href="index.php" class="btn btn-secondary w-100 mt-2">Kembali</a>

            </form>
        </div>
    </div>
</div>

</body>
</html>