<?php

class Requisicao {

    private // Requisitante
            $id,
            $dataRequisicao,
            $om,
            $idSecao,
            $idNotaCredito,
            $idCategoria,
            $modalidade,
            $numeroModalidade,
            $ug,
            $omModalidade,
            $empresa,
            $cnpj,
            $contato,
            // SALC
            $dataNE,
            $tipoNE,
            $ne,
            $valorNE,
            $observacaoSALC,
            $dataEnvioNE,
            $valorAnulado,
            $justificativaAnulado,
            $valorReforcado,
            $observacaoReforco,
            $idNotaCreditoReforco,
            // Conformidade
            $dataParecer,
            $parecer,
            $observacaoConformidade,
            $dataAssinatura,
            // Almox
            $dataEnvioNEEmpresa,
            $dataPrazoEntrega,
            $diex,
            $dataDiex,
            $dataOficio,
            $observacaoAlmox,
            $idProcesso,
            // Itens
            $itemList,
            // Formatações pré-definidas
            $dataRequisicaoFormatada,
            $dataEnvioNEFormatada,
            $dataNEFormatada;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            // Requisitante
            $this->dataRequisicao = $idOrRow["dataRequisicao"];
            $this->om = $idOrRow["om"];
            $this->idSecao = $idOrRow["idSecao"];
            $this->idNotaCredito = $idOrRow["idNotaCredito"];
            $this->idCategoria = $idOrRow["idCategoria"];
            $this->modalidade = $idOrRow["modalidade"]; //            
            $this->numeroModalidade = $idOrRow["numeroModalidade"];
            $this->ug = $idOrRow["ug"];
            $this->omModalidade = $idOrRow["omModalidade"];
            $this->empresa = $idOrRow["empresa"]; //
            $this->cnpj = $idOrRow["cnpj"];
            $this->contato = $idOrRow["contato"];
            // SALC
            $this->dataNE = $idOrRow["dataNE"];
            $this->tipoNE = $idOrRow["tipoNE"];
            $this->ne = $idOrRow["ne"];
            $this->valorNE = $idOrRow["valorNE"];
            $this->observacaoSALC = $idOrRow["observacaoSALC"];
            $this->dataEnvioNE = $idOrRow["dataEnvioNE"];
            $this->valorAnulado = $idOrRow["valorAnulado"];
            $this->justificativaAnulado = $idOrRow["justificativaAnulado"];
            $this->valorReforcado = $idOrRow["valorReforcado"];
            $this->observacaoReforco = $idOrRow["observacaoReforco"];
            $this->idNotaCreditoReforco = $idOrRow["idNotaCreditoReforco"];
            // Conformidade
            $this->dataParecer = $idOrRow["dataParecer"];
            $this->parecer = $idOrRow["parecer"];
            $this->observacaoConformidade = $idOrRow["observacaoConformidade"];
            $this->dataAssinatura = $idOrRow["dataAssinatura"];
            // Almoxarifado                                              
            $this->dataEnvioNEEmpresa = $idOrRow["dataEnvioNEEmpresa"];
            $this->dataPrazoEntrega = $idOrRow["dataPrazoEntrega"];
            $this->diex = $idOrRow["diex"];
            $this->dataDiex = $idOrRow["dataDiex"];
            $this->dataOficio = $idOrRow["dataOficio"];
            $this->observacaoAlmox = $idOrRow["observacaoAlmox"];
            $this->idProcesso = $idOrRow["idProcesso"];
            // Outros
            $this->itemList = $idOrRow["itemList"];
            $this->dataRequisicaoFormatada = $idOrRow["dataRequisicaoFormatada"];
            $this->dataEnvioNEFormatada = $idOrRow["dataEnvioNEFormatada"];
            $this->dataNEFormatada = $idOrRow["dataNEFormatada"];
        }
    }

    function getId() {
        return $this->id;
    }

    function getDataRequisicao() {
        return $this->dataRequisicao;
    }

    function getOm() {
        return $this->om;
    }

    function getIdSecao() {
        return $this->idSecao;
    }

    function getIdNotaCredito() {
        return $this->idNotaCredito;
    }

    function getIdCategoria() {
        return $this->idCategoria;
    }

    function getModalidade() {
        return $this->modalidade;
    }

    function getNumeroModalidade() {
        return $this->numeroModalidade;
    }

    function getUg() {
        return $this->ug;
    }

    function getOmModalidade() {
        return $this->omModalidade;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function getContato() {
        return $this->contato;
    }

    function getDataNE() {
        return $this->dataNE;
    }

    function getTipoNE() {
        return $this->tipoNE;
    }

    function getNe() {
        return $this->ne;
    }

    function getValorNE() {
        return $this->valorNE;
    }

    function getObservacaoSALC() {
        return $this->observacaoSALC;
    }

    function getDataEnvioNE() {
        return $this->dataEnvioNE;
    }

    function getValorAnulado() {
        return $this->valorAnulado;
    }

    function getJustificativaAnulado() {
        return $this->justificativaAnulado;
    }

    function getValorReforcado() {
        return $this->valorReforcado;
    }

    function getObservacaoReforco() {
        return $this->observacaoReforco;
    }

    function getIdNotaCreditoReforco() {
        return $this->idNotaCreditoReforco;
    }

    function getDataParecer() {
        return $this->dataParecer;
    }

    function getParecer() {
        return $this->parecer;
    }

    function getObservacaoConformidade() {
        return $this->observacaoConformidade;
    }

    function getDataAssinatura() {
        return $this->dataAssinatura;
    }

    function getDataEnvioNEEmpresa() {
        return $this->dataEnvioNEEmpresa;
    }

    function getDataPrazoEntrega() {
        return $this->dataPrazoEntrega;
    }

    function getDiex() {
        return $this->diex;
    }

    function getDataDiex() {
        return $this->dataDiex;
    }

    function getDataOficio() {
        return $this->dataOficio;
    }

    function getObservacaoAlmox() {
        return $this->observacaoAlmox;
    }

    function getItemList() {
        return $this->itemList;
    }

    function getDataRequisicaoFormatada() {
        return $this->dataRequisicaoFormatada;
    }

    function getDataEnvioNEFormatada() {
        return $this->dataEnvioNEFormatada;
    }

    function getDataNEFormatada() {
        return $this->dataNEFormatada;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDataRequisicao($dataRequisicao) {
        $this->dataRequisicao = $dataRequisicao;
    }

    function setOm($om) {
        $this->om = $om;
    }

    function setIdSecao($idSecao) {
        $this->idSecao = $idSecao;
    }

    function setIdNotaCredito($idNotaCredito) {
        $this->idNotaCredito = $idNotaCredito;
    }

    function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    function setModalidade($modalidade) {
        $this->modalidade = $modalidade;
    }

    function setNumeroModalidade($numeroModalidade) {
        $this->numeroModalidade = $numeroModalidade;
    }

    function setUg($ug) {
        $this->ug = $ug;
    }

    function setOmModalidade($omModalidade) {
        $this->omModalidade = $omModalidade;
    }

    function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setContato($contato) {
        $this->contato = $contato;
    }

    function setDataNE($dataNE) {
        $this->dataNE = $dataNE;
    }

    function setTipoNE($tipoNE) {
        $this->tipoNE = $tipoNE;
    }

    function setNe($ne) {
        $this->ne = $ne;
    }

    function setValorNE($valorNE) {
        $this->valorNE = $valorNE;
    }

    function setObservacaoSALC($observacaoSALC) {
        $this->observacaoSALC = $observacaoSALC;
    }

    function setDataEnvioNE($dataEnvioNE) {
        $this->dataEnvioNE = $dataEnvioNE;
    }

    function setValorAnulado($valorAnulado) {
        $this->valorAnulado = $valorAnulado;
    }

    function setJustificativaAnulado($justificativaAnulado) {
        $this->justificativaAnulado = $justificativaAnulado;
    }

    function setValorReforcado($valorReforcado) {
        $this->valorReforcado = $valorReforcado;
    }

    function setObservacaoReforco($observacaoReforco) {
        $this->observacaoReforco = $observacaoReforco;
    }

    function setIdNotaCreditoReforco($idNotaCreditoReforco) {
        $this->idNotaCreditoReforco = $idNotaCreditoReforco;
    }

    function setDataParecer($dataParecer) {
        $this->dataParecer = $dataParecer;
    }

    function setParecer($parecer) {
        $this->parecer = $parecer;
    }

    function setObservacaoConformidade($observacaoConformidade) {
        $this->observacaoConformidade = $observacaoConformidade;
    }

    function setDataAssinatura($dataAssinatura) {
        $this->dataAssinatura = $dataAssinatura;
    }

    function setDataEnvioNEEmpresa($dataEnvioNEEmpresa) {
        $this->dataEnvioNEEmpresa = $dataEnvioNEEmpresa;
    }

    function setDataPrazoEntrega($dataPrazoEntrega) {
        $this->dataPrazoEntrega = $dataPrazoEntrega;
    }

    function setDiex($diex) {
        $this->diex = $diex;
    }

    function setDataDiex($dataDiex) {
        $this->dataDiex = $dataDiex;
    }

    function setDataOficio($dataOficio) {
        $this->dataOficio = $dataOficio;
    }

    function setObservacaoAlmox($observacaoAlmox) {
        $this->observacaoAlmox = $observacaoAlmox;
    }

    function setItemList($itemList) {
        $this->itemList = $itemList;
    }

    function setDataRequisicaoFormatada($dataRequisicaoFormatada) {
        $this->dataRequisicaoFormatada = $dataRequisicaoFormatada;
    }

    function setDataEnvioNEFormatada($dataEnvioNEFormatada) {
        $this->dataEnvioNEFormatada = $dataEnvioNEFormatada;
    }

    function setDataNEFormatada($dataNEFormatada) {
        $this->dataNEFormatada = $dataNEFormatada;
    }

    function getIdProcesso() {
        return $this->idProcesso;
    }

    function setIdProcesso($idProcesso) {
        $this->idProcesso = $idProcesso;
    }

}
