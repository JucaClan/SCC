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
class Sped {

    private $id,
            $titulo,
            $prazo,
            $data,
            $responsavel,
            $resolvido,
            $tipo;

    function __construct($idOrRow = 0) {
        if (is_int($idOrRow)) {
            $this->id = $idOrRow;
        } else if (is_array($idOrRow)) {
            $this->id = $idOrRow["id"];
            $this->titulo = $idOrRow["titulo"];
            $this->prazo = $idOrRow["prazo"];
            $this->data = $idOrRow["data"];
            $this->responsavel = $idOrRow["responsavel"];
            $this->resolvido = $idOrRow["resolvido"];
            $this->tipo = $idOrRow["tipo"];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getPrazo() {
        return $this->prazo;
    }

    public function getData() {
        return $this->data;
    }

    public function getResponsavel() {
        return $this->responsavel;
    }

    public function getResolvido() {
        return $this->resolvido;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setPrazo($prazo) {
        $this->prazo = $prazo;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    public function setResolvido($resolvido) {
        $this->resolvido = $resolvido;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function validate() {
        return $this->titulo != null && $this->prazo != null;
    }

}
