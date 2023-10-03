CREATE TABLE IF NOT EXISTS `scc`.`Sped` (
  `idSped` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(1150) NULL,
  `prazo` DATE NULL,
  `data` DATE NULL,
  `resolvido` TINYINT(1) NULL DEFAULT 0,
  `responsavel` VARCHAR(250) NULL,
  PRIMARY KEY (`idSped`))
ENGINE = InnoDB;
