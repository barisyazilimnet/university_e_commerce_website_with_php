-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 01 Haz 2021, 23:53:14
-- Sunucu sürümü: 10.4.18-MariaDB
-- PHP Sürümü: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `goksun_myo`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_order` varchar(3) NOT NULL,
  `category_name` varchar(2000) NOT NULL,
  `category_visibility` varchar(1) NOT NULL,
  `adding` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`category_id`, `category_order`, `category_name`, `category_visibility`, `adding`, `date`) VALUES
(5, '5', 'Elbiseler', '1', 'GameMaster', '2021-03-24 10:52:07'),
(6, '6', 'Takılar', '1', 'GameMaster', '2021-03-24 10:52:30'),
(7, '7', 'Şapkalar', '1', 'GameMaster', '2021-03-24 10:52:44'),
(8, '1', 'Spor Giyim', '1', 'GameMaster', '2021-03-31 14:53:54');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mails`
--

CREATE TABLE `mails` (
  `mail_id` int(7) NOT NULL,
  `mail_sender` varchar(3000) NOT NULL,
  `mail_subject` varchar(2000) NOT NULL,
  `mail_content` text NOT NULL,
  `mail_receiver` varchar(3000) NOT NULL,
  `reading` varchar(7) NOT NULL,
  `mail_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `mails`
--

INSERT INTO `mails` (`mail_id`, `mail_sender`, `mail_subject`, `mail_content`, `mail_receiver`, `reading`, `mail_date`) VALUES
(1, 'sem', 'Admin paneli', '<b>Merhaba Arkadaşlar,</b>\r\n<p>Admin panelimizi geliştirmemiz lazım.Bu konu hakkında düşünceleriniz nelerdir?</p>\r\n<p>Yeni tarayıcılarda kullanılabilir hale getirmemiz lazım. Php, html, mysql, cssin yeni sürümleri çıktı ona göre bizde kodlarımızı yenilememiz lazım</p>\r\n<p>Bu konu hakkındaki düşüncelerinizi maili cevaplayarak benimle paylaşırsanız sevinirim.</p>\r\n<p>İyi çalışmalar.</p>\r\n', 'GameMaster', 'Okundu', '2020-12-23 23:44:34'),
(2, 'GameMaster', 'merhaba', '<p>merhaba iyi günler</p>', 'shnbsra', '', '2020-12-25 09:54:19'),
(4, 'shnbsra', 'merhaba', '<p>merhaba iyi günler barış nasılsın</p>\r\n\r\n', 'GameMaster', 'Okundu', '2020-12-25 23:28:58'),
(5, 'shnbsra', 'merhabayine ben', '<p>merhabayine benmerhabayine benmerhabayine benmerhabayine benmerhabayine benmerhabayine ben<br></p><p>merhabayine benmerhabayine benmerhabayine benmerhabayine ben<br></p>', 'GameMaster', 'Okundu', '2020-12-26 01:08:15'),
(6, 'shnbsra', 'merhabayine ben ya ben anlamıyorsun', '<p>merhabayine ben ya ben anlamıyorsunmerhabayine ben ya ben anlamıyorsunmerhabayine ben ya ben anlamıyorsunmerhabayine ben ya ben anlamıyorsunmerhabayine ben ya ben anlamıyorsunmerhabayine ben ya ben anlamıyorsunmerhabayine ben ya ben anlamıyorsunmerhabayine ben ya ben anlamıyorsunmerhabayine ben ya ben anlamıyorsunmerhabayine ben ya ben anlamıyorsun<br></p><p>merhabayine ben ya ben anlamıyorsunmerhabayine ben ya ben anlamıyorsunmerhabayine ben ya ben anlamıyorsun<br></p><p>merhabayine ben ya ben anlamıyorsun<br></p><p><br></p><p>vmerhabayine ben ya ben anlamıyorsun</p><p>merhabayine ben ya ben anlamıyorsunmerhabayine ben ya ben anlamıyorsunv<br></p>', 'GameMaster', 'Okundu', '2020-12-26 01:11:35'),
(7, 'GameMaster', 'merhabayine ben ya ben anlamıyorsun', '<p>asdasdadasdaads</p>', 'sem', '', '2020-12-27 15:28:39'),
(8, 'GameMaster', 'merhabayine ben ya ben anlamıyorsun', '', 'sem', '', '2021-03-31 23:50:43'),
(9, 'GameMaster', 'merhabayine ben', '<p>lj</p>', 'sem', '', '2021-03-31 23:51:45'),
(10, 'GameMaster', 'merhabayine ben', '<p>ads</p>', 'sem', '', '2021-03-31 23:52:47'),
(11, 'GameMaster', 'merhabayine ben', '', 'sem', '', '2021-03-31 23:53:11');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(3000) NOT NULL,
  `photo` text NOT NULL,
  `stock_information` varchar(1) NOT NULL,
  `price` float NOT NULL,
  `detail` text NOT NULL,
  `adding` varchar(3000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `photo`, `stock_information`, `price`, `detail`, `adding`, `date`) VALUES
(1, 5, 'Elbise', 'elbise_photo_160648ee7b2e2d.jpg', '1', 99.99, 'stok bilgisi', 'GameMaster', '2021-03-31 15:01:59'),
(3, 5, 'Elbise', 'elbise_photo_160648ee7b2e2d.jpg', '1', 99.99, 'stok bilgisi', 'GameMaster', '2021-03-31 15:01:59'),
(4, 5, 'Elbise', 'elbise_photo_160648ee7b2e2d.jpg', '1', 99.99, 'stok bilgisi', 'GameMaster', '2021-03-31 15:01:59'),
(5, 5, 'Elbise', 'elbise_photo_160648ee7b2e2d.jpg', '1', 99.99, 'stok bilgisi', 'GameMaster', '2021-03-31 15:01:59');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` int(1) NOT NULL,
  `site_url` varchar(1000) NOT NULL,
  `site_logo` text NOT NULL,
  `site_title_icon` text NOT NULL,
  `site_title` varchar(100) NOT NULL,
  `site_description` text NOT NULL,
  `site_keywords` varchar(1000) NOT NULL,
  `site_status` varchar(1) NOT NULL,
  `site_theme` varchar(10) NOT NULL,
  `site_phone_number` varchar(20) NOT NULL,
  `site_email` varchar(150) NOT NULL,
  `site_facebook` text NOT NULL,
  `site_twitter` text NOT NULL,
  `site_linkedin` text NOT NULL,
  `site_instagram` text NOT NULL,
  `site_pinterest` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `site_url`, `site_logo`, `site_title_icon`, `site_title`, `site_description`, `site_keywords`, `site_status`, `site_theme`, `site_phone_number`, `site_email`, `site_facebook`, `site_twitter`, `site_linkedin`, `site_instagram`, `site_pinterest`) VALUES
(1, 'http://localhost', '', 'site_title_icon_160602b89034c3.png', 'BK Yazılım', 'Kahramanmaraş Sütçü İmam Üniversitesinde bir meslek yüksekokuludur.', 'Eğitim, Meslek, Bilgisayar Bölümü, Paramedik Bölüm, Banka ve Sigortacılık Bölümü.', '1', '0', '05324973873', 'kurt-bar07@hotmail.com', 'https://www.facebook.com/kurt.baris07/', 'https://twitter.com/Barkurt14443348', 'https://www.linkedin.com/in/bar%C4%B1%C5%9F-kurt-31ba65201/', 'https://www.instagram.com/kurtbar07/', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `slider`
--

CREATE TABLE `slider` (
  `slider_id` int(5) NOT NULL,
  `slider_top_header` varchar(200) CHARACTER SET utf8 NOT NULL,
  `slider_bottom_header` varchar(200) CHARACTER SET utf8 NOT NULL,
  `slider_description` varchar(3000) CHARACTER SET utf8 NOT NULL,
  `slider_buy_link` text CHARACTER SET utf8 NOT NULL,
  `slider_photo` text CHARACTER SET utf8 NOT NULL,
  `slider_price_photo` text CHARACTER SET utf8 NOT NULL,
  `slider_adding` varchar(300) CHARACTER SET utf8 NOT NULL,
  `slider_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `slider`
--

INSERT INTO `slider` (`slider_id`, `slider_top_header`, `slider_bottom_header`, `slider_description`, `slider_buy_link`, `slider_photo`, `slider_price_photo`, `slider_adding`, `slider_date`) VALUES
(20, 'ŞOK ŞOK ŞOK ŞOK ŞOK', 'Büyük Kampanya', 'Bütün ürünler indirimde', 'link', 'slider_photo_160606a112602e.jpg', 'slider_price_photo_160606a112734e.png', 'GameMaster', '2021-03-28 11:35:45'),
(21, 'ŞOK ŞOK ŞOK', 'Çok Büyük Kampanya', 'Bütün elbiseler %50', 'link', 'slider_photo_160607b811ac12.jpg', 'slider_price_photo_160607b811ade1.png', 'GameMaster', '2021-03-28 12:50:09');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `system_archives`
--

CREATE TABLE `system_archives` (
  `id` int(11) NOT NULL,
  `description` varchar(3000) NOT NULL,
  `made_transaction` varchar(1000) NOT NULL,
  `do_transactions` varchar(100) NOT NULL,
  `transaction_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `system_archives`
--

INSERT INTO `system_archives` (`id`, `description`, `made_transaction`, `do_transactions`, `transaction_date`) VALUES
(1, 'shnbusraadında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-11-13 01:34:31'),
(2, 'shnbusra adında yeni bir kayıt silindi', 'Üye Silindi', 'kurtbar07', '2020-11-13 01:37:12'),
(3, 'localhost2 adlı kullancının kaydı güncellendi', 'Üye Güncellendi', 'kurtbar07', '2020-11-13 01:42:39'),
(4, 'localhost2 adlı kullanıcının kaydı silindi', 'Üye Silindi', 'kurtbar07', '2020-11-13 16:48:55'),
(5, 'whoIam adlı kullanıcının kaydı silindi', 'Üye Silindi', 'kurtbar07', '2020-11-13 16:52:01'),
(6, 'admin adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-11-13 16:52:50'),
(7, 'admin adlı kullancının kaydı güncellendi', 'Üye Güncellendi', 'kurtbar07', '2020-11-13 16:52:59'),
(8, 'asd12 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-11-13 16:55:11'),
(9, 'admin adlı kullanıcının kaydı silindi', 'Üye Silindi', 'kurtbar07', '2020-11-13 19:11:35'),
(10, 'shnbusra adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-11-13 19:12:36'),
(11, 'whoIam adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-11-13 19:12:52'),
(12, 'semih adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-11-13 19:16:22'),
(13, 'whoIam adlı kullanıcının kaydı silindi', 'Üye Silindi', 'kurtbar07', '2020-11-13 19:16:56'),
(14, 'semih adlı kullanıcının kaydı silindi', 'Üye Silindi', 'kurtbar07', '2020-11-13 19:25:07'),
(15, 'shnbusra adlı kullanıcının kaydı silindi', 'Üye Silindi', 'kurtbar07', '2020-11-24 15:30:23'),
(16, 'Kurtbar adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-11-25 00:45:11'),
(17, 'Kurtbar adlı kullancının kaydı güncellendi', 'Üye Güncellendi', 'kurtbar07', '2020-11-25 00:45:21'),
(18, 'kurtbar07 adlı kullanıcının kaydı silindi', 'Üye Silindi', 'kurtbar07', '2020-12-13 19:09:52'),
(19, 'Site ayarları güncellendi', 'Üye Güncellendi', 'kurtbar07', '2020-12-13 21:14:52'),
(20, 'semih adlı kullanıcının kaydı silindi', 'Üye Silindi', 'kurtbar07', '2020-12-19 13:46:23'),
(21, 'asd adlı kullanıcının kaydı silindi', 'Üye Silindi', 'kurtbar', '2020-12-20 02:08:31'),
(22, 'kurtbar0756 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-20 20:38:58'),
(23, 'kurtbar0756 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-20 20:48:07'),
(24, 'kurtbar0756 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-20 21:42:04'),
(25, 'asd adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-20 22:02:20'),
(26, 'kurtbar07kj adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-20 22:04:45'),
(27, 'kurtbar076516 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-20 22:08:41'),
(28, 'asdadasd adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-20 22:10:19'),
(29, 'kurtbar0756 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-20 22:11:06'),
(30, 'asd adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-20 22:12:34'),
(31, 'İbrahım adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-20 23:59:02'),
(32, 'asdasdasd adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 00:02:03'),
(33, 'asdgdfgfh adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 00:03:58'),
(34, 'kurtbar0756asd adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 03:45:16'),
(35, 'asd5a165sd adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 12:56:11'),
(36, 'asdasdsdvmsldv adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 14:51:42'),
(37, 'asdasdsvsdlvdsl adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 14:54:44'),
(38, '5164948236 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 14:55:41'),
(39, '516511655612 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 14:58:21'),
(40, '1343546456 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 14:58:49'),
(41, '987465321 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 15:09:56'),
(42, '18256 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 15:11:01'),
(43, '841 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 15:12:49'),
(44, '1 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 15:16:30'),
(45, '6 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 16:06:19'),
(48, 'kurtbar0756 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 16:58:11'),
(49, 'kurtbar0756 adlı kullanıcının kaydı silindi', 'Üye Silindi', 'kurtbar07', '2020-12-21 16:58:26'),
(50, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'kurtbar07', '2020-12-21 21:45:34'),
(51, 'kurtbar0756 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'kurtbar07', '2020-12-21 22:10:30'),
(52, 'kurtbar0756 adlı kullancının kaydı güncellendi', 'Üye Güncellendi', 'kurtbar07', '2020-12-21 22:23:34'),
(53, 'kurtbar07 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 02:46:20'),
(54, 'kurtbar0756asd adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 02:49:41'),
(55, 'kurtbar07 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 04:07:41'),
(56, 'shnbsra adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 04:10:19'),
(57, 'shnbsra adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 04:26:46'),
(58, 'shnbsra adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 04:28:43'),
(59, 'shnbsra adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 04:38:58'),
(60, 'shnbsra adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 04:50:50'),
(61, 'asd adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 04:52:05'),
(62, 'asdasd adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 04:52:48'),
(63, 'shnbsra adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 04:59:59'),
(64, 'kurtbar0756 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 05:02:19'),
(65, 'shnbsra adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 05:12:18'),
(66, 'shnbsra adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 05:13:25'),
(67, 'kurtbar07kj adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 16:03:01'),
(68, 'furkan61 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 17:51:32'),
(69, 'furkan61 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 18:02:36'),
(70, 'furkan61 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 18:05:55'),
(71, 'sem adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-22 23:45:29'),
(72, 'furkan61 adlı kullancının kaydı güncellendi', 'Üye Güncellendi', 'GameMaster', '2020-12-22 23:53:26'),
(73, 'sem adlı kullancının kaydı güncellendi', 'Üye Güncellendi', 'GameMaster', '2020-12-23 03:03:59'),
(74, 'sem adlı kullancının kaydı güncellendi', 'Üye Güncellendi', 'GameMaster', '2020-12-23 03:04:50'),
(76, 'sem adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-23 03:20:12'),
(77, 'sem adlı kullanıcının kaydı silindi', 'Üye Silindi', '', '2020-12-23 03:21:17'),
(78, 'sem adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-23 03:23:09'),
(79, 'sem adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2020-12-23 03:23:22'),
(80, 'shnbsra adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-23 03:25:44'),
(81, 'sem adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-23 03:27:03'),
(82, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2020-12-23 19:07:36'),
(83, 'asd adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-23 21:25:18'),
(84, 'asd adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2020-12-23 22:52:49'),
(85, 'GameMaster07 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-23 23:43:30'),
(86, 'kurtbar0756 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-23 23:45:41'),
(87, 'kurtbar0756 adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2020-12-23 23:51:00'),
(88, 'kurtbar0756 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-23 23:51:20'),
(89, 'kurtbar0756 adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2020-12-23 23:52:09'),
(90, 'asd adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-23 23:52:25'),
(91, 'asd adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2020-12-23 23:53:14'),
(92, 'kurtbar0756 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-23 23:53:29'),
(93, 'kurtbar0756 adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2020-12-23 23:54:35'),
(94, 'asd adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-24 00:42:54'),
(95, 'asd adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2020-12-25 10:40:49'),
(96, 'asd adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2020-12-25 10:41:08'),
(97, 'shnbsra adlı kullancının kaydı güncellendi', 'Üye Güncellendi', 'GameMaster', '2020-12-27 00:32:02'),
(98, 'sem adlı kullancının kaydı güncellendi', 'Üye Güncellendi', 'GameMaster', '2020-12-27 00:52:33'),
(99, 'asdasdasd adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2020-12-27 01:05:10'),
(100, 'asd asdf asd adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2020-12-27 01:12:21'),
(101, 'shnbsra adlı kullancının kaydı güncellendi', 'Üye Güncellendi', 'GameMaster', '2020-12-29 23:10:14'),
(102, 'sem adlı kullancının kaydı güncellendi', 'Üye Güncellendi', 'GameMaster', '2020-12-30 00:22:12'),
(103, 'asd adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2021-01-05 13:47:01'),
(104, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-23 10:44:22'),
(105, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-23 10:46:27'),
(106, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-23 10:48:37'),
(107, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-23 10:51:46'),
(108, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-23 10:52:54'),
(109, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-23 10:54:07'),
(110, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 11:10:09'),
(111, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 11:14:06'),
(112, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 11:15:35'),
(113, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 11:16:17'),
(114, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 11:17:35'),
(115, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-23 11:21:56'),
(116, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 11:22:08'),
(117, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 11:23:11'),
(118, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 11:24:14'),
(119, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 11:29:01'),
(120, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 11:42:15'),
(121, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 11:44:14'),
(122, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 12:05:56'),
(123, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 12:30:35'),
(124, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 12:59:00'),
(125, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 16:35:41'),
(126, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-23 23:27:51'),
(127, 'Kategori eklendi', 'Kategori Eklendi', 'GameMaster', '2021-03-24 13:44:33'),
(128, 'Kategori eklendi', 'Kategori Eklendi', 'GameMaster', '2021-03-24 13:48:04'),
(129, 'Kategori eklendi', 'Kategori Eklendi', 'GameMaster', '2021-03-24 13:49:16'),
(130, 'Kategori eklendi', 'Kategori Eklendi', 'GameMaster', '2021-03-24 13:51:35'),
(131, 'Kategori eklendi', 'Kategori Eklendi', 'GameMaster', '2021-03-24 13:52:07'),
(132, 'Kategori eklendi', 'Kategori Eklendi', 'GameMaster', '2021-03-24 13:52:30'),
(133, 'Kategori eklendi', 'Kategori Eklendi', 'GameMaster', '2021-03-24 13:52:44'),
(134, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-27 22:32:50'),
(135, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-28 09:55:53'),
(136, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-28 10:06:21'),
(137, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-28 10:08:41'),
(138, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-28 10:08:57'),
(139, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-28 12:22:00'),
(140, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-28 12:23:08'),
(141, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-28 14:29:36'),
(142, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-28 14:31:00'),
(143, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-28 14:35:45'),
(144, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-28 14:57:13'),
(145, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-28 15:05:03'),
(146, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-28 15:05:34'),
(147, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-28 15:05:37'),
(148, 'Site ayarları güncellendi', 'Site Ayarları Güncellendi', 'GameMaster', '2021-03-28 15:06:11'),
(149, 'shnbsra adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2021-03-28 15:19:36'),
(150, 'Slider eklendi', 'Slider Eklendi', 'GameMaster', '2021-03-28 15:50:09'),
(151, 'Kategori eklendi', 'Kategori Eklendi', 'GameMaster', '2021-03-31 17:53:54'),
(152, 'Elbise ürünü eklendi', 'Ürün Eklendi', 'GameMaster', '2021-03-31 18:01:59'),
(153, 'GameMaster0707 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2021-04-01 02:33:17'),
(154, 'GameMaster0707 adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2021-04-01 02:33:29'),
(155, 'GameMaster0707 adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2021-04-01 02:35:42'),
(156, 'GameMaster0707 adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2021-04-01 02:42:38'),
(157, 'sem adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2021-04-01 11:20:47'),
(158, 'sem adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2021-04-01 11:48:27'),
(159, 'sem adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2021-04-01 12:24:17'),
(160, 'sem adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2021-04-01 12:25:33'),
(161, 'sem adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2021-04-01 12:25:48'),
(162, 'sem adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2021-04-01 12:27:15'),
(163, 'sem adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2021-04-01 12:29:57'),
(164, 'sem adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2021-04-01 12:30:33'),
(165, 'sem adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2021-04-01 12:32:36'),
(166, 'sem adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2021-04-01 12:49:16'),
(167, 'sem adlı kullancının kaydı güncellendi', 'Üye Güncellendi', 'GameMaster', '2021-04-01 12:51:12'),
(168, 'sem adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2021-04-01 12:51:18'),
(169, 'sem adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2021-04-01 12:51:47'),
(170, 'sem adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2021-04-01 12:51:56'),
(171, 'sem adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2021-04-01 18:01:09'),
(172, 'shnbsra adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2021-04-01 18:01:58'),
(173, 'shnbsra adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2021-04-01 18:02:53'),
(174, 'shnbsra adında yeni bir kayıt oluşturuldu', 'Üye Eklendi', 'GameMaster', '2021-04-01 18:03:40'),
(175, 'shnbsra adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2021-04-01 18:03:59'),
(176, 'shnbusra adında yeni bir üye oluşturuldu', 'Üye Eklendi', 'GameMaster', '2021-04-06 03:29:26'),
(177, 'shnbusra adlı kullanıcının kaydı silindi', 'Üye Silindi', 'GameMaster', '2021-04-10 22:56:13'),
(178, 'Elbise ürünü eklendi', 'Ürün Eklendi', 'GameMaster', '2021-04-27 20:17:34'),
(179, 'Elbise ürünü eklendi', 'Ürün Eklendi', 'GameMaster', '2021-04-27 20:19:53');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `user_id` int(7) NOT NULL,
  `user_profile_photo` text NOT NULL,
  `user_name_surname` varchar(3000) NOT NULL,
  `user_name` varchar(300) NOT NULL,
  `user_birthday` date NOT NULL,
  `user_email` varchar(300) NOT NULL,
  `user_phone_number` varchar(15) NOT NULL,
  `user_web_site` text NOT NULL,
  `user_facebook` text NOT NULL,
  `user_instagram` text NOT NULL,
  `user_twitter` text NOT NULL,
  `user_linkedin` text NOT NULL,
  `user_pinterest` text NOT NULL,
  `user_gender` int(1) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_status` int(1) NOT NULL,
  `user_authority` int(1) NOT NULL,
  `user_registration_date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_active_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`user_id`, `user_profile_photo`, `user_name_surname`, `user_name`, `user_birthday`, `user_email`, `user_phone_number`, `user_web_site`, `user_facebook`, `user_instagram`, `user_twitter`, `user_linkedin`, `user_pinterest`, `user_gender`, `user_password`, `user_status`, `user_authority`, `user_registration_date`, `user_active_status`) VALUES
(30, 'GameMaster_16060248c4ae1f.jpg', 'Barış KURT', 'GameMaster', '1999-08-11', 'kurt-bar07@hotmail.com', '532 497 38 73', 'http://kurtbaris.com/', 'https://www.facebook.com/kurt.baris07', 'https://www.instagram.com/kurtbar07/', 'https://twitter.com/Barkurt14443348', 'https://www.linkedin.com/in/bar%C4%B1%C5%9F-kurt-31ba65201/', '', 0, '7815696ecbf1c96e6894b779456d330e', 1, 0, '2020-12-13 19:10:10', 'çevrimiçi'),
(112, 'Mr_profile_photo.png', 'Semih ACAR', 'sem', '2021-04-15', 'smhacar@gmail.com', '123 123 12 31', '', '', '', '', '', '', 0, '700260321de78895a72ffa37ea6faa74', 1, 1, '2021-04-01 18:01:09', 'çevrimdışı');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Tablo için indeksler `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`mail_id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slider_id`);

--
-- Tablo için indeksler `system_archives`
--
ALTER TABLE `system_archives`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `mails`
--
ALTER TABLE `mails`
  MODIFY `mail_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `slider`
--
ALTER TABLE `slider`
  MODIFY `slider_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tablo için AUTO_INCREMENT değeri `system_archives`
--
ALTER TABLE `system_archives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
