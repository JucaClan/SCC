<?php

/* * *****************************************************************************
 * 
 * Copyright © 2021 Gustavo Henrique Mello Dauer - 2º Ten 
 * Chefe da Seção de Informática do 2º BE Cmb
 * Email: gustavodauer@gmail.com
 * 
 * Este arquivo é parte do programa SCC
 * 
 * SCC é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da Licença Pública Geral GNU como
 * publicada pela Free Software Foundation (FSF); na versão 3 da
 * Licença, ou qualquer versão posterior.

 * Este programa é distribuído na esperança de que possa ser útil,
 * mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO
 * a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
 * Licença Pública Geral GNU para maiores detalhes.

 * Você deve ter recebido uma cópia da Licença Pública Geral GNU junto
 * com este programa, Se não, veja <http://www.gnu.org/licenses/>.
 * 
 * ***************************************************************************** */

/**
 *
 * @author gustavodauer
 */
require_once '../include/comum.php';
require_once '../Model/NotaFiscal.php';
require_once 'RequisicaoDAO.php';

class NotaFiscalDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "START TRANSACTION;"
                    . "INSERT INTO `scc`.`NotaFiscal` (`tipoNF`, `nf`, `codigoVerificacao`, `chaveAcesso`, `valorNF`, `descricao`, `dataEmissaoNF`, `dataEntrega`, `dataRemessaTesouraria`, `Requisicao_idRequisicao`, `dataLiquidacao`) "
                    . "VALUES ("
                    . "'" . $object->getTipoNF() . "' "
                    . ", '" . $object->getNf() . "' "
                    . ", '" . $object->getCodigoVerificacao() . "' "
                    . ", '" . $object->getChaveAcesso() . "' "
                    . ", '" . (empty($object->getValorNF()) ? "0.0" : $object->getValorNF()) . "'"
                    . ", '" . $object->getDescricao() . "' "
                    . ", " . (!empty($object->getDataEmissaoNF()) ? "'" . $object->getDataEmissaoNF() . "' " : "NULL ")
                    . ", " . (!empty($object->getDataEntrega()) ? "'" . $object->getDataEntrega() . "' " : "NULL ")
                    . ", " . (!empty($object->getDataRemessaTesouraria()) ? "'" . $object->getDataRemessaTesouraria() . "' " : "NULL ")
                    . ", " . (!empty($object->getIdRequisicao()) ? $object->getIdRequisicao() : "NULL ")
                    . ", " . (!empty($object->getDataLiquidacao()) ? "'" . $object->getDataLiquidacao() . "' " : "NULL ")
                    . ");SET @idNotaFiscal = LAST_INSERT_ID();";
            $itemList = $object->getItemList();
            if (!is_null($itemList)) {
                foreach ($itemList as $item) {
                    $sql .= "INSERT INTO `scc`.`NotaFiscal_has_Item` (`NotaFiscal_idNotaFiscal`, `Item_idItem`, `quantidade`) "
                            . "VALUES ("
                            . "@idNotaFiscal "
                            . ", " . $item["idItem"]
                            . ", " . $item["quantidadeItem"]
                            . ");";
                }
            }
            $sql .= "COMMIT;";
            //$stmt = $c->prepare($sql);
            //$sqlOk = $stmt ? $stmt->execute() : false;
            $sqlOk = $c->multi_query($sql);
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function update($object) { // ToDo NULL nos campos de datas
        try {
            $c = connect();
            $sql = "START TRANSACTION;
                UPDATE `scc`.`NotaFiscal` SET                        
                        `tipoNF` = '" . $object->getTipoNF() . "'
                        , `nf` = '" . $object->getNf() . "'
                        , `codigoVerificacao` = '" . $object->getCodigoVerificacao() . "'
                        , `chaveAcesso` = '" . $object->getChaveAcesso() . "'
                        , `valorNF` = '" . (empty($object->getValorNF()) ? "0.0" : $object->getValorNF()) . "'      
                        , `descricao` = '" . $object->getDescricao() . "'
                        , `dataEmissaoNF` = " . (!empty($object->getDataEmissaoNF()) ? "'" . $object->getDataEmissaoNF() . "' " : "NULL ") . "
                        , `dataEntrega` = " . (!empty($object->getDataEntrega()) ? "'" . $object->getDataEntrega() . "' " : "NULL ") . "
                        , `dataRemessaTesouraria` = " . (!empty($object->getDataRemessaTesouraria()) ? "'" . $object->getDataRemessaTesouraria() . "' " : "NULL ") . "
                        , `Requisicao_idRequisicao` = '" . $object->getIdRequisicao() . "'
                        , `dataLiquidacao` = " . (!empty($object->getDataLiquidacao()) ? "'" . $object->getDataLiquidacao() . "' " : "NULL ") . "                        
                        WHERE `idNotaFiscal` = " . $object->getId() . ";";            
            $itemList = $object->getItemList();
            if (!is_null($itemList)) {
                foreach ($itemList as $item) {
                    $list = $this->getByNFIdEItemId($object->getId(), $item["idItem"]);
                    if (!is_null($list)) {
                        $sql .= "UPDATE `scc`.`NotaFiscal_has_Item` "
                                . "SET "
                                . " `quantidade` = " . $item["quantidadeItem"]
                                . " WHERE "
                                . " `NotaFiscal_idNotaFiscal` = " . $object->getId() . " AND `Item_idItem` = " . $item["idItem"] . ";";
                    } else {
                        $sql .= "INSERT INTO `scc`.`NotaFiscal_has_Item` (`NotaFiscal_idNotaFiscal`, `Item_idItem`, `quantidade`) "
                                . "VALUES ("
                                . $object->getId()
                                . ", " . $item["idItem"]
                                . ", " . $item["quantidadeItem"]
                                . ");";
                    }
                }
            }
            $sql .= "COMMIT;";
            //$stmt = $c->prepare($sql);
            //$sqlOk = $stmt ? $stmt->execute() : false;            
            $sqlOk = $c->multi_query($sql);
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function delete($object) {
        try {
            $c = connect();
            $sql = "DELETE FROM NotaFiscal "
                    . " WHERE idNotaFiscal = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList($filtro = "") {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . ", REPLACE(valorNF, '.', ',') AS valorNF "
                    . ", DATE_FORMAT(dataLiquidacao, '%d/%m/%Y') as dataLiquidacao "
                    . " FROM NotaFiscal ";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new NotaFiscal($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getById($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . ", REPLACE(valorNF, '.', ',') AS valorNF "
                    . " FROM NotaFiscal "
                    . " WHERE idNotaFiscal = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new NotaFiscal($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getByRequisicaoId($idRequisicao) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . ", REPLACE(valorNF, '.', ',') AS valorNF "
                    . ", DATE_FORMAT(dataLiquidacao, '%d/%m/%Y') as dataLiquidacao "
                    . " FROM NotaFiscal "
                    . " WHERE Requisicao_idRequisicao = $idRequisicao";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new NotaFiscal($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getByNFIdEItemId($idNotaFiscal, $idItem) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM `scc`.`NotaFiscal_has_Item` "
                    . " INNER JOIN NotaFiscal ON idNotaFiscal = NotaFiscal_idNotaFiscal "
                    . " WHERE `NotaFiscal_idNotaFiscal` = " . $idNotaFiscal . " AND `Item_idItem` = " . $idItem . ";";            
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new NotaFiscal($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idNotaFiscal"],
            "tipoNF" => $row["tipoNF"],
            "nf" => $row["nf"],
            "codigoVerificacao" => $row["codigoVerificacao"],
            "chaveAcesso" => $row["chaveAcesso"],
            "valorNF" => $row["valorNF"],
            "descricao" => $row["descricao"],
            "dataEmissaoNF" => $row["dataEmissaoNF"],
            "dataEntrega" => $row["dataEntrega"],
            "dataRemessaTesouraria" => $row["dataRemessaTesouraria"],
            "idRequisicao" => $row["Requisicao_idRequisicao"],
            "dataLiquidacao" => $row["dataLiquidacao"],
        );
    }

}
