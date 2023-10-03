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
require_once '../Model/Sped.php';

class SpedDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO Sped("
                    . "titulo, responsavel, resolvido, prazo, data, tipo "
                    . ") "
                    . "VALUES("
                    . "'" . $object->getTitulo() . "', "
                    . "'" . $object->getResponsavel() . "', "
                    . (empty($object->getResolvido()) ? "0, " : $object->getResolvido() . ", ")
                    . (empty($object->getPrazo()) ? "NULL, " : "'" . $object->getPrazo() . "', ")
                    . (empty($object->getData()) ? "NULL, " : "'" . $object->getData() . "', ")
                    . (empty($object->getTipo()) ? "NULL " : "'" . $object->getTipo() . "' ")
                    . ");";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function update($object) {
        try {
            $c = connect();
            $sql = "UPDATE Sped SET "
                    . "titulo = '" . $object->getTitulo() . "', "
                    . "responsavel = '" . $object->getResponsavel() . "', "
                    . "resolvido = " . (empty($object->getResolvido()) ? "0, " : $object->getResolvido() . ", ")
                    . "prazo = " . (empty($object->getPrazo()) ? "NULL, " : "'" . $object->getPrazo() . "', ")
                    . "data = " . (empty($object->getData()) ? "NULL, " : "'" . $object->getData() . "', ")
                    . "tipo = '" . $object->getTipo() . "' "
                    . " WHERE idSped = " . $object->getId() . ";";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function delete($object) {
        try {
            $c = connect();
            $sql = "DELETE FROM Sped "
                    . " WHERE idSped = " . $object->getId() . ";";
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
                    . " FROM Sped ";
            if (/*$filtro["resolvido"] != "todos" ||*/ $filtro["tipo"] != "todos") {                              
//                if ($filtro["resolvido"] === 1 || $filtro["resolvido"] === 0) {
//                    $sql .= " resolvido = " . $filtro["resolvido"];
//                }
                if ($filtro["tipo"] == "Documento" || $filtro["tipo"] == "Missao") {
//                    if ($filtro["resolvido"] !== "") {
//                        $sql .= " AND ";
//                    }
                    $sql .= " WHERE tipo = '" . $filtro["tipo"] . "'";
                }
            }
            $sql .= " ORDER BY prazo ";             
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Sped($objectArray);
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
                    . " FROM Sped "
                    . " WHERE idSped = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Sped($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idSped"],
            "resolvido" => $row["resolvido"],
            "responsavel" => $row["responsavel"],
            "titulo" => $row["titulo"],
            "prazo" => $row["prazo"],
            "data" => $row["data"],
            "tipo" => $row["tipo"]
        );
    }

}
