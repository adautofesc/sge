-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           5.7.18 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela sge.bairros_sanca
CREATE TABLE IF NOT EXISTS `bairros_sanca` (
  `id` int(11) unsigned NOT NULL,
  `nome` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela sge.bairros_sanca: ~201 rows (aproximadamente)
/*!40000 ALTER TABLE `bairros_sanca` DISABLE KEYS */;
INSERT INTO `bairros_sanca` (`id`, `nome`) VALUES
	(0, 'Outra cidade/ não consta'),
	(1, ' Água Vermelha'),
	(2, ' Albertini'),
	(3, ' Américo Alves Margarido'),
	(4, ' Aracê de Santo Antonio I'),
	(5, ' Aracê de Santo Antonio II'),
	(6, ' Arace Santo Antonio'),
	(7, ' Arnold Schimidt'),
	(8, ' Astolpho Luiz do Prado'),
	(9, ' Azulville 2'),
	(10, ' Azulville I'),
	(11, ' Bela Vista São-Carlense'),
	(12, ' Belvedere'),
	(13, ' Bosque de São Carlos'),
	(14, ' Castelo Branco'),
	(15, ' CEAT'),
	(16, ' Centreville'),
	(17, ' Centro'),
	(18, ' Chacara Club'),
	(19, ' Chacara das Araras'),
	(20, ' Chacara Leila'),
	(21, ' Chacara Parollo'),
	(22, ' Chacara São Caetano'),
	(23, ' Chacara São João'),
	(24, ' Cidade Aracy'),
	(25, ' Cidade Jardim'),
	(26, ' Cooperativa Habitacional Azulville'),
	(27, ' Damha I São Carlos'),
	(28, ' Damha II São Carlos'),
	(29, ' Damha l'),
	(30, ' Damha ll'),
	(31, ' Damha lll'),
	(32, ' Delta'),
	(33, ' Deputado José Zavaglia'),
	(34, ' Dom Constantino Amstalden'),
	(35, ' Douradinho'),
	(36, ' Eldorado'),
	(37, ' Espraiado'),
	(38, ' Estância Maria Alice'),
	(39, ' Estância Maria Alice Prolongamento'),
	(40, ' Faber Castell I'),
	(41, ' Faber Castell II'),
	(42, ' Fazenda Babilonia'),
	(43, ' Fehr'),
	(44, ' Ise Koizume'),
	(45, ' Itaipu'),
	(46, ' Itamarati'),
	(47, ' Jardim Acapulco'),
	(48, ' Jardim Alvorada'),
	(49, ' Jardim Araucária'),
	(50, ' Jardim Bandeirantes'),
	(51, ' Jardim Beatriz'),
	(52, ' Jardim Bethânia'),
	(53, ' Jardim Bicão'),
	(54, ' Jardim Botafogo 1'),
	(55, ' Jardim Brasil'),
	(56, ' Jardim Cardinalli'),
	(57, ' Jardim Centen rio'),
	(58, ' Jardim Citelli'),
	(59, ' Jardim Cruzeiro do Sul'),
	(60, ' Jardim das Rosas'),
	(61, ' Jardim das Torres'),
	(62, ' Jardim das Torres Prolongamento'),
	(63, ' Jardim de Cresci'),
	(64, ' Jardim Dona Francisca'),
	(65, ' Jardim dos Coqueiros'),
	(66, ' Jardim Embaré'),
	(67, ' Jardim Gibertoni'),
	(68, ' Jardim Gonzaga'),
	(69, ' Jardim Guanabara'),
	(70, ' Jardim Hikare'),
	(71, ' Jardim Ipanema'),
	(72, ' Jardim Jacobucci'),
	(73, ' Jardim Jóckei Club A'),
	(74, ' Jardim Lutfalla'),
	(75, ' Jardim Macarengo'),
	(76, ' Jardim Maracanã'),
	(77, ' Jardim Maria Alice'),
	(78, ' Jardim Martinelli'),
	(79, ' Jardim Medeiros'),
	(80, ' Jardim Mercedes'),
	(81, ' Jardim Munique'),
	(82, ' Jardim Nossa Senhora Aparecida'),
	(83, ' Jardim Nova Santa Paula'),
	(84, ' Jardim Nova São Carlos'),
	(85, ' Jardim Novo Horizonte'),
	(86, ' Jardim Pacaembu'),
	(87, ' Jardim Paraíso'),
	(88, ' Jardim Paulista'),
	(89, ' Jardim Paulistano'),
	(90, ' Jardim Real'),
	(91, ' Jardim Ricetti'),
	(92, ' Jardim Santa Elisa'),
	(93, ' Jardim Santa Helena'),
	(94, ' Jardim Santa J£lia'),
	(95, ' Jardim Santa Maria'),
	(96, ' Jardim Santa Maria II'),
	(97, ' Jardim Santa Paula'),
	(98, ' Jardim Santa Tereza'),
	(99, ' Jardim São Carlos'),
	(100, ' Jardim São Carlos 5'),
	(101, ' Jardim São João Batista'),
	(102, ' Jardim São Paulo'),
	(103, ' Jardim São Rafael'),
	(104, ' Jardim Social Belvedere'),
	(105, ' Jardim Social Presidente Collor'),
	(106, ' Jardim Taiti'),
	(107, ' Jardim Tangar'),
	(108, ' Jardim Tijuca'),
	(109, ' Jardim Veneza'),
	(110, ' Jardim Vista Alegre'),
	(111, ' Maria Stella Faga'),
	(112, ' Miguel Abdelnur'),
	(113, ' Mirante da Bela Vista'),
	(114, ' Monsenhor Romeu Tortorelli'),
	(115, ' Montreal'),
	(116, ' Morada dos Deuses'),
	(117, ' Novo Mundo'),
	(118, ' Paraíso'),
	(119, ' Parati'),
	(120, ' Parque dos Flamboyant'),
	(121, ' Parque dos Timburis'),
	(122, ' Parque Tecnológico'),
	(123, ' Planalto Paraíso'),
	(124, ' Planalto Verde'),
	(125, ' Planalto Verde'),
	(126, ' Portal do Sol'),
	(127, ' Primavera'),
	(128, ' Quebec'),
	(129, ' Quinta dos Buritis'),
	(130, ' Recreio Campestre'),
	(131, ' Recreio dos Bandeirantes'),
	(132, ' Recreio São Judas Tadeu'),
	(133, ' Romeu Santini'),
	(134, ' Sabará'),
	(135, ' Samambaia'),
	(136, ' Santa Angelina'),
	(137, ' Santa Eudóxia'),
	(138, ' Santa Felícia Jardim'),
	(139, ' Santa Marta'),
	(140, ' Santa Mônica'),
	(141, ' São Carlos Club'),
	(142, ' São Carlos I'),
	(143, ' São Carlos II'),
	(144, ' São Carlos III'),
	(145, ' São Carlos IV'),
	(146, ' São Carlos V'),
	(147, ' São Carlos VI'),
	(148, ' São Carlos VII'),
	(149, ' São Carlos VIII'),
	(150, ' São José'),
	(151, ' Silvio Vilari'),
	(152, ' Sisi'),
	(153, ' Social Antenor Garcia'),
	(154, ' Swiss Park Residencial'),
	(155, ' Terra Nova'),
	(156, ' Tibaia de São Fernando'),
	(157, ' Tibaia de São Fernando II'),
	(158, ' Tutoya do Vale'),
	(159, ' Val Paraiso'),
	(160, ' Vale do Uirapuru'),
	(161, ' Vale Santa Felicidade'),
	(162, ' Valparaíso I'),
	(163, ' Valparaíso II'),
	(164, ' Varjao'),
	(165, ' Vila Alpes'),
	(166, ' Vila Arnaldo'),
	(167, ' Vila Bela Vista'),
	(168, ' Vila Boa Vista'),
	(169, ' Vila Boa Vista 1'),
	(170, ' Vila Brasília'),
	(171, ' Vila Carmem'),
	(172, ' Vila Celina'),
	(173, ' Vila Conceição'),
	(174, ' Vila Costa do Sol'),
	(175, ' Vila Deriggi'),
	(176, ' Vila Elizabeth'),
	(177, ' Vila Faria'),
	(178, ' Vila Irene'),
	(179, ' Vila Izabel'),
	(180, ' Vila Jacobucci'),
	(181, ' Vila Lutfalla'),
	(182, ' Vila Marcelino'),
	(183, ' Vila Marigo'),
	(184, ' Vila Marina'),
	(185, ' Vila Max'),
	(186, ' Vila Monte Carlo'),
	(187, ' Vila Monteiro (Gleba I)'),
	(188, ' Vila Morumbi'),
	(189, ' Vila Nery'),
	(190, ' Vila Nossa Senhora de Fátima'),
	(191, ' Vila Pelicano'),
	(192, ' Vila Prado'),
	(193, ' Vila Pureza'),
	(194, ' Vila Rancho Velho'),
	(195, ' Vila Santa Madre Cabrini'),
	(196, ' Vila São José'),
	(197, ' Vila Sonia'),
	(198, ' Vila Vista Alegre'),
	(199, ' Village São Carlos l'),
	(200, ' Village São Carlos ll'),
	(201, ' Waldomiro Lobbe Sobrinho');
/*!40000 ALTER TABLE `bairros_sanca` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.enderecos
CREATE TABLE IF NOT EXISTS `enderecos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `logradouro` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complemento` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bairro` int(10) unsigned NOT NULL,
  `cidade` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` enum('AC','AL','AM','AP','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RO','RS','RR','SC','SE','SP','TO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `cep` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `atualizado_por` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `enderecos_bairro_foreign` (`bairro`),
  KEY `enderecos_atualizado_por_foreign` (`atualizado_por`),
  CONSTRAINT `enderecos_atualizado_por_foreign` FOREIGN KEY (`atualizado_por`) REFERENCES `pessoas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `enderecos_bairro_foreign` FOREIGN KEY (`bairro`) REFERENCES `bairros_sanca` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.enderecos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `enderecos` DISABLE KEYS */;
INSERT INTO `enderecos` (`id`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`, `atualizado_por`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'RUA MARECHAL RONDON', '920', 'RUA RANCHO', 49, 'SÃO CARLOS', 'SP', '13562834', 1, NULL, '2017-08-21 18:26:12', '2017-08-21 18:26:12');
/*!40000 ALTER TABLE `enderecos` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.migrations: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(9, '2014_10_12_000000_create_users_table', 1),
	(10, '2014_10_12_100000_create_password_resets_table', 1),
	(11, '2017_06_13_125150_create_tipos_dados', 1),
	(12, '2017_06_14_122106_create_pessoas', 1),
	(13, '2017_08_18_111152_create_enderecos_table', 2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.password_resets: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.pessoas
CREATE TABLE IF NOT EXISTS `pessoas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nascimento` date NOT NULL,
  `por` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_por_foreign` (`por`),
  CONSTRAINT `pessoas_por_foreign` FOREIGN KEY (`por`) REFERENCES `pessoas` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.pessoas: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas` DISABLE KEYS */;
INSERT INTO `pessoas` (`id`, `nome`, `genero`, `nascimento`, `por`, `created_at`, `updated_at`) VALUES
	(1, 'ADAUTO INOCENCIO DE OLIVEIRA JUNIOR', 'h', '1984-11-10', 1, '2017-08-10 13:59:57', '2017-09-01 19:00:22'),
	(12, 'ADAUTO INOCÊNCIO DE OLIVEIRA JUNIOR', 'h', '2017-08-25', 1, '2017-08-18 13:38:11', '2017-08-18 13:38:11'),
	(21, 'CLAUDIO MENEZES', 'h', '1979-04-15', 1, '2017-08-18 17:25:12', '2017-08-18 17:25:12'),
	(22, 'JOSÉ MARIA', 'h', '1979-04-15', 1, '2017-08-18 17:27:13', '2017-08-18 17:27:13'),
	(23, 'FULANO', 'h', '2017-08-05', 1, '2017-08-18 17:41:56', '2017-08-18 17:41:56'),
	(24, 'PETERSON SILVA', 'h', '1991-05-09', 1, '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(25, 'JOSÉ CARLOS', 'h', '2017-08-01', 1, '2017-08-21 19:12:20', '2017-08-21 19:12:20'),
	(26, 'LUCIANA CARVALHO', 'm', '1997-04-21', 1, '2017-09-01 16:50:19', '2017-09-01 16:50:19'),
	(27, 'JULIANA MIRANDA', 'm', '1989-04-22', 1, '2017-09-01 18:03:50', '2017-09-01 18:03:50'),
	(28, 'ALINE CRISTINA JIOKEM', 'y', '1974-04-22', 1, '2017-09-01 18:06:10', '2017-09-01 18:29:38');
/*!40000 ALTER TABLE `pessoas` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.pessoas_controle_acessos
CREATE TABLE IF NOT EXISTS `pessoas_controle_acessos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `recurso` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_controle_acessos_pessoa_foreign` (`pessoa`),
  KEY `pessoas_controle_acessos_recurso_foreign` (`recurso`),
  CONSTRAINT `pessoas_controle_acessos_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pessoas_controle_acessos_recurso_foreign` FOREIGN KEY (`recurso`) REFERENCES `recursos_sistema` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.pessoas_controle_acessos: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_controle_acessos` DISABLE KEYS */;
INSERT INTO `pessoas_controle_acessos` (`id`, `pessoa`, `recurso`) VALUES
	(1, 1, 1),
	(2, 1, 4),
	(3, 1, 5),
	(4, 1, 8),
	(5, 1, 10),
	(6, 1, 9),
	(7, 1, 3);
/*!40000 ALTER TABLE `pessoas_controle_acessos` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.pessoas_dados_academicos
CREATE TABLE IF NOT EXISTS `pessoas_dados_academicos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `dado` int(10) unsigned NOT NULL,
  `valor` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_dados_academicos_pessoa_foreign` (`pessoa`),
  KEY `pessoas_dados_academicos_dado_foreign` (`dado`),
  CONSTRAINT `pessoas_dados_academicos_dado_foreign` FOREIGN KEY (`dado`) REFERENCES `tipos_dados` (`id`),
  CONSTRAINT `pessoas_dados_academicos_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.pessoas_dados_academicos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_dados_academicos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pessoas_dados_academicos` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.pessoas_dados_acesso
CREATE TABLE IF NOT EXISTS `pessoas_dados_acesso` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `usuario` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validade` date NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pessoas_dados_acesso_usuario_unique` (`usuario`),
  KEY `pessoas_dados_acesso_pessoa_foreign` (`pessoa`),
  CONSTRAINT `pessoas_dados_acesso_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.pessoas_dados_acesso: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_dados_acesso` DISABLE KEYS */;
INSERT INTO `pessoas_dados_acesso` (`id`, `pessoa`, `usuario`, `senha`, `validade`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 1, 'adauto', '$2y$10$.Z8icu5nrWUb7upaysiMhO5bXkBVfN71QMTBF4vjtdKyZDiaHerNO', '2017-12-31', '1', NULL, '2017-08-10 14:00:03', '2017-09-01 13:31:26'),
	(2, 24, 'peterson', '$2y$10$XoPhWnkCV/WliZNLb9HHfeuX1nX1/sv6ieUsE/xUuUujeY1VfpoDO', '2017-12-31', '1', NULL, '2017-08-30 13:59:11', '2017-09-01 15:12:55');
/*!40000 ALTER TABLE `pessoas_dados_acesso` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.pessoas_dados_administrativos
CREATE TABLE IF NOT EXISTS `pessoas_dados_administrativos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `dado` int(10) unsigned NOT NULL,
  `valor` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_dados_administrativos_pessoa_foreign` (`pessoa`),
  KEY `pessoas_dados_administrativos_dado_foreign` (`dado`),
  CONSTRAINT `pessoas_dados_administrativos_dado_foreign` FOREIGN KEY (`dado`) REFERENCES `tipos_dados` (`id`),
  CONSTRAINT `pessoas_dados_administrativos_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.pessoas_dados_administrativos: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_dados_administrativos` DISABLE KEYS */;
INSERT INTO `pessoas_dados_administrativos` (`id`, `pessoa`, `dado`, `valor`, `created_at`, `updated_at`) VALUES
	(1, 12, 16, 'Docente', '2017-08-25 11:49:13', '2017-08-25 11:49:14');
/*!40000 ALTER TABLE `pessoas_dados_administrativos` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.pessoas_dados_clinicos
CREATE TABLE IF NOT EXISTS `pessoas_dados_clinicos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `dado` int(10) unsigned NOT NULL,
  `valor` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_dados_clinicos_pessoa_foreign` (`pessoa`),
  KEY `pessoas_dados_clinicos_dado_foreign` (`dado`),
  CONSTRAINT `pessoas_dados_clinicos_dado_foreign` FOREIGN KEY (`dado`) REFERENCES `tipos_dados` (`id`),
  CONSTRAINT `pessoas_dados_clinicos_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.pessoas_dados_clinicos: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_dados_clinicos` DISABLE KEYS */;
INSERT INTO `pessoas_dados_clinicos` (`id`, `pessoa`, `dado`, `valor`, `created_at`, `updated_at`) VALUES
	(1, 24, 11, 'AUDITIVA', '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(2, 24, 12, 'ATENOLOL', '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(3, 24, 13, 'PICADA DE ABELHAS', '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(4, 24, 14, 'LABERINTITE', '2017-08-21 18:26:12', '2017-08-21 18:26:12');
/*!40000 ALTER TABLE `pessoas_dados_clinicos` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.pessoas_dados_contato
CREATE TABLE IF NOT EXISTS `pessoas_dados_contato` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `dado` int(10) unsigned NOT NULL,
  `valor` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_dados_contato_pessoa_foreign` (`pessoa`),
  KEY `pessoas_dados_contato_dado_foreign` (`dado`),
  CONSTRAINT `pessoas_dados_contato_dado_foreign` FOREIGN KEY (`dado`) REFERENCES `tipos_dados` (`id`),
  CONSTRAINT `pessoas_dados_contato_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.pessoas_dados_contato: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_dados_contato` DISABLE KEYS */;
INSERT INTO `pessoas_dados_contato` (`id`, `pessoa`, `dado`, `valor`, `created_at`, `updated_at`) VALUES
	(1, 24, 1, 'peterson.silva@gmail.com', '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(2, 24, 2, '33721308', '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(3, 24, 9, '33615170', '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(4, 24, 10, '992288877', '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(5, 24, 6, '1', '2017-08-21 18:26:12', '2017-08-21 18:26:12');
/*!40000 ALTER TABLE `pessoas_dados_contato` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.pessoas_dados_financeiros
CREATE TABLE IF NOT EXISTS `pessoas_dados_financeiros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `dado` int(10) unsigned NOT NULL,
  `valor` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_dados_financeiros_pessoa_foreign` (`pessoa`),
  KEY `pessoas_dados_financeiros_dado_foreign` (`dado`),
  CONSTRAINT `pessoas_dados_financeiros_dado_foreign` FOREIGN KEY (`dado`) REFERENCES `tipos_dados` (`id`),
  CONSTRAINT `pessoas_dados_financeiros_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.pessoas_dados_financeiros: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_dados_financeiros` DISABLE KEYS */;
/*!40000 ALTER TABLE `pessoas_dados_financeiros` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.pessoas_dados_gerais
CREATE TABLE IF NOT EXISTS `pessoas_dados_gerais` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `dado` int(10) unsigned NOT NULL,
  `valor` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_dados_gerais_pessoa_foreign` (`pessoa`),
  KEY `pessoas_dados_gerais_dado_foreign` (`dado`),
  CONSTRAINT `pessoas_dados_gerais_dado_foreign` FOREIGN KEY (`dado`) REFERENCES `tipos_dados` (`id`),
  CONSTRAINT `pessoas_dados_gerais_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.pessoas_dados_gerais: ~14 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_dados_gerais` DISABLE KEYS */;
INSERT INTO `pessoas_dados_gerais` (`id`, `pessoa`, `dado`, `valor`, `created_at`, `updated_at`) VALUES
	(19, 1, 7, '1', '2017-08-18 17:25:12', '2017-08-18 17:25:12'),
	(20, 1, 7, '12', '2017-08-18 17:27:13', '2017-08-18 17:27:13'),
	(21, 12, 15, '1', '2017-08-18 17:41:56', '2017-08-18 17:41:56'),
	(22, 24, 4, '123123', '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(23, 24, 3, '456789', '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(24, 24, 5, 'gente boa', '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(25, 25, 3, '1234567', '2017-08-21 19:12:20', '2017-08-21 19:12:20'),
	(26, 21, 17, '1', '2017-08-25 13:44:48', '2017-08-25 13:44:49'),
	(27, 26, 3, '55787388933', '2017-09-01 16:50:19', '2017-09-01 16:50:19'),
	(28, 27, 3, '78315368923', '2017-09-01 18:03:50', '2017-09-01 18:03:50'),
	(47, 28, 8, 'Carlão da padoca', '2017-09-01 18:55:43', '2017-09-01 18:55:43'),
	(48, 28, 4, '0000', '2017-09-01 18:57:13', '2017-09-01 18:57:13'),
	(49, 28, 3, '111111', '2017-09-01 18:57:13', '2017-09-01 18:57:13'),
	(50, 28, 8, 'Fulano', '2017-09-01 18:57:13', '2017-09-01 18:57:13'),
	(51, 1, 3, '32488352810', '2017-09-01 19:00:22', '2017-09-01 19:00:22'),
	(52, 28, 4, '0000', '2017-09-01 19:17:58', '2017-09-01 19:17:58'),
	(53, 28, 8, 'Fulano', '2017-09-01 19:17:58', '2017-09-01 19:17:58'),
	(54, 28, 4, '0000', '2017-09-01 19:18:21', '2017-09-01 19:18:21'),
	(55, 28, 8, 'Fulano', '2017-09-01 19:18:21', '2017-09-01 19:18:21'),
	(56, 28, 4, '0000', '2017-09-01 19:22:01', '2017-09-01 19:22:01'),
	(57, 28, 8, 'Fulano', '2017-09-01 19:22:01', '2017-09-01 19:22:01'),
	(58, 28, 4, '0000', '2017-09-01 19:22:49', '2017-09-01 19:22:49'),
	(59, 28, 8, 'Fulano', '2017-09-01 19:22:49', '2017-09-01 19:22:49'),
	(60, 28, 4, '0000', '2017-09-01 19:23:07', '2017-09-01 19:23:07'),
	(61, 28, 8, 'Fulano', '2017-09-01 19:23:07', '2017-09-01 19:23:07'),
	(62, 28, 4, '0000', '2017-09-01 19:24:20', '2017-09-01 19:24:20'),
	(63, 28, 8, 'Fulano', '2017-09-01 19:24:20', '2017-09-01 19:24:20'),
	(64, 1, 4, '123', '2017-09-01 19:26:03', '2017-09-01 19:26:03'),
	(65, 1, 4, '123', '2017-09-01 19:26:41', '2017-09-01 19:26:41'),
	(66, 1, 3, '32488352810', '2017-09-01 19:26:41', '2017-09-01 19:26:41'),
	(67, 1, 4, '1234', '2017-09-01 19:31:46', '2017-09-01 19:31:46'),
	(68, 1, 3, '32488352810', '2017-09-01 19:31:46', '2017-09-01 19:31:46'),
	(69, 1, 4, '1234', '2017-09-01 19:33:05', '2017-09-01 19:33:05'),
	(70, 1, 3, '32488352810', '2017-09-01 19:33:05', '2017-09-01 19:33:05'),
	(71, 1, 4, '1234', '2017-09-01 19:33:31', '2017-09-01 19:33:31'),
	(72, 1, 3, '32488352810', '2017-09-01 19:33:31', '2017-09-01 19:33:31'),
	(73, 1, 4, '1234', '2017-09-01 19:37:01', '2017-09-01 19:37:01'),
	(74, 1, 3, '32488352810', '2017-09-01 19:37:01', '2017-09-01 19:37:01'),
	(75, 1, 4, '1234', '2017-09-01 19:37:32', '2017-09-01 19:37:32'),
	(76, 1, 3, '32488352810', '2017-09-01 19:37:32', '2017-09-01 19:37:32'),
	(77, 1, 4, '1234', '2017-09-01 19:39:13', '2017-09-01 19:39:13'),
	(78, 1, 3, '32488352810', '2017-09-01 19:39:13', '2017-09-01 19:39:13'),
	(79, 1, 4, '1234', '2017-09-01 19:39:25', '2017-09-01 19:39:25'),
	(80, 1, 3, '32488352810', '2017-09-01 19:39:25', '2017-09-01 19:39:25'),
	(81, 1, 4, '1234', '2017-09-01 19:40:28', '2017-09-01 19:40:28'),
	(82, 1, 3, '32488352810', '2017-09-01 19:40:28', '2017-09-01 19:40:28'),
	(83, 1, 4, '1234', '2017-09-01 19:44:00', '2017-09-01 19:44:00'),
	(84, 1, 3, '32488352810', '2017-09-01 19:44:00', '2017-09-01 19:44:00');
/*!40000 ALTER TABLE `pessoas_dados_gerais` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.recursos_sistema
CREATE TABLE IF NOT EXISTS `recursos_sistema` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.recursos_sistema: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `recursos_sistema` DISABLE KEYS */;
INSERT INTO `recursos_sistema` (`id`, `nome`, `desc`, `link`) VALUES
	(1, 'cadastrar_pessoa', 'Cadastro de pessoas,\r\ncadastro de alunos,\r\ncadastro de professores,\r\ncadastro de colaboradores,\r\nCadastro de funcionários.', '/pessoa/cadastrar'),
	(2, 'editar_dados_restritos', 'Gerencia  pessoas restritas', '/pessoa/listar'),
	(3, 'editar_dados_alunos', 'Gerencia pessoas SEM relação Institucional', '/pessoa/listar'),
	(4, 'ver_alunos', 'Pode visualizar todos perfis', '/pessoa/listar'),
	(5, 'ver_funcionarios', 'Pode ver a lista de pessoas com relação institucional', '/pessoa/listar'),
	(6, 'ver_privados', 'Pertite visualizar os dados de pessoas privadas', '/pessoas/'),
	(7, 'editar_funcionarios', 'Faz parte do quadro de funcionários / colaboradores da FESC', '/pessoas'),
	(8, 'cadastrar_usuarios', 'Criar acesso ao sistema para as pessoas', '/pessoa/$id/cadastrar-acesso'),
	(9, 'editar_login_alunos', 'Pode alterar senha dos alunos', '/secretaria/atender'),
	(10, 'editar_login_pri', 'Edita login de pessoas com relação institucional', '/admin/listarusuarios'),
	(11, 'editar_login_restritos', 'Edita login de pessoas restritas', '/admin/listarusuarios');
/*!40000 ALTER TABLE `recursos_sistema` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.tipos_dados
CREATE TABLE IF NOT EXISTS `tipos_dados` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria` enum('academico','acesso','administrativo','clinico','contato','financeiro','geral','log') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.tipos_dados: ~16 rows (aproximadamente)
/*!40000 ALTER TABLE `tipos_dados` DISABLE KEYS */;
INSERT INTO `tipos_dados` (`id`, `tipo`, `categoria`, `desc`) VALUES
	(1, 'email', 'contato', 'Endereço de email'),
	(2, 'telefone', 'contato', 'Número de telefone'),
	(3, 'cpf', 'geral', 'Cadastro de Pessoa Física CPF'),
	(4, 'rg', 'geral', 'Registro Geral - RG'),
	(5, 'obs', 'geral', 'Observações sobre'),
	(6, 'endereco', 'contato', 'Endereço completo'),
	(7, 'dependente', 'geral', 'Depependente da pessoa'),
	(8, 'nome_registro', 'geral', 'Nome Social caso transgênero'),
	(9, 'telefone_alternativo', 'contato', 'Telefone secundário'),
	(10, 'telefone_contato', 'contato', 'Telefone de algum conhecido'),
	(11, 'necessidade_especial', 'clinico', 'Necessidades especiais da pessoa'),
	(12, 'medicamentos_continuos', 'clinico', 'Medicamentos de uso contínuo'),
	(13, 'alergias', 'clinico', 'Alergia a alguma coisa ou medicamento'),
	(14, 'doenca_cronica', 'clinico', 'Doenças crônicas'),
	(15, 'responsavel', 'geral', 'Responsável legal'),
	(16, 'relacao_institucional', 'administrativo', 'Relação Institucional'),
	(17, 'perfil_privado', 'geral', 'Perfil que só exibe dados para sí.');
/*!40000 ALTER TABLE `tipos_dados` ENABLE KEYS */;

-- Copiando estrutura para tabela sge.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sge.users: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
