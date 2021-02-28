-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2019 at 12:49 AM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `surat`
--

-- --------------------------------------------------------

--
-- Table structure for table `arsip_file`
--

CREATE TABLE `arsip_file` (
  `id_arsip` int(11) NOT NULL,
  `id_user` varchar(25) NOT NULL,
  `id_klasifikasi` varchar(25) NOT NULL,
  `no_arsip` varchar(100) NOT NULL,
  `tgl_arsip` date NOT NULL,
  `keamanan` varchar(100) NOT NULL,
  `ket` tinytext NOT NULL,
  `file_arsip` tinytext NOT NULL,
  `tgl_upload` date NOT NULL,
  `created` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `arsip_file`
--

INSERT INTO `arsip_file` (`id_arsip`, `id_user`, `id_klasifikasi`, `no_arsip`, `tgl_arsip`, `keamanan`, `ket`, `file_arsip`, `tgl_upload`, `created`) VALUES
(1, '1', '12', '1', '2019-10-11', 'Rahasia', '', 'ARSIP_invoice-pdf_11-10-2019_05-30-18.pdf', '2019-10-11', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `arsip_sk`
--

CREATE TABLE `arsip_sk` (
  `id_sk` int(11) NOT NULL,
  `no_agenda` varchar(100) NOT NULL,
  `custom_noagenda` varchar(100) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `satker` varchar(11) NOT NULL,
  `no_sk` varchar(150) NOT NULL,
  `tgl_surat` date NOT NULL,
  `klasifikasi` varchar(10) NOT NULL,
  `pengolah` varchar(100) NOT NULL,
  `tujuan_surat` tinytext NOT NULL,
  `perihal` text NOT NULL,
  `ket` text NOT NULL,
  `file` varchar(200) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `arsip_sk`
--

INSERT INTO `arsip_sk` (`id_sk`, `no_agenda`, `custom_noagenda`, `id_user`, `satker`, `no_sk`, `tgl_surat`, `klasifikasi`, `pengolah`, `tujuan_surat`, `perihal`, `ket`, `file`, `created`) VALUES
(1, '1', '0001/29/SM/2019', '1', '', '001/29/BA/X/2019', '2019-10-11', '40', 'Mahmud Al Fauzi', 'OSIS SMK Plus Al-Maftuh', 'Pemilihan Ketua OSIS', '', 'SK_2019-10-11_pemilihan-ketua-osis_11-10-2019_05-16-20.pdf', '2019-10-11 05:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `arsip_sk_kapolda`
--

CREATE TABLE `arsip_sk_kapolda` (
  `id_sk` int(11) NOT NULL,
  `no_agenda` varchar(100) NOT NULL,
  `custom_noagenda` varchar(100) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `satker` varchar(11) NOT NULL,
  `no_sk` varchar(150) NOT NULL,
  `tgl_surat` date NOT NULL,
  `klasifikasi` varchar(10) NOT NULL,
  `pengolah` varchar(100) NOT NULL,
  `tujuan_surat` tinytext NOT NULL,
  `perihal` text NOT NULL,
  `ket` text NOT NULL,
  `file` varchar(200) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `arsip_sm`
--

CREATE TABLE `arsip_sm` (
  `id_sm` int(11) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `no_sm` varchar(150) NOT NULL,
  `tgl_terima` date NOT NULL,
  `no_agenda` varchar(50) NOT NULL,
  `custom_noagenda` varchar(100) NOT NULL,
  `klasifikasi` varchar(10) NOT NULL,
  `tgl_surat` date NOT NULL,
  `pengirim` varchar(200) NOT NULL,
  `tujuan_surat` varchar(200) NOT NULL,
  `perihal` text NOT NULL,
  `ket` text NOT NULL,
  `file` tinytext NOT NULL,
  `view` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `arsip_sm`
--

INSERT INTO `arsip_sm` (`id_sm`, `id_user`, `no_sm`, `tgl_terima`, `no_agenda`, `custom_noagenda`, `klasifikasi`, `tgl_surat`, `pengirim`, `tujuan_surat`, `perihal`, `ket`, `file`, `view`, `created`) VALUES
(1, '1', '0001/R/X/2019', '2019-10-10', '1', '0001/BIN - R/SM/2019', '20', '2019-10-07', 'Badan Intelegen Negara', '["85"]', 'Rahasi', '', 'SM_10-10-2019_rahasi_11-10-2019_05-18-58.pdf', 0, '2019-10-11 05:18:58');

-- --------------------------------------------------------

--
-- Table structure for table `bagian`
--

CREATE TABLE `bagian` (
  `id_bag` int(11) NOT NULL,
  `nama_bagian` tinytext NOT NULL,
  `kepala` varchar(100) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_setting`
--

CREATE TABLE `email_setting` (
  `id` int(11) NOT NULL,
  `id_kop` varchar(15) NOT NULL,
  `layout` text NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'N',
  `ket` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_setting`
--

INSERT INTO `email_setting` (`id`, `id_kop`, `layout`, `status`, `ket`) VALUES
(11, '1', '<p>Yth Bpk/Ibu :</p>\r\n<p><strong>=TembusanV=</strong></p>\r\n<p>Anda mendapat tembusan surat masuk baru dari <strong>=DisposisiOleh=</strong> dengan ket :<br /><br />Nomor agenda : <strong>=NoAgenda=</strong><br />Nomor surat : <strong>=NoSurat=</strong><br />Perihal surat : <strong>=Perihal=</strong><br />Surat Dari : <strong>=AsalSurat=</strong><br />Keterangan : <strong>=Keterangan=</strong><br />Tanggal surat : <strong>=TglSurat=</strong><br />Tanggal terima : <strong>=TglTerima=</strong><br />Tanggal ditembuskan: <strong>=TglDisposisi=</strong></p>\r\n<p>Terimakasih.</p>', 'Y', 'Format Email Penerima Tembusan Surat Masuk'),
(12, '2', '<p>Yth Bapak/Ibu :<br /><strong>=TujuanSurat=</strong></p>\r\n<p>Anda mendapat surat masuk baru dari <strong>=AsalSurat=</strong> perihal <strong>=Perihal=</strong>. Surat diterima pada tanggal <strong>=TglTerima= </strong>yang diterima oleh <strong>=Penerima=</strong>&nbsp;dengan ket:</p>\r\n<p>Nomor agenda : <strong>=NoAgenda=</strong><br />Nomor surat : <strong>=NoSurat=</strong><br />Tanggal surat : <strong>=TglSurat=<br /></strong>keterangan&nbsp;:<strong> =Keterangan=<br /></strong></p>\r\n<p>Terimakasih.</p>', 'Y', 'Format Email Penerima Surat Masuk'),
(13, '3', '<p>Yth Bapak/Ibu :<br /><strong>=Disposisi=</strong></p>\r\n<p>Anda mendapat disposisi surat masuk baru dari <strong>=DisposisiOleh=</strong> dengan ket :<br /><br />Nomor agenda : <strong>=NoAgenda=</strong><br />Nomor surat : <strong>=NoSurat=</strong><br />Perihal surat : <strong>=Perihal=</strong><br />Surat Dari : <strong>=AsalSurat=</strong><br />Keterangan : <strong>=Keterangan=</strong><br />Tanggal surat : <strong>=TglSurat=</strong><br />Tanggal terima : <strong>=TglTerima=</strong><br />Catatan disposisi : <br /><strong>=NoteDisposisi=</strong><br />Tanggal disposisi : <strong>=TglDisposisi=<br /></strong>Tembusan : <br /><strong>=TembusanV=<br /></strong>Surat Diteruskan ke:<br /><strong>=TujuanSurat=</strong><strong><br /></strong></p>\r\n<p>Terimakasih.</p>', 'Y', 'Format Email Penerima Disposisi Surat Masuk'),
(26, '4', '<p>Yth Bpk/Ibu :</p>\r\n<p><strong>=TujuanMemo=</strong></p>\r\n<p>Anda mendapat memo baru perihal <strong>=PerihalMemo=</strong> pada tanggal <strong>=TglMemo=</strong> dengan ket sebagai berikut :<br /><br /><em>=IsiMemo=</em></p>\r\n<p>Terimakasih.</p>', 'Y', 'Format Email Penerima Memo');

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `id_info` int(11) NOT NULL,
  `pengirim_info` varchar(50) NOT NULL,
  `tujuan_info` varchar(200) NOT NULL,
  `judul_info` varchar(150) NOT NULL,
  `ket_info` text NOT NULL,
  `file` varchar(200) NOT NULL,
  `tgl_info` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`id_info`, `pengirim_info`, `tujuan_info`, `judul_info`, `ket_info`, `file`, `tgl_info`) VALUES
(1, '1', '["85"]', 'Laporan BOS', 'Laporan Dana BOS', 'Memo_11-10-2019_05-29-09.pdf', '2019-10-11 05:29:09');

-- --------------------------------------------------------

--
-- Table structure for table `klasifikasi`
--

CREATE TABLE `klasifikasi` (
  `id_klas` int(11) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `klasifikasi`
--

INSERT INTO `klasifikasi` (`id_klas`, `kode`, `nama`, `updated`, `created`) VALUES
(11, 'KK', 'KEPUTUSAN DARI MABES POLRI', '2018-05-08 19:17:40', '2018-05-09'),
(10, 'PK', 'PERATURAN DARI MABES POLRI', '2018-05-08 19:17:26', '2018-05-09'),
(12, 'IK', 'INSTRUKSI DARI MABES POLRI', '2018-05-08 19:18:00', '2018-05-09'),
(13, 'PAK', 'PERINTAH HARIAN / AMANAT ANGGARAN', '2018-05-08 19:18:10', '2018-05-09'),
(14, 'LPR', 'LAPORAN', '2018-05-08 19:18:21', '2018-05-09'),
(15, 'BK', 'SURAT BIASA DARI MABES POLRI', '2018-05-08 19:18:40', '2018-05-09'),
(16, 'RK', 'SURAT RAHASIA DARI MABES POLRI', '2018-05-08 19:18:54', '2018-05-09'),
(17, 'BD', 'SURAT BIASA DARI JAJARAN POLDA KALTENG', '2018-05-08 19:19:12', '2018-05-09'),
(18, 'RD', 'SURAT RAHASIA DARI JAJARAN POLDA KALTENG', '2018-05-08 19:19:31', '2018-05-09'),
(19, 'BIN - B', 'SURAT BIASA DARI INSTANSI LAIN', '2018-05-08 19:19:48', '2018-05-09'),
(20, 'BIN - R', 'SURAT RAHASIA DARI INSTANSI LAIN', '2018-05-08 19:20:05', '2018-05-09'),
(21, 'NDM', 'NOTA DINAS', '2018-05-08 19:20:15', '2018-05-09'),
(22, 'STK', 'SURAT TELEGRAM BIASA DARI MABES POLRI', '2018-05-08 19:20:32', '2018-05-09'),
(23, 'STRK', 'SURAT TELEGRAM RAHASIA DARI MABES POLRI', '2018-05-08 19:20:55', '2018-05-09'),
(24, 'STD', 'SURAT TELEGRAM BIASA DARI JAJARAN POLDA KALTENG', '2018-05-08 19:21:08', '2018-05-09'),
(25, 'STRD', 'SURAT TELEGRAM RAHASIA DARI JAJARAN POLDA KALTENG', '2018-05-08 19:21:22', '2018-05-09'),
(26, 'MK', 'MAKLUMAT', '2018-05-08 19:21:30', '2018-05-09'),
(34, 'PKU', 'PENGUMUMAN', '2018-05-08 19:24:12', '2018-05-09'),
(28, 'SPK', 'SURAT PENGANTAR DARI MABES POLRI', '2018-05-08 19:22:08', '2018-05-09'),
(29, 'SPD', 'SURAT PENGANTAR DARI JAJARAN POLDA KALTENG', '2018-05-08 19:22:23', '2018-05-09'),
(30, 'UDG', 'UNDANGAN', '2018-05-08 19:22:31', '2018-05-09'),
(31, 'TS', 'TELAAH STAF', '2018-05-08 19:22:43', '2018-05-09'),
(32, '5000', 'KOTAK POS 5000', '2018-05-08 19:22:57', '2018-05-09'),
(33, '777', 'DUMAS 777', '2018-05-08 19:23:08', '2018-05-09');

-- --------------------------------------------------------

--
-- Table structure for table `klasifikasi_arsip`
--

CREATE TABLE `klasifikasi_arsip` (
  `id_klasifikasi` int(11) NOT NULL,
  `nama_klasifikasi` varchar(150) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `klasifikasi_arsip`
--

INSERT INTO `klasifikasi_arsip` (`id_klasifikasi`, `nama_klasifikasi`, `updated`, `created`) VALUES
(12, 'template', '2018-05-09 04:33:41', '2018-05-09');

-- --------------------------------------------------------

--
-- Table structure for table `klasifikasi_sk`
--

CREATE TABLE `klasifikasi_sk` (
  `id_klas` int(11) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `klasifikasi_sk`
--

INSERT INTO `klasifikasi_sk` (`id_klas`, `kode`, `nama`, `updated`, `created`) VALUES
(12, '01', 'PERATURAN KAPOLDA', '2018-05-08 19:05:24', '2018-05-09'),
(13, '02', 'KEPUTUSAN KAPOLDA', '2018-05-08 19:05:38', '2018-05-09'),
(14, '03', 'INTRUKSI KAPOLDA', '2018-05-08 19:06:23', '2018-05-09'),
(15, '04', 'LAPORAN', '2018-05-08 19:06:31', '2018-05-09'),
(16, '05', 'SURAT EDARAN', '2018-05-08 19:06:40', '2018-05-09'),
(17, '06', 'SURAT PERINTAH', '2018-05-08 19:06:59', '2018-05-09'),
(18, '07', 'SURAT PERINTAH PERJALANAN DINAS', '2018-05-08 19:07:18', '2018-05-09'),
(19, '08', 'SURAT BIASA KE MABES POLRI  ( KE JAJARAN POLDA LAIN )', '2018-05-08 19:07:33', '2018-05-09'),
(20, '09', 'SURAT RAHASIA  KE MABES POLRI ( KE JAJARAN POLDA LAIN )', '2018-05-08 19:07:50', '2018-05-09'),
(21, '10', 'SURAT BIASA KE JAJARAN', '2018-05-08 19:08:00', '2018-05-09'),
(22, '11', 'SURAT RAHASIA KE JAJARAN', '2018-05-08 19:08:49', '2018-05-09'),
(23, '12', 'SURAT BIASA KEINSTANSI LAIN', '2018-05-08 19:09:21', '2018-05-09'),
(24, '13', 'SURAT RAHASIA KE INSTANSI LAIN', '2018-05-08 19:09:37', '2018-05-09'),
(25, '14', 'NOTA DINAS', '2018-05-08 19:09:50', '2018-05-09'),
(26, '15', 'MAKLUMAT', '2018-05-08 19:09:58', '2018-05-09'),
(27, '16', 'PENGUMUMAN', '2018-05-08 19:10:06', '2018-05-09'),
(28, '17', 'SURAT PENGANTAR', '2018-05-08 19:10:18', '2018-05-09'),
(29, '18', 'TELAAH STAF', '2018-05-08 19:10:30', '2018-05-09'),
(30, '19', 'SURAT TELEGRAM BIASA KE MABES POLRI  ( KE JAJARAN POLDA LAIN )', '2018-05-08 19:10:49', '2018-05-09'),
(31, '20', 'SURAT TELEGRAM RAHASIA KE MABES POLRI ( KE JAJARAN POLDA LAIN )', '2018-05-08 19:11:00', '2018-05-09'),
(32, '21', 'SURAT TELEGRAM BIASA KE JAJARAN', '2018-05-08 19:11:10', '2018-05-09'),
(33, '22', 'SURAT TELEGRAM RAHASIA KE JAJARAN', '2018-05-08 19:11:20', '2018-05-09'),
(34, '23', 'RENCANA ( OPS, GIAT, KONTIJENSI )', '2018-05-08 19:11:30', '2018-05-09'),
(35, '24', 'PERINTAH', '2018-05-08 19:11:38', '2018-05-09'),
(36, '25', 'JUK / PROTAP', '2018-05-08 19:11:55', '2018-05-09'),
(37, '26', 'MoU', '2018-05-08 19:13:13', '2018-05-09'),
(38, '27', 'SURAT IJIN', '2018-05-08 19:14:13', '2018-05-09'),
(39, '28', 'UNDANGAN', '2018-05-08 19:14:24', '2018-05-09'),
(40, '29', 'BERITA ACARA', '2018-05-08 19:14:33', '2018-05-09'),
(41, '30', 'KARTU TANDA ANGGOTA', '2018-05-08 19:14:48', '2018-05-09'),
(42, '31', 'KARTU PENUNJUKAN ISTRI / SUAMI', '2018-05-08 19:15:00', '2018-05-09'),
(43, '32', 'REKOMENDASI', '2018-05-08 19:15:13', '2018-05-09'),
(44, '33', 'PIAGAM / PENGHARGAAN', '2018-05-08 19:15:44', '2018-05-09'),
(45, '34', 'SURAT KUASA', '2018-05-08 19:15:57', '2018-05-09'),
(46, '35', 'BUKU REGISTER PENGESAHAN PERATURAN KASATFUNG JAJARAN POLDA KALTENG', '2018-05-08 19:16:09', '2018-05-09');

-- --------------------------------------------------------

--
-- Table structure for table `kop_setting`
--

CREATE TABLE `kop_setting` (
  `idkop` int(11) NOT NULL,
  `kopdefault` enum('Y','N') NOT NULL DEFAULT 'Y',
  `layout` text NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'N',
  `ket` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kop_setting`
--

INSERT INTO `kop_setting` (`idkop`, `kopdefault`, `layout`, `status`, `ket`) VALUES
(1, 'Y', '<p style="color: #000000; font-family: Verdana,Arial,Helvetica,sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-style: initial; text-decoration-color: initial;">&nbsp;<span style="font-size: x-large;"><strong><u>TANDA TERIMA SURAT CUSTOM <br /></u></strong></span></p>\r\n<table style="border-collapse: collapse; width: 699px;" border="1" align="center">\r\n<tbody>\r\n<tr align="left">\r\n<td style="padding: 5px; vertical-align: top; width: 338.776px;" nowrap="nowrap">Telah terima dari</td>\r\n<td style="padding: 5px; vertical-align: top; width: 338.224px;" nowrap="nowrap">=AsalSurat=</td>\r\n</tr>\r\n<tr align="left">\r\n<td style="padding: 5px; vertical-align: top; width: 338.776px;" nowrap="nowrap">Nomor Surat</td>\r\n<td style="padding: 5px; width: 338.224px;">=NoSurat=</td>\r\n</tr>\r\n<tr align="left">\r\n<td style="padding: 5px; vertical-align: top; width: 338.776px;" nowrap="nowrap">Nomor Agenda</td>\r\n<td style="padding: 5px; width: 338.224px;">=NoAgenda=</td>\r\n</tr>\r\n<tr align="left">\r\n<td style="padding: 5px; vertical-align: top; width: 338.776px;" nowrap="nowrap">Tanggal Surat</td>\r\n<td style="padding: 5px; width: 338.224px;">=TglSurat=</td>\r\n</tr>\r\n<tr align="left">\r\n<td style="padding: 5px; vertical-align: top; width: 338.776px;" nowrap="nowrap">Tujuan Surat</td>\r\n<td style="padding: 5px; width: 338.224px;">=TujuanSurat=</td>\r\n</tr>\r\n<tr align="left">\r\n<td style="padding: 5px; vertical-align: top; width: 338.776px;" nowrap="nowrap">Tanggal Terima</td>\r\n<td style="padding: 5px; width: 338.224px;">=TglTerima=</td>\r\n</tr>\r\n<tr align="left">\r\n<td style="padding: 5px; vertical-align: top; width: 338.776px;" nowrap="nowrap">Perihal</td>\r\n<td style="padding: 5px; vertical-align: top; width: 338.224px;">=Perihal=</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<table style="border-collapse: collapse; width: 699px;" border="1" align="center">\r\n<tbody>\r\n<tr align="left">\r\n<td style="padding: 5px; width: 340.622px; text-align: center;" nowrap="nowrap">Yang Menyerahkan<br /><br /><br /><br /><br /><br /><strong>=AsalSurat=</strong></td>\r\n<td style="padding: 5px; width: 336.378px; text-align: center;" nowrap="nowrap">Yang Menerima<br /><br /><br /><br /><br /><br /><strong>=Penerima=</strong></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p style="text-align: center;">&nbsp;</p>\r\n<p style="color: #000000; font-family: Verdana,Arial,Helvetica,sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-style: initial; text-decoration-color: initial;">&nbsp;</p>\r\n<div id="container" style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-style: initial; text-decoration-color: initial;">\r\n<div id="row">\r\n<p style="text-align: center;">&nbsp;</p>\r\n</div>\r\n</div>', 'N', 'Tanda Terima Surat'),
(2, 'Y', '<h3 style="text-align: center;">SURAT MASUK CUSTOM</h3>\r\n<table style="border-collapse: collapse;" border="1" width="700" cellspacing="0" cellpadding="0" align="center">\r\n<tbody>\r\n<tr align="left">\r\n<td style="padding: 5px; vertical-align: top;" nowrap="nowrap">Surat Dari</td>\r\n<td style="padding: 5px; vertical-align: top; width: 250;" nowrap="nowrap">=AsalSurat=</td>\r\n<td style="padding: 5px; vertical-align: top;" nowrap="nowrap">Diterima Tanggal</td>\r\n<td style="padding: 5px; vertical-align: top; width: 225;" nowrap="nowrap">=TglTerima=</td>\r\n</tr>\r\n<tr align="left">\r\n<td style="padding: 5px; vertical-align: top;" nowrap="nowrap">Tanggal Surat</td>\r\n<td style="padding: 5px; vertical-align: top;">=TglSurat=</td>\r\n<td style="padding: 5px; vertical-align: top;" nowrap="nowrap">Nomor Agenda</td>\r\n<td style="padding: 5px; vertical-align: top;" nowrap="nowrap">=NoAgenda=</td>\r\n</tr>\r\n<tr align="left">\r\n<td style="padding: 5px; vertical-align: top;" nowrap="nowrap">Nomor Surat</td>\r\n<td style="padding: 5px;">=NoSurat=</td>\r\n<td style="padding: 5px; vertical-align: top;" nowrap="nowrap">Tujuan Surat</td>\r\n<td style="padding: 5px; vertical-align: top;" nowrap="nowrap">=TujuanSurat=</td>\r\n</tr>\r\n<tr align="left">\r\n<td style="padding: 5px; vertical-align: top;" nowrap="nowrap">Perihal</td>\r\n<td style="padding: 5px; vertical-align: top;">=Perihal=</td>\r\n<td style="padding: 5px; vertical-align: top;" nowrap="nowrap">Ket</td>\r\n<td style="padding: 5px; vertical-align: top;">=Keterangan=</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 'N', 'Detail Surat'),
(3, 'Y', '<h2 id="mcetoc_1bd3u8rgs1" style="text-align: center;"><strong><u>Disposisi Surat Custom<br /></u></strong></h2>\r\n<table style="border-collapse: collapse; width: 696px;" border="1" cellspacing="5" cellpadding="5" align="center">\r\n<tbody>\r\n<tr style="height: 17px;">\r\n<td style="width: 180px; height: 17px;">Surat Dari</td>\r\n<td style="width: 190px; height: 17px;">=AsalSurat=</td>\r\n</tr>\r\n<tr style="height: 17px;">\r\n<td style="width: 180px; height: 17px;">Tanggal Surat</td>\r\n<td style="width: 190px; height: 17px;">=TglSurat=</td>\r\n</tr>\r\n<tr style="height: 45px;">\r\n<td style="width: 180px; height: 45px;">Nomor Surat</td>\r\n<td style="width: 190px; height: 45px;">=NoSurat=</td>\r\n</tr>\r\n<tr style="height: 17px;">\r\n<td style="width: 180px; height: 17px;">Diterima Tanggal</td>\r\n<td style="width: 190px; height: 17px;">=TglTerima=</td>\r\n</tr>\r\n<tr style="height: 17px;">\r\n<td style="width: 180px; height: 17px;">Perihal</td>\r\n<td style="width: 190px; height: 17px;">=Perihal=</td>\r\n</tr>\r\n<tr style="height: 17px;">\r\n<td style="width: 180px; height: 17px;">Nomor Agenda</td>\r\n<td style="width: 190px; height: 17px;">=NoAgenda=</td>\r\n</tr>\r\n<tr style="height: 17px;">\r\n<td style="width: 180px; height: 17px;">Tujuan Surat</td>\r\n<td style="width: 190px; height: 17px;">=TujuanSurat=</td>\r\n</tr>\r\n<tr style="height: 70.84375px;">\r\n<td style="width: 180px; height: 70.84375px;">Disposisi dari/ke</td>\r\n<td style="width: 190px; height: 70.84375px;"><strong>=DisposisiOleh=</strong> ke :<br />=Disposisi=</td>\r\n</tr>\r\n<tr style="height: 17px;">\r\n<td style="width: 180px; height: 17px;">Tanggal Disposisi</td>\r\n<td style="width: 190px; height: 17px;">=TglDisposisi=</td>\r\n</tr>\r\n<tr style="height: 17px;">\r\n<td style="width: 180px; height: 17px;">Keterangan</td>\r\n<td style="width: 190px; height: 17px;">=Keterangan=</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;&nbsp;</p>\r\n<table style="border-collapse: collapse; width: 700px;" border="1" cellspacing="5" cellpadding="5" align="center">\r\n<tbody>\r\n<tr>\r\n<td style="width: 330.026px;" nowrap="nowrap">Tembusan:&nbsp;</td>\r\n<td style="width: 355.974px;" nowrap="nowrap">Catatan Disposisi:</td>\r\n</tr>\r\n<tr>\r\n<td style="width: 330.026px;">=TembusanV=</td>\r\n<td style="width: 355.974px;">=NoteDisposisi=</td>\r\n</tr>\r\n<tr>\r\n<td style="width: 686px;" colspan="2">Ditindak lanjuti oleh Kasie/Kasubbag, TU kepada Kasubsi/kaur:</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 'Y', 'Disposisi');

-- --------------------------------------------------------

--
-- Table structure for table `kop_variabel`
--

CREATE TABLE `kop_variabel` (
  `variabel` varchar(100) NOT NULL,
  `ket` tinytext NOT NULL,
  `id_kop` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kop_variabel`
--

INSERT INTO `kop_variabel` (`variabel`, `ket`, `id_kop`) VALUES
('=AsalSurat=', 'Asal surat/pengirim surat ', '1,2,3'),
('=Disposisi=', 'Surat didisposisikan ke', '3'),
('=DisposisiOleh=', 'Yang Memberikan Disposisi', '3'),
('=IsiMemo=', 'Isi Memo/Pesan Singkat', '4'),
('=Keterangan=', 'Keterangan surat', '1,2,3'),
('=KetSuratEdaran=', 'Keterangan Surat Edaran', '5'),
('=NoAgenda=', 'Nomor agenda surat masuk', '1,2,3'),
('=NoSurat=', 'Nomor surat masuk', '1,2,3'),
('=NoSuratEdaran=', 'Nomor Surat Edaran', '5'),
('=NoteDisposisi=', 'Catatan disposisi', '3'),
('=Penerima=', 'Konseptor Surat', '1,2'),
('=PengirimEdaran=', 'Pengirim Surat Edaran', '5'),
('=Perihal=', 'Perihal surat', '1,2,3'),
('=PerihalEdaran=', 'Perihal Surat Edaran', '5'),
('=PerihalMemo=', 'Perihal Memo/Pesna Singkat', '4'),
('=TembusanH=', 'Tembusan surat (tampil tampil sebaris)', '3'),
('=TembusanV=', 'Tembusan surat (tampil per baris)', '3'),
('=TglDisposisi=', 'Tanggal surat didisposisi', '3'),
('=TglMemo=', 'Tanggal memo', '4'),
('=TglSurat=', 'Tanggal surat Masuk', '1,2,3'),
('=TglSuratEdaran=', 'Tanggal Surat Edaran', '5'),
('=TglTerima=', 'Tanggal terima Surat', '1,2,3'),
('=TujuanEdaran=', 'Tujuan Surat Edaran', '5'),
('=TujuanMemo=', 'Tujuan Memo', '4'),
('=TujuanSurat=', 'Tujuan Surat Masuk', '1,2,3');

-- --------------------------------------------------------

--
-- Table structure for table `memo`
--

CREATE TABLE `memo` (
  `id_status` int(11) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_sm` varchar(200) NOT NULL,
  `disposisi` varchar(100) NOT NULL,
  `tembusan` varchar(200) NOT NULL,
  `note` text NOT NULL,
  `tgl` datetime NOT NULL,
  `ref` varchar(6) NOT NULL,
  `file_memo` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `deskripsi` tinytext NOT NULL,
  `logo` varchar(200) NOT NULL,
  `no_agenda_sm_start` varchar(100) NOT NULL,
  `no_agenda_sm` varchar(100) NOT NULL,
  `no_agenda_sk_start` varchar(100) NOT NULL,
  `no_agenda_sk` varchar(100) NOT NULL,
  `no_agenda_sk_kapolda_start` varchar(100) NOT NULL,
  `no_agenda_kapolda_sk` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass_email` varchar(100) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `title`, `deskripsi`, `logo`, `no_agenda_sm_start`, `no_agenda_sm`, `no_agenda_sk_start`, `no_agenda_sk`, `no_agenda_sk_kapolda_start`, `no_agenda_kapolda_sk`, `email`, `pass_email`, `updated`) VALUES
(1, 'SIAS - Sistem Informasi Arsip Surat', 'SIAS merupakan aplikasi pengelolaan arsip surat', 'KOP_09-05-2018_12-47-46.jpg', '1', '=KodeSurat=/SM/=Tahun=', '1', 'B/=KodeSurat=/=Bulan=/KKA/=Tahun=', '1', 'KAPOLDA/=KodeSurat=/=Bulan=/KKA/=Tahun=', 'mahmud.teachers@gmail.com', '#88gegana#lensakom#!', '2019-10-08 05:31:51');

-- --------------------------------------------------------

--
-- Table structure for table `status_surat`
--

CREATE TABLE `status_surat` (
  `id_status` int(15) NOT NULL,
  `id_sm` varchar(15) NOT NULL,
  `statsurat` char(1) NOT NULL,
  `id_user` varchar(15) NOT NULL,
  `ket` tinytext NOT NULL,
  `file_progress` varchar(100) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_surat`
--

INSERT INTO `status_surat` (`id_status`, `id_sm`, `statsurat`, `id_user`, `ket`, `file_progress`, `created`) VALUES
(1, '2', '1', '19', '', '', '2018-05-09 11:12:54'),
(2, '3', '1', '19', 'Naskah sedang di proses', '', '2018-05-09 13:14:07'),
(3, '1', '2', '85', 'Sudah kami baca', '', '2019-10-11 05:25:07');

-- --------------------------------------------------------

--
-- Table structure for table `surat_read`
--

CREATE TABLE `surat_read` (
  `id_sm` varchar(15) NOT NULL,
  `id_user` varchar(11) NOT NULL,
  `kode` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surat_read`
--

INSERT INTO `surat_read` (`id_sm`, `id_user`, `kode`) VALUES
('1', '19', 'INFO'),
('1', '31', 'DIS'),
('1', '45', 'SM'),
('1', '85', 'INFO'),
('1', '85', 'SM'),
('10', '73', 'INFO'),
('11', '1', 'CC'),
('11', '1', 'SM'),
('11', '49', 'CC'),
('11', '49', 'DIS'),
('12', '18', 'SM'),
('13', '60', 'SM'),
('14', '60', 'SM'),
('14', '72', 'DIS'),
('16', '90', 'SM'),
('2', '19', 'DIS'),
('2', '19', 'INFO'),
('2', '44', 'SM'),
('2', '46', 'DIS'),
('2', '47', 'SM'),
('3', '19', 'INFO'),
('3', '19', 'SM'),
('3', '46', 'DIS'),
('4', '19', 'DIS'),
('4', '44', 'SM'),
('4', '46', 'DIS'),
('4', '47', 'SM'),
('5', '19', 'SM'),
('5', '46', 'DIS'),
('5', '48', 'SM'),
('6', '44', 'DIS'),
('6', '44', 'SM'),
('6', '47', 'SM'),
('6', '60', 'INFO'),
('7', '72', 'INFO'),
('8', '1', 'SM'),
('8', '60', 'INFO'),
('9', '72', 'INFO');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `satker` varchar(10) NOT NULL,
  `uname` varchar(150) NOT NULL,
  `upass` varchar(150) NOT NULL,
  `rule_disposisi` tinytext NOT NULL,
  `level` varchar(100) NOT NULL,
  `jabatan` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `picture` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nik`, `nama`, `satker`, `uname`, `upass`, `rule_disposisi`, `level`, `jabatan`, `email`, `picture`) VALUES
(1, '123', 'Administrator', '27', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'null', 'Admin', 57, '', 'picture.jpg'),
(90, '123', 'IRWASDA', '28', 'IRWASDA', '9a6331365da6d3d9732ec67d20002f1d', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 58, '', 'sekretaris.png'),
(89, '123', 'WAKAPOLDA KALTENG', '30', 'WAKAPOLDA', '202cb962ac59075b964b07152d234b70', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 239, '', 'sekretaris.png'),
(88, '123', 'KAPOLDA KALTENG', '29', 'KAPOLDA', '202cb962ac59075b964b07152d234b70', '["90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 238, '', 'sekretaris.png'),
(87, '123', 'SESPRI SPRIPIM', '39', 'SESPRI SPRIPIM', '202cb962ac59075b964b07152d234b70', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 104, '', 'sekretaris.png'),
(86, '123', 'KOORSPRIPIM', '39', 'KOORSPRIPIM', '202cb962ac59075b964b07152d234b70', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 103, '', 'sekretaris.png'),
(85, '123', 'URKANPOS', '40', 'URKANPOS', '58c2cc5a431982c49a837583b81c103e', '["1","90","88","74","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 116, '', 'sekretaris.png'),
(84, '123', 'URPUSTAKA SUBBAGSIPTAKA', '40', 'URPUSTAKA SUBBAGSIPTAKA', '202cb962ac59075b964b07152d234b70', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 115, '', 'sekretaris.png'),
(82, '123', 'SUBBAGSIPTAKA SETUM', '40', 'SUBBAGSIPTAKA SETUM', '202cb962ac59075b964b07152d234b70', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 113, '', 'sekretaris.png'),
(83, '123', 'URARSIP SUBBAGSIPTAKA', '40', 'URARSIP SUBBAGSIPTAKA', '202cb962ac59075b964b07152d234b70', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 114, '', 'sekretaris.png'),
(81, '123', 'URTAKAH SUBBAGMINU', '40', 'URTAKAH SUBBAGMINU', '202cb962ac59075b964b07152d234b70', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 112, '', 'sekretaris.png'),
(80, '123', 'URBINSET SUBBAGMINU', '40', 'URBINSET SUBBAGMINU', '202cb962ac59075b964b07152d234b70', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 111, '', 'sekretaris.png'),
(79, '123', 'SUBBAGMINU SETUM', '40', 'SUBBAGMINU SETUM', '202cb962ac59075b964b07152d234b70', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 110, '', 'sekretaris.png'),
(78, '123', 'URTU URRENMIN', '40', 'URTU URRENMIN', '202cb962ac59075b964b07152d234b70', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 109, '', 'sekretaris.png'),
(77, '123', 'URMIN URRENMIN', '40', 'URMIN URRENMIN', '202cb962ac59075b964b07152d234b70', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 108, '', 'sekretaris.png'),
(76, '123', 'URREN URRENMIN', '40', 'URREN URRENMIN', '202cb962ac59075b964b07152d234b70', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 107, '', 'sekretaris.png'),
(75, '123', 'URRENMIN SETUM', '40', 'URRENMIN SETUM', '202cb962ac59075b964b07152d234b70', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 106, '', 'sekretaris.png'),
(74, '123', 'KASETUM', '40', 'KASETUM', '202cb962ac59075b964b07152d234b70', '["1","90","88","74","91","86","87","79","82","83","80","85","77","84","76","75","81","78","89"]', '', 105, '', 'sekretaris.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_jabatan`
--

CREATE TABLE `user_jabatan` (
  `id_jab` int(11) NOT NULL,
  `nama_jabatan` varchar(200) NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_jabatan`
--

INSERT INTO `user_jabatan` (`id_jab`, `nama_jabatan`, `created`, `updated`) VALUES
(87, 'KASUBBAGREHABPERS BIDPROPAM', '2018-07-22 15:57:14', '2018-07-22 08:57:14'),
(86, 'KASUBBAGRENMIN BIDPROPAM', '2018-07-22 15:57:09', '2018-07-22 08:57:09'),
(85, 'KABIDPROPAM', '2018-07-22 15:57:04', '2018-07-22 08:57:04'),
(84, 'KABAGFASKON ROSARPRAS', '2018-07-22 15:56:53', '2018-07-22 08:56:53'),
(83, 'KABAGPAL ROSARPRAS', '2018-07-22 15:56:38', '2018-07-22 08:56:38'),
(82, 'KABAGINFOSARPRAS ROSARPRAS', '2018-07-22 15:56:20', '2018-07-22 08:56:20'),
(81, 'KASUBBAGRENMIN ROSARPRAS', '2018-07-22 15:56:12', '2018-07-22 08:56:12'),
(80, 'KAROSARPRAS', '2018-07-22 15:56:07', '2018-07-22 08:56:07'),
(79, 'KABAGPSI RO SM', '2018-07-22 15:55:58', '2018-07-22 08:55:58'),
(78, 'KABAGWATPERS RO SM', '2018-07-22 15:55:53', '2018-07-22 08:55:53'),
(77, 'KABAGBINKAR RO SDM', '2018-07-22 15:55:48', '2018-07-22 08:55:48'),
(76, 'KABAGDALPERS RO SDM', '2018-07-22 15:55:42', '2018-07-22 08:55:42'),
(75, 'KASUBBAGRENMIN RO SDM', '2018-07-22 15:55:36', '2018-07-22 08:55:36'),
(74, 'KARO SDM', '2018-07-22 15:55:31', '2018-07-22 08:55:31'),
(73, 'KABAG RBP RORENA', '2018-07-22 15:54:55', '2018-07-22 08:54:55'),
(72, 'KABAGDALPROGAR RORENA', '2018-07-22 15:54:50', '2018-07-22 08:54:50'),
(71, 'KABAGRENPROGAR RORENA', '2018-07-22 15:54:42', '2018-07-22 08:54:43'),
(70, 'KABAGSTRAJEMEN RORENA', '2018-07-22 15:54:37', '2018-07-22 08:54:37'),
(69, 'KASUBBAGRENMIN RORENA', '2018-07-22 15:54:32', '2018-07-22 08:54:32'),
(68, 'KARORENA', '2018-07-22 15:54:27', '2018-07-22 08:54:27'),
(67, 'KABAGDALOPS ROOPS', '2018-07-22 15:54:05', '2018-07-22 08:54:05'),
(66, 'KABAGBINLATIOPS ROOPS', '2018-07-22 15:54:00', '2018-07-22 08:54:00'),
(65, 'KABAGBINOPS ROOPS', '2018-07-22 15:53:54', '2018-07-22 08:53:54'),
(64, 'KASUBBAGRENMIN ROOPS', '2018-07-22 15:53:50', '2018-07-22 08:53:50'),
(63, 'KAROOPS', '2018-07-22 15:53:44', '2018-07-22 08:53:44'),
(62, 'IRBIDBIN ITWASDA', '2018-07-22 15:53:39', '2018-07-22 08:53:39'),
(61, 'IRBIDOPS ITWASDA', '2018-07-22 15:53:34', '2018-07-22 08:53:34'),
(60, 'KASUBBAGDUMASAN ITWASDA', '2018-07-22 15:53:25', '2018-07-22 08:53:25'),
(59, 'KASUBBAGRENMIN ITWASDA', '2018-07-22 15:53:16', '2018-07-22 08:53:16'),
(58, 'IRWASDA', '2018-07-22 15:53:11', '2018-07-22 08:53:11'),
(57, 'ICT', '2018-07-22 15:47:47', '2018-07-22 08:47:47'),
(88, 'KASUBBAGYANDUAN BIDPROPAM', '2018-07-22 15:57:18', '2018-07-22 08:57:18'),
(89, 'KASUBBIDPAMINAL BIDPROPAM', '2018-07-22 15:57:24', '2018-07-22 08:57:24'),
(90, 'KASUBBIDPROVOS BIDPROPAM', '2018-07-22 15:57:30', '2018-07-22 08:57:30'),
(91, 'KASUBBIDWABPROF BIDPROPAM', '2018-07-22 15:57:34', '2018-07-22 08:57:34'),
(92, 'KABIDHUMAS', '2018-07-22 15:57:57', '2018-07-22 08:57:57'),
(93, 'KASUBBAGRENMIN BIDHUMAS', '2018-07-22 15:58:01', '2018-07-22 08:58:01'),
(94, 'KASUBBIDPENMAS BIDHUMAS', '2018-07-22 15:58:06', '2018-07-22 08:58:06'),
(95, 'KASUBBID PID BIDHUMAS', '2018-07-22 15:58:10', '2018-07-22 08:58:10'),
(96, 'KASUBBAGRENMIN BIDKUM', '2018-07-22 15:58:16', '2018-07-22 08:58:16'),
(97, 'KASUBBIDSUNLUHKUM BIDKUM', '2018-07-22 15:58:22', '2018-07-22 08:58:22'),
(98, 'KASUBBIDBANKUM BIDKUM', '2018-07-22 15:58:27', '2018-07-22 08:58:27'),
(99, 'KABID TI', '2018-07-22 15:58:37', '2018-07-22 08:58:37'),
(100, 'KASUBBAGRENMIN BID TI', '2018-07-22 15:58:41', '2018-07-22 08:58:42'),
(101, 'KASUBBIDTEKKOM BID TI', '2018-07-22 15:58:46', '2018-07-22 08:58:46'),
(102, 'KASUBBIDTEKINFO BID TI', '2018-07-22 15:58:51', '2018-07-22 08:58:51'),
(103, 'KOORSPRIPIM', '2018-07-22 15:58:56', '2018-07-22 08:58:56'),
(104, 'SESPRI SPRIPIM', '2018-07-22 15:59:01', '2018-07-22 08:59:01'),
(105, 'KASETUM', '2018-07-22 15:59:06', '2018-07-22 08:59:06'),
(106, 'KAURRENMIN SETUM', '2018-07-22 15:59:11', '2018-07-22 08:59:11'),
(107, 'BAURREN URRENMIN', '2018-07-22 15:59:15', '2018-07-22 08:59:15'),
(108, 'BAURMIN URRENMIN', '2018-07-22 15:59:19', '2018-07-22 08:59:20'),
(109, 'BAURTU URRENMIN', '2018-07-22 15:59:25', '2018-07-22 08:59:25'),
(110, 'KASUBBAGMINU SETUM', '2018-07-22 15:59:31', '2018-07-22 08:59:31'),
(111, 'KAURBINSET SUBBAGMINU', '2018-07-22 15:59:37', '2018-07-22 08:59:37'),
(112, 'KAURTAKAH SUBBAGMINU', '2018-07-22 15:59:43', '2018-07-22 08:59:43'),
(113, 'KASUBBAGSIPTAKA SETUM', '2018-07-22 15:59:48', '2018-07-22 08:59:48'),
(114, 'KAURARSIP SUBBAGSIPTAKA', '2018-07-22 15:59:53', '2018-07-22 08:59:53'),
(115, 'KAURPUSTAKA SUBBAGSIPTAKA', '2018-07-22 16:00:00', '2018-07-22 09:00:00'),
(116, 'KAURKANPOS', '2018-07-22 16:00:04', '2018-07-22 09:00:04'),
(117, 'KAYANMA', '2018-07-22 16:41:53', '2018-07-22 09:41:53'),
(118, 'KAURRENMIN YANMA', '2018-07-22 16:41:59', '2018-07-22 09:41:59'),
(119, 'KASUBBAGYANTOR YANMA', '2018-07-22 16:42:05', '2018-07-22 09:42:05'),
(120, 'KASUBBAGHARBANGLING YANMA', '2018-07-22 16:42:10', '2018-07-22 09:42:10'),
(121, 'KASUBBAGPAMSIK YANMA', '2018-07-22 16:42:15', '2018-07-22 09:42:15'),
(122, 'KA SPKT', '2018-07-22 16:42:24', '2018-07-22 09:42:24'),
(123, 'KAURRENMIN SPKT', '2018-07-22 16:42:29', '2018-07-22 09:42:29'),
(124, 'DIRINTELKAM', '2018-07-22 16:45:08', '2018-07-22 09:45:08'),
(125, 'WADIRINTELKAM', '2018-07-22 16:45:14', '2018-07-22 09:45:14'),
(126, 'KASUBBAGRENMIN DITINTELKAM', '2018-07-22 16:45:20', '2018-07-22 09:45:20'),
(127, 'KABAGANALISIS DITINTELKAM', '2018-07-22 16:45:25', '2018-07-22 09:45:25'),
(128, 'KASIYANMIN DITINTELKAM', '2018-07-22 16:45:35', '2018-07-22 09:45:36'),
(129, 'KASIINTELTEK DITINTELKAM', '2018-07-22 16:45:41', '2018-07-22 09:45:41'),
(130, 'KASISANDI DITINTELKAM', '2018-07-22 16:45:45', '2018-07-22 09:45:45'),
(131, 'SUBDIT DITINTELKAM I', '2018-07-22 16:45:49', '2018-07-22 09:45:50'),
(132, 'SUBDIT DITINTELKAM II', '2018-07-22 16:45:54', '2018-07-22 09:45:54'),
(133, 'SUBDIT DITINTELKAM III', '2018-07-22 16:45:58', '2018-07-22 09:45:58'),
(134, 'SUBDIT DITINTELKAM IV', '2018-07-22 16:46:03', '2018-07-22 09:46:03'),
(135, 'DIRRESKRIMUM', '2018-07-22 16:46:13', '2018-07-22 09:46:13'),
(136, 'WADIRRESKRIMUM', '2018-07-22 16:46:17', '2018-07-22 09:46:17'),
(137, 'KASUBBAGRENMIN DITRESKRIMUM', '2018-07-22 16:46:21', '2018-07-22 09:46:21'),
(138, 'KABAGBINOPSNAL DITRESKRIMUM', '2018-07-22 16:46:25', '2018-07-22 09:46:25'),
(139, 'KABAGWASSIDIK DITRESKRIMUM', '2018-07-22 16:46:29', '2018-07-22 09:46:29'),
(140, 'KASUBDIT I DITRESKRIMUM', '2018-07-22 16:46:34', '2018-07-22 09:46:34'),
(141, 'KASUBDIT II DITRESKRIMUM', '2018-07-22 16:46:39', '2018-07-22 09:46:39'),
(142, 'KASUBDIT III DITRESKRIMUM', '2018-07-22 16:46:50', '2018-07-22 09:46:50'),
(143, 'KASUBDIT IV DITRESKRIMUM', '2018-07-22 16:46:54', '2018-07-22 09:46:54'),
(144, 'DIRRESKRIMSUS', '2018-07-22 16:48:44', '2018-07-22 09:48:44'),
(145, 'WADIRRESKRIMSUS', '2018-07-22 16:48:48', '2018-07-22 09:48:48'),
(146, 'KASUBBAGRENMIN DITRESKRIMSUS', '2018-07-22 16:48:53', '2018-07-22 09:48:53'),
(147, 'KABAGBINOPSNAL DITRESKRIMSUS', '2018-07-22 16:48:57', '2018-07-22 09:48:57'),
(148, 'KABAGWASSIDIK DITRESKRIMSUS', '2018-07-22 16:49:02', '2018-07-22 09:49:02'),
(149, 'KASIKORWAS PPNS DITRESKRIMSUS', '2018-07-22 16:49:07', '2018-07-22 09:49:07'),
(150, 'KASUBDIT I DITRESKRIMSUS', '2018-07-22 16:49:12', '2018-07-22 09:49:12'),
(151, 'KASUBDIT II DITRESKRIMSUS', '2018-07-22 16:49:17', '2018-07-22 09:49:17'),
(152, 'KASUBDIT III DITRESKRIMSUS', '2018-07-22 16:49:23', '2018-07-22 09:49:23'),
(153, 'KASUBDIT IV DITRESKRIMSUS', '2018-07-22 16:49:27', '2018-07-22 09:49:27'),
(154, 'DIRRESNARKOBA', '2018-07-22 16:51:09', '2018-07-22 09:51:09'),
(155, 'WADIRRESNARKOBA', '2018-07-22 16:51:15', '2018-07-22 09:51:15'),
(156, 'KASUBBAGRENMIN DITRESNARKOBA', '2018-07-22 16:51:19', '2018-07-22 09:51:19'),
(157, 'KABAGBINOPSNAL DITRESNARKOBA', '2018-07-22 16:51:24', '2018-07-22 09:51:24'),
(158, 'KABAGWASSIDIK DITRESNARKOBA', '2018-07-22 16:51:28', '2018-07-22 09:51:28'),
(159, 'KASUBDIT I DITRESNARKOBA', '2018-07-22 16:51:33', '2018-07-22 09:51:33'),
(160, 'KASUBDIT II DITRESNARKOBA', '2018-07-22 16:51:38', '2018-07-22 09:51:38'),
(161, 'KASUBDIT III DITRESNARKOBA', '2018-07-22 16:51:44', '2018-07-22 09:51:44'),
(162, 'DIRBINMAS', '2018-07-22 16:51:54', '2018-07-22 09:51:54'),
(163, 'WADIRBINMAS', '2018-07-22 16:51:59', '2018-07-22 09:51:59'),
(164, 'KASUBBAGRENMIN DITBINMAS', '2018-07-22 16:52:04', '2018-07-22 09:52:04'),
(165, 'KABAGBINOPSNAL DITBINMAS', '2018-07-22 16:52:08', '2018-07-22 09:52:09'),
(166, 'KASUBDITBINTIBLUH DITBINMAS', '2018-07-22 16:52:13', '2018-07-22 09:52:13'),
(167, 'KASIBINLAT SUBDITBINSATPAM/POLSUS', '2018-07-22 16:52:18', '2018-07-22 09:52:18'),
(168, 'KASUBDITBINPOLMAS DITBINMAS', '2018-07-22 16:52:23', '2018-07-22 09:52:23'),
(169, 'KASUBDITKERMA DITBINMS', '2018-07-22 16:52:27', '2018-07-22 09:52:27'),
(170, 'DIRSABHARA', '2018-07-22 16:52:35', '2018-07-22 09:52:35'),
(171, 'WADIRSABHARA', '2018-07-22 16:52:39', '2018-07-22 09:52:39'),
(172, 'KASUBBAGRENMIN DITSABHARA', '2018-07-22 16:52:43', '2018-07-22 09:52:43'),
(173, 'KABAGBINOPSNAL DITSABHARA', '2018-07-22 16:52:57', '2018-07-22 09:52:57'),
(174, 'KASUBDITGASUM DITSABHARA', '2018-07-22 16:53:05', '2018-07-22 09:53:05'),
(175, 'KASUBDITDALMAS DITSABHARA', '2018-07-22 16:53:09', '2018-07-22 09:53:09'),
(176, 'DIRLANTAS', '2018-07-22 16:53:25', '2018-07-22 09:53:25'),
(177, 'WADIRLANTAS', '2018-07-22 16:53:29', '2018-07-22 09:53:29'),
(178, 'KASUBBAGRENMIN DITLANTAS', '2018-07-22 16:53:33', '2018-07-22 09:53:33'),
(179, 'KABAGBINOPSNAL DITLANTAS', '2018-07-22 16:53:36', '2018-07-22 09:53:36'),
(180, 'KASUBDITDIKYASA DITLANTAS', '2018-07-22 16:53:40', '2018-07-22 09:53:40'),
(181, 'KASUBDITBINGAKKUM DITLANTAS', '2018-07-22 16:53:44', '2018-07-22 09:53:44'),
(182, 'KASUBDITREGIDENT DITLANTAS', '2018-07-22 16:53:48', '2018-07-22 09:53:48'),
(183, 'KASUBDITKAMSEL DITLANTAS', '2018-07-22 16:53:52', '2018-07-22 09:53:52'),
(184, 'KASAT PJR DITLANTAST PJR', '2018-07-22 16:53:57', '2018-07-22 09:53:57'),
(185, 'DIRPAMOBVIT', '2018-07-22 16:54:05', '2018-07-22 09:54:05'),
(186, 'WADIRPAMOBVIT', '2018-07-22 16:54:08', '2018-07-22 09:54:08'),
(187, 'KASUBBAGRENMIN DITPAMOBVIT', '2018-07-22 16:54:13', '2018-07-22 09:54:13'),
(188, 'KABAGBINOPSNAL DITPAMOBVIT', '2018-07-22 16:54:17', '2018-07-22 09:54:17'),
(189, 'KASUBDITWASTER DITPAMOBVIT', '2018-07-22 16:54:23', '2018-07-22 09:54:23'),
(190, 'KASUBDITWISATA DITPAMOBVIT', '2018-07-22 16:54:28', '2018-07-22 09:54:28'),
(191, 'KASUBDITLEMNEG DITPAMOBVIT', '2018-07-22 16:54:53', '2018-07-22 09:54:53'),
(192, 'KASUBDITKILAS DITPAMOBVIT', '2018-07-22 16:54:58', '2018-07-22 09:54:58'),
(193, 'DIRPOLAIR', '2018-07-22 16:55:06', '2018-07-22 09:55:06'),
(194, 'WADIRPOLAIR', '2018-07-22 16:55:11', '2018-07-22 09:55:11'),
(195, 'KASUBBAGRENMIN DITPOLAIR', '2018-07-22 16:55:15', '2018-07-22 09:55:15'),
(196, 'KABAGBINOPSNAL DITPOLAIR', '2018-07-22 16:55:19', '2018-07-22 09:55:19'),
(197, 'KASUBDITGAKKUM DITPOLAIR', '2018-07-22 16:55:24', '2018-07-22 09:55:24'),
(198, 'KASATROLDA DITPOLAIR', '2018-07-22 16:55:29', '2018-07-22 09:55:29'),
(199, 'KASUBDITFASHARKAN DITPOLAIR', '2018-07-22 16:55:39', '2018-07-22 09:55:39'),
(200, 'DIRTAHTI', '2018-07-22 16:55:59', '2018-07-22 09:55:59'),
(201, 'WADIRTAHTI', '2018-07-22 16:56:04', '2018-07-22 09:56:04'),
(202, 'KASUBBAGRENMIN DITTAHTI', '2018-07-22 16:56:07', '2018-07-22 09:56:08'),
(203, 'KASUBDITPAMTAH DITTAHTI', '2018-07-22 16:56:17', '2018-07-22 09:56:17'),
(204, 'KASUBDITHARWATTAH DITTAHTI', '2018-07-22 16:56:22', '2018-07-22 09:56:22'),
(205, 'KASUBDITBARBUK DITTAHTI', '2018-07-22 16:56:27', '2018-07-22 09:56:27'),
(206, 'KASATBRIMOB', '2018-07-22 16:56:54', '2018-07-22 09:56:54'),
(207, 'WAKASATBRIMOB', '2018-07-22 16:56:58', '2018-07-22 09:56:58'),
(208, 'KASUBBAGRENMIN SATBRIMOB', '2018-07-22 16:57:02', '2018-07-22 09:57:02'),
(209, 'KASIINTEL SATBRIMOB', '2018-07-22 16:57:06', '2018-07-22 09:57:06'),
(210, 'KASIOPS SATBRIMOB', '2018-07-22 16:57:10', '2018-07-22 09:57:10'),
(211, 'KASISARPRAS SATBRIMOB', '2018-07-22 16:57:15', '2018-07-22 09:57:15'),
(212, 'KASIYANMA SATBRIMOB', '2018-07-22 16:57:20', '2018-07-22 09:57:20'),
(213, 'KADEN A SATBRIMOB', '2018-07-22 16:57:24', '2018-07-22 09:57:24'),
(214, 'KADEN B SATBRIMOB', '2018-07-22 16:57:28', '2018-07-22 09:57:28'),
(215, 'KADEN GEGANA SATBRIMOB', '2018-07-22 16:57:32', '2018-07-22 09:57:32'),
(216, 'KA SPN', '2018-07-22 16:57:43', '2018-07-22 09:57:43'),
(217, 'KAWAKA SPN', '2018-07-22 16:57:46', '2018-07-22 09:57:46'),
(218, 'KASUBBAGRENMIN SPN', '2018-07-22 16:57:51', '2018-07-22 09:57:51'),
(219, 'KASUBBAGYANMA SPN', '2018-07-22 16:57:55', '2018-07-22 09:57:55'),
(220, 'KABAGJARLAT SPN', '2018-07-22 16:57:59', '2018-07-22 09:57:59'),
(221, 'KAKORSIS SPN', '2018-07-22 16:58:04', '2018-07-22 09:58:04'),
(222, 'KOORGADIK SPN', '2018-07-22 16:58:08', '2018-07-22 09:58:08'),
(223, 'KABIDKEU', '2018-07-22 16:58:13', '2018-07-22 09:58:13'),
(224, 'KASUBBARENMIN BIDKEU', '2018-07-22 16:58:16', '2018-07-22 09:58:17'),
(225, 'KASUBBID BIA DAN APK BIDKEU', '2018-07-22 16:58:21', '2018-07-22 09:58:21'),
(226, 'KASUBBIDALKEU BIDKEU', '2018-07-22 16:58:25', '2018-07-22 09:58:25'),
(227, 'KABIDDOKKES', '2018-07-22 16:58:45', '2018-07-22 09:58:45'),
(228, 'KASUBBARENMIN BIDDOKKES', '2018-07-22 16:58:57', '2018-07-22 09:58:57'),
(229, 'KASUBBIDOKPOL BIDDOKKES', '2018-07-22 16:59:02', '2018-07-22 09:59:02'),
(230, 'KASUBBIKESPOL BIDDOKKES', '2018-07-22 16:59:05', '2018-07-22 09:59:05'),
(231, 'KARUMKIT', '2018-07-22 16:59:11', '2018-07-22 09:59:11'),
(232, 'WAKARUMKIT', '2018-07-22 16:59:20', '2018-07-22 09:59:20'),
(233, 'KASUBBAGRENMIN', '2018-07-22 16:59:31', '2018-07-22 09:59:31'),
(234, 'KASUBBAGBINFUNG', '2018-07-22 16:59:36', '2018-07-22 09:59:36'),
(235, 'KASUBBAGWASINTERN', '2018-07-22 16:59:40', '2018-07-22 09:59:40'),
(236, 'KASUBBIDYANMEDDOKPOL', '2018-07-22 16:59:44', '2018-07-22 09:59:44'),
(237, 'KASUBBIDJANGMEDUM', '2018-07-22 16:59:48', '2018-07-22 09:59:49'),
(238, 'KAPOLDA', '2018-07-22 17:17:57', '2018-07-22 10:17:57'),
(239, 'WAKAPOLDA', '2018-07-22 17:18:00', '2018-07-22 10:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `id_user` int(11) NOT NULL,
  `sm` char(1) NOT NULL DEFAULT 'N',
  `sk` char(1) NOT NULL DEFAULT 'N',
  `arsip` char(1) NOT NULL DEFAULT 'N',
  `cari_surat_masuk` char(1) NOT NULL DEFAULT 'N',
  `cari_surat_keluar` char(1) NOT NULL DEFAULT 'N',
  `template_surat` char(1) NOT NULL DEFAULT 'N',
  `atur_noagenda` char(1) NOT NULL DEFAULT 'N',
  `atur_layout` char(1) NOT NULL DEFAULT 'N',
  `report_dispo` char(1) NOT NULL DEFAULT 'N',
  `atur_klasifikasi_sm` char(1) NOT NULL DEFAULT 'N',
  `atur_klasifikasi_sk` char(1) NOT NULL DEFAULT 'N',
  `atur_klasifikasi_arsip` char(1) NOT NULL DEFAULT 'N',
  `atur_user` char(1) NOT NULL DEFAULT 'N',
  `atur_infoapp` char(1) NOT NULL DEFAULT 'N',
  `report_sm` char(1) DEFAULT 'N',
  `report_sk` char(1) NOT NULL DEFAULT 'N',
  `report_arsip` char(1) NOT NULL DEFAULT 'N',
  `report_progress` char(1) NOT NULL DEFAULT 'N',
  `info` char(1) NOT NULL DEFAULT 'N',
  `atur_tujuan_sk` char(1) NOT NULL DEFAULT 'N',
  `edaran` char(1) NOT NULL,
  `report_edaran` char(1) NOT NULL,
  `log_user` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`id_user`, `sm`, `sk`, `arsip`, `cari_surat_masuk`, `cari_surat_keluar`, `template_surat`, `atur_noagenda`, `atur_layout`, `report_dispo`, `atur_klasifikasi_sm`, `atur_klasifikasi_sk`, `atur_klasifikasi_arsip`, `atur_user`, `atur_infoapp`, `report_sm`, `report_sk`, `report_arsip`, `report_progress`, `info`, `atur_tujuan_sk`, `edaran`, `report_edaran`, `log_user`) VALUES
(1, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'W', '', 'Y'),
(2, 'R', 'R', 'R', 'N', 'N', 'N', 'N', '', 'Y', '', 'N', '', '', 'N', 'Y', 'Y', 'Y', '', 'N', '', '', '', ''),
(3, 'W', 'W', 'W', 'Y', 'Y', 'W', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', 'W', 'Y', ''),
(9, 'R', 'R', 'R', 'N', 'N', 'N', 'N', '', 'Y', 'N', 'N', 'N', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'N', '', '', '', ''),
(10, 'R', 'R', 'R', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', '', '', '', ''),
(11, 'R', 'R', 'R', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', '', '', '', ''),
(12, '', '', '', 'N', 'N', 'N', 'N', '', '', '', 'N', '', '', 'N', '', '', '', '', 'N', '', '', '', ''),
(17, 'W', 'W', '', 'N', 'N', 'N', 'N', '', '', '', '', '', '', 'N', '', '', '', '', '', 'N', '', '', ''),
(18, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', ''),
(19, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', ''),
(20, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(21, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(22, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(23, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(24, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(25, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(26, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(27, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(28, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(29, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(30, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(31, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(32, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(33, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(34, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(35, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(36, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(37, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(38, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(39, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(40, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(41, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(42, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(43, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(44, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(45, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(46, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', ''),
(47, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(48, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '', '', ''),
(50, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'N'),
(51, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'N'),
(52, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', '', '', 'N'),
(53, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(54, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(55, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(56, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(57, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(58, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(59, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(60, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(61, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(62, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(63, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(64, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(65, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(66, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(67, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(68, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(69, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(70, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(71, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', 'N'),
(72, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(73, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(74, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(75, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(76, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(77, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(78, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(79, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(80, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(81, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(82, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(83, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(84, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(85, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'Y'),
(86, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'N', 'Y', 'Y', 'N', '', '', 'N'),
(87, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'N', 'Y', 'N', 'N', '', '', 'N'),
(88, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'N'),
(89, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'N', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', '', '', 'N'),
(90, 'W', 'W', 'W', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'N', 'Y', 'Y', 'N', '', '', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id_log` int(11) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `browser` varchar(25) NOT NULL,
  `url` varchar(150) NOT NULL,
  `keterangan` tinytext NOT NULL,
  `tgl_akses` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`id_log`, `ip_address`, `browser`, `url`, `keterangan`, `tgl_akses`) VALUES
(1, '125.167.249.165', 'Safari', '/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2018-07-21 09:10:09'),
(2, '182.1.166.158', 'Safari', '/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2018-07-21 09:20:21'),
(3, '125.167.249.165', 'Safari', '/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2018-07-21 09:21:10'),
(4, '125.165.24.236', 'Safari', '/login', 'Percobaan login ke aplikasi sinadin dengan username <b>admin</b> dan password <b>pass</b> Gagal..!', '2018-07-21 10:02:20'),
(5, '125.167.249.165', 'Safari', '/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2018-07-21 10:21:44'),
(6, '125.167.249.165', 'Safari', '/login', 'Percobaan login ke aplikasi sinadin dengan username <b>baurtusetum1</b> dan password <b>pass</b> Gagal..!', '2018-07-21 10:28:12'),
(7, '125.167.249.165', 'Safari', '/login', 'User <b>baursetum</b> berhasil login ke aplikasi sinadin', '2018-07-21 10:28:30'),
(8, '125.167.249.165', 'Safari', '/login', 'User <b>kasetum</b> berhasil login ke aplikasi sinadin', '2018-07-21 10:38:02'),
(9, '125.167.249.165', 'Safari', '/login', 'Percobaan login ke aplikasi sinadin dengan username <b>baurtu1</b> dan password <b>pass</b> Gagal..!', '2018-07-21 10:38:47'),
(10, '125.167.249.165', 'Safari', '/login', 'Percobaan login ke aplikasi sinadin dengan username <b>baurtusetum1</b> dan password <b>pass</b> Gagal..!', '2018-07-21 10:39:15'),
(11, '125.167.249.165', 'Safari', '/login', 'User <b>baursetum</b> berhasil login ke aplikasi sinadin', '2018-07-21 10:39:51'),
(12, '125.167.249.165', 'Safari', '/login', 'User <b>kasetum</b> berhasil login ke aplikasi sinadin', '2018-07-21 10:43:28'),
(13, '125.167.249.165', 'Safari', '/login', 'User <b>KAURRENMIN SETUM</b> berhasil login ke aplikasi sinadin', '2018-07-21 10:48:28'),
(14, '125.167.249.165', 'Safari', '/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2018-07-21 10:54:10'),
(15, '125.167.249.165', 'Safari', '/login', 'User <b>kasetum</b> berhasil login ke aplikasi sinadin', '2018-07-21 10:54:20'),
(16, '125.167.249.165', 'Safari', '/login', 'Percobaan login ke aplikasi sinadin dengan username <b>admin</b> dan password <b>pass</b> Gagal..!', '2018-07-21 11:19:05'),
(17, '125.167.249.165', 'Safari', '/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2018-07-21 11:19:11'),
(18, '125.167.249.165', 'Safari', '/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2018-07-21 11:23:37'),
(19, '125.167.249.165', 'Safari', '/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2018-07-21 11:37:53'),
(20, '125.167.249.165', 'Safari', '/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2018-07-21 12:08:51'),
(21, '125.167.249.165', 'Safari', '/login', 'Percobaan login ke aplikasi sinadin dengan username <b>kasubbagsdm</b> dan password <b>pass</b> Gagal..!', '2018-07-21 12:15:52'),
(22, '125.167.249.165', 'Safari', '/login', 'User <b>KASUBBAGMIN RO SDM</b> berhasil login ke aplikasi sinadin', '2018-07-21 12:16:00'),
(23, '125.167.249.165', 'Safari', '/login', 'Percobaan login ke aplikasi sinadin dengan username <b>admin</b> dan password <b>pass</b> Gagal..!', '2018-07-21 12:20:39'),
(24, '125.167.249.165', 'Safari', '/login', 'Percobaan login ke aplikasi sinadin dengan username <b>kaurrenminsetum</b> dan password <b>pass</b> Gagal..!', '2018-07-21 12:21:12'),
(25, '125.167.249.165', 'Safari', '/login', 'User <b>KAURRENMIN SETUM</b> berhasil login ke aplikasi sinadin', '2018-07-21 12:21:30'),
(26, '125.167.249.165', 'Safari', '/login', 'User <b>kasetum</b> berhasil login ke aplikasi sinadin', '2018-07-21 12:22:03'),
(27, '125.167.249.165', 'Safari', '/login', 'Percobaan login ke aplikasi sinadin dengan username <b>kasubbagsdm</b> dan password <b>pass</b> Gagal..!', '2018-07-21 12:29:04'),
(28, '125.167.249.165', 'Safari', '/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2018-07-21 12:29:10'),
(29, '125.167.249.165', 'Safari', '/login', 'User <b>KAURRENMIN SETUM</b> berhasil login ke aplikasi sinadin', '2018-07-21 12:29:41'),
(30, '125.167.249.165', 'Safari', '/login', 'User <b>kasetum</b> berhasil login ke aplikasi sinadin', '2018-07-21 13:12:45'),
(31, '125.167.249.165', 'Safari', '/login', 'Percobaan login ke aplikasi sinadin dengan username <b>karo sdm</b> dan password <b>pass</b> Gagal..!', '2018-07-21 13:17:46'),
(32, '125.167.249.165', 'Safari', '/login', 'User <b>kasetum</b> berhasil login ke aplikasi sinadin', '2018-07-21 13:18:51'),
(33, '180.248.158.87', 'Safari', '/login', 'User <b>kasetum</b> berhasil login ke aplikasi sinadin', '2018-07-22 07:42:44'),
(34, '127.0.0.1', 'Safari', '/sinadin/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2018-08-20 17:59:21'),
(35, '127.0.0.1', 'Safari', '/sinadin/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2018-08-20 18:03:47'),
(36, '127.0.0.1', 'Safari', '/sinadin/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2018-09-28 09:06:54'),
(37, '127.0.0.1', 'Safari', '/sinadin/login', 'Percobaan login ke aplikasi sinadin dengan username <b>admin</b> dan password <b>pass</b> Gagal..!', '2018-12-03 12:00:23'),
(38, '127.0.0.1', 'Safari', '/sinadin/login', 'Percobaan login ke aplikasi sinadin dengan username <b>admin</b> dan password <b>pass</b> Gagal..!', '2018-12-03 12:00:29'),
(39, '127.0.0.1', 'Safari', '/sinadin/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2018-12-03 12:00:45'),
(40, '127.0.0.1', 'Safari', '/sinadin/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2019-01-01 13:15:01'),
(41, '127.0.0.1', 'Safari', '/sinadin/login', 'User <b>Administrator</b> berhasil login ke aplikasi sinadin', '2019-01-28 15:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `user_satker`
--

CREATE TABLE `user_satker` (
  `id_satker` int(11) NOT NULL,
  `nama_satker` varchar(200) NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_satker`
--

INSERT INTO `user_satker` (`id_satker`, `nama_satker`, `created`, `updated`) VALUES
(49, 'DITLANTAS', '2018-07-22 15:51:09', '2018-07-22 08:51:09'),
(48, 'DITSABHARA', '2018-07-22 15:51:03', '2018-07-22 08:51:03'),
(47, 'DITBINMAS', '2018-07-22 15:50:58', '2018-07-22 08:50:58'),
(46, 'DITRESNARKOBA', '2018-07-22 15:50:52', '2018-07-22 08:50:52'),
(45, 'DITRESKRIMSUS', '2018-07-22 15:50:44', '2018-07-22 08:50:45'),
(44, 'DITRESKRIMUM', '2018-07-22 15:50:39', '2018-07-22 08:50:39'),
(43, 'DITINTELKAM', '2018-07-22 15:50:34', '2018-07-22 08:50:34'),
(42, 'SPKT', '2018-07-22 15:50:29', '2018-07-22 08:50:29'),
(41, 'YANMA', '2018-07-22 15:50:25', '2018-07-22 08:50:25'),
(40, 'SETUM', '2018-07-22 15:50:19', '2018-07-22 08:50:19'),
(39, 'SPRIPIM', '2018-07-22 15:50:14', '2018-07-22 08:50:14'),
(38, 'BID TI POLRI', '2018-07-22 15:50:07', '2018-07-22 08:50:07'),
(37, 'BIDKUM', '2018-07-22 15:50:00', '2018-07-22 08:50:00'),
(57, 'RUMKIT BHAYANGKARA', '2018-07-22 15:52:15', '2018-07-22 08:52:16'),
(35, 'BIDPROPAM', '2018-07-22 15:49:48', '2018-07-22 08:49:48'),
(34, 'ROSARPRAS', '2018-07-22 15:49:42', '2018-07-22 08:49:42'),
(33, 'RO SDM', '2018-07-22 15:49:36', '2018-07-22 08:49:36'),
(32, 'RORENA', '2018-07-22 15:49:31', '2018-07-22 08:49:31'),
(31, 'ROOPS', '2018-07-22 15:49:25', '2018-07-22 08:49:25'),
(30, 'WAKAPOLDA KALTENG', '2018-07-22 15:49:18', '2018-07-22 08:49:18'),
(29, 'KAPOLDA KALTENG', '2018-07-22 15:49:13', '2018-07-22 08:49:13'),
(28, 'ITWASDA', '2018-07-22 15:49:02', '2018-07-22 08:49:02'),
(27, 'ICT', '2018-07-22 15:48:09', '2018-07-22 08:48:10'),
(50, 'DITPAMOBVIT', '2018-07-22 15:51:13', '2018-07-22 08:51:13'),
(51, 'DITPOLAIR', '2018-07-22 15:51:19', '2018-07-22 08:51:19'),
(52, 'DITTAHTI', '2018-07-22 15:51:25', '2018-07-22 08:51:25'),
(53, 'SPN', '2018-07-22 15:51:30', '2018-07-22 08:51:30'),
(54, 'BIDKEU', '2018-07-22 15:51:36', '2018-07-22 08:51:36'),
(55, 'BIDDOKKES', '2018-07-22 15:51:40', '2018-07-22 08:51:40'),
(56, 'BIDDOKKES', '2018-07-22 15:51:45', '2018-07-22 08:51:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arsip_file`
--
ALTER TABLE `arsip_file`
  ADD PRIMARY KEY (`id_arsip`);

--
-- Indexes for table `arsip_sk`
--
ALTER TABLE `arsip_sk`
  ADD PRIMARY KEY (`id_sk`);

--
-- Indexes for table `arsip_sk_kapolda`
--
ALTER TABLE `arsip_sk_kapolda`
  ADD PRIMARY KEY (`id_sk`);

--
-- Indexes for table `arsip_sm`
--
ALTER TABLE `arsip_sm`
  ADD PRIMARY KEY (`id_sm`);

--
-- Indexes for table `bagian`
--
ALTER TABLE `bagian`
  ADD PRIMARY KEY (`id_bag`);

--
-- Indexes for table `email_setting`
--
ALTER TABLE `email_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id_info`);

--
-- Indexes for table `klasifikasi`
--
ALTER TABLE `klasifikasi`
  ADD PRIMARY KEY (`id_klas`);

--
-- Indexes for table `klasifikasi_arsip`
--
ALTER TABLE `klasifikasi_arsip`
  ADD PRIMARY KEY (`id_klasifikasi`);

--
-- Indexes for table `klasifikasi_sk`
--
ALTER TABLE `klasifikasi_sk`
  ADD PRIMARY KEY (`id_klas`);

--
-- Indexes for table `kop_setting`
--
ALTER TABLE `kop_setting`
  ADD PRIMARY KEY (`idkop`);

--
-- Indexes for table `kop_variabel`
--
ALTER TABLE `kop_variabel`
  ADD PRIMARY KEY (`variabel`);

--
-- Indexes for table `memo`
--
ALTER TABLE `memo`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_surat`
--
ALTER TABLE `status_surat`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `surat_read`
--
ALTER TABLE `surat_read`
  ADD PRIMARY KEY (`id_sm`,`id_user`,`kode`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_jabatan`
--
ALTER TABLE `user_jabatan`
  ADD PRIMARY KEY (`id_jab`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `user_satker`
--
ALTER TABLE `user_satker`
  ADD PRIMARY KEY (`id_satker`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arsip_file`
--
ALTER TABLE `arsip_file`
  MODIFY `id_arsip` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `arsip_sk`
--
ALTER TABLE `arsip_sk`
  MODIFY `id_sk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `arsip_sk_kapolda`
--
ALTER TABLE `arsip_sk_kapolda`
  MODIFY `id_sk` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `arsip_sm`
--
ALTER TABLE `arsip_sm`
  MODIFY `id_sm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bagian`
--
ALTER TABLE `bagian`
  MODIFY `id_bag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `email_setting`
--
ALTER TABLE `email_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `klasifikasi`
--
ALTER TABLE `klasifikasi`
  MODIFY `id_klas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `klasifikasi_arsip`
--
ALTER TABLE `klasifikasi_arsip`
  MODIFY `id_klasifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `klasifikasi_sk`
--
ALTER TABLE `klasifikasi_sk`
  MODIFY `id_klas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `memo`
--
ALTER TABLE `memo`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `status_surat`
--
ALTER TABLE `status_surat`
  MODIFY `id_status` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `user_jabatan`
--
ALTER TABLE `user_jabatan`
  MODIFY `id_jab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;
--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `user_satker`
--
ALTER TABLE `user_satker`
  MODIFY `id_satker` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


