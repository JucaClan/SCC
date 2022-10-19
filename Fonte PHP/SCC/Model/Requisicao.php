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
            $dataProtocoloSalc1,
            // SALC
            $dataNE,
            $tipoNE,
            $tipoNF,
            $ne,
            $valorNE,
            $observacaoSALC,
            $dataEnvioNE,
            $valorAnulado,
            $justificativaAnulado,
            $valorReforcado,
            $observacaoReforco,
            $idNotaCreditoReforco,
            $dataProtocoloConformidade,
            $dataProtocoloAlmox,
            $responsavel,
            // Conformidade
            $dataParecer,
            $parecer,
            $observacaoConformidade,
            $dataAssinatura,
            $dataProtocoloSalc2,
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
            // Notas Fiscais            
            $hasNFsParaEntrega,
            $hasNFsParaLiquidar,
            $hasNFsParaRemessa,
            // Timeline
            $timeline;

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
            $this->dataProtocoloSalc1 = $idOrRow["dataProtocoloSalc1"];
            // SALC
            $this->dataNE = $idOrRow["dataNE"];
            $this->tipoNE = $idOrRow["tipoNE"];
            $this->tipoNF = $idOrRow["tipoNF"];
            $this->ne = $idOrRow["ne"];
            $this->valorNE = $idOrRow["valorNE"];
            $this->observacaoSALC = $idOrRow["observacaoSALC"];
            $this->dataEnvioNE = $idOrRow["dataEnvioNE"];
            $this->valorAnulado = $idOrRow["valorAnulado"];
            $this->justificativaAnulado = $idOrRow["justificativaAnulado"];
            $this->valorReforcado = $idOrRow["valorReforcado"];
            $this->observacaoReforco = $idOrRow["observacaoReforco"];
            $this->idNotaCreditoReforco = $idOrRow["idNotaCreditoReforco"];
            $this->dataProtocoloConformidade = $idOrRow["dataProtocoloConformidade"];
            $this->dataProtocoloAlmox = $idOrRow["dataProtocoloAlmox"];
            $this->responsavel = $idOrRow["responsavel"];
            // Conformidade
            $this->dataParecer = $idOrRow["dataParecer"];
            $this->parecer = $idOrRow["parecer"];
            $this->observacaoConformidade = $idOrRow["observacaoConformidade"];
            $this->dataAssinatura = $idOrRow["dataAssinatura"];
            $this->dataProtocoloSalc2 = $idOrRow["dataProtocoloSalc2"];
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

    function getIdProcesso() {
        return $this->idProcesso;
    }

    function setIdProcesso($idProcesso) {
        $this->idProcesso = $idProcesso;
    }

    public function getTimeline() {
        return $this->timeline;
    }

    public function setTimeline($timeline) {
        $this->timeline = $timeline;
    }

    public function getHasNFsParaEntrega() {
        return $this->hasNFsParaEntrega;
    }

    public function setHasNFsParaEntrega($hasNFsParaEntrega) {
        $this->hasNFsParaEntrega = $hasNFsParaEntrega;
    }

    public function getHasNFsParaLiquidar() {
        return $this->hasNFsParaLiquidar;
    }

    public function setHasNFsParaLiquidar($hasNFsParaLiquidar) {
        $this->hasNFsParaLiquidar = $hasNFsParaLiquidar;
    }

    public function getHasNFsParaRemessa() {
        return $this->hasNFsParaRemessa;
    }

    public function setHasNFsParaRemessa($hasNFsParaRemessa) {
        $this->hasNFsParaRemessa = $hasNFsParaRemessa;
    }

    function getDataProtocoloSalc1() {
        return $this->dataProtocoloSalc1;
    }

    function getDataProtocoloConformidade() {
        return $this->dataProtocoloConformidade;
    }

    function getDataProtocoloAlmox() {
        return $this->dataProtocoloAlmox;
    }

    function getDataProtocoloSalc2() {
        return $this->dataProtocoloSalc2;
    }

    function setDataProtocoloSalc1($dataProtocoloSalc1) {
        $this->dataProtocoloSalc1 = $dataProtocoloSalc1;
    }

    function setDataProtocoloConformidade($dataProtocoloConformidade) {
        $this->dataProtocoloConformidade = $dataProtocoloConformidade;
    }

    function setDataProtocoloAlmox($dataProtocoloAlmox) {
        $this->dataProtocoloAlmox = $dataProtocoloAlmox;
    }

    function setDataProtocoloSalc2($dataProtocoloSalc2) {
        $this->dataProtocoloSalc2 = $dataProtocoloSalc2;
    }

    public function getTipoNF() {
        return $this->tipoNF;
    }

    public function setTipoNF($tipoNF) {
        $this->tipoNF = $tipoNF;
    }

    public function getResponsavel() {
        return $this->responsavel;
    }

    public function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

}
