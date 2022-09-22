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
$hoje = new DateTime();
// FILTROS
$idSecao = filter_input(INPUT_GET, "idSecao", FILTER_VALIDATE_INT);
$idNotaCredito = filter_input(INPUT_GET, "idNotaCredito", FILTER_VALIDATE_INT);
$ug = filter_input(INPUT_GET, "ug", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
$ne = filter_input(INPUT_GET, "ne", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
$materiaisEntregues = filter_input(INPUT_GET, "materiaisEntregues", FILTER_VALIDATE_INT);

function formatValue($value) {
    echo "<span style='color:" . ($value <= 0 ? "red" : "green") . "'>$value</span>";
}
?>
<script type="text/javascript">
    function update() {
        document.getElementById("filtro").submit();
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
</script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="../include/js/jquery-mask/jquery.mask.min.js"></script>
<style type="text/css">
    .timeline {
        display: flex;
        align-items: center;
        justify-content: center;
        list-style-type: none;
    }

    .timestamp {
        margin-bottom: 2px;
        padding: 0px 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        color: #ffcccc;
        font-size: 10px;
    }

    .timestampCompleted {
        margin-bottom: 2px;
        padding: 0px 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        color: #00cc00;
        font-size: 10px;
    }

    .timestampNext {
        margin-bottom: 2px;
        padding: 0px 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        color: red;
        font-size: 10px;
    }

    .status {
        padding: 0px 4px;
        display: flex;
        justify-content: center;
        border: 1px solid;        
        border-radius: 7px;
        border-color: #ffcccc;
        height: 1px;
        /*background-color: #ffcccc;*/
    }

    .statusCompleted {
        padding: 0px 4px;
        display: flex;
        justify-content: center;
        border: 1px solid;       
        border-radius: 7px;
        border-color: #00cc00;
        height: 1px;
        background-color: #ccffcc;
    }

    .statusNext {
        padding: 0px 4px;
        display: flex;
        justify-content: center;
        border: 2px solid;      
        border-radius: 7px;
        border-color: red;
        height: 1px;
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
    <?php

    function checaSituacao($object) {
//        $hoje = new DateTime();
//        $dataRequisicao = $object->getDataRequisicao();
//        $dataEnvioNe = $object->getDataEnvioNe();
//        //$dataEntregaMaterial = $object->getDataEntregaMaterial();
//        $dateDif = date_diff(new DateTime($dataEnvioNe), $hoje);
//        $ne = $object->getNe();
//        $nc = $object->getIdNotaCredito();
//        $parecer = $object->getParecer();
//        //$numeroOficio = $object->getNumeroOficio();
        $situacao = "";

        if (empty($nc)) {
            $situacao = "Aguardando Requisitante";
        } else if (empty($ne)) {
            $situacao = "Aguardando Aquisições";
        } else if (empty($parecer)) {
            $situacao = "Aguardando Conformidade";
        } else if (empty($dataEnvioNe)) {
            $situacao = "Aguardando Aquisições";
        } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') < 31) {
            $situacao = "Aguardando Entrega há " . $dateDif->format('%a') . " dia(s)";
        }// else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') >= 31 && empty($numeroOficio) && empty($dataEntregaMaterial)) {
//            $situacao = "Notificar Empresa <sup>Aguardando Entrega há " . $dateDif->format('%a') . " dia(s)</sup>";
//        } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') >= 31 && !empty($numeroOficio) && empty($dataEntregaMaterial)) {
//            $situacao = "Empresa Oficiada";
//        } else if (!empty($dataEntregaMaterial)) {
//            $situacao = "Material entregue";
//        }
        //echo $situacao;
        $salc1 = !empty($object->getDataNE()) ? "Completed" : "Next";
        $conformidade = !empty($object->getDataParecer()) ? "Completed" : ($salc1 == "Completed" ? "Next" : "");
        $salc2 = !empty($object->getDataEnvioNE()) ? "Completed" : ($conformidade == "Completed" ? "Next" : "");
        $almoxarifado = !empty($object->getDataEnvioNEEmpresa()) ? "Completed" : ($salc2 == "Completed" ? "Next" : "");
        $notaFiscalDAO = new NotaFiscalDAO();
        $notaFiscalList = $notaFiscalDAO->getByRequisicaoId($object->getId());
        $tesouraria = "";
        if (!is_null($notaFiscalList)) {
            foreach ($notaFiscalList as $notaFiscal) {
                if (empty($notaFiscal->getDataLiquidacao())) {
                    $tesouraria = ($almoxarifado == "Completed") ? "Next" : "";
                    break;
                } else {
                    $tesouraria = "Completed";
                }
            }
        }
        ?>
        <ul class="timeline">
            <li>
                <div class="timestampCompleted" id="requisitanteTimestamp">
                    REQ
                </div>
                <div class="statusCompleted" id="requisitanteStatus">
                    <h4>&FilledSmallSquare; </h4>
                </div>
            </li>
            <li>
                <div class="timestamp<?= $salc1 ?>" id="salc1Timestamp">
                    SALC
                </div>
                <div class="status<?= $salc1 ?>" id="salc1Status">
                    <h4>&FilledSmallSquare; </h4>
                </div>
            </li>
            <li>
                <div class="timestamp<?= $conformidade ?>" id="conformidadeTimestamp">
                    CONF
                </div>
                <div class="status<?= $conformidade ?>" id="conformidadeStatus">
                    <h4>&FilledSmallSquare; </h4>
                </div>
            </li>
            <li>
                <div class="timestamp<?= $salc2 ?>" id="salc2Timestamp">
                    SALC
                </div>
                <div class="status<?= $salc2 ?>" id="salc2Status">
                    <h4>&FilledSmallSquare; </h4>
                </div>
            </li>
            <li>
                <div class="timestamp<?= $almoxarifado ?>" id="almoxarifadoTimestamp">
                    ALMOX
                </div>
                <div class="status<?= $almoxarifado ?>" id="almoxarifadoStatus">
                    <h4>&FilledSmallSquare; </h4>
                </div>
            </li>
            <li>
                <div class="timestamp<?= $tesouraria ?>" id="tesourariaTimestamp">
                    TESO
                </div>
                <div class="status<?= $tesouraria ?>" id="tesourariaStatus">
                    <h4>&FilledSmallSquare;</h4>
                </div>
            </li>
        </ul>
        <?php
    }

    // Verificações de datas e atualizações de datas
    $dateDif = date_diff(new DateTime($secaoDAO->getBySecao("Fiscalizacao")->getDataAtualizacaoOriginal()), $hoje);
    $alert = "";
    if ($dateDif->format('%R') == "+" && $dateDif->format('%a') >= 7) {
        $color = "red";
        $alert = $dateDif->format('%a') . " dia(s) atrás";
    } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') > 2 && $dateDif->format('%a') < 7) {
        $color = "darkorange";
        $alert = $dateDif->format('%a') . " dia(s) atrás";
    } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') <= 2) {
        $color = "darkgreen";
        $alert = $dateDif->format('%a') . " dia(s) atrás";
    }
    ?>    
    <h6 style="font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("Fiscalizacao")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= $alert ?></span></h6>
<!--    <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("Fiscalizacao")->getMensagem(); ?></h6>
    <div align="left">                        
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mensagem">Editar mensagem</button>
    </div>        
    <br>    -->
</div>
<div class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">
    <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('requisicoes');"> 
    <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('requisicoes');">        
    <span style="margin-left: 14px; font-weight: bold;">REQUISIÇÕES</span>
</div>
<br>
<div style="width:99%;margin: 0 auto">                                         
    <table class="table table-bordered" id="requisicoes">
        <thead>            
            <tr>
                <th colspan="25">
                    <div align="center">
                        <form accept-charset="UTF-8" id="filtro" action="../Controller/FiscalizacaoController.php?action=getAllList" method="get">
                            <input type="hidden" name="action" value="getAllList">            
                            <div class="form-row">                                  
                                <div class="col-2" align="left" style="padding-top: 7px;">   
                                    <select class="form-control" name="idSecao" onchange="update();">
                                        <option disabled selected>Filtrar por seção</option>
                                        <?php
                                        if (!empty($secaoList) && $secaoList != null) {
                                            foreach ($secaoList as $secao) {
                                                ?>
                                                <option value="<?= $secao->getId() ?>" <?= $idSecao == $secao->getId() ? "selected" : "" ?>><?= $secao->getSecao() ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-2" align="left" style="padding-top: 7px;">   
                                    <select class="form-control" name="idNotaCredito" onchange="update();">
                                        <option disabled selected>Filtrar por Nota de crédito</option>
                                        <?php
                                        if (!empty($notaCreditoList) && $notaCreditoList != null) {
                                            foreach ($notaCreditoList as $notaCredito) {
                                                ?>
                                                <option value="<?= $notaCredito->getId() ?>" <?= $idNotaCredito == $notaCredito->getId() ? "selected" : "" ?>><?= $notaCredito->getNc() ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-2" align="left" style="padding-top: 7px;" onchange="update();">   
                                    <select class="form-control" name="ug" id="ug">
                                        <option disabled selected>Filtrar por UG da NC</option>
                                        <option <?= $ug == "160477" ? "selected" : "" ?>>160477</option>
                                        <option <?= $ug == "167477" ? "selected" : "" ?>>167477</option>
                                    </select>
                                </div>
                                <div class="col-2" align="left" style="padding-top: 7px;">   
                                    <input type="text" class="form-control" id="ne" placeholder="Filtrar por nota de empenho" name="ne" maxlength="12" onkeypress="return event.charCode === 78 || event.charCode === 69 || (event.charCode >= 48 && event.charCode <= 57);" onblur="update();" value="<?= $ne ?>" />
                                </div>
                                <div class="col-2" align="left" style="padding-top: 7px;">   
                                    <input type="radio" id="materiaisEntregues" name="materiaisEntregues" value="1" onclick="update();" <?= $materiaisEntregues === 1 ? "checked" : "" ?> /> Entregues <br><input type="radio" id="materiaisEntregues" name="materiaisEntregues" value="0" onclick="update();" <?= $materiaisEntregues === 0 ? "checked" : "" ?> /> Não entregues
                                </div>
                                <div class="col-2" align="left" style="padding-top: 7px;">   
                                    <a href="../Controller/FiscalizacaoController.php?action=getAllList">Remover filtros</a>
                                </div>
                            </div>                            
                        </form>
                    </div>
                </th>
            </tr>
            <tr>
                <th>UG NC</th>
                <th>Seção</th>   
                <th></th>
                <th>NE <sup>NC</sup></th>
                <th>Data NE</th>
                <th>Data Envio NE</th>                             
                <th>Empresa</th>                
                <th>Situação</th>
                <th>
                    <?php if (isAdminLevel($ADICIONAR_FISCALIZACAO)) { ?>
                        <a href="../Controller/FiscalizacaoController.php?action=insert"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                    <?php } ?>
                </th>                
            </tr>
        </thead>        
        <tbody>
            <?php
            if (is_array($objectList) && isAdminLevel($LISTAR_FISCALIZACAO)) {
                foreach ($objectList as $object) {
//                    $itemList = $itemDAO->getByRequisicaoId($object->getId());
//                    $descricaoItens = "";
//                    foreach ($itemList as $item) {
//                        //$descricaoItens .= $item->getDescricao() . "<br>";
//                    }
                    //$object->setDescricao($descricaoItens);
                    ?> 
                    <tr>
                        <td><?= $object->getIdNotaCredito() > 0 ? $notaCreditoDAO->getById($object->getIdNotaCredito())->getUg() : "" ?></td>
                        <td><?= $secaoDAO->getById($object->getIdSecao())->getSecao(); ?> </td>
                        <td></td>
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<?= $object->getIdNotaCredito() > 0 ? $notaCreditoDAO->getById($object->getIdNotaCredito())->getNc() : $object->getIdNotaCredito() ?>"><?= $object->getNe() ?></a></td>
                        <td><?= $object->getDataNEFormatada() ?></td>
                        <td><?= $object->getDataEnvioNEFormatada() ?></td>
                        <td><?= $object->getEmpresa() ?></td>                        
                        <td><?= checaSituacao($object); ?></td>
                        <td>
                            <?php if (isAdminLevel($EDITAR_FISCALIZACAO)) { ?>
                                <a href="../Controller/FiscalizacaoController.php?action=update&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                            <?php } ?>
                            <?php if (isAdminLevel($EXCLUIR_FISCALIZACAO)) { ?>
                                <a href="../Controller/FiscalizacaoController.php?action=delete&id=<?= $object->getId() ?>"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
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
<div  class="conteudo" style="border: 1px dashed lightskyblue; padding: 7px;">
    <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('notasCredito');"> 
    <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('notasCredito');">        
    <span style="margin-left: 14px; font-weight: bold;">NOTAS DE CRÉDITO</span>
</div>
<br>
<div style="width:99%;margin: 0 auto">                                         
    <table class="table table-bordered" id="notasCredito">
        <thead>
            <tr>
                <th colspan="25">                    
                    <div id="contador" style="margin: 7px; font-size: 14px; font-weight: bold; color: #cc0000;"></div>
                </th>
            </tr>
            <tr>
                <th>Data NC</th>   
                <th>Nota de Crédito</th>
                <th>PI</th>
                <th>Valor</th>
                <th>Gestor NC</th>                             
                <th>PTRes</th>
                <th>Fonte</th>
                <th>UG</th>
                <th>
                    <?php if (isAdminLevel($ADICIONAR_FISCALIZACAO_NC)) { ?>
                        <a href="../Controller/FiscalizacaoController.php?action=insert_nc"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                    <?php } ?>
                </th>                
            </tr>
        </thead>        
        <tbody>
            <?php
            if (is_array($notaCreditoList) && isAdminLevel($LISTAR_FISCALIZACAO_NC)) {
                foreach ($notaCreditoList as $object) {
                    ?> 
                    <tr>
                        <td><?= $object->getDataNc() ?></td>
                        <td><?= $object->getNc() ?></td>
                        <td><?= $object->getPi() ?></td>
                        <td><?= $object->getValor() ?></td>
                        <td><?= $object->getGestorNc() ?></td>
                        <td><?= $object->getPtres() ?></td>
                        <td><?= $object->getFonte() ?></td>
                        <td><?= $object->getUg() ?></td>                        
                        <td>
                            <?php if (isAdminLevel($EDITAR_FISCALIZACAO_NC)) { ?>
                                <a href="../Controller/FiscalizacaoController.php?action=update_nc&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                            <?php } ?>
                            <?php if (isAdminLevel($EXCLUIR_FISCALIZACAO_NC)) { ?>
                                <a href="../Controller/FiscalizacaoController.php?action=delete_nc&id=<?= $object->getId() ?>"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
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
<div class="alert alert-info" style="font-weight:normal;">
    <strong>INFORMAÇÕES!</strong> 
    <ol>
        <li>A Seção Requisitante cadastra a REQUISIÇÃO;</li>
        <li>A SALC realiza o empenho</li>
        <li>A Conformidade emite o parecer do OD</li>
        <li>A SALC envia a Nota de Empenho ao Almoxarifado</li>
        <li>O Almoxarifado envia a NE à Empresa e realiza o controle da entrega do material. Caso não tenha recebido, passado-se 30 dias do envio da Nota de Empenho, o Almoxarifado notifica a empresa através de Ofício. Passado-se mais 30 dias, após o envio do Ofício, sem recebimento do material, o Almoxarifado solicita a abertura de Processo Administrativo;</li>
        <li>A Tesouraria, após o recebimento do material pelo Almoxarifado faz a liquidação da Nota de Empenho;</li>
    </ol>
    A Situação da REQUISIÇÃO será calculada pelo sistema com base no fluxo de informações que são fornecidos no decorrer do tempo de vida da REQUISIÇÃO, que deixa de estar ATIVA, após preenchimento pela Tesouraria do valor liquidado.
</div>
<div class="modal fade" id="mensagem" tabindex="-1" role="dialog" aria-labelledby="mensagemLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="combustivelLabel">Mensagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                  
                <?php
                $dateDif = date_diff(new DateTime($secaoDAO->getBySecao("Fiscalizacao")->getDataAtualizacaoOriginal()), $hoje);
                if ($dateDif->format('%R') == "+" && $dateDif->format('%a') >= 7) {
                    $color = "red";
                    $alert = $dateDif->format('%a') . " dia(s) atrás";
                } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') > 2 && $dateDif->format('%a') < 7) {
                    $color = "darkorange";
                    $alert = $dateDif->format('%a') . " dia(s) atrás";
                } else if ($dateDif->format('%R') == "+" && $dateDif->format('%a') <= 2) {
                    $color = "darkgreen";
                    $alert = $dateDif->format('%a') . " dia(s) atrás";
                }
                ?>    
                <h6 style="font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("Fiscalizacao")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= empty($secaoDAO->getBySecao("Fiscalizacao")->getDataAtualizacao()) ? "" : $alert; ?></span></h6>
                <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("Fiscalizacao")->getMensagem(); ?></h6>                
            </div>
            <div class="modal-footer">                
                <form accept-charset="UTF-8" id="formAgenda" action="../Controller/FiscalizacaoController.php?action=mensagem_update" method="post">                    
                    <?php if (isAdminLevel($EDITAR_FISCALIZACAO)) { ?>                        
                        <textarea name="mensagem" cols="81" placeholder="Mensagem opcional para o Comandante" maxlength="700"><?= $secaoDAO->getBySecao("Fiscalizacao")->getMensagem(); ?></textarea><br>
                        <input type="submit" class="btn btn-primary" value="Atualizar">
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
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
        $('[name=ne]').mask('0000NE000000');
    });
</script>
<?php
require_once '../include/footer.php';
