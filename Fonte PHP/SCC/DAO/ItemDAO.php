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
require_once '../Model/Item.php';

class ItemDAO {

//    public function insert($object) {
//        try {
//            $c = connect();
//            $sql = "INSERT INTO `scc`.`Item` (`numeroItem`, `descricao`, `quantidade`, `valor`, `Requisicao_idRequisicao`) "
//                    . "VALUES ("
//                    . "'" . $object->getNumeroItem() . "' "
//                    . ", '" . $object->getDescricao() . "' "
//                    . ", " . (empty($object->getQuantidade()) ? "0" : $object->getQuantidade()) . " "
//                    . ", '" . (empty($object->getValor()) ? "0.0" : $object->getValor()) . "' "
//                    . ", " . $object->getIdRequisicao() . " "
//                    . ");";
//            $stmt = $c->prepare($sql);
//            $sqlOk = $stmt ? $stmt->execute() : false;
//            $c->close();
//            return $sqlOk;
//        } catch (Exception $e) {
//            throw($e);
//        }
//    }
//    public function update($object) {
//        try {
//            $c = connect();
//            $sql = "UPDATE `scc`.`Item`
//                    SET                        
//                        `numeroItem` = '" . $object->getNumeroItem() . "'
//                        , `descricao` = '" . $object->getDescricao() . "'
//                        , `quantidade` = '" . (empty($object->getQuantidade()) ? "0" : $object->getQuantidade()) . "'
//                        , `valor` = '" . (empty($object->getValor()) ? "0.0" : $object->getValor()) . "'
//                        , `Requisicao_idRequisicao` = '" . $object->getIdRequisicao() . "'                       
//                        WHERE `idItem` = " . $object->getId() . ";";
//            $stmt = $c->prepare($sql);
//            $sqlOk = $stmt ? $stmt->execute() : false;
//            $c->close();
//            return $sqlOk;
//        } catch (Exception $e) {
//            throw($e);
//        }
//    }

    public function delete($object) {
        try {
            $c = connect();
            $sql = "DELETE FROM Item "
                    . " WHERE idItem = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

//    public function getAllList() {
//        try {
//            $c = connect();
//            $sql = "SELECT * "
//                    . " FROM Item ";
//            $result = $c->query($sql);
//            while ($row = $result->fetch_assoc()) {
//                $objectArray = $this->fillArray($row);
//                $lista[] = new Item($objectArray);
//            }
//            $c->close();
//            return isset($lista) ? $lista : null;
//        } catch (Exception $e) {
//            throw($e);
//        }
//    }
//    public function getById($id) {
//        try {
//            $c = connect();
//            $sql = "SELECT * "
//                    . " FROM Item "
//                    . " WHERE idItem = $id";
//            $result = $c->query($sql);
//            while ($row = $result->fetch_assoc()) {
//                $objectArray = $this->fillArray($row);
//                $instance = new Item($objectArray);
//            }
//            $c->close();
//            return isset($instance) ? $instance : null;
//        } catch (Exception $e) {
//            throw($e);
//        }
//    }

    public function getByRequisicaoId($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . ", REPLACE(valor, '.', ',') AS valor "
                    . " FROM Item "
                    . " WHERE Requisicao_idRequisicao = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Item($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    /**
     * 
     * @param ID of NotaFiscal object
     * @return List of Itens of a NotaFiscal object     
     */
    public function getByNotaFiscalId($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . ", REPLACE(valor, '.', ',') AS valor "
                    . " FROM NotaFiscal_has_Item "
                    . " INNER JOIN Item ON Item_idItem = idItem "
                    . " WHERE NotaFiscal_idNotaFiscal = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Item($objectArray);
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getTotalQuantidade($idItem) {
        try {
            $c = connect();
            $sql = "SELECT SUM(quantidade) as total 
                        FROM NotaFiscal_has_Item 
                        WHERE Item_idItem = $idItem";   
            $result = $c->query($sql);            
            while ($row = $result->fetch_assoc()) {
                $total = $row["total"];
            }
            $c->close();
            return isset($total) ? $total : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getQuantidadeByItemIdENFId($idItem, $idNF) {
        try {
            $c = connect();
            $sql = "SELECT idItem, numeroItem, descricao, valor, Requisicao_idRequisicao, "
                    . " NotaFiscal_has_Item.quantidade as quantidade "
                    . " FROM NotaFiscal_has_Item "
                    . " INNER JOIN Item "
                    . " WHERE Item_idItem = $idItem AND NotaFiscal_idNotaFiscal = $idNF";            
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Item($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }
    
    public function getQuantidadeByItem($idItem) {
        try {
            $c = connect();
            $sql = "SELECT idItem, numeroItem, descricao, valor, Requisicao_idRequisicao, "
                    . " NotaFiscal_has_Item.quantidade as quantidade "
                    . " FROM NotaFiscal_has_Item "
                    . " INNER JOIN Item "
                    . " WHERE Item_idItem = $idItem";            
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Item($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idItem"],
            "numeroItem" => $row["numeroItem"],
            "descricao" => $row["descricao"],
            "quantidade" => $row["quantidade"],
            "valor" => $row["valor"],
            "idRequisicao" => $row["Requisicao_idRequisicao"]
        );
    }

}
