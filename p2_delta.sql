-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 18-Dez-2021 às 18:51
-- Versão do servidor: 5.7.33-0ubuntu0.18.04.1
-- PHP Version: 7.1.33-34+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `p2_delta`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `requisicao`
--

CREATE TABLE `requisicao` (
  `cd_requisicao` int(11) NOT NULL,
  `cd_requisitante` int(11) DEFAULT NULL,
  `cd_sistema` int(11) DEFAULT NULL,
  `dt_requisicao` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL COMMENT 'EA em andamento/ AP autorização pendente/ COM completa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `requisicao`
--

INSERT INTO `requisicao` (`cd_requisicao`, `cd_requisitante`, `cd_sistema`, `dt_requisicao`, `status`) VALUES
(101, 1, 1, '2020-06-25', 'COM'),
(102, 2, 2, '2020-04-15', 'EA'),
(103, 3, 3, '2020-03-12', 'AP'),
(104, 4, 2, '2020-03-03', 'AP'),
(105, 5, 3, '2020-06-21', 'EA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `requisitante`
--

CREATE TABLE `requisitante` (
  `cd_requisitante` int(11) NOT NULL,
  `nm_requisitante` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `requisitante`
--

INSERT INTO `requisitante` (`cd_requisitante`, `nm_requisitante`) VALUES
(1, 'Jose Salgado'),
(2, 'Sergio Amareal'),
(3, 'Fernando Nobrega'),
(4, 'Cristovao Silva'),
(5, 'Julia Albertch');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sistema`
--

CREATE TABLE `sistema` (
  `cd_sistema` int(11) NOT NULL,
  `nm_sistema` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sistema`
--

INSERT INTO `sistema` (`cd_sistema`, `nm_sistema`) VALUES
(1, 'Estoque'),
(2, 'Compras'),
(3, 'Vendas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `requisicao`
--
ALTER TABLE `requisicao`
  ADD PRIMARY KEY (`cd_requisicao`),
  ADD KEY `idx_cd_requisitante` (`cd_requisitante`) USING BTREE,
  ADD KEY `idx_cd_sistema` (`cd_sistema`) USING BTREE;

--
-- Indexes for table `requisitante`
--
ALTER TABLE `requisitante`
  ADD PRIMARY KEY (`cd_requisitante`);

--
-- Indexes for table `sistema`
--
ALTER TABLE `sistema`
  ADD PRIMARY KEY (`cd_sistema`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `requisicao`
--
ALTER TABLE `requisicao`
  MODIFY `cd_requisicao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT for table `requisitante`
--
ALTER TABLE `requisitante`
  MODIFY `cd_requisitante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `sistema`
--
ALTER TABLE `sistema`
  MODIFY `cd_sistema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `requisicao`
--
ALTER TABLE `requisicao`
  ADD CONSTRAINT `fk_requisicao_cd_requisitante` FOREIGN KEY (`cd_requisitante`) REFERENCES `requisitante` (`cd_requisitante`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_requisicao_cd_sistema` FOREIGN KEY (`cd_sistema`) REFERENCES `sistema` (`cd_sistema`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
