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
require_once '../include/global.php';
require_once '../include/comum.php';
require_once '../DAO/VeiculoDAO.php';
require_once '../DAO/SecaoDAO.php';

class S2Controller {

    private $veiculoInstance,     // Model instance to be used by Controller and DAO
            $veiculoDAO;          // DAO instance for database operations                                        
    private $filtro;                // Array of filters to be used by DAO object

    /**
     * Responsible to receive all input form data
     */
    public function getFormData() {
        $dataHoje = date('Y-m-d');
        $dataAmanha = date('Y-m-d', strtotime(' +1 day'));
        $inicio = !empty(filter_input(INPUT_GET, "inicio", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? filter_input(INPUT_GET, "inicio", FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $dataHoje;
        $fim = !empty(filter_input(INPUT_GET, "fim", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? filter_input(INPUT_GET, "fim", FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $dataAmanha;
        $this->filtro = array(
            "inicio" => $inicio,
            "fim" => $fim
        );
        $this->veiculoInstance = new Veiculo();
        $this->veiculoInstance->setId(filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
        $this->veiculoInstance->setTipoVeiculo(filter_input(INPUT_POST, "tipoVeiculo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setPlaca(filter_input(INPUT_POST, "placa", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setModelo(filter_input(INPUT_POST, "modelo", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setCor(filter_input(INPUT_POST, "cor", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setNomeCompleto(filter_input(INPUT_POST, "nomeCompleto", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setIdentidade(filter_input(INPUT_POST, "identidade", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setDestino(filter_input(INPUT_POST, "destino", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setDataEntrada(filter_input(INPUT_POST, "dataEntrada", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES) . " " . filter_input(INPUT_POST, "horaEntrada", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));
        $this->veiculoInstance->setDataSaida(filter_input(INPUT_POST, "dataSaida", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES) . " " . filter_input(INPUT_POST, "horaSaida", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES));       
        $this->mensagem = filter_input(INPUT_POST, "mensagem", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);        
    }

    /**
     * Generate list of everything on database calling the view
     */
    public function getAllList() {
        try {
            $this->getFormData(); // Used to get filters            
            $this->veiculoDAO = new VeiculoDAO();
            $secaoDAO = new SecaoDAO();            
            $objectList = $this->veiculoDAO->getAllList($this->filtro);
            require_once '../View/view_S2_list.php';
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Insert new object on the database or require the view of the form
     */
    public function veiculoInsert() {       
        try {            
            $this->getFormData();
            $this->veiculoDAO = new VeiculoDAO();
            $secaoDAO = new SecaoDAO();     
            if ($this->veiculoInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form                
                if ($this->veiculoDAO->insert($this->veiculoInstance)) {
                    $secaoDAO->updateDataAtualizacao("S2");
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na inserção de dados no banco de dados!");
                }
            } else { // Require the view of the form
                $object = $this->veiculoInstance;
                require_once '../View/view_S2_veiculo_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database or require the view of the form
     */
    public function veiculoUpdate() {
        try {
            $this->getFormData();            
            $this->veiculoDAO = new VeiculoDAO();
            $secaoDAO = new SecaoDAO();            
            if ($this->veiculoInstance->validate()) { // Check if the input form was filled correctly and proceed to DAO or Require de view of the form
                if ($this->veiculoDAO->update($this->veiculoInstance)) {
                    $secaoDAO->updateDataAtualizacao("S2");                    
                    header("Location: " . filter_input(INPUT_POST, "lastURL"));
                } else {
                    throw new Exception("Problema na atualização de dados no banco de dados!<br>O tamanho do arquivo deve ser de no máximo 40 KB e a extensão deve ser .jpg ou .png.");
                }
            } else { // Require the view of the form   
                $this->veiculoInstance = $this->veiculoInstance->getId() > 0 ? $this->veiculoDAO->getById($this->veiculoInstance->getId()) : null;
                $object = $this->veiculoInstance;
                require_once '../View/view_S2_veiculo_edit.php';
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Delete object on the database
     */
    public function veiculoDelete() {
        try {
            $this->getFormData();
            $this->veiculoDAO = new VeiculoDAO();
            $secaoDAO = new SecaoDAO();            
            if ($this->veiculoInstance->getId() != null) {
                if ($this->veiculoDAO->delete($this->veiculoInstance)) {
                    $secaoDAO->updateDataAtualizacao("RP");
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                } else {
                    throw new Exception("Problema na remoção de dados no banco de dados!");
                }
            }
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

    /**
     * Update object on the database
     */
    public function mensagemUpdate() {
        try {
            $this->getFormData();
            $secaoDAO = new SecaoDAO();
            if (!empty($this->mensagem)) {
                $secaoDAO->updateDataAtualizacao("S2", $this->mensagem);
            }
            header("Location: S2Controller.php?action=getAllList");
        } catch (Exception $e) {
            require_once '../View/view_error.php';
        }
    }

}

// POSSIBLE ACTIONS
$action = $_REQUEST["action"];
$controller = new S2Controller();
switch ($action) {            
    case "getAllList":
        !isAdminLevel($LISTAR_S2) ? redirectToLogin() : $controller->getAllList();
        break;
    case "veiculo_insert":           
        !isAdminLevel($ADICIONAR_S2) ? redirectToLogin() : $controller->veiculoInsert();
        break;
    case "veiculo_update":
        !isAdminLevel($EDITAR_S2) ? redirectToLogin() : $controller->veiculoUpdate();
        break;
    case "veiculo_delete":
        !isAdminLevel($EXCLUIR_S2) ? redirectToLogin() : $controller->veiculoDelete();
        break;
    case "mensagem_update":
        !isAdminLevel($EDITAR_S2) ? redirectToLogin() : $controller->mensagemUpdate();
        break;
    default:
        break;
}
?>