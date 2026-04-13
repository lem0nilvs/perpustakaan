<?php

// 1. fungsi hitung total anggota
function hitung_total_anggota($anggota_list) {
    return count($anggota_list);
}

// 2. fungsi hitung anggota aktif
function hitung_anggota_aktif($anggota_list) {
    $count = 0;
    foreach ($anggota_list as $a) {
        if ($a['status'] == "Aktif") {
            $count++;
        }
    }
    return $count;
}

// 3. fungsi hitung rata-rata pinjaman
function hitung_rata_rata_pinjaman($anggota_list) {
    $total = 0;
    foreach ($anggota_list as $a) {
        $total += $a['total_pinjaman'];
    }
    return $total / count($anggota_list);
}

// 4. fungsi anggota by ID
function cari_anggota_by_id($anggota_list, $id) {
    foreach ($anggota_list as $a) {
        if ($a['id'] == $id) {
            return $a;
        }
    }
    return null;
}

// 5. fungsi anggota teraktif
function cari_anggota_teraktif($anggota_list) {
    $max = $anggota_list[0];
    foreach ($anggota_list as $a) {
        if ($a['total_pinjaman'] > $max['total_pinjaman']) {
            $max = $a;
        }
    }
    return $max;
}

// 6. fungsi filter by status
function filter_by_status($anggota_list, $status) {
    $result = [];
    foreach ($anggota_list as $a) {
        if ($a['status'] == $status) {
            $result[] = $a;
        }
    }
    return $result;
}

// 7. fungsi validasi email
function validasi_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// 8. fungsi format tanggal Indonesia
function format_tanggal_indo($tanggal) {
    $bulan = [
        1 => "Januari","Februari","Maret","April","Mei","Juni",
        "Juli","Agustus","September","Oktober","November","Desember"
    ];

    $split = explode('-', $tanggal);
    return $split[2] . " " . $bulan[(int)$split[1]] . " " . $split[0];
}

// BONUS fungsi
//9. sort by id
function sort_by_id($anggota_list) {
    usort($anggota_list, function($a, $b) {
        return strcmp($a['id'], $b['id']);
    });
    return $anggota_list;
}
// sort by nama
function sort_by_nama($anggota_list) {
    usort($anggota_list, function($a, $b) {
        return strcmp($a['nama'], $b['nama']);
    });
    return $anggota_list;
}

// 10. fungsi search
function search_nama($anggota_list, $keyword) {
    $result = [];
    foreach ($anggota_list as $a) {
        if (stripos($a['nama'], $keyword) !== false) {
            $result[] = $a;
        }
    }
    return $result;
}

?>