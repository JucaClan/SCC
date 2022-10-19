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
</script>
<style type="text/css">
    .subtitulo {
        font-weight: bold;
    }

    .explanation {
        font-size: 12px;
        color: red;
    }
</style>
<div class="conteudo">  
    <?php
    $requisicaoDAO = new RequisicaoDAO();
    $requisicao = $requisicaoDAO->getById($object->getIdRequisicao());
    ?>
    <form accept-charset="UTF-8" action="../Controller/FiscalizacaoController.php?action=<?= $object->getId() > 0 ? 'update_nf' : 'insert_nf' ?>&idRequisicao=<?= $object->getIdRequisicao(); ?>&id=<?= $object->getId(); ?>" class="needs-validation" novalidate method="post" name="requisicao" id="requisicao">
        <h2><?= $object->getId() > 0 ? "Editar" : "Cadastrar" ?> <?= $requisicao->getTipoNF() !== "ordinario" ? "Pedido/" : "" ?>Nota Fiscal | <a href="#" onclick="history.back(-1);">Voltar</a> | <button type="submit" class="btn btn-success">Salvar</button></h2>    
        <hr>           
        <?php
        if (isAdminLevel($ALMOXARIFADO) || isAdminLevel($TESOURARIA)) {
            $readonly = false;
        }
        ?>
        <div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">   
            <?php
            if ($requisicao->getTipoNE() !== "ordinario") {
                ?>
                <h2 class="alert alert-info">                
                    PEDIDO
                </h2>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data do pedido</span>
                                <input type="date" class="form-control" id="dataPedido" name ="dataPedido" value="<?= $object->getDataPedido() ?>" / >
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data da realização do pedido.</span>
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
                                        <th width="5%">Nº</th>
                                        <th width="35%">Descrição</th>
                                        <th width="20%">Valor</th>
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
                                                    <?= number_format((float)$item->getValor(), 2, ",", ".") ?>
                                                    <input type="hidden" name="valorItem<?= $i ?>" id="valorItem<?= $i ?>" value="<?= $item->getValor() ?>">
                                                </td>
                                                <td>
                                                    <?= $item->getQuantidade() ?>
                                                </td>
                                                <td>
                                                    <?= $total ?>
                                                </td>
                                                <td>                                                    
                                                    <input type="number" class="form-control" id="quantidadeItem<?= $i; ?>" name="quantidadeItem<?= $i; ?>" max="<?= $notaFiscal_has_item != null ? ($notaFiscal_has_item->getQuantidade() + $item->getQuantidade() - $total) : $item->getQuantidade() ?>" min="0" value="<?= ($notaFiscal_has_item != null && !empty($notaFiscal_has_item->getQuantidade())) ? $notaFiscal_has_item->getQuantidade() : 0; ?>" style="width: 95px;" <?= ($item->getQuantidade() - $total) === 0 ? "  " : "" ?> onchange="fillValorNF();"/>                                                    
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
                                <span class="input-group-text">Data prazo de entrega</span>
                                <input type="date" class="form-control" id="dataPrazoEntrega" name ="dataPrazoEntrega" value="<?= $object->getDataPrazoEntrega() ?>" / >
                            </div>                    
                        </div>
                        <div class="col">
                            <span class="explanation">Data prazo para entrega do pedido.</span>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <h2 class="alert alert-info">                
                NOTA FISCAL
            </h2>            
            <input type="hidden" id="tipoNF" name="tipoNF" value="<?= $requisicao->getTipoNF() ?>" />
            <div class="form-group">
                <div class="form-row">                
                    <div class="col">                    
                        <div class="input-group-prepend">
                            <span class="input-group-text">NF<?= $requisicao->getTipoNF() === "servico" ? "S" : "" ?></span>
                            <input type="text" class="form-control" id="nf" name="nf" maxlength="70" value="<?= $object->getNf() ?>"/>
                        </div>                    
                    </div>
                    <div class="col">
                        <span class="explanation">Número da nota fiscal.</span>
                    </div>              
                </div>
            </div>
            <?php
            if ($requisicao->getTipoNF() === "servico") {
                ?>
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
                <?php
            } else {
                ?>
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
                <?php
            }
            ?>
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
                                    <th width="5%">Nº</th>
                                    <th width="35%">Descrição</th>
                                    <th width="20%">Valor</th>
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
                                                <?= number_format((float)$item->getValor(), 2, ",", ".") ?>
                                                <?php
                                                if ($requisicao->getTipoNE() === "ordinario") {
                                                    ?>
                                                    <input type="hidden" name="valorItem<?= $i ?>" id="valorItem<?= $i ?>" value="<?= $item->getValor() ?>">
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?= $item->getQuantidade() ?>
                                            </td>
                                            <td>
                                                <?= $total ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($requisicao->getTipoNE() === "ordinario") {
                                                    ?>
                                                    <input type="number" class="form-control" id="quantidadeItem<?= $i; ?>" name="quantidadeItem<?= $i; ?>" max="<?= $notaFiscal_has_item != null ? ($notaFiscal_has_item->getQuantidade() + $item->getQuantidade() - $total) : $item->getQuantidade() ?>" min="0" value="<?= ($notaFiscal_has_item != null && !empty($notaFiscal_has_item->getQuantidade())) ? $notaFiscal_has_item->getQuantidade() : 0; ?>" style="width: 95px;" <?= ($item->getQuantidade() - $total) === 0 ? "  " : "" ?> onchange="fillValorNF();"/>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="number" class="form-control" value="<?= ($notaFiscal_has_item != null && !empty($notaFiscal_has_item->getQuantidade())) ? $notaFiscal_has_item->getQuantidade() : 0; ?>" style="width: 95px;" <?= ($item->getQuantidade() - $total) === 0 ? "  " : "" ?> readonly />
                                                    <?php
                                                }
                                                if ($requisicao->getTipoNE() === "ordinario") {
                                                    ?>
                                                    <input type="hidden" name="idItem<?= $i; ?>" value="<?= $item->getId(); ?>" />
                                                    <?php
                                                }
                                                if ($object != null) {
                                                    if ($requisicao->getTipoNE() === "ordinario") {
                                                        ?>
                                                        <input type="hidden" name="idNotaFiscal<?= $i; ?>" value="<?= $object->getId(); ?>" />
                                                        <?php
                                                    }
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
                            <?php
                            if ($requisicao->getTipoNE() === "ordinario") {
                                ?>
                                <input type="text" class="form-control" id="valorNF" name="valorNF" maxlength="25" value="<?= $object->getValorNF() ?>" onkeypress="return event.charCode === 44 || (event.charCode >= 48 && event.charCode <= 57);" />
                            <?php } else { ?>
                                <input type="text" class="form-control" value="<?= $object->getValorNF() ?>" readonly />
                            <?php } ?>
                        </div>                    
                    </div>
                    <div class="col">
                        <span class="explanation">Valor da Nota Fiscal.</span>
                    </div>                                                  
                </div>
            </div>
            <hr>
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

    //    function checkTipoNF() {
    //        var tipoNF = document.getElementById("tipoNF").value;
    //        var codigoVerificacao = document.getElementById("codigoVerificacaoField");
    //        var chaveAcesso = document.getElementById("chaveAcessoField");
    //        if (tipoNF === "servico") {
    //            codigoVerificacao.style.display = "";
    //            chaveAcesso.style.display = "none";
    //        } else if (tipoNF === "material") {
    //            codigoVerificacao.style.display = "none";
    //            chaveAcesso.style.display = "";
    //        } else {
    //            codigoVerificacao.style.display = "none";
    //            chaveAcesso.style.display = "none";
    //        }
    //    }

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
