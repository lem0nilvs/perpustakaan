# Tugas Pertemuan 6
## Tugas 1: Eksplorasi Database dengan Query

**Nama:** Rahmawati Azizah Afriliani  
**NIM:** 60324025
**Program Studi:** Informatika
**Mata Kuliah:** Pemrograman Web II 


## 1. Statistik Buku (5 Query)

### Total Buku Seluruhnya
![Hasil Query Total Buku](sshasilp6/tu1_1_1.png)
*hitung jumlah total baris/buku yang ada di dalam tabel.*

### Total Nilai Inventaris
![Hasil Query Nilai Inventaris](sshasilp6/tu1_1_2.png)
*menjumlahkan hasil perkalian antara harga dan stok untuk setiap buku.*

### Rata-rata Harga Buku
![Hasil Query Rata-rata Harga](sshasilp6/tu1_1_3.png)
*hitung nilai rata-rata dari kolom harga keseluruhan buku.*

### Buku Termahal
![Hasil Query Buku Termahal](sshasilp6/tu1_1_4.png)
*buat nampilin satu buku dengan harga tertinggi.*

### Buku dengan Stok Terbanyak
![Hasil Query Stok Terbanyak](sshasilp6/tu1_1_5.png)
*buat nampilin satu buku yang memiliki angka stok paling tinggi.*

---

## 2. Filter dan Pencarian (5 Query)

### Kategori Programming Harga < 100.000
![Hasil Query Filter 1](sshasilp6/tu1_2_1.png)

### Judul memiliki kata "PHP" atau "MySQL"
![Hasil Query Filter 2](sshasilp6/tu1_2_2.png)

### Buku Terbit Tahun 2024
![Hasil Query Filter 3](sshasilp6/tu1_2_3.png)

### Stok Antara 5-10
![Hasil Query Filter 4](sshasilp6/tu1_2_4.png)

### Pengarang "Budi Raharjo"
![Hasil Query Filter 5](sshasilp6/tu1_2_5.png)

---

## 3. Grouping dan Agregasi (3 Query)

### Jumlah Buku & Total Stok per Kategori
![Hasil Query Grouping 1](sshasilp6/tu1_3_1.png)

### Rata-rata Harga per Kategori
![Hasil Query Grouping 2](sshasilp6/tu1_3_2.png)

### Kategori dengan Total Nilai Inventaris Terbesar
![Hasil Query Grouping 3](sshasilp6/tu1_3_3.png)

---

## 4. Update Data (2 Query)

### Kenaikan Harga 5% Kategori Programming
![Hasil Query Update 1](sshasilp6/tu1_4_1_!.png)
*(Screenshot menunjukkan pesan sukses dari phpMyAdmin bahwa baris telah terpengaruh/berubah)*
![Hasil Query Update 1](sshasilp6/tu1_4_1_2.png)
### Tambah Stok 10 untuk Stok < 5
![Hasil Query Update 2](sshasilp6/tu1_4_2_1.png)
*(Screenshot menunjukkan pesan sukses dari phpMyAdmin bahwa baris telah terpengaruh/berubah)*
![Hasil Query Update 1](sshasilp6/tu1_4_2_2.png)

---

## 5. Laporan Khusus (2 Query)

### Daftar Buku Perlu Restocking (Stok < 5)
![Hasil Query Laporan 1](sshasilp6/tu1_5_1.png)
*Jika hasilnya kosong, berarti tidak ada buku dengan stok di bawah 5 setelah query update sebelumnya dijalankan*

### Top 5 Buku Termahal
![Hasil Query Laporan 2](sshasilp6/tu1_5_2.png)



# Tugas 2
## 1. Entity Relationship Diagram (ERD)

![ERD Database Perpustakaan](sshasilp6/erd_pemweb.png)

---

## 2. Struktur Semua Tabel:

### 2.1 Relasi Antar Tabel (Designer View)
![Desain Relasi](sshasilp6/relasi%20tu2.png)

### 2.2 Struktur Tabel Buku (Detail Foreign Key)
![Struktur Tabel Buku](sshasilp6/struktur%20buku.png)

---

## 3. Data di Setiap Tabel

### 3.1 Data Tabel Kategori Buku & Penerbit
![Data Kategori dan Penerbit](sshasilp6/kategori%20buku%20struktur%20tabel.png)
![Data Kategori dan Penerbit](sshasilp6/data%20penerbit.png)

### 3.2 Data Tabel Buku (Terdiri dari 15 Buku Minimal)
![Data Buku Lengkap](sshasilp6/data%20buku.png)

---

## 4. Hasil Query JOIN
### 4.1 Tampilkan Buku dengan Nama Kategori dan Penerbit
![Hasil JOIN 1](sshasilp6/4.1%20join.png)

### 4.2 Jumlah Buku per Kategori
![Hasil JOIN 2](sshasilp6/4.2jumlah%20buku%20perkatogori.png)

### 4.3 Jumlah Buku per Penerbit
![Hasil JOIN 3](sshasilp6/4.3%20jumlah%20buku%20perpenerbit.png)

### 4.4 Buku Beserta Detail Lengkap (Kategori, Penerbit, Rak)
![Hasil JOIN 4](sshasilp6/4.4%20buku%20beserta%20detail%20lengkap.png)

---

## 5. Fitur tambahan

### 5.1 Tambah Tabel `rak` dengan Relasi ke Buku
![Tabel Rak](sshasilp6/data%20rak.png)

### 5.2 Implementasi *Soft Delete*
Seluruh tabel memiliki kolom `is_deleted`. 
![Soft Delete Bukti](sshasilp6/is_deletedbonus2.png)
![Stored Procedure Bukti](sshasilp6/5.%20buku%20is%20delete.png)
*(Buku dengan ID 1 diubah status is_deleted-nya menjadi 1, bukan dihapus permanen dari sistem).*

### 5.3 *Stored Procedure* untuk Operasi Umum
Pembuatan dan pemanggilan *Stored Procedure* `sp_cek_stok_kritis` dan `sp_soft_delete_buku`:
![Stored Procedure Bukti](sshasilp6/sp_kurangdari5.png)
![Stored Procedure Bukti](sshasilp6/stored%20procedur.png)