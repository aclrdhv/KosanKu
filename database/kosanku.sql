-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Des 2023 pada 05.49
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kosanku`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id` int(2) NOT NULL,
  `nama` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `fasilitas`
--

INSERT INTO `fasilitas` (`id`, `nama`) VALUES
(1, 'AC'),
(2, 'Kamar Mandi Dalam'),
(3, 'Wifi'),
(4, 'Air'),
(5, 'Listrik'),
(6, 'Kasur'),
(7, 'Lemari'),
(8, 'Meja');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fasil_kost`
--

CREATE TABLE `fasil_kost` (
  `id_kost` int(11) NOT NULL,
  `id_fasil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `fasil_kost`
--

INSERT INTO `fasil_kost` (`id_kost`, `id_fasil`) VALUES
(3, 2),
(3, 3),
(3, 4),
(3, 6),
(3, 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kamar`
--

CREATE TABLE `kamar` (
  `id_kost` int(6) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `lebar` float DEFAULT NULL,
  `panjang` float DEFAULT NULL,
  `idKamar` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kamar`
--

INSERT INTO `kamar` (`id_kost`, `status`, `lebar`, `panjang`, `idKamar`) VALUES
(5, 'TERISI', 3, 4, '62cb6b0bce83e'),
(5, 'TERISI', 3, 4, '62cb6b0bcfb3b'),
(5, 'KOSONG', 3, 4, '62cb6b0bd0e70'),
(5, 'KOSONG', 3, 4, '62cb6b0bd468f'),
(5, 'KOSONG', 3, 4, '62cb6b0bd595f'),
(5, 'TERISI', 3, 4, '62cb6b0bd6fa2'),
(5, 'TERISI', 3, 4, '62cb6b0bd84c0'),
(5, 'KOSONG', 3, 4, '62cb6b0bd99cc'),
(5, 'KOSONG', 3, 4, '62cb6b0bdae42'),
(5, 'KOSONG', 3, 4, '62cb6b0bdc3ab'),
(5, 'KOSONG', 3, 4, '62cb6b0bdd8fd'),
(5, 'KOSONG', 3, 4, '62cb6b0bded87'),
(5, 'TERISI', 3, 4, '62cb6b0be02a6'),
(5, 'KOSONG', 3, 4, '62cb6b0be1736'),
(5, 'KOSONG', 3, 4, '62cb6b0be2a5b'),
(5, 'KOSONG', 3, 4, '62cb6b0be3c5b'),
(5, 'TERISI', 3, 4, '62cb6b0be4ea0'),
(5, 'KOSONG', 3, 4, '62cb6b0be612d'),
(5, 'KOSONG', 3, 4, '62cb6b0be7349'),
(5, 'KOSONG', 3, 4, '62cb6b0be84d9'),
(3, 'KOSONG', 3, 4, '62cb6bb97d831'),
(3, 'KOSONG', 3, 4, '62cb6bb9807c8'),
(3, 'KOSONG', 3, 4, '62cb6bb983217'),
(3, 'KOSONG', 3, 4, '62cb6bb9868e2'),
(3, 'KOSONG', 3, 4, '62cb6bb98905d'),
(3, 'TERISI', 3, 4, '62cb6bb98cdfa'),
(3, 'TERISI', 3, 4, '62cb6bb98e245'),
(3, 'KOSONG', 3, 4, '62cb6bb98f107'),
(3, 'KOSONG', 3, 4, '62cb6bb98ffc5'),
(3, 'KOSONG', 3, 4, '62cb6bb9922b8'),
(3, 'TERISI', 3, 4, '62cb6bb993545'),
(3, 'KOSONG', 3, 4, '62cb6bb9947f3'),
(3, 'KOSONG', 3, 4, '62cb6bb9959af'),
(3, 'KOSONG', 3, 4, '62cb6bb996c62'),
(3, 'KOSONG', 3, 4, '62cb6bb997ecc'),
(3, 'KOSONG', 3, 4, '62cb6bb99923e'),
(3, 'KOSONG', 3, 4, '62cb6bb99a3da'),
(3, 'KOSONG', 3, 4, '62cb6bb99b858'),
(3, 'KOSONG', 3, 4, '62cb6bb99cc94'),
(3, 'TERISI', 3, 4, '62cb6bb99e105'),
(3, 'KOSONG', 3, 4, '62cb6bb99f5a6'),
(13, 'KOSONG', 3, 4, '62cdba667f1bf'),
(13, 'KOSONG', 3, 4, '62cdba667f675'),
(13, 'KOSONG', 3, 4, '62cdba667f949'),
(13, 'KOSONG', 3, 4, '62cdba667fbf6'),
(13, 'KOSONG', 3, 4, '62cdba667fe6e'),
(13, 'KOSONG', 3, 4, '62cdba66800f5'),
(13, 'KOSONG', 3, 4, '62cdba6680358'),
(13, 'KOSONG', 3, 4, '62cdba66805b3'),
(13, 'KOSONG', 3, 4, '62cdba6680d7e'),
(13, 'KOSONG', 3, 4, '62cdba668100c'),
(16, 'KOSONG', 3, 4, '62cdc71cb148a'),
(16, 'KOSONG', 3, 4, '62cdc71cb1785'),
(16, 'KOSONG', 3, 4, '62cdc71cb1a23'),
(16, 'KOSONG', 3, 4, '62cdc71cb1daf'),
(16, 'TERISI', 3, 4, '62cdc71cb203e');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kost`
--

CREATE TABLE `kost` (
  `id` int(6) NOT NULL,
  `alamat` varchar(120) NOT NULL,
  `nama` varchar(60) DEFAULT NULL,
  `jumlahKamar` int(3) DEFAULT 0,
  `NIK_Pemilik` char(16) DEFAULT NULL,
  `harga` int(7) NOT NULL,
  `fasilitas` varchar(255) NOT NULL,
  `jenis` enum('Putra','Putri','Campur') DEFAULT NULL,
  `gambar_preview` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kost`
--

INSERT INTO `kost` (`id`, `alamat`, `nama`, `jumlahKamar`, `NIK_Pemilik`, `harga`, `fasilitas`, `jenis`, `gambar_preview`) VALUES
(3, ' Jl. Raya Manukan, Mladangan', 'Kost Mawar', 21, '1234890723456789', 430000, '', 'Putri', '62c833dc576a1.jpg'),
(5, 'Cost Putra Sadewa Pugeran, Maguwoharjo, Depok, Sleman', 'Kost Sadewa', 20, '8907134586971234', 560000, '', 'Putra', '62cb6b0bcd1c1.jpg'),
(13, 'Kaliurang St No.KM 15, Ngemplak, Umbulmartani, Ngemplak, Sleman Regency, Special Region of Yogyakarta 55584', 'KOOL KOST near UII Jakal Yogyakarta', 10, '1234890723456789', 1000000, 'AC,Kamar Mandi Dalam,Wifi,Listrik,Kasur,Lemari,Meja', 'Putri', '62cdba667c0a3.jpg'),
(16, 'UII, Jl. Kaliurang KM 14, Perumahan Kavling, Jl. Angsa No.C12, Besi, Sukoharjo, Kec. Ngaglik, Kabupaten Sleman, Daerah I', 'Kost Adani Muslimah UII', 5, '1234890723456789', 1000000, 'AC,Kamar Mandi Dalam,Wifi,Listrik,Kasur,Lemari', 'Putri', '62cdc71cae624.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemilik`
--

CREATE TABLE `pemilik` (
  `NIK` char(16) NOT NULL,
  `nama` varchar(120) DEFAULT NULL,
  `noTelp` varchar(15) DEFAULT NULL,
  `alamat` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL,
  `keypassword` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemilik`
--

INSERT INTO `pemilik` (`NIK`, `nama`, `noTelp`, `alamat`, `email`, `keypassword`) VALUES
('1234096789123456', 'test test', '123456789123', 'test ', 'test@gmail.com', '$2y$10$ym51t82wfJFxA79UYaK4c.RRONg1VVPuNU9Y6i0U9iv8F/tt9zoH6'),
('1234123412341234', 'corn wall', '081234561234', 'jl. kaliurang km 12.5', 'corn@gmail.com', '$2y$10$kBiuyx229Si5Ecx23wXqweF4KrxXjHlBr2YIAIs2J1fTokRungcPu'),
('1234890723456789', 'dara zara', '091234567890', 'Tanggerang Selatan', 'dara@gmail.com', '$2y$10$WlOtfRF8zfHkEsVGanoP8eFDPCnnfEzQ7AfUNd3W1fRlrcQHRsANq'),
('1235908712345678', 'corn wall', '081234567895', 'corn field', 'corn@gmail.com', '$2y$10$gZ1WNbAeRNJSxYdMaBTNFurNAZYBQONLEwKHKkYxSNwPJ3NYN7pH.'),
('12378678362736', 'budi cek', '081227875674', 'kaliurang', 'cek@gmail.com', '$2y$10$HNqdJ1ZMRFsSQSQwUgY0/OxHU.FCcg8mmF6cmqlRJOL94mcfK1KgS'),
('326787899876774', 'fajrun shubhi', '087989876478', 'jalan kaliurang', 'fajrun@gmail.com', '$2y$10$POr3Wl8l/6T3BGj/dA7I7eAASPgj5/nfWuOzDI1bgwbmYvRn7pv9C'),
('328978987676', 'fajrun shubhi', '087998674876', 'jalan kaliurang km 14', 'fajrun@gmail.com', '$2y$10$a2IswgOGGfTXi5IXQWK4e.AEBIWc2Sf1x1rHHW.RwHAgT0MGvUkoO'),
('8907134586971234', 'ilham Rizqyakbar', '081323465789', 'Sanggrahan, Sleman, Yogyakarta', 'ilham@gmail.com', '$2y$10$a4D5EWpUzq7kyXp8GGvtfO.PjZcFqAzwamZdUOC0P7FAQN0/agwrG'),
('8909186957867890', 'dalas nasyar', '081234567890', 'Pogung, Yogyakarta', 'dalas@gmail.com', '$2y$10$jbo2q/pff0qsf7OY2mWLYufUdEx5WxQbxQOGlF7EWLJ.SOr827msi'),
('9856784358681234', 'ilham  Rizqyakbar', '081989096789', 'Sanggrahan, Sleman, Kalasan', 'ilham@gmail.com', '$2y$10$662vGTft3cThKvmWsXdowOH3PGAUhRJtkjsqNscZwcyrPpK6drWmC');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyewaan`
--

CREATE TABLE `penyewaan` (
  `id` int(6) NOT NULL,
  `NIK_penyewa` char(16) DEFAULT NULL,
  `tannggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `idKamar` varchar(15) DEFAULT NULL,
  `idKost` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penyewaan`
--

INSERT INTO `penyewaan` (`id`, `NIK_penyewa`, `tannggal_mulai`, `tanggal_akhir`, `idKamar`, `idKost`) VALUES
(2, '1989403989087564', '2022-07-11', '2023-07-11', '62cb6b0bcfb3b', 5),
(3, '1989403989087564', '2022-07-11', '2023-07-11', '62cb6bb98e245', 3),
(4, '1989403989087564', '2022-07-26', '2022-10-25', '62cb6bb993545', 3),
(6, '1989403989087564', '2022-07-11', '2023-07-11', '62cb6b0bd84c0', 3),
(7, '1989403989087564', '2022-07-11', '2023-07-11', '62cb6b0bce83e', 3),
(8, '1989403989087564', '2022-07-26', '2022-10-25', '62cb6bb99e105', 3),
(9, '1989403989087564', '2022-07-26', '2022-10-25', '62cb6b0be4ea0', 3),
(10, '1989403989087564', '2022-07-26', '2022-10-25', '62cb6b0be02a6', 3),
(12, '1989403989087564', '2022-07-25', '2023-07-25', '62cb6bb98cdfa', 3),
(13, '1989403989087564', '2022-07-13', '2022-12-12', '62cb6b0bd6fa2', 3),
(16, '1989403989087564', '2022-07-13', '2022-10-12', '62cdc71cb203e', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `idPesanan` varchar(13) NOT NULL,
  `idPemesan` varchar(16) DEFAULT NULL,
  `idKost` int(6) DEFAULT NULL,
  `tglPemesanan` date DEFAULT NULL,
  `mulaiSewa` date DEFAULT NULL,
  `akhirSewa` date DEFAULT NULL,
  `totalPembayaran` bigint(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`idPesanan`, `idPemesan`, `idKost`, `tglPemesanan`, `mulaiSewa`, `akhirSewa`, `totalPembayaran`) VALUES
('62cd79d339330', '1989403989087564', 3, '2022-07-12', '2022-07-12', '2022-09-10', 860000),
('62cd7edd942ca', '1989403989087564', 5, '2022-07-12', '2022-07-12', '2022-11-10', 2240000),
('62cdd67f4066c', '1989403989087564', 3, '2022-07-12', '2022-07-13', '2022-10-12', 1290000),
('62cdd6bed68db', '1989403989087564', 5, '2022-07-12', '2022-07-13', '2022-09-11', 1120000),
('62cdd874858be', '1989403989087564', 3, '2022-07-12', '2022-07-13', '2022-09-11', 860000),
('658c31fd47828', '123456789', 3, '2023-12-27', '2023-12-22', '2024-01-21', 430000),
('658c41bcaa1d9', '123456789', 5, '2023-12-27', '2023-12-31', '2024-02-29', 1120000),
('658c41e1ca39a', '123456789', 3, '2023-12-27', '2023-12-28', '2024-05-28', 2150000),
('658c46c925314', '123456789', 13, '2023-12-27', '2023-12-27', '2024-12-26', 12000000),
('658c46fc28a5a', '123456789', 13, '2023-12-27', '2023-12-27', '2024-12-26', 12000000),
('658c472edf03d', '123456789', 13, '2023-12-27', '2023-12-27', '2024-12-26', 12000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekening`
--

CREATE TABLE `rekening` (
  `NoRekening` varchar(20) NOT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `NIK_Pemilik` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rekening`
--

INSERT INTO `rekening` (`NoRekening`, `bank`, `NIK_Pemilik`) VALUES
('2345095482', 'BCA', '1234890723456789');

-- --------------------------------------------------------

--
-- Struktur dari tabel `review`
--

CREATE TABLE `review` (
  `id` int(6) NOT NULL,
  `komen` varchar(512) DEFAULT '',
  `nilai` float NOT NULL,
  `tanggal` datetime NOT NULL,
  `NIK_Penyewa` char(16) DEFAULT NULL,
  `id_kost` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `NIK` char(16) NOT NULL,
  `firstName` varchar(60) DEFAULT NULL,
  `lastName` varchar(60) DEFAULT NULL,
  `email` varchar(60) NOT NULL,
  `jenisKelamin` char(1) DEFAULT NULL,
  `keypassword` varchar(64) NOT NULL,
  `no_telepon` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`NIK`, `firstName`, `lastName`, `email`, `jenisKelamin`, `keypassword`, `no_telepon`) VALUES
('123456789', 'Marcell', 'Virgiano', 'marcell@gmail.com', 'L', '$2y$10$fpG2Vx8fJwb9n.r2TmAvvOj.GFMY7araG2mXc3pHHUx.m4ogXDD12', '087816288999'),
('1989403989087564', 'Lala', 'Poo', 'lala@gmail.com', 'P', '$2y$10$k6cR1REVbQ3ORdL7GvHIQO7PSND244r0rIAP99r/7HeVhOQWCn1dK', '81245630989'),
('9090808070706060', 'admin', 'admin', 'admin@gmail.com', 'L', '$2y$10$dueCV/bVHp1fBacPJ.GEA.las18IGBMTMLnT6WEjvgakf7IWy41.m', '81345678767');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `fasil_kost`
--
ALTER TABLE `fasil_kost`
  ADD PRIMARY KEY (`id_kost`,`id_fasil`),
  ADD KEY `id_fasil` (`id_fasil`);

--
-- Indeks untuk tabel `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`idKamar`),
  ADD KEY `fk_id_kamar` (`id_kost`);

--
-- Indeks untuk tabel `kost`
--
ALTER TABLE `kost`
  ADD PRIMARY KEY (`id`),
  ADD KEY `NIK_Pemilik` (`NIK_Pemilik`);

--
-- Indeks untuk tabel `pemilik`
--
ALTER TABLE `pemilik`
  ADD PRIMARY KEY (`NIK`);

--
-- Indeks untuk tabel `penyewaan`
--
ALTER TABLE `penyewaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `NIK_penyewa` (`NIK_penyewa`),
  ADD KEY `penyewaan` (`idKamar`),
  ADD KEY `fk_penyewaan_kost` (`idKost`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`idPesanan`),
  ADD KEY `idPemesan` (`idPemesan`),
  ADD KEY `fkKostId` (`idKost`);

--
-- Indeks untuk tabel `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`NoRekening`),
  ADD KEY `NIK_Pemilik` (`NIK_Pemilik`);

--
-- Indeks untuk tabel `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `NIK_Penyewa` (`NIK_Penyewa`),
  ADD KEY `id_kost` (`id_kost`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`NIK`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kost`
--
ALTER TABLE `kost`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `penyewaan`
--
ALTER TABLE `penyewaan`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `fasil_kost`
--
ALTER TABLE `fasil_kost`
  ADD CONSTRAINT `fasil_kost_ibfk_1` FOREIGN KEY (`id_kost`) REFERENCES `kost` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fasil_kost_ibfk_2` FOREIGN KEY (`id_fasil`) REFERENCES `fasilitas` (`id`);

--
-- Ketidakleluasaan untuk tabel `kamar`
--
ALTER TABLE `kamar`
  ADD CONSTRAINT `fk_id_kamar` FOREIGN KEY (`id_kost`) REFERENCES `kost` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kost`
--
ALTER TABLE `kost`
  ADD CONSTRAINT `Kost_ibfk_1` FOREIGN KEY (`NIK_Pemilik`) REFERENCES `pemilik` (`NIK`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penyewaan`
--
ALTER TABLE `penyewaan`
  ADD CONSTRAINT `Penyewaan_ibfk_1` FOREIGN KEY (`NIK_penyewa`) REFERENCES `users` (`NIK`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_penyewaan_kost` FOREIGN KEY (`idKost`) REFERENCES `kost` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penyewaan` FOREIGN KEY (`idKamar`) REFERENCES `kamar` (`idKamar`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `Pesanan_ibfk_1` FOREIGN KEY (`idPemesan`) REFERENCES `users` (`NIK`),
  ADD CONSTRAINT `fkKostId` FOREIGN KEY (`idKost`) REFERENCES `kost` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rekening`
--
ALTER TABLE `rekening`
  ADD CONSTRAINT `Rekening_ibfk_1` FOREIGN KEY (`NIK_Pemilik`) REFERENCES `pemilik` (`NIK`);

--
-- Ketidakleluasaan untuk tabel `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`NIK_Penyewa`) REFERENCES `users` (`NIK`),
  ADD CONSTRAINT `Review_ibfk_2` FOREIGN KEY (`id_kost`) REFERENCES `kost` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
