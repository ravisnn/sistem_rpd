-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Des 2025 pada 14.45
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rencana_test`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'rencana_kegiatan', 'created', 'App\\Models\\RencanaKegiatan', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"kegiatan\":\"3375\",\"komponen\":\"001\",\"jenis_belanja\":\"51\",\"unit_kerja\":\"Umum\",\"output\":\"EBA.994\",\"akun_id\":8,\"uraian_id\":25,\"uraians\":null,\"target\":100000,\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 21:12:44', '2025-12-02 21:12:44'),
(2, 'rencana_kegiatan', 'created', 'App\\Models\\RencanaKegiatan', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"kegiatan\":\"3365\",\"komponen\":\"053\",\"jenis_belanja\":\"52\",\"unit_kerja\":\"Umum\",\"output\":\"DCF.001\",\"akun_id\":1,\"uraian_id\":1,\"uraians\":null,\"target\":0,\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 21:14:11', '2025-12-02 21:14:11'),
(3, 'rencana_kegiatan', 'deleted', 'App\\Models\\RencanaKegiatan', 'deleted', 1, 'App\\Models\\User', 1, '{\"old\":{\"kegiatan\":\"3375\",\"komponen\":\"001\",\"jenis_belanja\":\"51\",\"unit_kerja\":\"Umum\",\"output\":\"EBA.994\",\"akun_id\":8,\"uraian_id\":25,\"uraians\":null,\"target\":100000,\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 21:28:52', '2025-12-02 21:28:52'),
(4, 'rencana_kegiatan', 'deleted', 'App\\Models\\RencanaKegiatan', 'deleted', 2, 'App\\Models\\User', 1, '{\"old\":{\"kegiatan\":\"3365\",\"komponen\":\"053\",\"jenis_belanja\":\"52\",\"unit_kerja\":\"Umum\",\"output\":\"DCF.001\",\"akun_id\":1,\"uraian_id\":1,\"uraians\":null,\"target\":0,\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 21:29:06', '2025-12-02 21:29:06'),
(5, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 140, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Biaya Penerimaan\\/Jamuan Tamu, City Tour, dll untuk Tamu\\/Organisasi International\",\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":530000,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 23:46:21', '2025-12-02 23:46:21'),
(6, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 141, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Jasa Laundry\",\"jan\":0,\"feb\":2648500,\"mar\":0,\"apr\":6065696,\"mei\":2188000,\"jun\":1837500,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 23:48:08', '2025-12-02 23:48:08'),
(7, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 142, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Keperluan sehari-hari klinik\",\"jan\":0,\"feb\":750500,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 23:49:01', '2025-12-02 23:49:01'),
(8, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 143, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Keperluan sehari-hari perkantoran\",\"jan\":20000,\"feb\":12291600,\"mar\":783100,\"apr\":7713115,\"mei\":9963500,\"jun\":7036230,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 23:50:46', '2025-12-02 23:50:46'),
(9, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 144, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Linen Kantor\",\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":9049000,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 23:52:07', '2025-12-02 23:52:07'),
(10, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 145, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Penghasilan PPNPN 52 (Pengamanan)\",\"jan\":0,\"feb\":90697450,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 23:53:10', '2025-12-02 23:53:10'),
(11, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 146, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Penghasilan PPNPN 52 (Pengemudi)\",\"jan\":0,\"feb\":15249000,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 23:53:34', '2025-12-02 23:53:34'),
(12, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 147, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Penghasilan PPNPN 52 (Pramubakti)\",\"jan\":0,\"feb\":129875000,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 23:54:15', '2025-12-02 23:54:15'),
(13, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 148, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Penghasilan PPNPN 52 (Teknisi)\",\"jan\":0,\"feb\":10250250,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 23:54:45', '2025-12-02 23:54:45'),
(14, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 149, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Biaya pengiriman surat dinas pos (Dalam dan Luar Negeri)\",\"jan\":0,\"feb\":1538000,\"mar\":0,\"apr\":1087300,\"mei\":212000,\"jun\":204000,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 23:56:18', '2025-12-02 23:56:18'),
(15, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 150, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Honorarium Bendahara\",\"jan\":0,\"feb\":800000,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 23:56:56', '2025-12-02 23:56:56'),
(16, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 151, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Keperluan Standar Pelayanan Publik\",\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":4040000,\"mei\":27052600,\"jun\":69767400,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-02 23:58:32', '2025-12-02 23:58:32'),
(17, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 152, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pengangkutan Sampah\",\"jan\":0,\"feb\":150000,\"mar\":0,\"apr\":5150000,\"mei\":1800000,\"jun\":2000000,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:01:14', '2025-12-03 00:01:14'),
(18, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 153, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pengelolaan Limbah Medis\",\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":500000,\"jun\":500000,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:01:54', '2025-12-03 00:01:54'),
(19, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 154, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Uang Lembur\",\"jan\":0,\"feb\":2275000,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:02:35', '2025-12-03 00:02:35'),
(20, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 155, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Uang Makan Lembur\",\"jan\":0,\"feb\":1200000,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:02:59', '2025-12-03 00:02:59'),
(21, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 156, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pencetakan Banner\",\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":2776000,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:03:44', '2025-12-03 00:03:44'),
(22, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 157, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Alat Rumah Tangga dan Bahan Kebersihan\",\"jan\":0,\"feb\":4695680,\"mar\":0,\"apr\":0,\"mei\":330000,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:04:30', '2025-12-03 00:04:30'),
(23, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 158, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Alat Tulis Kantor (ATK)\",\"jan\":0,\"feb\":0,\"mar\":1274820,\"apr\":0,\"mei\":0,\"jun\":32111770,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:05:19', '2025-12-03 00:05:19'),
(24, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 159, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Amenities Asrama\",\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":8077248,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:06:00', '2025-12-03 00:06:00'),
(25, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 160, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Bahan Cetakan (+3jt-Juli)\",\"jan\":0,\"feb\":30364050,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:06:54', '2025-12-03 00:06:54'),
(26, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 161, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pengadaan Obat-obatan, bahan-bahan dan Persediaan Klinik\",\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":778894494,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:07:49', '2025-12-03 00:07:49'),
(27, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 162, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":null,\"jan\":123953370,\"feb\":138722547,\"mar\":132751502,\"apr\":107059711,\"mei\":121215050,\"jun\":134912716,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:09:09', '2025-12-03 00:09:09'),
(28, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 163, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":null,\"jan\":546676,\"feb\":1328199,\"mar\":554835,\"apr\":1454907,\"mei\":965050,\"jun\":931407,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:10:40', '2025-12-03 00:10:40'),
(29, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 164, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":null,\"jan\":6376000,\"feb\":5430000,\"mar\":5782000,\"apr\":5441000,\"mei\":2647000,\"jun\":2581000,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:12:08', '2025-12-03 00:12:08'),
(30, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 165, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Langganan Internet\",\"jan\":0,\"feb\":760300,\"mar\":0,\"apr\":69160800,\"mei\":0,\"jun\":760800,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:13:16', '2025-12-03 00:13:16'),
(31, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 166, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Langganan Lisensi Software Manajemen Perkantoran\",\"jan\":0,\"feb\":2218500,\"mar\":2347000,\"apr\":32000000,\"mei\":3818331,\"jun\":30045,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:14:31', '2025-12-03 00:14:31'),
(32, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 167, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Lisensi Aplikasi Video Conference\",\"jan\":0,\"feb\":2944412,\"mar\":0,\"apr\":0,\"mei\":3054844,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:15:28', '2025-12-03 00:15:28'),
(33, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 168, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Sewa Kendaraan Operasional Roda 4\",\"jan\":130810824,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:16:59', '2025-12-03 00:16:59'),
(34, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 169, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Sewa Mesin Fotocopy (Digital)\",\"jan\":0,\"feb\":888000,\"mar\":888000,\"apr\":888000,\"mei\":888000,\"jun\":888000,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:18:06', '2025-12-03 00:18:06'),
(35, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 170, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Sewa Mesin Printer Warna\",\"jan\":0,\"feb\":9000000,\"mar\":9000000,\"apr\":9000000,\"mei\":9000000,\"jun\":9000000,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:18:48', '2025-12-03 00:18:48'),
(36, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 171, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Sewa tenda, panggung, dan dekorasi\",\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":4280000,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:19:30', '2025-12-03 00:19:30'),
(37, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 172, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Jasa Desain (+)\",\"jan\":5980000,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:20:17', '2025-12-03 00:20:17'),
(38, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 173, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pengadaan Jasa Pengelolaan Gedung Pusdiklat APUPPT (Building Management)\",\"jan\":0,\"feb\":0,\"mar\":372204134,\"apr\":695347983,\"mei\":384081342,\"jun\":384081342,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:21:51', '2025-12-03 00:21:51'),
(39, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 174, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Halaman gedung\\/bangunan kantor (Gedung Ciloto)\",\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":170000,\"mei\":1706275,\"jun\":83000,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:23:11', '2025-12-03 00:23:11'),
(40, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 175, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Halaman gedung\\/bangunan kantor (Gedung Pusdiklat)\",\"jan\":0,\"feb\":2840200,\"mar\":0,\"apr\":656000,\"mei\":4202600,\"jun\":6776670,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:24:17', '2025-12-03 00:24:17'),
(41, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 176, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pemeliharaan gedung bertingkat (Gedung Ciloto)\",\"jan\":0,\"feb\":8071248,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":16075796,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:25:29', '2025-12-03 00:25:29'),
(42, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 177, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pemeliharaan gedung bertingkat (Gedung Pusdiklat)\",\"jan\":0,\"feb\":12702947,\"mar\":17321597,\"apr\":17493597,\"mei\":72081183,\"jun\":54890837,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:26:51', '2025-12-03 00:26:51'),
(43, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 144, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"STP dan pompa-pompa\"},\"old\":{\"uraians\":\"\"}}', NULL, '2025-12-03 00:29:35', '2025-12-03 00:29:35'),
(44, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 178, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"AC Presisi\",\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":32000000,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:30:18', '2025-12-03 00:30:18'),
(45, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 179, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Dehumidifier dan Filter Air Purifier\",\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":48299985,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:31:31', '2025-12-03 00:31:31'),
(46, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 180, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Mekanikal Elektrik Lainnya\",\"jan\":435000,\"feb\":3107899,\"mar\":17094000,\"apr\":12921000,\"mei\":1291000,\"jun\":3826592,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:33:17', '2025-12-03 00:33:17'),
(47, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 181, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pemeliharaan dan operasional kendaraan operasional roda 2\",\"jan\":0,\"feb\":229950,\"mar\":0,\"apr\":500000,\"mei\":624062,\"jun\":274000,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:35:23', '2025-12-03 00:35:23'),
(48, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 182, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pemeliharaan Elevator System\",\"jan\":0,\"feb\":0,\"mar\":9768000,\"apr\":0,\"mei\":9768000,\"jun\":2912700,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:36:20', '2025-12-03 00:36:20'),
(49, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 183, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pemeliharaan kendaraan dinas Eselon II\",\"jan\":0,\"feb\":4045000,\"mar\":0,\"apr\":3656500,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:38:18', '2025-12-03 00:38:18'),
(50, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 184, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pemeliharaan kendaraan operasional roda 4\",\"jan\":0,\"feb\":6201511,\"mar\":0,\"apr\":2400000,\"mei\":4700000,\"jun\":2770000,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:39:35', '2025-12-03 00:39:35'),
(51, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 185, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Sistem Tata Udara (Chiller, AHU, FCU, Dehumidifier dan Filter Air Purifier)\",\"jan\":0,\"feb\":12853000,\"mar\":0,\"apr\":0,\"mei\":313455212,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:41:26', '2025-12-03 00:41:26'),
(52, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 186, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"STP dan pompa-pompa\",\"jan\":0,\"feb\":0,\"mar\":2719500,\"apr\":2719500,\"mei\":2719500,\"jun\":2719500,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:42:23', '2025-12-03 00:42:23'),
(53, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 187, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"UPS\",\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":28000000,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:43:13', '2025-12-03 00:43:13'),
(54, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Biaya Penerimaan\\/Jamuan Tamu, City Tour, dll untuk Tamu\\/Organisasi International\",\"jan\":10,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 00:48:08', '2025-12-03 00:48:08'),
(55, 'rencana_kegiatan', 'created', 'App\\Models\\RencanaKegiatan', 'created', 218, 'App\\Models\\User', 1, '{\"attributes\":{\"kegiatan\":\"3365\",\"komponen\":\"053\",\"jenis_belanja\":\"52\",\"unit_kerja\":\"Umum\",\"output\":\"DCF.001\",\"akun_id\":1,\"uraian_id\":5,\"uraians\":null,\"target\":100,\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 01:07:49', '2025-12-03 01:07:49'),
(56, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 218, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"-\",\"target\":50},\"old\":{\"uraians\":null,\"target\":100}}', NULL, '2025-12-03 01:08:16', '2025-12-03 01:08:16'),
(57, 'rencana_kegiatan', 'deleted', 'App\\Models\\RencanaKegiatan', 'deleted', 218, 'App\\Models\\User', 1, '{\"old\":{\"kegiatan\":\"3365\",\"komponen\":\"053\",\"jenis_belanja\":\"52\",\"unit_kerja\":\"Umum\",\"output\":\"DCF.001\",\"akun_id\":1,\"uraian_id\":5,\"uraians\":\"-\",\"target\":50,\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-03 01:08:31', '2025-12-03 01:08:31'),
(58, 'rencana_kegiatan', 'created', 'App\\Models\\RencanaKegiatan', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"kegiatan\":\"3375\",\"komponen\":\"001\",\"jenis_belanja\":\"51\",\"unit_kerja\":\"Umum\",\"output\":\"EBA.994\",\"akun_id\":8,\"uraian_id\":25,\"uraians\":null,\"target\":0,\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 01:46:50', '2025-12-04 01:46:50'),
(59, 'rencana_kegiatan', 'created', 'App\\Models\\RencanaKegiatan', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"kegiatan\":\"3377\",\"komponen\":\"001\",\"jenis_belanja\":\"52\",\"unit_kerja\":\"Umum\",\"output\":\"EBA.994\",\"akun_id\":17,\"uraian_id\":1,\"uraians\":null,\"target\":0,\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 01:49:19', '2025-12-04 01:49:19'),
(60, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":null,\"jan\":530000,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 01:49:50', '2025-12-04 01:49:50'),
(61, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":null,\"jan\":0,\"feb\":250000,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 01:50:51', '2025-12-04 01:50:51'),
(62, 'rencana_kegiatan', 'created', 'App\\Models\\RencanaKegiatan', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"kegiatan\":\"3375\",\"komponen\":\"001\",\"jenis_belanja\":\"51\",\"unit_kerja\":\"Umum\",\"output\":\"EBA.994\",\"akun_id\":8,\"uraian_id\":25,\"uraians\":null,\"target\":10,\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 01:52:11', '2025-12-04 01:52:11'),
(63, 'realisasi', 'updated', 'App\\Models\\Realisasi', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"jan\":0},\"old\":{\"jan\":530000}}', NULL, '2025-12-04 01:52:57', '2025-12-04 01:52:57'),
(64, 'realisasi', 'updated', 'App\\Models\\Realisasi', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"jan\":50000},\"old\":{\"jan\":0}}', NULL, '2025-12-04 01:53:30', '2025-12-04 01:53:30'),
(65, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 140, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pembayaran Gaji Induk PNS\",\"jan\":153208561,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 02:44:46', '2025-12-04 02:44:46'),
(66, 'realisasi', 'updated', 'App\\Models\\Realisasi', 'updated', 140, 'App\\Models\\User', 1, '{\"attributes\":{\"feb\":153492907,\"mar\":153642367,\"jul\":161449652},\"old\":{\"feb\":0,\"mar\":0,\"jul\":0}}', NULL, '2025-12-04 02:46:32', '2025-12-04 02:46:32'),
(67, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 141, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Kekurangan Gaji DP\",\"jan\":0,\"feb\":345175,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 02:47:28', '2025-12-04 02:47:28'),
(68, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 142, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pembayaran Gaji THR PNS\",\"jan\":0,\"feb\":0,\"mar\":164903105,\"apr\":1234760631,\"mei\":1245274657,\"jun\":2638146606,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 02:51:07', '2025-12-04 02:51:07'),
(69, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 143, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pembayaran Gaji PPPK\",\"jan\":58380700,\"feb\":58380700,\"mar\":58380700,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":58891100,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 02:53:14', '2025-12-04 02:53:14'),
(70, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 144, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pembayaran Gaji THR PPPK\",\"jan\":0,\"feb\":0,\"mar\":58380700,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 02:54:11', '2025-12-04 02:54:11'),
(71, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 145, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pembayaran Tunsus PNS\",\"jan\":719226646,\"feb\":718082770,\"mar\":720480852,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":764429195,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 02:56:39', '2025-12-04 02:56:39'),
(72, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 146, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Kekurangan Pembayaran Tunsus PNS Des 2024 (38%)\",\"jan\":297843330,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 02:58:07', '2025-12-04 02:58:07'),
(73, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 147, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pembayaran Tunsus THR PNS\",\"jan\":0,\"feb\":0,\"mar\":841715073,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 02:59:11', '2025-12-04 02:59:11'),
(74, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 148, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pembayaran Tunsus PPPK\",\"jan\":194460635,\"feb\":194327120,\"mar\":194964400,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":195132485,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 03:01:16', '2025-12-04 03:01:16'),
(75, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 149, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Kekurangan Pembayaran Tunsus PPPK Des 2024 (38%)\",\"jan\":73922863,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 03:08:03', '2025-12-04 03:08:03'),
(76, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 150, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Pembayaran Tunsus THR PPPK\",\"jan\":0,\"feb\":0,\"mar\":214750051,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 03:10:19', '2025-12-04 03:10:19'),
(77, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 151, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Penghasilan PPNPN 51\",\"jan\":0,\"feb\":37585975,\"mar\":37734750,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":37815900,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 03:13:16', '2025-12-04 03:13:16'),
(78, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 152, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"Penghasilan THR PPNPN 51\",\"jan\":0,\"feb\":0,\"mar\":34353900,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 03:14:11', '2025-12-04 03:14:11'),
(79, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 153, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"ULembur PNS\",\"jan\":0,\"feb\":434000,\"mar\":755000,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 03:15:36', '2025-12-04 03:15:36'),
(80, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 154, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"ULembur PPPK\",\"jan\":0,\"feb\":0,\"mar\":1010000,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":0,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 03:16:29', '2025-12-04 03:16:29'),
(81, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 155, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"UMakan PPPK\",\"jan\":0,\"feb\":8882000,\"mar\":9622000,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":7852000,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 03:18:20', '2025-12-04 03:18:20'),
(82, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 156, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"UMakan PNS\",\"jan\":0,\"feb\":22431000,\"mar\":25033000,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":18474000,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 03:20:04', '2025-12-04 03:20:04'),
(83, 'realisasi', 'created', 'App\\Models\\Realisasi', 'created', 157, 'App\\Models\\User', 1, '{\"attributes\":{\"uraians\":\"ULembur PPPNPN\",\"jan\":0,\"feb\":0,\"mar\":0,\"apr\":0,\"mei\":0,\"jun\":0,\"jul\":2847000,\"agt\":0,\"sep\":0,\"okt\":0,\"nov\":0,\"des\":0}}', NULL, '2025-12-04 03:32:31', '2025-12-04 03:32:31'),
(84, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 210, 'App\\Models\\User', 1, '{\"attributes\":{\"jan\":0,\"feb\":37585975,\"mar\":37734750,\"apr\":37842950,\"mei\":37748275,\"jun\":37761800,\"jul\":37815900,\"okt\":37870000},\"old\":{\"jan\":37585975,\"feb\":37734750,\"mar\":37842950,\"apr\":37748275,\"mei\":37761800,\"jun\":37815900,\"jul\":37870000,\"okt\":0}}', NULL, '2025-12-04 04:16:22', '2025-12-04 04:16:22'),
(85, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 213, 'App\\Models\\User', 1, '{\"attributes\":{\"jan\":0,\"feb\":22431000,\"mar\":25033000,\"apr\":23420000,\"mei\":17631000,\"jun\":17357000,\"jul\":18474000,\"agt\":31142000,\"sep\":27080000,\"okt\":25326000,\"nov\":27738000,\"des\":24120000},\"old\":{\"jan\":22431000,\"feb\":25033000,\"mar\":23420000,\"apr\":17631000,\"mei\":17357000,\"jun\":18474000,\"jul\":31142000,\"agt\":27080000,\"sep\":25326000,\"okt\":27738000,\"nov\":24120000,\"des\":25326000}}', NULL, '2025-12-04 04:33:25', '2025-12-04 04:33:25'),
(86, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 213, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":49466000},\"old\":{\"des\":24120000}}', NULL, '2025-12-04 04:38:47', '2025-12-04 04:38:47'),
(87, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 213, 'App\\Models\\User', 1, '{\"attributes\":{\"target\":285098000},\"old\":{\"target\":285078000}}', NULL, '2025-12-04 04:40:30', '2025-12-04 04:40:30'),
(88, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 214, 'App\\Models\\User', 1, '{\"attributes\":{\"jan\":0,\"feb\":8882000,\"mar\":9622000,\"apr\":9287000,\"mei\":7235000,\"jun\":7671000,\"jul\":7852000,\"agt\":11822000,\"sep\":10280000,\"okt\":10794000,\"nov\":17457000,\"des\":31119000},\"old\":{\"jan\":8882000,\"feb\":9622000,\"mar\":9287000,\"apr\":7235000,\"mei\":7671000,\"jun\":7852000,\"jul\":11822000,\"agt\":10280000,\"sep\":10794000,\"okt\":17457000,\"nov\":15180000,\"des\":15939000}}', NULL, '2025-12-04 04:43:58', '2025-12-04 04:43:58'),
(89, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 215, 'App\\Models\\User', 1, '{\"attributes\":{\"jan\":0,\"feb\":434000,\"mar\":755000,\"apr\":898000,\"mei\":0,\"jun\":591000},\"old\":{\"jan\":434000,\"feb\":755000,\"mar\":898000,\"apr\":0,\"mei\":591000,\"jun\":0}}', NULL, '2025-12-04 04:46:20', '2025-12-04 04:46:20'),
(90, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 216, 'App\\Models\\User', 1, '{\"attributes\":{\"jan\":0,\"feb\":0,\"mar\":1010000,\"mei\":0,\"jun\":753000},\"old\":{\"jan\":262000,\"feb\":748000,\"mar\":0,\"mei\":753000,\"jun\":0}}', NULL, '2025-12-04 04:48:45', '2025-12-04 04:48:45'),
(91, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 54, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":0},\"old\":{\"des\":151367954}}', NULL, '2025-12-04 06:00:57', '2025-12-04 06:00:57'),
(92, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 213, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":0},\"old\":{\"des\":49466000}}', NULL, '2025-12-04 06:01:33', '2025-12-04 06:01:33'),
(93, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 195, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":0},\"old\":{\"des\":81262232}}', NULL, '2025-12-04 06:01:48', '2025-12-04 06:01:48'),
(94, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 214, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":0},\"old\":{\"des\":31119000}}', NULL, '2025-12-04 06:02:15', '2025-12-04 06:02:15'),
(95, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 215, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":0},\"old\":{\"des\":6650000}}', NULL, '2025-12-04 06:02:31', '2025-12-04 06:02:31'),
(96, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 216, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":0},\"old\":{\"des\":1388000}}', NULL, '2025-12-04 06:02:54', '2025-12-04 06:02:54'),
(97, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 198, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":0},\"old\":{\"des\":746803655}}', NULL, '2025-12-04 06:03:27', '2025-12-04 06:03:27'),
(98, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 206, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":0},\"old\":{\"des\":252469000}}', NULL, '2025-12-04 06:04:14', '2025-12-04 06:04:14'),
(99, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 54, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":151367954},\"old\":{\"des\":0}}', NULL, '2025-12-04 06:19:16', '2025-12-04 06:19:16'),
(100, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 213, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":49466000},\"old\":{\"des\":0}}', NULL, '2025-12-04 06:19:50', '2025-12-04 06:19:50'),
(101, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 213, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":49446000},\"old\":{\"des\":49466000}}', NULL, '2025-12-04 06:22:27', '2025-12-04 06:22:27'),
(102, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 213, 'App\\Models\\User', 1, '{\"attributes\":{\"target\":285078000},\"old\":{\"target\":285098000}}', NULL, '2025-12-04 06:23:04', '2025-12-04 06:23:04'),
(103, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 195, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":81262232},\"old\":{\"des\":0}}', NULL, '2025-12-04 06:23:22', '2025-12-04 06:23:22'),
(104, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 214, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":31119000},\"old\":{\"des\":0}}', NULL, '2025-12-04 06:23:52', '2025-12-04 06:23:52'),
(105, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 215, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":6650000},\"old\":{\"des\":0}}', NULL, '2025-12-04 06:24:09', '2025-12-04 06:24:09'),
(106, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 216, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":1388000},\"old\":{\"des\":0}}', NULL, '2025-12-04 06:24:33', '2025-12-04 06:24:33'),
(107, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 198, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":746803655},\"old\":{\"des\":0}}', NULL, '2025-12-04 06:24:59', '2025-12-04 06:24:59'),
(108, 'rencana_kegiatan', 'updated', 'App\\Models\\RencanaKegiatan', 'updated', 206, 'App\\Models\\User', 1, '{\"attributes\":{\"des\":252469000},\"old\":{\"des\":0}}', NULL, '2025-12-04 06:25:24', '2025-12-04 06:25:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akuns`
--

CREATE TABLE `akuns` (
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `akuns`
--

INSERT INTO `akuns` (`id_akun`, `kode`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'A', 'Penyelenggaraan Pendidikan dan Pelatihan', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(2, 'B', 'Kerjasama Pendidikan dan Pelatihan', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(3, 'C', 'Perencanaan dan Pengembangan Program Pelatihan', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(4, 'D', 'Persiapan Sertifikasi Pendidikan dan Pelatihan', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(5, 'E', 'Publikasi Pendidikan dan Pelatihan', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(6, 'F', 'Penjaminan Mutu Layanan Pendidikan dan Pelatihan', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(7, 'G', 'Evaluasi Pendidikan dan Pelatihan', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(8, 'A', 'Layanan Dukungan Manajemen Internal', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(9, 'A', 'Perencanaan dan Penganggaran Internal Pusdiklat', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(10, 'A', 'Pengelolaan Keuangan Pusdiklat', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(11, 'B', 'Pengelolaan Kinerja', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(12, 'A', 'Layanan Manajemen Ortala & RB', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(13, 'B', 'Layanan Manajemen SDM Pusdiklat', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(14, 'A', 'Layanan BMN', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(15, 'B', 'Layanan Umum dan Perlengkapan', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(16, 'C', 'Layanan Koordinasi Internal dan Eksternal', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(17, 'A', 'Layanan Perkantoran', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(18, 'A', 'Layanan Sarana Internal', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(19, 'A', 'Belanja Penambahan Nilai Gedung dan Bangunan', '2025-12-02 20:58:04', '2025-12-02 20:58:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ikpa_targets`
--

CREATE TABLE `ikpa_targets` (
  `id_ikpa_target` bigint(20) UNSIGNED NOT NULL,
  `jenis_belanja` varchar(255) NOT NULL,
  `triwulan` tinyint(3) UNSIGNED NOT NULL,
  `tahun` int(11) NOT NULL,
  `target` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ikpa_targets`
--

INSERT INTO `ikpa_targets` (`id_ikpa_target`, `jenis_belanja`, `triwulan`, `tahun`, `target`, `created_at`, `updated_at`) VALUES
(1, '51', 1, 2025, 20, '2025-12-03 23:42:26', '2025-12-03 23:42:26'),
(2, '51', 3, 2025, 75, '2025-12-04 00:20:48', '2025-12-04 00:20:48'),
(3, '51', 4, 2025, 95, '2025-12-04 00:21:01', '2025-12-04 00:21:01'),
(4, '53', 1, 2025, 10, '2025-12-04 00:22:07', '2025-12-04 00:22:07'),
(5, '53', 2, 2025, 40, '2025-12-04 00:22:22', '2025-12-04 00:22:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatans`
--

CREATE TABLE `kegiatans` (
  `id_kegiatan` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kegiatans`
--

INSERT INTO `kegiatans` (`id_kegiatan`, `kode`, `created_at`, `updated_at`) VALUES
(1, '3365', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(2, '3375', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(3, '3376', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(4, '3377', '2025-12-02 20:58:05', '2025-12-02 20:58:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan_output`
--

CREATE TABLE `kegiatan_output` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kegiatan_id` bigint(20) UNSIGNED NOT NULL,
  `output_id` bigint(20) UNSIGNED NOT NULL,
  `akun_id` bigint(20) UNSIGNED NOT NULL,
  `uraian_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kegiatan_output`
--

INSERT INTO `kegiatan_output` (`id`, `kegiatan_id`, `output_id`, `akun_id`, `uraian_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(2, 1, 1, 1, 2, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(3, 1, 1, 1, 3, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(4, 1, 1, 1, 4, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(5, 1, 1, 1, 5, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(6, 1, 1, 1, 6, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(7, 1, 1, 1, 7, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(8, 1, 1, 1, 8, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(9, 1, 1, 1, 9, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(10, 1, 1, 1, 10, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(11, 1, 1, 1, 11, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(12, 1, 1, 1, 12, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(13, 1, 1, 1, 13, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(14, 1, 1, 1, 14, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(15, 1, 1, 1, 15, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(16, 1, 1, 1, 16, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(17, 1, 1, 1, 17, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(18, 1, 1, 1, 18, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(19, 1, 1, 1, 19, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(20, 1, 1, 1, 20, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(21, 1, 1, 1, 21, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(22, 1, 1, 1, 22, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(23, 1, 1, 1, 23, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(24, 1, 1, 1, 24, '2025-12-03 04:38:21', '2025-12-03 04:38:21'),
(32, 1, 1, 2, 1, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(33, 1, 1, 2, 2, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(34, 1, 1, 2, 3, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(35, 1, 1, 2, 4, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(36, 1, 1, 2, 5, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(37, 1, 1, 2, 6, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(38, 1, 1, 2, 7, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(39, 1, 1, 2, 8, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(40, 1, 1, 2, 9, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(41, 1, 1, 2, 10, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(42, 1, 1, 2, 11, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(43, 1, 1, 2, 12, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(44, 1, 1, 2, 13, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(45, 1, 1, 2, 14, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(46, 1, 1, 2, 15, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(47, 1, 1, 2, 16, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(48, 1, 1, 2, 17, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(49, 1, 1, 2, 18, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(50, 1, 1, 2, 19, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(51, 1, 1, 2, 20, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(52, 1, 1, 2, 21, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(53, 1, 1, 2, 22, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(54, 1, 1, 2, 23, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(55, 1, 1, 2, 24, '2025-12-03 04:39:10', '2025-12-03 04:39:10'),
(63, 1, 1, 3, 1, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(64, 1, 1, 3, 2, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(65, 1, 1, 3, 3, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(66, 1, 1, 3, 4, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(67, 1, 1, 3, 5, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(68, 1, 1, 3, 6, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(69, 1, 1, 3, 7, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(70, 1, 1, 3, 8, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(71, 1, 1, 3, 9, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(72, 1, 1, 3, 10, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(73, 1, 1, 3, 11, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(74, 1, 1, 3, 12, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(75, 1, 1, 3, 13, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(76, 1, 1, 3, 14, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(77, 1, 1, 3, 15, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(78, 1, 1, 3, 16, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(79, 1, 1, 3, 17, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(80, 1, 1, 3, 18, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(81, 1, 1, 3, 19, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(82, 1, 1, 3, 20, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(83, 1, 1, 3, 21, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(84, 1, 1, 3, 22, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(85, 1, 1, 3, 23, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(86, 1, 1, 3, 24, '2025-12-03 04:40:06', '2025-12-03 04:40:06'),
(94, 1, 1, 4, 1, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(95, 1, 1, 4, 2, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(96, 1, 1, 4, 3, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(97, 1, 1, 4, 4, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(98, 1, 1, 4, 5, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(99, 1, 1, 4, 6, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(100, 1, 1, 4, 7, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(101, 1, 1, 4, 8, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(102, 1, 1, 4, 9, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(103, 1, 1, 4, 10, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(104, 1, 1, 4, 11, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(105, 1, 1, 4, 12, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(106, 1, 1, 4, 13, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(107, 1, 1, 4, 14, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(108, 1, 1, 4, 15, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(109, 1, 1, 4, 16, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(110, 1, 1, 4, 17, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(111, 1, 1, 4, 18, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(112, 1, 1, 4, 19, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(113, 1, 1, 4, 20, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(114, 1, 1, 4, 21, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(115, 1, 1, 4, 22, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(116, 1, 1, 4, 23, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(117, 1, 1, 4, 24, '2025-12-03 04:40:19', '2025-12-03 04:40:19'),
(125, 1, 1, 5, 1, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(126, 1, 1, 5, 2, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(127, 1, 1, 5, 3, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(128, 1, 1, 5, 4, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(129, 1, 1, 5, 5, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(130, 1, 1, 5, 6, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(131, 1, 1, 5, 7, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(132, 1, 1, 5, 8, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(133, 1, 1, 5, 9, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(134, 1, 1, 5, 10, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(135, 1, 1, 5, 11, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(136, 1, 1, 5, 12, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(137, 1, 1, 5, 13, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(138, 1, 1, 5, 14, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(139, 1, 1, 5, 15, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(140, 1, 1, 5, 16, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(141, 1, 1, 5, 17, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(142, 1, 1, 5, 18, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(143, 1, 1, 5, 19, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(144, 1, 1, 5, 20, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(145, 1, 1, 5, 21, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(146, 1, 1, 5, 22, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(147, 1, 1, 5, 23, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(148, 1, 1, 5, 24, '2025-12-03 04:41:19', '2025-12-03 04:41:19'),
(156, 1, 1, 6, 1, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(157, 1, 1, 6, 2, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(158, 1, 1, 6, 3, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(159, 1, 1, 6, 4, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(160, 1, 1, 6, 5, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(161, 1, 1, 6, 6, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(162, 1, 1, 6, 7, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(163, 1, 1, 6, 8, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(164, 1, 1, 6, 9, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(165, 1, 1, 6, 10, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(166, 1, 1, 6, 11, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(167, 1, 1, 6, 12, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(168, 1, 1, 6, 13, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(169, 1, 1, 6, 14, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(170, 1, 1, 6, 15, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(171, 1, 1, 6, 16, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(172, 1, 1, 6, 17, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(173, 1, 1, 6, 18, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(174, 1, 1, 6, 19, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(175, 1, 1, 6, 20, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(176, 1, 1, 6, 21, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(177, 1, 1, 6, 22, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(178, 1, 1, 6, 23, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(179, 1, 1, 6, 24, '2025-12-03 04:41:36', '2025-12-03 04:41:36'),
(187, 1, 1, 7, 1, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(188, 1, 1, 7, 2, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(189, 1, 1, 7, 3, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(190, 1, 1, 7, 4, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(191, 1, 1, 7, 5, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(192, 1, 1, 7, 6, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(193, 1, 1, 7, 7, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(194, 1, 1, 7, 8, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(195, 1, 1, 7, 9, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(196, 1, 1, 7, 10, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(197, 1, 1, 7, 11, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(198, 1, 1, 7, 12, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(199, 1, 1, 7, 13, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(200, 1, 1, 7, 14, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(201, 1, 1, 7, 15, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(202, 1, 1, 7, 16, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(203, 1, 1, 7, 17, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(204, 1, 1, 7, 18, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(205, 1, 1, 7, 19, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(206, 1, 1, 7, 20, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(207, 1, 1, 7, 21, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(208, 1, 1, 7, 22, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(209, 1, 1, 7, 23, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(210, 1, 1, 7, 24, '2025-12-03 04:41:56', '2025-12-03 04:41:56'),
(218, 1, 2, 1, 1, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(219, 1, 2, 1, 2, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(220, 1, 2, 1, 3, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(221, 1, 2, 1, 4, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(222, 1, 2, 1, 5, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(223, 1, 2, 1, 6, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(224, 1, 2, 1, 7, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(225, 1, 2, 1, 8, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(226, 1, 2, 1, 9, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(227, 1, 2, 1, 10, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(228, 1, 2, 1, 11, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(229, 1, 2, 1, 12, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(230, 1, 2, 1, 13, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(231, 1, 2, 1, 14, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(232, 1, 2, 1, 15, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(233, 1, 2, 1, 16, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(234, 1, 2, 1, 17, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(235, 1, 2, 1, 18, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(236, 1, 2, 1, 19, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(237, 1, 2, 1, 20, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(238, 1, 2, 1, 21, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(239, 1, 2, 1, 22, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(240, 1, 2, 1, 23, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(241, 1, 2, 1, 24, '2025-12-03 04:43:06', '2025-12-03 04:43:06'),
(249, 2, 3, 8, 25, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(250, 2, 3, 8, 26, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(251, 2, 3, 8, 27, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(252, 2, 3, 8, 28, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(253, 2, 3, 8, 29, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(254, 2, 3, 8, 30, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(255, 2, 3, 8, 31, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(256, 2, 3, 8, 32, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(257, 2, 3, 8, 33, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(258, 2, 3, 8, 34, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(259, 2, 3, 8, 35, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(260, 2, 3, 8, 36, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(261, 2, 3, 8, 37, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(262, 2, 3, 8, 38, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(263, 2, 3, 8, 39, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(264, 2, 3, 8, 40, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(265, 2, 3, 8, 41, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(266, 2, 3, 8, 42, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(267, 2, 3, 8, 43, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(268, 2, 3, 8, 44, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(269, 2, 3, 8, 45, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(270, 2, 3, 8, 46, '2025-12-03 04:45:07', '2025-12-03 04:45:07'),
(280, 2, 4, 9, 1, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(281, 2, 4, 9, 2, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(282, 2, 4, 9, 3, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(283, 2, 4, 9, 4, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(284, 2, 4, 9, 5, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(285, 2, 4, 9, 6, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(286, 2, 4, 9, 7, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(287, 2, 4, 9, 8, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(288, 2, 4, 9, 9, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(289, 2, 4, 9, 10, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(290, 2, 4, 9, 11, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(291, 2, 4, 9, 12, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(292, 2, 4, 9, 13, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(293, 2, 4, 9, 14, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(294, 2, 4, 9, 15, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(295, 2, 4, 9, 16, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(296, 2, 4, 9, 17, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(297, 2, 4, 9, 18, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(298, 2, 4, 9, 19, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(299, 2, 4, 9, 20, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(300, 2, 4, 9, 21, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(301, 2, 4, 9, 22, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(302, 2, 4, 9, 23, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(303, 2, 4, 9, 24, '2025-12-03 04:47:34', '2025-12-03 04:47:34'),
(311, 2, 5, 10, 1, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(312, 2, 5, 10, 2, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(313, 2, 5, 10, 3, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(314, 2, 5, 10, 4, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(315, 2, 5, 10, 5, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(316, 2, 5, 10, 6, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(317, 2, 5, 10, 7, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(318, 2, 5, 10, 8, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(319, 2, 5, 10, 9, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(320, 2, 5, 10, 10, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(321, 2, 5, 10, 11, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(322, 2, 5, 10, 12, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(323, 2, 5, 10, 13, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(324, 2, 5, 10, 14, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(325, 2, 5, 10, 15, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(326, 2, 5, 10, 16, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(327, 2, 5, 10, 17, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(328, 2, 5, 10, 18, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(329, 2, 5, 10, 19, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(330, 2, 5, 10, 20, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(331, 2, 5, 10, 21, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(332, 2, 5, 10, 22, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(333, 2, 5, 10, 23, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(334, 2, 5, 10, 24, '2025-12-03 06:04:10', '2025-12-03 06:04:10'),
(342, 2, 5, 11, 1, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(343, 2, 5, 11, 2, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(344, 2, 5, 11, 3, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(345, 2, 5, 11, 4, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(346, 2, 5, 11, 5, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(347, 2, 5, 11, 6, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(348, 2, 5, 11, 7, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(349, 2, 5, 11, 8, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(350, 2, 5, 11, 9, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(351, 2, 5, 11, 10, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(352, 2, 5, 11, 11, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(353, 2, 5, 11, 12, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(354, 2, 5, 11, 13, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(355, 2, 5, 11, 14, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(356, 2, 5, 11, 15, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(357, 2, 5, 11, 16, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(358, 2, 5, 11, 17, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(359, 2, 5, 11, 18, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(360, 2, 5, 11, 19, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(361, 2, 5, 11, 20, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(362, 2, 5, 11, 21, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(363, 2, 5, 11, 22, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(364, 2, 5, 11, 23, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(365, 2, 5, 11, 24, '2025-12-03 06:05:50', '2025-12-03 06:05:50'),
(373, 3, 6, 12, 1, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(374, 3, 6, 12, 2, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(375, 3, 6, 12, 3, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(376, 3, 6, 12, 4, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(377, 3, 6, 12, 5, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(378, 3, 6, 12, 6, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(379, 3, 6, 12, 7, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(380, 3, 6, 12, 8, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(381, 3, 6, 12, 9, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(382, 3, 6, 12, 10, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(383, 3, 6, 12, 11, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(384, 3, 6, 12, 12, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(385, 3, 6, 12, 13, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(386, 3, 6, 12, 14, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(387, 3, 6, 12, 15, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(388, 3, 6, 12, 16, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(389, 3, 6, 12, 17, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(390, 3, 6, 12, 18, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(391, 3, 6, 12, 19, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(392, 3, 6, 12, 20, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(393, 3, 6, 12, 21, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(394, 3, 6, 12, 22, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(395, 3, 6, 12, 23, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(396, 3, 6, 12, 24, '2025-12-03 06:08:08', '2025-12-03 06:08:08'),
(404, 3, 7, 13, 1, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(405, 3, 7, 13, 2, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(406, 3, 7, 13, 3, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(407, 3, 7, 13, 4, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(408, 3, 7, 13, 5, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(409, 3, 7, 13, 6, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(410, 3, 7, 13, 7, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(411, 3, 7, 13, 8, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(412, 3, 7, 13, 9, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(413, 3, 7, 13, 10, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(414, 3, 7, 13, 11, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(415, 3, 7, 13, 12, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(416, 3, 7, 13, 13, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(417, 3, 7, 13, 14, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(418, 3, 7, 13, 15, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(419, 3, 7, 13, 16, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(420, 3, 7, 13, 17, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(421, 3, 7, 13, 18, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(422, 3, 7, 13, 19, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(423, 3, 7, 13, 20, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(424, 3, 7, 13, 21, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(425, 3, 7, 13, 22, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(426, 3, 7, 13, 23, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(427, 3, 7, 13, 24, '2025-12-03 06:10:12', '2025-12-03 06:10:12'),
(498, 4, 3, 17, 1, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(499, 4, 3, 17, 2, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(500, 4, 3, 17, 3, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(501, 4, 3, 17, 4, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(502, 4, 3, 17, 5, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(503, 4, 3, 17, 6, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(504, 4, 3, 17, 7, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(505, 4, 3, 17, 8, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(506, 4, 3, 17, 9, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(507, 4, 3, 17, 10, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(508, 4, 3, 17, 11, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(509, 4, 3, 17, 12, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(510, 4, 3, 17, 13, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(511, 4, 3, 17, 14, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(512, 4, 3, 17, 15, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(513, 4, 3, 17, 16, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(514, 4, 3, 17, 17, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(515, 4, 3, 17, 18, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(516, 4, 3, 17, 19, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(517, 4, 3, 17, 20, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(518, 4, 3, 17, 21, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(519, 4, 3, 17, 22, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(520, 4, 3, 17, 23, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(521, 4, 3, 17, 24, '2025-12-03 06:18:58', '2025-12-03 06:18:58'),
(529, 4, 8, 14, 1, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(530, 4, 8, 14, 2, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(531, 4, 8, 14, 3, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(532, 4, 8, 14, 4, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(533, 4, 8, 14, 5, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(534, 4, 8, 14, 6, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(535, 4, 8, 14, 7, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(536, 4, 8, 14, 8, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(537, 4, 8, 14, 9, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(538, 4, 8, 14, 10, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(539, 4, 8, 14, 11, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(540, 4, 8, 14, 12, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(541, 4, 8, 14, 13, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(542, 4, 8, 14, 14, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(543, 4, 8, 14, 15, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(544, 4, 8, 14, 16, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(545, 4, 8, 14, 17, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(546, 4, 8, 14, 18, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(547, 4, 8, 14, 19, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(548, 4, 8, 14, 20, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(549, 4, 8, 14, 21, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(550, 4, 8, 14, 22, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(551, 4, 8, 14, 23, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(552, 4, 8, 14, 24, '2025-12-03 06:22:54', '2025-12-03 06:22:54'),
(560, 4, 8, 15, 1, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(561, 4, 8, 15, 2, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(562, 4, 8, 15, 3, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(563, 4, 8, 15, 4, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(564, 4, 8, 15, 5, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(565, 4, 8, 15, 6, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(566, 4, 8, 15, 7, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(567, 4, 8, 15, 8, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(568, 4, 8, 15, 9, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(569, 4, 8, 15, 10, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(570, 4, 8, 15, 11, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(571, 4, 8, 15, 12, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(572, 4, 8, 15, 13, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(573, 4, 8, 15, 14, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(574, 4, 8, 15, 15, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(575, 4, 8, 15, 16, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(576, 4, 8, 15, 17, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(577, 4, 8, 15, 18, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(578, 4, 8, 15, 19, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(579, 4, 8, 15, 20, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(580, 4, 8, 15, 21, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(581, 4, 8, 15, 22, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(582, 4, 8, 15, 23, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(583, 4, 8, 15, 24, '2025-12-03 06:24:00', '2025-12-03 06:24:00'),
(591, 4, 8, 16, 1, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(592, 4, 8, 16, 2, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(593, 4, 8, 16, 3, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(594, 4, 8, 16, 4, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(595, 4, 8, 16, 5, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(596, 4, 8, 16, 6, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(597, 4, 8, 16, 7, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(598, 4, 8, 16, 8, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(599, 4, 8, 16, 9, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(600, 4, 8, 16, 10, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(601, 4, 8, 16, 11, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(602, 4, 8, 16, 12, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(603, 4, 8, 16, 13, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(604, 4, 8, 16, 14, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(605, 4, 8, 16, 15, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(606, 4, 8, 16, 16, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(607, 4, 8, 16, 17, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(608, 4, 8, 16, 18, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(609, 4, 8, 16, 19, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(610, 4, 8, 16, 20, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(611, 4, 8, 16, 21, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(612, 4, 8, 16, 22, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(613, 4, 8, 16, 23, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(614, 4, 8, 16, 24, '2025-12-03 06:25:02', '2025-12-03 06:25:02'),
(656, 4, 9, 18, 47, '2025-12-03 06:31:06', '2025-12-03 06:31:06'),
(657, 4, 9, 18, 48, '2025-12-03 06:31:06', '2025-12-03 06:31:06'),
(659, 4, 10, 19, 47, '2025-12-03 06:31:58', '2025-12-03 06:31:58'),
(660, 4, 10, 19, 48, '2025-12-03 06:31:58', '2025-12-03 06:31:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_09_22_205128_create_akuns_table copy', 1),
(2, '2025_09_22_205128_create_ikpa_target_table copy 3', 1),
(3, '2025_09_22_205303_create_uraians_table copy', 1),
(4, '2025_09_22_205338_create_rencana_kegiatans_table copy 4', 1),
(5, '2025_09_22_210707_create_sessions_table', 1),
(6, '2025_09_23_000001_create_realisasis_table copy 2', 1),
(7, '2025_09_27_075256_create_users_table copy', 1),
(8, '2025_10_01_080240_create_cache_table', 1),
(9, '2025_11_06_065832_create_activity_log_table', 1),
(10, '2025_11_06_065833_add_event_column_to_activity_log_table', 1),
(11, '2025_11_06_065834_add_batch_uuid_column_to_activity_log_table', 1),
(12, '2025_11_27_110000_create_kegiatans_table', 1),
(13, '2025_11_27_110100_create_outputs_table', 1),
(14, '2025_11_27_110200_create_kegiatan_output_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `outputs`
--

CREATE TABLE `outputs` (
  `id_output` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `outputs`
--

INSERT INTO `outputs` (`id_output`, `kode`, `created_at`, `updated_at`) VALUES
(1, 'DCF.001', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(2, 'SCF.002', '2025-12-02 21:25:30', '2025-12-02 21:25:30'),
(3, 'EBA.994', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(4, 'EBD.952', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(5, 'EBD.955', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(6, 'EBA.960', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(7, 'EBC.954', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(8, 'EBA.962', '2025-12-03 06:20:58', '2025-12-03 06:20:58'),
(9, 'EBB.951', '2025-12-03 06:20:58', '2025-12-03 06:20:58'),
(10, 'EBB.971', '2025-12-03 06:20:58', '2025-12-03 06:20:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `realisasis`
--

CREATE TABLE `realisasis` (
  `id_realisasi` bigint(20) UNSIGNED NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `komponen` varchar(255) DEFAULT NULL,
  `jenis_belanja` varchar(255) DEFAULT NULL,
  `unit_kerja` varchar(255) DEFAULT NULL,
  `output` varchar(255) NOT NULL,
  `akun_id` bigint(20) UNSIGNED NOT NULL,
  `uraian_id` bigint(20) UNSIGNED NOT NULL,
  `uraians` varchar(255) DEFAULT NULL,
  `target` bigint(20) NOT NULL DEFAULT 0,
  `jan` bigint(20) NOT NULL DEFAULT 0,
  `feb` bigint(20) NOT NULL DEFAULT 0,
  `mar` bigint(20) NOT NULL DEFAULT 0,
  `apr` bigint(20) NOT NULL DEFAULT 0,
  `mei` bigint(20) NOT NULL DEFAULT 0,
  `jun` bigint(20) NOT NULL DEFAULT 0,
  `jul` bigint(20) NOT NULL DEFAULT 0,
  `agt` bigint(20) NOT NULL DEFAULT 0,
  `sep` bigint(20) NOT NULL DEFAULT 0,
  `okt` bigint(20) NOT NULL DEFAULT 0,
  `nov` bigint(20) NOT NULL DEFAULT 0,
  `des` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `realisasis`
--

INSERT INTO `realisasis` (`id_realisasi`, `kegiatan`, `komponen`, `jenis_belanja`, `unit_kerja`, `output`, `akun_id`, `uraian_id`, `uraians`, `target`, `jan`, `feb`, `mar`, `apr`, `mei`, `jun`, `jul`, `agt`, `sep`, `okt`, `nov`, `des`, `created_at`, `updated_at`) VALUES
(1, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Biaya Penerimaan/Jamuan Tamu, City Tour, dll untuk Tamu/Organisasi International', 530000, 0, 0, 0, 530000, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 00:16:46', '2025-11-30 00:16:46'),
(2, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Jasa Laundry', 55800000, 0, 2648500, 0, 6065696, 2188000, 1837500, 0, 0, 0, 0, 0, 0, '2025-11-30 00:18:47', '2025-11-30 00:18:47'),
(4, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Keperluan sehari-hari klinik', 3502000, 0, 750500, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 00:28:40', '2025-11-30 00:28:40'),
(5, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Keperluan sehari-hari perkantoran', 98000000, 20000, 12291600, 783100, 7713115, 9963500, 7036230, 0, 0, 0, 0, 0, 0, '2025-11-30 00:37:25', '2025-11-30 00:37:25'),
(6, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Penghasilan PPNPN 52 (Pengamanan)', 90702000, 0, 90697450, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 00:38:41', '2025-11-30 00:38:41'),
(7, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Penghasilan PPNPN 52 (Pengemudi)', 15249000, 0, 15249000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 00:39:28', '2025-11-30 00:39:28'),
(8, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Linen Kantor', 9060000, 0, 0, 0, 0, 0, 9049000, 0, 0, 0, 0, 0, 0, '2025-11-30 00:48:35', '2025-11-30 00:48:35'),
(9, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Penghasilan PPNPN 52 (Pramubakti)', 129896000, 0, 129875000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 02:06:31', '2025-11-30 02:15:35'),
(10, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Penghasilan PPNPN 52 (Teknisi)', 10251000, 0, 10250250, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 02:07:33', '2025-11-30 02:07:33'),
(16, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 7, NULL, 42300000, 0, 900000, 0, 0, 0, 0, 850000, 0, 0, 0, 0, 0, '2025-11-30 02:31:44', '2025-11-30 02:32:16'),
(17, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 5, NULL, 368198000, 0, 31896000, 0, 0, 308652, 15780600, 51529200, 9631433, 2177690, 0, 0, 0, '2025-11-30 02:36:57', '2025-12-01 16:41:25'),
(18, '3377', '002', '52', 'Umum', 'EBA.994', 17, 2, NULL, 4350000, 0, 1538000, 0, 1087300, 212000, 204000, 0, 0, 0, 0, 0, 0, '2025-11-30 02:39:38', '2025-11-30 02:48:21'),
(19, '3377', '002', '52', 'Umum', 'EBA.994', 17, 3, 'Honorarium Bendahara', 9600000, 0, 800000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 02:40:47', '2025-11-30 02:40:47'),
(20, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 6, NULL, 187400000, 0, 18300000, 0, 12150000, 1800000, 9600000, 4800000, 0, 4500000, 0, 0, 0, '2025-11-30 02:45:02', '2025-11-30 23:37:35'),
(21, '3377', '002', '52', 'Umum', 'EBA.994', 17, 4, 'Keperluan Standar Pelayanan Publik', 123000000, 0, 0, 0, 4040000, 27052600, 69767400, 0, 0, 0, 0, 0, 0, '2025-11-30 02:53:55', '2025-11-30 02:53:55'),
(22, '3377', '002', '52', 'Umum', 'EBA.994', 17, 4, 'Pengangkutan Sampah', 20400000, 0, 150000, 0, 5150000, 1800000, 2000000, 0, 0, 0, 0, 0, 0, '2025-11-30 02:56:20', '2025-11-30 02:56:20'),
(23, '3377', '002', '52', 'Umum', 'EBA.994', 17, 4, 'Pengelolaan Limbah Medis', 4500000, 0, 0, 0, 0, 500000, 500000, 0, 0, 0, 0, 0, 0, '2025-11-30 02:57:09', '2025-11-30 02:57:09'),
(24, '3377', '002', '52', 'Umum', 'EBA.994', 17, 4, 'Uang Lembur', 2275000, 0, 2275000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 02:57:55', '2025-11-30 02:57:55'),
(25, '3377', '002', '52', 'Umum', 'EBA.994', 17, 4, 'Uang Makan Lembur', 1200000, 0, 1200000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 02:58:20', '2025-11-30 02:58:20'),
(26, '3377', '002', '52', 'Umum', 'EBA.994', 17, 7, 'Pencetakan Banner', 3000000, 0, 0, 0, 2776000, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 02:59:31', '2025-11-30 02:59:31'),
(27, '3377', '002', '52', 'Umum', 'EBA.994', 17, 8, 'Alat Rumah Tangga dan Bahan Kebersihan', 5030000, 0, 4695680, 0, 0, 330000, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 03:00:42', '2025-11-30 03:00:42'),
(28, '3377', '002', '52', 'Umum', 'EBA.994', 17, 8, 'Alat Tulis Kantor (ATK)', 48000000, 0, 0, 1274820, 0, 0, 32111770, 0, 0, 0, 0, 0, 0, '2025-11-30 03:01:50', '2025-11-30 03:01:50'),
(29, '3377', '002', '52', 'Umum', 'EBA.994', 17, 8, 'Amenities Asrama', 12000000, 0, 0, 0, 8077248, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 03:02:34', '2025-11-30 03:02:34'),
(30, '3377', '002', '52', 'Umum', 'EBA.994', 17, 8, 'Bahan Cetakan (+3jt-Juli)', 73459000, 0, 30364050, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 03:04:03', '2025-11-30 03:04:03'),
(31, '3377', '002', '52', 'Umum', 'EBA.994', 17, 9, 'Pengadaan Obat-obatan, bahan-bahan dan Persediaan Klinik', 41362000, 0, 0, 0, 0, 0, 0, 778894494, 0, 0, 0, 0, 0, '2025-11-30 03:05:37', '2025-11-30 03:05:37'),
(32, '3377', '002', '52', 'Umum', 'EBA.994', 17, 10, NULL, 1656000000, 123953370, 138722547, 132751502, 107059711, 121215050, 134912716, 0, 0, 0, 0, 0, 0, '2025-11-30 03:07:19', '2025-11-30 03:07:19'),
(33, '3377', '002', '52', 'Umum', 'EBA.994', 17, 11, NULL, 12000000, 546676, 1328199, 554835, 1454907, 965050, 931407, 0, 0, 0, 0, 0, 0, '2025-11-30 03:08:51', '2025-11-30 03:08:51'),
(34, '3377', '002', '52', 'Umum', 'EBA.994', 17, 12, NULL, 66000000, 6376000, 5430000, 5782000, 5441000, 2647000, 2581000, 0, 0, 0, 0, 0, 0, '2025-11-30 03:10:30', '2025-11-30 03:10:30'),
(35, '3377', '002', '52', 'Umum', 'EBA.994', 17, 13, 'Langganan Internet', 280355000, 0, 760300, 0, 69160800, 0, 760800, 0, 0, 0, 0, 0, 0, '2025-11-30 03:11:39', '2025-11-30 03:11:39'),
(36, '3377', '002', '52', 'Umum', 'EBA.994', 17, 13, 'Langganan Lisensi Software Manajemen Perkantoran', 45500000, 0, 2218500, 2347000, 32000000, 3818331, 30045, 0, 0, 0, 0, 0, 0, '2025-11-30 03:22:44', '2025-11-30 03:22:44'),
(37, '3377', '002', '52', 'Umum', 'EBA.994', 17, 13, 'Lisensi Aplikasi Video Conference', 18000000, 0, 2944412, 0, 0, 3054844, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 03:28:26', '2025-11-30 03:28:26'),
(38, '3377', '002', '52', 'Umum', 'EBA.994', 17, 15, 'Sewa Kendaraan Operasional Roda 4', 132000000, 130810824, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 03:31:01', '2025-11-30 03:31:01'),
(39, '3377', '002', '52', 'Umum', 'EBA.994', 17, 15, 'Sewa Mesin Fotocopy (Digital)', 10656000, 0, 888000, 888000, 888000, 888000, 888000, 0, 0, 0, 0, 0, 0, '2025-11-30 03:32:09', '2025-11-30 03:32:09'),
(40, '3377', '002', '52', 'Umum', 'EBA.994', 17, 15, 'Sewa Mesin Printer Warna', 108000000, 0, 9000000, 9000000, 9000000, 9000000, 9000000, 0, 0, 0, 0, 0, 0, '2025-11-30 03:33:38', '2025-11-30 03:33:38'),
(41, '3377', '002', '52', 'Umum', 'EBA.994', 17, 15, 'Sewa tenda, panggung, dan dekorasi', 4280000, 0, 0, 0, 0, 0, 4280000, 0, 0, 0, 0, 0, 0, '2025-11-30 03:34:43', '2025-11-30 03:34:43'),
(42, '3377', '002', '52', 'Umum', 'EBA.994', 17, 17, 'Jasa Desain (+)', 12000000, 5980000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 03:35:42', '2025-11-30 03:35:42'),
(43, '3377', '002', '52', 'Umum', 'EBA.994', 17, 17, 'Pengadaan Jasa Pengelolaan Gedung Pusdiklat APUPPT (Building Management)', 4945185000, 0, 0, 372204134, 695347983, 384081342, 384081342, 0, 0, 0, 0, 0, 0, '2025-11-30 03:37:27', '2025-11-30 03:37:27'),
(44, '3377', '002', '52', 'Umum', 'EBA.994', 17, 18, 'Halaman gedung/bangunan kantor (Gedung Ciloto)', 6300000, 0, 0, 0, 170000, 1706275, 83000, 0, 0, 0, 0, 0, 0, '2025-11-30 03:39:55', '2025-11-30 03:39:55'),
(45, '3377', '002', '52', 'Umum', 'EBA.994', 17, 18, 'Halaman gedung/bangunan kantor (Gedung Pusdiklat)', 66000000, 0, 2840200, 0, 656000, 4202600, 6776670, 0, 0, 0, 0, 0, 0, '2025-11-30 03:41:16', '2025-11-30 03:41:16'),
(46, '3377', '002', '52', 'Umum', 'EBA.994', 17, 18, 'Pemeliharaan gedung bertingkat (Gedung Ciloto)', 53000000, 0, 8071248, 0, 0, 0, 16075796, 0, 0, 0, 0, 0, 0, '2025-11-30 03:43:45', '2025-11-30 03:43:45'),
(47, '3377', '002', '52', 'Umum', 'EBA.994', 17, 18, 'Pemeliharaan gedung bertingkat (Gedung Pusdiklat)', 500676000, 0, 12702947, 17321597, 17493597, 72081183, 54890837, 0, 0, 0, 0, 0, 0, '2025-11-30 03:45:11', '2025-11-30 03:45:11'),
(48, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'AC Presisi', 64000000, 0, 0, 0, 0, 0, 32000000, 0, 0, 0, 0, 0, 0, '2025-11-30 03:46:11', '2025-11-30 03:46:11'),
(49, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Dehumidifier dan Filter Air Purifier', 48300000, 0, 0, 0, 0, 0, 48299985, 0, 0, 0, 0, 0, 0, '2025-11-30 03:47:55', '2025-11-30 03:47:55'),
(50, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Mekanikal Elektrik Lainnya', 371472000, 435000, 3107899, 17094000, 12921000, 1291000, 3826592, 0, 0, 0, 0, 0, 0, '2025-11-30 03:49:48', '2025-11-30 03:49:48'),
(51, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Pemeliharaan Elevator System', 80000000, 0, 0, 9768000, 0, 9768000, 2912700, 0, 0, 0, 0, 0, 0, '2025-11-30 03:51:41', '2025-11-30 03:51:41'),
(52, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Pemeliharaan kendaraan dinas Eselon II', 39175000, 0, 4045000, 0, 3656500, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 03:53:41', '2025-11-30 03:53:41'),
(53, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Pemeliharaan kendaraan operasional roda 4', 40000000, 0, 6201511, 0, 2400000, 4700000, 2770000, 0, 0, 0, 0, 0, 0, '2025-11-30 03:54:56', '2025-11-30 03:54:56'),
(54, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Sistem Tata Udara (Chiller, AHU, FCU, Dehumidifier dan Filter Air Purifier)', 432000000, 0, 12853000, 0, 0, 313455212, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 03:57:09', '2025-11-30 03:57:09'),
(55, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'STP dan pompa-pompa', 29915000, 0, 0, 2719500, 2719500, 2719500, 2719500, 0, 0, 0, 0, 0, 0, '2025-11-30 03:58:18', '2025-11-30 03:58:18'),
(56, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'UPS', 56000000, 0, 0, 0, 0, 28000000, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 04:00:16', '2025-11-30 04:00:16'),
(57, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Pemeliharaan dan operasional kendaraan operasional roda 2', 6000000, 0, 229950, 0, 500000, 624062, 274000, 0, 0, 0, 0, 0, 0, '2025-11-30 04:38:54', '2025-11-30 04:38:54'),
(58, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'AC Split', 52836000, 0, 0, 0, 0, 0, 0, 52836000, 0, 0, 0, 0, 0, '2025-11-30 07:22:44', '2025-11-30 07:22:44'),
(59, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Alat Kesehatan (Head lamp eye scope)', 1400000, 1275100, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 07:23:28', '2025-11-30 07:23:28'),
(60, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Alat Kesehatan (Kursi Roda)', 1600000, 1518525, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 07:24:23', '2025-11-30 07:24:23'),
(61, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Alat Kesehatan (Sterilisator)', 2350000, 0, 2327000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 07:25:10', '2025-11-30 07:25:10'),
(62, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Alat Kesehatan (Tensimeter)', 1400000, 1317475, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 07:25:58', '2025-11-30 07:25:58'),
(63, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'DVR CCTV Ciloto (sisa anggaran)', 4000000, 0, 3881200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 07:27:01', '2025-11-30 07:27:01'),
(64, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Mesin Absen', 48840000, 0, 0, 0, 0, 0, 48840000, 0, 0, 0, 0, 0, 0, '2025-11-30 07:27:53', '2025-11-30 07:27:53'),
(65, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Meubelair Ruang Kelas', 99000000, 0, 7836000, 0, 0, 67898700, 22627350, 0, 0, 0, 0, 0, 0, '2025-11-30 07:29:07', '2025-11-30 07:29:07'),
(66, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Vidiotron', 600001000, 0, 0, 0, 0, 0, 600000001, 0, 0, 0, 0, 0, 0, '2025-11-30 07:30:57', '2025-11-30 07:30:57'),
(67, '3377', '055', '52', 'Umum', 'EBA.962', 14, 16, NULL, 0, 0, 0, 0, 0, 0, 2098400, 0, 0, 0, 0, 0, 0, '2025-11-30 07:37:46', '2025-11-30 07:37:46'),
(68, '3377', '055', '52', 'Umum', 'EBA.962', 14, 21, NULL, 9530000, 0, 0, 0, 0, 530000, 1290000, 530000, 0, 0, 0, 0, 0, '2025-11-30 07:38:55', '2025-11-30 07:38:55'),
(69, '3377', '055', '52', 'Umum', 'EBA.962', 15, 21, NULL, 7540000, 0, 860000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 07:42:28', '2025-11-30 07:42:28'),
(70, '3377', '055', '52', 'Umum', 'EBA.962', 16, 5, NULL, 11360000, 0, 2763500, 0, 0, 2029500, 1359400, 3475100, 0, 0, 0, 0, 0, '2025-11-30 07:45:53', '2025-11-30 07:51:03'),
(71, '3377', '055', '52', 'Umum', 'EBA.962', 16, 21, NULL, 22660000, 0, 3310000, 0, 0, 2650000, 1060000, 0, 0, 0, 0, 0, 0, '2025-11-30 07:47:24', '2025-11-30 07:47:24'),
(72, '3376', '053', '52', 'Umum', 'EBA.960', 12, 5, NULL, 12515000, 0, 100000, 0, 0, 275000, 975000, 350000, 0, 0, 0, 0, 0, '2025-11-30 08:13:26', '2025-11-30 08:13:26'),
(73, '3376', '053', '52', 'Umum', 'EBA.960', 12, 16, NULL, 4000000, 0, 0, 0, 0, 0, 1500000, 0, 0, 0, 0, 0, 0, '2025-11-30 08:14:02', '2025-11-30 08:14:02'),
(74, '3376', '053', '52', 'Umum', 'EBA.960', 12, 21, NULL, 11610000, 0, 0, 0, 0, 4240000, 1590000, 0, 0, 0, 0, 0, 0, '2025-11-30 08:14:50', '2025-11-30 08:14:50'),
(75, '3376', '054', '52', 'Umum', 'EBC.954', 13, 5, NULL, 8198000, 0, 0, 0, 1973000, 1500400, 3978000, 0, 0, 0, 0, 0, 0, '2025-11-30 08:17:35', '2025-11-30 08:17:35'),
(76, '3376', '054', '52', 'Umum', 'EBC.954', 13, 21, NULL, 10860000, 0, 0, 0, 1060000, 0, 1060000, 0, 0, 0, 0, 0, 0, '2025-11-30 08:18:21', '2025-11-30 08:18:21'),
(77, '3375', '053', '52', 'Umum', 'EBD.955', 10, 21, NULL, 7310000, 0, 860000, 0, 0, 6890000, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 08:20:51', '2025-11-30 08:20:51'),
(78, '3375', '052', '52', 'Umum', 'EBD.952', 9, 21, NULL, 17560000, 0, 1920000, 0, 0, 0, 0, 1060000, 0, 0, 0, 0, 0, '2025-11-30 08:24:52', '2025-11-30 08:24:52'),
(79, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 5, NULL, 389816000, 0, 28875000, 0, 0, 0, 62793500, 92651200, 23400000, 226800, 0, 0, 0, '2025-11-30 08:29:34', '2025-11-30 08:29:34'),
(80, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 6, NULL, 180000000, 0, 1000000, 0, 10200000, 4200000, 21300000, 45750000, 17650000, 0, 0, 0, 0, '2025-11-30 08:31:21', '2025-11-30 08:31:21'),
(81, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 7, NULL, 17500000, 0, 0, 0, 950000, 0, 900000, 3375000, 0, 550000, 0, 0, 0, '2025-11-30 08:32:27', '2025-11-30 08:32:27'),
(82, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 8, NULL, 243870000, 0, 0, 0, 0, 2851000, 15062700, 0, 0, 7770000, 0, 0, 0, '2025-11-30 08:33:35', '2025-11-30 08:33:35'),
(83, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 16, NULL, 20400000, 0, 0, 0, 0, 0, 0, 0, 4500000, 0, 0, 0, 0, '2025-11-30 08:34:16', '2025-11-30 08:34:16'),
(84, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 17, NULL, 12000000, 0, 0, 0, 0, 0, 0, 733500, 437960, 106000, 0, 0, 0, '2025-11-30 08:35:11', '2025-11-30 08:35:11'),
(85, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 21, NULL, 594486000, 0, 18200000, 4837199, 2027400, 40283864, 59332423, 92265979, 38034843, 19145500, 0, 0, 0, '2025-11-30 08:37:08', '2025-11-30 08:37:08'),
(86, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 24, NULL, 822715000, 0, 0, 0, 0, 0, 0, 194587753, 182857880, 11388640, 0, 0, 0, '2025-11-30 08:38:41', '2025-11-30 08:38:41'),
(87, '3365', '053', '52', 'Sijitu', 'DCF.001', 7, 5, NULL, 17800000, 0, 1180000, 0, 0, 1710500, 1366000, 1866727, 0, 748617, 0, 0, 0, '2025-11-30 08:41:37', '2025-11-30 08:41:37'),
(88, '3365', '053', '52', 'Sijitu', 'DCF.001', 7, 8, NULL, 65920000, 0, 0, 0, 0, 10016640, 0, 9545500, 0, 5328000, 0, 0, 0, '2025-11-30 08:42:50', '2025-11-30 08:42:50'),
(89, '3365', '053', '52', 'Sijitu', 'DCF.001', 7, 16, NULL, 12200000, 0, 0, 0, 0, 5400000, 0, 0, 0, 2000000, 0, 0, 0, '2025-11-30 08:43:51', '2025-11-30 08:43:51'),
(90, '3365', '053', '52', 'Sijitu', 'DCF.001', 7, 21, NULL, 510000, 0, 0, 0, 0, 0, 6230000, 21607414, 5307500, 2120000, 0, 0, 0, '2025-11-30 08:45:29', '2025-11-30 08:45:29'),
(91, '3365', '053', '52', 'Sijitu', 'DCF.001', 6, 5, NULL, 62546000, 0, 0, 0, 1900000, 2037300, 0, 1900000, 3504000, 4965138, 0, 0, 0, '2025-11-30 08:48:17', '2025-11-30 08:48:17'),
(92, '3365', '053', '52', 'Sijitu', 'DCF.001', 6, 21, NULL, 162620000, 0, 0, 0, 860000, 5297780, 1378250, 11740978, 14886880, 14860367, 0, 0, 0, '2025-11-30 08:52:49', '2025-11-30 08:52:49'),
(93, '3365', '053', '52', 'Sijitu', 'DCF.001', 6, 23, NULL, 0, 0, 0, 0, 0, 0, 0, 680000, 1190000, 170000, 0, 0, 0, '2025-11-30 08:53:55', '2025-11-30 08:53:55'),
(94, '3365', '053', '52', 'Sijitu', 'DCF.001', 7, 22, NULL, 510000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 08:57:41', '2025-11-30 08:57:41'),
(95, '3365', '053', '52', 'Sijitu', 'DCF.001', 7, 23, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 08:58:27', '2025-11-30 08:58:27'),
(96, '3365', '053', '52', 'Sijitu', 'DCF.001', 5, 5, NULL, 5704000, 0, 0, 0, 0, 2739000, 1600000, 0, 0, 0, 0, 0, 0, '2025-11-30 09:00:35', '2025-11-30 09:00:35'),
(97, '3365', '053', '52', 'Sijitu', 'DCF.001', 5, 8, NULL, 24000000, 0, 0, 0, 0, 7825500, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 09:01:25', '2025-11-30 09:01:25'),
(98, '3365', '053', '52', 'Sijitu', 'DCF.001', 5, 16, NULL, 3000000, 0, 0, 0, 0, 3000000, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 09:02:01', '2025-11-30 09:02:01'),
(99, '3365', '053', '52', 'Sijitu', 'DCF.001', 5, 17, NULL, 63898000, 0, 0, 0, 0, 0, 0, 0, 0, 9900000, 0, 0, 0, '2025-11-30 09:02:32', '2025-11-30 09:02:32'),
(100, '3365', '053', '52', 'Sijitu', 'DCF.001', 5, 21, NULL, 6680000, 0, 0, 0, 0, 2440000, 0, 0, 530000, 0, 0, 0, 0, '2025-11-30 09:03:11', '2025-11-30 09:03:11'),
(101, '3365', '053', '52', 'Renbang', 'DCF.001', 4, 5, NULL, 12045000, 0, 0, 0, 1208500, 1323000, 1394000, 0, 3347300, 2687643, 0, 0, 0, '2025-11-30 09:06:23', '2025-11-30 09:06:23'),
(102, '3365', '053', '52', 'Renbang', 'DCF.001', 4, 16, NULL, 6300000, 0, 0, 0, 0, 0, 1800000, 0, 0, 4100000, 0, 0, 0, '2025-11-30 09:07:28', '2025-11-30 09:07:28'),
(103, '3365', '053', '52', 'Renbang', 'DCF.001', 4, 21, NULL, 34330000, 0, 0, 0, 2650000, 7984631, 2850500, 1769500, 2254000, 7219795, 0, 0, 0, '2025-11-30 09:08:48', '2025-11-30 09:08:48'),
(104, '3365', '053', '52', 'Renbang', 'DCF.001', 3, 5, NULL, 42090000, 0, 2727000, 0, 0, 2553800, 2180293, 6938435, 2169500, 1575090, 0, 0, 0, '2025-11-30 09:11:47', '2025-11-30 09:11:47'),
(105, '3365', '053', '52', 'Renbang', 'DCF.001', 3, 16, NULL, 9900000, 0, 0, 0, 0, 0, 4300000, 0, 0, 0, 0, 0, 0, '2025-11-30 09:12:34', '2025-11-30 09:12:34'),
(106, '3365', '053', '52', 'Renbang', 'DCF.001', 3, 21, NULL, 146010000, 0, 0, 0, 0, 8015058, 6370650, 12170042, 6617873, 5597082, 0, 0, 0, '2025-11-30 09:13:58', '2025-11-30 09:13:58'),
(107, '3365', '053', '52', 'Penyedik', 'DCF.001', 2, 5, NULL, 38988000, 0, 1225300, 0, 0, 2072500, 0, 2627500, 1100500, 1366700, 0, 0, 0, '2025-11-30 09:17:06', '2025-11-30 09:17:06'),
(108, '3365', '053', '52', 'Penyedik', 'DCF.001', 2, 8, NULL, 30000000, 0, 0, 0, 0, 0, 0, 27972000, 0, 0, 0, 0, 0, '2025-11-30 09:18:05', '2025-11-30 09:18:05'),
(109, '3365', '053', '52', 'Penyedik', 'DCF.001', 2, 16, NULL, 81600000, 0, 1800000, 0, 0, 0, 0, 0, 5000000, 0, 0, 0, 0, '2025-11-30 09:18:57', '2025-11-30 09:18:57'),
(110, '3365', '053', '52', 'Penyedik', 'DCF.001', 2, 21, NULL, 91462000, 0, 0, 0, 0, 1060000, 2450000, 11690000, 10137500, 6406750, 0, 0, 0, '2025-11-30 09:20:45', '2025-11-30 09:20:45'),
(111, '3365', '053', '52', 'Penyedik', 'DCF.001', 2, 22, NULL, 510000, 0, 0, 0, 0, 0, 0, 510000, 0, 0, 0, 0, 0, '2025-11-30 09:21:17', '2025-11-30 09:21:17'),
(112, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 22, NULL, 850000, 0, 0, 0, 0, 0, 0, 340000, 0, 0, 0, 0, 0, '2025-11-30 09:23:29', '2025-11-30 09:23:29'),
(113, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 21, NULL, 563355000, 0, 26355485, 0, 9361451, 8546076, 25610000, 25114578, 10019406, 0, 0, 0, 0, '2025-11-30 09:24:56', '2025-11-30 09:24:56'),
(114, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 17, NULL, 1200000, 0, 0, 0, 0, 18000, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 09:25:34', '2025-11-30 09:25:34'),
(115, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 14, NULL, 208312000, 0, 0, 0, 0, 0, 0, 21090000, 12210000, 0, 0, 0, 0, '2025-11-30 09:26:31', '2025-11-30 09:26:31'),
(116, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 8, NULL, 240300000, 0, 0, 0, 1492200, 0, 127372500, 39733360, 0, 0, 0, 0, 0, '2025-11-30 09:27:41', '2025-11-30 09:27:41'),
(140, '3375', '001', '51', 'Umum', 'EBA.994', 8, 25, 'Pembayaran Gaji Induk PNS', 1894683789, 153208561, 153492907, 153642367, 0, 0, 0, 161449652, 0, 0, 0, 0, 0, '2025-12-04 02:44:46', '2025-12-04 02:46:32'),
(141, '3375', '001', '51', 'Umum', 'EBA.994', 8, 25, 'Kekurangan Gaji DP', 345175, 0, 345175, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-04 02:47:27', '2025-12-04 02:47:27'),
(142, '3375', '001', '51', 'Umum', 'EBA.994', 8, 25, 'Pembayaran Gaji THR PNS', 164903105, 0, 0, 164903105, 1234760631, 1245274657, 2638146606, 0, 0, 0, 0, 0, 0, '2025-12-04 02:51:07', '2025-12-04 02:51:07'),
(143, '3375', '001', '51', 'Umum', 'EBA.994', 8, 35, 'Pembayaran Gaji PPPK', 771882696, 58380700, 58380700, 58380700, 0, 0, 0, 58891100, 0, 0, 0, 0, 0, '2025-12-04 02:53:14', '2025-12-04 02:53:14'),
(144, '3375', '001', '51', 'Umum', 'EBA.994', 8, 35, 'Pembayaran Gaji THR PPPK', 58380700, 0, 0, 58380700, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-04 02:54:11', '2025-12-04 02:54:11'),
(145, '3375', '001', '51', 'Umum', 'EBA.994', 8, 45, 'Pembayaran Tunsus PNS', 8890495426, 719226646, 718082770, 720480852, 0, 0, 0, 764429195, 0, 0, 0, 0, 0, '2025-12-04 02:56:39', '2025-12-04 02:56:39'),
(146, '3375', '001', '51', 'Umum', 'EBA.994', 8, 45, 'Kekurangan Pembayaran Tunsus PNS Des 2024 (38%)', 297843330, 297843330, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-04 02:58:07', '2025-12-04 02:58:07'),
(147, '3375', '001', '51', 'Umum', 'EBA.994', 8, 45, 'Pembayaran Tunsus THR PNS', 841715073, 0, 0, 841715073, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-04 02:59:11', '2025-12-04 02:59:11'),
(148, '3375', '001', '51', 'Umum', 'EBA.994', 8, 46, 'Pembayaran Tunsus PPPK', 2481583325, 194460635, 194327120, 194964400, 0, 0, 0, 195132485, 0, 0, 0, 0, 0, '2025-12-04 03:01:16', '2025-12-04 03:01:16'),
(149, '3375', '001', '51', 'Umum', 'EBA.994', 8, 46, 'Kekurangan Pembayaran Tunsus PPPK Des 2024 (38%)', 73922863, 73922863, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-04 03:08:03', '2025-12-04 03:08:03'),
(150, '3375', '001', '51', 'Umum', 'EBA.994', 8, 46, 'Pembayaran Tunsus THR PPPK', 214750051, 0, 0, 214750051, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-04 03:10:19', '2025-12-04 03:10:19'),
(151, '3375', '001', '51', 'Umum', 'EBA.994', 8, 42, 'Penghasilan PPNPN 51', 340099650, 0, 37585975, 37734750, 0, 0, 0, 37815900, 0, 0, 0, 0, 0, '2025-12-04 03:13:16', '2025-12-04 03:13:16'),
(152, '3375', '001', '51', 'Umum', 'EBA.994', 8, 42, 'Penghasilan THR PPNPN 51', 34353900, 0, 0, 34353900, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-04 03:14:11', '2025-12-04 03:14:11'),
(153, '3375', '001', '51', 'Umum', 'EBA.994', 8, 43, 'ULembur PNS', 9328000, 0, 434000, 755000, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-04 03:15:36', '2025-12-04 03:15:36'),
(154, '3375', '001', '51', 'Umum', 'EBA.994', 8, 44, 'ULembur PPPK', 3151000, 0, 0, 1010000, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-04 03:16:29', '2025-12-04 03:16:29'),
(155, '3375', '001', '51', 'Umum', 'EBA.994', 8, 41, 'UMakan PPPK', 132021000, 0, 8882000, 9622000, 0, 0, 0, 7852000, 0, 0, 0, 0, 0, '2025-12-04 03:18:20', '2025-12-04 03:18:20'),
(156, '3375', '001', '51', 'Umum', 'EBA.994', 8, 33, 'UMakan PNS', 285078000, 0, 22431000, 25033000, 0, 0, 0, 18474000, 0, 0, 0, 0, 0, '2025-12-04 03:20:04', '2025-12-04 03:20:04'),
(157, '3375', '001', '51', 'Umum', 'EBA.994', 8, 43, 'ULembur PPPNPN', 1559000, 0, 0, 0, 0, 0, 0, 2847000, 0, 0, 0, 0, 0, '2025-12-04 03:32:31', '2025-12-04 03:32:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rencana_kegiatans`
--

CREATE TABLE `rencana_kegiatans` (
  `id_rencana` bigint(20) UNSIGNED NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `komponen` varchar(255) DEFAULT NULL,
  `jenis_belanja` varchar(255) DEFAULT NULL,
  `unit_kerja` varchar(255) DEFAULT NULL,
  `output` varchar(255) NOT NULL,
  `akun_id` bigint(20) UNSIGNED NOT NULL,
  `uraian_id` bigint(20) UNSIGNED NOT NULL,
  `uraians` varchar(255) DEFAULT NULL,
  `target` bigint(20) NOT NULL DEFAULT 0,
  `jan` bigint(20) NOT NULL DEFAULT 0,
  `feb` bigint(20) NOT NULL DEFAULT 0,
  `mar` bigint(20) NOT NULL DEFAULT 0,
  `apr` bigint(20) NOT NULL DEFAULT 0,
  `mei` bigint(20) NOT NULL DEFAULT 0,
  `jun` bigint(20) NOT NULL DEFAULT 0,
  `jul` bigint(20) NOT NULL DEFAULT 0,
  `agt` bigint(20) NOT NULL DEFAULT 0,
  `sep` bigint(20) NOT NULL DEFAULT 0,
  `okt` bigint(20) NOT NULL DEFAULT 0,
  `nov` bigint(20) NOT NULL DEFAULT 0,
  `des` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rencana_kegiatans`
--

INSERT INTO `rencana_kegiatans` (`id_rencana`, `kegiatan`, `komponen`, `jenis_belanja`, `unit_kerja`, `output`, `akun_id`, `uraian_id`, `uraians`, `target`, `jan`, `feb`, `mar`, `apr`, `mei`, `jun`, `jul`, `agt`, `sep`, `okt`, `nov`, `des`, `created_at`, `updated_at`) VALUES
(1, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 5, '-', 368198000, 0, 31896000, 0, 0, 308652, 15780600, 51529200, 9631433, 2177690, 0, 63338915, 131661500, '2025-10-18 23:37:16', '2025-12-01 16:37:17'),
(2, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 6, NULL, 187400000, 0, 18300000, 0, 12150000, 1800000, 9600000, 4800000, 0, 4500000, 24000000, 46500000, 37250000, '2025-10-18 23:37:16', '2025-11-30 02:34:46'),
(3, '3365', '053', '52', 'Penyedik', 'DCF.001', 2, 5, NULL, 38988000, 0, 1225300, 0, 0, 2072500, 0, 2627500, 1100500, 1366700, 11947500, 9324000, 9324000, '2025-10-18 23:46:02', '2025-10-20 12:59:59'),
(4, '3365', '053', '52', 'Renbang', 'DCF.001', 3, 5, NULL, 42090000, 0, 2727000, 0, 0, 2553800, 2180293, 6938435, 2169500, 1575090, 4691174, 4090817, 0, '2025-10-18 23:46:28', '2025-10-20 15:10:31'),
(5, '3365', '053', '52', 'Renbang', 'DCF.001', 4, 5, NULL, 12045000, 0, 0, 0, 1208500, 1323000, 1394000, 0, 3347300, 2687643, 0, 0, 0, '2025-10-18 23:47:00', '2025-10-20 15:34:09'),
(6, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 7, NULL, 42300000, 0, 900000, 0, 0, 0, 0, 850000, 0, 0, 31250000, 6000000, 28300000, '2025-10-18 23:48:01', '2025-10-20 12:48:51'),
(7, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 14, NULL, 208312000, 0, 0, 0, 0, 0, 0, 21090000, 12210000, 0, 0, 175012000, 0, '2025-10-18 23:53:46', '2025-10-20 12:50:13'),
(8, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 17, NULL, 1200000, 0, 0, 0, 0, 18000, 0, 0, 0, 0, 0, 0, 1182000, '2025-10-20 12:51:50', '2025-10-20 12:51:50'),
(9, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 21, '-', 563355000, 0, 26355485, 0, 9361451, 8546076, 25610000, 25114578, 10019406, 0, 56350000, 76464924, 283478105, '2025-10-20 12:55:25', '2025-11-30 09:22:05'),
(10, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 22, '-', 850000, 0, 0, 0, 0, 0, 0, 340000, 0, 0, 510000, 0, 0, '2025-10-20 12:57:32', '2025-11-30 09:22:34'),
(11, '3365', '053', '52', 'Sijitu', 'DCF.001', 5, 5, NULL, 5704000, 0, 0, 0, 0, 2739000, 1600000, 0, 0, 0, 1365000, 0, 0, '2025-10-20 13:00:52', '2025-10-20 15:26:50'),
(12, '3365', '053', '52', 'Sijitu', 'DCF.001', 6, 5, NULL, 62546000, 0, 0, 0, 1900000, 2037300, 0, 1900000, 3504000, 4965138, 6080000, 9120000, 33039562, '2025-10-20 13:01:42', '2025-10-20 16:09:52'),
(13, '3365', '053', '52', 'Sijitu', 'DCF.001', 7, 5, NULL, 17800000, 0, 1180000, 0, 0, 1710500, 1366000, 1866727, 0, 748617, 0, 810000, 10118156, '2025-10-20 13:02:29', '2025-10-20 16:26:15'),
(14, '3365', '053', '52', 'Penyedik', 'DCF.001', 2, 8, NULL, 30000000, 0, 0, 0, 0, 0, 0, 27972000, 0, 0, 2028000, 0, 0, '2025-10-20 13:04:54', '2025-10-20 13:04:54'),
(15, '3365', '053', '52', 'Penyedik', 'DCF.001', 2, 16, NULL, 81600000, 0, 1800000, 0, 0, 0, 0, 0, 5000000, 0, 5000000, 64800000, 0, '2025-10-20 13:08:29', '2025-10-20 13:08:29'),
(16, '3365', '053', '52', 'Penyedik', 'DCF.001', 2, 21, '-', 91462000, 0, 0, 0, 0, 1060000, 2450000, 11690000, 10137500, 6406750, 29572625, 30145125, 0, '2025-10-20 13:12:14', '2025-11-30 09:15:13'),
(17, '3365', '053', '52', 'Penyedik', 'DCF.001', 2, 22, '-', 510000, 0, 0, 0, 0, 0, 0, 510000, 0, 0, 0, 0, 510000, '2025-10-20 13:14:37', '2025-11-30 09:15:33'),
(18, '3365', '053', '52', 'Renbang', 'DCF.001', 3, 21, '-', 146010000, 0, 0, 0, 0, 8015058, 6370650, 12170042, 6617873, 5597082, 11550000, 15810000, 51777817, '2025-10-20 15:11:11', '2025-11-30 09:09:53'),
(19, '3365', '053', '52', 'Sijitu', 'DCF.001', 3, 8, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-10-20 15:11:54', '2025-10-20 15:11:54'),
(20, '3365', '053', '52', 'Renbang', 'DCF.001', 3, 16, NULL, 9900000, 0, 0, 0, 0, 0, 4300000, 0, 0, 0, 2500000, 0, 600000, '2025-10-20 15:14:57', '2025-10-20 15:16:55'),
(21, '3365', '053', '52', 'Renbang', 'DCF.001', 3, 17, NULL, 279473000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 49860000, 0, 151113000, '2025-10-20 15:15:38', '2025-10-20 15:17:55'),
(22, '3365', '053', '52', 'Renbang', 'DCF.001', 4, 21, '-', 34330000, 0, 0, 0, 2650000, 7984631, 2850500, 1769500, 2254000, 7219795, 0, 7870000, 0, '2025-10-20 15:20:14', '2025-11-30 09:04:28'),
(23, '3365', '053', '52', 'Renbang', 'DCF.001', 4, 8, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-10-20 15:21:18', '2025-10-20 15:21:18'),
(24, '3365', '053', '52', 'Renbang', 'DCF.001', 4, 16, NULL, 6300000, 0, 0, 0, 0, 0, 1800000, 0, 0, 4100000, 0, 0, 400000, '2025-10-20 15:21:59', '2025-10-20 15:25:22'),
(25, '3365', '053', '52', 'Sijitu', 'DCF.001', 5, 8, NULL, 24000000, 0, 0, 0, 0, 7825500, 0, 0, 0, 0, 0, 16174500, 0, '2025-10-20 15:27:43', '2025-10-20 15:29:19'),
(26, '3365', '053', '52', 'Sijitu', 'DCF.001', 5, 15, NULL, 25000000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-10-20 15:28:18', '2025-10-20 15:30:02'),
(27, '3365', '053', '52', 'Penyedik', 'DCF.001', 1, 8, NULL, 240300000, 0, 0, 0, 1492200, 0, 127372500, 39733360, 0, 0, 25974900, 42600170, 3127500, '2025-10-20 15:37:41', '2025-10-20 15:37:41'),
(28, '3365', '053', '52', 'Sijitu', 'DCF.001', 5, 6, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-10-20 15:56:36', '2025-10-20 15:56:36'),
(29, '3365', '053', '52', 'Sijitu', 'DCF.001', 5, 17, NULL, 63898000, 0, 0, 0, 0, 0, 0, 0, 0, 9900000, 10000000, 10000000, 33998000, '2025-10-20 15:58:26', '2025-10-20 16:03:46'),
(30, '3365', '053', '52', 'Sijitu', 'DCF.001', 5, 21, '-', 6680000, 0, 0, 0, 0, 2440000, 0, 0, 530000, 0, 1590000, 1590000, 530000, '2025-10-20 15:59:08', '2025-11-30 08:59:10'),
(31, '3365', '053', '52', 'Sijitu', 'DCF.001', 5, 16, NULL, 3000000, 0, 0, 0, 0, 3000000, 0, 0, 0, 0, 0, 0, 0, '2025-10-20 16:00:43', '2025-10-20 16:02:35'),
(32, '3365', '053', '52', 'Sijitu', 'DCF.001', 6, 6, NULL, 400000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 400000, '2025-10-20 16:10:43', '2025-10-20 16:17:31'),
(33, '3365', '053', '52', 'Sijitu', 'DCF.001', 6, 21, '-', 162620000, 0, 0, 0, 860000, 5297780, 1378250, 11740978, 14886880, 14860367, 15600000, 43670000, 50434745, '2025-10-20 16:11:57', '2025-11-30 08:46:45'),
(34, '3365', '053', '52', 'Sijitu', 'DCF.001', 6, 16, NULL, 13900000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5100000, 8800000, '2025-10-20 16:12:49', '2025-10-20 16:18:41'),
(35, '3365', '053', '52', 'Sijitu', 'DCF.001', 6, 17, NULL, 75000000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 75000000, 0, '2025-10-20 16:13:33', '2025-10-20 16:19:29'),
(37, '3365', '053', '52', 'Sijitu', 'DCF.001', 6, 22, '-', 2890000, 0, 0, 0, 0, 0, 0, 680000, 1190000, 170000, 850000, 0, 0, '2025-10-20 16:15:39', '2025-11-30 08:49:44'),
(39, '3365', '053', '52', 'Sijitu', 'DCF.001', 7, 8, NULL, 65920000, 0, 0, 0, 0, 10016640, 0, 9545500, 0, 5328000, 0, 40903360, 126500, '2025-10-20 16:27:22', '2025-10-20 16:30:55'),
(40, '3365', '053', '52', 'Sijitu', 'DCF.001', 7, 16, NULL, 12200000, 0, 0, 0, 0, 5400000, 0, 0, 0, 2000000, 0, 0, 4800000, '2025-10-20 16:28:03', '2025-10-20 16:32:08'),
(41, '3365', '053', '52', 'Sijitu', 'DCF.001', 7, 21, '-', 110035000, 0, 0, 0, 0, 0, 6230000, 21607414, 5307500, 2120000, 550000, 46722642, 26637444, '2025-10-20 16:28:43', '2025-11-30 08:40:13'),
(42, '3365', '053', '52', 'Sijitu', 'DCF.001', 7, 23, '-', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-10-20 16:29:29', '2025-11-30 08:56:55'),
(43, '3365', '053', '52', 'Sijitu', 'DCF.001', 6, 8, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 30000000, 0, 0, 0, '2025-10-20 16:45:44', '2025-10-20 16:45:44'),
(44, '3365', '053', '52', 'Sijitu', 'DCF.001', 7, 22, '-', 510000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 510000, '2025-10-20 16:52:34', '2025-11-30 08:55:51'),
(45, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 5, NULL, 389816000, 0, 28875000, 0, 0, 0, 62793500, 92651200, 23400000, 226800, 0, 54708700, 97577800, '2025-10-20 16:55:33', '2025-10-20 16:55:33'),
(46, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 6, NULL, 180000000, 0, 1000000, 0, 10200000, 4200000, 21300000, 45750000, 17650000, 0, 24000000, 21600000, 31330000, '2025-10-20 16:56:37', '2025-10-20 17:04:06'),
(47, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 7, NULL, 17500000, 0, 0, 0, 950000, 0, 900000, 3375000, 0, 550000, 3000000, 4125000, 2350000, '2025-10-20 16:57:06', '2025-10-20 17:07:55'),
(48, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 8, NULL, 243870000, 0, 0, 0, 0, 2851000, 15062700, 0, 0, 7770000, 13090000, 11616300, 0, '2025-10-20 16:57:48', '2025-10-20 17:09:25'),
(49, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 16, NULL, 20400000, 0, 0, 0, 0, 0, 0, 0, 4500000, 0, 0, 0, 15900000, '2025-10-20 16:58:19', '2025-10-20 17:10:26'),
(50, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 17, NULL, 12000000, 0, 0, 0, 0, 0, 0, 733500, 437960, 106000, 0, 0, 10722540, '2025-10-20 17:05:00', '2025-10-20 17:11:30'),
(51, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 21, '-', 594486000, 0, 18200000, 4837199, 2027400, 40283864, 59332423, 92265979, 38034843, 19145500, 48000000, 175544000, 73770547, '2025-10-20 17:05:28', '2025-11-30 08:27:51'),
(52, '3365', '053', '52', 'Penyedik', 'SCF.002', 1, 24, '-', 822715000, 0, 0, 0, 0, 0, 0, 194587753, 182857880, 11388640, 0, 0, 426711000, '2025-10-20 17:06:01', '2025-11-30 08:37:47'),
(53, '3365', '053', '52', 'Sijitu', 'DCF.001', 6, 23, '-', 0, 0, 0, 0, 0, 0, 0, 0, 0, 170000, 0, 0, 0, '2025-10-21 17:13:33', '2025-11-30 08:50:52'),
(54, '3375', '001', '51', 'Umum', 'EBA.994', 8, 25, 'Pembayaran Gaji Induk PNS', 1894683789, 153208561, 153492907, 153642367, 159252761, 162840289, 164488020, 161449652, 164977685, 168227685, 150867954, 150867954, 151367954, '2025-10-21 17:21:55', '2025-12-04 06:19:16'),
(55, '3375', '052', '52', 'Umum', 'EBD.952', 9, 5, NULL, 2590000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2590000, '2025-10-21 17:29:05', '2025-10-21 17:29:05'),
(56, '3375', '053', '52', 'Umum', 'EBD.955', 10, 5, NULL, 3224000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3224000, '2025-10-21 18:40:48', '2025-10-21 18:48:36'),
(57, '3375', '052', '52', 'Umum', 'EBD.952', 9, 21, '-', 17560000, 0, 1920000, 0, 0, 6890000, 0, 1060000, 1060000, 1590000, 1060000, 1060000, 2920000, '2025-10-21 18:44:24', '2025-11-30 08:22:14'),
(58, '3375', '053', '52', 'Umum', 'EBD.955', 10, 16, NULL, 3800000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3800000, '2025-10-21 18:50:27', '2025-10-21 18:50:27'),
(59, '3375', '053', '52', 'Umum', 'EBD.955', 10, 21, '-', 7310000, 0, 860000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6450000, '2025-10-21 18:51:55', '2025-11-30 08:19:43'),
(60, '3375', '053', '52', 'Umum', 'EBD.955', 11, 5, NULL, 1136000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1136000, '2025-10-21 18:54:06', '2025-10-21 18:54:06'),
(61, '3375', '053', '52', 'Umum', 'EBD.955', 11, 21, '-', 5580000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5580000, '2025-10-21 18:55:15', '2025-11-30 08:23:19'),
(62, '3376', '053', '52', 'Umum', 'EBA.960', 12, 5, NULL, 12515000, 0, 100000, 0, 0, 275000, 975000, 1525800, 0, 0, 0, 0, 9639200, '2025-10-21 19:00:42', '2025-10-21 19:00:42'),
(63, '3376', '053', '52', 'Umum', 'EBA.960', 12, 16, NULL, 4000000, 0, 0, 0, 0, 0, 1500000, 0, 0, 0, 0, 0, 2500000, '2025-10-21 19:02:42', '2025-10-21 19:02:42'),
(64, '3376', '053', '52', 'Umum', 'EBA.960', 12, 21, '-', 11610000, 0, 0, 0, 0, 4240000, 1590000, 0, 0, 0, 0, 0, 5780000, '2025-10-21 19:04:16', '2025-11-30 08:11:44'),
(65, '3376', '054', '52', 'Umum', 'EBC.954', 13, 5, NULL, 8198000, 0, 0, 0, 1097385, 1500400, 3978000, 146000, 2920500, 2864400, 0, 0, -4308685, '2025-10-21 19:12:28', '2025-10-21 19:12:28'),
(66, '3376', '054', '52', 'Umum', 'EBC.954', 13, 16, NULL, 3600000, 0, 0, 0, 481896, 0, 0, 0, 0, 2500000, 0, 0, 618104, '2025-10-21 19:14:35', '2025-10-21 19:14:35'),
(67, '3376', '054', '52', 'Umum', 'EBC.954', 13, 21, '-', 10860000, 0, 0, 0, 1453719, 0, 1060000, 0, 0, 530000, 530000, 530000, 6756281, '2025-10-21 19:16:27', '2025-11-30 08:16:00'),
(68, '3377', '055', '52', 'Umum', 'EBA.962', 14, 5, NULL, 2130000, 0, 0, 0, 0, 0, 2098400, 0, 0, 0, 0, 0, 31600, '2025-10-21 19:23:27', '2025-10-21 19:23:27'),
(69, '3377', '055', '52', 'Umum', 'EBA.962', 14, 21, '-', 9530000, 0, 0, 0, 0, 530000, 1290000, 530000, 0, 0, 0, 0, 7180000, '2025-10-21 19:25:15', '2025-11-30 07:34:56'),
(70, '3377', '055', '52', 'Umum', 'EBA.962', 14, 22, '-', 1195000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1195000, '2025-10-21 19:26:18', '2025-11-30 07:35:29'),
(71, '3377', '055', '52', 'Umum', 'EBA.962', 15, 5, NULL, 1034000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1034000, '2025-10-21 19:29:22', '2025-10-21 19:29:22'),
(72, '3377', '055', '52', 'Umum', 'EBA.962', 15, 16, NULL, 200000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 200000, '2025-10-21 19:30:29', '2025-10-21 19:30:29'),
(73, '3377', '055', '52', 'Umum', 'EBA.962', 15, 21, '-', 7540000, 0, 860000, 0, 0, 0, 0, 0, 0, 0, 430000, 430000, 5820000, '2025-10-21 19:32:11', '2025-11-30 07:41:10'),
(74, '3377', '055', '52', 'Umum', 'EBA.962', 15, 22, '-', 145000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 145000, '2025-10-21 19:33:44', '2025-11-30 07:41:31'),
(75, '3377', '055', '52', 'Umum', 'EBA.962', 16, 5, NULL, 11360000, 0, 2763500, 0, 0, 2029500, 1359400, 3475100, 1537400, 500000, 500000, 500000, -1304900, '2025-10-21 19:38:53', '2025-10-21 19:38:53'),
(76, '3377', '055', '52', 'Umum', 'EBA.962', 16, 16, NULL, 3850000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3850000, '2025-10-21 19:40:49', '2025-10-21 19:40:49'),
(77, '3377', '055', '52', 'Umum', 'EBA.962', 16, 21, '-', 22660000, 0, 3310000, 0, 0, 2650000, 1060000, 430000, 0, 860000, 1060000, 0, 13290000, '2025-10-21 19:42:59', '2025-11-30 07:44:16'),
(78, '3377', '055', '52', 'Umum', 'EBA.962', 16, 22, '-', 160000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 160000, '2025-10-21 19:44:15', '2025-11-30 07:44:44'),
(79, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Teknisi', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-10-21 19:49:42', '2025-12-02 04:48:19'),
(80, '3377', '002', '52', 'Umum', 'EBA.994', 17, 9, 'Pengadaan Obat-obatan, bahan-bahan dan Persediaan Klinik', 41362000, 0, 0, 0, 0, 0, 0, 35478930, 0, 0, 0, 0, 2362000, '2025-10-21 19:52:15', '2025-12-02 04:48:42'),
(81, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Alat Kesehatan (Kursi Roda)', 1600000, 1518525, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 81475, '2025-10-21 19:56:59', '2025-11-30 04:47:04'),
(82, '3377', '052', '53', 'Umum', 'EBB.971', 19, 48, 'Renovasi Ruang Kelas', 200000000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 200000000, 0, '2025-10-21 19:56:59', '2025-11-30 05:14:11'),
(83, '3377', '055', '52', 'Umum', 'EBA.962', 14, 16, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-10-21 23:41:51', '2025-10-21 23:41:51'),
(85, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Keperluan sehari-hari klinik', 3502000, 0, 750500, 0, 0, 0, 0, 225850, 0, 200000, 200000, 200000, 1925650, '2025-11-26 14:23:00', '2025-11-26 15:07:30'),
(87, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Resepsionis', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 14:32:14', '2025-11-26 14:32:14'),
(88, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Dokter (1)', 1806000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1806000, '2025-11-26 14:41:49', '2025-12-02 03:50:48'),
(89, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Perawat (1)', 1806000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1806000, '2025-11-26 15:19:25', '2025-11-26 15:19:25'),
(90, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Keperluan sehari-hari perkantoran', 98000000, 20000, 12291600, 783100, 7713115, 9963500, 7036230, 12649125, 8067300, 9838630, 9838630, 9838630, 9960140, '2025-11-26 15:23:00', '2025-11-26 15:23:00'),
(91, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Biaya Penerimaan/Jamuan Tamu, City Tour, dll untuk Tamu/Organisasi International', 530000, 0, 0, 0, 530000, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 15:25:13', '2025-12-02 03:50:19'),
(92, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Konsumsi Rapat Jamuan Tamu Eselon I / Setara', 2500000, 0, 0, 0, 0, 0, 0, 0, 0, 1645000, 0, 0, 855000, '2025-11-26 15:27:14', '2025-11-26 15:27:14'),
(93, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Linen Kantor', 9060000, 0, 0, 0, 0, 0, 9049000, 0, 0, 0, 0, 0, 11000, '2025-11-26 15:29:17', '2025-11-26 15:29:17'),
(94, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Pemenuhan Asrama', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 15:30:36', '2025-11-26 15:30:36'),
(95, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Jasa Laundry', 55800000, 0, 2648500, 0, 6065696, 2188000, 1837500, 10198790, 0, 5779190, 5779190, 5779190, 15523944, '2025-11-26 15:34:13', '2025-12-02 03:53:31'),
(96, '3377', '002', '52', 'Umum', 'EBA.994', 17, 2, 'Biaya pengiriman surat dinas pos (Dalam dan Luar Negeri)', 4350000, 0, 1538000, 0, 1087300, 212000, 204000, 280500, 111000, 200000, 200000, 200000, 317200, '2025-11-26 15:37:48', '2025-12-02 05:05:13'),
(97, '3377', '002', '52', 'Umum', 'EBA.994', 17, 3, 'Honorarium Bendahara', 9600000, 0, 800000, 0, 0, 0, 0, 4000000, 800000, 800000, 800000, 800000, 1600000, '2025-11-26 15:40:34', '2025-11-26 15:41:05'),
(98, '3377', '002', '52', 'Umum', 'EBA.994', 17, 4, 'Pengangkutan Sampah', 20400000, 0, 150000, 0, 5150000, 1800000, 2000000, 1650000, 1500000, 1650000, 2000000, 2000000, 2500000, '2025-11-26 16:03:45', '2025-11-26 16:05:15'),
(99, '3377', '002', '52', 'Umum', 'EBA.994', 17, 4, 'Pengelolaan Limbah Medis', 4500000, 0, 0, 0, 0, 500000, 500000, 500000, 500000, 500000, 500000, 500000, 1000000, '2025-11-26 16:07:36', '2025-11-26 16:07:36'),
(100, '3377', '002', '52', 'Umum', 'EBA.994', 17, 4, 'Parkir Dalam Rangka Pengiriman Surat', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 16:10:27', '2025-11-26 16:10:27'),
(101, '3377', '002', '52', 'Umum', 'EBA.994', 17, 4, 'Keperluan Standar Pelayanan Publik', 123000000, 0, 0, 0, 4040000, 27052600, 69767400, 6546255, 6279500, 8018000, 0, 0, 1296245, '2025-11-26 16:13:15', '2025-11-26 16:13:15'),
(102, '3377', '002', '52', 'Umum', 'EBA.994', 17, 7, 'Pencetakan Banner', 3000000, 0, 0, 0, 2776000, 0, 0, 0, 0, 0, 0, 0, 224000, '2025-11-26 16:19:45', '2025-11-26 16:19:45'),
(103, '3377', '002', '52', 'Umum', 'EBA.994', 17, 8, 'Alat Tulis Kantor (ATK)', 48000000, 0, 0, 1274820, 0, 0, 32111770, 0, 13624600, 0, 0, 0, 988810, '2025-11-26 16:23:10', '2025-11-26 16:23:10'),
(104, '3377', '002', '52', 'Umum', 'EBA.994', 17, 8, 'Toner Printer', 5000000, 0, 0, 0, 0, 0, 0, 0, 0, 5000000, 0, 0, 0, '2025-11-26 16:25:10', '2025-11-26 16:25:10'),
(105, '3377', '002', '52', 'Umum', 'EBA.994', 17, 8, 'Bahan Cetakan (+3jt-Juli)', 73459000, 0, 30364050, 0, 0, 0, 0, 0, 3000000, 0, 0, 0, 40094950, '2025-11-26 16:27:23', '2025-11-26 16:27:23'),
(106, '3377', '002', '52', 'Umum', 'EBA.994', 17, 8, 'Alat Rumah Tangga dan Bahan Kebersihan', 5030000, 0, 4695680, 0, 0, 330000, 0, 0, 0, 0, 0, 0, 4320, '2025-11-26 16:29:47', '2025-11-26 16:29:47'),
(107, '3377', '002', '52', 'Umum', 'EBA.994', 17, 8, 'Amenities Asrama', 12000000, 0, 0, 0, 8077248, 0, 0, 0, 2294096, 0, 0, 0, 1628656, '2025-11-26 16:33:18', '2025-11-26 16:33:18'),
(108, '3377', '002', '52', 'Umum', 'EBA.994', 17, 8, 'Materai Rp.10.000', 1000000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1000000, '2025-11-26 16:34:46', '2025-11-26 16:34:46'),
(109, '3377', '002', '52', 'Umum', 'EBA.994', 17, 8, 'Plakat', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 16:36:20', '2025-11-26 16:36:20'),
(110, '3377', '002', '52', 'Umum', 'EBA.994', 17, 17, 'Jasa Desain (+)', 12000000, 5980000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6020000, '2025-11-26 16:38:31', '2025-11-26 16:38:31'),
(111, '3377', '002', '52', 'Umum', 'EBA.994', 17, 17, 'Jasa Angkut', 2000000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2000000, '2025-11-26 16:40:09', '2025-11-26 16:40:09'),
(112, '3377', '002', '52', 'Umum', 'EBA.994', 17, 10, NULL, 1656000000, 123953370, 138722547, 132751502, 107059711, 121215050, 134912716, 143434295, 150064998, 144067865, 150000000, 150000000, 159817946, '2025-11-26 17:16:13', '2025-11-26 17:16:13'),
(113, '3377', '002', '52', 'Umum', 'EBA.994', 17, 12, '-', 66000000, 6376000, 5430000, 5782000, 5441000, 2647000, 2581000, 4484000, 4770000, 4660000, 4660000, 4660000, 14509000, '2025-11-26 17:31:16', '2025-11-26 17:31:16'),
(114, '3377', '002', '52', 'Umum', 'EBA.994', 17, 11, '-', 12000000, 546676, 1328199, 554835, 1454907, 965050, 931407, 826068, 827954, 539960, 1187848, 1187848, 1649248, '2025-11-26 19:13:44', '2025-11-26 19:18:31'),
(115, '3377', '002', '52', 'Umum', 'EBA.994', 17, 13, 'Langganan Lisensi Software Manajemen Perkantoran', 45500000, 0, 2218500, 2347000, 32000000, 3818331, 30045, 504545, 329997, 368302, 0, 0, 3883280, '2025-11-26 19:32:40', '2025-11-26 19:32:40'),
(116, '3377', '002', '52', 'Umum', 'EBA.994', 17, 13, 'Langganan Internet', 280355000, 0, 760300, 0, 69160800, 0, 760800, 68780400, 0, 760800, 69200000, 800000, 70131900, '2025-11-26 19:36:19', '2025-11-26 19:36:19'),
(117, '3377', '002', '52', 'Umum', 'EBA.994', 17, 13, 'Lisensi Aplikasi Video Conference', 18000000, 0, 2944412, 0, 0, 3054844, 0, 6785864, 920136, 2916668, 0, 0, 1378076, '2025-11-26 19:39:16', '2025-11-26 19:39:16'),
(118, '3377', '002', '52', 'Umum', 'EBA.994', 17, 15, 'Sewa Mesin Fotocopy (Digital)', 10656000, 0, 888000, 888000, 888000, 888000, 888000, 888000, 888000, 888000, 888000, 1776000, 888000, '2025-11-26 19:42:05', '2025-11-26 19:45:15'),
(119, '3377', '002', '52', 'Umum', 'EBA.994', 17, 15, 'Sewa Mesin Printer Warna', 108000000, 0, 9000000, 9000000, 9000000, 9000000, 9000000, 9000000, 9000000, 9000000, 9000000, 18000000, 9000000, '2025-11-26 19:44:32', '2025-12-02 05:16:18'),
(120, '3377', '002', '52', 'Umum', 'EBA.994', 17, 15, 'Sewa Minigarden', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 19:46:21', '2025-11-26 19:46:21'),
(121, '3377', '002', '52', 'Umum', 'EBA.994', 17, 15, 'Sewa Kendaraan Operasional Roda 4', 132000000, 130810824, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1189176, '2025-11-26 19:47:35', '2025-11-26 19:47:35'),
(122, '3377', '002', '52', 'Umum', 'EBA.994', 17, 15, 'Sewa tenda, panggung, dan dekorasi', 4280000, 0, 0, 0, 0, 0, 4280000, 0, 0, 0, 0, 0, 0, '2025-11-26 19:52:10', '2025-11-26 20:02:14'),
(123, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Pemeliharaan kendaraan dinas Eselon II', 39175000, 0, 4045000, 0, 2400000, 0, 1400000, 16134106, 1160700, 1455000, 2000000, 2000000, 8580194, '2025-11-26 19:56:29', '2025-11-26 19:56:29'),
(124, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Pemeliharaan kendaraan operasional roda 4', 40000000, 0, 6201511, 0, 3656500, 4700000, 1370000, 5364120, 2350000, 3000000, 3000000, 3000000, 7357869, '2025-11-26 20:12:02', '2025-11-26 20:12:02'),
(125, '3377', '002', '52', 'Umum', 'EBA.994', 17, 4, 'Operasional kendaraan operasional roda 4', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 20:13:39', '2025-11-26 20:13:39'),
(126, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Pemeliharaan dan operasional kendaraan operasional roda 2', 6000000, 0, 229950, 0, 500000, 624062, 274000, 387540, 90000, 117140, 117140, 117140, 3543028, '2025-11-26 20:17:09', '2025-11-26 20:17:09'),
(127, '3377', '002', '52', 'Umum', 'EBA.994', 17, 18, 'Pemeliharaan gedung bertingkat (Gedung Pusdiklat)', 500676000, 0, 12702947, 17321597, 17493597, 72081183, 54890837, 84462653, 73762658, 64783058, 58164764, 33164764, 11847943, '2025-11-26 20:22:56', '2025-11-26 20:22:56'),
(128, '3377', '002', '52', 'Umum', 'EBA.994', 17, 18, 'Halaman gedung/bangunan kantor (Gedung Pusdiklat)', 66000000, 0, 2840200, 0, 656000, 4202600, 6776670, 26244750, 22601956, 800000, 0, 0, 1877824, '2025-11-26 20:26:58', '2025-11-26 20:27:19'),
(129, '3377', '002', '52', 'Umum', 'EBA.994', 17, 18, 'Pemeliharaan gedung bertingkat (Gedung Ciloto)', 53000000, 0, 8071248, 0, 0, 0, 16075796, 4437700, 0, 1537920, 8841500, 8841500, 5194336, '2025-11-26 20:30:31', '2025-11-26 20:30:49'),
(130, '3377', '002', '52', 'Umum', 'EBA.994', 17, 18, 'Halaman gedung/bangunan kantor (Gedung Ciloto)', 6300000, 0, 0, 0, 170000, 1706275, 83000, 85000, 0, 1890000, 1000000, 1000000, 365725, '2025-11-26 20:33:18', '2025-11-26 20:33:18'),
(131, '3377', '002', '52', 'Umum', 'EBA.994', 17, 18, 'Jasa Konsultan Pengawas', 40002000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 40002000, '2025-11-26 20:34:35', '2025-11-26 20:34:35'),
(132, '3377', '002', '52', 'Umum', 'EBA.994', 17, 18, 'Jasa Konsultan Perencana', 30000000, 0, 0, 0, 0, 0, 0, 0, 0, 30000000, 0, 0, 0, '2025-11-26 20:36:13', '2025-11-26 20:36:13'),
(133, '3377', '002', '52', 'Umum', 'EBA.994', 17, 18, 'Pekerjaan Konstruksi', 1020000000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 510000000, 510000000, '2025-11-26 20:37:31', '2025-11-26 20:37:31'),
(134, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Pemeliharaan Sistem telekomunikasi PABX + Telepon + televisi', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 20:39:19', '2025-11-26 20:39:19'),
(135, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Pemeliharaan Elevator System', 80000000, 0, 0, 9768000, 0, 9768000, 0, 9768000, 0, 9768000, 0, 9768000, 31160000, '2025-11-26 20:42:09', '2025-11-26 20:42:09'),
(136, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Pemeliharaan Sistem Pemadam Kebakaran (Fire Hydrant dan Fire Alarm)', 50000000, 0, 0, 0, 0, 0, 0, 0, 23726750, 0, 0, 0, 26273250, '2025-11-26 20:44:15', '2025-11-26 20:44:15'),
(137, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Pemeliharaan Alat Pemadam Ringan (APAR)', 15200000, 0, 0, 0, 0, 0, 0, 1220000, 0, 0, 15200000, 0, -1220000, '2025-11-26 20:46:22', '2025-11-26 20:46:22'),
(138, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Genset 500 KVA termasuk biaya bahan bakar selama 1 tahun', 58000000, 0, 0, 0, 0, 0, 43845000, 0, 0, 0, 10000000, 0, 4155000, '2025-11-26 20:49:12', '2025-11-26 20:49:12'),
(139, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Genset 250 KVA termasuk biaya bahan bakar selama 1 tahun', 18315000, 0, 0, 0, 0, 0, 18315000, 0, 0, 0, 0, 0, 0, '2025-11-26 20:51:16', '2025-11-26 20:51:16'),
(140, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Sistem Tata Udara (Chiller, AHU, FCU, Dehumidifier dan Filter Air Purifier)', 432000000, 0, 12853000, 0, 0, 313455212, 0, 0, 17499150, 48506000, 18000000, 0, 21686638, '2025-11-26 20:53:37', '2025-11-26 20:53:37'),
(141, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Dehumidifier dan Filter Air Purifier', 48300000, 0, 0, 0, 0, 0, 48299985, 0, 0, 0, 0, 0, 15, '2025-11-26 20:55:40', '2025-11-26 20:55:40'),
(142, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Trafo dan Kubikal Kelistrikan', 100000000, 0, 0, 0, 0, 0, 0, 0, 100000000, 0, 0, 0, 0, '2025-11-26 20:57:46', '2025-11-26 20:57:46'),
(143, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Cubical, Panel PDTR, Panel UPS, dan Panel distribusi', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 20:59:30', '2025-11-26 20:59:30'),
(144, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'STP dan pompa-pompa', 29915000, 0, 0, 2719500, 2719500, 2719500, 2719500, 2719500, 2719500, 2719500, 2719500, 2719500, 5439500, '2025-11-26 21:02:55', '2025-12-02 17:29:35'),
(145, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'AC Presisi', 64000000, 0, 0, 0, 0, 0, 32000000, 0, 0, 0, 0, 32000000, 0, '2025-11-26 21:04:40', '2025-11-26 21:04:40'),
(146, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'CCTV System', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 21:06:02', '2025-11-26 21:06:02'),
(147, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'UPS', 56000000, 0, 0, 0, 0, 28000000, 0, 0, 0, 0, 0, 0, 28000000, '2025-11-26 21:07:39', '2025-11-26 21:07:39'),
(148, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'AC Split', 26160000, 0, 0, 0, 0, 0, 0, 0, 8910000, 0, 15000000, 0, 2250000, '2025-11-26 21:09:27', '2025-11-26 21:09:27'),
(149, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Mekanikal Elektrik Lainnya', 371472000, 435000, 3107899, 17094000, 12921000, 1291000, 3826592, 2337300, 5846750, 5744950, 193000000, 0, 125867509, '2025-11-26 21:12:34', '2025-11-26 21:12:34'),
(150, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Pemeliharaan Peralatan dan Mesin', 21335000, 0, 0, 0, 0, 0, 0, 0, 21334200, 0, 0, 0, 800, '2025-11-26 21:14:29', '2025-11-26 21:14:29'),
(151, '3377', '002', '52', 'Umum', 'EBA.994', 17, 19, 'Pemeliharaan Kelistrikan', 140000000, 0, 0, 0, 0, 0, 0, 0, 0, 140000000, 0, 0, 0, '2025-11-26 21:16:27', '2025-11-26 21:16:27'),
(152, '3377', '002', '52', 'Umum', 'EBA.994', 17, 20, 'Pemeliharaan Alat Musik', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 21:23:29', '2025-11-30 04:01:37'),
(153, '3377', '002', '52', 'Umum', 'EBA.994', 17, 17, 'Pengadaan Jasa Pengelolaan Gedung Pusdiklat APUPPT (Building Management)', 4945185000, 0, 0, 372204134, 695347983, 384081342, 384081342, 383582014, 384081342, 384081342, 384372918, 384372918, 1188979665, '2025-11-26 21:27:17', '2025-11-26 21:27:17'),
(154, '3377', '002', '52', 'Umum', 'EBA.994', 17, 4, 'Pencetakan Publikasi', 6000000, 0, 0, 0, 0, 0, 0, 0, 4520000, 1198200, 0, 0, 281800, '2025-11-26 21:30:15', '2025-11-26 21:30:15'),
(155, '3377', '002', '52', 'Umum', 'EBA.994', 17, 4, 'Atribut Upacara', 100000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 100000, '2025-11-26 21:32:12', '2025-11-26 21:32:12'),
(156, '3377', '002', '52', 'Umum', 'EBA.994', 17, 15, 'Sewa Atribut Upacara', 5173000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5173000, '2025-11-26 21:34:03', '2025-11-26 21:34:03'),
(157, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Penghasilan PPNPN 52 (Pengamanan)', 90702000, 0, 90697450, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4550, '2025-11-26 21:36:56', '2025-11-26 21:36:56'),
(158, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Penghasilan PPNPN 52 (Pramubakti)', 129896000, 0, 129875000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 21000, '2025-11-26 21:39:02', '2025-11-26 21:39:02'),
(159, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Penghasilan PPNPN 52 (Pengemudi)', 15249000, 0, 15249000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 21:41:08', '2025-11-26 21:41:08'),
(160, '3377', '002', '52', 'Umum', 'EBA.994', 17, 1, 'Penghasilan PPNPN 52 (Teknisi)', 10251000, 0, 10250250, 0, 0, 0, 0, 0, 0, 0, 0, 0, 750, '2025-11-26 21:42:59', '2025-11-26 21:42:59'),
(161, '3377', '002', '52', 'Umum', 'EBA.994', 17, 4, 'Uang Lembur', 2275000, 0, 2275000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 21:44:52', '2025-11-26 21:44:52'),
(162, '3377', '002', '52', 'Umum', 'EBA.994', 17, 4, 'Uang Makan Lembur', 1200000, 0, 1200000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-26 21:47:18', '2025-11-26 21:47:18'),
(165, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Alat Kesehatan (Tensimeter)', 1400000, 1317475, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 82525, '2025-11-30 04:48:36', '2025-11-30 04:48:36'),
(166, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Alat Kesehatan (Head lamp eye scope)', 1400000, 1275100, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 124900, '2025-11-30 04:49:54', '2025-11-30 04:49:54'),
(167, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Alat Kesehatan (Sterilisator)', 2350000, 0, 2327000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 23000, '2025-11-30 04:51:12', '2025-11-30 04:51:12'),
(168, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Vidiotron', 600001000, 0, 0, 0, 0, 0, 600000001, 0, 0, 0, 0, 0, 999, '2025-11-30 04:52:31', '2025-11-30 04:52:31'),
(169, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Pompa Deepwell', 63000000, 0, 0, 0, 0, 0, 0, 0, 0, 63000000, 0, 0, 0, '2025-11-30 04:53:33', '2025-11-30 04:53:33'),
(170, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Meubelair Ruang Kelas', 99000000, 0, 7836000, 0, 0, 67898700, 22627350, 0, 0, 0, 0, 0, 637950, '2025-11-30 04:55:04', '2025-11-30 04:55:04'),
(171, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Mesin Absen', 48840000, 0, 0, 0, 0, 0, 48840000, 0, 0, 0, 0, 0, 0, '2025-11-30 04:56:06', '2025-11-30 04:56:06'),
(172, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'DVR CCTV Ciloto (sisa anggaran)', 4000000, 0, 3881200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 118800, '2025-11-30 04:59:05', '2025-11-30 04:59:05'),
(173, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Mic Conference Table Wireless (KKP)', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 04:59:49', '2025-11-30 04:59:49'),
(174, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Patch Panel', 9407000, 0, 0, 0, 0, 0, 0, 0, 0, 9407000, 0, 0, 0, '2025-11-30 05:00:45', '2025-11-30 05:00:45'),
(175, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Meubeliar Studio', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 05:01:23', '2025-11-30 05:01:23'),
(176, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Sofa', 5999000, 0, 0, 0, 0, 0, 0, 0, 0, 5999000, 0, 0, 0, '2025-11-30 05:02:26', '2025-11-30 05:02:26'),
(177, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Kaca Lift', 24000000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 05:03:45', '2025-11-30 05:03:45'),
(178, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'AC Split', 52836000, 0, 0, 0, 0, 0, 0, 52836000, 0, 0, 0, 0, 0, '2025-11-30 05:07:14', '2025-11-30 05:19:43'),
(179, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Water Heater (KKP)', 230000000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 230000000, '2025-11-30 05:08:19', '2025-11-30 05:25:50'),
(180, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Mesin Penghancur Kertas', 5000000, 0, 0, 0, 0, 0, 0, 0, 0, 5000000, 0, 0, 0, '2025-11-30 05:09:32', '2025-11-30 05:25:21'),
(181, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Mixer', 8314000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 05:10:29', '2025-11-30 05:10:29'),
(182, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'CCTV', 90000000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 90000000, 0, '2025-11-30 05:11:25', '2025-11-30 05:11:25'),
(183, '3377', '055', '53', 'Umum', 'EBB.951', 18, 47, 'Rak Kabel Jaringan', 9200000, 0, 0, 0, 0, 0, 0, 0, 0, 9137700, 0, 0, 62300, '2025-11-30 05:12:39', '2025-11-30 05:12:39'),
(184, '3377', '052', '53', 'Umum', 'EBB.971', 19, 48, 'Pembangunan Studio Multimedia', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 760000000, '2025-11-30 05:15:33', '2025-11-30 05:15:57'),
(185, '3377', '052', '53', 'Umum', 'EBB.971', 19, 48, 'Pembangunan Gudang BMN', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1300000000, '2025-11-30 05:16:54', '2025-11-30 05:16:54'),
(186, '3377', '052', '53', 'Umum', 'EBB.971', 19, 48, 'Renovasi Gerbang dan Portal', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 100000000, '2025-11-30 05:17:51', '2025-11-30 05:17:51'),
(187, '3377', '052', '53', 'Umum', 'EBB.971', 19, 48, 'Pembangunan Gedung Record Centre', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-30 05:18:43', '2025-11-30 05:18:43'),
(190, '3375', '001', '51', 'Umum', 'EBA.994', 8, 25, 'Kekurangan Gaji DP', 345175, 0, 345175, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-01 02:16:17', '2025-12-01 02:16:17'),
(191, '3375', '001', '51', 'Umum', 'EBA.994', 8, 25, 'Pembayaran Gaji THR PNS', 164903105, 0, 0, 164903105, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-01 02:19:44', '2025-12-01 02:19:44'),
(192, '3375', '001', '51', 'Umum', 'EBA.994', 8, 25, 'Pembayaran Gaji 13 PNS', 173570107, 0, 0, 0, 0, 0, 173570107, 0, 0, 0, 0, 0, 0, '2025-12-01 02:21:24', '2025-12-01 02:21:56'),
(193, '3375', '001', '51', 'Umum', 'EBA.994', 8, 25, 'Kekurangan Gaji Feb-Apr25', 4999528, 0, 0, 0, 0, 0, 4999528, 0, 0, 0, 0, 0, 0, '2025-12-01 02:36:40', '2025-12-01 02:36:40'),
(194, '3375', '001', '51', 'Umum', 'EBA.994', 8, 25, 'Kekurangan Gaji Apr-Mei25', 3915106, 0, 0, 0, 0, 0, 3915106, 0, 0, 0, 0, 0, 0, '2025-12-01 02:37:54', '2025-12-01 02:37:54'),
(195, '3375', '001', '51', 'Umum', 'EBA.994', 8, 35, 'Pembayaran Gaji PPPK', 771882696, 58380700, 58380700, 58380700, 58498400, 58891100, 58891100, 58891100, 58891100, 58891100, 81262232, 81262232, 81262232, '2025-12-01 02:40:42', '2025-12-04 06:23:22'),
(196, '3375', '001', '51', 'Umum', 'EBA.994', 8, 35, 'Pembayaran Gaji THR PPPK', 58380700, 0, 0, 58380700, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-01 02:45:50', '2025-12-01 02:54:53'),
(197, '3375', '001', '51', 'Umum', 'EBA.994', 8, 35, 'Pembayaran Gaji 13 PPPK', 58891100, 0, 0, 0, 0, 0, 58891100, 0, 0, 0, 0, 0, 0, '2025-12-01 02:47:29', '2025-12-01 02:54:09'),
(198, '3375', '001', '51', 'Umum', 'EBA.994', 8, 45, 'Pembayaran Tunsus PNS', 8890495426, 719226646, 718082770, 720480852, 750907460, 766089368, 736330984, 764429195, 772268593, 772268593, 711803655, 711803655, 746803655, '2025-12-01 03:00:27', '2025-12-04 06:24:59'),
(199, '3375', '001', '51', 'Umum', 'EBA.994', 8, 45, 'Pembayaran Tunsus THR PNS', 841715073, 0, 0, 841715073, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-01 03:02:42', '2025-12-01 03:02:42'),
(200, '3375', '001', '51', 'Umum', 'EBA.994', 8, 45, 'Pembayaran Tunsus 13 PNS', 899278470, 0, 0, 0, 0, 0, 899278470, 0, 0, 0, 0, 0, 0, '2025-12-01 03:04:37', '2025-12-01 03:04:37'),
(201, '3375', '001', '51', 'Umum', 'EBA.994', 8, 45, 'Kekurangan Pembayaran Tunsus PNS Des 2024 (38%)', 297843330, 297843330, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-01 03:06:17', '2025-12-01 03:06:17'),
(202, '3375', '001', '51', 'Umum', 'EBA.994', 8, 45, 'Kekurangan Tunsus PNS Feb 2025', 2911724, 0, 0, 0, 0, 0, 2911724, 0, 0, 0, 0, 0, 0, '2025-12-01 03:08:31', '2025-12-01 03:08:31'),
(203, '3375', '001', '51', 'Umum', 'EBA.994', 8, 45, 'Kekurangan Tunsus PNS Apr 2025', 20524707, 0, 0, 0, 0, 0, 20524707, 0, 0, 0, 0, 0, 0, '2025-12-01 03:09:32', '2025-12-01 03:09:32'),
(204, '3375', '001', '51', 'Umum', 'EBA.994', 8, 45, 'Kekurangan Tunsus PNS Mei 2025', 2900000, 0, 0, 0, 0, 0, 2900000, 0, 0, 0, 0, 0, 0, '2025-12-01 03:10:27', '2025-12-01 03:10:27'),
(205, '3375', '001', '51', 'Umum', 'EBA.994', 8, 45, 'Kekurangan Tunsus Ke13 PNS 2025', 2900000, 0, 0, 0, 0, 0, 2900000, 0, 0, 0, 0, 0, 0, '2025-12-01 03:12:38', '2025-12-01 03:12:38'),
(206, '3375', '001', '51', 'Umum', 'EBA.994', 8, 46, 'Pembayaran Tunsus PPPK', 2481583325, 194460635, 194327120, 194964400, 194654060, 194839625, 195266000, 195132485, 195266000, 195266000, 237469000, 237469000, 252469000, '2025-12-01 03:17:13', '2025-12-04 06:25:24'),
(207, '3375', '001', '51', 'Umum', 'EBA.994', 8, 46, 'Pembayaran Tunsus THR PPPK', 214750051, 0, 0, 214750051, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-01 03:19:23', '2025-12-01 03:19:23'),
(208, '3375', '001', '51', 'Umum', 'EBA.994', 8, 46, 'Pembayaran Tunsus 13 PPPK', 214792060, 0, 0, 0, 0, 0, 214792060, 0, 0, 0, 0, 0, 0, '2025-12-01 03:20:55', '2025-12-01 03:20:55'),
(209, '3375', '001', '51', 'Umum', 'EBA.994', 8, 46, 'Kekurangan Pembayaran Tunsus PPPK Des 2024 (38%)', 73922863, 73922863, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-01 03:22:12', '2025-12-01 03:22:12'),
(210, '3375', '001', '51', 'Umum', 'EBA.994', 8, 42, 'Penghasilan PPNPN 51', 340099650, 0, 37585975, 37734750, 37842950, 37748275, 37761800, 37815900, 37870000, 37870000, 37870000, 0, 0, '2025-12-01 03:25:49', '2025-12-04 04:16:22'),
(211, '3375', '001', '51', 'Umum', 'EBA.994', 8, 42, 'Penghasilan THR PPNPN 51', 34353900, 0, 0, 34353900, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-12-01 03:28:07', '2025-12-01 03:28:07'),
(212, '3375', '001', '51', 'Umum', 'EBA.994', 8, 42, 'Penghasilan 13 PPNPN 51', 34353900, 0, 0, 0, 0, 0, 34353900, 0, 0, 0, 0, 0, 0, '2025-12-01 03:29:49', '2025-12-01 03:29:49'),
(213, '3375', '001', '51', 'Umum', 'EBA.994', 8, 33, 'UMakan PNS', 285078000, 0, 22431000, 25033000, 23420000, 17631000, 17357000, 18474000, 31142000, 27080000, 25326000, 27738000, 49446000, '2025-12-01 03:33:29', '2025-12-04 06:23:04'),
(214, '3375', '001', '51', 'Umum', 'EBA.994', 8, 41, 'UMakan PPPK', 132021000, 0, 8882000, 9622000, 9287000, 7235000, 7671000, 7852000, 11822000, 10280000, 10794000, 17457000, 31119000, '2025-12-01 03:37:49', '2025-12-04 06:23:52'),
(215, '3375', '001', '51', 'Umum', 'EBA.994', 8, 43, 'ULembur PNS', 9328000, 0, 434000, 755000, 898000, 0, 591000, 0, 0, 0, 0, 0, 6650000, '2025-12-01 03:41:55', '2025-12-04 06:24:09'),
(216, '3375', '001', '51', 'Umum', 'EBA.994', 8, 44, 'ULembur PPPK', 3151000, 0, 0, 1010000, 0, 0, 753000, 0, 0, 0, 0, 0, 1388000, '2025-12-01 03:44:43', '2025-12-04 06:24:33'),
(217, '3375', '001', '51', 'Umum', 'EBA.994', 8, 43, 'ULembur PPPNPN', 1559000, 0, 0, 0, 0, 0, 0, 1559000, 0, 0, 0, 0, 0, '2025-12-01 03:49:06', '2025-12-01 03:49:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('AbPd8HmaGLdPRZU3GmqJK5a2PfTehFmEkpy2JC6T', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVFlVQndneGlKUzIxQkVpaFVrakpBdldJODFjZ0g4MGVsUDA4bGxXUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tb25pdG9yaW5nLXJwZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxMzoibGFzdF9hY3Rpdml0eSI7aToxNzY0ODU0Nzg0O30=', 1764854786),
('L87q6uhSBa4pEDMWQOFU7u9Ja5vCXgV70UoV0wcM', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibTRsMlVFMTRoZkt0VnduZlpKY1kwd041ZkJkajBRTmp0RHo3VkVBViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZW5jYW5hLWtlZ2lhdGFuP2tlZ2lhdGFuPTMzNzUmb3V0cHV0PUVCQS45OTQmcmVuY2FuYV9wYWdlPTEmc3VtbWFyeV9wYWdlPTIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTM6Imxhc3RfYWN0aXZpdHkiO2k6MTc2NDg1MzQ3Njt9', 1764853477),
('RcAR5kUUcpBniCOA4wPzQmOWCz2WNrHqi797IiAN', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWTcwamtrdk5TclBjUTdxeE1ZcTZ3RjRkUnJZbkJiSU1ldTlpcE5XbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTM6Imxhc3RfYWN0aXZpdHkiO2k6MTc2NDg1NTkyNjt9', 1764855931),
('uPNArR27g5PdWwIZwYOiwVYkzA6RxdGfN1udwrMP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmhWZ1FmUW41bmJXMkNkSEd4dElPSU9mVlU2UEx4SU14U2U0STNWbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1764854170),
('We9caOjQ31rJLvLcICk25pwNkdBAhAXj4DBgYPmr', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSnB3eVBJNTlhckJKYVhkT3k4bFpWd2VRREFsdkM5M01XekZlUjJmMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1764855448);

-- --------------------------------------------------------

--
-- Struktur dari tabel `uraians`
--

CREATE TABLE `uraians` (
  `id_uraian` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `uraians`
--

INSERT INTO `uraians` (`id_uraian`, `kode`, `nama`, `created_at`, `updated_at`) VALUES
(1, '521111', 'Belanja Keperluan Perkantoran', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(2, '521114', 'Belanja Pengiriman Surat Dinas Pos Pusat', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(3, '521115', 'Belanja Honor Operasional Satuan Kerja', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(4, '521119', 'Belanja Barang Operasional Lainnya', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(5, '521211', 'Belanja Bahan', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(6, '521213', 'Belanja Honor Output Kegiatan', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(7, '521219', 'Belanja Barang Non Operasional Lainnya', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(8, '521811', 'Belanja Barang Persediaan Barang Konsumsi', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(9, '521832', 'Belanja Barang Persediaan Lainnya', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(10, '522111', 'Belanja Langganan Listrik', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(11, '522112', 'Belanja Langganan Telepon', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(12, '522113', 'Belanja Langganan Air', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(13, '522119', 'Belanja Langganan Daya dan Jasa Lainnya', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(14, '522131', 'Belanja Jasa Konsultan', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(15, '522141', 'Belanja Sewa', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(16, '522151', 'Belanja Jasa Profesi', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(17, '522191', 'Belanja Jasa Lainnya', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(18, '523111', 'Belanja Pemeliharaan Gedung dan Bangunan', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(19, '523121', 'Belanja Pemeliharaan Peralatan dan Mesin', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(20, '523199', 'Belanja Pemeliharaan Lainnya', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(21, '524111', 'Belanja Perjalanan Dinas Biasa', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(22, '524113', 'Belanja Perjalanan Dinas Dalam Kota', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(23, '524114', 'Belanja Perjalanan Dinas Paket Meeting Luar Kota', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(24, '524119', 'Belanja Perjalanan Dinas Paket Meeting Luar Kota', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(25, '511111', 'Belanja Gaji Pokok PNS', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(26, '511119', 'Belanja Pembulatan Gaji PNS', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(27, '511121', 'Belanja Tunj. Suami/Istri PNS', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(28, '511122', 'Belanja Tunj. Anak PNS', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(29, '511123', 'Belanja Tunj. Struktural PNS', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(30, '511124', 'Belanja Tunj. Fungsional PNS', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(31, '511125', 'Belanja Tunj. PPh PNS', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(32, '511126', 'Belanja Tunj. Beras PNS', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(33, '511129', 'Belanja Uang Makan PNS', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(34, '511151', 'Belanja Tunjangan Umum PNS', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(35, '511611', 'Belanja Gaji Pokok PPPK', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(36, '511619', 'Belanja Pembulatan Gaji PPPK', '2025-12-02 20:58:04', '2025-12-02 20:58:04'),
(37, '511621', 'Belanja Tunjangan Suami/Istri PPPK', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(38, '511622', 'Belanja Tunjangan Anak PPPK', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(39, '511624', 'Belanja Tunjangan Fungsional PPPK', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(40, '511625', 'Belanja Tunjangan Beras PPPK', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(41, '511628', 'Belanja Uang Makan PPPK', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(42, '512111', 'Belanja Uang Honor Tetap', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(43, '512211', 'Belanja Uang Lembur', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(44, '512212', 'Belanja Uang Lembur PPPK', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(45, '512411', 'Belanja Pegawai (Tunjangan Khusus/Kegiatan/Kinerja)', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(46, '512414', 'Belanja Pegawai Tunjangan Khusus/Kegiatan/Kinerja PPPK', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(47, '532111', 'Belanja Modal Peralatan dan Mesin', '2025-12-02 20:58:05', '2025-12-02 20:58:05'),
(48, '533121', 'Belanja Penambahan Nilai Gedung dan Bangunan', '2025-12-02 20:58:05', '2025-12-02 20:58:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `name`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', '$2y$12$hnXLGmAmf/CuYlHbWO6J6.YcV8kaCWq5U3QlPgp6gkggUWkl3QtOW', 'admin', '2025-12-01 22:22:57', '2025-12-01 22:53:17'),
(2, 'user', 'User', '$2y$12$QcKYP6qHHzY5tVAd2IBrFOSxCxpFzCAwIFRsNYgkWhLrpwpBeNWVy', 'user', '2025-12-01 22:22:57', '2025-12-01 22:53:17');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indeks untuk tabel `akuns`
--
ALTER TABLE `akuns`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `ikpa_targets`
--
ALTER TABLE `ikpa_targets`
  ADD PRIMARY KEY (`id_ikpa_target`),
  ADD UNIQUE KEY `ikpa_targets_jenis_belanja_triwulan_tahun_unique` (`jenis_belanja`,`triwulan`,`tahun`);

--
-- Indeks untuk tabel `kegiatans`
--
ALTER TABLE `kegiatans`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indeks untuk tabel `kegiatan_output`
--
ALTER TABLE `kegiatan_output`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kegiatan_output_kegiatan_id_output_id_akun_id_uraian_id_unique` (`kegiatan_id`,`output_id`,`akun_id`,`uraian_id`),
  ADD KEY `kegiatan_output_output_id_foreign` (`output_id`),
  ADD KEY `kegiatan_output_akun_id_foreign` (`akun_id`),
  ADD KEY `kegiatan_output_uraian_id_foreign` (`uraian_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `outputs`
--
ALTER TABLE `outputs`
  ADD PRIMARY KEY (`id_output`);

--
-- Indeks untuk tabel `realisasis`
--
ALTER TABLE `realisasis`
  ADD PRIMARY KEY (`id_realisasi`),
  ADD UNIQUE KEY `realisasis_output_akun_id_uraian_id_uraians_unique` (`output`,`akun_id`,`uraian_id`,`uraians`),
  ADD KEY `realisasis_akun_id_foreign` (`akun_id`),
  ADD KEY `realisasis_uraian_id_foreign` (`uraian_id`);

--
-- Indeks untuk tabel `rencana_kegiatans`
--
ALTER TABLE `rencana_kegiatans`
  ADD PRIMARY KEY (`id_rencana`),
  ADD KEY `rencana_kegiatans_akun_id_foreign` (`akun_id`),
  ADD KEY `rencana_kegiatans_uraian_id_foreign` (`uraian_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `uraians`
--
ALTER TABLE `uraians`
  ADD PRIMARY KEY (`id_uraian`),
  ADD UNIQUE KEY `uraians_kode_unique` (`kode`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT untuk tabel `akuns`
--
ALTER TABLE `akuns`
  MODIFY `id_akun` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `ikpa_targets`
--
ALTER TABLE `ikpa_targets`
  MODIFY `id_ikpa_target` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kegiatans`
--
ALTER TABLE `kegiatans`
  MODIFY `id_kegiatan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kegiatan_output`
--
ALTER TABLE `kegiatan_output`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=662;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `outputs`
--
ALTER TABLE `outputs`
  MODIFY `id_output` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `realisasis`
--
ALTER TABLE `realisasis`
  MODIFY `id_realisasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT untuk tabel `rencana_kegiatans`
--
ALTER TABLE `rencana_kegiatans`
  MODIFY `id_rencana` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT untuk tabel `uraians`
--
ALTER TABLE `uraians`
  MODIFY `id_uraian` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kegiatan_output`
--
ALTER TABLE `kegiatan_output`
  ADD CONSTRAINT `kegiatan_output_akun_id_foreign` FOREIGN KEY (`akun_id`) REFERENCES `akuns` (`id_akun`) ON DELETE CASCADE,
  ADD CONSTRAINT `kegiatan_output_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatans` (`id_kegiatan`) ON DELETE CASCADE,
  ADD CONSTRAINT `kegiatan_output_output_id_foreign` FOREIGN KEY (`output_id`) REFERENCES `outputs` (`id_output`) ON DELETE CASCADE,
  ADD CONSTRAINT `kegiatan_output_uraian_id_foreign` FOREIGN KEY (`uraian_id`) REFERENCES `uraians` (`id_uraian`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `realisasis`
--
ALTER TABLE `realisasis`
  ADD CONSTRAINT `realisasis_akun_id_foreign` FOREIGN KEY (`akun_id`) REFERENCES `akuns` (`id_akun`),
  ADD CONSTRAINT `realisasis_uraian_id_foreign` FOREIGN KEY (`uraian_id`) REFERENCES `uraians` (`id_uraian`);

--
-- Ketidakleluasaan untuk tabel `rencana_kegiatans`
--
ALTER TABLE `rencana_kegiatans`
  ADD CONSTRAINT `rencana_kegiatans_akun_id_foreign` FOREIGN KEY (`akun_id`) REFERENCES `akuns` (`id_akun`) ON DELETE CASCADE,
  ADD CONSTRAINT `rencana_kegiatans_uraian_id_foreign` FOREIGN KEY (`uraian_id`) REFERENCES `uraians` (`id_uraian`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
