-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2024 at 03:39 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `data_konser`
--

-- --------------------------------------------------------

--
-- Table structure for table `artis`
--

CREATE TABLE `artis` (
  `ID_artis` int(11) NOT NULL,
  `nama_artis` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artis`
--

INSERT INTO `artis` (`ID_artis`, `nama_artis`) VALUES
(1, 'IU'),
(2, 'TVXQ'),
(3, 'Niall'),
(4, 'Lany'),
(5, 'RAN'),
(6, 'Yura Yunita'),
(7, 'JKT 48'),
(8, 'Kunto Aji'),
(9, 'Indra Lesmana'),
(10, 'Javier Parisi'),
(11, 'Tulus'),
(12, 'DERE'),
(13, 'Nadin Amizah'),
(14, 'Vierratale');

-- --------------------------------------------------------

--
-- Table structure for table `artis_konser`
--

CREATE TABLE `artis_konser` (
  `ID_artis_konser` int(11) NOT NULL,
  `ID_artis` int(11) NOT NULL,
  `ID_konser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artis_konser`
--

INSERT INTO `artis_konser` (`ID_artis_konser`, `ID_artis`, `ID_konser`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 6, 5),
(6, 7, 5),
(7, 8, 5),
(8, 9, 5),
(9, 10, 5),
(10, 11, 5),
(11, 12, 5),
(12, 13, 5);

-- --------------------------------------------------------

--
-- Table structure for table `konser`
--

CREATE TABLE `konser` (
  `ID_konser` int(11) NOT NULL,
  `nama_konser` varchar(100) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `venue` varchar(100) NOT NULL,
  `tanggal_awal` date NOT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `waktu` time NOT NULL,
  `deskripsi` text NOT NULL,
  `syarat` text DEFAULT NULL,
  `poster` varchar(255) NOT NULL,
  `seating_plan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konser`
--

INSERT INTO `konser` (`ID_konser`, `nama_konser`, `lokasi`, `venue`, `tanggal_awal`, `tanggal_akhir`, `waktu`, `deskripsi`, `syarat`, `poster`, `seating_plan`) VALUES
(1, 'IU H.E.R. World Tour', 'Jakarta', 'Indonesia Convention Exhibition (ICE) BSD Hall 5-6', '2024-04-27', '2024-04-28', '17:00:00', 'Lee Ji-eun, also known by her stage name IU, is a South Korean singer, songwriter, philanthropist, and actress. Her stage name IU, mean \"I and You become one through music.” IU is also loved by fans worldwide for her performance as an actress in dramas such as \"Moon Lovers: Scarlet Heart Ryeo,\" \"Hotel Del Luna,\" and \"My Mister.”\r\n\r\nShe debuted as a singer at the age of fifteen with Lost and Found (2008). She achieved national stardom after the release of \"Good Day\", the lead single from her 2010 album “Real”. After releasing five studio albums, ten extended plays (EPs), 47 singles (including 19 as featured artist), five single albums, two remake albums and two compilation albums, IU successful in maintaining her dominance in Korean music charts and further brace her nickname as Korea\'s \"little sister.\" She is now known as \"The Nation\'s Sweetheart\".\r\n\r\nNow she\'s finally comeback for【2024 IU H.E.R. WORLD TOUR CONCERT】IN JAKARTA! Let’s get ready to witness her amazing performance and make unforgettable memories.', 'Tiket hanya dapat dibeli melalui iuinjakarta2024.com. Tiket hanya dapat digunakan untuk masuk ke acara konser【2024 IU H.E.R. WORLD TOUR CONCERT】DI JAKARTA.\r\nNama sesuai dengan kartu identitas yang sah bersifat wajib untuk membeli Tiket ke konser【2024 IU H.E.R. WORLD TOUR CONCERT】DI JAKARTA. Pastikan Anda melakukan pembelian tiket dengan menggunakan data Anda yang sah dan benar (Kartu Identitas/Kartu Pelajar/KTP/KK/SIM/Paspor). Tiket Anda tidak dapat di ubah dan/atau dimodifikasi setelah pembelian sudah dilakukan.\r\n1 (Satu) akun hanya dapat membeli maksimum 4 (empat) tiket per transaksi. Akun dengan NIK, alamat email dan nomor telepon yang sama tidak bisa melakukan pembelian berulang.\r\nHarga Tiket tidak termasuk Pajak Pemerintah yang berlaku and Biaya Layanan lainnya.\r\nSetelah Anda berhasil melakukan pembelian tiket, E-Ticket akan dikirimkan ke email Anda. H-7 sebelum konser dimulai, seat number akan muncul di E-Ticket yang telah Anda dapatkan sebelumnya. Anda perlu me-refresh link E-Ticket sebelumnya. Nomor kursi akan di generate oleh sistem.', 'poster_IU.jpg', 'seating_plan_IU.jpg'),
(2, 'TVXQ! Concert [20&2]', 'Jakarta', 'ICE BSD Hall 5', '2024-04-20', NULL, '15:00:00', 'Ini bukanlah hal yang pertama bagi TVXQ untuk menggelar konser di Indonesia. Pelantun “Mirotic” tersebut telah menggelar konser bertajuk \"TVXQ! Concert - Circle - #with in Jakarta\" pada 31 Agustus 2019 di ICE BSD, Tangerang, dan ikut memeriahkan konser SMTOWN di Gelora Bung Karno, Jakarta, pada September 2023 lalu. \r\n\r\nKonser-konser ini selalu menjadi momen yang sangat dinanti oleh penggemar TVXQ di Indonesia. Kehadiran TVXQ di Jakarta pada 2024 mendatang tentu menjadi kabar yang menggembirakan bagi Cassiopeia. \r\n\r\nJadi, apakah kamu sudah siap untuk menyanyikan lagu-lagu TVXQ favoritmu? Ayo bersiap-siap untuk merayakan momen spesial bersama TVXQ!', 'Seluruh harga tiket sudah termasuk pajak, kecuali admin/ticket processing fee (sesuai yang berlaku dari Mecimashop.com dan Tiket.com).\r\nUntuk informasi lebih lanjut, silakan mengacu kepada Mecimashop.com dan Tiket.com sebagai Official Ticketing Partner acara ini.\r\nMohon perhatikan syarat dan ketentuan pembelian tiket yang ditetapkan oleh Official Ticketing Partner. Pihak penyelenggara tidak bertanggung jawab atas segala bentuk pelanggaran dari ketentuan pembelian tiket.\r\nMohon untuk tidak membeli tiket dari pihak lain selain Official Ticketing Partner yang sudah ditunjuk. Pihak penyelenggara tidak bertanggung jawab atas segala bentuk penipuan tiket yang dibeli di pihak lain.\r\nSeluruh pemegang tiket harus mengikuti syarat dan ketentuan yang telah tertulis pada tiket dan juga syarat dan ketentuan acara yang telah ditentukan oleh pihak penyelenggara.\r\nUntuk syarat dan ketentuan acara, silakan kunjungi: bit.ly/tvxq2on2jkt_tnc.', 'poster_TVXQ.jpg', 'seating_plan_TVXQ.jpg'),
(3, 'Niall Horan The Show Live on Tour', 'Jakarta', 'Beach City International Stadium', '2024-05-11', NULL, '19:00:00', 'Jakarta, 12 October 2023 - The chart-topping global superstar Niall Horan has announced the following tour called “THE SHOW LIVE ON TOUR\" – his biggest tour yet and first headline run since 2018’s Flicker World Tour. Niall Horan will be adding new dates in Asia and will be performing in Jakarta on Saturday, 11 May 2024 at Beach City International Stadium. \r\n\r\nTickets will be available starting with an Artist Presale starting Monday, 16 October 2023 from 14:00 to 23:59 Jakarta time. Public On-sale will be available starting Wednesday, 18 October 2023 at 14:00 Jakarta time only at niallhoranjakarta.com \r\n\r\nGet your tickets earlier by subscribing to Niall Horan’s newsletter on niallhoran.com before Sunday, 15 October 2023 at 23:59 Jakarta time to receive the code.', 'Tickets can only be purchased through NiallHoranJakarta.com. Tickets are only for admission to Niall Horan The Show Live on Tour.\r\nName in accordance with a valid ID Card is required to purchase tickets to Niall Horan The Show Live on Tour. Make sure to buy tickets using your valid and correct data (ID Card/KK/KTP/SIM/Passport). Your ticket(s) cannot be changed and/or modified once the purchase has been made.\r\nTicket Buyer is any person who makes a ticket purchase in accordance with these Terms & Conditions. Ticket Holder is every person who owns/controls a ticket to enter the event location on the date of the event. 1 (one) ticket is valid for 1 (one) Ticket Holder for 1 (one) entry to the event location.', 'poster_Niall.jpg', 'seating_plan_Niall.jpg'),
(4, 'LANY a beautiful blur: the world tour / asia 2024', 'Jakarta', 'Beach City Stadium', '2024-10-09', '2024-10-10', '19:00:00', 'LANY have quietly cracked the mainstream on their own terms as one of the most ubiquitous, unpredictable, and undeniable alternative rock bands of this era. Tallying billions of streams, selling out legendary arenas, and earning widespread critical acclaim, the platinum-certified Los Angeles group consistently deliver rafter- reaching anthems anchored by airtight songcraft and the outsized personality of enigmatic frontman and songwriter Paul Jason Klein. Thus far, they’ve earned four gold singles—“Malibu Nights,” “Super Far,” “I Quit Drinking” [with Kelsea Ballerini], and “Mean It” [with Lauv]—in addition to scoring platinum status with “ILYSB.” Nominated for “Best Pop Tour” by Pollstar, their energetic, entrancing, and ever-evolving live show continues to captivate fans on multiple continents as a huge draw worldwide. This summer, the band canvased Asia on their First The Moon, Then The Stars: A Tour Before A World Tour which included festival headline slots at the iconic Summer Sonic Festivals in Tokyo and Osaka, and Bangkoks Sonic Bang Festival.\r\n\r\nTheir most recent album, a beautiful blur, is their fifth studio album and the first to be released independently by the band. a beautiful blur debuted at #2 on Billboard’s Current Rock Albums chart, as well as #3 on their Current Alternative Albums chart, and was a TOP 5 Album in Australia, debuting at #4 on ARIA’s charts. Standout single “XXL” exploded on social media and earned performances from the band on the TODAY Show and Jimmy Kimmel Live! To celebrate the album’s triumphant release, the band hosted four acoustic pop-up events across the US, giving fans a chance to see the band in a once-in-a-lifetime intimate environment. This fall, LANY will take a beautiful blur on the road, touring Europe followed by North America and the rest of the world in the new year. LANY’s next chapter has just begun.', 'The Organiser/Venue Owner reserves the right without refund or compensation to refuse admission/evict any person(s) whose conduct is disorderly or inappropriate or who poses a threat to security, or to the enjoyment of the Event by others.\r\nTicket holders assume all risk of injury and all responsibility for property loss, destruction or theft and release the promoters, performers, sponsors, ticket outlets, venues, and their employees from any liability thereafter.\r\nThe resale of ticket(s) at the same or any price in excess of the initial purchase price is prohibited.\r\nThere is no refund, exchange, upgrade, or cancellation once ticket(s) are sold.\r\nWe would like to caution members of the public against purchasing tickets from unauthorized sellers or 3rd party websites. By purchasing tickets through these non-authorized points of sale, buyers take on the risk that the validity of the tickets cannot be guaranteed, with no refunds possible.', 'poster_lany.jpg', 'seating_plan_lany.jpg'),
(5, 'Prambanan Jazz', 'Yogyakarta', 'Pelataran Candi Prambanan', '2024-07-05', '2024-07-07', '15:00:00', 'Immerse yourself in a weekend to be etched in the hearts of jazz enthusiasts at Prambanan Jazz 2024 #SatuDekadeBersama. Join in the harmonious melodies as you sing along with the illustrious lineup featuring Maliq & D Essentials, Kahitna, Tulus, and other incredible artists yet to be revealed. From July 5th to 7th, 2024, revel in the magic of jazz against the breathtaking setting of the Prambanan temple!', 'Show or scan the Traveloka voucher on your phone at the ticket booth to receive a wristband. \r\n Please adjust the brightness of your mobile phone screen before scanning the QR code on your voucher. Only your Traveloka voucher is valid. \r\n Your payment receipt or proof of payment may not be used to enter. Redeem in ticket booth at the east parking lot of Prambanan Temple', 'poster_prambanan.jpg', 'seating_plan_prambanan.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `kursi`
--

CREATE TABLE `kursi` (
  `ID_kursi` int(11) NOT NULL,
  `ID_konser` int(11) NOT NULL,
  `nama_kursi` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kursi`
--

INSERT INTO `kursi` (`ID_kursi`, `ID_konser`, `nama_kursi`, `tanggal`, `harga`, `stok`) VALUES
(1, 1, 'CAT 1A', '2024-04-27', 2900000, 0),
(2, 1, 'CAT 1B', '2024-04-27', 2900000, 0),
(3, 1, 'CAT 2A', '2024-04-27', 2700000, 0),
(4, 1, 'CAT 2B', '2024-04-27', 2700000, 0),
(5, 1, 'CAT 2C', '2024-04-27', 2700000, 0),
(6, 1, 'CAT 3A', '2024-04-27', 1900000, 0),
(7, 1, 'CAT 3B', '2024-04-27', 1900000, 0),
(8, 1, 'CAT 3C', '2024-04-27', 1900000, 0),
(9, 1, 'CAT 4A', '2024-04-27', 1500000, 0),
(10, 1, 'CAT 4B', '2024-04-27', 1500000, 0),
(11, 1, 'CAT 5A', '2024-04-27', 1100000, 0),
(12, 1, 'CAT 5B', '2024-04-27', 1100000, 0),
(13, 1, 'CAT 1A', '2024-04-28', 2900000, 0),
(14, 1, 'CAT 1B', '2024-04-28', 2900000, 0),
(15, 1, 'CAT 2A', '2024-04-28', 2700000, 0),
(16, 1, 'CAT 2B', '2024-04-28', 2700000, 0),
(17, 1, 'CAT 2C', '2024-04-28', 2700000, 0),
(18, 1, 'CAT 3A', '2024-04-28', 1900000, 0),
(19, 1, 'CAT 3B', '2024-04-28', 1900000, 0),
(20, 1, 'CAT 3C', '2024-04-28', 1900000, 0),
(21, 1, 'CAT 4A', '2024-04-28', 1500000, 0),
(22, 1, 'CAT 4B', '2024-04-28', 1500000, 0),
(23, 1, 'CAT 5A', '2024-04-28', 1100000, 0),
(24, 1, 'CAT 5B', '2024-04-28', 1100000, 0),
(25, 2, 'Blue Soundcheck Package', '2024-04-20', 3500000, 0),
(26, 2, 'Blue', '2024-04-20', 2900000, 0),
(27, 2, 'Green', '2024-04-20', 2400000, 0),
(28, 2, 'Yellow', '2024-04-20', 1900000, 0),
(29, 2, 'Pink', '2024-04-20', 2600000, 0),
(30, 2, 'Grey', '2024-04-20', 1400000, 0),
(31, 3, 'Festival 1 (free standing)', '2024-05-11', 2000000, 0),
(32, 3, 'Festival 2 (free standing)', '2024-05-11', 1800000, 0),
(33, 3, 'CAT 1 (numbered seating)', '2024-05-11', 1600000, 0),
(34, 3, 'CAT 2 (numbered seating)', '2024-05-11', 1400000, 0),
(35, 3, 'CAT 3 (numbered seating)', '2024-05-11', 1200000, 0),
(36, 3, 'CAT 1 (numbered seating)', '2024-05-11', 1600000, 0),
(37, 4, 'Star Club', '2024-10-10', 6650000, 8),
(38, 4, 'Early Entry', '2024-10-10', 2800000, 11),
(39, 4, 'The Blur', '2024-10-10', 3500000, 27),
(40, 4, 'Blue', '2024-10-10', 1950000, 31),
(41, 4, 'Purple', '2024-10-10', 1750000, 43),
(42, 4, 'Festival', '2024-10-10', 1650000, 68),
(43, 4, 'Orange', '2024-10-10', 1550000, 85),
(44, 4, 'Star Club', '2024-10-09', 6650000, 0),
(45, 4, 'Early Entry', '2024-10-09', 2800000, 0),
(46, 4, 'The Blur', '2024-10-09', 3500000, 0),
(47, 4, 'Blue', '2024-10-09', 1950000, 0),
(48, 4, 'Purple', '2024-10-09', 1750000, 0),
(49, 4, 'Festival', '2024-10-09', 1650000, 0),
(50, 4, 'Orange', '2024-10-09', 1550000, 0),
(51, 5, 'Tiket Reguler - Festival', '2024-07-05', 402500, 94),
(52, 5, 'Tiket Reguler - Super Festival', '2024-07-05', 575000, 83),
(54, 5, 'Tiket Reguler - Festival', '2024-07-06', 402500, 73),
(55, 5, 'Tiket Reguler - Super Festival', '2024-07-06', 575000, 72),
(56, 5, '(Presale 1) Gold Special Show', '2024-07-06', 1080000, 23),
(57, 5, '(Presale 1) Diamond Special Show', '2024-07-06', 3000000, 15),
(58, 5, '(Presale 1) VIP Special Show', '2024-07-06', 6000000, 12),
(59, 5, 'Tiket Reguler - Festival', '2024-07-07', 402500, 52),
(60, 5, '(Presale 1) Gold Special Show', '2024-07-07', 540000, 28),
(61, 5, '(Presale 1) Diamond Special Show', '2024-07-07', 900000, 13),
(62, 5, '(Presale 1) VIP Special Show', '2024-07-07', 1200000, 9);

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `ID_pemesanan` int(11) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `ID_konser` int(11) NOT NULL,
  `ID_kursi` int(11) NOT NULL,
  `total_pembayaran` int(11) NOT NULL,
  `jenis_pembayaran` enum('Virtual Account','QRIS','Gopay','OVO','Dana') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tiket`
--

CREATE TABLE `tiket` (
  `ID_tiket` int(11) NOT NULL,
  `ID_pemesanan` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artis`
--
ALTER TABLE `artis`
  ADD PRIMARY KEY (`ID_artis`);

--
-- Indexes for table `artis_konser`
--
ALTER TABLE `artis_konser`
  ADD PRIMARY KEY (`ID_artis_konser`),
  ADD KEY `ID_artis` (`ID_artis`),
  ADD KEY `ID_konser` (`ID_konser`);

--
-- Indexes for table `konser`
--
ALTER TABLE `konser`
  ADD PRIMARY KEY (`ID_konser`);

--
-- Indexes for table `kursi`
--
ALTER TABLE `kursi`
  ADD PRIMARY KEY (`ID_kursi`),
  ADD KEY `ID_konser` (`ID_konser`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`ID_pemesanan`),
  ADD KEY `ID_user` (`ID_user`),
  ADD KEY `ID_konser` (`ID_konser`),
  ADD KEY `ID_kursi` (`ID_kursi`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`ID_tiket`),
  ADD KEY `ID_pemesanan` (`ID_pemesanan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artis`
--
ALTER TABLE `artis`
  MODIFY `ID_artis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `artis_konser`
--
ALTER TABLE `artis_konser`
  MODIFY `ID_artis_konser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `konser`
--
ALTER TABLE `konser`
  MODIFY `ID_konser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kursi`
--
ALTER TABLE `kursi`
  MODIFY `ID_kursi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `ID_pemesanan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `ID_tiket` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artis_konser`
--
ALTER TABLE `artis_konser`
  ADD CONSTRAINT `artis_konser_ibfk_1` FOREIGN KEY (`ID_artis`) REFERENCES `artis` (`ID_artis`),
  ADD CONSTRAINT `artis_konser_ibfk_2` FOREIGN KEY (`ID_konser`) REFERENCES `konser` (`ID_konser`);

--
-- Constraints for table `kursi`
--
ALTER TABLE `kursi`
  ADD CONSTRAINT `kursi_ibfk_1` FOREIGN KEY (`ID_konser`) REFERENCES `konser` (`ID_konser`);

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `user` (`ID_user`),
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`ID_konser`) REFERENCES `konser` (`ID_konser`),
  ADD CONSTRAINT `pemesanan_ibfk_3` FOREIGN KEY (`ID_kursi`) REFERENCES `kursi` (`ID_kursi`);

--
-- Constraints for table `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `tiket_ibfk_1` FOREIGN KEY (`ID_pemesanan`) REFERENCES `pemesanan` (`ID_pemesanan`);
COMMIT; 

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
