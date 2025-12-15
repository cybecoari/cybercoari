-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geraÃ§Ã£o: 29/10/2025 Ã s 18:52
-- VersÃ£o do servidor: 10.6.21-MariaDB-cll-lve
-- VersÃ£o do PHP: 8.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cyber_cyber`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `api_tokens`
--

CREATE TABLE `api_tokens` (
  `id` int(11) NOT NULL,
  `token_hash` varchar(64) NOT NULL,
  `owner_user_id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('pending_payment','active','revoked') DEFAULT 'pending_payment',
  `paid` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `api_tokens`
--

INSERT INTO `api_tokens` (`id`, `token_hash`, `owner_user_id`, `label`, `price`, `status`, `paid`, `created_at`, `expires_at`) VALUES
(15, '774916f6852abdb69ab79bdc67488215', 1, 'Futebol', 0.00, 'active', 1, '2025-10-14 01:09:54', '2026-10-13 22:09:54'),
(16, '1f532e3336f0c6ee658b577c0ace53f3', 7, 'Teste', 0.00, 'pending_payment', 0, '2025-10-23 18:06:07', '2025-11-22 15:06:07'),
(17, '2748eb3eb8a734f954a23d183c31b72c', 7, 'Teste 2', 0.01, 'pending_payment', 0, '2025-10-23 23:52:22', '2025-11-22 20:52:22'),
(18, 'f44c1e11d4bb89cb2d79abe264265651', 7, 'Teste 2', 0.01, 'pending_payment', 0, '2025-10-23 23:54:14', '2025-11-22 20:54:14'),
(19, 'e4e88305e20f8049fe64603e914d0fd0', 7, 'Teste 3', 0.00, 'pending_payment', 0, '2025-10-24 00:04:45', '2025-11-22 21:04:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estatisticas_site`
--

CREATE TABLE `estatisticas_site` (
  `id` int(11) NOT NULL,
  `total_usuarios` int(11) DEFAULT 0,
  `usuarios_online` int(11) DEFAULT 0,
  `data_criacao` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `estatisticas_site`
--

INSERT INTO `estatisticas_site` (`id`, `total_usuarios`, `usuarios_online`, `data_criacao`) VALUES
(1, 0, 0, '2025-10-20');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamentos_pix`
--

CREATE TABLE `pagamentos_pix` (
  `id` int(11) NOT NULL,
  `produto` varchar(100) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'pendente',
  `external_reference` varchar(50) NOT NULL,
  `payment_id` varchar(50) DEFAULT NULL,
  `qr_code` text DEFAULT NULL,
  `qr_code_base64` text DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `reset_senha`
--

CREATE TABLE `reset_senha` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `token` varchar(128) NOT NULL,
  `expira_em` datetime NOT NULL,
  `usado` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `times`
--

CREATE TABLE `times` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `times`
--

INSERT INTO `times` (`id`, `nome`) VALUES
(1, 'Agua Santa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ativo` tinyint(1) DEFAULT 1,
  `modo_escuro` tinyint(1) DEFAULT 0,
  `tipo_usuario` enum('usuario','admin') DEFAULT 'usuario',
  `status_online` tinyint(1) DEFAULT 0,
  `ultimo_acesso` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha_hash`, `data_criacao`, `data_atualizacao`, `ativo`, `modo_escuro`, `tipo_usuario`, `status_online`, `ultimo_acesso`) VALUES
(7, 'admin', 'admin@site.com', '$2y$10$rKqHplG/RgZ9YVDxW8ZKX.CbPpToYg9zRxYZ/Wv.NYwHo.LwGw79C', '2025-10-22 00:22:50', '2025-10-29 17:23:56', 1, 1, 'admin', 1, '2025-10-29 14:23:56'),
(8, 'cyber', 'cybercoari@gmail.com', '$2y$10$JIgAunOcsej3CHBpwB6ku.AsaQTPBcGrjfnr9s0b.J8QTz78o6uBO', '2025-10-23 23:42:09', '2025-10-24 01:21:02', 1, 0, 'admin', 0, '2025-10-23 22:21:02');

--
-- Ãndices para tabelas despejadas
--

--
-- Ãndices de tabela `api_tokens`
--
ALTER TABLE `api_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Ãndices de tabela `estatisticas_site`
--
ALTER TABLE `estatisticas_site`
  ADD PRIMARY KEY (`id`);

--
-- Ãndices de tabela `reset_senha`
--
ALTER TABLE `reset_senha`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Ãndices de tabela `times`
--
ALTER TABLE `times`
  ADD PRIMARY KEY (`id`);

--
-- Ãndices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `api_tokens`
--
ALTER TABLE `api_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `estatisticas_site`
--
ALTER TABLE `estatisticas_site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `reset_senha`
--
ALTER TABLE `reset_senha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `times`
--
ALTER TABLE `times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;