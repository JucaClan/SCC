-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA `scc`;
CREATE SCHEMA IF NOT EXISTS `scc` ;
USE `scc` ;

-- -----------------------------------------------------
-- Table `scc`.`Posto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Posto` ;

CREATE TABLE IF NOT EXISTS `scc`.`Posto` (
  `idPosto` INT NOT NULL AUTO_INCREMENT,
  `posto` VARCHAR(70) NULL,
  PRIMARY KEY (`idPosto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Usuario` ;

CREATE TABLE IF NOT EXISTS `scc`.`Usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(70) NOT NULL,
  `senha` VARCHAR(70) NULL,
  `status` TINYINT NULL,
  `nome` VARCHAR(70) NULL,
  `Posto_idPosto` INT NULL,
  PRIMARY KEY (`idUsuario`),
  INDEX `fk_Usuario_Posto1_idx` (`Posto_idPosto` ASC),
  CONSTRAINT `fk_Usuario_Posto1`
    FOREIGN KEY (`Posto_idPosto`)
    REFERENCES `scc`.`Posto` (`idPosto`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Secao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Secao` ;

CREATE TABLE IF NOT EXISTS `scc`.`Secao` (
  `idSecao` INT NOT NULL AUTO_INCREMENT,
  `secao` VARCHAR(70) NOT NULL,
  `dataAtualizacao` DATETIME NULL,
  `mensagem` VARCHAR(700) NULL,
  PRIMARY KEY (`idSecao`),
  UNIQUE INDEX `secao_UNIQUE` (`secao` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Usuario_has_Secao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Usuario_has_Secao` ;

CREATE TABLE IF NOT EXISTS `scc`.`Usuario_has_Secao` (
  `Usuario_idUsuario` INT NOT NULL,
  `Secao_idSecao` INT NOT NULL,
  PRIMARY KEY (`Usuario_idUsuario`, `Secao_idSecao`),
  INDEX `fk_Usuario_has_Secao_Secao1_idx` (`Secao_idSecao` ASC),
  INDEX `fk_Usuario_has_Secao_Usuario_idx` (`Usuario_idUsuario` ASC),
  CONSTRAINT `fk_Usuario_has_Secao_Usuario`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `scc`.`Usuario` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Usuario_has_Secao_Secao1`
    FOREIGN KEY (`Secao_idSecao`)
    REFERENCES `scc`.`Secao` (`idSecao`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Processo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Processo` ;

CREATE TABLE IF NOT EXISTS `scc`.`Processo` (
  `idProcesso` INT NOT NULL AUTO_INCREMENT,
  `portaria` VARCHAR(250) NOT NULL,
  `responsavel` VARCHAR(70) NULL,
  `solucao` VARCHAR(250) NULL,
  `dataInicio` DATE NULL,
  `dataFim` DATE NULL,
  `tipo` VARCHAR(70) NULL,
  `assunto` VARCHAR(70) NULL,
  `prorrogacao` VARCHAR(125) NULL,
  `prorrogacaoPrazo` DATE NULL,
  `dataPrazo` DATE NULL,
  PRIMARY KEY (`idProcesso`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Combustivel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Combustivel` ;

CREATE TABLE IF NOT EXISTS `scc`.`Combustivel` (
  `ctc01-celula1` VARCHAR(70) NULL,
  `ctc01-celula2` VARCHAR(70) NULL,
  `ctc01-celula3` VARCHAR(70) NULL,
  `ctc01-celula1-valor` DECIMAL(10,1) NULL DEFAULT 0.0,
  `ctc01-celula2-valor` DECIMAL(10,1) NULL DEFAULT 0.0,
  `ctc01-celula3-valor` DECIMAL(10,1) NULL DEFAULT 0.0,
  `ctc04-celula1` VARCHAR(70) NULL,
  `ctc04-celula2` VARCHAR(70) NULL,
  `ctc04-celula3` VARCHAR(70) NULL,
  `ctc04-celula1-valor` DECIMAL(10,1) NULL DEFAULT 0.0,
  `ctc04-celula2-valor` DECIMAL(10,1) NULL DEFAULT 0.0,
  `ctc04-celula3-valor` DECIMAL(10,1) NULL DEFAULT 0.0,
  `diesel` DECIMAL(10,1) NULL DEFAULT 0.0,
  `gasolina` DECIMAL(10,1) NULL DEFAULT 0.0)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Situacao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Situacao` ;

CREATE TABLE IF NOT EXISTS `scc`.`Situacao` (
  `idSituacao` INT NOT NULL AUTO_INCREMENT,
  `situacao` VARCHAR(70) NULL,
  PRIMARY KEY (`idSituacao`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Classe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Classe` ;

CREATE TABLE IF NOT EXISTS `scc`.`Classe` (
  `idClasse` INT NOT NULL AUTO_INCREMENT,
  `classe` VARCHAR(70) NULL,
  PRIMARY KEY (`idClasse`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Material`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Material` ;

CREATE TABLE IF NOT EXISTS `scc`.`Material` (
  `idMaterial` INT NOT NULL AUTO_INCREMENT,
  `item` VARCHAR(250) NULL,
  `marca` VARCHAR(70) NULL,
  `modelo` VARCHAR(70) NULL,
  `ano` VARCHAR(14) NULL,
  `motivo` VARCHAR(70) NULL,
  `local` VARCHAR(125) NULL,
  `motivoDetalhado` VARCHAR(700) NULL,
  `Situacao_idSituacao` INT NULL,
  `Classe_idClasse` INT NULL,
  `secaoResponsavel` VARCHAR(25) NULL,
  PRIMARY KEY (`idMaterial`),
  INDEX `fk_Material_Situacao1_idx` (`Situacao_idSituacao` ASC),
  INDEX `fk_Material_Classe1_idx` (`Classe_idClasse` ASC),
  CONSTRAINT `fk_Material_Situacao1`
    FOREIGN KEY (`Situacao_idSituacao`)
    REFERENCES `scc`.`Situacao` (`idSituacao`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Material_Classe1`
    FOREIGN KEY (`Classe_idClasse`)
    REFERENCES `scc`.`Classe` (`idClasse`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Baixado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Baixado` ;

CREATE TABLE IF NOT EXISTS `scc`.`Baixado` (
  `idBaixado` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(125) NULL,
  `situacao` VARCHAR(70) NULL,
  `turma` INT NULL,
  `cia` VARCHAR(25) NULL,
  `amparo` VARCHAR(70) NULL,
  `dataAtualizacao` DATE NULL,
  `Posto_idPosto` INT NULL,
  `diagnostico` VARCHAR(520) NULL,
  `bi` VARCHAR(520) NULL,
  `bar` VARCHAR(520) NULL,
  `dispensa` VARCHAR(250) NULL,
  `acao` VARCHAR(250) NULL,
  PRIMARY KEY (`idBaixado`),
  INDEX `fk_Baixado_Posto1_idx` (`Posto_idPosto` ASC),
  CONSTRAINT `fk_Baixado_Posto1`
    FOREIGN KEY (`Posto_idPosto`)
    REFERENCES `scc`.`Posto` (`idPosto`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`MapaDaForca`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`MapaDaForca` ;

CREATE TABLE IF NOT EXISTS `scc`.`MapaDaForca` (
  `cel_previsto` SMALLINT NULL DEFAULT 0,
  `tc_previsto` SMALLINT NULL DEFAULT 0,
  `maj_previsto` SMALLINT NULL DEFAULT 0,
  `cap_previsto` SMALLINT NULL DEFAULT 0,
  `1ten_previsto` SMALLINT NULL DEFAULT 0,
  `2ten_previsto` SMALLINT NULL DEFAULT 0,
  `aspof_previsto` SMALLINT NULL DEFAULT 0,
  `cel_existente` SMALLINT NULL DEFAULT 0,
  `tc_existente` SMALLINT NULL DEFAULT 0,
  `maj_existente` SMALLINT NULL DEFAULT 0,
  `cap_existente` SMALLINT NULL DEFAULT 0,
  `1ten_existente` SMALLINT NULL DEFAULT 0,
  `2ten_existente` SMALLINT NULL DEFAULT 0,
  `aspof_existente` SMALLINT NULL DEFAULT 0,
  `sten_previsto` SMALLINT NULL DEFAULT 0,
  `1sgt_previsto` SMALLINT NULL DEFAULT 0,
  `2sgt_previsto` SMALLINT NULL DEFAULT 0,
  `3sgt_previsto` SMALLINT NULL DEFAULT 0,
  `cb_previsto` SMALLINT NULL DEFAULT 0,
  `cbev_previsto` SMALLINT NULL DEFAULT 0,
  `sdep_previsto` SMALLINT NULL DEFAULT 0,
  `sdev_previsto` SMALLINT NULL DEFAULT 0,
  `sten_existente` SMALLINT NULL DEFAULT 0,
  `1sgt_existente` SMALLINT NULL DEFAULT 0,
  `2sgt_existente` SMALLINT NULL DEFAULT 0,
  `3sgt_existente` SMALLINT NULL DEFAULT 0,
  `cb_existente` SMALLINT NULL DEFAULT 0,
  `cbev_existente` SMALLINT NULL DEFAULT 0,
  `sdep_existente` SMALLINT NULL DEFAULT 0,
  `sdev_existente` SMALLINT NULL DEFAULT 0,
  `cel_adido` SMALLINT NULL DEFAULT 0,
  `tc_adido` SMALLINT NULL DEFAULT 0,
  `maj_adido` SMALLINT NULL DEFAULT 0,
  `cap_adido` SMALLINT NULL DEFAULT 0,
  `1ten_adido` SMALLINT NULL DEFAULT 0,
  `2ten_adido` SMALLINT NULL DEFAULT 0,
  `aspof_adido` SMALLINT NULL DEFAULT 0,
  `sten_adido` SMALLINT NULL DEFAULT 0,
  `1sgt_adido` SMALLINT NULL DEFAULT 0,
  `2sgt_adido` SMALLINT NULL DEFAULT 0,
  `3sgt_adido` SMALLINT NULL DEFAULT 0,
  `cb_adido` SMALLINT NULL DEFAULT 0,
  `cbev_adido` SMALLINT NULL DEFAULT 0,
  `sdep_adido` SMALLINT NULL DEFAULT 0,
  `sdev_adido` SMALLINT NULL DEFAULT 0,
  `cel_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `tc_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `maj_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `cap_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `1ten_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `2ten_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `aspof_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `sten_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `1sgt_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `2sgt_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `3sgt_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `cb_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `cbev_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `sdep_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `sdev_adidoTexto` VARCHAR(500) NULL DEFAULT 0,
  `encostados` VARCHAR(500) NULL DEFAULT 0,
  `agregados` VARCHAR(500) NULL DEFAULT 0,
  `cap_pttc_previsto` SMALLINT NULL DEFAULT 0,
  `1ten_pttc_previsto` SMALLINT NULL DEFAULT 0,
  `2ten_pttc_previsto` SMALLINT NULL DEFAULT 0,
  `sten_pttc_previsto` SMALLINT NULL DEFAULT 0,
  `1sgt_pttc_previsto` SMALLINT NULL DEFAULT 0,
  `2sgt_pttc_previsto` SMALLINT NULL DEFAULT 0,
  `cap_pttc_existente` SMALLINT NULL DEFAULT 0,
  `1ten_pttc_existente` SMALLINT NULL DEFAULT 0,
  `2ten_pttc_existente` SMALLINT NULL DEFAULT 0,
  `sten_pttc_existente` SMALLINT NULL DEFAULT 0,
  `1sgt_pttc_existente` SMALLINT NULL DEFAULT 0,
  `2sgt_pttc_existente` SMALLINT NULL DEFAULT 0,
  `cap_pttc_adido` SMALLINT NULL DEFAULT 0,
  `1ten_pttc_adido` SMALLINT NULL DEFAULT 0,
  `2ten_pttc_adido` SMALLINT NULL DEFAULT 0,
  `sten_pttc_adido` SMALLINT NULL DEFAULT 0,
  `1sgt_pttc_adido` SMALLINT NULL DEFAULT 0,
  `2sgt_pttc_adido` SMALLINT NULL DEFAULT 0,
  `cap_pttc_adidoTexto` VARCHAR(500) NULL,
  `1ten_pttc_adidoTexto` VARCHAR(500) NULL,
  `2ten_pttc_adidoTexto` VARCHAR(500) NULL,
  `sten_pttc_adidoTexto` VARCHAR(500) NULL,
  `1sgt_pttc_adidoTexto` VARCHAR(500) NULL,
  `2sgt_pttc_adidoTexto` VARCHAR(500) NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Providencia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Providencia` ;

CREATE TABLE IF NOT EXISTS `scc`.`Providencia` (
  `idProvidencia` INT NOT NULL AUTO_INCREMENT,
  `providencia` VARCHAR(2500) NULL,
  `Material_idMaterial` INT NOT NULL,
  `data` DATE NULL,
  PRIMARY KEY (`idProvidencia`),
  INDEX `fk_Providencia_Material1_idx` (`Material_idMaterial` ASC),
  CONSTRAINT `fk_Providencia_Material1`
    FOREIGN KEY (`Material_idMaterial`)
    REFERENCES `scc`.`Material` (`idMaterial`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`NotaCredito`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`NotaCredito` ;

CREATE TABLE IF NOT EXISTS `scc`.`NotaCredito` (
  `idNotaCredito` INT NOT NULL AUTO_INCREMENT,
  `dataNc` DATE NULL,
  `nc` VARCHAR(25) NOT NULL,
  `pi` VARCHAR(25) NULL,
  `valor` DECIMAL(10,2) NULL,
  `gestorNc` VARCHAR(70) NULL,
  `ptres` VARCHAR(25) NULL,
  `fonte` VARCHAR(25) NULL,
  `ug` VARCHAR(7) NULL,
  `valorRecolhido` DECIMAL(10,2) NULL,
  PRIMARY KEY (`idNotaCredito`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Categoria` ;

CREATE TABLE IF NOT EXISTS `scc`.`Categoria` (
  `idCategoria` INT NOT NULL AUTO_INCREMENT,
  `categoria` VARCHAR(125) NULL,
  PRIMARY KEY (`idCategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Requisicao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Requisicao` ;

CREATE TABLE IF NOT EXISTS `scc`.`Requisicao` (
  `idRequisicao` INT NOT NULL AUTO_INCREMENT,
  `dataRequisicao` DATE NULL,
  `om` VARCHAR(70) NULL,
  `Secao_idSecao` INT NULL DEFAULT NULL,
  `NotaCredito_idNotaCredito` INT NULL,
  `Categoria_idCategoria` INT NULL,
  `modalidade` VARCHAR(70) NULL,
  `numeroModalidade` VARCHAR(14) NULL,
  `ug` INT NULL,
  `omModalidade` VARCHAR(125) NULL,
  `empresa` VARCHAR(250) NULL,
  `cnpj` VARCHAR(25) NULL,
  `contato` VARCHAR(520) NULL,
  `dataNE` DATE NULL,
  `tipoNE` VARCHAR(25) NULL,
  `ne` VARCHAR(25) NULL,
  `valorNE` DECIMAL(10,2) NULL,
  `observacaoSALC` VARCHAR(520) NULL,
  `dataEnvioNE` DATE NULL,
  `valorAnulado` DECIMAL(10,2) NULL,
  `justificativaAnulado` VARCHAR(520) NULL,
  `valorReforcado` DECIMAL(10,2) NULL,
  `observacaoReforco` VARCHAR(520) NULL,
  `NotaCredito_idNotaCreditoReforco` INT NULL,
  `dataParecer` DATE NULL,
  `parecer` TINYINT(1) NULL,
  `observacaoConformidade` VARCHAR(520) NULL,
  `dataAssinatura` DATE NULL,
  `dataEnvioNEEmpresa` DATE NULL,
  `dataPrazoEntrega` DATE NULL,
  `diex` VARCHAR(520) NULL,
  `dataDiex` DATE NULL,
  `dataOficio` DATE NULL,
  `Processo_idProcesso` INT NULL,
  `observacaoAlmox` VARCHAR(520) NULL,
  `dataProtocoloSalc1` DATE NULL,
  `dataProtocoloConformidade` DATE NULL,
  `dataProtocoloSalc2` DATE NULL,
  `dataProtocoloAlmox` DATE NULL,
  `tipoNF` VARCHAR(25) NULL,
  `responsavel` VARCHAR(25) NULL,
  PRIMARY KEY (`idRequisicao`),
  INDEX `fk_Requisicao_Secao1_idx` (`Secao_idSecao` ASC) VISIBLE,
  INDEX `fk_Requisicao_NotaCredito1_idx` (`NotaCredito_idNotaCredito` ASC) VISIBLE,
  INDEX `fk_Requisicao_Categoria1_idx` (`Categoria_idCategoria` ASC) VISIBLE,
  INDEX `fk_Requisicao_NotaCredito2_idx` (`NotaCredito_idNotaCreditoReforco` ASC) VISIBLE,
  INDEX `fk_Requisicao_Processo1_idx` (`Processo_idProcesso` ASC) VISIBLE,
  CONSTRAINT `fk_Requisicao_Secao1`
    FOREIGN KEY (`Secao_idSecao`)
    REFERENCES `scc`.`Secao` (`idSecao`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Requisicao_NotaCredito1`
    FOREIGN KEY (`NotaCredito_idNotaCredito`)
    REFERENCES `scc`.`NotaCredito` (`idNotaCredito`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Requisicao_Categoria1`
    FOREIGN KEY (`Categoria_idCategoria`)
    REFERENCES `scc`.`Categoria` (`idCategoria`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Requisicao_NotaCredito2`
    FOREIGN KEY (`NotaCredito_idNotaCreditoReforco`)
    REFERENCES `scc`.`NotaCredito` (`idNotaCredito`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Requisicao_Processo1`
    FOREIGN KEY (`Processo_idProcesso`)
    REFERENCES `scc`.`Processo` (`idProcesso`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `scc`.`Visitante`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Visitante` ;

CREATE TABLE IF NOT EXISTS `scc`.`Visitante` (
  `idVisitante` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(125) NULL,
  `cpf` VARCHAR(16) NULL,
  `telefone` VARCHAR(14) NULL,
  `destino` VARCHAR(250) NULL,
  `dataEntrada` DATETIME NULL,
  `dataSaida` DATETIME NULL,
  `cracha` VARCHAR(25) NULL,
  `temporario` TINYINT(1) NULL,
  `foto` VARCHAR(250) NULL,
  PRIMARY KEY (`idVisitante`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`Item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`Item` ;

CREATE TABLE IF NOT EXISTS `scc`.`Item` (
  `idItem` INT NOT NULL AUTO_INCREMENT,
  `numeroItem` VARCHAR(7) NULL,
  `descricao` VARCHAR(500) NULL,
  `quantidade` INT NULL,
  `valor` DECIMAL(10,2) NULL,
  `Requisicao_idRequisicao` INT NULL,
  PRIMARY KEY (`idItem`),
  INDEX `fk_Item_Requisicao1_idx` (`Requisicao_idRequisicao` ASC),
  CONSTRAINT `fk_Item_Requisicao1`
    FOREIGN KEY (`Requisicao_idRequisicao`)
    REFERENCES `scc`.`Requisicao` (`idRequisicao`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`NotaFiscal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`NotaFiscal` ;

CREATE TABLE IF NOT EXISTS `scc`.`NotaFiscal` (
  `idNotaFiscal` INT NOT NULL AUTO_INCREMENT,
  `tipoNF` VARCHAR(25) NULL,
  `nf` VARCHAR(70) NULL,
  `codigoVerificacao` VARCHAR(70) NULL,
  `chaveAcesso` VARCHAR(70) NULL,
  `valorNF` DECIMAL(10,2) NULL,
  `descricao` VARCHAR(1000) NULL,
  `dataEmissaoNF` DATE NULL,
  `dataEntrega` DATE NULL,
  `dataRemessaTesouraria` DATE NULL,
  `Requisicao_idRequisicao` INT NOT NULL,
  `dataLiquidacao` DATE NULL,
  `dataPedido` DATE NULL,
  `dataPrazoEntrega` DATE NULL,
  PRIMARY KEY (`idNotaFiscal`),
  INDEX `fk_NotaFiscal_Requisicao1_idx` (`Requisicao_idRequisicao` ASC) VISIBLE,
  CONSTRAINT `fk_NotaFiscal_Requisicao1`
    FOREIGN KEY (`Requisicao_idRequisicao`)
    REFERENCES `scc`.`Requisicao` (`idRequisicao`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scc`.`NotaFiscal_has_Item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `scc`.`NotaFiscal_has_Item` ;

CREATE TABLE IF NOT EXISTS `scc`.`NotaFiscal_has_Item` (
  `NotaFiscal_idNotaFiscal` INT NOT NULL,
  `Item_idItem` INT NOT NULL,
  `quantidade` INT NULL,
  INDEX `fk_NotaFiscal_has_Item_Item1_idx` (`Item_idItem` ASC),
  INDEX `fk_NotaFiscal_has_Item_NotaFiscal1_idx` (`NotaFiscal_idNotaFiscal` ASC),
  CONSTRAINT `fk_NotaFiscal_has_Item_NotaFiscal1`
    FOREIGN KEY (`NotaFiscal_idNotaFiscal`)
    REFERENCES `scc`.`NotaFiscal` (`idNotaFiscal`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_NotaFiscal_has_Item_Item1`
    FOREIGN KEY (`Item_idItem`)
    REFERENCES `scc`.`Item` (`idItem`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `scc`.`Posto`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Sd EV');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Sd EP');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Cb');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, '3º Sgt');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, '2º Sgt');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, '1º Sgt');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'S Ten');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Asp Of');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, '2º Ten');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, '1º Ten');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Cap');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Maj');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'TC');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Cel');
INSERT INTO `scc`.`Posto` (`idPosto`, `posto`) VALUES (DEFAULT, 'Gen');

COMMIT;

-- -----------------------------------------------------
-- Data for table `scc`.`Secao`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `Secao` VALUES (1,'SecInfo',NULL,NULL),(2,'S1','2022-08-05 09:44:20',''),(3,'S4','2022-07-14 10:48:09','Saldo total dos tanques &eacute; a soma do saldo do 2&ordm; BE Cmb, 11&ordm; Cia E Cmb L, 12&ordf; Cia E Cmb L e 2&ordf; RM'),(4,'Juridico',NULL,NULL),(5,'FS','2022-08-03 10:19:41',NULL),(7,'Comando',NULL,NULL),(8,'S2',NULL,NULL),(9,'S3',NULL,NULL),(10,'Fiscalizacao',NULL,NULL),(11,'RP','2022-05-18 16:33:05',NULL);
INSERT INTO Secao(secao) VALUES('SALC');
INSERT INTO Secao(secao) VALUES('Conformidade');
INSERT INTO Secao(secao) VALUES('Almoxarifado');
INSERT INTO Secao(secao) VALUES('Tesouraria');

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`Combustivel`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;

INSERT INTO `Combustivel` VALUES ('11&ordm; Cia E Cmb  L','Cota batalh&atilde;o','Cota batalh&atilde;o',5000.0,5000.0,0.0,'Cota batalh&atilde;o','Cota Batalh&atilde;o','Cota batalh&atilde;o',0.0,5000.0,0.0,21253.0,10027.0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`Situacao`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`Situacao` (`idSituacao`, `situacao`) VALUES (DEFAULT, 'Disponível');
INSERT INTO `scc`.`Situacao` (`idSituacao`, `situacao`) VALUES (DEFAULT, 'Indisponível');
INSERT INTO `scc`.`Situacao` (`idSituacao`, `situacao`) VALUES (DEFAULT, 'Cedido');
INSERT INTO `scc`.`Situacao` (`idSituacao`, `situacao`) VALUES (DEFAULT, 'Missão');

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`Classe`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
--INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'I');
--INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'II');
--INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'III');
--INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'IV');
--INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'V');
INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (6, 'VI');
--INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'VII');
--INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'VIII');
INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (9, 'IX');
--INSERT INTO `scc`.`Classe` (`idClasse`, `classe`) VALUES (DEFAULT, 'X');

COMMIT;

-- -----------------------------------------------------
-- Data for table `scc`.`NotaCredito`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `NotaCredito` VALUES (1,'2022-06-14','2022NC800149','i3',280.00,'COTER','01','','160477',NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `scc`.`Categoria`
-- -----------------------------------------------------
START TRANSACTION;
USE `scc`;
INSERT INTO `scc`.`Categoria` (`idCategoria`, `categoria`) VALUES (1, 'INFORMÁTICA');
INSERT INTO `Categoria` VALUES (2,'MATERIAL DE LIMPEZA');
COMMIT;

ALTER TABLE `scc`.`Baixado` 
CHANGE COLUMN `amparo` `amparo` VARCHAR(250) NULL DEFAULT NULL ;
ALTER TABLE `scc`.`Baixado` 
CHANGE COLUMN `acao` `acao` VARCHAR(500) NULL DEFAULT NULL ;


