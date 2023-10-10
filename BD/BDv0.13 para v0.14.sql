CREATE TABLE `scc`.`Veiculo` (
  `idVeiculo` INT NOT NULL AUTO_INCREMENT,
  `tipoVeiculo` VARCHAR(50) NULL,
  `placa` VARCHAR(10) NULL,
  `modelo` VARCHAR(50) NULL,
  `cor` VARCHAR(50) NULL,
  `nomeCompleto` VARCHAR(80) NULL,
  `identidade` VARCHAR(50) NULL,
  `destino` VARCHAR(70) NULL,
  `dataEntrada` DATETIME NULL,
  `dataSaida` DATETIME NULL,
  PRIMARY KEY (`idVeiculo`));
