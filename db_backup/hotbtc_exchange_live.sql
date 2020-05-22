-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 01, 2019 at 12:23 PM
-- Server version: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 7.2.15-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotbtc_exchange_live`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_balance` (IN `user_id` INT(10) UNSIGNED, IN `coin_id` INT(10) UNSIGNED)  NO SQL
SELECT 
coin_id, 
(credit - debit) as balance FROM (SELECT coin_id,
SUM(CASE
        WHEN type = 'Credit' THEN amount
        ELSE 0
    END) AS credit,
SUM(CASE
        WHEN type = 'Debit' THEN amount
        ELSE 0
    END) AS debit
FROM `transactions` WHERE transactions.deleted_at is null and transactions.status = 1 and transactions.user_id = user_id and transactions.coin_id = coin_id ) as tbl$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_change_percent` (IN `pair_name` VARCHAR(10))  NO SQL
BEGIN
DECLARE first_price, last_price double default 0;
select IFNULL(trades.price, 0) into first_price  from trades
INNER JOIN coin_pairs ON coin_pairs.id = trades.coin_pair_id
where trades.updated_at >= (now() - INTERVAL 24 hour)
AND coin_pairs.pair_name = pair_name 
AND trades.status = 1 
AND trades.type = 'buy'
ORDER by 
trades.updated_at ASC
LIMIT 1;

select IFNULL(trades.price, 0) into last_price  from trades
INNER JOIN coin_pairs ON coin_pairs.id = trades.coin_pair_id
where trades.updated_at >= (now() - INTERVAL 24 hour)
AND coin_pairs.pair_name = pair_name 
AND trades.status = 1 
AND trades.type = 'buy'
ORDER by 
trades.updated_at DESC
LIMIT 1;

SELECT CASE 
when (first_price <> 0 and last_price <> 0) 
then ((last_price - first_price) / first_price) else 0 END as change_percent;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_graph_record` (IN `coin_pair_id` INT(10) UNSIGNED)  NO SQL
    DETERMINISTIC
SELECT (
           ROUND(unix_timestamp(intervals))*1000) as intervals,
    open,
    close,
    low,
    high
  FROM (
         SELECT
           concat(date(trades.created_at),' ',sec_to_time(time_to_sec(trades.created_at)- time_to_sec (trades.created_at)%(5*60))) as intervals,
           MIN(trades.created_at) as lowestTime,
           MAX(trades.created_at) as highestTime ,
           SUBSTRING_INDEX(MIN(CONCAT(trades.created_at, '_', trades.price)), '_', -1) AS `open`,
           SUBSTRING_INDEX(MAX(CONCAT(trades.created_at, '_', trades.price)), '_', -1) AS `close`,
           MIN(trades.price) as low,
           MAX(trades.price) as high,
           sum(trades.price * trades.volume) as volume from trades
         WHERE
           trades.deleted_at IS NULL AND 
           trades.coin_pair_id=coin_pair_id AND
           trades.status=1
         group by intervals ORDER BY `intervals` ASC) as tb1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_trade_record` (IN `pair` VARCHAR(10))  NO SQL
SELECT
    price,
    type,
    `amount` - (`closedamount` + `cancelledamount`) as toamount FROM(SELECT trades.price, trades.type, sum(trades.volume) as amount,
    SUM(CASE
        WHEN trades.status = 1 THEN volume
        ELSE 0
        END) AS 'closedamount',
    SUM(CASE
        WHEN trades.status = 0 THEN volume
        ELSE 0
        END) AS 'ongoinamount',
    SUM(CASE
        WHEN trades.status = 2 THEN volume
        ELSE 0
        END) AS 'cancelledamount'
        FROM 
          trades LEFT JOIN coin_pairs on trades.coin_pair_id = coin_pairs.id 
        WHERE coin_pairs.pair_name = pair and trades.method='limit' group by price, type) as tablea$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_trade_summary` (IN `user_info` VARCHAR(191), IN `coin_pair_id` INT(10) UNSIGNED, IN `start_date` DATE, IN `end_date` DATE)  NO SQL
SELECT 
  users.email,
  coin_pairs.pair_name,
  t1.volume,
  t1.fees
  
FROM (select
    `trades`.`user_id` AS `user_id`,
    `trades`.`coin_pair_id` AS `coin_pair_id`,
    sum((`trades`.`price` * `trades`.`volume`)) AS `volume`,
    sum(`trades`.`fees`) AS `fees`
  from `trades`    
  where (
        (`trades`.`status` = 1) and
    ((start_date is null) or (`trades`.`updated_at` >= start_date)) and
    ((end_date is null) or (`trades`.`updated_at` <= end_date))        
  )
  group by `trades`.`user_id`,`trades`.`coin_pair_id`) as t1
  INNER JOIN users on users.id = t1.user_id
  INNER JOIN profiles on profiles.user_id = t1.user_id
  INNER JOIN coin_pairs on t1.coin_pair_id = coin_pairs.id

  WHERE (
    (user_info is null) or
    (
      (users.email = user_info) OR
      (users.first_name LIKE concat('%', user_info, '%')) or
      (users.middle_name LIKE concat('%', user_info, '%')) or
      (users.last_name LIKE concat('%', user_info, '%')) or
      (profiles.address LIKE concat('%', user_info, '%')) or
      (profiles.city LIKE concat('%', user_info, '%')) or
      (profiles.state LIKE concat('%', user_info, '%')) or
      (profiles.zip LIKE concat('%', user_info, '%')) or
      (profiles.phone LIKE concat('%', user_info, '%')) or
      (profiles.ide_no LIKE concat('%', user_info, '%'))
    ))$$

--
-- Functions
--
CREATE DEFINER=`amit`@`localhost` FUNCTION `fn_get_change_percent` (`pair_name` VARCHAR(191), `period` INT(10) UNSIGNED) RETURNS DECIMAL(15,2) NO SQL
BEGIN
  DECLARE first_price, last_price double default 0;
  select IFNULL(trades.price, 0) into first_price  from trades
    INNER JOIN coin_pairs ON coin_pairs.id = trades.coin_pair_id
  where trades.updated_at >= (now() - INTERVAL period hour)
        AND coin_pairs.pair_name = pair_name
        AND trades.status = 1
        AND trades.type = 'buy'
  ORDER by
    trades.updated_at ASC
  LIMIT 1;

  select IFNULL(trades.price, 0) into last_price  from trades
    INNER JOIN coin_pairs ON coin_pairs.id = trades.coin_pair_id
  where trades.updated_at >= (now() - INTERVAL period hour)
        AND coin_pairs.pair_name = pair_name
        AND trades.status = 1
        AND trades.type = 'buy'
  ORDER by
    trades.updated_at DESC
  LIMIT 1;

  RETURN CASE
          when (first_price <> 0 and last_price <> 0) then ((last_price - first_price) / first_price) 
          else 0 
         END;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coins`
--

CREATE TABLE `coins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `withdraw` enum('automatic','manual') COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_type` enum('Fiat','Crypto') COLLATE utf8mb4_unicode_ci NOT NULL,
  `withdraw_enabled` tinyint(4) NOT NULL DEFAULT '1',
  `withdraw_fees` double DEFAULT NULL,
  `withdraw_min_amount` double DEFAULT NULL,
  `withdraw_max_amount` double DEFAULT NULL,
  `deposit_enabled` tinyint(4) NOT NULL DEFAULT '1',
  `deposit_fees` double DEFAULT NULL,
  `deposit_min_amount` double DEFAULT NULL,
  `deposit_max_amount` double DEFAULT NULL,
  `is_base` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coins`
--

INSERT INTO `coins` (`id`, `name`, `coin`, `withdraw`, `currency_type`, `withdraw_enabled`, `withdraw_fees`, `withdraw_min_amount`, `withdraw_max_amount`, `deposit_enabled`, `deposit_fees`, `deposit_min_amount`, `deposit_max_amount`, `is_base`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Bitcoin', 'BTC', 'manual', 'Crypto', 1, 0.0005, 0.0015, 1, 1, NULL, NULL, NULL, 1, 1, NULL, '2019-02-11 02:39:01', '2019-03-07 02:14:53'),
(3, 'Etherium', 'ETH', 'manual', 'Crypto', 1, 0.01, 0.02, 20, 1, NULL, NULL, NULL, 0, 1, NULL, '2019-02-11 02:39:58', '2019-02-11 02:39:58'),
(4, 'Ripple', 'XRP', 'manual', 'Crypto', 1, 0.25, 22, 50000, 1, NULL, NULL, NULL, 0, 1, NULL, '2019-02-11 02:40:20', '2019-02-11 02:40:20'),
(5, 'Dash', 'DASH', 'manual', 'Crypto', 1, 0.002, 0.004, 10, 1, NULL, NULL, NULL, 0, 1, NULL, '2019-02-11 02:40:44', '2019-02-11 02:40:44'),
(6, 'Litecoin', 'LTC', 'manual', 'Crypto', 1, 0.001, 0.002, 20, 1, NULL, NULL, NULL, 0, 1, NULL, '2019-02-11 02:40:59', '2019-02-11 02:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `coin_for_lists`
--

CREATE TABLE `coin_for_lists` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `coin_id` int(10) UNSIGNED DEFAULT NULL,
  `contact_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position_in_company` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `one_sentence_pitch` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `previously_submited` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coin_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coin_symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website_link` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whitepaper_link` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_nature` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_application` tinytext COLLATE utf8mb4_unicode_ci,
  `target_industry` tinytext COLLATE utf8mb4_unicode_ci,
  `project_competetor` tinytext COLLATE utf8mb4_unicode_ci,
  `remarks` mediumtext COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coin_pairs`
--

CREATE TABLE `coin_pairs` (
  `id` int(10) UNSIGNED NOT NULL,
  `coin_id` int(10) UNSIGNED NOT NULL,
  `base_coin_id` int(10) UNSIGNED NOT NULL,
  `listed_by` int(10) UNSIGNED DEFAULT NULL,
  `pair_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 => Active, 2 => Inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coin_pairs`
--

INSERT INTO `coin_pairs` (`id`, `coin_id`, `base_coin_id`, `listed_by`, `pair_name`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 3, 1, NULL, 'BTC_ETH', 1, NULL, '2019-02-11 02:42:23', '2019-02-11 02:42:23'),
(2, 4, 1, NULL, 'BTC_XRP', 1, NULL, '2019-02-11 02:42:33', '2019-02-11 02:42:40'),
(3, 5, 1, NULL, 'BTC_DASH', 1, NULL, '2019-02-11 02:42:54', '2019-02-11 02:42:54'),
(4, 6, 1, NULL, 'BTC_LTC', 1, NULL, '2019-02-11 02:43:08', '2019-02-11 02:43:08');

-- --------------------------------------------------------

--
-- Table structure for table `coin_transactions`
--

CREATE TABLE `coin_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `coin_id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `coin_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dest_tag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double NOT NULL,
  `fees` double DEFAULT NULL,
  `type` enum('Credit','Debit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 => Pending, 1 => Completed, 2 => Rejected, 3 => Cancelled',
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coin_wallet_balances`
--

CREATE TABLE `coin_wallet_balances` (
  `id` int(10) UNSIGNED NOT NULL,
  `coin_id` int(10) UNSIGNED NOT NULL,
  `balance_available` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag_icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `calling_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `code`, `name`, `nationality`, `flag_icon`, `calling_code`) VALUES
(1, 'AF', 'Afghanistan', 'Afghan', 'af.png', '+93'),
(2, 'AL', 'Albania', 'Albanian', 'al.png', '+355'),
(3, 'DZ', 'Algeria', 'Algerian', 'dz.png', '+213'),
(4, 'AD', 'Andorra', 'Andorran', 'ad.png', '+376'),
(5, 'AO', 'Angola', 'Angolan', 'ao.png', '+244'),
(6, 'AG', 'Antigua and Barbuda', 'Antiguans, Barbudans', 'ag.png', '+1268'),
(7, 'AR', 'Argentina', 'Argentinean', 'ar.png', '+54'),
(8, 'AM', 'Armenia', 'Armenian', 'am.png', '+374'),
(9, 'AU', 'Australia', 'Australian', 'au.png', '+61'),
(10, 'AT', 'Austria', 'Austrian', 'at.png', '+43'),
(11, 'AZ', 'Azerbaijan', 'Azerbaijani', 'az.png', '+994'),
(12, 'BH', 'Bahrain', 'Bahraini', 'bh.png', '+973'),
(13, 'BD', 'Bangladesh', 'Bangladeshi', 'bd.png', '+880'),
(14, 'BB', 'Barbados', 'Barbadian', 'bb.png', '+1246'),
(15, 'BY', 'Belarus', 'Belarusian', 'by.png', '+375'),
(16, 'BE', 'Belgium', 'Belgian', 'be.png', '+32'),
(17, 'BZ', 'Belize', 'Belizean', 'bz.png', '+501'),
(18, 'BJ', 'Benin', 'Beninese', 'bj.png', '+229'),
(19, 'BT', 'Bhutan', 'Bhutanese', 'bt.png', '+975'),
(20, 'BA', 'Bosnia and Herzegovina', 'Bosnian, Herzegovinian', 'ba.png', '+387'),
(21, 'BW', 'Botswana', 'Motswana (singular), Batswana (plural)', 'bw.png', '+267'),
(22, 'BR', 'Brazil', 'Brazilian', 'br.png', '+55'),
(23, 'BG', 'Bulgaria', 'Bulgarian', 'bg.png', '+359'),
(24, 'BF', 'Burkina Faso', 'Burkinabe', 'bf.png', '+226'),
(25, 'BI', 'Burundi', 'Burundian', 'bi.png', '+257'),
(26, 'KH', 'Cambodia', 'Cambodian', 'kh.png', '+855'),
(27, 'CM', 'Cameroon', 'Cameroonian', 'cm.png', '+237'),
(28, 'CA', 'Canada', 'Canadian', 'ca.png', '+1'),
(29, 'CV', 'Cape Verde', 'Cape Verdian', 'cv.png', '+238'),
(30, 'CF', 'Central African Republic', 'Central African', 'cf.png', '+236'),
(31, 'TD', 'Chad', 'Chadian', 'td.png', '+235'),
(32, 'CL', 'Chile', 'Chilean', 'cl.png', '+56'),
(33, 'CN', 'China', 'Chinese', 'cn.png', '+86'),
(34, 'CO', 'Colombia', 'Colombian', 'co.png', '+57'),
(35, 'KM', 'Comoros', 'Comoran', 'km.png', '+269'),
(36, 'CR', 'Costa Rica', 'Costa Rican', 'cr.png', '+506'),
(37, 'HR', 'Croatia', 'Croatian', 'hr.png', '+385'),
(38, 'CU', 'Cuba', 'Cuban', 'cu.png', '+53'),
(39, 'CY', 'Cyprus', 'Cypriot', 'cy.png', '+357'),
(40, 'CZ', 'Czech Republic', 'Czech', 'cz.png', '+420'),
(41, 'DK', 'Denmark', 'Danish', 'dk.png', '+45'),
(42, 'DJ', 'Djibouti', 'Djibouti', 'dj.png', '+253'),
(43, 'DM', 'Dominica', 'Dominican', 'dm.png', '+1767'),
(44, 'DO', 'Dominican Republic', 'Dominican', 'do.png', '+1809'),
(45, 'EC', 'Ecuador', 'Ecuadorean', 'ec.png', '+593'),
(46, 'EG', 'Egypt', 'Egyptian', 'eg.png', '+20'),
(47, 'SV', 'El Salvador', 'Salvadoran', 'sv.png', '+503'),
(48, 'GQ', 'Equatorial Guinea', 'Equatorial Guinean', 'gq.png', '+240'),
(49, 'ER', 'Eritrea', 'Eritrean', 'er.png', '+291'),
(50, 'EE', 'Estonia', 'Estonian', 'ee.png', '+372'),
(51, 'ET', 'Ethiopia', 'Ethiopian', 'et.png', '+251'),
(52, 'FJ', 'Fiji', 'Fijian', 'fj.png', '+679'),
(53, 'FI', 'Finland', 'Finnish', 'fi.png', '+358'),
(54, 'FR', 'France', 'French', 'fr.png', '+33'),
(55, 'GA', 'Gabon', 'Gabonese', 'ga.png', '+241'),
(56, 'GE', 'Georgia', 'Georgian', 'ge.png', '+995'),
(57, 'DE', 'Germany', 'German', 'de.png', '+49'),
(58, 'GH', 'Ghana', 'Ghanaian', 'gh.png', '+233'),
(59, 'GR', 'Greece', 'Greek', 'gr.png', '+30'),
(60, 'GD', 'Grenada', 'Grenadian', 'gd.png', '+1473'),
(61, 'GT', 'Guatemala', 'Guatemalan', 'gt.png', '+502'),
(62, 'GN', 'Guinea', 'Guinean', 'gn.png', '+224'),
(63, 'GW', 'Guinea-Bissau', 'Guinea-Bissauan', 'gw.png', '+245'),
(64, 'GY', 'Guyana', 'Guyanese', 'gy.png', '+592'),
(65, 'HT', 'Haiti', 'Haitian', 'ht.png', '+509'),
(66, 'HN', 'Honduras', 'Honduran', 'hn.png', '+504'),
(67, 'HU', 'Hungary', 'Hungarian', 'hu.png', '+36'),
(68, 'IS', 'Iceland', 'Icelander', 'is.png', '+354'),
(69, 'IN', 'India', 'Indian', 'in.png', '+91'),
(70, 'ID', 'Indonesia', 'Indonesian', 'id.png', '+62'),
(71, 'IQ', 'Iraq', 'Iraqi', 'iq.png', '+964'),
(72, 'IE', 'Ireland', 'Irish', 'ie.png', '+353'),
(73, 'IL', 'Israel', 'Israeli', 'il.png', '+972'),
(74, 'IT', 'Italy', 'Italian', 'it.png', '+39'),
(75, 'JM', 'Jamaica', 'Jamaican', 'jm.png', '+1876'),
(76, 'JP', 'Japan', 'Japanese', 'jp.png', '+81'),
(77, 'JO', 'Jordan', 'Jordanian', 'jo.png', '+962'),
(78, 'KZ', 'Kazakhstan', 'Kazakhstani', 'kz.png', '+76'),
(79, 'KE', 'Kenya', 'Kenyan', 'ke.png', '+254'),
(80, 'KI', 'Kiribati', 'I-Kiribati', 'ki.png', '+686'),
(81, 'KW', 'Kuwait', 'Kuwaiti', 'kw.png', '+965'),
(82, 'LV', 'Latvia', 'Latvian', 'lv.png', '+371'),
(83, 'LB', 'Lebanon', 'Lebanese', 'lb.png', '+961'),
(84, 'LS', 'Lesotho', 'Mosotho', 'ls.png', '+266'),
(85, 'LR', 'Liberia', 'Liberian', 'lr.png', '+231'),
(86, 'LI', 'Liechtenstein', 'Liechtensteiner', 'li.png', '+423'),
(87, 'LT', 'Lithuania', 'Lithuanian', 'lt.png', '+370'),
(88, 'LU', 'Luxembourg', 'Luxembourger', 'lu.png', '+370'),
(89, 'MG', 'Madagascar', 'Malagasy', 'mg.png', '+261'),
(90, 'MW', 'Malawi', 'Malawian', 'mw.png', '+265'),
(91, 'MY', 'Malaysia', 'Malaysian', 'my.png', '+60'),
(92, 'MV', 'Maldives', 'Maldivan', 'mv.png', '+960'),
(93, 'ML', 'Mali', 'Malian', 'ml.png', '+223'),
(94, 'MT', 'Malta', 'Maltese', 'mt.png', '+356'),
(95, 'MH', 'Marshall Islands', 'Marshallese', 'mh.png', '+692'),
(96, 'MR', 'Mauritania', 'Mauritanian', 'mr.png', '+222'),
(97, 'MU', 'Mauritius', 'Mauritian', 'mu.png', '+230'),
(98, 'MX', 'Mexico', 'Mexican', 'mx.png', '+52'),
(99, 'MC', 'Monaco', 'Monegasque', 'mc.png', '+377'),
(100, 'MN', 'Mongolia', 'Mongolian', 'mn.png', '+976'),
(101, 'MA', 'Morocco', 'Moroccan', 'ma.png', '+212'),
(102, 'MZ', 'Mozambique', 'Mozambican', 'mz.png', '+258'),
(103, 'NA', 'Namibia', 'Namibian', 'na.png', '+264'),
(104, 'NR', 'Nauru', 'Nauruan', 'nr.png', '+674'),
(105, 'NP', 'Nepal', 'Nepalese', 'np.png', '+977'),
(106, 'NL', 'Netherlands', 'Dutch', 'nl.png', '+31'),
(107, 'NZ', 'New Zealand', 'New Zealander', 'nz.png', '+64'),
(108, 'NI', 'Nicaragua', 'Nicaraguan', 'ni.png', '+505'),
(109, 'NE', 'Niger', 'Nigerien', 'ne.png', '+227'),
(110, 'NG', 'Nigeria', 'Nigerian', 'ng.png', '+234'),
(111, 'NO', 'Norway', 'Norwegian', 'no.png', '+47'),
(112, 'OM', 'Oman', 'Omani', 'om.png', '+968'),
(113, 'PK', 'Pakistan', 'Pakistani', 'pk.png', '+92'),
(114, 'PW', 'Palau', 'Palauan', 'pw.png', '+680'),
(115, 'PA', 'Panama', 'Panamanian', 'pa.png', '+507'),
(116, 'PG', 'Papua New Guinea', 'Papua New Guinean', 'pg.png', '+675'),
(117, 'PY', 'Paraguay', 'Paraguayan', 'py.png', '+595'),
(118, 'PE', 'Peru', 'Peruvian', 'pe.png', '+51'),
(119, 'PH', 'Philippines', 'Filipino', 'ph.png', '+63'),
(120, 'PL', 'Poland', 'Polish', 'pl.png', '+48'),
(121, 'PT', 'Portugal', 'Portuguese', 'pt.png', '+351'),
(122, 'QA', 'Qatar', 'Qatari', 'qa.png', '+974'),
(123, 'RO', 'Romania', 'Romanian', 'ro.png', '+40'),
(124, 'RW', 'Rwanda', 'Rwandan', 'rw.png', '+250'),
(125, 'KN', 'Saint Kitts and Nevis', 'Kittian and Nevisian', 'kn.png', '+1869'),
(126, 'LC', 'Saint Lucia', 'Saint Lucian', 'lc.png', '+1758'),
(127, 'WS', 'Samoa', 'Samoan', 'ws.png', '+685'),
(128, 'SM', 'San Marino', 'Sammarinese', 'sm.png', '+378'),
(129, 'ST', 'Sao Tome and Principe', 'Sao Tomean', 'st.png', '+239'),
(130, 'SA', 'Saudi Arabia', 'Saudi Arabian', 'sa.png', '+966'),
(131, 'SN', 'Senegal', 'Senegalese', 'sn.png', '+221'),
(132, 'SC', 'Seychelles', 'Seychellois', 'sc.png', '+248'),
(133, 'SL', 'Sierra Leone', 'Sierra Leonean', 'sl.png', '+232'),
(134, 'SG', 'Singapore', 'Singaporean', 'sg.png', '+65'),
(135, 'SK', 'Slovakia', 'Slovak', 'sk.png', '+421'),
(136, 'SI', 'Slovenia', 'Slovene', 'si.png', '+386'),
(137, 'SB', 'Solomon Islands', 'Solomon Islander', 'sb.png', '+677'),
(138, 'SO', 'Somalia', 'Somali', 'so.png', '+252'),
(139, 'ZA', 'South Africa', 'South African', 'za.png', '+27'),
(140, 'ES', 'Spain', 'Spanish', 'es.png', '+34'),
(141, 'LK', 'Sri Lanka', 'Sri Lankan', 'lk.png', '+94'),
(142, 'SD', 'Sudan', 'Sudanese', 'sd.png', '+249'),
(143, 'SR', 'Suriname', 'Surinamer', 'sr.png', '+597'),
(144, 'SZ', 'Swaziland', 'Swazi', 'sz.png', '+268'),
(145, 'SE', 'Sweden', 'Swedish', 'se.png', '+46'),
(146, 'CH', 'Switzerland', 'Swiss', 'ch.png', '+41'),
(147, 'TJ', 'Tajikistan', 'Tadzhik', 'tj.png', '+992'),
(148, 'TH', 'Thailand', 'Thai', 'th.png', '+66'),
(149, 'TG', 'Togo', 'Togolese', 'tg.png', '+228'),
(150, 'TO', 'Tonga', 'Tongan', 'to.png', '+676'),
(151, 'TT', 'Trinidad and Tobago', 'Trinidadian', 'tt.png', '+1868'),
(152, 'TN', 'Tunisia', 'Tunisian', 'tn.png', '+216'),
(153, 'TR', 'Turkey', 'Turkish', 'tr.png', '+90'),
(154, 'TM', 'Turkmenistan', 'Turkmen', 'tm.png', '+993'),
(155, 'TV', 'Tuvalu', 'Tuvaluan', 'tv.png', '+688'),
(156, 'UG', 'Uganda', 'Ugandan', 'ug.png', '+256'),
(157, 'UA', 'Ukraine', 'Ukrainian', 'ua.png', '+380'),
(158, 'AE', 'United Arab Emirates', 'Emirian', 'ae.png', '+971'),
(159, 'GB', 'United Kingdom', 'British', 'gb.png', '+44'),
(160, 'US', 'United States', 'American', 'us.png', '+1'),
(161, 'UY', 'Uruguay', 'Uruguayan', 'uy.png', '+598');

-- --------------------------------------------------------

--
-- Table structure for table `cp_ipns`
--

CREATE TABLE `cp_ipns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ipn_version` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ipn_type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ipn_mode` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ipn_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchant` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `status_text` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_ipn_descriptors`
--

CREATE TABLE `cp_ipn_descriptors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ipns_id` bigint(20) UNSIGNED NOT NULL,
  `ref_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `txn_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buyer_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom` text COLLATE utf8mb4_unicode_ci,
  `send_tx` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_confirms` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_log`
--

CREATE TABLE `cp_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `log` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_transactions`
--

CREATE TABLE `cp_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency1` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency2` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buyer_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buyer_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom` text COLLATE utf8mb4_unicode_ci,
  `ipn_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `txn_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirms_needed` tinyint(3) UNSIGNED NOT NULL,
  `timeout` int(10) UNSIGNED NOT NULL,
  `status_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qrcode_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_transfers`
--

CREATE TABLE `cp_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchant` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pbntag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auto_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `ref_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_withdrawals`
--

CREATE TABLE `cp_withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency2` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pbntag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dest_tag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ipn_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auto_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `note` text COLLATE utf8mb4_unicode_ci,
  `ref_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposit_addresses`
--

CREATE TABLE `deposit_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `coin_id` int(10) UNSIGNED NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dest_tag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `icos`
--

CREATE TABLE `icos` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_start_at` datetime DEFAULT NULL,
  `ico_end_at` datetime DEFAULT NULL,
  `additional_notes` longtext COLLATE utf8mb4_unicode_ci,
  `airdrop` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `feature_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `whitelist` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `token_sale_hard_cap` decimal(32,8) DEFAULT NULL,
  `token_sale_hard_cap_currency` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_sale_soft_cap` decimal(32,8) DEFAULT NULL,
  `token_sale_soft_cap_currency` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presale` enum('yes','no','tbd') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presale_start_at` datetime DEFAULT NULL,
  `presale_end_at` datetime DEFAULT NULL,
  `token_symbol` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_type_and_platform` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_distribution` mediumtext COLLATE utf8mb4_unicode_ci,
  `price_per_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `participation_restriction` text COLLATE utf8mb4_unicode_ci,
  `selling_to_us_canada` tinyint(1) DEFAULT NULL,
  `accept_coin` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `listing_exchange` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_info` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` json NOT NULL,
  `involvement` json NOT NULL,
  `contact_person_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person_telegram` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marketing_services` json DEFAULT NULL,
  `listing_fee` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `how_you_hear_about_us` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish_status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kyc_documents`
--

CREATE TABLE `kyc_documents` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_card_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_doc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_proof` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_proof_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_proof_doc_front` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_proof_doc_back` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 => Pending, 1 => Approved, 2 => Rejected',
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `kyc_documents`
--
DELIMITER $$
CREATE TRIGGER `after_insert_kyc_documents` AFTER INSERT ON `kyc_documents` FOR EACH ROW INSERT INTO `hotbtc_exchange_demo`.`kyc_documents`
(`id`,`user_id`,`code`,`first_name`, `middle_name`, `last_name`, `pan_card_no`, `pan_doc`, `dob`, `address`, `state`, `pin`, `address_proof`,`address_proof_no`,`address_proof_doc_front`,`address_proof_doc_back`, `status`, `remarks`, `created_at`, `updated_at`) values
  (NEW.id, NEW.user_id, NEW.code, NEW.first_name, NEW.middle_name, NEW.last_name, NEW.pan_card_no, NEW.pan_doc, NEW.dob, NEW.address, NEW.state, NEW.pin, NEW.address_proof, NEW.address_proof_no, NEW.address_proof_doc_front, NEW.address_proof_doc_back, NEW.status, NEW.remarks, NEW.created_at, NEW.updated_at)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `last_month_trade_volume`
--
CREATE TABLE `last_month_trade_volume` (
`user_id` int(10) unsigned
,`coin_pair_id` int(10) unsigned
,`volume` double
,`fees` double
);

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` int(10) UNSIGNED NOT NULL,
  `ico_id` int(10) UNSIGNED NOT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whitepaper` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slack` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telegram` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reddit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bitcointalk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medium` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discord` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `airdrop` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `heading` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paybacks`
--

CREATE TABLE `paybacks` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `coin_pair_id` int(10) UNSIGNED NOT NULL,
  `revert_type` enum('profit','fees') COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` decimal(30,8) NOT NULL,
  `volume_in_usd` decimal(30,8) NOT NULL,
  `fees` decimal(30,8) NOT NULL,
  `rate_in_usd` decimal(15,8) NOT NULL,
  `usd_to_revert` decimal(15,8) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirm` tinyint(4) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre_orders`
--

CREATE TABLE `pre_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `coin_pair_id` int(10) UNSIGNED NOT NULL,
  `type` enum('stop-limit','limit','market') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'stop-limit',
  `side` enum('buy','sell') COLLATE utf8mb4_unicode_ci NOT NULL,
  `trigger` decimal(30,2) UNSIGNED NOT NULL COMMENT 'this is a stop price, from where condition will be picked up',
  `rate` decimal(30,2) UNSIGNED NOT NULL COMMENT 'this is a rate on which order will be placed',
  `amount` decimal(30,2) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `price_quotes`
--

CREATE TABLE `price_quotes` (
  `id` int(11) NOT NULL,
  `symbol` varchar(100) NOT NULL,
  `price` decimal(30,8) NOT NULL,
  `type` enum('FOREX','CRYPTO') NOT NULL DEFAULT 'CRYPTO',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `ide_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ide_proof_photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','subscriber') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'subscriber',
  `referral_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` enum('self','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `verification_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret_two_fa` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_two_fa` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 => Active, 1 => Inactive',
  `kyc` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 => Inactive, 1 => Active',
  `verified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `address`, `city`, `state`, `zip`, `phone`, `country_id`, `dob`, `ide_no`, `ide_proof_photo`, `avatar`, `role`, `referral_code`, `created_by`, `verification_token`, `secret_two_fa`, `status_two_fa`, `kyc`, `status`, `verified_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, '8099 Adeline BurgsBartonborough, SD 50074', 'Mattbury', 'Florida', '56009-2170', '+1.691.927.5976', 87, '2000-02-12', '798-38-4189', 'https://lorempixel.com/640/480/?48288', '1/V1dSOgXqsLiQRnVRyPwPVwVWLCQUDU10aZvm3uho.jpeg', 'admin', 'REF-5ae6fdb94f215', 'admin', 'WrauM7q2icoxCky2GNlJDg45jIte1B7OPdKocMpK8TF6ozCeTWbpSTtkfZzL', NULL, 0, 0, 1, '2019-03-09 07:30:13', NULL, '2018-04-30 11:27:53', '2019-03-09 02:00:13');

--
-- Triggers `profiles`
--
DELIMITER $$
CREATE TRIGGER `after_insert_profile` AFTER INSERT ON `profiles` FOR EACH ROW INSERT INTO `hotbtc_exchange_demo`.`profiles`
(`id`, `user_id`, `country_id`, `address`, `city`, `state`, `zip`, `phone`, `dob`, `ide_no`, `ide_proof_photo`,`avatar`,`role`,`referral_code`, `created_by`,`verification_token`, `secret_two_fa`, `status_two_fa`, `status`, `verified_at`, `deleted_at`, `created_at`, `updated_at`) values
(NEW.id, NEW.user_id, NEW.country_id, NEW.address, NEW.city, NEW.state, NEW.zip, NEW.phone, NEW.dob, NEW.ide_no, NEW.ide_proof_photo, NEW.avatar, NEW.role, NEW.referral_code, NEW.created_by, NEW.verification_token, NEW.secret_two_fa, NEW.status_two_fa, NEW.status, NEW.verified_at, NEW.deleted_at, NEW.created_at, NEW.updated_at)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'withdrawal_commission', '10', NULL, '2018-05-23 11:19:50', '2018-05-30 09:17:23'),
(2, 'deposit_fee', '0', NULL, '2018-05-23 11:19:50', '2018-05-30 09:17:23'),
(3, 'transfer_fee', '0', NULL, '2018-05-23 11:19:50', '2018-05-30 09:17:23'),
(6, 'max_referral_level', '1', NULL, '2018-06-06 05:36:34', '2019-03-05 03:06:01'),
(7, 'REFERRAL_LEVEL_1', '10', NULL, '2018-06-06 05:36:34', '2019-03-05 03:06:01'),
(8, 'REFERRAL_LEVEL_2', '0', NULL, '2018-06-06 05:36:34', '2018-06-06 05:36:34'),
(9, 'REFERRAL_LEVEL_3', '0', NULL, '2018-06-06 05:36:34', '2018-06-06 05:36:34'),
(10, 'REFERRAL_LEVEL_4', '0', NULL, '2018-06-06 05:36:34', '2018-06-06 05:36:34'),
(11, 'REFERRAL_LEVEL_5', '0', NULL, '2018-06-06 05:36:34', '2018-06-06 05:36:34'),
(12, 'taker_fee', '.1', NULL, '2019-03-06 00:38:34', '2019-03-06 00:38:52'),
(13, 'maker_fee', '.1', NULL, '2019-03-06 00:38:35', '2019-03-06 00:38:53'),
(14, 'limit_till_kyc_completion', '10000', NULL, '2019-03-06 00:38:35', '2019-03-06 00:38:53');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(10) UNSIGNED NOT NULL,
  `ico_id` int(10) UNSIGNED NOT NULL,
  `type` enum('core','advisory') COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trades`
--

CREATE TABLE `trades` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `coin_pair_id` int(10) UNSIGNED NOT NULL,
  `method` enum('limit','market','stop-limit') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'limit',
  `trigger` decimal(30,8) DEFAULT NULL,
  `price` double NOT NULL,
  `volume` double NOT NULL,
  `fees` double NOT NULL,
  `type` enum('buy','sell') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 => Ongoing, 1 => Closed, 2 => Cancelled',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `coin_id` int(10) UNSIGNED NOT NULL,
  `trade_id` int(10) UNSIGNED DEFAULT NULL,
  `source` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Credit','Debit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 => Incomplete, 1 => Complete, 2 => Failed',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `referred_by` int(10) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `referred_by`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Obie', NULL, 'Howell', 'info@hotbtc.exchange', '$2y$10$44RiPUkZDWyod337xFwYwOqLh5KYO1vmN0KOLiZB.i9vP9U8uyAZS', NULL, 'y2W0tK6fmD3ctPXxREnH89Bh68icjSbY7HCS1ZvD990C2qCPUizLFBXvuVaP', NULL, '2018-04-30 11:27:53', '2018-10-08 02:17:56');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `after_insert_users` AFTER INSERT ON `users` FOR EACH ROW INSERT INTO `hotbtc_exchange_demo`.`users`
(`id`,`first_name`,`middle_name`,`last_name`, `email`, `password`, `referred_by`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) values
  (NEW.id, NEW.first_name, NEW.middle_name, NEW.last_name, NEW.email, NEW.password, NEW.referred_by, NEW.remember_token, NEW.deleted_at, NEW.created_at, NEW.updated_at)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `client` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `verifications`
--

CREATE TABLE `verifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` enum('email','mobile','kyc') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 => Pending, 1 => Approved, 2 => Rejected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `verifications`
--
DELIMITER $$
CREATE TRIGGER `after_insert_verifications` AFTER INSERT ON `verifications` FOR EACH ROW INSERT INTO `hotbtc_exchange_demo`.`verifications` (`id`, `user_id`, `type`, `status`, `created_at`, `updated_at`) values (NEW.id,NEW.user_id,NEW.type,NEW.status,NEW.created_at,NEW.updated_at)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `withdraws`
--

CREATE TABLE `withdraws` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `coin_id` int(10) UNSIGNED NOT NULL,
  `coin_transaction_id` int(10) UNSIGNED DEFAULT NULL,
  `transaction_id` int(10) UNSIGNED DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dest_tag` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(65,8) UNSIGNED NOT NULL,
  `fees` double(65,8) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `last_month_trade_volume`
--
DROP TABLE IF EXISTS `last_month_trade_volume`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `last_month_trade_volume`  AS  select `trades`.`user_id` AS `user_id`,`trades`.`coin_pair_id` AS `coin_pair_id`,sum((`trades`.`price` * `trades`.`volume`)) AS `volume`,sum(`trades`.`fees`) AS `fees` from `trades` where ((`trades`.`status` = 1) and (year(`trades`.`updated_at`) = year((curdate() - interval 1 month))) and (month(`trades`.`updated_at`) = month((curdate() - interval 1 month)))) group by `trades`.`user_id`,`trades`.`coin_pair_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_user_id_foreign` (`user_id`);

--
-- Indexes for table `coins`
--
ALTER TABLE `coins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coin_for_lists`
--
ALTER TABLE `coin_for_lists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coin_for_lists_coin_symbol_unique` (`coin_symbol`),
  ADD KEY `coin_for_lists_user_id_foreign` (`user_id`),
  ADD KEY `coin_for_lists_coin_id_foreign` (`coin_id`);

--
-- Indexes for table `coin_pairs`
--
ALTER TABLE `coin_pairs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coin_pairs_coin_id_foreign` (`coin_id`),
  ADD KEY `coin_pairs_base_coin_id_foreign` (`base_coin_id`),
  ADD KEY `coin_pairs_listed_by_foreign` (`listed_by`);

--
-- Indexes for table `coin_transactions`
--
ALTER TABLE `coin_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coin_transactions_user_id_foreign` (`user_id`),
  ADD KEY `coin_transactions_coin_id_foreign` (`coin_id`),
  ADD KEY `coin_transactions_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `coin_wallet_balances`
--
ALTER TABLE `coin_wallet_balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coin_wallet_balances_coin_id_foreign` (`coin_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_code_unique` (`code`);

--
-- Indexes for table `cp_ipns`
--
ALTER TABLE `cp_ipns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_ipns_ipn_id_unique` (`ipn_id`);

--
-- Indexes for table `cp_ipn_descriptors`
--
ALTER TABLE `cp_ipn_descriptors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_log`
--
ALTER TABLE `cp_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_transactions`
--
ALTER TABLE `cp_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_transactions_txn_id_unique` (`txn_id`);

--
-- Indexes for table `cp_transfers`
--
ALTER TABLE `cp_transfers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_transfers_ref_id_unique` (`ref_id`);

--
-- Indexes for table `cp_withdrawals`
--
ALTER TABLE `cp_withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_withdrawals_ref_id_unique` (`ref_id`);

--
-- Indexes for table `deposit_addresses`
--
ALTER TABLE `deposit_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `icos`
--
ALTER TABLE `icos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `icos_slug_unique` (`slug`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `kyc_documents`
--
ALTER TABLE `kyc_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kyc_documents_user_id_foreign` (`user_id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `links_ico_id_foreign` (`ico_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `paybacks`
--
ALTER TABLE `paybacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `revert_amounts_user_id_foreign` (`user_id`),
  ADD KEY `revert_amounts_coin_pair_id_foreign` (`coin_pair_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pre_orders`
--
ALTER TABLE `pre_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pre_orders_user_id_foreign` (`user_id`),
  ADD KEY `pre_orders_coin_pair_id_foreign` (`coin_pair_id`);

--
-- Indexes for table `price_quotes`
--
ALTER TABLE `price_quotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`),
  ADD KEY `profiles_country_id_foreign` (`country_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_ico_id_foreign` (`ico_id`);

--
-- Indexes for table `trades`
--
ALTER TABLE `trades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trades_user_id_foreign` (`user_id`),
  ADD KEY `trades_coin_pair_id_foreign` (`coin_pair_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_code_unique` (`code`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_coin_id_foreign` (`coin_id`),
  ADD KEY `transactions_trade_id_foreign` (`trade_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verifications`
--
ALTER TABLE `verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `withdraws`
--
ALTER TABLE `withdraws`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdraws_user_id_foreign` (`user_id`),
  ADD KEY `withdraws_coin_id_foreign` (`coin_id`),
  ADD KEY `withdraws_coin_transaction_id_foreign` (`coin_transaction_id`),
  ADD KEY `withdraws_transaction_id_foreign` (`transaction_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `coins`
--
ALTER TABLE `coins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `coin_for_lists`
--
ALTER TABLE `coin_for_lists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `coin_pairs`
--
ALTER TABLE `coin_pairs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `coin_transactions`
--
ALTER TABLE `coin_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `coin_wallet_balances`
--
ALTER TABLE `coin_wallet_balances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;
--
-- AUTO_INCREMENT for table `cp_ipns`
--
ALTER TABLE `cp_ipns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cp_ipn_descriptors`
--
ALTER TABLE `cp_ipn_descriptors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cp_log`
--
ALTER TABLE `cp_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cp_transactions`
--
ALTER TABLE `cp_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cp_transfers`
--
ALTER TABLE `cp_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cp_withdrawals`
--
ALTER TABLE `cp_withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `deposit_addresses`
--
ALTER TABLE `deposit_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `icos`
--
ALTER TABLE `icos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;
--
-- AUTO_INCREMENT for table `kyc_documents`
--
ALTER TABLE `kyc_documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `paybacks`
--
ALTER TABLE `paybacks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pre_orders`
--
ALTER TABLE `pre_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `price_quotes`
--
ALTER TABLE `price_quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trades`
--
ALTER TABLE `trades`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=304;
--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `verifications`
--
ALTER TABLE `verifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `withdraws`
--
ALTER TABLE `withdraws`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `coin_for_lists`
--
ALTER TABLE `coin_for_lists`
  ADD CONSTRAINT `coin_for_lists_coin_id_foreign` FOREIGN KEY (`coin_id`) REFERENCES `coins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coin_for_lists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `coin_pairs`
--
ALTER TABLE `coin_pairs`
  ADD CONSTRAINT `coin_pairs_base_coin_id_foreign` FOREIGN KEY (`base_coin_id`) REFERENCES `coins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coin_pairs_coin_id_foreign` FOREIGN KEY (`coin_id`) REFERENCES `coins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coin_pairs_listed_by_foreign` FOREIGN KEY (`listed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `coin_transactions`
--
ALTER TABLE `coin_transactions`
  ADD CONSTRAINT `coin_transactions_coin_id_foreign` FOREIGN KEY (`coin_id`) REFERENCES `coins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coin_transactions_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coin_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
