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

-- Copiando dados para a tabela sge.atendimentos: ~30 rows (aproximadamente)
/*!40000 ALTER TABLE `atendimentos` DISABLE KEYS */;
INSERT INTO `atendimentos` (`id`, `atendente`, `usuario`, `descricao`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Matricula(s)', '2017-10-30 17:32:48', '2017-10-30 18:06:50'),
	(2, 1, 30, NULL, '2017-10-30 18:26:13', '2017-10-30 18:26:13'),
	(3, 1, 28, 'Matricula(s)', '2017-10-30 18:32:31', '2017-10-30 18:37:21'),
	(4, 1, 28, 'Matricula(s)', '2017-10-30 18:49:36', '2017-10-30 18:49:55'),
	(5, 1, 1, NULL, '2017-11-01 10:17:25', '2017-11-01 10:17:25'),
	(6, 1, 1, NULL, '2017-11-01 10:58:04', '2017-11-01 10:58:04'),
	(7, 1, 1, NULL, '2017-11-01 11:04:38', '2017-11-01 11:04:38'),
	(8, 1, 1, NULL, '2017-11-01 09:05:04', '2017-11-01 09:05:04'),
	(9, 1, 31, NULL, '2017-11-01 09:05:46', '2017-11-01 09:05:46'),
	(10, 1, 31, NULL, '2017-11-01 09:13:43', '2017-11-01 09:13:43'),
	(11, 1, 31, NULL, '2017-11-01 09:29:16', '2017-11-01 09:29:16'),
	(12, 1, 31, NULL, '2017-11-01 09:29:55', '2017-11-01 09:29:55'),
	(13, 1, 31, NULL, '2017-11-01 09:31:01', '2017-11-01 09:31:01'),
	(14, 1, 31, NULL, '2017-11-01 09:31:45', '2017-11-01 09:31:45'),
	(15, 1, 31, NULL, '2017-11-01 09:32:14', '2017-11-01 09:32:14'),
	(16, 1, 31, NULL, '2017-11-01 09:32:15', '2017-11-01 09:32:15'),
	(17, 1, 31, 'Matricula(s)', '2017-11-01 09:33:45', '2017-11-01 09:34:58'),
	(18, 1, 31, 'Matricula(s)', '2017-11-01 09:56:02', '2017-11-01 10:19:00'),
	(19, 1, 21, 'Matricula(s)', '2017-11-01 10:29:04', '2017-11-01 10:55:12'),
	(20, 1, 24, 'Matricula(s)', '2017-11-01 16:15:53', '2017-11-01 16:17:55'),
	(21, 1, 24, NULL, '2017-11-01 16:18:04', '2017-11-01 16:18:04'),
	(22, 1, 30, NULL, '2017-11-06 11:26:29', '2017-11-06 11:26:29'),
	(23, 1, 35, NULL, '2017-11-08 08:11:47', '2017-11-08 08:11:47'),
	(24, 1, 32, NULL, '2017-11-08 14:17:10', '2017-11-08 14:17:10'),
	(25, 1, 23, 'Matricula(s)', '2017-11-13 09:04:12', '2017-11-13 09:37:54'),
	(26, 1, 23, 'Matricula(s)', '2017-11-13 10:01:55', '2017-11-13 10:02:29'),
	(27, 1, 23, NULL, '2017-11-13 10:05:00', '2017-11-13 10:05:00'),
	(28, 1, 24, 'Matricula(s)', '2017-11-13 13:38:28', '2017-11-13 13:43:29'),
	(29, 1, 24, 'Matricula(s)', '2017-11-13 13:45:18', '2017-11-13 13:45:32'),
	(30, 1, 24, 'Matricula(s)', '2017-11-13 13:46:14', '2017-11-13 15:11:50'),
	(31, 1, 24, 'Matricula(s)', '2017-11-13 15:12:25', '2017-11-13 15:30:57'),
	(32, 1, 24, 'Matricula(s)', '2017-11-13 15:31:23', '2017-11-13 15:56:06'),
	(33, 1, 32, 'Matricula(s)', '2017-11-13 15:58:14', '2017-11-13 15:58:27'),
	(34, 1, 33, 'Matricula(s)', '2017-11-13 16:01:22', '2017-11-13 16:01:34'),
	(35, 1, 33, 'Matricula(s)', '2017-11-13 16:02:49', '2017-11-13 16:03:17'),
	(36, 1, 33, 'Matricula(s)', '2017-11-13 16:04:10', '2017-11-13 16:06:31'),
	(37, 1, 33, 'Matricula(s)', '2017-11-13 16:07:38', '2017-11-13 16:09:23'),
	(38, 1, 23, 'Matricula(s)', '2017-11-13 16:10:12', '2017-11-13 16:10:23'),
	(39, 1, 23, 'Matricula(s)', '2017-11-13 16:10:31', '2017-11-13 16:10:44'),
	(40, 1, 23, 'Matricula(s)', '2017-11-13 16:11:20', '2017-11-13 16:15:00'),
	(41, 1, 23, 'Matricula(s)', '2017-11-13 16:15:09', '2017-11-13 16:15:25'),
	(42, 1, 23, 'Matricula(s)', '2017-11-13 16:17:05', '2017-11-13 16:17:20'),
	(43, 1, 23, 'Matricula(s)', '2017-11-13 16:18:55', '2017-11-13 16:19:07'),
	(44, 1, 23, 'Matricula(s)', '2017-11-13 16:22:55', '2017-11-13 16:26:01'),
	(45, 1, 23, 'Matricula(s)', '2017-11-13 16:29:01', '2017-11-13 16:29:14'),
	(46, 1, 23, 'Matricula(s)', '2017-11-13 16:29:27', '2017-11-13 16:29:59'),
	(47, 1, 23, 'Matricula(s)', '2017-11-13 16:30:51', '2017-11-13 16:31:03'),
	(48, 1, 23, 'Matricula(s)', '2017-11-13 16:31:17', '2017-11-13 16:31:29');
/*!40000 ALTER TABLE `atendimentos` ENABLE KEYS */;

-- Copiando dados para a tabela sge.bairros_sanca: ~201 rows (aproximadamente)
/*!40000 ALTER TABLE `bairros_sanca` DISABLE KEYS */;
INSERT INTO `bairros_sanca` (`id`, `nome`) VALUES
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

-- Copiando dados para a tabela sge.classes: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;

-- Copiando dados para a tabela sge.cursos: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;
INSERT INTO `cursos` (`id`, `nome`, `programa`, `desc`, `vagas`, `carga`, `valor`) VALUES
	(1, 'Gestão de negócios públicos', 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec varius dui eu laoreet interdum. Morbi nec lorem ac magna commodo convallis. Morbi non finibus diam. Nam in eros eu metus sodales tincidunt. Mauris porttitor consectetur lacus, non maximus sapien sodales at. Mauris luctus, odio eget tempo', 50, 20, 321.00),
	(4, 'Introdução Tecnológica para o Trabalho (Windows & Internet)', 6, 'Curso Básico de informática', 10, 30, 164.00),
	(5, 'Atividade física e lazer', 4, 'Práticas de atividades físicas', 20, 30, 120.00),
	(6, 'Hidroginástica', 1, 'Exercícios físicos aquáticos.', 50, 30, 54.00),
	(7, 'Excel Completo', 2, 'Excel do básico ao avançado.', 10, 30, 150.00),
	(10, 'Alongamento', 4, 'Atividade de alongamento', 20, NULL, 120.00),
	(11, 'Alongamento', 4, 'Atividade de alongamento', 20, NULL, 120.00),
	(12, 'Exercitando a memória', 4, 'Práticas de atividades intelectuais para o exercício da memória.', 20, NULL, 64.00);
/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;

-- Copiando dados para a tabela sge.cursos_requisitos: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `cursos_requisitos` DISABLE KEYS */;
INSERT INTO `cursos_requisitos` (`id`, `curso`, `requisito`, `obrigatorio`) VALUES
	(56, 1, 18, 1),
	(57, 1, 20, 0),
	(62, 12, 22, 1),
	(70, 6, 18, 1),
	(71, 6, 22, 0);
/*!40000 ALTER TABLE `cursos_requisitos` ENABLE KEYS */;

-- Copiando dados para a tabela sge.descontos: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `descontos` DISABLE KEYS */;
INSERT INTO `descontos` (`id`, `nome`, `descricao`, `tipo`, `valor`, `validade`, `status`) VALUES
	(1, 'Bolsa Integral', 'Bolsa de estudos Integral', 'p', 100, '2017-12-20', '0'),
	(2, 'Bolsa 50%', 'Bolsa de 50% na mantrícula', 'p', 50, '2017-10-20', '0'),
	(3, 'Promoção Convide um amigo', 'Convidando um amigo a pessoa ganha 10% no Matrícula', 'p', 10, '2017-10-20', '0'),
	(4, 'Promoção Piscina para alunos', 'Se for aluno de outros cursos ganha desconto na piscina', 'v', 30, '2017-10-20', '0');
/*!40000 ALTER TABLE `descontos` ENABLE KEYS */;

-- Copiando dados para a tabela sge.disciplinas: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `disciplinas` DISABLE KEYS */;
INSERT INTO `disciplinas` (`id`, `nome`, `programa`, `desc`, `vagas`, `carga`, `created_at`, `updated_at`) VALUES
	(2, 'Qualidade de vida', 4, 'teste', 10, 20, '2017-09-04 19:15:33', '2017-09-29 12:33:49'),
	(4, 'Logica de programação', 6, 'Ensino de como ligar a lógica computacional com o mundo real através de algoritimos', 20, 30, '2017-09-06 19:00:38', '2017-09-29 12:37:44');
/*!40000 ALTER TABLE `disciplinas` ENABLE KEYS */;

-- Copiando dados para a tabela sge.enderecos: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `enderecos` DISABLE KEYS */;
INSERT INTO `enderecos` (`id`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`, `atualizado_por`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'RUA MARECHAL RONDON', '920', 'RUA RANCHO', 49, 'SÃO CARLOS', 'SP', '13562834', 1, NULL, '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(7, 'RUA MARECHAL RONDON', '920', 'RUA RANCHO', 49, 'SÃO CARLOS', 'SP', '13562834', 1, NULL, '2017-09-15 11:59:39', '2017-09-15 11:59:39'),
	(8, 'RUA IRINEU GABRIEL FLORINDO', '85', '', 49, 'SÃO CARLOS', 'SP', '13562834', 1, NULL, '2017-09-15 14:21:44', '2017-09-15 14:21:44');
/*!40000 ALTER TABLE `enderecos` ENABLE KEYS */;

-- Copiando dados para a tabela sge.grades: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `grades` DISABLE KEYS */;
INSERT INTO `grades` (`id`, `curso`, `disciplina`, `obrigatoria`) VALUES
	(18, 1, 2, 0),
	(19, 1, 4, 1);
/*!40000 ALTER TABLE `grades` ENABLE KEYS */;

-- Copiando dados para a tabela sge.locais: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `locais` DISABLE KEYS */;
INSERT INTO `locais` (`id`, `sala`, `unidade`, `capacidade`) VALUES
	(1, 'Telecentro', 'FESC 1', '10'),
	(2, '1', 'FESC 1', '30'),
	(3, '2', 'FESC 1', '30'),
	(4, 'Telecentro', 'FESC 3', '10'),
	(5, 'Costura', 'FESC 3', '20'),
	(6, 'Externa', 'FESC 1', '50');
/*!40000 ALTER TABLE `locais` ENABLE KEYS */;

-- Copiando dados para a tabela sge.matriculas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `matriculas` DISABLE KEYS */;
INSERT INTO `matriculas` (`id`, `pessoa`, `atendimento`, `status`, `dia_venc`, `forma_pgto`, `parcelas`, `resp_financeiro`, `contrato`, `turma`, `created_at`, `updated_at`) VALUES
	(50, 23, 46, 'regular', 7, 'boleto', 3, NULL, NULL, 2, '2017-11-13 16:29:59', '2017-11-13 16:29:59'),
	(51, 23, 47, 'regular', 7, 'boleto', 1, NULL, NULL, 4, '2017-11-13 16:31:02', '2017-11-13 16:31:02'),
	(52, 23, 48, 'regular', 7, 'boleto', 1, NULL, NULL, 3, '2017-11-13 16:31:29', '2017-11-13 16:31:29');
/*!40000 ALTER TABLE `matriculas` ENABLE KEYS */;

-- Copiando dados para a tabela sge.migrations: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2017_10_30_165836_create_atendimentos_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Copiando dados para a tabela sge.password_resets: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Copiando dados para a tabela sge.pessoas: ~19 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas` DISABLE KEYS */;
INSERT INTO `pessoas` (`id`, `nome`, `genero`, `nascimento`, `por`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'ADAUTO INOCENCIO DE OLIVEIRA JUNIOR', 'h', '1984-11-10', 1, '2017-08-10 13:59:57', '2017-09-01 19:00:22', NULL),
	(12, 'ADAUTO INOCÊNCIO DE OLIVEIRA JUNIOR', 'h', '2017-08-25', 1, '2017-08-18 13:38:11', '2017-08-18 13:38:11', NULL),
	(21, 'CLAUDIO MENEZES', 'h', '1979-04-15', 1, '2017-08-18 17:25:12', '2017-08-18 17:25:12', NULL),
	(22, 'JOSÉ MARIA', 'h', '1979-04-15', 1, '2017-08-18 17:27:13', '2017-08-18 17:27:13', NULL),
	(23, 'FULANO', 'h', '2017-08-05', 1, '2017-08-18 17:41:56', '2017-08-18 17:41:56', NULL),
	(24, 'PETERSON SILVA', 'h', '1991-05-09', 1, '2017-08-21 18:26:12', '2017-08-21 18:26:12', NULL),
	(25, 'JOSÉ CARLOS', 'h', '2017-08-01', 1, '2017-08-21 19:12:20', '2017-08-21 19:12:20', NULL),
	(26, 'LUCIANA CARVALHO', 'm', '1997-04-21', 1, '2017-09-01 16:50:19', '2017-09-01 16:50:19', NULL),
	(27, 'JULIANA MIRANDA', 'm', '1989-04-22', 1, '2017-09-01 18:03:50', '2017-09-04 12:14:11', NULL),
	(28, 'ALINE CRISTINA JOKEMIOX', 'y', '1974-04-22', 1, '2017-09-01 18:06:10', '2017-09-04 12:41:58', NULL),
	(29, 'JULIANA DOS REIAS COTRIN', 'm', '1972-08-25', 1, '2017-09-15 11:34:15', '2017-09-15 11:34:15', NULL),
	(30, 'CARLA DA SILVA CARVALHO', 'm', '1999-04-22', 1, '2017-09-15 11:37:30', '2017-09-15 11:37:30', NULL),
	(31, 'GIOVANA BOTELHO', 'm', '1944-07-19', 1, '2017-09-15 11:39:59', '2017-09-15 11:39:59', NULL),
	(32, 'RODRIGO CARVALHO', 'h', '1972-02-10', 1, '2017-09-15 11:51:53', '2017-09-15 11:51:53', NULL),
	(33, 'FELIPE MASSA', 'h', '1976-04-28', 1, '2017-09-15 11:53:26', '2017-09-15 11:53:26', NULL),
	(34, 'JOSE', 'h', '2017-09-15', 1, '2017-09-15 11:55:13', '2017-09-15 11:55:13', NULL),
	(35, 'MAURICIO', 'h', '1997-09-11', 1, '2017-09-15 11:57:37', '2017-11-08 08:12:18', NULL),
	(36, 'SIMONE', 'm', '2017-09-21', 1, '2017-09-15 11:59:39', '2017-09-15 11:59:39', NULL),
	(37, 'MARIA RITA', 'm', '2017-09-08', 1, '2017-09-15 12:05:37', '2017-09-15 12:05:37', NULL);
/*!40000 ALTER TABLE `pessoas` ENABLE KEYS */;

-- Copiando dados para a tabela sge.pessoas_controle_acessos: ~12 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_controle_acessos` DISABLE KEYS */;
INSERT INTO `pessoas_controle_acessos` (`id`, `pessoa`, `recurso`, `deleted_at`) VALUES
	(39, 1, 1, NULL),
	(40, 1, 2, NULL),
	(41, 1, 3, NULL),
	(42, 1, 4, NULL),
	(43, 1, 5, NULL),
	(44, 1, 6, NULL),
	(45, 1, 7, NULL),
	(46, 1, 8, NULL),
	(47, 1, 9, NULL),
	(48, 1, 10, NULL),
	(49, 1, 11, NULL),
	(51, 24, 4, NULL);
/*!40000 ALTER TABLE `pessoas_controle_acessos` ENABLE KEYS */;

-- Copiando dados para a tabela sge.pessoas_dados_academicos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_dados_academicos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pessoas_dados_academicos` ENABLE KEYS */;

-- Copiando dados para a tabela sge.pessoas_dados_acesso: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_dados_acesso` DISABLE KEYS */;
INSERT INTO `pessoas_dados_acesso` (`id`, `pessoa`, `usuario`, `senha`, `validade`, `status`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 'adauto', '$2y$10$.Z8icu5nrWUb7upaysiMhO5bXkBVfN71QMTBF4vjtdKyZDiaHerNO', '2017-12-31', '1', '$2a$11$BpuKl267TczRgPlkm7R6VOnU/wVGv1PaZMYF4utO069kh2t1uK6Cm', NULL, '2017-08-10 14:00:03', '2017-10-23 12:51:52'),
	(2, 24, 'peterson', '$2y$10$XoPhWnkCV/WliZNLb9HHfeuX1nX1/sv6ieUsE/xUuUujeY1VfpoDO', '2017-12-31', '0', NULL, NULL, '2017-08-30 13:59:11', '2017-09-18 17:29:39');
/*!40000 ALTER TABLE `pessoas_dados_acesso` ENABLE KEYS */;

-- Copiando dados para a tabela sge.pessoas_dados_administrativos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_dados_administrativos` DISABLE KEYS */;
INSERT INTO `pessoas_dados_administrativos` (`id`, `pessoa`, `dado`, `deleted_at`, `valor`, `created_at`, `updated_at`) VALUES
	(1, 12, 16, NULL, 'Docente', '2017-08-25 11:49:13', '2017-08-25 11:49:14'),
	(6, 1, 16, NULL, 'Educador', '2017-09-20 20:06:49', '2017-09-20 20:06:49'),
	(7, 27, 16, NULL, 'Assistente', '2017-11-01 10:36:05', '2017-11-01 10:36:05');
/*!40000 ALTER TABLE `pessoas_dados_administrativos` ENABLE KEYS */;

-- Copiando dados para a tabela sge.pessoas_dados_clinicos: ~14 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_dados_clinicos` DISABLE KEYS */;
INSERT INTO `pessoas_dados_clinicos` (`id`, `pessoa`, `dado`, `valor`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 24, 11, 'AUDITIVA', NULL, '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(2, 24, 12, 'ATENOLOL', NULL, '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(3, 24, 13, 'PICADA DE ABELHAS', NULL, '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(4, 24, 14, 'LABERINTITE', NULL, '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(5, 24, 11, '', NULL, '2017-09-15 17:24:03', '2017-09-15 17:24:03'),
	(6, 24, 12, 'ATENOLOL', NULL, '2017-09-15 17:24:03', '2017-09-15 17:24:03'),
	(7, 24, 13, 'PICADA DE ABELHAS', NULL, '2017-09-15 17:24:03', '2017-09-15 17:24:03'),
	(8, 24, 14, 'LABERINTITE', NULL, '2017-09-15 17:24:03', '2017-09-15 17:24:03'),
	(9, 12, 13, 'PICADA DE ABELHAS', NULL, '2017-09-15 17:25:25', '2017-09-15 17:25:25'),
	(10, 24, 11, 'AUDITIVA', NULL, '2017-09-15 19:48:09', '2017-09-15 19:48:09'),
	(11, 24, 12, 'ATENOLOL', NULL, '2017-09-15 19:48:09', '2017-09-15 19:48:09'),
	(12, 24, 13, 'PICADA DE ABELHAS', NULL, '2017-09-15 19:48:09', '2017-09-15 19:48:09'),
	(13, 24, 14, 'LABERINTITE', NULL, '2017-09-15 19:48:09', '2017-09-15 19:48:09'),
	(14, 1, 13, 'ABELHA', NULL, '2017-09-22 19:37:28', '2017-09-22 19:37:28'),
	(15, 1, 13, 'PICADA DE ABELHA', NULL, '2017-11-01 10:06:04', '2017-11-01 10:06:04');
/*!40000 ALTER TABLE `pessoas_dados_clinicos` ENABLE KEYS */;

-- Copiando dados para a tabela sge.pessoas_dados_contato: ~12 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_dados_contato` DISABLE KEYS */;
INSERT INTO `pessoas_dados_contato` (`id`, `pessoa`, `dado`, `valor`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 24, 1, 'peterson.silva@gmail.com', NULL, '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(2, 24, 2, '33721308', NULL, '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(3, 24, 9, '33615170', NULL, '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(4, 24, 10, '992288877', NULL, '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(12, 24, 6, '1', NULL, '2017-09-15 12:05:37', '2017-09-15 12:05:37'),
	(13, 1, 1, 'adautonet@gmail.com', NULL, '2017-09-15 14:21:44', '2017-09-15 14:21:44'),
	(14, 1, 2, '1633615170', NULL, '2017-09-15 14:21:44', '2017-09-15 14:21:44'),
	(15, 1, 9, '16982005092', NULL, '2017-09-15 14:21:44', '2017-09-15 14:21:44'),
	(16, 1, 10, '16992222222', NULL, '2017-09-15 14:21:44', '2017-09-15 14:21:44'),
	(17, 1, 6, '8', NULL, '2017-09-15 14:21:44', '2017-09-15 14:21:44'),
	(18, 1, 9, '16991370041', NULL, '2017-09-15 14:29:49', '2017-09-15 14:29:49'),
	(19, 30, 1, 'calinha23@yahoo.com', NULL, '2017-09-15 14:52:31', '2017-09-15 14:52:31');
/*!40000 ALTER TABLE `pessoas_dados_contato` ENABLE KEYS */;

-- Copiando dados para a tabela sge.pessoas_dados_financeiros: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_dados_financeiros` DISABLE KEYS */;
/*!40000 ALTER TABLE `pessoas_dados_financeiros` ENABLE KEYS */;

-- Copiando dados para a tabela sge.pessoas_dados_gerais: ~100 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas_dados_gerais` DISABLE KEYS */;
INSERT INTO `pessoas_dados_gerais` (`id`, `pessoa`, `dado`, `valor`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(19, 1, 7, '1', NULL, '2017-08-18 17:25:12', '2017-08-18 17:25:12'),
	(21, 12, 15, '1', NULL, '2017-08-18 17:41:56', '2017-08-18 17:41:56'),
	(22, 24, 4, '123123', NULL, '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(23, 24, 3, '456789', NULL, '2017-08-21 18:26:12', '2017-08-21 18:26:12'),
	(25, 25, 3, '1234567', NULL, '2017-08-21 19:12:20', '2017-08-21 19:12:20'),
	(26, 21, 17, '1', NULL, '2017-08-25 13:44:48', '2017-08-25 13:44:49'),
	(27, 26, 3, '55787388933', NULL, '2017-09-01 16:50:19', '2017-09-01 16:50:19'),
	(28, 27, 3, '78315368923', NULL, '2017-09-01 18:03:50', '2017-09-01 18:03:50'),
	(47, 28, 8, 'Carlão da padoca', NULL, '2017-09-01 18:55:43', '2017-09-01 18:55:43'),
	(48, 28, 4, '0000', NULL, '2017-09-01 18:57:13', '2017-09-01 18:57:13'),
	(49, 28, 3, '111111', NULL, '2017-09-01 18:57:13', '2017-09-01 18:57:13'),
	(50, 28, 8, 'Fulano', NULL, '2017-09-01 18:57:13', '2017-09-01 18:57:13'),
	(51, 1, 3, '32488352819', NULL, '2017-09-01 19:00:22', '2017-09-01 19:00:22'),
	(52, 28, 4, '0000', NULL, '2017-09-01 19:17:58', '2017-09-01 19:17:58'),
	(53, 28, 8, 'Fulano', NULL, '2017-09-01 19:17:58', '2017-09-01 19:17:58'),
	(54, 28, 4, '0000', NULL, '2017-09-01 19:18:21', '2017-09-01 19:18:21'),
	(55, 28, 8, 'Fulano', NULL, '2017-09-01 19:18:21', '2017-09-01 19:18:21'),
	(56, 28, 4, '0000', NULL, '2017-09-01 19:22:01', '2017-09-01 19:22:01'),
	(57, 28, 8, 'Fulano', NULL, '2017-09-01 19:22:01', '2017-09-01 19:22:01'),
	(58, 28, 4, '0000', NULL, '2017-09-01 19:22:49', '2017-09-01 19:22:49'),
	(59, 28, 8, 'Fulano', NULL, '2017-09-01 19:22:49', '2017-09-01 19:22:49'),
	(60, 28, 4, '0000', NULL, '2017-09-01 19:23:07', '2017-09-01 19:23:07'),
	(61, 28, 8, 'Fulano', NULL, '2017-09-01 19:23:07', '2017-09-01 19:23:07'),
	(62, 28, 4, '0000', NULL, '2017-09-01 19:24:20', '2017-09-01 19:24:20'),
	(63, 28, 8, 'Fulano', NULL, '2017-09-01 19:24:20', '2017-09-01 19:24:20'),
	(64, 1, 4, '123', NULL, '2017-09-01 19:26:03', '2017-09-01 19:26:03'),
	(65, 1, 4, '123', NULL, '2017-09-01 19:26:41', '2017-09-01 19:26:41'),
	(66, 1, 3, '32488352810', NULL, '2017-09-01 19:26:41', '2017-09-01 19:26:41'),
	(67, 1, 4, '1234', NULL, '2017-09-01 19:31:46', '2017-09-01 19:31:46'),
	(68, 1, 3, '32488352810', NULL, '2017-09-01 19:31:46', '2017-09-01 19:31:46'),
	(69, 1, 4, '1234', NULL, '2017-09-01 19:33:05', '2017-09-01 19:33:05'),
	(70, 1, 3, '32488352810', NULL, '2017-09-01 19:33:05', '2017-09-01 19:33:05'),
	(71, 1, 4, '1234', NULL, '2017-09-01 19:33:31', '2017-09-01 19:33:31'),
	(72, 1, 3, '32488352810', NULL, '2017-09-01 19:33:31', '2017-09-01 19:33:31'),
	(73, 1, 4, '1234', NULL, '2017-09-01 19:37:01', '2017-09-01 19:37:01'),
	(74, 1, 3, '32488352810', NULL, '2017-09-01 19:37:01', '2017-09-01 19:37:01'),
	(75, 1, 4, '1234', NULL, '2017-09-01 19:37:32', '2017-09-01 19:37:32'),
	(76, 1, 3, '32488352810', NULL, '2017-09-01 19:37:32', '2017-09-01 19:37:32'),
	(77, 1, 4, '1234', NULL, '2017-09-01 19:39:13', '2017-09-01 19:39:13'),
	(78, 1, 3, '32488352810', NULL, '2017-09-01 19:39:13', '2017-09-01 19:39:13'),
	(79, 1, 4, '1234', NULL, '2017-09-01 19:39:25', '2017-09-01 19:39:25'),
	(80, 1, 3, '32488352810', NULL, '2017-09-01 19:39:25', '2017-09-01 19:39:25'),
	(81, 1, 4, '1234', NULL, '2017-09-01 19:40:28', '2017-09-01 19:40:28'),
	(82, 1, 3, '32488352810', NULL, '2017-09-01 19:40:28', '2017-09-01 19:40:28'),
	(83, 1, 4, '1234', NULL, '2017-09-01 19:44:00', '2017-09-01 19:44:00'),
	(84, 1, 3, '32488352810', NULL, '2017-09-01 19:44:00', '2017-09-01 19:44:00'),
	(85, 27, 3, '78315368923', NULL, '2017-09-04 11:18:10', '2017-09-04 11:18:10'),
	(86, 27, 3, '78315368923', NULL, '2017-09-04 11:18:45', '2017-09-04 11:18:45'),
	(87, 27, 3, '78315368923', NULL, '2017-09-04 11:24:13', '2017-09-04 11:24:13'),
	(88, 27, 3, '78315368923', NULL, '2017-09-04 11:25:44', '2017-09-04 11:25:44'),
	(89, 27, 3, '78315368923', NULL, '2017-09-04 11:26:06', '2017-09-04 11:26:06'),
	(90, 27, 3, '78315368923', NULL, '2017-09-04 11:26:43', '2017-09-04 11:26:43'),
	(91, 27, 3, '78315368923', NULL, '2017-09-04 11:27:07', '2017-09-04 11:27:07'),
	(92, 27, 3, '78315368923', NULL, '2017-09-04 11:27:18', '2017-09-04 11:27:18'),
	(93, 27, 3, '78315368923', NULL, '2017-09-04 11:35:11', '2017-09-04 11:35:11'),
	(94, 27, 3, '78315368923', NULL, '2017-09-04 11:36:17', '2017-09-04 11:36:17'),
	(95, 27, 3, '78315368923', NULL, '2017-09-04 11:36:54', '2017-09-04 11:36:54'),
	(96, 27, 3, '78315368923', NULL, '2017-09-04 11:44:36', '2017-09-04 11:44:36'),
	(97, 27, 3, '78315368923', NULL, '2017-09-04 11:45:08', '2017-09-04 11:45:08'),
	(98, 27, 3, '78315368923', NULL, '2017-09-04 11:47:35', '2017-09-04 11:47:35'),
	(99, 27, 3, '78315368923', NULL, '2017-09-04 11:48:13', '2017-09-04 11:48:13'),
	(100, 27, 3, '78315368923', NULL, '2017-09-04 11:49:07', '2017-09-04 11:49:07'),
	(101, 27, 3, '78315368923', NULL, '2017-09-04 11:55:43', '2017-09-04 11:55:43'),
	(102, 27, 3, '78315368923', NULL, '2017-09-04 12:02:58', '2017-09-04 12:02:58'),
	(103, 27, 3, '78315368923', NULL, '2017-09-04 12:03:47', '2017-09-04 12:03:47'),
	(104, 27, 3, '78315368923', NULL, '2017-09-04 12:05:08', '2017-09-04 12:05:08'),
	(105, 27, 3, '78315368923', NULL, '2017-09-04 12:05:12', '2017-09-04 12:05:12'),
	(106, 27, 3, '78315368923', NULL, '2017-09-04 12:05:33', '2017-09-04 12:05:33'),
	(107, 27, 3, '78315368923', NULL, '2017-09-04 12:05:59', '2017-09-04 12:05:59'),
	(108, 27, 3, '78315368923', NULL, '2017-09-04 12:09:41', '2017-09-04 12:09:41'),
	(109, 27, 3, '78315368923', NULL, '2017-09-04 12:10:56', '2017-09-04 12:10:56'),
	(110, 27, 3, '78315368923', NULL, '2017-09-04 12:11:25', '2017-09-04 12:11:25'),
	(111, 27, 3, '78315368923', NULL, '2017-09-04 12:12:51', '2017-09-04 12:12:51'),
	(112, 27, 3, '78315368923', NULL, '2017-09-04 12:14:02', '2017-09-04 12:14:02'),
	(113, 27, 3, '78315368923', NULL, '2017-09-04 12:14:11', '2017-09-04 12:14:11'),
	(114, 27, 3, '78315368923', NULL, '2017-09-04 12:16:11', '2017-09-04 12:16:11'),
	(115, 27, 3, '78315368923', NULL, '2017-09-04 12:16:58', '2017-09-04 12:16:58'),
	(116, 27, 3, '78315368923', NULL, '2017-09-04 12:17:13', '2017-09-04 12:17:13'),
	(117, 27, 3, '78315368923', NULL, '2017-09-04 12:17:42', '2017-09-04 12:17:42'),
	(118, 28, 4, '0000', NULL, '2017-09-04 12:26:14', '2017-09-04 12:26:14'),
	(119, 28, 8, 'Fulano', NULL, '2017-09-04 12:26:14', '2017-09-04 12:26:14'),
	(120, 28, 4, '0000', NULL, '2017-09-04 12:27:22', '2017-09-04 12:27:22'),
	(121, 28, 8, 'Fulano', NULL, '2017-09-04 12:27:22', '2017-09-04 12:27:22'),
	(122, 28, 4, '0000', NULL, '2017-09-04 12:28:39', '2017-09-04 12:28:39'),
	(123, 28, 8, 'Fulano', NULL, '2017-09-04 12:28:39', '2017-09-04 12:28:39'),
	(124, 28, 4, '0000', NULL, '2017-09-04 12:38:05', '2017-09-04 12:38:05'),
	(125, 28, 8, 'Fulano', NULL, '2017-09-04 12:38:05', '2017-09-04 12:38:05'),
	(126, 28, 4, '0000', NULL, '2017-09-04 12:38:45', '2017-09-04 12:38:45'),
	(127, 28, 8, 'Fulano', NULL, '2017-09-04 12:38:45', '2017-09-04 12:38:45'),
	(128, 28, 4, '0000', NULL, '2017-09-04 12:40:15', '2017-09-04 12:40:15'),
	(129, 28, 8, 'Fulano', NULL, '2017-09-04 12:40:15', '2017-09-04 12:40:15'),
	(130, 28, 4, '0000', NULL, '2017-09-04 12:41:58', '2017-09-04 12:41:58'),
	(131, 28, 8, 'Carlão da padaria', NULL, '2017-09-04 12:41:58', '2017-09-04 12:41:58'),
	(132, 29, 4, '428569979', NULL, '2017-09-15 11:34:15', '2017-09-15 11:34:15'),
	(133, 1, 4, '123456', NULL, '2017-09-15 14:38:43', '2017-09-15 14:38:43'),
	(134, 30, 4, '4657896354', NULL, '2017-09-15 14:49:12', '2017-09-15 14:49:12'),
	(135, 30, 4, '', NULL, '2017-09-15 14:52:03', '2017-09-15 14:52:03'),
	(141, 24, 5, 'teste', NULL, '2017-09-15 18:16:27', '2017-09-15 18:16:27'),
	(145, 1, 5, '', NULL, '2017-09-15 18:24:48', '2017-09-15 18:24:48');
/*!40000 ALTER TABLE `pessoas_dados_gerais` ENABLE KEYS */;

-- Copiando dados para a tabela sge.programas: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `programas` DISABLE KEYS */;
INSERT INTO `programas` (`id`, `nome`, `sigla`) VALUES
	(1, 'Centro Esportivo', 'CE'),
	(2, 'Escola Municipal de Governo', 'EMG'),
	(3, 'Universidade Aberta do Brasil', 'UAB'),
	(4, 'Universidade Aberta da Terceira Idade', 'UATI'),
	(5, 'UniversidadeAberta do Trabalhador ', 'UNIT'),
	(6, 'Programa de Inclusão Digital', 'PID'),
	(7, 'TVE ', 'TVE');
/*!40000 ALTER TABLE `programas` ENABLE KEYS */;

-- Copiando dados para a tabela sge.recursos_sistema: ~11 rows (aproximadamente)
/*!40000 ALTER TABLE `recursos_sistema` DISABLE KEYS */;
INSERT INTO `recursos_sistema` (`id`, `nome`, `desc`, `link`) VALUES
	(1, 'cadastrar_pessoa', 'Cadastrar e alterar pessoas', '/pessoa/cadastrar'),
	(2, 'editar_dados_restritos', 'Alterar dados de pessoas restritas', '/pessoa/listar'),
	(3, 'editar_dados_alunos', 'Alterar dados de pessoas SEM relação Institucional', '/pessoa/listar'),
	(4, 'ver_alunos', 'Visualizar pefis de pessoas', '/pessoa/listar'),
	(5, 'ver_funcionarios', 'Visualizar os dados de pessoas com relação institucional', '/pessoa/listar'),
	(6, 'ver_privados', 'Visualizar os dados de pessoas privadas', '/pessoas/'),
	(7, 'editar_funcionarios', 'Alterar dados de pessoas COM relação Institucional', '/pessoas'),
	(8, 'cadastrar_usuarios', 'Criar acesso ao sistema para as pessoas', '/pessoa/$id/cadastrar-acesso'),
	(9, 'editar_login_alunos', 'Alterar senha dos alunos', '/secretaria/atender'),
	(10, 'editar_login_pri', 'Alterar  login de pessoas com relação institucional', '/admin/listarusuarios'),
	(11, 'editar_login_restritos', 'Alterar  login de pessoas restritas', '/admin/listarusuarios');
/*!40000 ALTER TABLE `recursos_sistema` ENABLE KEYS */;

-- Copiando dados para a tabela sge.requisitos: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `requisitos` DISABLE KEYS */;
INSERT INTO `requisitos` (`id`, `nome`) VALUES
	(18, 'Atestado médico'),
	(20, 'Ter entre 10 e 14 anos'),
	(21, 'Ter acima de 14 anos'),
	(22, 'Ter acima de 40 anos');
/*!40000 ALTER TABLE `requisitos` ENABLE KEYS */;

-- Copiando dados para a tabela sge.tipos_dados: ~19 rows (aproximadamente)
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
	(15, 'dependente_financeiro', 'geral', 'Dependente financeiro'),
	(16, 'relacao_institucional', 'administrativo', 'Relação Institucional'),
	(17, 'perfil_privado', 'geral', 'Perfil que só exibe dados para sí.'),
	(18, 'contratado_em', 'administrativo', 'Data de contratação'),
	(19, 'vencimento_contrato', 'administrativo', 'Vencimento do contrato');
/*!40000 ALTER TABLE `tipos_dados` ENABLE KEYS */;

-- Copiando dados para a tabela sge.turmas: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `turmas` DISABLE KEYS */;
INSERT INTO `turmas` (`id`, `programa`, `curso`, `disciplina`, `professor`, `local`, `dias_semana`, `data_inicio`, `data_termino`, `hora_inicio`, `hora_termino`, `valor`, `vagas`, `status`, `atributos`, `created_at`, `updated_at`) VALUES
	(1, 6, 4, NULL, 1, 1, 'seg,qua', '2017-10-09', '2017-11-29', '08:00:00', '10:00:00', 164.00000, 10, 3, NULL, '2017-10-09 13:26:31', '2017-10-11 12:04:08'),
	(2, 1, 6, NULL, 1, 6, 'seg', '2017-10-09', '2017-12-09', '08:00:00', '10:00:00', 300.00000, 42, 3, NULL, '2017-10-09 16:28:27', '2017-11-13 16:29:59'),
	(3, 4, 12, NULL, 1, 4, 'ter', '2017-10-09', '2017-10-09', '08:00:00', '10:00:00', 120.00000, 23, 4, 'D', '2017-10-09 16:48:59', '2017-11-13 16:31:29'),
	(4, 1, 6, NULL, 1, 6, 'seg', '2017-10-18', '2017-10-19', '13:00:00', '15:00:00', 600.00000, 42, 3, NULL, '2017-10-18 13:38:13', '2017-11-13 16:31:03'),
	(5, 6, 4, NULL, 1, 1, 'ter,qui', '2017-10-20', '2017-11-30', '13:00:00', '15:00:00', 120.00000, 29, 3, NULL, '2017-10-20 17:58:21', '2017-11-13 15:10:43');
/*!40000 ALTER TABLE `turmas` ENABLE KEYS */;

-- Copiando dados para a tabela sge.users: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
