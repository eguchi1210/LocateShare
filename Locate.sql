-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2021 年 10 月 05 日 14:45
-- サーバのバージョン： 5.7.32
-- PHP のバージョン: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `Locate`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `Category`
--

CREATE TABLE `Category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `Category`
--

INSERT INTO `Category` (`id`, `name`) VALUES
(1, 'レストラン'),
(2, 'カフェ'),
(3, '交通機関'),
(4, '娯楽施設'),
(5, '名所•ランドマーク'),
(6, 'ショップ'),
(7, '学校・病院'),
(8, '博物館・美術館'),
(9, '企業・行政施設');

-- --------------------------------------------------------

--
-- テーブルの構造 `Favorite`
--

CREATE TABLE `Favorite` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `del_flg` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `Favorite`
--

INSERT INTO `Favorite` (`id`, `location_id`, `user_id`, `del_flg`) VALUES
(1, 3, 10, 0),
(2, 1, 11, 0),
(3, 12, 14, 0),
(4, 1, 12, 0),
(5, 4, 12, 0),
(6, 9, 12, 0),
(7, 11, 12, 0),
(8, 8, 12, 0),
(9, 5, 12, 0),
(10, 1, 13, 0),
(11, 10, 13, 0),
(12, 12, 10, 0),
(13, 4, 10, 1),
(14, 14, 10, 0),
(15, 13, 10, 0),
(16, 16, 16, 0),
(17, 16, 10, 0),
(18, 15, 10, 0),
(19, 20, 18, 0),
(20, 30, 18, 0),
(21, 18, 18, 1),
(22, 28, 18, 0),
(23, 29, 18, 0),
(24, 8, 18, 0),
(25, 12, 18, 0),
(26, 20, 10, 0),
(27, 16, 18, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `Follow`
--

CREATE TABLE `Follow` (
  `id` int(11) NOT NULL,
  `follow_user` int(11) NOT NULL,
  `followed_user` int(11) NOT NULL,
  `del_flg` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `Follow`
--

INSERT INTO `Follow` (`id`, `follow_user`, `followed_user`, `del_flg`) VALUES
(55, 10, 14, 0),
(56, 11, 10, 0),
(57, 11, 14, 0),
(58, 12, 10, 0),
(59, 12, 14, 0),
(60, 13, 10, 0),
(61, 10, 11, 0),
(62, 10, 17, 0),
(63, 16, 17, 0),
(64, 18, 16, 0),
(65, 18, 10, 0),
(66, 10, 16, 0),
(67, 18, 17, 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `Location`
--

CREATE TABLE `Location` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` varchar(32) DEFAULT NULL,
  `user_id` int(32) NOT NULL,
  `post_num` varchar(8) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del_flg` int(11) NOT NULL DEFAULT '0',
  `report` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `Location`
--

INSERT INTO `Location` (`id`, `name`, `category_id`, `user_id`, `post_num`, `image`, `address`, `comment`, `updated_at`, `del_flg`, `report`) VALUES
(1, '両国駅', '3', 10, '1300026', 'img/20210904_143249.7411jpg', '東京都墨田区両国1-3-20', '国技館のすぐ横', '2021-08-28 20:58:54', 0, 0),
(3, 'ヨドバシアキバ', '6', 14, '1010028', NULL, '東京都千代田区神田花岡町１−１', '東京都千代田区神田花岡町１−１', '2021-08-29 12:22:24', 1, 0),
(4, '東京大学医学部附属病院', '7', 14, '113-8655', NULL, '東京都文京区本郷７丁目３−１', '東京都文京区本郷７丁目３−１', '2021-08-29 12:26:39', 0, 0),
(5, '早稲田大学', '7', 10, '1698050', 'img/noimage.png', '東京都新宿区戸塚町１丁目１０４', '都の西北', '2021-08-29 13:35:32', 0, 0),
(8, '慶應義塾大学', '7', 10, '108-8345', NULL, '東京都港区三田２丁目１５−４５', '東京都港区三田２丁目１５−４５', '2021-08-29 13:44:00', 0, 0),
(9, '国会議事堂', '9', 10, '1000014', NULL, '東京都千代田区永田町１丁目７−１', '国の中枢', '2021-08-29 19:26:45', 0, 0),
(10, '東京スカイツリー', '5', 10, '131-0045', NULL, '東京都墨田区押上１丁目１−２', '世界一高い自立型電波塔。360 度のパノラマを望む展望台がある。', '2021-08-31 15:21:42', 0, 0),
(11, '早稲田大学', '7', 10, '1698050', NULL, '東京都新宿区戸塚町１丁目１０４', '都の西北', '2021-09-02 17:17:46', 1, 0),
(12, '東京タワー', '5', 11, '105-0011', NULL, '東京都港区芝公園4−2−8', '1958年に竣工された高さ333mの電波塔。東京のシンボルとして知られ、高さ150mと250mの2つの展望台と飲食施設を備える。', '2021-09-11 16:27:33', 0, 0),
(13, '明治神宮', '5', 13, '', NULL, '東京都渋谷区代々木神園町1−1', '神社', '2021-09-20 16:42:38', 0, 0),
(14, '蔵前橋', '5', 12, '', 'img/20210922_130237.7782jpg', '東京都墨田区横網１丁目', '隅田川に架かる橋　', '2021-09-22 13:02:42', 2, 0),
(15, 'マルハのカルビ丼', '1', 17, '001-0018', 'img/20210929_041854.9368jpg', '北海道札幌市北区北十八条西3-1-12', 'カルビ丼の店。トッピングが色々選べる。なまらうまい', '2021-09-29 03:41:34', 0, 0),
(16, 'ジンギスカン 味の羊ヶ丘', '1', 17, '064-0806', 'img/20210929_035230.8711jpg', '北海道札幌市中央区南六条西', '気のいい店長が無限に野菜投入してくる。楽しい', '2021-09-29 03:55:21', 0, 0),
(17, 'test', '1', 16, '130-0026', 'img/20210929_125213.3790png', '東京都墨田区両国1-3-20', '', '2021-09-29 12:52:18', 1, 0),
(18, '小樽運河', '5', 16, '047-0007', 'img/20210930_180634.9934jpg', '北海道小樽市港町5', '意外と小さかった', '2021-09-30 18:06:39', 0, 0),
(19, '蔵前橋', '5', 10, '', 'img/20211001_115320.8473jpg', '東京都墨田区横網2', '隅田川の橋', '2021-10-01 11:54:04', 0, 0),
(20, '北海道神宮', '5', 16, '064-0959', 'img/20211001_161609.5243jpg', '北海道札幌市中央区宮ケ丘474', '緑多くて穏やか。よいとこ', '2021-10-01 16:16:55', 0, 0),
(21, 'test', '', 13, '', NULL, '東京都千代田区神田', '', '2021-10-01 18:18:07', 0, 0),
(27, 'test3', '', 11, '', NULL, '東京都墨田区', '', '2021-10-01 18:44:29', 0, 0),
(28, 'test4 北海道', '', 16, '', NULL, '北海道札幌市', '', '2021-10-01 18:46:17', 0, 0),
(29, 'test', '', 16, '', NULL, '神奈川県川崎市', '', '2021-10-02 18:05:25', 0, 0),
(30, 'test6', '', 16, '', NULL, '石川県金沢市', '', '2021-10-02 18:07:19', 0, 0),
(31, 'test', '', 18, '', NULL, '愛媛県松山市', '', '2021-10-03 16:43:11', 0, 0),
(32, 'test', '', 18, '130-0026', NULL, '東京都墨田区両国', '', '2021-10-04 15:40:51', 1, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `Report`
--

CREATE TABLE `Report` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `rep_category` int(11) NOT NULL,
  `reported_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `Report`
--

INSERT INTO `Report` (`id`, `location_id`, `posted_by`, `rep_category`, `reported_by`) VALUES
(1, 4, 14, 2, 10),
(2, 12, 11, 3, 10),
(3, 3, 14, 3, 10),
(4, 10, 10, 3, 14),
(5, 5, 10, 2, 14),
(6, 10, 10, 3, 11),
(7, 5, 10, 1, 11),
(8, 14, 12, 1, 10);

-- --------------------------------------------------------

--
-- テーブルの構造 `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birth` date DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del_flg` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `User`
--

INSERT INTO `User` (`id`, `name`, `mail`, `password`, `birth`, `role`, `created_at`, `del_flg`) VALUES
(10, '山田', 'test@test.co.jp', '$2y$10$ZBNK6gdwc01SRQa6vs3CGeTgZqN6Y.rsanuQg60y0z.m/8pNP.85u', '2021-09-01', 0, '2021-08-21 17:50:01', 0),
(11, '山田1', 'test1@test.co.jp', '$2y$10$caWULwavYLzJoCyehVpl0.b9QpNAlchJkWtlC5.3xE0GfDXACZXQO', '2011-06-01', 0, '2021-08-21 17:50:57', 0),
(12, '山田太郎', 'test2@test.co.jp', '$2y$10$HwnIp77xoCQDcJMY14Q4De9XNSr7Kqomj/X2NWJb1j96Mzt.N8cIO', '2011-09-01', 0, '2021-08-21 18:28:00', 2),
(13, '山田太', 'test3@test.co.jp', '$2y$10$.CQ87hWg4wh7muGTIcS3EOXLfVuYJBHdQPjsCsJoSeuPmuv5e26gK', '2011-09-01', 0, '2021-08-21 18:40:41', 0),
(14, 'あああ', 'test5@test.co.jp', '$2y$10$z6JRK2kzhJEzv3i1SN9a6ua/afhDNHgnr2UteYa5adgx3/heiitb2', '2011-09-01', 0, '2021-08-21 23:10:10', 0),
(15, 'admin', 'admin@test.co.jp', '$2y$10$Qj.frHa6WI8aMk/vZUdx7eopko1M/tOzi0AjtSyUCw0tFA7biBr/m', '2011-09-01', 1, '2021-09-22 13:05:25', 0),
(16, 'test4', 'test4@test.co.jp', '$2y$10$IcCLeWmY1tDqcNo1lk8/PeCH/LIxRqKcAikqj9nLfd6dQGVNVdy5i', '2000-01-01', 0, '2021-09-28 17:56:21', 0),
(17, 'test6', 'test6@test.co.jp', '$2y$10$DuoeMqb.aJ.Dx70SZxd9eO37EwOWSunvvcAoY77XCBOcFCtO2OFbe', '1995-12-10', 0, '2021-09-28 17:58:00', 0),
(18, 'test', 'test7@test.co.jp', '$2y$10$Mjv.hQ87I7FN/qIAGP.ao.IXvOJxSvXg2IG2.7eFCXodDxJyduA/S', '1995-12-10', 0, '2021-10-02 20:33:36', 0),
(19, 'test8', 'test8@test.co.jp', '$2y$10$0.TD7ijJAp/2ZxAePABwkO6Qx7vzDn0pgRPOoGiT24IWyf8bZSdye', '1995-12-10', 0, '2021-10-02 20:34:15', 0);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `Favorite`
--
ALTER TABLE `Favorite`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `Follow`
--
ALTER TABLE `Follow`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `Location`
--
ALTER TABLE `Location`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `Report`
--
ALTER TABLE `Report`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `Category`
--
ALTER TABLE `Category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- テーブルの AUTO_INCREMENT `Favorite`
--
ALTER TABLE `Favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- テーブルの AUTO_INCREMENT `Follow`
--
ALTER TABLE `Follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- テーブルの AUTO_INCREMENT `Location`
--
ALTER TABLE `Location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- テーブルの AUTO_INCREMENT `Report`
--
ALTER TABLE `Report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- テーブルの AUTO_INCREMENT `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
