UPDATE `scc`.`Processo` SET `tipo` = 'Sindicancia' WHERE `tipo` = 'Sindicância';
UPDATE `scc`.`Processo` SET `tipo` = 'Processo de averiguacao' WHERE `tipo` = 'Processo de averiguação';
ALTER TABLE `scc`.`Usuario` 
CHANGE COLUMN `senha` `senha` VARCHAR(250) NULL DEFAULT NULL ;
ALTER TABLE `scc`.`Usuario` 
ADD UNIQUE INDEX `login_UNIQUE` (`login` ASC);

