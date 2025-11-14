-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2025 at 08:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem-kearsipan-bbpom`
--

-- --------------------------------------------------------

--
-- Table structure for table `arsip`
--

CREATE TABLE `arsip` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `klasifikasi_surat_id` bigint(20) UNSIGNED NOT NULL,
  `divisi_id` bigint(20) UNSIGNED NOT NULL,
  `bentuk_naskah_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `uraian_berkas` text NOT NULL,
  `tanggal_arsip` date NOT NULL,
  `kurun_waktu` varchar(255) DEFAULT NULL,
  `jumlah_berkas` varchar(255) DEFAULT NULL,
  `tingkat_perkembangan` varchar(255) NOT NULL,
  `lokasi_penyimpanan` varchar(255) NOT NULL,
  `keterangan_fisik` text DEFAULT NULL,
  `link_eksternal` text DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `arsip_files`
--

CREATE TABLE `arsip_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `arsip_id` bigint(20) UNSIGNED NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `nama_file_original` varchar(255) NOT NULL,
  `size` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `arsip_usulan_pemusnahan`
--

CREATE TABLE `arsip_usulan_pemusnahan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `arsip_id` bigint(20) UNSIGNED NOT NULL,
  `usulan_pemusnahan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `arsip_usulan_pindah`
--

CREATE TABLE `arsip_usulan_pindah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usulan_pindah_id` bigint(20) UNSIGNED NOT NULL,
  `arsip_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bentuk_naskahs`
--

CREATE TABLE `bentuk_naskahs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_bentuk_naskah` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `kode_sppd` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `klasifikasi_surat`
--

CREATE TABLE `klasifikasi_surat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_klasifikasi` varchar(255) NOT NULL,
  `nama_klasifikasi` text NOT NULL,
  `masa_aktif` int(11) NOT NULL,
  `masa_inaktif` int(11) NOT NULL,
  `status_akhir` enum('Musnah','Permanen') NOT NULL,
  `klasifikasi_keamanan` enum('Biasa/Terbuka','Terbatas','Rahasia','Sangat Rahasia') NOT NULL,
  `hak_akses` varchar(255) DEFAULT NULL,
  `unit_pengolah` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `link_terkaits`
--

CREATE TABLE `link_terkaits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `link_url` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL DEFAULT 'Portal Awal',
  `path_icon` varchar(255) DEFAULT NULL,
  `status` enum('Aktif','NonAktif') NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2025_09_27_031650_create_klasifikasi_surat_table', 1),
(5, '2025_09_28_063001_create_bentuk_naskahs_table', 1),
(6, '2025_09_28_070000_create_arsip_table', 1),
(7, '2025_09_28_070001_create_uraian_isi_informasi_table', 1),
(8, '2025_09_28_073304_create_link_terkaits_table', 1),
(9, '2025_09_29_165007_create_templates_table', 1),
(10, '2025_10_13_115140_create_usulan_pemusnahan_table', 1),
(11, '2025_10_13_115453_create_arsip_usulan_pemusnahan_table', 1),
(12, '2025_10_24_070002_create_arsip_files_table', 1),
(13, '2025_11_03_193223_create_usulan_pindahs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_template` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `kategori` varchar(255) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uraian_isi_informasi`
--

CREATE TABLE `uraian_isi_informasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `arsip_id` bigint(20) UNSIGNED NOT NULL,
  `nomor_item` varchar(255) DEFAULT NULL,
  `uraian` text NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jumlah_lembar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_pegawai` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `tempat_lhr` varchar(255) DEFAULT NULL,
  `tgl_lhr` date NOT NULL,
  `alamat` text DEFAULT NULL,
  `nikah` enum('Y','N') DEFAULT NULL,
  `jkel` enum('P','L') DEFAULT NULL,
  `telp` varchar(13) DEFAULT NULL,
  `jabatan_id` int(11) NOT NULL DEFAULT 0,
  `jabasn_id` int(11) DEFAULT 0,
  `seri_karpeg` varchar(50) DEFAULT NULL,
  `status` varchar(13) NOT NULL,
  `divisi_id` int(11) NOT NULL,
  `subdivisi_id` int(11) DEFAULT NULL,
  `golongan_id` int(11) DEFAULT NULL,
  `foto` varchar(100) DEFAULT '',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `aktif` enum('Y','N') DEFAULT NULL,
  `deskjob` varchar(250) NOT NULL,
  `TMT_Capeg` date DEFAULT NULL,
  `namanogelar` varchar(250) DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usulan_pemusnahan`
--

CREATE TABLE `usulan_pemusnahan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_usulan` varchar(255) NOT NULL,
  `tanggal_usulan` date NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Draft',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `nomor_surat_usulan` varchar(255) DEFAULT NULL,
  `tanggal_surat_usulan` date DEFAULT NULL,
  `file_surat_usulan_path` varchar(255) DEFAULT NULL,
  `nomor_surat_persetujuan` varchar(255) DEFAULT NULL,
  `tanggal_surat_persetujuan` date DEFAULT NULL,
  `file_surat_persetujuan_path` varchar(255) DEFAULT NULL,
  `tanggal_pemusnahan_fisik` date DEFAULT NULL,
  `nomor_bapa_diterima` varchar(255) DEFAULT NULL,
  `tanggal_bapa_diterima` date DEFAULT NULL,
  `file_bapa_diterima_path` varchar(255) DEFAULT NULL,
  `nomor_surat_penolakan` varchar(255) DEFAULT NULL,
  `tanggal_surat_penolakan` date DEFAULT NULL,
  `file_surat_penolakan_path` varchar(255) DEFAULT NULL,
  `catatan_penolakan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usulan_pindahs`
--

CREATE TABLE `usulan_pindahs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Draft',
  `nomor_ba` varchar(255) DEFAULT NULL,
  `tanggal_ba` date DEFAULT NULL,
  `file_ba_path` varchar(255) DEFAULT NULL,
  `diusulkan_oleh_id` bigint(20) UNSIGNED DEFAULT NULL,
  `diajukan_pada` timestamp NULL DEFAULT NULL,
  `dikembalikan_oleh_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dikembalikan_pada` timestamp NULL DEFAULT NULL,
  `catatan_admin` text DEFAULT NULL,
  `disetujui_oleh_id` bigint(20) UNSIGNED DEFAULT NULL,
  `disetujui_pada` timestamp NULL DEFAULT NULL,
  `dibatalkan_oleh_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dibatalkan_pada` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arsip`
--
ALTER TABLE `arsip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arsip_klasifikasi_surat_id_foreign` (`klasifikasi_surat_id`),
  ADD KEY `arsip_divisi_id_foreign` (`divisi_id`),
  ADD KEY `arsip_bentuk_naskah_id_foreign` (`bentuk_naskah_id`),
  ADD KEY `arsip_created_by_foreign` (`created_by`);

--
-- Indexes for table `arsip_files`
--
ALTER TABLE `arsip_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arsip_files_arsip_id_foreign` (`arsip_id`);

--
-- Indexes for table `arsip_usulan_pemusnahan`
--
ALTER TABLE `arsip_usulan_pemusnahan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arsip_usulan_pemusnahan_arsip_id_foreign` (`arsip_id`),
  ADD KEY `arsip_usulan_pemusnahan_usulan_pemusnahan_id_foreign` (`usulan_pemusnahan_id`);

--
-- Indexes for table `arsip_usulan_pindah`
--
ALTER TABLE `arsip_usulan_pindah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arsip_usulan_pindah_usulan_pindah_id_foreign` (`usulan_pindah_id`),
  ADD KEY `arsip_usulan_pindah_arsip_id_foreign` (`arsip_id`);

--
-- Indexes for table `bentuk_naskahs`
--
ALTER TABLE `bentuk_naskahs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bentuk_naskahs_nama_bentuk_naskah_unique` (`nama_bentuk_naskah`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `klasifikasi_surat`
--
ALTER TABLE `klasifikasi_surat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `klasifikasi_surat_kode_klasifikasi_unique` (`kode_klasifikasi`);

--
-- Indexes for table `link_terkaits`
--
ALTER TABLE `link_terkaits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `templates_created_by_foreign` (`created_by`);

--
-- Indexes for table `uraian_isi_informasi`
--
ALTER TABLE `uraian_isi_informasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uraian_isi_informasi_arsip_id_foreign` (`arsip_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `usulan_pemusnahan`
--
ALTER TABLE `usulan_pemusnahan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usulan_pemusnahan_nomor_usulan_unique` (`nomor_usulan`),
  ADD KEY `usulan_pemusnahan_created_by_foreign` (`created_by`);

--
-- Indexes for table `usulan_pindahs`
--
ALTER TABLE `usulan_pindahs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usulan_pindahs_user_id_foreign` (`user_id`),
  ADD KEY `usulan_pindahs_diusulkan_oleh_id_foreign` (`diusulkan_oleh_id`),
  ADD KEY `usulan_pindahs_dikembalikan_oleh_id_foreign` (`dikembalikan_oleh_id`),
  ADD KEY `usulan_pindahs_disetujui_oleh_id_foreign` (`disetujui_oleh_id`),
  ADD KEY `usulan_pindahs_dibatalkan_oleh_id_foreign` (`dibatalkan_oleh_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arsip`
--
ALTER TABLE `arsip`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `arsip_files`
--
ALTER TABLE `arsip_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `arsip_usulan_pemusnahan`
--
ALTER TABLE `arsip_usulan_pemusnahan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `arsip_usulan_pindah`
--
ALTER TABLE `arsip_usulan_pindah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bentuk_naskahs`
--
ALTER TABLE `bentuk_naskahs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `klasifikasi_surat`
--
ALTER TABLE `klasifikasi_surat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `link_terkaits`
--
ALTER TABLE `link_terkaits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uraian_isi_informasi`
--
ALTER TABLE `uraian_isi_informasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1213;

--
-- AUTO_INCREMENT for table `usulan_pemusnahan`
--
ALTER TABLE `usulan_pemusnahan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usulan_pindahs`
--
ALTER TABLE `usulan_pindahs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `arsip`
--
ALTER TABLE `arsip`
  ADD CONSTRAINT `arsip_bentuk_naskah_id_foreign` FOREIGN KEY (`bentuk_naskah_id`) REFERENCES `bentuk_naskahs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `arsip_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `arsip_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`),
  ADD CONSTRAINT `arsip_klasifikasi_surat_id_foreign` FOREIGN KEY (`klasifikasi_surat_id`) REFERENCES `klasifikasi_surat` (`id`);

--
-- Constraints for table `arsip_files`
--
ALTER TABLE `arsip_files`
  ADD CONSTRAINT `arsip_files_arsip_id_foreign` FOREIGN KEY (`arsip_id`) REFERENCES `arsip` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `arsip_usulan_pemusnahan`
--
ALTER TABLE `arsip_usulan_pemusnahan`
  ADD CONSTRAINT `arsip_usulan_pemusnahan_arsip_id_foreign` FOREIGN KEY (`arsip_id`) REFERENCES `arsip` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `arsip_usulan_pemusnahan_usulan_pemusnahan_id_foreign` FOREIGN KEY (`usulan_pemusnahan_id`) REFERENCES `usulan_pemusnahan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `arsip_usulan_pindah`
--
ALTER TABLE `arsip_usulan_pindah`
  ADD CONSTRAINT `arsip_usulan_pindah_arsip_id_foreign` FOREIGN KEY (`arsip_id`) REFERENCES `arsip` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `arsip_usulan_pindah_usulan_pindah_id_foreign` FOREIGN KEY (`usulan_pindah_id`) REFERENCES `usulan_pindahs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `templates`
--
ALTER TABLE `templates`
  ADD CONSTRAINT `templates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `uraian_isi_informasi`
--
ALTER TABLE `uraian_isi_informasi`
  ADD CONSTRAINT `uraian_isi_informasi_arsip_id_foreign` FOREIGN KEY (`arsip_id`) REFERENCES `arsip` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usulan_pemusnahan`
--
ALTER TABLE `usulan_pemusnahan`
  ADD CONSTRAINT `usulan_pemusnahan_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `usulan_pindahs`
--
ALTER TABLE `usulan_pindahs`
  ADD CONSTRAINT `usulan_pindahs_dibatalkan_oleh_id_foreign` FOREIGN KEY (`dibatalkan_oleh_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `usulan_pindahs_dikembalikan_oleh_id_foreign` FOREIGN KEY (`dikembalikan_oleh_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `usulan_pindahs_disetujui_oleh_id_foreign` FOREIGN KEY (`disetujui_oleh_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `usulan_pindahs_diusulkan_oleh_id_foreign` FOREIGN KEY (`diusulkan_oleh_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `usulan_pindahs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
