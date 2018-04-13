-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Värd: localhost
-- Tid vid skapande: 09 dec 2017 kl 14:10
-- Serverversion: 10.1.28-MariaDB
-- PHP-version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `Dreamshop`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `cart`
--

CREATE TABLE `cart` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` int(5) NOT NULL,
  `cart_order_id` int(11) NOT NULL,
  `single_amount` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `lager`
--

CREATE TABLE `lager` (
  `product_id` int(20) NOT NULL,
  `product_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `product_image` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `product_price` decimal(30,0) NOT NULL,
  `product_description` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumpning av Data i tabell `lager`
--

INSERT INTO `lager` (`product_id`, `product_name`, `product_image`, `product_price`, `product_description`) VALUES
(1, 'DEVICE', 'images/device1.jpg', '2000', 'After many years of studies we are happy to present you this device which will let you experience dreams like you never did before. Put it on your head and go to sleep ... and then fasten your seat belts.'),
(2, 'HORROR', 'images/horror.jpg', '500', 'We hope you are not a faint of heart if you want to try our Horror experience. Be the survivor in a zombie apocalypse or take a tour in the haunted castle. Whatever you decide be ready, this is not a piece of cake.'),
(3, 'FANTASY', 'images/fantasy.jpg', '500', 'Do you remember those long nights spent around a table playing D&D? Well now you can really go head to head with that vicious band of orcs that is terrorizing your village, or try to sneak behind the sleeping dragon to steal his treasure.\r\nA never ending adventure awaits you already tonight.'),
(4, 'SCI-FI', 'images/scifi.jpg', '500', 'Once upon a time in a far away galaxy ... this can be the start of your biggest adventure. Travel among the stars, discover unexplored planets, fly your star-fighter ship in the heat of a galactic battle, or choose humans or robots\' side in a cyberpunk-like future.\r\nEverything\'s possible with our Sci-Fi experience. '),
(5, 'MONEY MONEY MONEY', 'images/money.jpg', '500', 'Have you ever wondered what is like to be a millionaire? No more wondering with the MONEY MONEY MONEY dream. Drive the fastest cars, visit exotic islands, fly your private jet and rock the wildest party on your super deluxe yacht. There is very little money can\'t buy and you are going to find it out. Average John Doe by day and king for a night ... or many nights, it\'s only up to you.'),
(6, 'SENSUAL', 'images/sexy.jpg', '1000', 'Do you want to spice up your life? Then look no further as you are about to feel unbelievable pleasure. Soft or wild, depending on your taste, doesn\'t really matter ... Your life is never gonna be the same. Dreaming is not a sin so put your inhibitions aside and have fun.\r\n\r\nUser must be over 18 to purchase this product');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `user_first` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_last` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_birth` date NOT NULL,
  `user_uid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_pwd` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `user_order`
--

CREATE TABLE `user_order` (
  `order_id` int(10) NOT NULL,
  `user_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `order_status` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `update_time` date NOT NULL,
  `order_amount` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `lager`
--
ALTER TABLE `lager`
  ADD PRIMARY KEY (`product_id`);

--
-- Index för tabell `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Index för tabell `user_order`
--
ALTER TABLE `user_order`
  ADD PRIMARY KEY (`order_id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT för tabell `lager`
--
ALTER TABLE `lager`
  MODIFY `product_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT för tabell `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT för tabell `user_order`
--
ALTER TABLE `user_order`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
