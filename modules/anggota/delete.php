<?php
// modules/anggota/delete.php
session_start();
require_once '../../koneksi.php';

if(isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Ambil data untuk menghapus file foto fisik
    $stmt_sel = $conn->prepare("SELECT foto FROM anggota WHERE id_anggota = ?");
    $stmt_sel->bind_param("i", $id);
    $stmt_sel->execute();
    $result = $stmt_sel->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Hapus file foto jika ada
        if($row['foto'] && file_exists("uploads/".$row['foto'])) {
            unlink("uploads/".$row['foto']);
        }
        
        // Hapus dari database
        $stmt_del = $conn->prepare("DELETE FROM anggota WHERE id_anggota = ?");
        $stmt_del->bind_param("i", $id);
        if($stmt_del->execute()) {
            $_SESSION['success'] = "Data anggota berhasil dihapus!";
        }
    }
}

header("Location: index.php");
exit;
?>