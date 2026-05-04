<?php
// modules/anggota/create.php
session_start();
require_once '../../koneksi.php';

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
    $tgl_daftar = date('Y-m-d');
    $status = 'Aktif';

    // Validasi Required
    if(empty($kode) || empty($nama) || empty($email) || empty($telp) || empty($alamat) || empty($tgl_lahir) || empty($jk)) {
        $errors[] = "Semua field yang ditandai * wajib diisi.";
    }

    // Validasi Email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    }

    // Validasi Telepon
    if(!preg_match('/^08[0-9]{7,13}$/', $telp)) {
        $errors[] = "Nomor telepon harus diawali 08 dan berisi angka.";
    }

    // Validasi Umur
    $dob = new DateTime($tgl_lahir);
    $now = new DateTime();
    $age = $now->diff($dob)->y;
    if($age < 10) {
        $errors[] = "Umur minimal harus 10 tahun.";
    }

    // Validasi Unik
    $cek = $conn->query("SELECT id_anggota FROM anggota WHERE kode_anggota='$kode' OR email='$email'");
    if($cek->num_rows > 0) {
        $errors[] = "Kode Anggota atau Email sudah terdaftar.";
    }

    // Upload Foto
    $foto_name = null;
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_name = time() . "_" . uniqid() . "." . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto_name);
    }

    // Insert
    if(empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO anggota (kode_anggota, nama, email, telepon, alamat, tanggal_lahir, jenis_kelamin, pekerjaan, tanggal_daftar, status, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $kode, $nama, $email, $telp, $alamat, $tgl_lahir, $jk, $pekerjaan, $tgl_daftar, $status, $foto_name);
        
        if($stmt->execute()) {
            $_SESSION['success'] = "Data anggota berhasil ditambahkan!";
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Gagal menyimpan data: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4 mb-5">
    <div class="card shadow-sm" style="max-width: 600px; margin:auto;">
        
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Anggota Baru</h4>
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
                    <input type="text" name="kode_anggota" class="form-control" required value="<?= htmlspecialchars($_POST['kode_anggota'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" class="form-control" required value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label>Telepon (08...) *</label>
                    <input type="text" name="telepon" class="form-control" required value="<?= htmlspecialchars($_POST['telepon'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label>Alamat *</label>
                    <textarea name="alamat" class="form-control" required><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Tanggal Lahir *</label>
                    <input type="date" name="tanggal_lahir" class="form-control" required value="<?= htmlspecialchars($_POST['tanggal_lahir'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label>Jenis Kelamin *</label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="">Pilih...</option>
                        <option value="Laki-laki" <?= (($_POST['jenis_kelamin'] ?? '')=='Laki-laki') ? 'selected':'' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= (($_POST['jenis_kelamin'] ?? '')=='Perempuan') ? 'selected':'' ?>>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" value="<?= htmlspecialchars($_POST['pekerjaan'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label>Foto (Optional)</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary w-100">Simpan Data</button>
                <a href="index.php" class="btn btn-secondary w-100 mt-2">Batal</a>

            </form>
        </div>
    </div>
</div>

</body>
</html>