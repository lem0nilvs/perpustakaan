-- tugas 2 database perpustakaan lengkap


-- 1. buat tabel kategori_buku, penerbit, rak, dan buku
-- Tabel Kategori Buku
CREATE TABLE kategori_buku (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL UNIQUE,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_deleted TINYINT(1) DEFAULT 0 -- Bonus: Soft Delete
);

-- Tabel Penerbit
CREATE TABLE penerbit (
    id_penerbit INT AUTO_INCREMENT PRIMARY KEY,
    nama_penerbit VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(15),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_deleted TINYINT(1) DEFAULT 0 
);

-- Tabel Rak (Bonus +10%)
CREATE TABLE rak (
    id_rak INT AUTO_INCREMENT PRIMARY KEY,
    nama_rak VARCHAR(50) NOT NULL,
    lokasi VARCHAR(50),
    is_deleted TINYINT(1) DEFAULT 0 
);

-- Tabel Buku (Relasi ke Kategori, Penerbit, dan Rak)
CREATE TABLE buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    kode_buku VARCHAR(20) NOT NULL UNIQUE,
    judul VARCHAR(255) NOT NULL,
    id_kategori INT,
    id_penerbit INT,
    id_rak INT,
    pengarang VARCHAR(100),
    tahun_terbit INT,
    isbn VARCHAR(20),
    harga DECIMAL(10,2),
    stok INT,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_deleted TINYINT(1) DEFAULT 0, 
    
    FOREIGN KEY (id_kategori) REFERENCES kategori_buku(id_kategori) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (id_penerbit) REFERENCES penerbit(id_penerbit) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (id_rak) REFERENCES rak(id_rak) ON UPDATE CASCADE ON DELETE SET NULL
);

-- Tabel Anggota & Transaksi (Untuk Melengkapi Sistem)
CREATE TABLE anggota (
    id_anggota INT AUTO_INCREMENT PRIMARY KEY,
    kode_anggota VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    is_deleted TINYINT(1) DEFAULT 0
);

CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_buku INT,
    id_anggota INT,
    tanggal_pinjam DATE,
    status ENUM('Dipinjam', 'Dikembalikan') DEFAULT 'Dipinjam',
    is_deleted TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_buku) REFERENCES buku(id_buku),
    FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota)
);

-- 2. tambah data sample

-- Data Kategori
INSERT INTO kategori_buku (nama_kategori) VALUES 
('Programming'), ('Database'), ('Web Design'), ('Networking'), ('Security');

-- Data Penerbit
INSERT INTO penerbit (nama_penerbit) VALUES 
('Informatika'), ('Graha Ilmu'), ('Andi'), ('Erlangga'), ('Gramedia');

-- Data Rak
INSERT INTO rak (nama_rak, lokasi) VALUES 
('Rak A1', 'Lantai 1'), ('Rak B2', 'Lantai 2');

-- Data Buku (total 15)
INSERT INTO buku (kode_buku, judul, id_kategori, id_penerbit, id_rak, pengarang, tahun_terbit, harga, stok) VALUES
('BK-001', 'Pemrograman PHP untuk Pemula', 1, 1, 1, 'Budi Raharjo', 2023, 75000, 10),
('BK-002', 'Mastering MySQL Database', 2, 2, 1, 'Andi Nugroho', 2022, 95000, 5),
('BK-003', 'Laravel Framework Advanced', 1, 1, 1, 'Siti Aminah', 2024, 125000, 8),
('BK-004', 'Web Design Principles', 3, 3, 2, 'Dedi Santoso', 2023, 85000, 15),
('BK-005', 'Network Security Fundamentals', 4, 4, 2, 'Rina Wijaya', 2023, 110000, 3),
('BK-006', 'PHP Web Services', 1, 1, 1, 'Budi Raharjo', 2024, 90000, 12),
('BK-007', 'PostgreSQL Advanced', 2, 2, 1, 'Ahmad Yani', 2024, 115000, 7),
('BK-008', 'JavaScript Modern', 1, 1, 1, 'Siti Aminah', 2023, 80000, 0),
('BK-009', 'Cyber Security Basics', 5, 5, 2, 'John Doe', 2023, 150000, 4),
('BK-010', 'React Native Guide', 1, 3, 1, 'Andi Pratama', 2024, 130000, 6),
('BK-011', 'Database NoSQL', 2, 2, 1, 'Ahmad Yani', 2023, 98000, 9),
('BK-012', 'UI/UX Design Kit', 3, 5, 2, 'Siska Putri', 2022, 120000, 11),
('BK-013', 'Routing & Switching', 4, 4, 2, 'Rina Wijaya', 2024, 145000, 2),
('BK-014', 'Python for Data Science', 1, 1, 1, 'Budi Raharjo', 2024, 160000, 5),
('BK-015', 'Modern Web Development', 1, 3, 1, 'Dedi Santoso', 2023, 115000, 7);


-- 3. QUERY JOIN & ANALISIS

-- 3.1 JOIN: Tampilkan buku dengan nama kategori dan penerbit
SELECT b.judul, k.nama_kategori, p.nama_penerbit 
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit
WHERE b.is_deleted = 0;

-- 3.2 Jumlah buku per kategori
SELECT k.nama_kategori, COUNT(b.id_buku) AS jumlah_buku
FROM kategori_buku k
LEFT JOIN buku b ON k.id_kategori = b.id_kategori AND b.is_deleted = 0
GROUP BY k.id_kategori;

-- 3.3 Jumlah buku per penerbit
SELECT p.nama_penerbit, COUNT(b.id_buku) AS jumlah_buku
FROM penerbit p
LEFT JOIN buku b ON p.id_penerbit = b.id_penerbit AND b.is_deleted = 0
GROUP BY p.id_penerbit;

-- 3.4 Buku beserta detail lengkap (Kategori, Penerbit, dan Rak)
SELECT b.kode_buku, b.judul, k.nama_kategori, p.nama_penerbit, r.nama_rak, b.stok
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit
JOIN rak r ON b.id_rak = r.id_rak
WHERE b.is_deleted = 0;

-- 4. STORED PROCEDURE
DELIMITER //

-- Procedure untuk menampilkan stok buku yang perlu direstock (< 5)
CREATE PROCEDURE sp_cek_stok_kritis()
BEGIN
    SELECT judul, stok FROM buku WHERE stok < 5 AND is_deleted = 0;
END //

-- Procedure Soft Delete untuk Buku
CREATE PROCEDURE sp_soft_delete_buku(IN p_id INT)
BEGIN
    UPDATE buku SET is_deleted = 1 WHERE id_buku = p_id;
END //

DELIMITER ;