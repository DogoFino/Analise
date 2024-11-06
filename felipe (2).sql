-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/11/2024 às 02:00
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `felipe`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `ID_CARRINHO` int(11) NOT NULL,
  `ID_COMPRA` int(11) DEFAULT NULL,
  `FORMA_PAGAMENTO` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `classificacao`
--

CREATE TABLE `classificacao` (
  `ID_CLASSIFICACAO` int(11) NOT NULL,
  `NOME_CLASSIFICACAO` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `compra`
--

CREATE TABLE `compra` (
  `ID_COMPRA` int(11) NOT NULL,
  `DATA_COMPRA` date DEFAULT NULL,
  `ID_PRODUTO` int(11) DEFAULT NULL,
  `CPF` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `ID_ESTOQUE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `nomep` varchar(255) NOT NULL,
  `classificacao` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `preco`, `nomep`, `classificacao`, `descricao`, `imagem`, `quantidade`) VALUES
(27, 8.00, 'tal', 'Martelo', 'tal 2', 'images/Captura de Tela (1).png', 55),
(35, 1254.00, 'tal2', 'Chave de Boca', '124214', 'images/WhatsApp Image 2024-10-28 at 22.12.35.jpeg', 214),
(36, 124.00, 'teste', 'Chave de Boca', 'fwewegd', 'images/chad-stride-animation-dli0c654x0078as4.gif', 214),
(37, 1234.00, 'coca-cola', 'Chave de Boca', 'diego', 'images/8ed68cb0e0257aef072b8431648b4e81.gif', 23),
(38, 2.00, 'diego', 'Chave Inglesa', 'lekgsd', 'images/40a8649456d13a8ba708c0b7c324229308ee267f6d25251721129fd0d3b1c9c0_1.jpg', 43),
(39, 51.00, 'juca', 'Martelo', 'dgssdfsdfsdfgsdfffffsfsffdssgdgsgdsfsfa', 'images/i464123.jpeg', 52),
(40, 64.00, 'fsdasdf', 'Chave de Boca', 'fgdsgfs', 'images/Descubra o Mundo como Programador Full Stack!.png', 234),
(41, 64.00, 'fsdasdf', 'Chave de Boca', 'fgdsgfs', 'images/Descubra o Mundo como Programador Full Stack!.png', 234);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `tipo` varchar(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`nome`, `email`, `senha`, `cpf`, `telefone`, `tipo`) VALUES
('Felipe', 'felipee@gmail.com', 'felipe', '000.000.000', '(45) 98800-0000', '0'),
('fe', 'fe@gmail.com', '123', '111.111.111', '(11) 11111-1112', '1');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`ID_CARRINHO`),
  ADD KEY `ID_COMPRA` (`ID_COMPRA`);

--
-- Índices de tabela `classificacao`
--
ALTER TABLE `classificacao`
  ADD PRIMARY KEY (`ID_CLASSIFICACAO`);

--
-- Índices de tabela `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`ID_COMPRA`),
  ADD KEY `pk_id_produto` (`ID_PRODUTO`),
  ADD KEY `pk_CPF` (`CPF`),
  ADD KEY `CPF` (`CPF`);

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`ID_ESTOQUE`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`cpf`),
  ADD UNIQUE KEY `EMAIL` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `ID_ESTOQUE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinho_ibfk_1` FOREIGN KEY (`ID_COMPRA`) REFERENCES `compra` (`ID_COMPRA`);

--
-- Restrições para tabelas `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `pk_id_produto` FOREIGN KEY (`ID_PRODUTO`) REFERENCES `produto` (`id_produto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
