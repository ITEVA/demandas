-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 29-Mar-2017 às 13:20
-- Versão do servidor: 5.7.16
-- PHP Version: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demandas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `descricao` longtext,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `descricao`, `id_empregador`) VALUES
(1, 'Manuntenção', 'Consertos em geral na parte de hardware, instalações de programas .', 1),
(2, 'Infraestutura', 'Realizações de trabalhos juntamente com os meninos da oficina.', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `chamadas`
--

CREATE TABLE `chamadas` (
  `id` int(11) NOT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `nome_requeridor` varchar(45) DEFAULT NULL,
  `descricao` longtext,
  `id_categoria` int(11) DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `chamadas`
--

INSERT INTO `chamadas` (`id`, `data_inicio`, `data_fim`, `nome_requeridor`, `descricao`, `id_categoria`, `id_empregador`) VALUES
(1, '2017-03-28', '2017-03-29', 'Josinaldo', 'osoosoos', 1, 1),
(2, '2017-03-28', '2017-03-29', 'Josinaldo', 'Ativar o Windows\r\n', 1, 1),
(6, '2017-03-29', '2017-03-31', 'Josinaldo', 'uhul', 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `chamadas_users`
--

CREATE TABLE `chamadas_users` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_chamada` int(11) DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `chamadas_users`
--

INSERT INTO `chamadas_users` (`id`, `id_usuario`, `id_chamada`, `id_empregador`) VALUES
(13, 1, 6, 1),
(14, 4, 6, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `empregador`
--

CREATE TABLE `empregador` (
  `id` int(11) NOT NULL,
  `cnpj` varchar(45) DEFAULT NULL,
  `razaosocial` varchar(100) DEFAULT NULL,
  `nomefantasia` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `empregador`
--

INSERT INTO `empregador` (`id`, `cnpj`, `razaosocial`, `nomefantasia`) VALUES
(1, '03.502.169/0001-38', 'Iteva', 'Instituto Tecnológico e Vocacional Avançado'),
(2, '00.000.000/0000-00', 'Teste', 'Teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('nicolasmatos0905@gmail.com', '35ee6787683c6ecc19df073f6eb987b2e248eb99a58bac7cf367b50000716687', '2017-01-17 17:58:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissoes`
--

CREATE TABLE `permissoes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` longtext,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `permissoes`
--

INSERT INTO `permissoes` (`id`, `nome`, `descricao`, `id_empregador`) VALUES
(2, 'Usuário Comum', 'Acesso limitado ao sistema', 1),
(3, 'Administrador', 'Acesso total ao sistema', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissoes_classes`
--

CREATE TABLE `permissoes_classes` (
  `id` int(11) NOT NULL,
  `classe` varchar(100) DEFAULT NULL,
  `id_permissao` int(11) DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `permissoes_classes`
--

INSERT INTO `permissoes_classes` (`id`, `classe`, `id_permissao`, `id_empregador`) VALUES
(133, 'inicio', 2, 1),
(177, 'inicio', 3, 1),
(178, 'user', 3, 1),
(179, 'permissao', 3, 1),
(180, 'chamada', 3, 1),
(181, 'relatorio', 3, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `apelido` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `foto` varchar(100) DEFAULT 'default.jpg',
  `status` tinyint(1) DEFAULT '1',
  `id_permissao` int(11) DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `nome`, `apelido`, `email`, `password`, `foto`, `status`, `id_permissao`, `id_empregador`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ruan Nícolas da Silva Matos', 'Nicolas Matos', 'nicolasmatos0905@gmail.com', '$2y$10$T5dbD/f2xrrDRHKG/W/J5.65jfEVnsi5wv78yLYVePkyaqGuYd6qi', 'nicolas.jpg', 1, 3, 1, 'NKU2OPYQGc6211UCJq0UTob48JcAkf3TltohsWiIOpR5B7NyoPWbgGiPYPCH', NULL, '2017-03-13 16:55:13'),
(2, 'Maria Giselly Rebouças Azevedo', 'Giselly Rebouças', 'gisellyazevedo@hotmail.com', '$2y$10$dL/2WbHprTv2Xk43DqTpNOMv.nSiEj.0fFmj.X1i9nASQn9ESDYhO', 'giselly.jpg', 1, 3, 1, NULL, '2016-12-21 22:36:57', '2017-01-27 16:06:55'),
(3, 'Josinaldo da Silva Batista', 'Josinaldo Batista', 'josinaldosb@gmail.com', '$2y$10$sF7BAyjU3YF0yN3HmhDisOm.SZfXKolwkBowFK2TozqypsZNpVxJ2', 'josinaldo.jpg', 1, 2, 1, 'oTV7zn9xRY87tX3pS933nt7MwC77ACJcjBDbLCUGx1454STioZhCmJ6YTmZy', '2016-12-21 22:52:57', '2017-01-27 19:27:35'),
(4, 'Reginaldo Maranhão Sousa', 'Reginaldo Maranhão', 'naldomaranhao0203@outlook.com', '$2y$10$eoS1vMeKQ/zLlFoYul6N.OCtfNA15JzknLuVWRAnJfZ.DwrWEcB7y', 'Reginaldo.jpg', 1, 3, 1, '7DqgaYLD0fxq42GCJlHwwDPdmlSWiBCMOFBF4Zs0im9lfrgsQPo4XUJtkjaC', '2016-12-22 14:47:54', '2017-03-27 22:23:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria_empregador_idx` (`id_empregador`);

--
-- Indexes for table `chamadas`
--
ALTER TABLE `chamadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_chamadas_empregador_idx` (`id_empregador`),
  ADD KEY `fk_chamadas_categoria_idx` (`id_categoria`);

--
-- Indexes for table `chamadas_users`
--
ALTER TABLE `chamadas_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_chamada_pessoa_idx` (`id_usuario`),
  ADD KEY `fk_chamada_pessoa_chamada_idx` (`id_chamada`),
  ADD KEY `fk_chamada_empregador_idx` (`id_empregador`);

--
-- Indexes for table `empregador`
--
ALTER TABLE `empregador`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `permissoes`
--
ALTER TABLE `permissoes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome`),
  ADD KEY `fk_empregador_users_idx` (`id_empregador`);

--
-- Indexes for table `permissoes_classes`
--
ALTER TABLE `permissoes_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_permissao_idx` (`id_permissao`),
  ADD KEY `fk_empregador_permissoes_classe_idx` (`id_empregador`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `fk_empregador_users_idx` (`id_empregador`),
  ADD KEY `fk_permissao_usuario_idx` (`id_permissao`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chamadas`
--
ALTER TABLE `chamadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `chamadas_users`
--
ALTER TABLE `chamadas_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `empregador`
--
ALTER TABLE `empregador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `permissoes`
--
ALTER TABLE `permissoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `permissoes_classes`
--
ALTER TABLE `permissoes_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `fk_categoria_empregador` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `chamadas`
--
ALTER TABLE `chamadas`
  ADD CONSTRAINT `fk_chamadas_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_chamadas_empregador` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `chamadas_users`
--
ALTER TABLE `chamadas_users`
  ADD CONSTRAINT `fk_chamada_empregador` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_chamada_pessoa_chamada` FOREIGN KEY (`id_chamada`) REFERENCES `chamadas` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_chamada_pessoa_user` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `permissoes`
--
ALTER TABLE `permissoes`
  ADD CONSTRAINT `fk_empregador_permissoes` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `permissoes_classes`
--
ALTER TABLE `permissoes_classes`
  ADD CONSTRAINT `fk_empregador_permissoes_classe` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_permissao_classe` FOREIGN KEY (`id_permissao`) REFERENCES `permissoes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_empregador_users` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_permissao_usuario` FOREIGN KEY (`id_permissao`) REFERENCES `permissoes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
