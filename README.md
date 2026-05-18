# 24f_simgizi_dapur

# Struktur Database
```bash
-- CREATE DATABASE
CREATE DATABASE sim_gizi;
USE sim_gizi;

--  CREATE TABLE MITRA & DAPUR
CREATE TABLE mitra (
  id_mitra INT AUTO_INCREMENT PRIMARY KEY,
  nama_mitra VARCHAR(100),
  jenis VARCHAR(50),
  alamat TEXT,
  status_verifikasi ENUM('Pending', 'Terverifikasi', 'Ditolak')
);

CREATE TABLE dapur (
  id_dapur INT AUTO_INCREMENT PRIMARY KEY,
  nama_dapur VARCHAR(100),
  alamat TEXT,
  penanggung_jawab VARCHAR(100),
  kontak VARCHAR(20),
  id_mitra INT,

  CONSTRAINT fk_dapur_mitra
  FOREIGN KEY (id_mitra)
  REFERENCES mitra(id_mitra)

  ON UPDATE CASCADE
  ON DELETE SET NULL
);

-- ISI TABEL MITRA & DAPUR
INSERT INTO mitra (nama_mitra, jenis, alamat, status_verifikasi)
VALUES
('PT Gizi Nusantara', 'Supplier', 'Yogyakarta', 'Terverifikasi'),
('CV Boga Sehat', 'Katering', 'Sleman', 'Pending'),
('UD Pangan Anak', 'Distributor', 'Bantul', 'Terverifikasi');

INSERT INTO dapur
(nama_dapur, alamat, penanggung_jawab, kontak, id_mitra)
VALUES
('Dapur MBG Utara', 'Jl. Kaliurang', 'Budi Santoso',
'081234567890', 1),
('Dapur MBG Selatan', 'Jl. Bantul', 'Siti Aminah',
'081234567891', 2),
('Dapur MBG Timur', 'Jl. Solo', 'Rudi Hartono', '081234567892',
3);
```
