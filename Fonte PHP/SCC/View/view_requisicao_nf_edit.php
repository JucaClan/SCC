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
    <form accept-charset="UTF-8" action="../Controller/FiscalizacaoController.php?action=<?= $object->getId() > 0 ? 'update_nf' : 'insert_nf' ?>&idRequisicao=<?= $object->getIdRequisicao(); ?>&id=<?= $object->getId(); ?>" class="needs-validation" novalidate method="post" name="requisicao" id="requisicao">
        <h2><?= $object->getId() > 0 ? "Editar" : "Cadastrar" ?> Nota Fiscal | <a href="#" onclick="history.back(-1);">Voltar</a> | <button type="submit" class="btn btn-success">Salvar</button></h2>    
        <hr>           
        <?php
        if (isAdminLevel($ALMOXARIFADO)) {
            $readonly = false;
        }
        ?>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">            
            <h2 class="alert alert-info">                
                NOTA FISCAL
            </h2>            
            <div class="form-group">
                <div class="form-row">                
                    <div class="col">                        
                        <div class="form-check form-check-inline">    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tipo NF</span>
                            </div>
                            &nbsp;&nbsp;<input type="radio" class="form-check-input" id="tipoNF" name="tipoNF" value="material" <?= $object->getTipoNF() == "material" ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?> onclick="checkTipoNF(this.value);" required /> 
                            <label class="form-check-label">Material</label> 
                        </div>
                        <div class="form-check form-check-inline"> 
                            <input type="radio" class="form-check-input" id="tipoNF" name="tipoNF" value="servico" <?= $object->getTipoNF() == "servico" ? "checked" : "" ?> <?= !$readonly ? "" : "disabled" ?>  onclick="checkTipoNF(this.value);" required /> 
                            <label class="form-check-label">Serviço</label>                
                        </div>
                    </div>
                    <div class="col">
                        <span class="explanation">Tipo da Nota Fiscal.</span>
                    </div>
                </div>
            </div> 
            <div class="form-group">
                <div class="form-row">                
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">NF</span>
                            <input type="text" class="form-control" id="nf" name="nf" maxlength="70" value="<?= $object->getNf() ?>"/>
                        </div>                    
                    </div>
                    <div class="col">
                        <span class="explanation">Número da nota fiscal.</span>
                    </div>              
                </div>
            </div>
            <div class="form-group" id="codigoVerificacaoField">
                <div class="form-row">                
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">Código de verificação</span>
                            <input type="text" class="form-control" id="codigoVerificacao" name="codigoVerificacao" maxlength="70" value="<?= $object->getCodigoVerificacao() ?>"/>
                        </div>                    
                    </div>
                    <div class="col">
                        <span class="explanation">Código de verificação para verificação da NF.</span>
                    </div>              
                </div>
            </div>
            <div class="form-group" id="chaveAcessoField">
                <div class="form-row">                
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">Chave de acesso</span>
                            <input type="text" class="form-control" id="chaveAcesso" name="chaveAcesso" maxlength="70" value="<?= $object->getChaveAcesso() ?>"/>
                        </div>                    
                    </div>
                    <div class="col">
                        <span class="explanation">Chave de acesso para verificação da NF.</span>
                    </div>              
                </div>
            </div>            
            <div class="form-group">
                <div class="form-row">                
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">Descrição</span>
                            <textarea class="form-control" id="descricao" name="descricao" maxlength="1000"><?= $object->getDescricao() ?></textarea>
                        </div>                    
                    </div>
                    <div class="col">
                        <span class="explanation">Descrição da nota fiscal.</span>
                    </div>  
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">                
                    <div class="col">  
                        <div class="input-group-prepend">
                            <span class="input-group-text">Itens</span>                                                    
                            <table border="0" cellpadding="7" cellspacing="0" style="border: 1px solid lightblue;" width="100%">
                                <tr>
                                    <th width="10%">Número</th>
                                    <th width="35%">Descrição</th>
                                    <th width="15%">Valor</th>
                                    <th width="15%">Qtd Max</th>
                                    <th width="15%">Qtd Usada</th>
                                    <th width="20%">Qtd NF</th>
                                </tr>                                   
                                <?php
                                if (!empty($notaFiscalItemList) && $notaFiscalItemList != null) {
                                    $i = 0;
                                    $totalItens = 0;
                                    foreach ($notaFiscalItemList as $item) {
                                        $i++;
                                        $notaFiscal_has_item = ($object->getId() > 0) ? $itemDAO->getQuantidadeByItemIdENFId($item->getId(), $object->getId()) : new Item();
                                        $total = $itemDAO->getTotalQuantidade($item->getId());
                                        $total = (is_null($total) || $total < 0) ? 0 : $total;
                                        $totalItens++;
                                        ?>                                           
                                        <tr>
                                            <td>
                                                <?= $item->getNumeroItem() ?>
                                            </td>
                                            <td>
                                                <?= $item->getDescricao() ?>
                                            </td>
                                            <td>R$ 
                                                <?= $item->getValor() ?>
                                                <input type="hidden" name="valorItem<?= $i ?>" id="valorItem<?= $i ?>" value="<?= $item->getValor() ?>">
                                            </td>
                                            <td>
                                                <?= $item->getQuantidade() ?>
                                            </td>
                                            <td>
                                                <?= $total ?>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" id="quantidadeItem<?= $i; ?>" name="quantidadeItem<?= $i; ?>" max="<?= $notaFiscal_has_item->getQuantidade() + $item->getQuantidade() - $total ?>" min="0" value="<?= $notaFiscal_has_item != null ? $notaFiscal_has_item->getQuantidade() : 0; ?>" style="width: 95px;" <?= ($item->getQuantidade() - $total) === 0 ? "  " : "" ?> onchange="fillValorNF();"/>
                                                <input type="hidden" name="idItem<?= $i; ?>" value="<?= $item->getId(); ?>" />
                                                <?php
                                                if ($object != null) {
                                                    ?>
                                                    <input type="hidden" name="idNotaFiscal<?= $i; ?>" value="<?= $object->getId(); ?>" />
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?> 
                            </table>
                        </div>
                    </div>
                    <div class="col">
                        <span class="explanation">Itens respectivos à Nota Fiscal.</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">Valor R$</span>
                            <input type="text" class="form-control" id="valorNF" name="valorNF" maxlength="25" value="<?= $object->getValorNF() ?>" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" />
                        </div>                    
                    </div>
                    <div class="col">
                        <span class="explanation">Valor da Nota Fiscal.</span>
                    </div>                                                  
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">Data de emissão da Nota Fiscal</span>
                            <input type="date" class="form-control" id="dataEmissaoNF" name ="dataEmissaoNF" value="<?= $object->getDataEmissaoNF() ?>" / >
                        </div>                    
                    </div>
                    <div class="col">
                        <span class="explanation">Data de emissão da Nota Fiscal.</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">Data de entrega do Material/Serviço e Nota Fiscal</span>
                            <input type="date" class="form-control" id="dataEntrega" name="dataEntrega" value="<?= $object->getDataEntrega() ?>"/>
                        </div>                    
                    </div>
                    <div class="col">
                        <span class="explanation">Data de entrega do material ou serviço junto com a Nota Fiscal.</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div  class="col">                     
                        <div class="input-group-prepend">
                            <span class="input-group-text">Data Remessa à Tesouraria</span>
                            <input type="date" class="form-control" id="dataRemessaTesouraria" name="dataRemessaTesouraria" value="<?= $object->getDataRemessaTesouraria() ?>"/>
                        </div>                    
                    </div>
                    <div class="col">
                        <span class="explanation">Data Remessa à Tesouraria.</span>
                    </div>
                </div>
            </div>
            <!-- TESOURARIA -->
            <div class="form-group">
                <div class="form-row">
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text" >Data da liquidação da NF</span>
                            <input type="date" class="form-control" id="dataLiquidacao" name="dataLiquidacao" value="<?= $object->getDataLiquidacao() ?>"/>
                        </div>                    
                    </div>
                    <div class="col">
                        <span class="explanation">Data da liquidação da Nota Fiscal.</span>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="form-group" align="center">
            <input type="submit" class="btn btn-success" value="Salvar"/>
            <input type="button" class="btn btn-danger" value="Fechar" onclick="history.back(-1);"/>
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
        $('[name=codigoVerificacao]').mask('####-####');
        $('[name=chaveAcesso]').mask('0000 0000 0000 0000 0000 0000 0000 0000 0000 0000 0000');
    });

    var secoes = ["requisitante", "salc", "conformidade", "salc2", "almoxarifado", "tesouraria"];
    for (i = 0; i < secoes.length; i++) {
        if (getCookie(secoes[i]) === "1") {
            minimize(secoes[i]);
        }
    }

    function checkTipoNF(tipoNF) {
        var codigoVerificacao = document.getElementById("codigoVerificacaoField");

        var chaveAcesso = document.getElementById("chaveAcessoField");
        if (tipoNF === "servico") {
            codigoVerificacao.style.display = "";
            chaveAcesso.style.display = "none";
        } else if (tipoNF === "material") {
            codigoVerificacao.style.display = "none";
            chaveAcesso.style.display = "";
        } else {
            codigoVerificacao.style.display = "none";
            chaveAcesso.style.display = "none";
        }
    }

    function fillValorNF() {
        var valorNF = document.getElementById("valorNF");
        totalValores = 0;
        for (i = 1; i <=<?= $totalItens ?>; i++) {
            var valorItem = document.getElementById("valorItem" + i).value.replace(",", ".");
            var quantidadeItem = document.getElementById("quantidadeItem" + i).value;
            totalValores += parseFloat(valorItem) * parseInt(quantidadeItem);
        }
        valorNF.value = (totalValores.toFixed(2)).toString().replace(".", ",");
    }

    fillValorNF();
</script>
<?php
require_once '../include/footer.php';
