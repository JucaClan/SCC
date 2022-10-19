<?php

require_once '../Model/Requisicao.php';
require_once '../include/comum.php';

class RequisicaoDAO {

    function insert($object) {
        try {
            $c = connect();
            $sql = "START TRANSACTION;"
                    . "INSERT INTO `scc`.`Requisicao` (`dataRequisicao`, `om`, `Secao_idSecao`, `NotaCredito_idNotaCredito`, `Categoria_idCategoria`, `modalidade`, `numeroModalidade`, `ug`, `omModalidade`, `empresa`, `cnpj`, `contato`, `dataNE`, `tipoNE`, `tipoNF`, `ne`, `valorNE`, `observacaoSALC`, `dataEnvioNE`, `valorAnulado`, `justificativaAnulado`, `valorReforcado`, `observacaoReforco`, `NotaCredito_idNotaCreditoReforco`, `dataParecer`, `parecer`, `observacaoConformidade`, `dataAssinatura`, `dataEnvioNEEmpresa`, `dataPrazoEntrega`, `dataOficio`, `diex`, `dataDiex`, `Processo_idProcesso`, `observacaoAlmox`, `dataProtocoloSalc1`, `dataProtocoloConformidade`, `dataProtocoloSalc2`, `dataProtocoloAlmox`, `responsavel`) "
                    . " VALUES("
                    . (!empty($object->getDataRequisicao()) ? "'" . $object->getDataRequisicao() . "' " : "NULL ")
                    . ", '" . $object->getOm() . "'"
                    . ", " . $object->getIdSecao()
                    . ", " . (!empty($object->getIdNotaCredito()) ? $object->getIdNotaCredito() : "NULL ")
                    . ", " . (!empty($object->getIdCategoria()) ? $object->getIdCategoria() : "NULL ")
                    . ", '" . $object->getModalidade() . "'"
                    . ", " . $object->getNumeroModalidade()
                    . ", " . $object->getUg() . " "
                    . ", '" . $object->getOmModalidade() . "'"
                    . ", '" . $object->getEmpresa() . "'"
                    . ", '" . $object->getCnpj() . "'"
                    . ", '" . $object->getContato() . "'"
                    . ", " . (!empty($object->getDataNE()) ? "'" . $object->getDataNE() . "' " : "NULL ")
                    . ", '" . $object->getTipoNE() . "'"
                    . ", '" . $object->getTipoNF() . "'"
                    . ", '" . $object->getNe() . "'"
                    . ", '" . (empty($object->getValorNE()) ? "0.0" : $object->getValorNE()) . "'"
                    . ", '" . $object->getObservacaoSALC() . "'"
                    . ", " . (!empty($object->getDataEnvioNE()) ? "'" . $object->getDataEnvioNE() . "' " : "NULL ")
                    . ", '" . (empty($object->getValorAnulado()) ? "0.0" : $object->getValorAnulado()) . "'"
                    . ", '" . $object->getJustificativaAnulado() . "'"
                    . ", '" . (empty($object->getValorReforcado()) ? "0.0" : $object->getValorReforcado()) . "'"
                    . ", '" . $object->getObservacaoReforco() . "'"
                    . ", " . (!empty($object->getIdNotaCreditoReforco()) ? $object->getIdNotaCreditoReforco() : "NULL ")
                    . ", " . (!empty($object->getDataParecer()) ? "'" . $object->getDataParecer() . "' " : "NULL ")
                    . ", " . (!empty($object->getParecer()) ? $object->getParecer() : "NULL ")
                    . ", '" . $object->getObservacaoConformidade() . "'"
                    . ", " . (!empty($object->getDataAssinatura()) ? "'" . $object->getDataAssinatura() . "' " : "NULL ")
                    . ", " . (!empty($object->getDataEnvioNEEmpresa()) ? "'" . $object->getDataEnvioNEEmpresa() . "' " : "NULL ")
                    . ", " . (!empty($object->getDataPrazoEntrega()) ? "'" . $object->getDataPrazoEntrega() . "' " : "NULL ")
                    . ", " . (!empty($object->getDataOficio()) ? "'" . $object->getDataOficio() . "' " : "NULL ")
                    . ", '" . $object->getDiex() . "'"
                    . ", " . (!empty($object->getDataDiex()) ? "'" . $object->getDataDiex() . "' " : "NULL ")
                    . ", " . (!empty($object->getIdProcesso()) ? $object->getIdProcesso() : "NULL ")
                    . ", '" . $object->getObservacaoAlmox() . "'"
                    . ", " . (!empty($object->getDataProtocoloSalc1()) ? "'" . $object->getDataProtocoloSalc1() . "' " : "NULL ")
                    . ", " . (!empty($object->getDataProtocoloConformidade()) ? "'" . $object->getDataProtocoloConformidade() . "' " : "NULL ")
                    . ", " . (!empty($object->getDataProtocoloSalc2()) ? "'" . $object->getDataProtocoloSalc2() . "' " : "NULL ")
                    . ", " . (!empty($object->getDataProtocoloAlmox()) ? "'" . $object->getDataProtocoloAlmox() . "' " : "NULL ")
                    . ", '" . $object->getResponsavel() . "'"
                    . ");SET @idRequisicao = LAST_INSERT_ID();";
            $itemList = $object->getItemList();
            if (!is_null($itemList)) {
                foreach ($itemList as $item) {
                    $sql .= "INSERT INTO `scc`.`Item` (`numeroItem`, `descricao`, `quantidade`, `valor`, `Requisicao_idRequisicao`) "
                            . "VALUES ("
                            . "'" . $item->getNumeroItem() . "' "
                            . ", '" . $item->getDescricao() . "' "
                            . ", " . (empty($item->getQuantidade()) ? "0" : $item->getQuantidade()) . " "
                            . ", '" . (empty($item->getValor()) ? "0.0" : $item->getValor()) . "' "
                            . ", @idRequisicao "
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

    function update($object) {
        try {
            $c = connect();
            $sql = "START TRANSACTION;
                        UPDATE `scc`.`Requisicao`
                        SET "
                    . " dataRequisicao = " . (!empty($object->getDataRequisicao()) ? "'" . $object->getDataRequisicao() . "' " : "NULL ")
                    . ", om = '" . $object->getOm() . "' "
                    . ", Secao_idSecao = " . $object->getIdSecao() . " "
                    . ", NotaCredito_idNotaCredito = " . (!empty($object->getIdNotaCredito()) ? $object->getIdNotaCredito() : "NULL ")
                    . ", Categoria_idCategoria = " . (!empty($object->getIdCategoria()) ? $object->getIdCategoria() : "NULL ")
                    . ", modalidade = '" . $object->getModalidade() . "' "
                    . ", numeroModalidade = " . $object->getNumeroModalidade()
                    . ", ug = " . $object->getUg()
                    . ", omModalidade = '" . $object->getOmModalidade() . "' "
                    . ", empresa = '" . $object->getEmpresa() . "' "
                    . ", cnpj = '" . $object->getCnpj() . "' "
                    . ", contato = '" . $object->getContato() . "' "
                    . ", dataNE = " . (!empty($object->getDataNE()) ? "'" . $object->getDataNE() . "' " : "NULL ")
                    . ", tipoNE = '" . $object->getTipoNE() . "' "
                    . ", tipoNF = '" . $object->getTipoNF() . "' "
                    . ", ne = '" . $object->getNe() . "' "
                    . ", valorNE = '" . (empty($object->getValorNE()) ? "0.0" : $object->getValorNE()) . "' "
                    . ", observacaoSALC = '" . $object->getObservacaoSALC() . "' "
                    . ", dataEnvioNE = " . (!empty($object->getDataEnvioNE()) ? "'" . $object->getDataEnvioNE() . "' " : "NULL ")
                    . ", valorAnulado = '" . (empty($object->getValorAnulado()) ? "0.0" : $object->getValorAnulado()) . "' "
                    . ", justificativaAnulado = '" . $object->getJustificativaAnulado() . "' "
                    . ", valorReforcado = '" . (empty($object->getValorReforcado()) ? "0.0" : $object->getValorReforcado()) . "' "
                    . ", observacaoReforco = '" . $object->getObservacaoReforco() . "' "
                    . ", NotaCredito_idNotaCreditoReforco = " . (!empty($object->getIdNotaCreditoReforco()) ? $object->getIdNotaCreditoReforco() : "NULL ")
                    . ", dataParecer = " . (!empty($object->getDataParecer()) ? "'" . $object->getDataParecer() . "' " : "NULL ")
                    . ", parecer = " . (!empty($object->getParecer()) ? $object->getParecer() : "NULL ")
                    . ", observacaoConformidade = '" . $object->getObservacaoConformidade() . "' "
                    . ", dataAssinatura = " . (!empty($object->getDataAssinatura()) ? "'" . $object->getDataAssinatura() . "' " : "NULL ")
                    . ", dataEnvioNEEmpresa = " . (!empty($object->getDataEnvioNEEmpresa()) ? "'" . $object->getDataEnvioNEEmpresa() . "' " : "NULL ")
                    . ", dataPrazoEntrega = " . (!empty($object->getDataPrazoEntrega()) ? "'" . $object->getDataPrazoEntrega() . "' " : "NULL ")
                    . ", dataOficio = " . (!empty($object->getDataOficio()) ? "'" . $object->getDataOficio() . "' " : "NULL ")
                    . ", diex = '" . $object->getDiex() . "' "
                    . ", dataDiex = " . (!empty($object->getDataDiex()) ? "'" . $object->getDataDiex() . "' " : "NULL ")
                    . ", Processo_idProcesso = " . (!empty($object->getIdProcesso()) ? $object->getIdProcesso() . " " : "NULL ") . " "
                    . ", observacaoAlmox = '" . $object->getObservacaoAlmox() . "' "
                    . ", dataProtocoloSalc1 = " . (!empty($object->getDataProtocoloSalc1()) ? "'" . $object->getDataProtocoloSalc1() . "' " : "NULL ")
                    . ", dataProtocoloConformidade = " . (!empty($object->getDataProtocoloConformidade()) ? "'" . $object->getDataProtocoloConformidade() . "' " : "NULL ")
                    . ", dataProtocoloSalc2 = " . (!empty($object->getDataProtocoloSalc2()) ? "'" . $object->getDataProtocoloSalc2() . "' " : "NULL ")
                    . ", dataProtocoloAlmox = " . (!empty($object->getDataProtocoloAlmox()) ? "'" . $object->getDataProtocoloAlmox() . "' " : "NULL ")
                    . ", responsavel = '" . $object->getResponsavel() . "' "
                    . " WHERE idRequisicao = " . $object->getId() . ";";
            $itemList = $object->getItemList();
            if (!is_null($itemList)) {
                foreach ($itemList as $item) {
                    $sql .= "INSERT INTO `scc`.`Item` (`numeroItem`, `descricao`, `quantidade`, `valor`, `Requisicao_idRequisicao`) "
                            . "VALUES ("
                            . "'" . $item->getNumeroItem() . "' "
                            . ", '" . $item->getDescricao() . "' "
                            . ", " . (empty($item->getQuantidade()) ? "0" : $item->getQuantidade()) . " "
                            . ", '" . (empty($item->getValor()) ? "0.0" : $item->getValor()) . "' "
                            . ", " . $object->getId()
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

    function delete($id) {
        try {
            $c = connect();
            $sql = "DELETE FROM Requisicao WHERE idRequisicao = $id";
            $stmt = $c->prepare($sql);
            $sqlOk = $stmt ? $stmt->execute() : false;
            $c->close();
            return $sqlOk;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function getById($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . ", REPLACE(valorNE, '.', ',') AS valorNE "
                    . ", REPLACE(valorAnulado, '.', ',') AS valorAnulado "
                    . ", REPLACE(valorReforcado, '.', ',') AS valorReforcado "
                    . " FROM Requisicao "
                    . " WHERE idRequisicao = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Requisicao($objectArray);
                $instance->setHasNFsParaEntrega($this->checkNFSemEntrega($id));
                $instance->setHasNFsParaLiquidar($this->checkNFSemLiquidar($id));
                $instance->setHasNFsParaRemessa($this->checkNFSemRemessa($id));
            }
            $c->close();
            return isset($instance) ? $instance : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    public function getAllList($filtro = "") {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Requisicao "
                    . " INNER JOIN NotaCredito ON NotaCredito_idNotaCredito = idNotaCredito "
                    . " LEFT JOIN NotaFiscal ON Requisicao_idRequisicao = idRequisicao ";
            if (
                    $filtro["idSecao"] > 0 ||
                    $filtro["idNotaCredito"] > 0 ||
                    !empty($filtro["ug"]) ||
                    !empty($filtro["ne"]) ||
                    $filtro["materiaisEntregues"] === 1 ||
                    $filtro["materiaisEntregues"] === 0 ||
                    $filtro["ano"] > 0
            ) {
                $sql .= " WHERE ";
                if ($filtro["ano"] > 0) {
                    $sql .= " dataNE >= '" . $filtro["ano"] . "-01-01' AND dataNE <= '" . $filtro["ano"] . "-12-31' ";
                }
                if ($filtro["idSecao"] > 0) {
                    if ($filtro["ano"] > 0) {
                        $sql .= " AND ";
                    }
                    $sql .= " Secao_idSecao = " . $filtro["idSecao"];
                }
                if ($filtro["idNotaCredito"] > 0) {
                    if ($filtro["ano"] > 0 || $filtro["idSecao"] > 0) {
                        $sql .= " AND ";
                    }
                    $sql .= " NotaCredito_idNotaCredito = " . $filtro["idNotaCredito"];
                }
                if (!empty($filtro["ug"])) {
                    if ($filtro["ano"] > 0 || $filtro["idSecao"] > 0 || $filtro["idNotaCredito"] > 0) {
                        $sql .= " AND ";
                    }
                    $sql .= " NotaCredito.ug = '" . $filtro["ug"] . "'";
                }
                if (!empty($filtro["ne"])) {
                    if ($filtro["ano"] > 0 || $filtro["idSecao"] > 0 || $filtro["idNotaCredito"] > 0 || !empty($filtro["ug"])) {
                        $sql .= " AND ";
                    }
                    $sql .= " ne = '" . $filtro["ne"] . "'";
                }
                if ($filtro["materiaisEntregues"] === 1) {
                    if ($filtro["ano"] > 0 || $filtro["idSecao"] > 0 || $filtro["idNotaCredito"] > 0 || !empty($filtro["ug"]) || !empty($filtro["ne"])) {
                        $sql .= " AND ";
                    }
                    $sql .= " (dataEntrega != '' AND dataEntrega IS NOT NULL) ";
                }
                if ($filtro["materiaisEntregues"] === 0) {
                    if ($filtro["ano"] > 0 || $filtro["idSecao"] > 0 || $filtro["idNotaCredito"] > 0 || !empty($filtro["ug"]) || !empty($filtro["ne"])) {
                        $sql .= " AND ";
                    }
                    $sql .= " (dataEntrega = '' OR dataEntrega IS NULL) ";
                }
            }
            $sql .= " GROUP BY idRequisicao"
                    . " ORDER BY dataNE, dataRequisicao";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $object = new Requisicao($objectArray);
                $object->setHasNFsParaEntrega($this->checkNFSemEntrega($object->getId()));
                $object->setHasNFsParaLiquidar($this->checkNFSemLiquidar($object->getId()));
                $object->setHasNFsParaRemessa($this->checkNFSemRemessa($object->getId()));
                $lista[] = $object;
            }
            $c->close();
            return isset($lista) ? $lista : null;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function checkNFSemEntrega($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Requisicao "
                    . " LEFT JOIN NotaFiscal ON Requisicao_idRequisicao = idRequisicao "
                    . " WHERE idRequisicao = $id AND (dataEntrega = '' OR dataEntrega IS NULL) "
                    . " GROUP BY idRequisicao ";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Requisicao($objectArray);
            }
            $c->close();
            return isset($instance) ? true : false;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function checkNFSemLiquidar($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Requisicao "
                    . " LEFT JOIN NotaFiscal ON Requisicao_idRequisicao = idRequisicao "
                    . " WHERE idRequisicao = $id AND (dataLiquidacao = '' OR dataLiquidacao IS NULL) "
                    . " GROUP BY idRequisicao ";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Requisicao($objectArray);
            }
            $c->close();
            return isset($instance) ? true : false;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function checkNFSemRemessa($id) {
        try {
            $c = connect();
            $sql = "SELECT * "
                    . " FROM Requisicao "
                    . " LEFT JOIN NotaFiscal ON Requisicao_idRequisicao = idRequisicao "
                    . " WHERE idRequisicao = $id AND (dataRemessaTesouraria = '' OR dataRemessaTesouraria IS NULL) "
                    . " GROUP BY idRequisicao ";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $objectArray = $this->fillArray($row);
                $instance = new Requisicao($objectArray);
            }
            $c->close();
            return isset($instance) ? true : false;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function getTotalItensQuantity($id) {
        try {
            $c = connect();
            $sql = "SELECT SUM(quantidade) as quantidade "
                    . " FROM Requisicao "
                    . " INNER JOIN Item ON Requisicao_idRequisicao = idRequisicao "
                    . " WHERE idRequisicao = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $quantidade = $row["quantidade"];
            }
            $c->close();
            return isset($quantidade) ? $quantidade : 0;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function getTotalItensUsed($id) {
        try {
            $c = connect();
            $sql = "SELECT SUM(NotaFiscal_has_Item.quantidade) as quantidade "
                    . " FROM Requisicao "
                    . " INNER JOIN Item ON Requisicao_idRequisicao = idRequisicao "
                    . " INNER JOIN NotaFiscal_has_Item ON Item_idItem = IdItem "
                    . " WHERE idRequisicao = $id";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $quantidade = $row["quantidade"];
            }
            $c->close();
            return isset($quantidade) ? $quantidade : 0;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function getTotalItensLiquidado($id) {
        try {
            $c = connect();
            $sql = " SELECT SUM(NotaFiscal_has_Item.quantidade) as quantidade FROM Requisicao 
                INNER JOIN NotaFiscal ON NotaFiscal.Requisicao_idRequisicao = idRequisicao 
                INNER JOIN Item ON Item.Requisicao_idRequisicao = idRequisicao 
                INNER JOIN NotaFiscal_has_Item ON Item_idItem = IdItem 
                WHERE 
                    NotaFiscal_has_Item.quantidade > 0 AND 
                    idRequisicao = $id AND 
                    dataLiquidacao != '' AND 
                    dataLiquidacao IS NOT NULL";
            $result = $c->query($sql);
            while ($row = $result->fetch_assoc()) {
                $quantidade = $row["quantidade"];
            }
            $c->close();
            return isset($quantidade) ? $quantidade : 0;
        } catch (Exception $e) {
            throw($e);
        }
    }

    function fillArray($row) {
        return array(
            "id" => $row["idRequisicao"],
            "dataRequisicao" => $row["dataRequisicao"],
            "om" => $row["om"],
            "idSecao" => $row["Secao_idSecao"],
            "idNotaCredito" => $row["NotaCredito_idNotaCredito"],
            "idCategoria" => $row["Categoria_idCategoria"],
            "modalidade" => $row["modalidade"],
            "numeroModalidade" => $row["numeroModalidade"],
            "ug" => $row["ug"],
            "omModalidade" => $row["omModalidade"],
            "empresa" => $row["empresa"],
            "cnpj" => $row["cnpj"],
            "contato" => $row["contato"],
            "dataNE" => $row["dataNE"],
            "tipoNE" => $row["tipoNE"],
            "tipoNF" => $row["tipoNF"],
            "ne" => $row["ne"],
            "valorNE" => $row["valorNE"],
            "observacaoSALC" => $row["observacaoSALC"],
            "dataEnvioNE" => $row["dataEnvioNE"],
            "valorAnulado" => $row["valorAnulado"],
            "justificativaAnulado" => $row["justificativaAnulado"],
            "valorReforcado" => $row["valorReforcado"],
            "observacaoReforco" => $row["observacaoReforco"],
            "idNotaCreditoReforco" => $row["NotaCredito_idNotaCreditoReforco"],
            "dataParecer" => $row["dataParecer"],
            "parecer" => $row["parecer"],
            "observacaoConformidade" => $row["observacaoConformidade"],
            "dataAssinatura" => $row["dataAssinatura"],
            "dataEnvioNEEmpresa" => $row["dataEnvioNEEmpresa"],
            "dataPrazoEntrega" => $row["dataPrazoEntrega"],
            "diex" => $row["diex"],
            "dataDiex" => $row["dataDiex"],
            "dataOficio" => $row["dataOficio"],
            "observacaoAlmox" => $row["observacaoAlmox"],
            "idProcesso" => $row["Processo_idProcesso"],
            "dataProtocoloSalc1" => $row["dataProtocoloSalc1"],
            "dataProtocoloConformidade" => $row["dataProtocoloConformidade"],
            "dataProtocoloSalc2" => $row["dataProtocoloSalc2"],
            "dataProtocoloAlmox" => $row["dataProtocoloAlmox"],
            "responsavel" => $row["responsavel"],
            "itemList" => ""
        );
    }

}
