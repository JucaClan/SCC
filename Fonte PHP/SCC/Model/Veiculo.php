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
class Veiculo {

    private $id,
            $tipoVeiculo,
            $placa,
            $modelo,
            $cor,
            $nomeCompleto,
            $identidade,
            $destino,
            $dataEntrada,
            $dataSaida;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->tipoVeiculo = $idOrRow["tipoVeiculo"];
            $this->placa = $idOrRow["placa"];
            $this->modelo = $idOrRow["modelo"];
            $this->cor = $idOrRow["cor"];
            $this->nomeCompleto = $idOrRow["nomeCompleto"];
            $this->identidade = $idOrRow["identidade"];
            $this->destino = $idOrRow["destino"];
            $this->dataEntrada = $idOrRow["dataEntrada"];
            $this->dataSaida = $idOrRow["dataSaida"];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getTipoVeiculo() {
        return $this->tipoVeiculo;
    }

    public function getPlaca() {
        return $this->placa;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getCor() {
        return $this->cor;
    }

    public function getNomeCompleto() {
        return $this->nomeCompleto;
    }

    public function getIdentidade() {
        return $this->identidade;
    }

    public function getDestino() {
        return $this->destino;
    }

    public function getDataEntrada() {
        return $this->dataEntrada;
    }

    public function getDataSaida() {
        return $this->dataSaida;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTipoVeiculo($tipoVeiculo) {
        $this->tipoVeiculo = $tipoVeiculo;
    }

    public function setPlaca($placa) {
        $this->placa = $placa;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function setCor($cor) {
        $this->cor = $cor;
    }

    public function setNomeCompleto($nomeCompleto) {
        $this->nomeCompleto = $nomeCompleto;
    }

    public function setIdentidade($identidade) {
        $this->identidade = $identidade;
    }

    public function setDestino($destino) {
        $this->destino = $destino;
    }

    public function setDataEntrada($dataEntrada) {
        $this->dataEntrada = $dataEntrada;
    }

    public function setDataSaida($dataSaida) {
        $this->dataSaida = $dataSaida;
    }

    public function validate() {
        return $this->nome != null && !empty($this->nome);
    }
}
