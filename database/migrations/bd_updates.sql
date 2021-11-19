ALTER TABLE `matriculas`
	ADD COLUMN `pacote` INT UNSIGNED NULL AFTER `atendimento`;
	
ALTER TABLE `valores`
	ADD COLUMN `pacote` INT UNSIGNED NULL AFTER `id`;

ALTER TABLE `turma_dados`
	CHANGE COLUMN `dado` `dado` ENUM('professor_extra','proxima_turma','flag','ead','automatricula','pacote') NOT NULL AFTER `turma`;

ALTER TABLE `turmas`
	ADD COLUMN `status_matriculas` ENUM('aberta','fechada','rematricula','presencial','online') NULL DEFAULT 'fechada' AFTER `status`;

update turmas
	SET status_matriculas = 'aberta'
	WHERE status IN ('iniciada','inscricao');

update turmas
	SET status = 'lancada'
	WHERE status IN ('espera','inscricao');

update turmas
	set STATUS  = 'iniciada'
	where status in ('andamento');

ALTER TABLE `turmas`
	CHANGE COLUMN `status` `status` ENUM('lancada','iniciada','encerrada','cancelada') NULL DEFAULT 'lancada' AFTER `matriculados`;

ALTER TABLE `logs`
	CHANGE COLUMN `tipo` `tipo` ENUM('boleto','matricula','inscricao','bolsa','aula','turma','atestado') NOT NULL AFTER `id`;
ALTER TABLE `atestados`
	ADD COLUMN `tipo` ENUM('medico','saude','vacinacao') NULL DEFAULT 'saude' AFTER `id`,
	ADD COLUMN `status` ENUM('aprovado','recusado','analisando','vencido') NULL DEFAULT 'avaliando' AFTER `validade`;

update atestados
	set status = 'vencido'
	where id > 0;

