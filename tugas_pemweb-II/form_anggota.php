<?php
// inisialisasi variabel
$errors = [];
$data = [
    "nama" => "",
    "email" => "",
    "telepon" => "",
    "alamat" => "",
    "jk" => "",
    "tgl_lahir" => "",
    "pekerjaan" => ""
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ambik data
    foreach ($data as $key => $value) {
        $data[$key] = htmlspecialchars(trim($_POST[$key] ?? ""));
    }

    // validasi nama
    if (empty($data["nama"]) || strlen($data["nama"]) < 3) {
        $errors["nama"] = "Nama minimal 3 karakter.";
    }

    // validasi email
    if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Format email tidak valid.";
    }

    // validasi no telpon (08 + 10-13 digit)
    if (!preg_match("/^08[0-9]{8,11}$/", $data["telepon"])) {
        $errors["telepon"] = "Telepon harus format 08xxxxxxxxxx (10-13 digit).";
    }

    // validasi alamat 
    if (strlen($data["alamat"]) < 10) {
        $errors["alamat"] = "Alamat minimal 10 karakter.";
    }

    // validasi gender (adam atau hawa)
    if (empty($data["jk"])) {
        $errors["jk"] = "Pilih jenis kelamin.";
    }

    // validasi tanggal lahir (min umur 10 tahun)
    if (!empty($data["tgl_lahir"])) {
        $today = new DateTime();
        $birthDate = new DateTime($data["tgl_lahir"]);
        $umur = $today->diff($birthDate)->y;

        if ($umur < 10) {
            $errors["tgl_lahir"] = "Umur minimal 10 tahun.";
        }
    } else {
            $errors["tgl_lahir"] = "Tanggal lahir wajib diisi.";
    }

    // validasi pekerjaan
    if (empty($data["pekerjaan"])) {
        $errors["pekerjaan"] = "Pilih pekerjaan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">

<div class="container mt-5">
    <h3>Form Registrasi Anggota</h3>

    <form method="POST" class="mt-4">

        <!-- nama -->
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control <?= isset($errors["nama"]) ? 'is-invalid' : '' ?>" value="<?= $data["nama"] ?>">
            <div class="invalid-feedback"><?= $errors["nama"] ?? '' ?></div>
        </div>

        <!-- email -->
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control <?= isset($errors["email"]) ? 'is-invalid' : '' ?>" value="<?= $data["email"] ?>">
            <div class="invalid-feedback"><?= $errors["email"] ?? '' ?></div>
        </div>

        <!-- telpon -->
        <div class="mb-3">
            <label>Telepon</label>
            <input type="text" name="telepon" class="form-control <?= isset($errors["telepon"]) ? 'is-invalid' : '' ?>" value="<?= $data["telepon"] ?>">
            <div class="invalid-feedback"><?= $errors["telepon"] ?? '' ?></div>
        </div>

        <!-- alamat lengkap -->
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control <?= isset($errors["alamat"]) ? 'is-invalid' : '' ?>"><?= $data["alamat"] ?></textarea>
            <div class="invalid-feedback"><?= $errors["alamat"] ?? '' ?></div>
        </div>

        <!-- gender -->
        <div class="mb-3">
            <label>Jenis Kelamin</label><br>
            <input type="radio" name="jk" value="Laki-laki" <?= $data["jk"] == "Laki-laki" ? 'checked' : '' ?>> Laki-laki
            <input type="radio" name="jk" value="Perempuan" <?= $data["jk"] == "Perempuan" ? 'checked' : '' ?>> Perempuan
            <div class="text-danger"><?= $errors["jk"] ?? '' ?></div>
        </div>

        <!-- tanggal lahir -->
        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" class="form-control <?= isset($errors["tgl_lahir"]) ? 'is-invalid' : '' ?>" value="<?= $data["tgl_lahir"] ?>">
            <div class="invalid-feedback"><?= $errors["tgl_lahir"] ?? '' ?></div>
        </div>

        <!-- pekerjaan -->
        <div class="mb-3">
            <label>Pekerjaan</label>
            <select name="pekerjaan" class="form-control <?= isset($errors["pekerjaan"]) ? 'is-invalid' : '' ?>">
                <option value="">-- Pilih --</option>
                <option <?= $data["pekerjaan"]=="Pelajar"?'selected':'' ?>>Pelajar</option>
                <option <?= $data["pekerjaan"]=="Mahasiswa"?'selected':'' ?>>Mahasiswa</option>
                <option <?= $data["pekerjaan"]=="Pegawai"?'selected':'' ?>>Pegawai</option>
                <option <?= $data["pekerjaan"]=="Lainnya"?'selected':'' ?>>Lainnya</option>
            </select>
            <div class="invalid-feedback"><?= $errors["pekerjaan"] ?? '' ?></div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <!-- output sukses -->
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($errors)): ?>
    
    <!-- alert sukses -->
    <div class="alert alert-success mt-4">
        ✅ Data berhasil disimpan!
    </div>

    <!-- card data -->
    <div class="card mt-3 text-dark">
        <div class="card-body">
            <h5 class="card-title">Detail Data</h5>
            <p><b>Nama:</b> <?= $data["nama"] ?></p>
            <p><b>Email:</b> <?= $data["email"] ?></p>
            <p><b>Telepon:</b> <?= $data["telepon"] ?></p>
            <p><b>Alamat:</b> <?= $data["alamat"] ?></p>
            <p><b>Jenis Kelamin:</b> <?= $data["jk"] ?></p>
            <p><b>Tanggal Lahir:</b> <?= $data["tgl_lahir"] ?></p>
            <p><b>Pekerjaan:</b> <?= $data["pekerjaan"] ?></p>
        </div>
    </div>
    <?php endif; ?>

</div>

</body>
</html>