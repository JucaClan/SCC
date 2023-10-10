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
require_once '../Model/Veiculo.php';

class VeiculoDAO {

    public function insert($object) {
        try {
            $c = connect();
            $sql = "INSERT INTO Veiculo("
                    . "tipoVeiculo, placa, modelo, cor, nomeCompleto, identidade, destino, dataEntrada, dataSaida "
                    . ") "
                    . "VALUES("
                    . "'" . $object->getTipoVeiculo() . "', "
                    . "'" . $object->getPlaca() . "', "
                    . "'" . $object->getModelo() . "', "
                    . "'" . $object->getCor() . "' "
                    . "'" . $object->getNomeCompleto() . "' "
                    . "'" . $object->getIdentidade() . "' "
                    . "'" . $object->getDestino() . "' "
                    . ", " . (!empty($object->getDataEntrada()) ? "'" . $object->getDataEntrada() . "' " : " NULL ")
                    . ", " . (!empty($object->getDataSaida()) ? "'" . $object->getDataSaida() . "' " : " NULL ")                
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
            $sql = "UPDATE Veiculo SET "
                    . "tipoVeiculo = '" . $object->getTipoVeiculo() . "', "
                    . "placa = '" . $object->getPlaca() . "', "
                    . "modelo = '" . $object->getModelo() . "', "
                    . "cor = '" . $object->getCor() . "' "
                    . "nomeCompleto = '" . $object->getNomeCompleto() . "' "
                    . "identidade = '" . $object->getIdentidade() . "' "
                    . "destino = '" . $object->getDestino() . "' "                
                    . ", dataEntrada = " . (!empty($object->getDataEntrada()) ? "'" . $object->getDataEntrada() . "' " : "NULL ")
                    . ", dataSaida = " . (!empty($object->getDataSaida()) ? "'" . $object->getDataSaida() . "' " : "NULL ")                    
                    . " WHERE idVeiculo = " . $object->getId() . ";";            
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
            $sql = "DELETE FROM Veiculo "
                    . " WHERE idVeiculo = " . $object->getId() . ";";
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
            $sql = "SELECT *, "
                    . "DATE_FORMAT(dataEntrada, '%H:%i em %d/%m/%Y') as dataEntrada, "
                    . "DATE_FORMAT(dataSaida, '%H:%i em %d/%m/%Y') as dataSaida "
                    . " FROM Visitante "
                    . (!empty($filtro["inicio"]) || !empty($filtro["fim"]) ? " WHERE " : "")
                    . (!empty($filtro["inicio"]) ? " dataEntrada >= '" . $filtro["inicio"] . "' AND " : "")
                    . (!empty($filtro["fim"]) && !empty($filtro["inicio"]) ? " dataEntrada <= '" . $filtro["fim"] . "' " : "")
                    . " ORDER BY dataEntrada DESC ";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $lista[] = new Veiculo($objectArray);
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
                    . " FROM Veiculo "
                    . " WHERE idVeiculo = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Veiculo($objectArray);
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function fillArray($row) {
        return array(
            "id" => $row["idVeiculo"],
            "tipoVeiculo" => $row["tipoVeiculo"],
            "placa" => $row["placa"],
            "modelo" => $row["modelo"],
            "cor" => $row["cor"],
            "nomeCompleto" => $row["nomeCompleto"],
            "identidade" => $row["identidade"],            
            "destino" => $row["destino"],
            "dataEntrada" => $row["dataEntrada"],
            "dataSaida" => $row["dataSaida"]
        );
    }

}
