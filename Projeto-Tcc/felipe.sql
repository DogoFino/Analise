-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 25-Jul-2024 às 13:49
-- Versão do servidor: 10.1.38-MariaDB
-- versão do PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `felipe`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `ID_CARRINHO` int(11) NOT NULL,
  `ID_COMPRA` int(11) DEFAULT NULL,
  `FORMA_PAGAMENTO` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `classificacao`
--

CREATE TABLE `classificacao` (
  `ID_CLASSIFICACAO` int(11) NOT NULL,
  `NOME_CLASSIFICACAO` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `compra`
--

CREATE TABLE `compra` (
  `ID_COMPRA` int(11) NOT NULL,
  `DATA_COMPRA` date DEFAULT NULL,
  `ID_PRODUTO` int(11) DEFAULT NULL,
  `CPF` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

CREATE TABLE `estoque` (
  `ID_ESTOQUE` int(11) NOT NULL,
  `QUANTIDADE` int(11) DEFAULT NULL,
  `ID_PRODUTO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `ID_PRODUTO` int(11) NOT NULL,
  `ID_ESTOQUE` int(11) DEFAULT NULL,
  `PRECO_P` decimal(10,2) NOT NULL,
  `NOME_P` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `CLASSIFICACAO_P` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `DESCRICAO` text COLLATE utf8mb4_bin NOT NULL,
  `IMAGE` varchar(255) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `CPF` int(11) NOT NULL,
  `NOME` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `TELEFONE` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `SENHA` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `EMAIL` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`ID_CARRINHO`),
  ADD KEY `ID_COMPRA` (`ID_COMPRA`);

--
-- Indexes for table `classificacao`
--
ALTER TABLE `classificacao`
  ADD PRIMARY KEY (`ID_CLASSIFICACAO`);

--
-- Indexes for table `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`ID_COMPRA`),
  ADD KEY `pk_id_produto` (`ID_PRODUTO`),
  ADD KEY `pk_CPF` (`CPF`);

--
-- Indexes for table `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`ID_ESTOQUE`),
  ADD KEY `ID_PRODUTO` (`ID_PRODUTO`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`ID_PRODUTO`),
  ADD KEY `ID_ESTOQUE` (`ID_ESTOQUE`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`CPF`);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinho_ibfk_1` FOREIGN KEY (`ID_COMPRA`) REFERENCES `compra` (`ID_COMPRA`);

--
-- Limitadores para a tabela `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `pk_CPF` FOREIGN KEY (`CPF`) REFERENCES `usuario` (`CPF`),
  ADD CONSTRAINT `pk_id_produto` FOREIGN KEY (`ID_PRODUTO`) REFERENCES `produto` (`ID_PRODUTO`);

--
-- Limitadores para a tabela `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`ID_PRODUTO`) REFERENCES `produto` (`ID_PRODUTO`);

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `ID_ESTOQUE` FOREIGN KEY (`ID_ESTOQUE`) REFERENCES `estoque` (`ID_ESTOQUE`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
