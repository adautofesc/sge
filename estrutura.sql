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

-- Copiando estrutura para tabela sge.atendimentos
CREATE TABLE IF NOT EXISTS `atendimentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `atendente` int(10) unsigned NOT NULL,
  `usuario` int(10) unsigned NOT NULL,
  `descricao` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `atendimentos_atendente_foreign` (`atendente`),
  KEY `atendimentos_usuario_foreign` (`usuario`),
  CONSTRAINT `atendimentos_atendente_foreign` FOREIGN KEY (`atendente`) REFERENCES `pessoas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `atendimentos_usuario_foreign` FOREIGN KEY (`usuario`) REFERENCES `pessoas` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.bairros_sanca
CREATE TABLE IF NOT EXISTS `bairros_sanca` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.classes
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `matricula` int(10) unsigned NOT NULL,
  `turma` int(10) unsigned NOT NULL,
  `status` enum('Regular','Evadido','Nunca Frequentou','Aprovado','Retido','Suspenso','Expulso') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Regular',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classes_matricula_foreign` (`matricula`),
  KEY `classes_turma_foreign` (`turma`),
  CONSTRAINT `classes_matricula_foreign` FOREIGN KEY (`matricula`) REFERENCES `matriculas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `classes_turma_foreign` FOREIGN KEY (`turma`) REFERENCES `turmas` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.cursos
CREATE TABLE IF NOT EXISTS `cursos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `programa` int(10) unsigned NOT NULL,
  `desc` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vagas` int(10) unsigned DEFAULT NULL,
  `carga` int(10) unsigned DEFAULT NULL,
  `valor` decimal(5,2) DEFAULT NULL,
  `periodicidade` enum('mensal','bimestral','trimestral','semestral','anual','eventual','ND') COLLATE utf8mb4_unicode_ci DEFAULT 'ND',
  `modulos` tinyint(2) unsigned DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1432 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.cursos_requisitos
CREATE TABLE IF NOT EXISTS `cursos_requisitos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `para_tipo` enum('curso','disciplina') COLLATE utf8mb4_unicode_ci DEFAULT 'curso',
  `curso` int(10) unsigned NOT NULL,
  `requisito` int(10) unsigned NOT NULL,
  `obrigatorio` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cursos_requisitos_requisito_foreign` (`requisito`),
  CONSTRAINT `cursos_requisitos_requisito_foreign` FOREIGN KEY (`requisito`) REFERENCES `requisitos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.descontos
CREATE TABLE IF NOT EXISTS `descontos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL DEFAULT '0',
  `descricao` varchar(120) DEFAULT '0',
  `tipo` varchar(1) NOT NULL DEFAULT '0',
  `valor` decimal(10,0) NOT NULL DEFAULT '0',
  `validade` date NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.disciplinas
CREATE TABLE IF NOT EXISTS `disciplinas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `programa` int(10) unsigned DEFAULT NULL,
  `desc` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vagas` int(10) unsigned DEFAULT NULL,
  `carga` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=631 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.documentos
CREATE TABLE IF NOT EXISTS `documentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_documento` enum('Termo de matrícula','Contrato','Cessão de Imagem','Atestado de matrícula') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_objeto` enum('Aluno','Turma','Curso','Programa','Parceria','Global') COLLATE utf8mb4_unicode_ci NOT NULL,
  `objeto` int(10) unsigned DEFAULT NULL,
  `conteudo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
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
  `bairro_str` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `enderecos_bairro_foreign` (`bairro`),
  KEY `enderecos_atualizado_por_foreign` (`atualizado_por`),
  CONSTRAINT `enderecos_atualizado_por_foreign` FOREIGN KEY (`atualizado_por`) REFERENCES `pessoas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `enderecos_bairro_foreign` FOREIGN KEY (`bairro`) REFERENCES `bairros_sanca` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28427 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.grades
CREATE TABLE IF NOT EXISTS `grades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `curso` int(10) unsigned NOT NULL,
  `disciplina` int(10) unsigned NOT NULL,
  `obrigatoria` tinyint(1) unsigned DEFAULT NULL,
  `modulo` tinyint(2) unsigned DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `grades_curso_foreign` (`curso`),
  KEY `grades_disciplina_foreign` (`disciplina`),
  CONSTRAINT `grades_curso_foreign` FOREIGN KEY (`curso`) REFERENCES `cursos` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `grades_disciplina_foreign` FOREIGN KEY (`disciplina`) REFERENCES `disciplinas` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.locais
CREATE TABLE IF NOT EXISTS `locais` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sala` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unidade` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacidade` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.matriculas
CREATE TABLE IF NOT EXISTS `matriculas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `atendimento` int(10) unsigned NOT NULL,
  `status` enum('pendente','regular','evadido','nf','finalizado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'regular',
  `dia_venc` int(10) unsigned NOT NULL,
  `forma_pgto` enum('boleto','debito','credito','caixa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'boleto',
  `parcelas` tinyint(1) unsigned NOT NULL,
  `resp_financeiro` int(10) unsigned DEFAULT NULL,
  `contrato` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `turma` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `matriculas_pessoa_foreign` (`pessoa`),
  KEY `matriculas_resp_financeiro_foreign` (`resp_financeiro`),
  KEY `matriculas_atendimento_foreign` (`atendimento`),
  KEY `matriculas_turma_foreign` (`turma`),
  CONSTRAINT `matriculas_atendimento_foreign` FOREIGN KEY (`atendimento`) REFERENCES `atendimentos` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `matriculas_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `matriculas_resp_financeiro_foreign` FOREIGN KEY (`resp_financeiro`) REFERENCES `pessoas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `matriculas_turma_foreign` FOREIGN KEY (`turma`) REFERENCES `turmas` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.parcerias
CREATE TABLE IF NOT EXISTS `parcerias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `sigla` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.pessoas
CREATE TABLE IF NOT EXISTS `pessoas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nascimento` date NOT NULL,
  `por` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_por_foreign` (`por`),
  CONSTRAINT `pessoas_por_foreign` FOREIGN KEY (`por`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30739 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.pessoas_controle_acessos
CREATE TABLE IF NOT EXISTS `pessoas_controle_acessos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `recurso` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_controle_acessos_pessoa_foreign` (`pessoa`),
  KEY `pessoas_controle_acessos_recurso_foreign` (`recurso`),
  CONSTRAINT `pessoas_controle_acessos_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pessoas_controle_acessos_recurso_foreign` FOREIGN KEY (`recurso`) REFERENCES `recursos_sistema` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.pessoas_dados_academicos
CREATE TABLE IF NOT EXISTS `pessoas_dados_academicos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `dado` int(10) unsigned NOT NULL,
  `valor` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_dados_academicos_pessoa_foreign` (`pessoa`),
  KEY `pessoas_dados_academicos_dado_foreign` (`dado`),
  CONSTRAINT `pessoas_dados_academicos_dado_foreign` FOREIGN KEY (`dado`) REFERENCES `tipos_dados` (`id`),
  CONSTRAINT `pessoas_dados_academicos_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.pessoas_dados_acesso
CREATE TABLE IF NOT EXISTS `pessoas_dados_acesso` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `usuario` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validade` date NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pessoas_dados_acesso_usuario_unique` (`usuario`),
  KEY `pessoas_dados_acesso_pessoa_foreign` (`pessoa`),
  CONSTRAINT `pessoas_dados_acesso_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.pessoas_dados_administrativos
CREATE TABLE IF NOT EXISTS `pessoas_dados_administrativos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `dado` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `valor` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ativo` enum('S','N') COLLATE utf8mb4_unicode_ci DEFAULT 'S',
  PRIMARY KEY (`id`),
  KEY `pessoas_dados_administrativos_pessoa_foreign` (`pessoa`),
  KEY `pessoas_dados_administrativos_dado_foreign` (`dado`),
  CONSTRAINT `pessoas_dados_administrativos_dado_foreign` FOREIGN KEY (`dado`) REFERENCES `tipos_dados` (`id`),
  CONSTRAINT `pessoas_dados_administrativos_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.pessoas_dados_clinicos
CREATE TABLE IF NOT EXISTS `pessoas_dados_clinicos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `dado` int(10) unsigned NOT NULL,
  `valor` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_dados_clinicos_pessoa_foreign` (`pessoa`),
  KEY `pessoas_dados_clinicos_dado_foreign` (`dado`),
  CONSTRAINT `pessoas_dados_clinicos_dado_foreign` FOREIGN KEY (`dado`) REFERENCES `tipos_dados` (`id`),
  CONSTRAINT `pessoas_dados_clinicos_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.pessoas_dados_contato
CREATE TABLE IF NOT EXISTS `pessoas_dados_contato` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `dado` int(10) unsigned NOT NULL,
  `valor` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_dados_contato_pessoa_foreign` (`pessoa`),
  KEY `pessoas_dados_contato_dado_foreign` (`dado`),
  CONSTRAINT `pessoas_dados_contato_dado_foreign` FOREIGN KEY (`dado`) REFERENCES `tipos_dados` (`id`),
  CONSTRAINT `pessoas_dados_contato_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71511 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.pessoas_dados_financeiros
CREATE TABLE IF NOT EXISTS `pessoas_dados_financeiros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `dado` int(10) unsigned NOT NULL,
  `valor` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_dados_financeiros_pessoa_foreign` (`pessoa`),
  KEY `pessoas_dados_financeiros_dado_foreign` (`dado`),
  CONSTRAINT `pessoas_dados_financeiros_dado_foreign` FOREIGN KEY (`dado`) REFERENCES `tipos_dados` (`id`),
  CONSTRAINT `pessoas_dados_financeiros_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.pessoas_dados_gerais
CREATE TABLE IF NOT EXISTS `pessoas_dados_gerais` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pessoa` int(10) unsigned NOT NULL,
  `dado` int(10) unsigned NOT NULL,
  `valor` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pessoas_dados_gerais_pessoa_foreign` (`pessoa`),
  KEY `pessoas_dados_gerais_dado_foreign` (`dado`),
  CONSTRAINT `pessoas_dados_gerais_dado_foreign` FOREIGN KEY (`dado`) REFERENCES `tipos_dados` (`id`),
  CONSTRAINT `pessoas_dados_gerais_pessoa_foreign` FOREIGN KEY (`pessoa`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48422 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.programas
CREATE TABLE IF NOT EXISTS `programas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sigla` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.recursos_sistema
CREATE TABLE IF NOT EXISTS `recursos_sistema` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.requisitos
CREATE TABLE IF NOT EXISTS `requisitos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.tb_alunos
CREATE TABLE IF NOT EXISTS `tb_alunos` (
  `AluCod` int(11) NOT NULL,
  `AluDatCad` datetime(6) DEFAULT NULL,
  `AluFlgAti` tinyint(1) NOT NULL,
  `AluNom` varchar(37) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluSex` varchar(1) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluCpf` varchar(14) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluRG` varchar(14) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluDatNas` datetime(6) DEFAULT NULL,
  `ECICod` int(11) DEFAULT NULL,
  `AluEma` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluDdd1` varchar(5) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluFon1` varchar(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluDdd2` varchar(5) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluFon2` varchar(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluDddRec` varchar(2) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluFonRec` varchar(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluConRec` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `EmpCod` int(11) DEFAULT NULL,
  `AluPro` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluFlgFunP` tinyint(1) DEFAULT NULL,
  `SecCod` int(11) DEFAULT NULL,
  `AluDep` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluDiv` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluOut` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluObs` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluNomCra` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluTamCam` varchar(5) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluFot` varchar(80) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluSen` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluExaMed` tinyint(1) DEFAULT NULL,
  `AluDatValEM` datetime(6) DEFAULT NULL,
  `AluEnd` varchar(40) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluBai` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AluCep` varchar(8) CHARACTER SET utf8mb4 DEFAULT NULL,
  `MunCodRes` int(11) DEFAULT NULL,
  `UsuCodIns` int(11) DEFAULT NULL,
  `UsuDatIns` datetime(6) DEFAULT NULL,
  `UsuCodUpd` int(11) DEFAULT NULL,
  `UsuDatUpd` datetime(6) DEFAULT NULL,
  `RacCod` int(11) DEFAULT NULL,
  `AluFlgEmp` tinyint(1) DEFAULT NULL,
  `AluNomOri` varchar(37) CHARACTER SET utf8mb4 DEFAULT NULL,
  `NumPMSC` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `DoeAut` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `DoeQue` varchar(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `DoeMed` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL,
  `DoeDia` tinyint(1) DEFAULT NULL,
  `DoePre` tinyint(1) DEFAULT NULL,
  `DoePla` tinyint(1) DEFAULT NULL,
  `DoePlaQua` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `RecNom` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `RecGra` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `RecTel` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.tb_alunos_end
CREATE TABLE IF NOT EXISTS `tb_alunos_end` (
  `ALECod` int(11) NOT NULL,
  `AluCod` int(11) DEFAULT NULL,
  `ALETip` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL,
  `ALEEnd` varchar(40) CHARACTER SET utf8mb4 DEFAULT NULL,
  `ALEBai` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL,
  `ALECep` varchar(8) CHARACTER SET utf8mb4 DEFAULT NULL,
  `MunCod` int(11) DEFAULT NULL,
  `UsuCodIns` int(11) DEFAULT NULL,
  `UsuDatIns` datetime(6) DEFAULT NULL,
  `UsuCodUpd` int(11) DEFAULT NULL,
  `UsuDatUpd` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.tb_aulas
CREATE TABLE IF NOT EXISTS `tb_aulas` (
  `AulCod` int(11) NOT NULL,
  `AulDsc` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AulVlr` decimal(19,4) DEFAULT NULL,
  `AulTip` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AulFlgAti` tinyint(1) NOT NULL,
  `UsuCodIns` int(11) DEFAULT NULL,
  `UsuDatIns` datetime(6) DEFAULT NULL,
  `UsuCodUpd` int(11) DEFAULT NULL,
  `UsuDatUpd` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.tb_cursos
CREATE TABLE IF NOT EXISTS `tb_cursos` (
  `CurCod` int(11) NOT NULL,
  `CurDsc` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `CurFlgAti` tinyint(1) NOT NULL,
  `UsuCodIns` int(11) DEFAULT NULL,
  `UsuDatIns` datetime(6) DEFAULT NULL,
  `UsuCodUpd` int(11) DEFAULT NULL,
  `UsuDatUpd` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.tb_localizacoes
CREATE TABLE IF NOT EXISTS `tb_localizacoes` (
  `LocCod` int(11) NOT NULL,
  `LocDsc` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `LocEnd` varchar(37) CHARACTER SET utf8mb4 DEFAULT NULL,
  `LocBai` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL,
  `MunCod` int(11) DEFAULT NULL,
  `LocCep` varchar(8) CHARACTER SET utf8mb4 DEFAULT NULL,
  `LocFlgAti` tinyint(1) DEFAULT NULL,
  `LocSig` varchar(15) CHARACTER SET utf8mb4 DEFAULT NULL,
  `LocDscRes` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `UsuCodIns` int(11) DEFAULT NULL,
  `UsuDatIns` datetime(6) DEFAULT NULL,
  `UsuCodUpd` int(11) DEFAULT NULL,
  `UsuDatUpd` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.tb_matriculas
CREATE TABLE IF NOT EXISTS `tb_matriculas` (
  `MatCod` int(11) NOT NULL,
  `TurCod` int(11) NOT NULL,
  `AluCod` int(11) NOT NULL,
  `MatDat` datetime(6) DEFAULT NULL,
  `MDDCod` int(11) DEFAULT NULL,
  `MatVlrDes` decimal(19,4) DEFAULT NULL,
  `MatVlrPag` decimal(19,4) DEFAULT NULL,
  `SitCod` int(11) DEFAULT NULL,
  `ALECod` int(11) DEFAULT NULL,
  `MatDatSit` datetime(6) DEFAULT NULL,
  `MatNumRec` varchar(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `MatResNom` varchar(37) CHARACTER SET utf8mb4 DEFAULT NULL,
  `MatResCpf` varchar(14) CHARACTER SET utf8mb4 DEFAULT NULL,
  `MatDatNasR` datetime(6) DEFAULT NULL,
  `PRTCod` int(11) DEFAULT NULL,
  `UsuCod` int(11) DEFAULT NULL,
  `MatFlgAti` tinyint(1) NOT NULL,
  `MDCCod` int(11) DEFAULT NULL,
  `MatFlgEstRec` tinyint(1) DEFAULT NULL,
  `MatDatCan` datetime(6) DEFAULT NULL,
  `MatMotCan` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `UsuCodIns` int(11) DEFAULT NULL,
  `UsuDatIns` datetime(6) DEFAULT NULL,
  `UsuCodUpd` int(11) DEFAULT NULL,
  `UsuDatUpd` datetime(6) DEFAULT NULL,
  `TurCodOld` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.tb_matriculas_aulas
CREATE TABLE IF NOT EXISTS `tb_matriculas_aulas` (
  `MatCod` int(11) NOT NULL,
  `AulCod` int(11) NOT NULL,
  `MaaFlgAti` tinyint(1) DEFAULT NULL,
  `AulCodOld` int(11) DEFAULT NULL,
  `ChangedOn` datetime(6) DEFAULT NULL,
  `ChangedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.tb_parcerias
CREATE TABLE IF NOT EXISTS `tb_parcerias` (
  `PrcCod` int(11) NOT NULL,
  `PrcDsc` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `PrcFlgAti` tinyint(1) NOT NULL,
  `UsuCodIns` int(11) DEFAULT NULL,
  `UsuDatIns` datetime(6) DEFAULT NULL,
  `UsuCodUpd` int(11) DEFAULT NULL,
  `UsuDatUpd` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.tb_turmas
CREATE TABLE IF NOT EXISTS `tb_turmas` (
  `TurCod` int(11) NOT NULL,
  `TPTCod` int(11) DEFAULT NULL,
  `PRMCod` int(11) DEFAULT NULL,
  `TPCCod` int(11) DEFAULT NULL,
  `CurCod` int(11) DEFAULT NULL,
  `TurDsc` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `LocCod` int(11) DEFAULT NULL,
  `TurVag` int(11) DEFAULT NULL,
  `TurVagRes` int(11) DEFAULT NULL,
  `PerCod` int(11) DEFAULT NULL,
  `TurDatIni` datetime(6) DEFAULT NULL,
  `TurDatFin` datetime(6) DEFAULT NULL,
  `TurAnoLet` varchar(4) CHARACTER SET utf8mb4 DEFAULT NULL,
  `TurCarHor` int(11) DEFAULT NULL,
  `TurVlr` decimal(19,4) DEFAULT NULL,
  `TurVlrMat` decimal(19,4) DEFAULT NULL,
  `CPACod` int(11) DEFAULT NULL,
  `TurDatMen1` datetime(6) DEFAULT NULL,
  `TurFlgWeb` tinyint(1) NOT NULL,
  `PrcCod` int(11) DEFAULT NULL,
  `TurFlgDes` tinyint(1) DEFAULT NULL,
  `TurNumDis` int(11) DEFAULT NULL,
  `TurVlrDes` decimal(19,4) DEFAULT NULL,
  `TurFlgAti` tinyint(1) DEFAULT NULL,
  `UsuCodIns` int(11) DEFAULT NULL,
  `UsuDatIns` datetime(6) DEFAULT NULL,
  `UsuCodUpd` int(11) DEFAULT NULL,
  `UsuDatUpd` datetime(6) DEFAULT NULL,
  `ProCod` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.tb_turmas_log
CREATE TABLE IF NOT EXISTS `tb_turmas_log` (
  `TurCod` int(11) NOT NULL,
  `TPTCod` int(11) DEFAULT NULL,
  `PRMCod` int(11) DEFAULT NULL,
  `TPCCod` int(11) DEFAULT NULL,
  `CurCod` int(11) DEFAULT NULL,
  `TurDsc` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `LocCod` int(11) DEFAULT NULL,
  `TurVag` int(11) DEFAULT NULL,
  `TurVagRes` int(11) DEFAULT NULL,
  `PerCod` int(11) DEFAULT NULL,
  `TurDatIni` datetime(6) DEFAULT NULL,
  `TurDatFin` datetime(6) DEFAULT NULL,
  `TurAnoLet` varchar(4) CHARACTER SET utf8mb4 DEFAULT NULL,
  `TurCarHor` int(11) DEFAULT NULL,
  `TurVlr` decimal(19,4) DEFAULT NULL,
  `TurVlrMat` decimal(19,4) DEFAULT NULL,
  `CPACod` int(11) DEFAULT NULL,
  `TurDatMen1` datetime(6) DEFAULT NULL,
  `TurFlgWeb` tinyint(1) NOT NULL,
  `PrcCod` int(11) DEFAULT NULL,
  `TurFlgDes` tinyint(1) DEFAULT NULL,
  `TurNumDis` int(11) DEFAULT NULL,
  `TurVlrDes` decimal(19,4) DEFAULT NULL,
  `TurFlgAti` tinyint(1) DEFAULT NULL,
  `UsuCodIns` int(11) DEFAULT NULL,
  `UsuDatIns` datetime(6) DEFAULT NULL,
  `UsuCodUpd` int(11) DEFAULT NULL,
  `UsuDatUpd` datetime(6) DEFAULT NULL,
  `Deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.tipos_dados
CREATE TABLE IF NOT EXISTS `tipos_dados` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela sge.turmas
CREATE TABLE IF NOT EXISTS `turmas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `programa` int(10) unsigned NOT NULL,
  `curso` int(10) unsigned NOT NULL,
  `disciplina` int(10) unsigned DEFAULT NULL,
  `professor` int(10) unsigned NOT NULL,
  `local` int(10) unsigned NOT NULL,
  `dias_semana` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_inicio` date NOT NULL,
  `data_termino` date DEFAULT NULL,
  `hora_inicio` time NOT NULL,
  `hora_termino` time NOT NULL,
  `valor` decimal(10,5) NOT NULL,
  `vagas` int(10) unsigned NOT NULL,
  `status` tinyint(4) unsigned DEFAULT NULL,
  `atributos` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `periodicidade` enum('mensal','bimestral','trimestral','semestral','anual','eventual','ND') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modulo` tinyint(2) unsigned DEFAULT '1',
  `parceria` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `turmas_programa_foreign` (`programa`),
  KEY `turmas_curso_foreign` (`curso`),
  KEY `turmas_disciplina_foreign` (`disciplina`),
  KEY `turmas_professor_foreign` (`professor`),
  KEY `turmas_local_foreign` (`local`),
  CONSTRAINT `turmas_curso_foreign` FOREIGN KEY (`curso`) REFERENCES `cursos` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `turmas_disciplina_foreign` FOREIGN KEY (`disciplina`) REFERENCES `disciplinas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `turmas_local_foreign` FOREIGN KEY (`local`) REFERENCES `locais` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `turmas_professor_foreign` FOREIGN KEY (`professor`) REFERENCES `pessoas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `turmas_programa_foreign` FOREIGN KEY (`programa`) REFERENCES `programas` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.
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

-- Exportação de dados foi desmarcado.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
