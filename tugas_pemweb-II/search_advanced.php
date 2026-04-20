<?php
session_start();
// simpan pencarian ke session
if (!isset($_SESSION['recent'])) {
    $_SESSION['recent'] = [];
}
// simpan hanya jika ada pencarian
if (!empty($_GET)) {
    $_SESSION['recent'][] = $_GET;

    // max 5 pencarian
    if (count($_SESSION['recent']) > 5) {
        array_shift($_SESSION['recent']);
    }
}

// data buku 
$buku_list = [
    ["kode"=>"B001","judul"=>"Algoritma Dasar","kategori"=>"Teknologi","pengarang"=>"Andi","penerbit"=>"Informatika","tahun"=>2020,"harga"=>75000,"stok"=>5],
    ["kode"=>"B002","judul"=>"Pemrograman PHP","kategori"=>"Teknologi","pengarang"=>"Budi","penerbit"=>"Elex","tahun"=>2021,"harga"=>85000,"stok"=>0],
    ["kode"=>"B003","judul"=>"Belajar HTML","kategori"=>"Teknologi","pengarang"=>"Citra","penerbit"=>"Andi","tahun"=>2019,"harga"=>60000,"stok"=>10],
    ["kode"=>"B004","judul"=>"Sejarah Dunia","kategori"=>"Sejarah","pengarang"=>"Dedi","penerbit"=>"Gramedia","tahun"=>2015,"harga"=>90000,"stok"=>3],
    ["kode"=>"B005","judul"=>"Matematika Diskrit","kategori"=>"Pendidikan","pengarang"=>"Eka","penerbit"=>"Erlangga","tahun"=>2018,"harga"=>95000,"stok"=>7],
    ["kode"=>"B006","judul"=>"Fisika Dasar","kategori"=>"Pendidikan","pengarang"=>"Fajar","penerbit"=>"Erlangga","tahun"=>2017,"harga"=>80000,"stok"=>0],
    ["kode"=>"B007","judul"=>"Kimia Organik","kategori"=>"Pendidikan","pengarang"=>"Gina","penerbit"=>"Andi","tahun"=>2022,"harga"=>100000,"stok"=>4],
    ["kode"=>"B008","judul"=>"Novel Cinta","kategori"=>"Fiksi","pengarang"=>"Hana","penerbit"=>"Gramedia","tahun"=>2023,"harga"=>70000,"stok"=>8],
    ["kode"=>"B009","judul"=>"Cerita Rakyat","kategori"=>"Fiksi","pengarang"=>"Iwan","penerbit"=>"Gramedia","tahun"=>2016,"harga"=>65000,"stok"=>2],
    ["kode"=>"B010","judul"=>"Jaringan Komputer","kategori"=>"Teknologi","pengarang"=>"Joko","penerbit"=>"Informatika","tahun"=>2020,"harga"=>110000,"stok"=>6],
];

// ambil parameter GET
$keyword = $_GET['keyword'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$min_harga = $_GET['min_harga'] ?? '';
$max_harga = $_GET['max_harga'] ?? '';
$tahun = $_GET['tahun'] ?? '';
$status = $_GET['status'] ?? 'semua';
$sort = $_GET['sort'] ?? 'judul';
$page = $_GET['page'] ?? 1;

// validasi
$errors = [];

if (!empty($min_harga) && !empty($max_harga)) {
    if ($min_harga > $max_harga) {
        $errors[] = "Harga minimum tidak boleh lebih besar dari maksimum";
    }
}

if (!empty($tahun)) {
    if ($tahun < 1900 || $tahun > date("Y")) {
        $errors[] = "Tahun harus antara 1900 - sekarang";
    }
}

// di filter
$hasil = array_filter($buku_list, function($buku) use ($keyword,$kategori,$min_harga,$max_harga,$tahun,$status) {

    if ($keyword && stripos($buku['judul'],$keyword)===false && stripos($buku['pengarang'],$keyword)===false) {
        return false;
    }

    if ($kategori && $buku['kategori'] != $kategori) return false;

    if ($min_harga && $buku['harga'] < $min_harga) return false;
    if ($max_harga && $buku['harga'] > $max_harga) return false;

    if ($tahun && $buku['tahun'] != $tahun) return false;

    if ($status == "tersedia" && $buku['stok'] <= 0) return false;
    if ($status == "habis" && $buku['stok'] > 0) return false;

    return true;
});

// di sorting
usort($hasil, function($a,$b) use ($sort){
    return $a[$sort] <=> $b[$sort];
});

// pagination (10/halaman)
$per_page = 10;
$total = count($hasil);
$total_page = ceil($total / $per_page);
$start = ($page - 1) * $per_page;
$hasil = array_slice($hasil, $start, $per_page);

// highlight keyword (yg dicari ada marknya)
function highlight($text, $keyword){
    if (!$keyword) return $text;
    $keyword = preg_quote($keyword, '/');
    return preg_replace("/($keyword)/i", "<mark>$1</mark>", $text);
}

// di export ke csv
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="data_buku.csv"');

    $output = fopen("php://output", "w");

    // header csv
    fputcsv($output, ['Kode','Judul','Kategori','Pengarang','Tahun','Harga','Stok']);

    foreach ($hasil as $b) {
        fputcsv($output, $b);
    }

    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h3>Pencarian Buku</h3>

    <!-- buat error -->
    <?php foreach($errors as $e): ?>
        <div class="alert alert-danger"><?= $e ?></div>
    <?php endforeach; ?>

    <!-- form -->
    <form method="GET" class="row g-2">
        <input type="text" name="keyword" placeholder="Keyword" class="form-control" value="<?= $keyword ?>">

        <select name="kategori" class="form-control">
            <option value="">Semua Kategori</option>
            <option <?= $kategori=="Teknologi"?'selected':'' ?>>Teknologi</option>
            <option <?= $kategori=="Pendidikan"?'selected':'' ?>>Pendidikan</option>
            <option <?= $kategori=="Fiksi"?'selected':'' ?>>Fiksi</option>
            <option <?= $kategori=="Sejarah"?'selected':'' ?>>Sejarah</option>
        </select>

        <input type="number" name="min_harga" placeholder="Min Harga" value="<?= $min_harga ?>" class="form-control">
        <input type="number" name="max_harga" placeholder="Max Harga" value="<?= $max_harga ?>" class="form-control">

        <input type="number" name="tahun" placeholder="Tahun" value="<?= $tahun ?>" class="form-control">

        <div>
            <input type="radio" name="status" value="semua" <?= $status=="semua"?'checked':'' ?>> Semua
            <input type="radio" name="status" value="tersedia" <?= $status=="tersedia"?'checked':'' ?>> Tersedia
            <input type="radio" name="status" value="habis" <?= $status=="habis"?'checked':'' ?>> Habis
        </div>

        <select name="sort" class="form-control">
            <option value="judul">Sort Judul</option>
            <option value="harga">Sort Harga</option>
            <option value="tahun">Sort Tahun</option>
        </select>

        <button class="btn btn-primary">Cari</button>
    </form>

    <!-- table -->
    <table class="table table-bordered mt-3">
        <div class="d-flex justify-content-between align-items-center mt-3">
            <p class="mb-0">Jumlah hasil: <?= $total ?></p>
            <a href="?<?= http_build_query(array_merge($_GET,['export'=>'csv'])) ?>" class="btn btn-success" title="Download CSV"><i class="bi bi-download"></i></a>
        </div>
        <tr>
            <th>Kode</th><th>Judul</th><th>Kategori</th><th>Pengarang</th><th>Tahun</th><th>Harga</th><th>Stok</th>
        </tr>

        <?php foreach($hasil as $b): ?>
        <tr>
            <td><?= $b['kode'] ?></td>
            <td><?= highlight($b['judul'],$keyword) ?></td>
            <td><?= $b['kategori'] ?></td>
            <td><?= highlight($b['pengarang'],$keyword) ?></td>
            <td><?= $b['tahun'] ?></td>
            <td><?= $b['harga'] ?></td>
            <td><?= $b['stok'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- pagination -->
    <?php for($i=1; $i<=$total_page; $i++): ?>
        <a href="?<?= http_build_query(array_merge($_GET,['page'=>$i])) ?>" class="btn btn-sm btn-secondary"><?= $i ?></a>
    <?php endfor; ?>

    <h5 class="mt-4">Recent Searches</h5>
    <ul class="list-group">
    <?php if (!empty($_SESSION['recent'])): ?>
        <?php foreach (array_reverse($_SESSION['recent']) as $r): ?>
            <li class="list-group-item">
                <a href="?<?= http_build_query($r) ?>">
                    <?= $r['keyword'] ?? 'Tanpa keyword' ?>
                </a>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li class="list-group-item">Belum ada pencarian</li>
    <?php endif; ?>
    </ul>

</div>
</body>
</html>