-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 04-Maio-2017 às 14:32
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
(2, 'Infraestutura', 'Realizações de trabalhos juntamente com os meninos da oficina.', 1),
(3, 'Saídas externas', 'Saídas para realizações de atividades externas, o funcionário tem que ausentar-se de sua área.', NULL),
(4, 'Extra-Desenvolvimento', 'Atividades relacionadas a demandas aleatórias que não são relacionadas a desenvolvimento em si.', NULL),
(5, 'Telemática', 'Atividades relacionadas ao funcionamento interno da rede telefônica.', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `chamadas`
--

CREATE TABLE `chamadas` (
  `id` int(11) NOT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `agendar` tinyint(2) DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fim` time DEFAULT NULL,
  `nome_requeridor` varchar(45) DEFAULT NULL,
  `descricao` longtext,
  `id_categoria` int(11) DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `chamadas`
--

INSERT INTO `chamadas` (`id`, `status`, `agendar`, `data_inicio`, `data_fim`, `hora_inicio`, `hora_fim`, `nome_requeridor`, `descricao`, `id_categoria`, `id_empregador`) VALUES
(1, 1, 0, '2017-04-03', NULL, '08:10:40', '11:20:28', 'Sara', 'Saída para o CEDCA, e compra de materiais para impressora.', 3, 1),
(2, 1, 0, '2017-04-03', NULL, '07:30:21', '11:55:17', 'Sara', 'Envio e organização de e-mails relacionados ao CDECA', 4, 1),
(3, 1, 0, '2017-04-03', NULL, '09:43:13', '10:15:39', 'Fábio', 'Puxando um ramal para Beth.', 5, 1),
(4, 1, 0, '2017-04-03', NULL, '13:00:56', '15:00:50', 'Sara', 'Colocar a TV e o quadro branco na Geodésica para a reunião do CEDCA.', 2, 1),
(5, 1, 0, '2017-04-03', NULL, '07:30:03', '14:00:17', 'Fábio', 'Realização da lista de atividades relacionadas a organização da reunião do CEDCA, para o dia 03/04/2017.', 2, 1),
(6, 1, 0, '2017-04-03', NULL, '15:00:00', '16:12:54', 'Kananda', 'Saída para Aquiraz para comprar materiais de higiene.', 3, 1),
(7, 1, 0, '2017-04-04', NULL, '07:30:14', '10:26:49', 'Sara', 'Organização de cadeiras e teste de ar-condicionado.', 2, 1),
(8, 1, 0, '2017-04-04', NULL, '10:40:14', '11:32:19', 'Kananda', 'Saída para compra de materiais.', 3, 1),
(9, 1, 0, '2017-04-04', NULL, '12:25:56', '13:04:13', 'Josinaldo', 'Montar computadores para o cadastramento do evento(CEDCA).', 1, 1),
(10, 1, 0, '2017-04-04', NULL, '14:00:58', '17:00:45', 'Fábio', 'Participação da reunião do CEDCA', 5, 1),
(13, 1, 0, '2017-04-05', NULL, '07:52:54', '07:56:33', 'Jaqueline', 'Montar a impressora', 1, 1),
(14, 1, 0, '2017-04-05', NULL, '08:06:34', '08:25:45', 'Josinaldo', 'Repôr quadro na sala de reunião.', 2, 1),
(15, 1, 0, '2017-04-06', NULL, '10:17:14', '10:33:14', 'Sara', 'Retirar as cadeiras da geodésica.', 2, 1),
(16, 1, 0, '2017-04-06', NULL, '14:41:18', '15:02:53', 'Thayná', 'Colocando HD em máquina, para maior espaço em disco.', 1, 1),
(22, 1, 0, '2017-04-12', NULL, '07:40:16', '09:40:00', 'Josinaldo', 'Formatando máquina da Beth.', 1, 1),
(32, 1, 0, '2017-04-12', NULL, '09:43:56', '10:17:04', 'Josinaldo', 'Formatando máquina da Beth.(Continuando)', 1, 1),
(42, 1, 0, '2017-04-12', NULL, '14:30:13', '15:18:55', 'Fábio', 'Verificação de material para a escada da caixa dágua.', 2, 1),
(48, 1, 0, '2017-04-12', '0000-00-00', '15:48:47', '16:23:38', 'Gabriel', 'Ativação de produtos da Adobe.', 1, 1),
(62, 1, 0, '2017-04-13', '0000-00-00', '09:13:51', '09:46:11', 'Camila', 'instalar Adobe CC pra Camila', 1, 1),
(70, 1, 0, '2017-04-13', NULL, '10:26:52', '10:38:48', 'Thayná', 'Compartilhar máquina.', 1, 1),
(72, 1, 0, '2017-04-13', '0000-00-00', '10:39:16', '11:15:29', 'Josinaldo', 'Procurar memórias para as máquinas dos garotos do design.', 1, 1),
(73, 1, 0, '2017-04-13', '0000-00-00', '10:40:31', '10:54:00', 'Thayná', 'Computador não passa vídeo.', 1, 1),
(79, 1, 0, '2017-04-13', '0000-00-00', '11:53:13', '12:10:00', 'Gabriel', 'Colocando memórias nas máquinas.', 1, 1),
(80, 1, 0, '2017-04-20', '0000-00-00', '07:40:33', '08:25:00', 'Josinaldo', 'Materiais gerais da geodésica, preço e mais.', 2, 1),
(82, 1, 0, '2017-04-24', '0000-00-00', '07:59:24', '08:19:45', 'Fábio', 'Verificação de teste de montagem de peças.', 2, 1),
(83, 1, 0, '2017-04-24', '0000-00-00', '07:59:59', '08:20:00', 'Jaqueline', 'Remover vírus do computador.', 1, 1),
(84, 1, 0, '2017-04-24', '0000-00-00', '09:30:19', '09:48:18', 'Josinaldo', 'Colocar HD na máquina da Camila.', 1, 1),
(85, 1, 0, '2017-04-24', '0000-00-00', '09:19:24', '09:30:32', 'Josinaldo', 'Verificar quantidades e preços dos produtos da geodésica.', 2, 1),
(86, 1, 0, '2017-04-24', '0000-00-00', '10:24:12', '11:19:46', 'Fábio', 'Verificar projetos da Geodésica.', 2, 1),
(87, 1, 0, '2017-04-24', '0000-00-00', '11:11:25', '11:20:56', 'Josinaldo', 'Verificar quantidades e preços dos produtos da geodésica.(Continuando)', 2, 1),
(88, 1, 0, '2017-04-24', '0000-00-00', '12:50:54', '14:38:41', 'Fábio', 'Verificar quantidades e preços dos produtos da geodésica.(Continuando)', 2, 1),
(89, 1, 0, '2017-04-26', '0000-00-00', '08:17:49', '08:44:51', 'Jaque', 'Hd não reconhece.', 1, 1),
(130, 1, 0, '2017-05-03', '0000-00-00', '13:10:41', '15:32:31', 'Miguel', 'Limpar espaço.(Vassoura, pá, poeira e muito mais).', 4, 1),
(131, 0, 0, '2017-05-04', '0000-00-00', '07:40:56', '08:32:00', 'Kananda', 'Fazer compras.', 3, 1),
(133, 0, 1, '2017-05-18', '0000-00-00', '12:00:14', NULL, 'Josinaldo', 'dsds', 4, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `chamadas_agendadas`
--

CREATE TABLE `chamadas_agendadas` (
  `id` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_chamada` int(11) DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `chamadas_agendadas`
--

INSERT INTO `chamadas_agendadas` (`id`, `data`, `id_usuario`, `id_chamada`, `id_empregador`) VALUES
(1, '2017-04-20', 3, 80, 1),
(2, '2017-04-20', 4, 80, 1),
(3, '2017-04-24', 3, 82, 1),
(4, '2017-04-24', 4, 83, 1),
(5, '2017-04-24', 2, 84, 1),
(6, '2017-04-24', 4, 85, 1),
(7, '2017-04-24', 3, 86, 1),
(8, '2017-04-24', 4, 87, 1),
(9, '2017-04-24', 3, 88, 1),
(10, '2017-04-24', 4, 88, 1),
(11, '2017-04-26', 4, 89, 1),
(20, '2017-05-03', 4, 130, 1),
(21, '2017-05-04', 4, 131, 1),
(23, '2017-05-18', NULL, 133, 1);

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
(53, 2, 2, 1),
(59, 4, 3, 1),
(60, 4, 4, 1),
(61, 3, 5, 1),
(62, 1, 6, 1),
(65, 4, 7, 1),
(66, 1, 8, 1),
(67, 4, 9, 1),
(69, 3, 10, 1),
(72, 4, 13, 1),
(73, 4, 14, 1),
(74, 4, 15, 1),
(75, 2, 16, 1),
(87, 1, 1, 1),
(100, 4, 29, 1),
(104, 3, 30, 1),
(105, 4, 30, 1),
(106, 4, 31, 1),
(108, 2, 22, 1),
(109, 2, 32, 1),
(110, 4, 33, 1),
(111, 4, 34, 1),
(112, 4, 35, 1),
(113, 4, 36, 1),
(114, 4, 37, 1),
(116, 4, 38, 1),
(117, 4, 39, 1),
(119, 4, 40, 1),
(120, 3, 41, 1),
(121, 4, 41, 1),
(122, 3, 42, 1),
(123, 4, 42, 1),
(124, 4, 43, 1),
(125, 4, 44, 1),
(126, 4, 45, 1),
(127, 3, 46, 1),
(128, 4, 46, 1),
(129, 3, 47, 1),
(130, 4, 47, 1),
(131, 2, 48, 1),
(132, 2, 49, 1),
(133, 4, 49, 1),
(135, 4, 50, 1),
(136, 4, 51, 1),
(137, 4, 52, 1),
(138, 4, 49, 1),
(139, 4, 50, 1),
(140, 4, 51, 1),
(141, 4, 52, 1),
(142, 4, 53, 1),
(143, 2, 54, 1),
(144, 4, 54, 1),
(145, 4, 55, 1),
(146, 4, 56, 1),
(148, 4, 57, 1),
(149, 4, 58, 1),
(150, 4, 59, 1),
(152, 4, 60, 1),
(153, 4, 61, 1),
(155, 2, 62, 1),
(157, 4, 63, 1),
(158, 4, 64, 1),
(159, 4, 65, 1),
(162, 2, 66, 1),
(163, 4, 66, 1),
(164, 4, 67, 1),
(165, 4, 68, 1),
(166, 4, 69, 1),
(167, 2, 70, 1),
(169, 4, 71, 1),
(170, 2, 72, 1),
(171, 4, 73, 1),
(173, 4, 74, 1),
(174, 2, 75, 1),
(175, 4, 75, 1),
(176, 4, 76, 1),
(177, 3, 77, 1),
(178, 4, 77, 1),
(179, 1, 78, 1),
(180, 2, 79, 1),
(192, 4, 90, 1),
(193, 4, 91, 1),
(194, 1, 92, 1),
(195, 3, 92, 1),
(196, 4, 92, 1),
(197, 4, 93, 1),
(198, 4, 94, 1),
(199, 4, 95, 1),
(200, 1, 96, 1),
(201, 4, 96, 1),
(202, 4, 97, 1),
(203, 2, 99, 1),
(204, 4, 100, 1),
(205, 2, 101, 1),
(206, 4, 102, 1),
(207, 4, 103, 1),
(208, 1, 104, 1),
(209, 2, 104, 1),
(214, 4, 106, 1),
(215, 4, 105, 1),
(217, 4, 107, 1),
(218, 4, 108, 1),
(219, 4, 109, 1),
(220, 2, 110, 1),
(221, 4, 110, 1),
(222, 4, 111, 1),
(223, 4, 112, 1),
(224, 4, 113, 1),
(225, 4, 114, 1),
(226, 4, 115, 1),
(227, 3, 116, 1),
(228, 4, 117, 1),
(229, 4, 118, 1),
(241, 3, 80, 1),
(242, 4, 80, 1),
(243, 4, 81, 1),
(245, 3, 82, 1),
(247, 4, 83, 1),
(249, 2, 84, 1),
(251, 4, 85, 1),
(253, 3, 86, 1),
(255, 4, 87, 1),
(258, 3, 88, 1),
(259, 4, 88, 1),
(261, 4, 89, 1),
(262, 4, 90, 1),
(270, 4, 130, 1),
(272, 1, 131, 1),
(274, 3, 133, 1),
(275, 4, 133, 1);

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
(3, 'Josinaldo da Silva Batista', 'Josinaldo Batista', 'josinaldosb@gmail.com', '$2y$10$sF7BAyjU3YF0yN3HmhDisOm.SZfXKolwkBowFK2TozqypsZNpVxJ2', 'josinaldo.jpg', 1, 3, 1, 'oTV7zn9xRY87tX3pS933nt7MwC77ACJcjBDbLCUGx1454STioZhCmJ6YTmZy', '2016-12-21 22:52:57', '2017-03-29 21:47:15'),
(4, 'Reginaldo Maranhão Sousa', 'Reginaldo Maranhão', 'naldomaranhao0203@outlook.com', '$2y$10$eoS1vMeKQ/zLlFoYul6N.OCtfNA15JzknLuVWRAnJfZ.DwrWEcB7y', 'Reginaldo.jpg', 1, 3, 1, 'zV46bmuRC8uHWKZVcSBCeFSxe9rLjWHVBTfQJDkNH4L92Hckm86dvsSFn2VG', '2016-12-22 14:47:54', '2017-04-01 16:17:08');

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
-- Indexes for table `chamadas_agendadas`
--
ALTER TABLE `chamadas_agendadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pessoa_agendada_idx` (`id_usuario`),
  ADD KEY `fk_chamada_agendada_idx` (`id_chamada`),
  ADD KEY `fk_empregador_agendada_idx` (`id_empregador`);

--
-- Indexes for table `chamadas_users`
--
ALTER TABLE `chamadas_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_chamada_pessoa_idx` (`id_usuario`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;
--
-- AUTO_INCREMENT for table `chamadas_agendadas`
--
ALTER TABLE `chamadas_agendadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `chamadas_users`
--
ALTER TABLE `chamadas_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=276;
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
-- Limitadores para a tabela `chamadas_agendadas`
--
ALTER TABLE `chamadas_agendadas`
  ADD CONSTRAINT `fk_chamada_agendada` FOREIGN KEY (`id_chamada`) REFERENCES `chamadas` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_empregador_agendada` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pessoa_agendada` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `chamadas_users`
--
ALTER TABLE `chamadas_users`
  ADD CONSTRAINT `fk_chamada_empregador` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
