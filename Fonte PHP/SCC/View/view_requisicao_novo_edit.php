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
require_once '../include/header.php';
?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="../include/js/jquery-mask/jquery.mask.min.js"></script>
<script type="text/javascript">
    function excluir(id, idRequisicao) {
        if (confirm('Tem certeza que deseja excluir esse item?\n\nAo prosseguir, os dados editados nesse formulário não serão salvos. A página irá recarregar com a exclusão do item, exibindo os últimos dados salvos ao clicar no botão Salvar.')) {
            document.location = 'FiscalizacaoController.php?action=delete_item&idItem=' + id + "&id=" + idRequisicao;
        }
        return false;
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function minimize(id) {
        var object = document.getElementById(id);
        object.style.display = "none";
        document.cookie = id + "=1";
    }

    function maximize(id) {
        var object = document.getElementById(id);
        object.style.display = "";
        document.cookie = id + "=0";
    }

    function minimizeByDefault() {
        minimize('requisitante');
        minimize('salc');
        minimize('conformidade');
        minimize('almoxarifado');
        minimize('tesouraria');
    }

    function maximizeByDefault() {
        maximize('requisitante');
        maximize('salc');
        maximize('conformidade');
        maximize('almoxarifado');
        minimize('tesouraria');
    }
</script>
<style type="text/css">
    .subtitulo {
        font-weight: bold;
    }

    .timeline {
        display: flex;
        align-items: center;
        justify-content: center;
        list-style-type: none;
    }

    .timestamp {
        margin-bottom: 20px;
        padding: 0px 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        color: #ffcccc;
        font-size: 14px;
    }

    .timestampCompleted {
        margin-bottom: 20px;
        padding: 0px 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        color: #00cc00;
        font-size: 14px;
    }

    .timestampNext {
        margin-bottom: 20px;
        padding: 0px 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        color: red;
        font-size: 14px;
    }

    .status {
        padding: 0px 40px;
        display: flex;
        justify-content: center;
        border-top: 2px solid;
        border-right: 2px solid;
        border-bottom: 2px solid;
        border-radius: 70px;
        border-color: #ffcccc;
        height: 80px;
        /*background-color: #ffcccc;*/
    }

    .statusCompleted {
        padding: 0px 40px;
        display: flex;
        justify-content: center;
        border: 2px solid;
        /*        border-left: 2px solid; 
                border-right: 2px solid; */
        border-radius: 70px;
        border-color: #00cc00;
        height: 80px;
        background-color: #ccffcc;
    }

    .statusNext {
        padding: 0px 40px;
        display: flex;
        justify-content: center;
        border-top: 2px solid;
        border-right: 2px solid;
        border-bottom: 2px solid;
        border-radius: 70px;
        border-color: red;
        height: 80px;
        /*background-color: #ffcccc;*/
    }

    .status h4 {
        color: white;
        font-weight: bold;
        font-size: 12px;
        margin-top: 7px;
    }

    .statusCompleted h4 {
        color: #00cc00;
        font-weight: bold;
        font-size: 12px;
        margin-top: 7px;
    }

    .statusNext h4 {
        color: red;
        font-weight: bold;
        font-size: 12px;
        margin-top: 7px;
    }

    .explanation {
        font-size: 12px;
        color: red;
    }
</style>
<div class="conteudo">  
    <form accept-charset="UTF-8" action="../Controller/FiscalizacaoController.php?action=<?= $object->getId() > 0 ? 'update' : 'insert' ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post" name="requisicao" id="requisicao">
        <h2><?= $object->getId() > 0 ? "Editar" : "Cadastrar" ?> Requisição | <a href="#" onclick="document.location = 'FiscalizacaoController.php?action=getAllList';">Voltar</a> | <button type="submit" class="btn btn-success">Salvar</button></h2>    
        <hr> 
        <div>
            <ul class="timeline">
                <li>
                    <div class="timestampNext" id="requisitanteTimestamp">
                        REQUISITANTE
                    </div>
                    <div class="statusNext" id="requisitanteStatus">
                        <h4>Aguardando...</h4>
                    </div>
                </li>
                <li>
                    <div class="timestamp" id="salc1Timestamp">
                        SALC
                    </div>
                    <div class="status" id="salc1Status">
                        <h4></h4>
                    </div>
                </li>
                <li>
                    <div class="timestamp" id="conformidadeTimestamp">
                        CONFORMIDADE
                    </div>
                    <div class="status" id="conformidadeStatus">
                        <h4></h4>
                    </div>
                </li>
                <li>
                    <div class="timestamp" id="salc2Timestamp">
                        SALC
                    </div>
                    <div class="status" id="salc2Status">
                        <h4></h4>
                    </div>
                </li>
                <li>
                    <div class="timestamp" id="almoxarifadoTimestamp">
                        ALMOXARIFADO
                    </div>
                    <div class="status" id="almoxarifadoStatus">
                        <h4></h4>
                    </div>
                </li>
                <li>
                    <div class="timestamp" id="tesourariaTimestamp">
                        TESOURARIA
                    </div>
                    <div class="status" id="tesourariaStatus">
                        <h4></h4>
                    </div>
                </li>
            </ul>
        </div>  
        <?php
        $readonly = true;
        if ($object->getIdSecao() > 0) { // Verifica se há seção definida no objeto
            $secao = $secaoDAO->getById($object->getIdSecao());
            $isOwner = isAdminLevel(array($secao->getSecao())); // Verifica se o usuário é dono da requisição
        } else {
            $isOwner = true; // Como não há seção definida no objeto, trata-se de uma adição, logo o usuário é dono da requisição
        }
        if (isAdminLevel($REQUISITANTES) && $isOwner) { // Verifica se é requisitante e se é o dono
            $readonly = false;
        }
        ?>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">            
            <h2 class="alert alert-info">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('requisitante');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('requisitante');"> 
                REQUISITANTE
            </h2>
            <div id="requisitante">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data Requisição</span>
                                <input type="date" class="form-control" id="dataRequisicao" name="dataRequisicao" value="<?= $object->getDataRequisicao() ?>" required <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data em que a requisição foi feita pela Seção Requisitante.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">OM</span>                        
                                <select class="form-control" name="om" required <?= !$readonly ? "" : "disabled" ?>>
                                    <option value="2becmb" <?= $object->getOm() === "2becmb" ? "selected" : "" ?>>2º BE Cmb</option>
                                    <option value="11cia" <?= $object->getOm() === "11cia" ? "selected" : "" ?>>11ª Cia E Cmb L</option>
                                    <option value="12cia" <?= $object->getOm() === "12cia" ? "selected" : "" ?>>12ª Cia E Cmb L</option>
                                </select>
                            </div>                    
                        </div>   
                        <div class="col">
                            <span class="explanation">Organização Militar responsável pelo empenho.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Seção</span>                        
                                <select class="form-control" name="idSecao" required <?= !$readonly ? "" : "disabled" ?>>
                                    <?php
                                    if (!empty($secaoList) && $secaoList != null) {
                                        foreach ($secaoList as $secao) {
                                            if ($object->getIdSecao() > 0) {
                                                ?>
                                                <option value="<?= $secao->getId() ?>" <?= $secao->getId() == $object->getIdSecao() ? "selected" : "" ?>><?= $secao->getSecao() ?></option>
                                                <?php
                                            } else { // First section that the user belongs will be used by default
                                                if (!isset($_SESSION["sccsecoes"][0])) {
                                                    throw new Exception("Seção indefinida!");
                                                }
                                                ?>
                                                <option value="<?= $secao->getId() ?>" <?= $secao->getSecao() == $_SESSION["sccsecoes"][0]->getSecao() ? "selected" : "" ?>><?= $secao->getSecao() ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>                    
                        </div> 
                        <div class="col">
                            <span class="explanation">Seção responsável pela requisição.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nota de Crédito</span>
                                <select class="form-control" name="idNotaCredito" required <?= !$readonly ? "" : "disabled" ?>>
                                    <option value="" disabled required <?= $object->getIdNotaCredito() > 0 ? "" : " selected"; ?>>Selecione uma nota de crédito</option>
                                    <?php
                                    $notaCreditoList = $notaCreditoDAO->getAllList();
                                    if (!empty($notaCreditoList) && $notaCreditoList != null) {
                                        foreach ($notaCreditoList as $notaCredito) {
                                            ?>
                                            <option value="<?= $notaCredito->getId() ?>" <?= $notaCredito->getId() == $object->getIdNotaCredito() ? " selected" : "" ?>><?= $notaCredito->getNc() ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Nota de crédito cadastrada pela SALC.</span>
                        </div>
                    </div>
                </div>                
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Categoria</span>
                                <select class="form-control" name="idCategoria" required <?= !$readonly ? "" : "disabled" ?>>
                                    <option value="" disabled required <?= $object->getIdCategoria() > 0 ? "" : " selected" ?>>Escolha uma categoria para requisição</option>
                                    <?php
                                    if (!empty($categoriaList) && $categoriaList != null) {
                                        foreach ($categoriaList as $categoria) {
                                            ?>
                                            <option value="<?= $categoria->getId() ?>" <?= $categoria->getId() == $object->getIdCategoria() ? " selected" : "" ?>><?= $categoria->getCategoria() ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation">Categoria a que se refere o empenho, cadastrada pelo Almoxarifado.</span>
                        </div>
                    </div>
                </div>        
                <h2 class="subtitulo">Dados da modalidade de compra</h2>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Modalidade</span>
                                <select name="modalidade" class="form-control" required <?= !$readonly ? "" : "disabled" ?>>
                                    <option value="" disabled required <?= !empty($object->getModalidade()) ? "" : " selected" ?>>Escolha uma modalidade para requisição</option>
                                    <option value="pe" <?= $object->getModalidade() === "pe" ? "selected" : "" ?>>Pregão Eletrônico</option>
                                    <option value="ce" <?= $object->getModalidade() === "ce" ? "selected" : "" ?>>Cotação Eletrônica</option>
                                </select>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Modalidade da compra usada para empenho.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Identificador da modalidade</span>
                                <input type="text" class="form-control" id="numeroModalidade" placeholder="" name="numeroModalidade" maxlength="7" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" value="<?= $object->getNumeroModalidade() ?>" required  <?= !$readonly ? "" : "disabled" ?>/>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Número do pregão, cotação eletrônica ou outra modalidade.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row"> 
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Unidade Gestora</span>
                                <input type="text" class="form-control" id="ug" placeholder="Unidade Gestora" name="ug" maxlength="6" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" value="<?= $object->getUg() ?>" required <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">UASG da unidade Gestora da modalidade.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row"> 
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Organização Militar da modalidade</span>
                                <input type="text" class="form-control" id="omModalidade" placeholder="Organização Militar" name="omModalidade" maxlength="125" value="<?= $object->getOmModalidade() ?>" required <?= !$readonly ? "" : "disabled" ?> />
                            </div>                             
                        </div>
                        <div class="col">
                            <span class="explanation">Organização Militar responsável pela modalidade.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Empresa</span>
                                <input type="text" class="form-control" id="empresa" placeholder="Nome da Empresa" name="empresa" maxlength="250" value="<?= $object->getEmpresa() ?>" required <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Nome da empresa responsável pelos materiais.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row"> 
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">CNPJ</span>
                                <input type="text" class="form-control" id="cnpj" placeholder="CNPJ" name="cnpj" maxlength="18"  onkeypress="return event.charCode >= 48 && event.charCode <= 57;" value="<?= $object->getCnpj() ?>" required <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">CNPJ da empresa responsável pelos materiais.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Contato</span>
                                <textarea class="form-control" name="contato" placeholder="Informações de contato com a empresa" maxlength="520" required <?= !$readonly ? "" : "disabled" ?>><?= $object->getContato() ?></textarea>
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation">Informações de contato da empresa responsável pelos materiais.</span>
                        </div>
                    </div>
                </div>                
            </div>
        </div>        
        <br>        
        <?php
        $readonly = true;
        if (isAdminLevel($SALC)) {
            $readonly = false;
        }
        ?>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">                  
            <h2 class="alert alert-info">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('salc');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('salc');"> 
                SALC
            </h2>
            <div id="salc">
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data NE</span>
                                <input type="date" class="form-control" id="dataNE" name="dataNE" value="<?= $object->getDataNE() ?>" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data da Nota de Empenho pela SALC.</span>
                        </div>
                    </div>                    
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                        
                            <div class="form-check form-check-inline">    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Tipo</span>
                                </div>
                                &nbsp;&nbsp;<input type="radio" class="form-check-input" id="tipoNE" name="tipoNE" value="ordinario" <?= $object->getTipoNE() == "ordinario" ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>/> 
                                <label class="form-check-label">Ordinário</label> 
                            </div>
                            <div class="form-check form-check-inline"> 
                                <input type="radio" class="form-check-input" id="tipoNE" name="tipoNE" value="global" <?= $object->getTipoNE() == "global" ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>/> 
                                <label class="form-check-label">Global/Estimativa</label>                
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation">Tipo da Nota de Empenho.</span>
                        </div>
                    </div>
                </div>                                
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">
                            <div class="input-group-prepend">
                                <span class="input-group-text">NE</span>
                                <input type="text" class="form-control" id="ne" placeholder="Nota de Empenho" name="ne" maxlength="12" onkeypress="return event.charCode === 78 || event.charCode === 69 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getNe() ?>" <?= !$readonly ? "" : "disabled" ?>/>
                            </div>  
                        </div>
                        <div class="col">
                            <span class="explanation">Número da Nota de Empenho.</span>
                        </div>
                    </div> 
                </div>
                <h2 class="subtitulo">Itens</h2>
                <div id="itensInseridos" style="margin: 7px;">                    
                    <table border="0" cellpadding="7" cellspacing="0" width="100%">
                        <tr>
                            <th>Número do item</th>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>Valor</th>
                            <th>&nbsp;</th>
                        </tr>
                        <?php
                        $totalValue = 0;
                        if (isset($itemList) && is_array($itemList) && isAdminLevel($LISTAR_FISCALIZACAO)) {
                            foreach ($itemList as $item) {
                                $totalValue += floatval($item->getValor()) * intval($item->getQuantidade());
                                ?> 
                                <tr>
                                    <td width="10%"><?= $item->getNumeroItem() ?></td>
                                    <td width="60%"><?= $item->getDescricao() ?></td>
                                    <td width="10%"><?= $item->getQuantidade() ?></td>
                                    <td width="10%"><?= $item->getValor() ?></td>
                                    <td width="10%"><input type="button" class="btn btn-danger" value="Excluir" onclick="excluir(<?= $item->getId() . ", " . $object->getId() ?>);" <?= !$readonly ? "" : "disabled" ?>></td> 
                                    <?php
                                }
                            }
                            ?>
                    </table>
                </div>
                <div>
                    <div class="form-group">
                        <div class="form-row">                
                            <div class="col">                    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Número do item</span>
                                    <input type="number" class="form-control" id="numeroItem" name="numeroItem" maxlength="7" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" <?= !$readonly ? "" : "disabled" ?> />
                                </div>                          
                            </div>                       
                            <div class="col">                    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Descrição</span>
                                    <input type="text" class="form-control" id="descricao" name="descricaoItem" maxlength="500" <?= !$readonly ? "" : "disabled" ?> />
                                </div>                    
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Valor</span>
                                    <input type="text" class="form-control" id="valor" name="valor" maxlength="25" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" onchange="fillValor();" <?= !$readonly ? "" : "disabled" ?> />
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Quantidade</span>
                                    <input type="number" class="form-control" id="quantidade" name="quantidade" maxlength="25" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onchange="fillValor();" <?= !$readonly ? "" : "disabled" ?> />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="itens">
                </div>
                <script type="text/javascript">
                    var total = 0;
                    function adicionarItens() {
                        total++;
                        var itens = document.getElementById("itens");
                        var novoItem = "";
                        novoItem += "<hr><div class = 'form-group'><div class = 'form-row'><div class = 'col'>";
                        novoItem += "<div class = 'input-group-prepend'><span class = 'input-group-text'>Número do item</span>";
                        novoItem += "<input type='hidden' id='idItem' name='idItem" + total + "' value=''/><input type = 'number' class = 'form-control' id = 'numeroItem" + total + "' name = 'numeroItem" + total + "' maxlength = '7'/>";
                        novoItem += "</div></div>"
                        novoItem += "<div class = 'col'>";
                        novoItem += "<div class = 'input-group-prepend'><span class = 'input-group-text'>Descrição</span><input type = 'text' class = 'form-control' id = 'descricaoItem" + total + "' name = 'descricaoItem" + total + "' maxlength = '500' /></div></div></div></div>";
                        novoItem += "<div class = 'form-group'><div class = 'form-row'><div class = 'col'>";
                        novoItem += "<div class = 'input-group-prepend'><span class = 'input-group-text'>Valor</span><input type = 'text' class = 'form-control' id = 'valor" + total + "' name = 'valor" + total + "' maxlength = '25' onkeypress='return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);' onchange='fillValor();' /></div></div>";
                        novoItem += "<div class = 'col'>";
                        novoItem += "<div class = 'input-group-prepend'><span class = 'input-group-text'>Quantidade</span><input type = 'number' class = 'form-control' id = 'quantidade" + total + "' name = 'quantidade" + total + "' maxlength = '25' onkeypress='return event.charCode >= 48 && event.charCode <= 57;' onchange='fillValor();' /></div></div></div></div>";
                        itens.innerHTML = itens.innerHTML + novoItem;
                    }

                    function fillValor() {
                        var valor = parseFloat(document.getElementById("valor").value.replace(",", "."));
                        var quantidade = parseInt(document.getElementById("quantidade").value.replace(",", "."));
                        var totalValue = <?= $totalValue ?> + (valor * quantidade);
                        for (i = 1; i <= total; i++) {
                            valor = parseFloat(document.getElementById("valor" + i).value.replace(",", "."));
                            quantidade = parseInt(document.getElementById("quantidade" + i).value.replace(",", "."));
                            totalValue = parseFloat(totalValue) + (valor * quantidade);
                        }
                        document.getElementById("valorNE").value = totalValue.toString().replace(".", ",");
                    }
                </script>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">  
                            <a onclick="adicionarItens();
                               " style="color: blue;
                               text-decoration: underline;
                               " <?= !$readonly ? "" : "disabled" ?>>Adicionar mais itens</a>
                        </div>                                             
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Valor Total R$</span>
                                <input type="text" class="form-control" id="valorNE" name="valorNE" maxlength="11" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getValorNE(); ?>" placeholder="Valor empenhado da nota de empenho" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>  
                        <div class="col">
                            <span class="explanation">Valor empenhado pela SALC até o momento.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Observação</span>
                                <textarea class="form-control" id="observacaoSALC" name="observacaoSALC" maxlength="520" <?= !$readonly ? "" : "disabled" ?>><?= $object->getObservacaoSALC(); ?></textarea>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Observações relativas aos procedimentos da SALC.</span>
                        </div>
                    </div>                    
                </div>                                                                              
            </div>
        </div>
        <br>        
        <?php
        $readonly = true;
        if (isAdminLevel($CONFORMIDADE)) {
            $readonly = false;
        }
        ?>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">
            <h2 class="alert alert-info">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('conformidade');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('conformidade');"> 
                CONFORMIDADE
            </h2>
            <div id="conformidade">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data</span> 
                                <input type="date" class="form-control" name="dataParecer" value="<?= $object->getDataParecer() ?>" <?= !$readonly ? "" : "disabled" ?>>
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation">Data do parecer da Conformidade.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Parecer</span>
                                &nbsp;
                                <input type="radio" id="parecer" name="parecer" value="1" <?= $object->getParecer() == 1 ? " checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>/> Aprovado &nbsp;
                                <input type="radio" id="parecer" name="parecer" value="0" <?= $object->getParecer() == 0 ? " checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>/> Desaprovado
                            </div>                    
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Observação</span>
                                <textarea class="form-control" id="observacaoConformidade" name="observacaoConformidade" maxlength="520" <?= !$readonly ? "" : "disabled" ?>><?= $object->getObservacaoConformidade(); ?></textarea>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Observações da Seção de Conformidade e Gestão.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data da assinatura do OD</span> 
                                <input type="date" class="form-control" name="dataAssinatura" value="<?= $object->getDataAssinatura() ?>" <?= !$readonly ? "" : "disabled" ?>>
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation">Data da assinatura do Ordernador de Despesas.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br> 
        <?php
        $readonly = true;
        if (isAdminLevel($SALC)) {
            $readonly = false;
        }
        ?>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">                  
            <h2 class="alert alert-info">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('salc2');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('salc2');"> 
                SALC
            </h2>
            <div id="salc2">                                                                                   
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data de Envio NE</span>
                                <input type="date" class="form-control" id="dataEnvioNE" name="dataEnvioNE" value="<?= $object->getDataEnvioNE() ?>" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data de envio da Nota de Empenho pela SALC ao Almoxarifado.</span>
                        </div>
                    </div>                    
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                        
                            <div class="form-check form-check-inline">    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Houve anulação de valores?</span>
                                </div>
                                &nbsp;&nbsp;<input type="radio" class="form-check-input" id="anulou" name="anulou" value="1" <?= !empty($object->getValorAnulado()) && $object->getValorAnulado() > 0 ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?> onclick="checkVA(this.value);" /> 
                                <label class="form-check-label">Sim</label> 
                            </div>
                            <div class="form-check form-check-inline"> 
                                <input type="radio" class="form-check-input" id="anulou" name="anulou" value="0" <?= empty($object->getValorAnulado()) || $object->getValorAnulado() == 0 ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>  onclick="checkVA(this.value);" /> 
                                <label class="form-check-label">Não</label>                
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="valorAnuladoField" style="display: <?= !empty($object->getValorAnulado()) && $object->getValorAnulado() > 0 ? "" : "none;" ?>">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Valor anulado</span>
                                <input type="text" class="form-control" id="valorAnulado" name="valorAnulado" maxlength="11" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getValorAnulado(); ?>" placeholder="Valor anulado da nota de empenho" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>  
                        <div class="col">
                            <span class="explanation">Valor anulado pela SALC até o momento.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="justificativaField" style="display: <?= !empty($object->getValorAnulado()) && $object->getValorAnulado() > 0 ? "" : "none;" ?>">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Justificativa</span>
                                <textarea class="form-control" id="justificativaAnulado" name="justificativaAnulado" maxlength="520" <?= !$readonly ? "" : "disabled" ?>><?= $object->getJustificativaAnulado(); ?></textarea>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Justificativas relativas aos procedimentos de valores anulados pela SALC.</span>
                        </div>
                    </div>                    
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                        
                            <div class="form-check form-check-inline">    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Houve reforço de valores?</span>
                                </div>
                                &nbsp;&nbsp;<input type="radio" class="form-check-input" id="reforcou" name="reforcou" value="1" <?= !empty($object->getValorReforcado()) && $object->getValorReforcado() > 0 ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?> onclick="checkRV(this.value);" /> 
                                <label class="form-check-label">Sim</label> 
                            </div>
                            <div class="form-check form-check-inline"> 
                                <input type="radio" class="form-check-input" id="reforcou" name="reforcou" value="0" <?= empty($object->getValorReforcado()) || $object->getValorReforcado() == 0 ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>  onclick="checkRV(this.value);" /> 
                                <label class="form-check-label">Não</label>                
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="valorReforcoField" style="display: <?= !empty($object->getValorReforcado()) && $object->getValorReforcado() > 0 ? "" : "none;" ?>">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Valor reforçado</span>
                                <input type="text" class="form-control" id="valorReforcado" name="valorReforcado" maxlength="11" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" value="<?= $object->getValorReforcado(); ?>" placeholder="Valor reforçado" <?= !$readonly ? "" : "disabled" ?> />
                            </div>                    
                        </div>  
                        <div class="col">
                            <span class="explanation">Valor reforçado pela SALC até o momento.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="observacoesReforcoField" style="display: <?= !empty($object->getValorReforcado()) && $object->getValorReforcado() > 0 ? "" : "none;" ?>">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Observações</span>
                                <textarea class="form-control" id="observacaoReforco" name="observacaoReforco" maxlength="520" <?= !$readonly ? "" : "disabled" ?>><?= $object->getObservacaoReforco(); ?></textarea>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Observações relativas aos procedimentos de valores reforçados pela SALC.</span>
                        </div>
                    </div>                    
                </div>
                <div class="form-group" id="idNotaCreditoField" style="display: <?= !empty($object->getValorReforcado()) && $object->getValorReforcado() > 0 ? "" : "none;" ?>">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nota de Crédito Reforço</span>
                                <select class="form-control" name="idNotaCreditoReforco" <?= !$readonly ? "" : "disabled" ?>>
                                    <option value="" disabled <?= $object->getIdNotaCreditoReforco() > 0 ? "" : "selected"; ?>>Selecione uma nota de crédito</option>
                                    <?php
                                    $notaCreditoReforcoList = $notaCreditoDAO->getAllList();
                                    if (!empty($notaCreditoReforcoList) && $notaCreditoReforcoList != null) {
                                        foreach ($notaCreditoReforcoList as $notaCredito) {
                                            ?>
                                            <option value="<?= $notaCredito->getId() ?>" <?= $notaCredito->getId() == $object->getIdNotaCreditoReforco() ? " selected" : "" ?>><?= $notaCredito->getNc() ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Nota de crédito usada para o reforço.</span>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <br>
        <?php
        $readonly = true;
        if (isAdminLevel($ALMOXARIFADO) || isAdminLevel($TESOURARIA)) {
            $readonly = false;
        }
        ?>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">
            <h2 class="alert alert-info">
                <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('almoxarifado');"> 
                <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('almoxarifado');"> 
                ALMOXARIFADO
            </h2>   
            <div id="almoxarifado">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data de envio NE à empresa</span>
                                <input type="date" class="form-control" id="dataEnvioNEEmpresa" name="dataEnvioNEEmpresa" value="<?= $object->getDataEnvioNEEmpresa(); ?>"/>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data de envio da Nota de Empenho à empresa</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Prazo para entrega do material/serviço</span>
                                <?php
                                $dataPrazoEntrega = $object->getDataEnvioNEEmpresa(); // ToDo            
                                $dataPrazoEntrega = strval($dataPrazoEntrega);
                                $novaData = new DateTime("$dataPrazoEntrega");
                                $novaData->add(new DateInterval('P30D'));
                                $dataPrazoEntrega = $novaData->format('Y-m-d');
                                $dataPrazoEntrega = empty($object->getDataPrazoEntrega()) ? $dataPrazoEntrega : $object->getDataPrazoEntrega();
                                // Caso sejam empenhos não ordinários, o prazo de entrega pode se estender por muito mais de 30 dias
                                ?>
                                <input type="date" class="form-control" id="dataPrazoEntrega" name="dataPrazoEntrega" value="<?= $dataPrazoEntrega ?>" />
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Prazo para entrega do material/serviço.</span>
                        </div>
                    </div>
                </div>            
                <div class="form-group">
                    <div class="form-row">                                    
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data do 1º Ofício de notificação à empresa</span>
                                <input type="date" class="form-control" id="dataOficio" name="dataOficio" value="<?= $object->getDataOficio(); ?>"/>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data do 1º Ofício de Notificação à empresa.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">                
                        <div class="col">                        
                            <div class="form-check form-check-inline">    
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Houve abertura de Processo Administrativo?</span>
                                </div>
                                &nbsp;&nbsp;<input type="radio" class="form-check-input" id="abriuPA" name="abriuPA" value="1" <?= !empty($object->getDiex()) ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?> onclick="checkPA(this.value);" /> 
                                <label class="form-check-label">Sim</label> 
                            </div>
                            <div class="form-check form-check-inline"> 
                                <input type="radio" class="form-check-input" id="abriuPA" name="abriuPA" value="0" <?= empty($object->getDiex()) ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>  onclick="checkPA(this.value);" /> 
                                <label class="form-check-label">Não</label>                
                            </div>
                        </div>
                        <div class="col">
                            <span class="explanation"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="diexField" style="display: <?= !empty($object->getDiex()) ? "" : "none;" ?>">
                    <div class="form-row">                
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">DIEx solicitando abertura de PA</span>
                                <input type="text" class="form-control" id="diex" name="diex" maxlength="125" value="<?= $object->getDiex(); ?>"/>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Número DIEx solicitando abertura de Processo Administrativo.</span>
                        </div>                                               
                    </div>
                </div>
                <div class="form-group" id="dataDiexField" style="display: <?= !empty($object->getDiex()) ? "" : "none;" ?>">
                    <div class="form-row">                                    
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data do DIEx solicitando abertura de PA</span>
                                <input type="date" class="form-control" id="dataDiex" name="dataDiex" value="<?= $object->getDataDiex(); ?>"/>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data do DIEx solicitando abertura de Processo Administrativo.</span>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="idProcessoField" style="display: <?= !empty($object->getDiex()) ? "" : "none;" ?>">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Processo Administrativo <?= $object->getIdProcesso() ?></span>
                                <select name="idProcesso" class="form-control">
                                    <option>Selecione o processo administrativo</option>
                                    <?php
                                    if (!empty($processoList) && $processoList != null) {
                                        foreach ($processoList as $processo) {
                                            ?>
                                            <option value="<?= $processo->getId() ?>" <?= $processo->getId() == $object->getIdProcesso() ? "selected" : "" ?>><?= $processo->getPortaria() ?> - <?= $processo->getTipo() ?> ( <?= $processo->getAssunto() ?>) - <?= $processo->getResponsavel() ?></option>                             
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Processo Administrativo aberto para apuração.</span>
                        </div>                                                
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Observação</span>
                                <textarea class="form-control" id="observacaoAlmox" name="observacaoAlmox" maxlength="520" <?= !$readonly ? "" : "disabled" ?>><?= $object->getObservacaoAlmox(); ?></textarea>
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Observações relativas ao Almoxarifado.</span>
                        </div>
                    </div>
                </div>            
                <a name="notasFiscais">&nbsp;</a>                
                <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">
                    <h2 class="alert alert-info">
                        <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('tesouraria');"> 
                        <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('tesouraria');"> 
                        ALMOXARIFADO / TESOURARIA
                    </h2>
                    <div id="tesouraria">                                                                            
                        <table class="table table-bordered" id="notasCredito">
                            <thead>                            
                                <tr>
                                    <th>Tipo NF</th>   
                                    <th>NF</th>
                                    <th>Valor NF</th>
                                    <th>Data Entrega</th>
                                    <th>Data Remessa Tesouraria</th>                             
                                    <th>Data Liquidação</th>                                
                                    <th>
                                        <?php if (isAdminLevel($ADICIONAR_FISCALIZACAO)) { ?>
                                            <a href="../Controller/FiscalizacaoController.php?action=insert_nf&idRequisicao=<?= $object->getId(); ?>"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                                        <?php } ?>
                                    </th>                
                                </tr>
                            </thead>        
                            <tbody>
                                <?php
                                if (isset($notaFiscalList) && is_array($notaFiscalList) && isAdminLevel($LISTAR_FISCALIZACAO)) {
                                    foreach ($notaFiscalList as $object) {
                                        ?> 
                                        <tr>
                                            <td><?= $object->getTipoNF() ?></td>
                                            <td><?= $object->getNf() ?></td>
                                            <td><?= $object->getValorNF() ?></td>
                                            <td><?= $object->getDataEntrega() ?></td>
                                            <td><?= $object->getDataRemessaTesouraria() ?></td>
                                            <td><input type="hidden" name="dataLiquidacao" value="<?= $object->getDataLiquidacao() ?>"><?= $object->getDataLiquidacao() ?></td>                               
                                            <td>
                                                <?php if (isAdminLevel($EDITAR_FISCALIZACAO)) { ?>
                                                    <a href="../Controller/FiscalizacaoController.php?action=update_nf&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                                                <?php } ?>
                                                <?php if (isAdminLevel($EXCLUIR_FISCALIZACAO)) { ?>
                                                    <a href="../Controller/FiscalizacaoController.php?action=delete_nf&id=<?= $object->getId() ?>"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
                                                <?php } ?>
                                            </td>               
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>        
        <div class="form-group" align="center">
            <input type="submit" class="btn btn-success" value="Salvar"/>
            <input type="button" class="btn btn-danger" value="Fechar" onclick="document.location = 'FiscalizacaoController.php?action=getAllList';"/>
        </div>
    </form>
</div>
<script>
    // Disable form submissions if there are invalid fields
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Get the forms we want to add validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    String.prototype.reverse = function () {
        return this.split('').reverse().join('');
    };

    $(document).ready(function () {
        $('[name=cnpj]').mask('00.000.000/0000-00');
        $('[name=ne]').mask('0000NE000000');
    });

    var secoes = ["requisitante", "salc", "conformidade", "salc2", "almoxarifado", "tesouraria"];
    for (i = 0; i < secoes.length; i++) {
        if (getCookie(secoes[i]) === "1") {
            minimize(secoes[i]);
        }
    }

    function setTimelineStatus(cell, status) {
        var cellNameStatus = cell + "Status";
        document.getElementById(cellNameStatus).innerHTML = "<h4>" + status + "</h4>";
    }

    function completeTimeline(cell) {
        var timeline = ["requisitante", "salc1", "conformidade", "salc2", "almoxarifado", "tesouraria"];
        var cellNameTimestamp, cellNameStatus, timestamp, status;
        cellNameTimestamp = cell + "Timestamp";
        cellNameStatus = cell + "Status";
        timestamp = document.getElementById(cellNameTimestamp);
        status = document.getElementById(cellNameStatus);
        timestamp.className = "timestampCompleted";
        status.className = "statusCompleted";
        cellIndex = timeline.indexOf(cell);
        if (cellIndex < timeline.length - 1) {
            cell = timeline[++cellIndex];
            cellNameTimestamp = cell + "Timestamp";
            cellNameStatus = cell + "Status";
            timestamp = document.getElementById(cellNameTimestamp);
            status = document.getElementById(cellNameStatus);
            timestamp.className = "timestampNext";
            status.className = "statusNext";
            setTimelineStatus(cell, "Aguardando...");
        }
    }

    function checkIfReady(fields) {
        var ready = true;
        for (i = 0; i < fields.length; i++) {
            var needle = document.forms["requisicao"][fields[i]].value;
            if (needle === "") {
                ready = false;
            }
        }
        return ready;
    }

    function fillTimeline() {
        var requisitanteFields = ["dataRequisicao", "om", "idSecao", "idNotaCredito", "idCategoria", "modalidade", "ug", "omModalidade", "empresa", "cnpj", "contato"];
        var salc1Fields = ["dataNE", "ne", "tipoNE", "valorNE"];
        var conformidadeFields = ["dataParecer", "parecer"];
        var salc2Fields = ["dataEnvioNE"];
        var almoxarifadoFields = ["dataEnvioNEEmpresa"];
        var tesourariaFields = ["dataLiquidacao"];
        if (checkIfReady(requisitanteFields)) {
            completeTimeline("requisitante");
            setTimelineStatus("requisitante", "Requisição feita");
        }
        if (checkIfReady(salc1Fields)) {
            completeTimeline("salc1");
            setTimelineStatus("salc1", "Empenhado");
        }
        if (checkIfReady(conformidadeFields)) {
            completeTimeline("conformidade");
            setTimelineStatus("conformidade", "Conformidade OK");
        }
        if (checkIfReady(salc2Fields)) {
            completeTimeline("salc2");
            setTimelineStatus("salc2", "Enviado ao Almoxarifado");
        }
        if (checkIfReady(almoxarifadoFields)) {
            completeTimeline("almoxarifado");
            setTimelineStatus("almoxarifado", "Enviado à Empresa");
        }
        if (checkIfReady(tesourariaFields)) {
            completeTimeline("tesouraria");
            setTimelineStatus("tesouraria", "NFs Liquidadas");
        }
    }

    fillTimeline();

    function checkPA(abriuPA) {
        var diex = document.getElementById("diexField");
        var dataDiex = document.getElementById("dataDiexField");
        var idProcesso = document.getElementById("idProcessoField");
        if (abriuPA === "1") {
            diex.style.display = "";
            dataDiex.style.display = "";
            idProcesso.style.display = "";
        } else if (abriuPA === "0") {
            diex.style.display = "none";
            dataDiex.style.display = "none";
            idProcesso.style.display = "none";
        } else {
            diex.style.display = "none";
            dataDiex.style.display = "none";
            idProcesso.style.display = "none";
        }
    }

    function checkVA(anulou) {
        var valorAnulado = document.getElementById("valorAnuladoField");
        var justificativa = document.getElementById("justificativaField");
        if (anulou === "1") {
            valorAnulado.style.display = "";
            justificativa.style.display = "";
        } else if (anulou === "0") {
            valorAnulado.style.display = "none";
            justificativa.style.display = "none";
        } else {
            valorAnulado.style.display = "none";
            justificativa.style.display = "none";
        }
    }

    function checkRV(reforcou) {
        var valorReforco = document.getElementById("valorReforcoField");
        var observacoes = document.getElementById("observacoesReforcoField");
        var idNotaCredito = document.getElementById("idNotaCreditoField");
        if (reforcou === "1") {
            valorReforco.style.display = "";
            observacoes.style.display = "";
            idNotaCredito.style.display = "";
        } else if (reforcou === "0") {
            valorReforco.style.display = "none";
            observacoes.style.display = "none";
            idNotaCredito.style.display = "none";
        } else {
            valorReforco.style.display = "none";
            observacoes.style.display = "none";
            idNotaCredito.style.display = "none";
        }
    }
</script>
<?php
require_once '../include/footer.php';
