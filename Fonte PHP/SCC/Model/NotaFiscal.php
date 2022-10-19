<?php

class NotaFiscal {

    private $id,
            $tipoNF,
            $nf,
            $codigoVerificacao,
            $chaveAcesso,
            $valorNF,
            $descricao,
            $dataEmissaoNF,
            $dataEntrega,
            $dataRemessaTesouraria,
            $idRequisicao,
            $dataLiquidacao,
            $dataPedido,
            $dataPrazoEntrega,
            $itemList;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->tipoNF = $idOrRow["tipoNF"];
            $this->nf = $idOrRow["nf"];
            $this->codigoVerificacao = $idOrRow["codigoVerificacao"];
            $this->chaveAcesso = $idOrRow["chaveAcesso"];
            $this->valorNF = $idOrRow["valorNF"];
            $this->descricao = $idOrRow["descricao"];
            $this->dataEmissaoNF = $idOrRow["dataEmissaoNF"];
            $this->dataEntrega = $idOrRow["dataEntrega"];
            $this->dataRemessaTesouraria = $idOrRow["dataRemessaTesouraria"];
            $this->idRequisicao = $idOrRow["idRequisicao"];
            $this->dataLiquidacao = $idOrRow["dataLiquidacao"];
            $this->dataPedido = $idOrRow["dataPedido"];
            $this->dataPrazoEntrega = $idOrRow["dataPrazoEntrega"];
        }
    }

    function getId() {
        return $this->id;
    }

    function getTipoNF() {
        return $this->tipoNF;
    }

    function getNf() {
        return $this->nf;
    }

    function getCodigoVerificacao() {
        return $this->codigoVerificacao;
    }

    function getChaveAcesso() {
        return $this->chaveAcesso;
    }

    function getValorNF() {
        return $this->valorNF;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getDataEmissaoNF() {
        return $this->dataEmissaoNF;
    }

    function getDataEntrega() {
        return $this->dataEntrega;
    }

    function getDataRemessaTesouraria() {
        return $this->dataRemessaTesouraria;
    }

    function getIdRequisicao() {
        return $this->idRequisicao;
    }

    function getDataLiquidacao() {
        return $this->dataLiquidacao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipoNF($tipoNF) {
        $this->tipoNF = $tipoNF;
    }

    function setNf($nf) {
        $this->nf = $nf;
    }

    function setCodigoVerificacao($codigoVerificacao) {
        $this->codigoVerificacao = $codigoVerificacao;
    }

    function setChaveAcesso($chaveAcesso) {
        $this->chaveAcesso = $chaveAcesso;
    }

    function setValorNF($valorNF) {
        $this->valorNF = $valorNF;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setDataEmissaoNF($dataEmissaoNF) {
        $this->dataEmissaoNF = $dataEmissaoNF;
    }

    function setDataEntrega($dataEntrega) {
        $this->dataEntrega = $dataEntrega;
    }

    function setDataRemessaTesouraria($dataRemessaTesouraria) {
        $this->dataRemessaTesouraria = $dataRemessaTesouraria;
    }

    function setIdRequisicao($idRequisicao) {
        $this->idRequisicao = $idRequisicao;
    }

    function setDataLiquidacao($dataLiquidacao) {
        $this->dataLiquidacao = $dataLiquidacao;
    }

    function getItemList() {
        return $this->itemList;
    }

    function setItemList($itemList) {
        $this->itemList = $itemList;
    }

    public function getDataPedido() {
        return $this->dataPedido;
    }

    public function getDataPrazoEntrega() {
        return $this->dataPrazoEntrega;
    }

    public function setDataPedido($dataPedido) {
        $this->dataPedido = $dataPedido;
    }

    public function setDataPrazoEntrega($dataPrazoEntrega) {
        $this->dataPrazoEntrega = $dataPrazoEntrega;
    }

}
