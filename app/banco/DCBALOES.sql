-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql211.byetcluster.com
-- Tempo de geração: 15/04/2026 às 07:19
-- Versão do servidor: 11.4.10-MariaDB
-- Versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `if0_41664812_DCBaloes`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `balloonproduct`
--

CREATE TABLE `balloonproduct` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `image_url` text DEFAULT NULL,
  `base_price` decimal(10,2) DEFAULT 0.00,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `image_url2` text DEFAULT NULL,
  `image_url3` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `balloonproduct`
--

INSERT INTO `balloonproduct` (`id`, `name`, `description`, `category`, `image_url`, `base_price`, `is_active`, `created_at`, `image_url2`, `image_url3`) VALUES
(1, 'TESTANDO', 'SO TESTANDO', 'BALÃO PERSONALIZADO ', 'uploads/img_69dea5c581069.jpg', '0.00', 1, '2026-04-14 17:17:14', 'uploads/img_69dea5c581312.webp', 'uploads/img_69dea5c581468.png'),
(2, 'TESTE', 'SDSFDS', 'ARRANJO', 'uploads/img_69dec50a78a71.jpeg', '0.00', 1, '2026-04-14 19:51:54', 'uploads/img_69dec50a78d3f.png', 'uploads/img_69dec50a78f27.png'),
(3, 'ARRANJO', 'hndfgb', 'ARRANJO', 'uploads/img_69decff83f457.png', '0.00', 1, '2026-04-14 16:38:32', 'uploads/img_69decff83f592.png', 'uploads/img_69decff83f680.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pricecalculation`
--

CREATE TABLE `pricecalculation` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `material_cost` decimal(10,2) NOT NULL,
  `labor_hours` decimal(10,2) DEFAULT NULL,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `delivery_fee` decimal(10,2) DEFAULT 0.00,
  `other_costs` decimal(10,2) DEFAULT 0.00,
  `markup_percentage` decimal(10,2) NOT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `final_price` decimal(10,2) DEFAULT NULL,
  `profit` decimal(10,2) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `client_name` varchar(255) DEFAULT NULL,
  `service_type` varchar(100) DEFAULT NULL,
  `client_phone` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pricecalculation`
--

INSERT INTO `pricecalculation` (`id`, `name`, `material_cost`, `labor_hours`, `hourly_rate`, `delivery_fee`, `other_costs`, `markup_percentage`, `total_cost`, `final_price`, `profit`, `created_date`, `client_name`, `service_type`, `client_phone`, `description`) VALUES
(2, 'ARRANJO', '30.00', '3.00', '25.00', '15.00', '0.00', '25.00', NULL, '150.00', NULL, '2026-04-14 17:52:58', 'MARCELE BRANDÃO', 'TESTE', '71993265132', 'TESTANDO'),
(4, 'xxxxx', '50.00', '2.00', '25.00', '0.00', '0.00', '20.00', NULL, '120.00', NULL, '2026-04-14 17:22:17', 'fia', 'TESTE', '71991634794', 'TESTANDO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `service_description` text DEFAULT NULL,
  `min_value` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `services`
--

INSERT INTO `services` (`id`, `service_name`, `service_description`, `min_value`) VALUES
(1, 'ARRANJO', 'TESTANDO', '85.00'),
(3, 'BALÃO PERSONALIZADO ', 'DFDS', '25.00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL DEFAULT 1,
  `default_hourly_rate` decimal(10,2) DEFAULT 0.00,
  `default_markup_percentage` decimal(10,2) DEFAULT 0.00,
  `whatsapp_number` varchar(20) DEFAULT NULL
) ;

--
-- Despejando dados para a tabela `settings`
--

INSERT INTO `settings` (`id`, `default_hourly_rate`, `default_markup_percentage`, `whatsapp_number`) VALUES
(1, '25.00', '25.00', '71991634794');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `nivel` varchar(20) DEFAULT 'admin',
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `reset_token`, `token_expiry`, `created_at`, `nivel`, `status`) VALUES
(3, 'Talita Castro Freitas', 'talitacastrofreitas@gmail.com', '$2y$10$l0IrBJWX.SKH1HAJM5IcmeNqnAaCgZTbIrMGv.XvyZWaBYMcg46YG', '575685', '2026-04-14 18:45:34', '2026-04-14 20:06:31', 'super_admin', 1),
(6, 'Daiana Castro Freitas Silva', 'daianacastrofreitas1997@gmail.com', '$2y$10$I3Ryjxyl85oGww/SjVR/peZjvdbdW7gYmEcWMwBg/HdXKHU9nh1im', NULL, NULL, '2026-04-14 16:40:39', 'admin', 1);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `balloonproduct`
--
ALTER TABLE `balloonproduct`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pricecalculation`
--
ALTER TABLE `pricecalculation`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `balloonproduct`
--
ALTER TABLE `balloonproduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `pricecalculation`
--
ALTER TABLE `pricecalculation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
