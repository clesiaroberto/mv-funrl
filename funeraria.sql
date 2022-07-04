-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2021 at 11:10 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `funeraria`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `estado`) VALUES
(1, 'Acessórios', 1),
(2, 'Equipamentos', 1),
(3, 'Flores', 1),
(4, 'Serviços', 1),
(5, 'Pedra tumular', 0),
(6, 'Transporte', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nome` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `apelido` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `genero` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `nacionalidadeid` int(11) NOT NULL,
  `nascimento` date NOT NULL,
  `contacto_1` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `contacto_2` int(11) NOT NULL,
  `email` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `cidade` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Obter cidade do Cliente',
  `ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Obter ip do Cliente',
  `pais` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Obter país do Cliente',
  `estado` int(11) NOT NULL DEFAULT 1,
  `registo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`id`, `nome`, `apelido`, `genero`, `nacionalidadeid`, `nascimento`, `contacto_1`, `contacto_2`, `email`, `cidade`, `ip`, `pais`, `estado`, `registo`) VALUES
(1, 'Clesia', 'Roberto', 'F', 1, '1998-02-05', '8787878778', 2147483647, 'clesiaroberto@yahoo.com', '', NULL, '', 1, '2020-08-15 12:46:22'),
(2, 'Elton', 'Bruno', 'M', 1, '1990-02-05', '840000000', 840000000, 'echidjoto@gmail.com', '', NULL, '', 1, '2020-08-17 23:50:52'),
(20, 'Roldao', 'Martin', 'M', 1, '1989-02-05', '820001025', 865000233, 'Martin@hotmail.com', '', NULL, '', 1, '2020-08-24 10:11:52'),
(21, 'Climara', 'Miluna', 'F', 1, '1991-02-06', '820201025', 845022000, 'miluna@outlook.com', '', NULL, '', 1, '2020-08-26 23:03:39'),
(23, 'Martina', 'Pinheiro', 'F', 1, '1987-05-06', '845455852', 823269741, 'pinheiro@gmail.com', '', NULL, '', 1, '2020-08-28 01:09:45'),
(28, 'Yolanda', 'Chale', 'F', 1, '1996-02-08', '825850255', 82525888, 'chale@gmail.com', '', NULL, '', 1, '2020-08-31 10:59:09'),
(32, 'tw', 'te', 'M', 1, '2000-05-10', '875432136', 90890987, 'benphine88@gmail.com', '', NULL, '', 1, '2020-09-10 17:00:24'),
(34, 'Ruina', 'Piloa', 'F', 2, '2020-12-18', '820000000', 850000005, 'piloa@gmail.com', '', NULL, '', 1, '2020-12-18 12:59:57'),
(35, 'Madalena', 'Chuva', 'M', 1, '1958-12-24', '845896003', 2147483647, 'chuva@gmail.com', '', NULL, '', 1, '2020-12-26 14:41:37'),
(36, 'Elton', 'Chidjoto', 'M', 1, '2021-12-23', '823896874', 823569855, 'chidjoto@gmail.com', NULL, NULL, NULL, 1, '2021-12-02 19:21:52');

-- --------------------------------------------------------

--
-- Table structure for table `cor`
--

CREATE TABLE `cor` (
  `id` int(11) NOT NULL,
  `nome_cor` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cor`
--

INSERT INTO `cor` (`id`, `nome_cor`) VALUES
(1, '#6f7B24'),
(2, '#23f236'),
(3, '#000'),
(4, '#e0b8bb'),
(5, '#fff'),
(6, '#ff05c0');

-- --------------------------------------------------------

--
-- Table structure for table `cotacao`
--

CREATE TABLE `cotacao` (
  `id` int(11) NOT NULL,
  `ref_compra` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `clienteid` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `desconto` decimal(10,2) NOT NULL,
  `desconto_promo` decimal(10,2) NOT NULL,
  `preco_total` decimal(10,2) NOT NULL,
  `dia_processamento` date NOT NULL,
  `hora_processamento` time NOT NULL,
  `dia_entrega` date DEFAULT NULL,
  `hora_entrega` time DEFAULT NULL,
  `taxa_envio` int(11) NOT NULL,
  `modo_pagamento` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero_conta` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cotacao`
--

INSERT INTO `cotacao` (`id`, `ref_compra`, `clienteid`, `subtotal`, `desconto`, `desconto_promo`, `preco_total`, `dia_processamento`, `hora_processamento`, `dia_entrega`, `hora_entrega`, `taxa_envio`, `modo_pagamento`, `numero_conta`, `estado`) VALUES
(1, 'PH.2020.08.0000.1', 1, '0.00', '0.00', '0.00', '0.00', '2020-08-17', '23:33:05', NULL, NULL, 0, '', '0', 0),
(7, 'PH.2020.08.0000.2', 2, '402000.00', '0.00', '0.00', '402000.00', '2020-08-18', '12:12:33', NULL, NULL, 0, 'Transferência', '0', 1),
(13, 'PH.2020.08.0000.3', 20, '17600.00', '0.00', '0.00', '17600.00', '2020-08-24', '10:59:29', NULL, NULL, 0, 'M-pesa', '0', 1),
(14, 'PH.2020.08.0000.4', 21, '0.00', '0.00', '0.00', '0.00', '2020-08-26', '23:04:50', NULL, NULL, 0, '', '0', 0),
(17, 'PH.2020.12.0000.5', 34, '35100.00', '0.00', '0.00', '35100.00', '2020-12-18', '13:00:22', NULL, NULL, 0, 'Visa', '0', 1),
(18, 'PH.2020.12.0000.6', 28, '23400.00', '0.00', '0.00', '23400.00', '2020-12-18', '14:34:06', NULL, NULL, 0, 'Transferência', '0', 1),
(19, 'PH.2020.12.0000.7', 28, '0.00', '0.00', '0.00', '0.00', '2020-12-18', '14:50:13', NULL, NULL, 0, '', NULL, 0),
(20, 'PH.2020.12.0000.8', 2, '0.00', '0.00', '0.00', '0.00', '2020-12-26', '09:32:31', NULL, NULL, 0, '', NULL, 0),
(21, 'PH.2020.12.0000.9', 35, '0.00', '0.00', '0.00', '0.00', '2020-12-26', '14:42:05', NULL, NULL, 0, '', NULL, 0),
(22, 'PH.2021.01.0001.1', 34, '0.00', '0.00', '0.00', '0.00', '2021-01-15', '20:54:04', NULL, NULL, 0, '', NULL, 0),
(24, 'PH.2021.12.0001.2', 36, '12400.00', '0.00', '0.00', '12400.00', '2021-12-02', '19:27:56', NULL, NULL, 0, 'Visa', '823896874 / 823569855', 1),
(25, 'PH.2021.12.0001.3', 36, '225400.00', '0.00', '0.00', '225400.00', '2021-12-02', '22:50:03', NULL, NULL, 0, 'M-pesa', '823896874 / 823569855', 1);

-- --------------------------------------------------------

--
-- Table structure for table `endereco`
--

CREATE TABLE `endereco` (
  `id` int(11) NOT NULL,
  `av_bairro` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `rua` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `nr_casa` int(11) NOT NULL,
  `clienteid` int(11) NOT NULL,
  `activo` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `endereco`
--

INSERT INTO `endereco` (`id`, `av_bairro`, `rua`, `nr_casa`, `clienteid`, `activo`) VALUES
(1, 'Cabral', 'ewrw', 0, 1, 1),
(2, 'Manduca', 'Farmacia', 0, 2, 0),
(20, 'Eduardo Mondlane', '280', 0, 20, 1),
(21, 'Malhagalene', '304', 0, 21, 1),
(23, '24 de Julho', '154', 58, 23, 1),
(32, '24', '03', 6, 32, 1),
(34, 'Agostinho Neto', '723837', 8555, 34, 1),
(35, 'Agostinho', '1879', 698, 28, 1),
(36, 'Mavalane', 'Natal', 15, 35, 1),
(43, 'Infulene', '34', 5688, 2, 1),
(44, 'Manduca', 'Farmacia', 214, 36, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id` int(11) NOT NULL,
  `fornecedor` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `produtoid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fornecedor`
--

INSERT INTO `fornecedor` (`id`, `fornecedor`, `descricao`, `produtoid`) VALUES
(1, 'Flor Bela', 'Lium ment giro flmh', 301001),
(2, 'Garopia', 'Vocndm skdksdjm alsk', 301001),
(3, 'Hummana', 'dsaf asldfusdl soaudfhsa sudhfash sduhfasiilsdbfs sdufuds', 321001),
(4, 'Julia maria', 'Lum po fula', 301001);

-- --------------------------------------------------------

--
-- Table structure for table `marca`
--

CREATE TABLE `marca` (
  `id` int(11) NOT NULL,
  `nome_marca` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `marca`
--

INSERT INTO `marca` (`id`, `nome_marca`, `estado`) VALUES
(1, 'Pioneer', 1),
(2, 'Sony', 1),
(3, 'Floress', 1),
(4, 'Fonestar', 1),
(5, 'Samsung', 1),
(6, 'Toyota', 1),
(7, 'Ford', 1),
(8, 'Cadelac', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nacionalidade`
--

CREATE TABLE `nacionalidade` (
  `id` int(11) NOT NULL,
  `nome` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nacionalidade`
--

INSERT INTO `nacionalidade` (`id`, `nome`) VALUES
(1, 'Moçambicana'),
(2, 'Sul africana');

-- --------------------------------------------------------

--
-- Table structure for table `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `img` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `categoriaid` int(11) NOT NULL,
  `subcategoriaid` int(11) NOT NULL,
  `nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `modelo` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `descricao` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `info` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `marcaid` int(11) NOT NULL,
  `preco` int(11) NOT NULL,
  `tamanhoid` int(11) NOT NULL,
  `unidade` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `corid` int(11) NOT NULL,
  `stock` int(1) NOT NULL DEFAULT 1,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `produto`
--

INSERT INTO `produto` (`id`, `img`, `codigo`, `categoriaid`, `subcategoriaid`, `nome`, `modelo`, `descricao`, `info`, `marcaid`, `preco`, `tamanhoid`, `unidade`, `corid`, `stock`, `estado`) VALUES
(1, 'IMG0212001', '0212001', 2, 12, 'Pioneer', 'XPRS-215S', 'The Vans All-Weather MTE Collection designed.', '', 1, 1500, 1, '1un', 2, 1, 1),
(2, 'IMG0212002', '0212002', 2, 12, 'Fonestar', 'ASB-880U', 'The Vans All-Weather MTE Collection designed.', '', 4, 2000, 1, '5un', 1, 1, 1),
(3, 'IMG0220001', '0220001', 2, 20, 'Microphone', 'XM8500', 'The Vans All-Weather MTE Collection designed.', '', 4, 34300, 2, '1un', 3, 1, 1),
(4, 'IMG0212003', '0212003', 2, 12, 'Pioneer', 'SL-250', 'The Vans All-Weather MTE Collection designed.', '', 1, 50000, 2, '1un', 3, 1, 1),
(5, 'IMG0321001', '0321001', 3, 21, 'Floress', '', 'The Vans All-Weather MTE Collection designed.', '', 3, 700, 1, '1un', 4, 1, 1),
(6, 'IMG0110001', '0110001', 1, 10, 'Cadelac', 'Virro', 'The Vans All-Weather MTE Collection designed.', '', 8, 200000, 1, '-', 3, 1, 1),
(7, 'IMG0301001', '0301001', 3, 1, 'Maria flo', '', 'Rosa com aromante', 'Ambitioni dedisse scripsisse iudicaretur. Cras mattis iudicium purus sit amet fermentum. Donec sed odio operae, eu vulputate felis rhoncus. Praeterea iter est quasdam res quas ex communi. At nos hinc posthac, sitientis piros Afros. Petierunt uti sibi conc', 3, 900, 1, '1un', 6, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `recuperar`
--

CREATE TABLE `recuperar` (
  `id` int(11) NOT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `recuperar`
--

INSERT INTO `recuperar` (`id`, `email`) VALUES
(1, 'clesia@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `rec_cotacao`
--

CREATE TABLE `rec_cotacao` (
  `id` int(11) NOT NULL,
  `ref_compraid` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `fornecedorid` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `dias_trans` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `taxa_trans` int(11) NOT NULL,
  `qtd` int(11) DEFAULT NULL,
  `preco_un` int(11) NOT NULL,
  `preco_venda` int(11) NOT NULL,
  `dataHora` datetime NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rec_cotacao`
--

INSERT INTO `rec_cotacao` (`id`, `ref_compraid`, `email`, `codigo`, `item`, `fornecedorid`, `descricao`, `dias_trans`, `taxa_trans`, `qtd`, `preco_un`, `preco_venda`, `dataHora`, `estado`) VALUES
(129, 'PH.2020.08.0000.4', 'miluna@outlook.com', '0611001', '', '0', 'TT', '3', 1800, 2, 30000, 65400, '2020-08-26 23:04:50', 0),
(130, 'PH.2020.08.0000.4', 'miluna@outlook.com', '0220001', '', '0', 'XM8500', NULL, 0, 1, 34300, 34300, '2020-08-26 23:05:02', 0),
(140, 'PH.2020.08.0000.1', 'clesiaroberto@yahoo.com', '0301001', '', '0', '-', '1', 1800, 1, 900, 900, '2020-08-28 16:00:20', 0),
(143, 'PH.2020.08.0000.1', 'clesiaroberto@yahoo.com', '0220001', '', '0', 'XM8500', '1', 1800, 1, 34300, 34300, '2020-08-28 22:12:08', 0),
(160, 'PH.2020.08.0000.2', 'echidjoto@gmail.com', '0110001', 'Cadelac', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 2, 200000, 400000, '2020-12-18 07:31:27', 1),
(162, 'PH.2020.08.0000.2', 'echidjoto@gmail.com', '0212002', 'Fonestar', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 1, 2000, 2000, '2020-12-18 07:56:24', 1),
(163, 'PH.2020.12.0000.5', 'piloa@gmail.com', '0212001', 'Pioneer', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 3, 1500, 4500, '2020-12-18 13:00:22', 1),
(164, 'PH.2020.12.0000.5', 'piloa@gmail.com', '0606001', 'Toyota Hilux', '0', '-', '2', 1800, 3, 9000, 30600, '2020-12-18 13:01:05', 1),
(165, 'PH.2020.12.0000.6', 'chale@gmail.com', '0606001', 'Toyota Hilux', '0', '-', '3', 1800, 2, 9000, 23400, '2020-12-18 14:34:06', 1),
(166, 'PH.2020.12.0000.7', 'chale@gmail.com', '0321001', 'Floress', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 1, 700, 700, '2020-12-18 14:50:13', 0),
(167, 'PH.2020.12.0000.7', 'chale@gmail.com', '0606003', 'Toyota Hilux', '0', '-', '1', 1800, 1, 4300, 4300, '2020-12-18 15:20:02', 0),
(169, 'PH.2020.12.0000.8', 'echidjoto@gmail.com', '0321001', 'Floress', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 4, 700, 2800, '2020-12-26 09:32:47', 0),
(170, 'PH.2020.08.0000.4', 'miluna@outlook.com', '0212002', 'Fonestar', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 1, 2000, 2000, '2020-12-26 09:46:51', 0),
(172, 'PH.2020.08.0000.3', 'Martin@hotmail.com', '0212001', 'Pioneer', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 1, 1500, 1500, '2020-12-26 14:47:25', 0),
(173, 'PH.2020.08.0000.3', 'Martin@hotmail.com', '0606003', 'Toyota Hilux', '0', '-', '2', 1800, 2, 4300, 12200, '2020-12-26 14:48:28', 0),
(174, 'PH.2020.08.0000.3', 'Martin@hotmail.com', '0409001', 'Linda', '0', '-', '-', 0, 2, 1500, 3000, '2020-12-26 15:04:14', 0),
(175, 'PH.2020.08.0000.3', 'Martin@hotmail.com', '0301001', 'Maria flo', '0', 'Rosa com aromante', '-', 0, 1, 900, 900, '2020-12-26 15:05:15', 0),
(177, 'PH.2021.01.0001.1', 'piloa@gmail.com', '0212002', 'Fonestar', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 1, 2000, 2000, '2021-01-15 20:54:04', 0),
(178, 'PH.2021.01.0001.1', 'piloa@gmail.com', '0212003', 'Pioneer', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 2, 50000, 100000, '2021-01-15 20:54:08', 0),
(179, 'PH.2020.12.0000.8', 'echidjoto@gmail.com', '0212001', 'Pioneer', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 1, 1500, 1500, '2021-01-15 21:09:02', 0),
(180, 'PH.2020.12.0000.8', 'echidjoto@gmail.com', '0212002', 'Fonestar', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 1, 2000, 2000, '2021-01-15 21:09:03', 0),
(181, 'PH.2020.12.0000.8', 'echidjoto@gmail.com', '0212003', 'Pioneer', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 1, 50000, 50000, '2021-01-15 21:09:04', 0),
(184, 'PH.2020.12.0000.9', 'chuva@gmail.com', '0321001', 'Floress', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 3, 700, 2100, '2021-02-09 14:53:15', 0),
(189, 'PH.2020.12.0000.9', 'chuva@gmail.com', '0212003', 'Pioneer', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 2, 50000, 100000, '2021-02-10 08:42:11', 0),
(190, 'PH.2020.12.0000.9', 'chuva@gmail.com', '0301001', 'Maria flo', '0', 'Rosa com aromante', '-', 0, 2, 900, 1800, '2021-02-10 08:43:22', 0),
(191, 'PH.2020.12.0000.9', 'chuva@gmail.com', '0606003', 'Toyota Hilux', '0', '-', '3', 1800, 2, 4300, 14000, '2021-02-20 15:53:35', 0),
(193, 'PH.2021.12.0001.2', 'chidjoto@gmail.com', '0301001', 'Maria flo', '2', 'Rosa com aromante', '-', 0, 4, 900, 3600, '2021-12-02 20:05:09', 1),
(194, 'PH.2021.12.0001.2', 'chidjoto@gmail.com', '0611001', 'Toyota TT', '0', '-', '1', 1800, 2, 3500, 8800, '2021-12-02 20:11:27', 1),
(195, 'PH.2021.12.0001.3', 'chidjoto@gmail.com', '0409001', 'Linda', '0', '-', '-', 0, 1, 1500, 1500, '2021-12-02 22:50:03', 1),
(196, 'PH.2021.12.0001.3', 'chidjoto@gmail.com', '0301001', 'Maria flo', '4', 'Rosa com aromante', '-', 0, 3, 900, 2700, '2021-12-02 22:50:44', 1),
(197, 'PH.2021.12.0001.3', 'chidjoto@gmail.com', '0110001', 'Cadelac', '0', 'The Vans All-Weather MTE Collection designed.', '-', 0, 1, 200000, 200000, '2021-12-02 22:51:01', 1),
(198, 'PH.2021.12.0001.3', 'chidjoto@gmail.com', '0606001', 'Toyota Hilux', '0', '-', '1', 1800, 1, 9000, 9000, '2021-12-02 22:51:06', 1),
(199, 'PH.2021.12.0001.3', 'chidjoto@gmail.com', '0606003', 'Toyota Hilux', '0', '-', '2', 1800, 2, 4300, 12200, '2021-12-02 22:51:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `servico`
--

CREATE TABLE `servico` (
  `id` int(11) NOT NULL,
  `img` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `categoriaid` int(11) NOT NULL,
  `subcategoriaid` int(11) NOT NULL,
  `nome` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `preco` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `servico`
--

INSERT INTO `servico` (`id`, `img`, `codigo`, `categoriaid`, `subcategoriaid`, `nome`, `descricao`, `preco`, `estado`) VALUES
(1, 'IMG0409001', '0409001', 4, 9, 'Linda', '', 1500, 1),
(2, 'IMG0409002', '0409002', 4, 9, 'JSKDSJKDS', '', 20001, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subcategoria`
--

CREATE TABLE `subcategoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `categoriaid` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `subcategoria`
--

INSERT INTO `subcategoria` (`id`, `nome`, `categoriaid`, `estado`) VALUES
(1, 'Artificiais', 3, 1),
(2, 'Cadeiras', 1, 1),
(3, 'Caixão', 1, 1),
(4, 'Camas moveis', 2, 1),
(5, 'Cameras', 2, 1),
(6, 'Camioneta aberta', 6, 1),
(7, 'Camioneta fechada', 6, 1),
(8, 'Casa de banho moveis', 2, 1),
(9, 'Chapel e Pastor', 4, 1),
(10, 'Carro funerário', 1, 1),
(11, 'Coaster', 6, 1),
(12, 'Colunas', 2, 1),
(13, 'Conselheiro de luto', 4, 1),
(14, 'Dispositivo de redução de caixão', 1, 1),
(15, 'Funeral digital via meios digitais', 4, 1),
(16, 'Gerrador', 2, 1),
(17, 'Jornal obituário', 4, 1),
(18, 'Luzes Solar', 2, 1),
(19, 'Machibombo', 6, 1),
(20, 'Microphone', 2, 1),
(21, 'Naturais – Boquets', 3, 1),
(22, 'Obituário on-line', 4, 1),
(23, 'Orbituary', 4, 1),
(24, 'Pagamentos de taxas de coveiro', 4, 1),
(25, 'Photografo', 4, 1),
(26, 'Showroom da Agência Funeral', 4, 1),
(27, 'Tenda', 1, 1),
(28, 'Tapete', 1, 1),
(29, 'Testamentos/Will', 4, 1),
(30, 'Videografo', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tamanho`
--

CREATE TABLE `tamanho` (
  `id` int(11) NOT NULL,
  `nome` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transporte`
--

CREATE TABLE `transporte` (
  `id` int(11) NOT NULL,
  `img` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `categoriaid` int(11) NOT NULL,
  `subcategoriaid` int(11) NOT NULL,
  `preco` int(11) NOT NULL,
  `marcaid` int(11) NOT NULL,
  `modelo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `matricula` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `corid` int(20) NOT NULL,
  `lugar` int(11) NOT NULL,
  `tara` int(11) NOT NULL,
  `peso_bruto` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transporte`
--

INSERT INTO `transporte` (`id`, `img`, `codigo`, `categoriaid`, `subcategoriaid`, `preco`, `marcaid`, `modelo`, `matricula`, `corid`, `lugar`, `tara`, `peso_bruto`, `estado`) VALUES
(1, 'IMG0606001', '0606001', 6, 6, 9000, 6, 'Hilux', 'AFC-124-MC', 5, 5, 1500, 3000, 1),
(2, 'IMG0606003', '0606003', 6, 6, 4300, 6, 'Hilux', 'AFC-125-MC', 5, 3, 1500, 4500, 1),
(3, 'IMG0611001', '0611001', 6, 11, 3500, 6, 'TT', 'AFC-098-MP', 5, 24, 1200, 3000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuarioid` int(11) NOT NULL,
  `senha` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `usuarioid`, `senha`, `estado`) VALUES
(1, 1, '12345', 1),
(2, 2, '123456', 1),
(20, 20, '12345a', 1),
(21, 21, '12345a', 1),
(23, 23, '12345l', 1),
(28, 28, '123458', 1),
(32, 32, '12345a', 1),
(34, 34, 'Bilene75', 1),
(35, 35, 'Filuana02', 1),
(36, 36, 'chidjoto97', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cor`
--
ALTER TABLE `cor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cotacao`
--
ALTER TABLE `cotacao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nacionalidade`
--
ALTER TABLE `nacionalidade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recuperar`
--
ALTER TABLE `recuperar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rec_cotacao`
--
ALTER TABLE `rec_cotacao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tamanho`
--
ALTER TABLE `tamanho`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transporte`
--
ALTER TABLE `transporte`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `cor`
--
ALTER TABLE `cor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cotacao`
--
ALTER TABLE `cotacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `marca`
--
ALTER TABLE `marca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `nacionalidade`
--
ALTER TABLE `nacionalidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `recuperar`
--
ALTER TABLE `recuperar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rec_cotacao`
--
ALTER TABLE `rec_cotacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `servico`
--
ALTER TABLE `servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subcategoria`
--
ALTER TABLE `subcategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tamanho`
--
ALTER TABLE `tamanho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transporte`
--
ALTER TABLE `transporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
