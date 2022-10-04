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
require_once '../DAO/ProcessoDAO.php';

class Timeline {

    private $requisitante, $salc1, $conformidade, $salc2, $almox, $tesouraria;
    private $processo;

    function __construct($object = 0) {
        if (!is_null($object)) {
            $processoDAO = new ProcessoDAO();
            $this->processo = $object->getIdProcesso() > 0 ? $processoDAO->getById($object->getIdProcesso()) : null;
            $hoje = new DateTime();
            $dataRequisicao = $object->getDataRequisicao();
            $dataNE = $object->getDataNE();
            $dataParecer = $object->getDataParecer();
            $dataEnvioNE = $object->getDataEnvioNE();
            $dataEnvioNEEmpresa = $object->getDataEnvioNEEmpresa();
            $dataPrazoEntrega = $object->getDataPrazoEntrega();
            $dataOficio = $object->getDataOficio();
            $dataDiex = $object->getDataDiex();
            $dataAssinatura = $object->getDataAssinatura();
            $dataProtocoloSalc1 = $object->getDataProtocoloSalc1();
            $dataProtocoloConformidade = $object->getDataProtocoloConformidade();
            $dataProtocoloSalc2 = $object->getDataProtocoloSalc2();
            $dataProtocoloAlmox = $object->getDataProtocoloAlmox();
            // REQUISITANTE
            if (
                    !empty($object->getDataRequisicao()) &&
                    !empty($object->getOm()) &&
                    !empty($object->getIdSecao()) &&
                    !empty($object->getIdNotaCredito()) &&
                    !empty($object->getIdCategoria()) &&
                    !empty($object->getModalidade()) &&
                    !empty($object->getUg()) &&
                    !empty($object->getOmModalidade()) &&
                    !empty($object->getEmpresa()) &&
                    !empty($object->getCnpj()) &&
                    !empty($object->getContato()) &&
                    !empty($object->getDataProtocoloSalc1())
            ) {
                $dateDif = date_diff(new DateTime($dataProtocoloSalc1), $hoje);
                $this->requisitante = ["Completed", "<div align='center'>Protocolada<br>em " . dateFormat($object->getDataProtocoloSalc1()) . "<br>há " . $dateDif->format('%a') . " dia(s)</div>"];
            } else {
                $this->requisitante = ["Next", "Aguardando..."];
            }
            // SALC1
            if (
                    !empty($object->getDataNE()) &&
                    !empty($object->getNe()) &&
                    !empty($object->getTipoNE()) &&
                    !empty($object->getValorNE()) &&
                    !empty($object->getDataProtocoloConformidade())
            ) {
                $dateDif = date_diff(new DateTime($dataProtocoloSalc1), new DateTime($dataNE));
                $this->salc1 = ["Completed", "<div align='center'>Empenhado em<br>" . dateFormat($dataNE) . "<br>após " . $dateDif->format('%a') . " dia(s)</div>"];
            } else if ($this->requisitante[0] === "Next") {
                $this->salc1 = ["", ""];
            } else if (
                    !empty($object->getDataNE()) &&
                    !empty($object->getNe()) &&
                    !empty($object->getTipoNE()) &&
                    !empty($object->getValorNE()) &&
                    empty($object->getDataProtocoloConformidade())
            ) {
                $dateDif = date_diff(new DateTime($dataProtocoloSalc1), $hoje);
                $this->salc1 = ["Next", "<div align='center'>Aguardando despacho<br>à Conformidade<br>Protocolado na SALC<br>há " . $dateDif->format('%a') . " dia(s)</div>"];
            } else {
                $dateDif = date_diff(new DateTime($dataProtocoloSalc1), $hoje);
                $this->salc1 = ["Next", "<div align='center'>Ociosa há " . $dateDif->format('%a') . " dia(s)</div>"];
            }
            // CONFORMIDADE
            if (
                    !empty($object->getDataParecer()) &&
                    !empty($object->getParecer()) &&
                    !empty($object->getDataAssinatura()) &&
                    !empty($object->getDataProtocoloSalc2())
            ) {
                $dateDif = date_diff(new DateTime($dataProtocoloConformidade), new DateTime($dataParecer));
                $this->conformidade = ["Completed", "<div align='center'>Conformado em<br>" . dateFormat($dataParecer) . "<br>após " . $dateDif->format('%a') . " dia(s)</div>"];
            } else if ($this->salc1[0] === "Next" || $this->salc1[0] === "") {
                $this->conformidade = ["", ""];
            } else if (
                    !empty($object->getDataParecer()) &&
                    !empty($object->getParecer()) &&
                    !empty($object->getDataAssinatura()) &&
                    empty($object->getDataProtocoloSalc2())
            ) {
                $dateDif = date_diff(new DateTime($dataProtocoloConformidade), $hoje);
                $this->conformidade = ["Next", "<div align='center'>Aguardando despacho<br>à SALC<br>Na Conformidade<br>há " . $dateDif->format('%a') . " dia(s)</div>"];
            } else if (
                    !empty($object->getDataParecer()) &&
                    !empty($object->getParecer()) &&
                    empty($object->getDataAssinatura())
            ) {
                $dateDif = date_diff(new DateTime($dataProtocoloConformidade), $hoje);
                $this->conformidade = ["Next", "<div align='center'>Aguardando<br>assinatura do OD<br>Na Conformidade<br>há " . $dateDif->format('%a') . " dia(s)</div>"];
            } else {
                $dateDif = date_diff(new DateTime($dataProtocoloConformidade), $hoje);
                $this->conformidade = ["Next", "<div align='center'>Ociosa há " . $dateDif->format('%a') . " dia(s)</div>"];
            }
            // SALC2
            if (
                    !empty($object->getDataEnvioNE()) &&
                    !empty($object->getDataProtocoloAlmox())
            ) {
                $dateDif = date_diff(new DateTime($dataProtocoloSalc2), new DateTime($dataEnvioNE));
                $this->salc2 = ["Completed", "<div align='center'>NE enviada ao <br>Almox em<br>" . dateFormat($dataEnvioNE) . "<br>após " . $dateDif->format('%a') . " dia(s)</div>"];
            } else if ($this->conformidade[0] === "Next" || $this->conformidade[0] === "") {
                $this->salc2 = ["", ""];
            } else if (
                    !empty($object->getDataEnvioNE()) &&
                    empty($object->getDataProtocoloAlmox())
            ) {
                $dateDif = date_diff(new DateTime($dataProtocoloSalc2), $hoje);
                $this->salc2 = ["Next", "<div align='center'>Aguardando despacho<br>ao Almoxarifado<br>Na SALC<br>há " . $dateDif->format('%a') . " dia(s)</div>"];
            } else {
                $dateDif = date_diff(new DateTime($dataProtocoloSalc2), $hoje);
                $this->salc2 = ["Next", "<div align='center'>Ociosa há " . $dateDif->format('%a') . " dia(s)</div>"];
            }
            // ALMOX
            if (
                    $object->getHasNFsParaEntrega() === false &&
                    $object->getHasNFsParaRemessa() === false
            ) {
                $this->almox = ["Completed", "<div align='center'>Materiais recebidos<br>NFs remetidas<br>à Tesouraria</div>"];
            } else if (
                    $object->getHasNFsParaEntrega() === false &&
                    $object->getHasNFsParaRemessa() === true
            ) {
                $this->almox = ["Next", "<div align='center'>Materiais recebidos<br>NFs ainda não remetidas à Tesouraria</div>"];
            } else if ($this->salc2[0] === "Next" || $this->salc2[0] === "") {
                $this->almox = ["", ""];
            } else if (
                    $object->getHasNFsParaEntrega() === true &&
                    !empty($object->getDataEnvioNEEmpresa() &&
                            empty($object->getDataOficio()))
            ) {
                $dateDif = date_diff(new DateTime($dataProtocoloAlmox), new DateTime($dataEnvioNEEmpresa));
                $dateDif2 = date_diff(new DateTime($dataEnvioNEEmpresa), $hoje);
                $dateDif3 = date_diff($hoje, new DateTime($dataPrazoEntrega));
                $this->almox = ["Next", "<div align='center'>NE Enviada à Empresa após " . $dateDif->format('%a') . " dia(s)<br>Aguardando material há " . $dateDif2->format('%a') . " dia(s)<br>" . ($dateDif3->format('%R') === "-" && $dateDif3->format('%a') > 0 ? "Prazo vencido há " : "Prazo vence em ") . $dateDif3->format('%a') . " dia(s)</div>"];
            } else if (
                    $object->getHasNFsParaEntrega() === true &&
                    !empty($object->getDataEnvioNEEmpresa()) &&
                    !empty($object->getDataOficio()) &&
                    empty($object->getDataDiex())
            ) {
                $dateDif = date_diff(new DateTime($dataEnvioNEEmpresa), new DateTime($dataOficio));
                $this->almox = ["Next", "<div align='center'>Empresa Oficiada<br>após " . $dateDif->format('%a') . " dia(s)<br>do envio da NE à Empresa</div>"];
            } else if (
                    $object->getHasNFsParaEntrega() === true &&
                    !empty($object->getDataEnvioNEEmpresa()) &&
                    !empty($object->getDataOficio()) &&
                    !empty($object->getDataDiex())
            ) {
                $dateDif = date_diff(new DateTime($dataOficio), new DateTime($dataDiex));
                $this->almox = ["Next", "<div align='center'>Solicitado abertura de PA após <br>" . $dateDif->format('%a') . " dia(s) do envio do Ofício" . (!is_null($this->processo) ? "<br><a href='S1Controller.php?action=processo_view&id=" . $this->processo->getId() . "'>PA aberto ( " . $this->processo->getResponsavel() . ")</a></div>" : "")];
            } else {
                $dateDif = date_diff(new DateTime($dataEnvioNE), $hoje);
                $this->almox = ["Next", "<div align='center'>Ociosa há " . $dateDif->format('%a') . " dia(s)</div>"];
            }
            // TESOURARIA
            if (
                    $object->getHasNFsParaLiquidar() === false
            ) {
                $this->tesouraria = ["Completed", "NE Liquidada"];
            } else if ($this->almox[0] === "Next" || $this->almox[0] === "") {
                $this->tesouraria = ["", ""];
            } else if (
                    $this->almox[0] === "Completed" &&
                    $object->getHasNFsParaLiquidar() === true &&
                    !empty($object->getObservacaoAlmox())
            ) {
                $this->tesouraria = ["Next", "Em liquidação"];
            } else {
                $this->tesouraria = ["Next", "Ociosa..."];
            }
        }
    }

    public function getRequisitante() {
        return $this->requisitante;
    }

    public function getSalc1() {
        return $this->salc1;
    }

    public function getConformidade() {
        return $this->conformidade;
    }

    public function getSalc2() {
        return $this->salc2;
    }

    public function getAlmox() {
        return $this->almox;
    }

    public function getTesouraria() {
        return $this->tesouraria;
    }

    public function setRequisitante($requisitante) {
        $this->requisitante = $requisitante;
    }

    public function setSalc1($salc1) {
        $this->salc1 = $salc1;
    }

    public function setConformidade($conformidade) {
        $this->conformidade = $conformidade;
    }

    public function setSalc2($salc2) {
        $this->salc2 = $salc2;
    }

    public function setAlmox($almox) {
        $this->almox = $almox;
    }

    public function setTesouraria($tesouraria) {
        $this->tesouraria = $tesouraria;
    }

    public function getProcesso() {
        return $this->processo;
    }

    public function setProcesso($processo) {
        $this->processo = $processo;
    }

}
