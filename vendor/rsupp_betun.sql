-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jul 2023 pada 06.11
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rsupp_betun`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_gejala`
--

CREATE TABLE `data_gejala` (
  `id_data_gejala` int(11) NOT NULL,
  `id_uji` int(11) NOT NULL,
  `id_gejala` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_gejala`
--

INSERT INTO `data_gejala` (`id_data_gejala`, `id_uji`, `id_gejala`) VALUES
(96, 1, 3),
(97, 1, 4),
(98, 1, 14),
(99, 1, 26),
(132, 2, 3),
(133, 2, 5),
(134, 2, 23),
(135, 2, 30);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_latih`
--

CREATE TABLE `data_latih` (
  `id_latih` int(11) NOT NULL,
  `nama` varchar(75) NOT NULL,
  `id_rawat` int(11) NOT NULL,
  `id_jenis_kelamin` int(11) NOT NULL,
  `id_usia` int(11) NOT NULL,
  `id_penyakit` int(11) NOT NULL,
  `id_lama_idap` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_latih`
--

INSERT INTO `data_latih` (`id_latih`, `nama`, `id_rawat`, `id_jenis_kelamin`, `id_usia`, `id_penyakit`, `id_lama_idap`, `created_at`, `updated_at`) VALUES
(1, 'Arlan Butar Butar', 1, 1, 2, 1, 1, '2023-07-01 13:53:11', '2023-07-01 13:53:11'),
(2, 'Itha', 1, 1, 1, 2, 2, '2023-07-16 11:38:34', '2023-07-16 11:38:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_uji`
--

CREATE TABLE `data_uji` (
  `id_uji` int(11) NOT NULL,
  `nama` varchar(75) NOT NULL,
  `id_rawat` int(11) NOT NULL,
  `id_jenis_kelamin` int(11) NOT NULL,
  `id_usia` int(11) NOT NULL,
  `id_penyakit` int(11) NOT NULL,
  `id_lama_idap` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_uji`
--

INSERT INTO `data_uji` (`id_uji`, `nama`, `id_rawat`, `id_jenis_kelamin`, `id_usia`, `id_penyakit`, `id_lama_idap`, `created_at`, `updated_at`) VALUES
(1, 'Arlan Butar Butar', 1, 1, 2, 1, 1, '2023-07-15 21:36:19', '2023-07-15 21:36:19'),
(2, 'Deby', 2, 2, 2, 1, 2, '2023-07-15 22:43:08', '2023-07-15 22:43:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `diagnosa`
--

CREATE TABLE `diagnosa` (
  `id_diagnosa` int(11) NOT NULL,
  `id_data_uji` int(11) NOT NULL,
  `id_klasifikasi` int(11) NOT NULL,
  `id_solusi` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala`
--

CREATE TABLE `gejala` (
  `id_gejala` int(11) NOT NULL,
  `id_penyakit` int(11) NOT NULL,
  `kode_gejala` char(5) NOT NULL,
  `gejala` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `id_penyakit`, `kode_gejala`, `gejala`) VALUES
(1, 1, 'G01', 'Nyeri kepala dan demam'),
(2, 1, 'G02', 'Nyeri dibelakang bola mata'),
(3, 1, 'G03', 'Nyeri otot'),
(4, 1, 'G04', 'Mual  dan muntah'),
(5, 1, 'G05', 'Ruam atau bintik merah pada kulit'),
(6, 1, 'G06', 'Nyeri Perut'),
(7, 1, 'G07', 'Mimisan dan Gusi Berdarah'),
(8, 2, 'G08', 'BAB Cair'),
(9, 2, 'G09', 'Tidak nafsu makan'),
(10, 2, 'G10', 'Mual dan muntah'),
(11, 2, 'G11', 'Kram pada perut'),
(12, 2, 'G12', 'Perut mulas atau kembung'),
(13, 2, 'G13', 'Dorongan untuk BAB meningkat'),
(14, 2, 'G14', 'Tidak mampu menahan BAB'),
(15, 2, 'G15', 'Demam'),
(16, 2, 'G16', 'Bercak darah pada fases'),
(17, 2, 'G17', 'Dehidrasi'),
(18, 3, 'G18', 'Berat badan anak dengan gejala TBC Paru turun atau tidak naik dalam 2 bulan terakhir     \n'),
(19, 3, 'G19', 'Demam lama lebih dari 2 minggu dan atau berulang tanpa sebab'),
(20, 3, 'G20', 'Suhu umumnya tidak tinggi'),
(21, 3, 'G21', 'Batuk lama lebih dari 2 minggu yang makin lama makin parah yang tidak membaik dengan pemberian antibiotik'),
(22, 3, 'G22', 'Badan lemas/lesu sehingga tidak aktif bermain'),
(23, 4, 'G25', 'Detak jantung meningkat (takikardia)'),
(24, 4, 'G26', 'Sesak napas atau kesulitas menarik napas(dyspnea)'),
(25, 4, 'G27', 'Kekurangan energi atau mudah lelah (kelelahan)'),
(26, 4, 'G28', 'Pusing atau vertigo, terutama saat berdiri'),
(27, 4, 'G29', 'Sakit kepala'),
(28, 4, 'G30', 'Mudah marah'),
(29, 4, 'G31', 'Lidah sakit atau bengkak(glositis)'),
(30, 4, 'G32', 'Penyakit kuning atau kulit, mata, dan mulut terlihat menguning'),
(31, 4, 'G33', 'Pembesaran limpa atau hari (splenomegali, hepatomegali)'),
(32, 4, 'G34', 'Pertumbuhan dan perkembangan yang  lambat atau tertunda'),
(33, 4, 'G35', 'Siklus haid tidak teratur'),
(34, 4, 'G36', 'Menstruasi tidak ada atau tertunda(amenore)');

-- --------------------------------------------------------

--
-- Struktur dari tabel `informasi`
--

CREATE TABLE `informasi` (
  `id` int(11) NOT NULL,
  `judul` varchar(75) NOT NULL,
  `konten` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `informasi`
--

INSERT INTO `informasi` (`id`, `judul`, `konten`, `created_at`, `updated_at`) VALUES
(2, 'Confirm my Invoice', '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis obcaecati consequuntur earum fugiat dolores quae asperiores aperiam, neque suscipit necessitatibus ducimus rerum ratione in illo facere repellendus porro! Ullam vero, odio quasi blanditiis iure obcaecati eaque error! Vel quibusdam voluptate nisi doloribus, pariatur explicabo nulla velit est nobis inventore ad in ipsam, sequi quis rerum beatae unde delectus nihil perspiciatis saepe adipisci consequatur. Assumenda vitae incidunt voluptate facere dignissimos molestias, ad dolorem eligendi numquam delectus eum veniam facilis commodi, praesentium obcaecati quasi laudantium eaque quibusdam sit est, et cum reprehenderit optio corrupti! Accusantium illum iure ad velit adipisci quibusdam blanditiis?</p>\r\n', '2023-07-16 11:52:07', '2023-07-16 12:04:36'),
(3, 'Menu Makanan', '<p><strong>Lorem ipsum </strong>dolor sit amet consectetur adipisicing elit. Officia saepe mollitia et, neque maxime sint, ad eveniet aperiam officiis libero perferendis necessitatibus! Minima aspernatur itaque expedita fuga vel aperiam exercitationem quibusdam ea qui voluptates ipsam iste nobis odio officiis, obcaecati laborum velit inventore dolor error vitae accusamus veritatis <em>ullam eos.</em></p>\r\n', '2023-07-16 11:53:33', '2023-07-16 12:04:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_kelamin`
--

CREATE TABLE `jenis_kelamin` (
  `id_jenis_kelamin` int(11) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis_kelamin`
--

INSERT INTO `jenis_kelamin` (`id_jenis_kelamin`, `jenis_kelamin`) VALUES
(1, 'Laki-Laki'),
(2, 'Perempuan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lama_idap`
--

CREATE TABLE `lama_idap` (
  `id_idap` int(11) NOT NULL,
  `lama_idap` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `lama_idap`
--

INSERT INTO `lama_idap` (`id_idap`, `lama_idap`) VALUES
(1, 'Baru mengidap'),
(2, 'Lama mengidap');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(11) NOT NULL,
  `id_penyakit` int(11) NOT NULL,
  `obat` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id_obat`, `id_penyakit`, `obat`) VALUES
(2, 1, 'Anak perlu istrahat yang cukup untuk memulihkan tubuhnya, berikan anak cairan yang cukup untuk mencegah dehidrasi.'),
(3, 2, 'Penting untuk menjaga kebersihan dan kebersihan pripadi anak, seperti mencuci tangan dengan sabun dan air bersih secara teratur, terutama sebelum maka'),
(4, 3, 'Harus rutin berobatan yang sudah di jadwalkan oleh dokter, dan juga menjaga kebersihan dan sehatan anak, serta memastikan anak mendapat nutrisi yang c'),
(5, 4, 'Memperhatikan pola makan sehat dan seimbang bagi anak, serta memberikan nutrisi yang cukup.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `overview`
--

CREATE TABLE `overview` (
  `id` int(11) NOT NULL,
  `judul` varchar(225) NOT NULL,
  `konten` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `overview`
--

INSERT INTO `overview` (`id`, `judul`, `konten`) VALUES
(1, 'RSUPP', '<p><strong>Lorem ipsum</strong>, dolor sit amet consectetur adipisicing elit. Voluptatibus atque ea vero, tempore ducimus maiores rem saepe amet vitae facere dignissimos iure similique reprehenderit quo enim rerum repudiandae, impedit cumque? Error perspiciatis nesciunt explicabo consectetur fugiat minima nisi, molestias suscipit beatae ullam. Sed dolorum fugiat ipsam ex vitae quos, adipisci blanditiis accusantium corrupti sint quas nam ullam ab. Facilis nisi a dolores iure dicta maxime quam repellat? Cum fuga facilis vero optio? Itaque porro hic laudantium cumque minima mollitia quo libero deserunt maiores beatae, obcaecati ut veritatis, quod ratione, eaque temporibus. Voluptatem minus voluptatum reprehenderit possimus soluta? Tenetur, quas. Necessitatibus?</p>\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyakit`
--

CREATE TABLE `penyakit` (
  `id_penyakit` int(11) NOT NULL,
  `kode_penyakit` char(5) NOT NULL,
  `nama_penyakit` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penyakit`
--

INSERT INTO `penyakit` (`id_penyakit`, `kode_penyakit`, `nama_penyakit`) VALUES
(1, 'P001', 'Demam Berdarah Dengue (DBD)'),
(2, 'P002', 'Diare Akut'),
(3, 'P003', 'Tuberkolosis Paru (TB-PARU)'),
(4, 'P004', 'Anemia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rawat`
--

CREATE TABLE `rawat` (
  `id_rawat` int(11) NOT NULL,
  `rawat` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rawat`
--

INSERT INTO `rawat` (`id_rawat`, `rawat`) VALUES
(1, 'Rawat Jalan'),
(2, 'Rawat Inap');

-- --------------------------------------------------------

--
-- Struktur dari tabel `solusi`
--

CREATE TABLE `solusi` (
  `id_solusi` int(11) NOT NULL,
  `id_penyakit` int(11) NOT NULL,
  `solusi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `solusi`
--

INSERT INTO `solusi` (`id_solusi`, `id_penyakit`, `solusi`) VALUES
(2, 1, 'Cairan Intravena, Paracetamol, Trolit,Maltofer,Trde,Kalnex,Domperidone,Motilium'),
(3, 2, 'Oralit, Zinkid Zinc Sirup, Madu Anak Antariksa,Lacto-B, Daryazinc, Guanistrep, Plain Yogurt, Air Kelapa, Wortel, Pisang'),
(4, 3, 'Pyrazinamide, Isoniazid, Streptomisin, Rifampisin,Ethambutol'),
(5, 4, 'Sangobion Vita-Tonik, Tonikum Bayer, Nature’s Plus Iron');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `id_role` int(11) DEFAULT 2,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(75) DEFAULT NULL,
  `password` varchar(75) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `id_role`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'admin@gmail.com', '$2y$10$//KMATh3ibPoI3nHFp7x/u7vnAbo2WyUgmI4x0CVVrH8ajFhMvbjG', '2023-06-18 08:58:56', '2023-06-18 08:58:56'),
(2, 2, 'ar.code_', 'arlan270899@gmail.com', '$2y$10$dt2681M3CLVXJYhU80SD0u8RCUlZWjFEQts/NiP1yoYJFVjr.Pvou', '2023-06-30 20:29:24', '2023-06-30 20:31:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_role`
--

CREATE TABLE `users_role` (
  `id_role` int(11) NOT NULL,
  `role` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users_role`
--

INSERT INTO `users_role` (`id_role`, `role`) VALUES
(1, 'Admin'),
(2, 'Pakar'),
(3, 'User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `usia`
--

CREATE TABLE `usia` (
  `id_usia` int(11) NOT NULL,
  `usia` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `usia`
--

INSERT INTO `usia` (`id_usia`, `usia`) VALUES
(1, '0-12 bulan'),
(2, '1-12 tahun');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_gejala`
--
ALTER TABLE `data_gejala`
  ADD PRIMARY KEY (`id_data_gejala`),
  ADD KEY `id_gejala` (`id_gejala`),
  ADD KEY `id_uji` (`id_uji`);

--
-- Indeks untuk tabel `data_latih`
--
ALTER TABLE `data_latih`
  ADD PRIMARY KEY (`id_latih`),
  ADD KEY `id_lama_idap` (`id_lama_idap`),
  ADD KEY `id_penyakit` (`id_penyakit`),
  ADD KEY `id_usia` (`id_usia`),
  ADD KEY `id_jenis_kelamin` (`id_jenis_kelamin`),
  ADD KEY `id_rawat` (`id_rawat`);

--
-- Indeks untuk tabel `data_uji`
--
ALTER TABLE `data_uji`
  ADD PRIMARY KEY (`id_uji`),
  ADD KEY `id_lama_idap` (`id_lama_idap`),
  ADD KEY `id_penyakit` (`id_penyakit`),
  ADD KEY `id_usia` (`id_usia`),
  ADD KEY `id_jenis_kelamin` (`id_jenis_kelamin`),
  ADD KEY `id_rawat` (`id_rawat`);

--
-- Indeks untuk tabel `diagnosa`
--
ALTER TABLE `diagnosa`
  ADD PRIMARY KEY (`id_diagnosa`),
  ADD KEY `id_data_uji` (`id_data_uji`);

--
-- Indeks untuk tabel `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`),
  ADD KEY `id_penyakit` (`id_penyakit`);

--
-- Indeks untuk tabel `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jenis_kelamin`
--
ALTER TABLE `jenis_kelamin`
  ADD PRIMARY KEY (`id_jenis_kelamin`);

--
-- Indeks untuk tabel `lama_idap`
--
ALTER TABLE `lama_idap`
  ADD PRIMARY KEY (`id_idap`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`),
  ADD KEY `id_penyakit` (`id_penyakit`);

--
-- Indeks untuk tabel `overview`
--
ALTER TABLE `overview`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id_penyakit`);

--
-- Indeks untuk tabel `rawat`
--
ALTER TABLE `rawat`
  ADD PRIMARY KEY (`id_rawat`);

--
-- Indeks untuk tabel `solusi`
--
ALTER TABLE `solusi`
  ADD PRIMARY KEY (`id_solusi`),
  ADD KEY `id_penyakit` (`id_penyakit`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`);

--
-- Indeks untuk tabel `users_role`
--
ALTER TABLE `users_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `usia`
--
ALTER TABLE `usia`
  ADD PRIMARY KEY (`id_usia`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_gejala`
--
ALTER TABLE `data_gejala`
  MODIFY `id_data_gejala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT untuk tabel `data_latih`
--
ALTER TABLE `data_latih`
  MODIFY `id_latih` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `data_uji`
--
ALTER TABLE `data_uji`
  MODIFY `id_uji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `diagnosa`
--
ALTER TABLE `diagnosa`
  MODIFY `id_diagnosa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gejala`
--
ALTER TABLE `gejala`
  MODIFY `id_gejala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jenis_kelamin`
--
ALTER TABLE `jenis_kelamin`
  MODIFY `id_jenis_kelamin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `lama_idap`
--
ALTER TABLE `lama_idap`
  MODIFY `id_idap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `overview`
--
ALTER TABLE `overview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  MODIFY `id_penyakit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `rawat`
--
ALTER TABLE `rawat`
  MODIFY `id_rawat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `solusi`
--
ALTER TABLE `solusi`
  MODIFY `id_solusi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users_role`
--
ALTER TABLE `users_role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `usia`
--
ALTER TABLE `usia`
  MODIFY `id_usia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_gejala`
--
ALTER TABLE `data_gejala`
  ADD CONSTRAINT `data_gejala_ibfk_1` FOREIGN KEY (`id_gejala`) REFERENCES `gejala` (`id_gejala`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `data_gejala_ibfk_2` FOREIGN KEY (`id_uji`) REFERENCES `data_uji` (`id_uji`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `data_latih`
--
ALTER TABLE `data_latih`
  ADD CONSTRAINT `data_latih_ibfk_1` FOREIGN KEY (`id_jenis_kelamin`) REFERENCES `jenis_kelamin` (`id_jenis_kelamin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `data_latih_ibfk_2` FOREIGN KEY (`id_usia`) REFERENCES `usia` (`id_usia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `data_latih_ibfk_3` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `data_latih_ibfk_4` FOREIGN KEY (`id_lama_idap`) REFERENCES `lama_idap` (`id_idap`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `data_latih_ibfk_7` FOREIGN KEY (`id_rawat`) REFERENCES `rawat` (`id_rawat`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `data_uji`
--
ALTER TABLE `data_uji`
  ADD CONSTRAINT `data_uji_ibfk_1` FOREIGN KEY (`id_jenis_kelamin`) REFERENCES `jenis_kelamin` (`id_jenis_kelamin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `data_uji_ibfk_2` FOREIGN KEY (`id_usia`) REFERENCES `usia` (`id_usia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `data_uji_ibfk_3` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `data_uji_ibfk_4` FOREIGN KEY (`id_lama_idap`) REFERENCES `lama_idap` (`id_idap`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `data_uji_ibfk_7` FOREIGN KEY (`id_rawat`) REFERENCES `rawat` (`id_rawat`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `diagnosa`
--
ALTER TABLE `diagnosa`
  ADD CONSTRAINT `diagnosa_ibfk_1` FOREIGN KEY (`id_data_uji`) REFERENCES `data_uji` (`id_uji`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `gejala`
--
ALTER TABLE `gejala`
  ADD CONSTRAINT `gejala_ibfk_1` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD CONSTRAINT `obat_ibfk_1` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `solusi`
--
ALTER TABLE `solusi`
  ADD CONSTRAINT `solusi_ibfk_1` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `users_role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
