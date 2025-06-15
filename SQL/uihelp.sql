-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15-Jun-2025 às 08:34
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `uihelp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `horarios_funcionamento`
--

CREATE TABLE `horarios_funcionamento` (
  `id` int(11) NOT NULL,
  `id_instituicao` int(11) NOT NULL,
  `dia_inicio` varchar(20) DEFAULT NULL,
  `dia_fim` varchar(20) DEFAULT NULL,
  `abertura` time DEFAULT NULL,
  `fechamento` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `instituicao_tipos_coleta`
--

CREATE TABLE `instituicao_tipos_coleta` (
  `id_instituicao` int(11) NOT NULL,
  `id_tipo_coleta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `instituicoes`
--

CREATE TABLE `instituicoes` (
  `id_instituicao` int(11) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `logradouro` varchar(255) NOT NULL,
  `numero` int(20) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT 'Nenhuma descrição',
  `tipo_servico` enum('coleta','distribuicao','distribuicao_e_coleta') NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `status` enum('pendente','aprovado') DEFAULT 'pendente',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_usuario` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_coleta`
--

CREATE TABLE `tipos_coleta` (
  `id_tipo_coleta` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `horarios_funcionamento`
--
ALTER TABLE `horarios_funcionamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `horarios_funcionamento_ibfk_1` (`id_instituicao`);

--
-- Índices para tabela `instituicao_tipos_coleta`
--
ALTER TABLE `instituicao_tipos_coleta`
  ADD PRIMARY KEY (`id_instituicao`,`id_tipo_coleta`),
  ADD KEY `id_tipo_coleta` (`id_tipo_coleta`);

--
-- Índices para tabela `instituicoes`
--
ALTER TABLE `instituicoes`
  ADD PRIMARY KEY (`id_instituicao`),
  ADD UNIQUE KEY `cnpj` (`cnpj`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Índices para tabela `tipos_coleta`
--
ALTER TABLE `tipos_coleta`
  ADD PRIMARY KEY (`id_tipo_coleta`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `horarios_funcionamento`
--
ALTER TABLE `horarios_funcionamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `instituicoes`
--
ALTER TABLE `instituicoes`
  MODIFY `id_instituicao` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `horarios_funcionamento`
--
ALTER TABLE `horarios_funcionamento`
  ADD CONSTRAINT `horarios_funcionamento_ibfk_1` FOREIGN KEY (`id_instituicao`) REFERENCES `instituicoes` (`id_instituicao`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `instituicao_tipos_coleta`
--
ALTER TABLE `instituicao_tipos_coleta`
  ADD CONSTRAINT `instituicao_tipos_coleta_ibfk_2` FOREIGN KEY (`id_instituicao`) REFERENCES `instituicoes` (`id_instituicao`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `instituicoes`
--
ALTER TABLE `instituicoes`
  ADD CONSTRAINT `instituicoes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `instituicoes_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
