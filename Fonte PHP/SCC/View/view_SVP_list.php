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
$dataHoje = date('Y-m-d');
$dataAmanha = date('Y-m-d', strtotime(' +1 day'));
$inicio = !empty(filter_input(INPUT_GET, "inicio", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? filter_input(INPUT_GET, "inicio", FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $dataHoje;
$fim = !empty(filter_input(INPUT_GET, "fim", FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ? filter_input(INPUT_GET, "fim", FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $dataAmanha;
$hoje = new DateTime();
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
<div class="conteudo">       
    <div align="center">                
    </div>   
    <br>
    <?php
    $alert = "";
    $dateDif = date_diff(new DateTime($secaoDAO->getBySecao("SVP")->getDataAtualizacaoOriginal()), $hoje);
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
    <h6 style="font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("SVP")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= $alert ?></span></h6>
    <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("SVP")->getMensagem(); ?></h6>
    <div align="left">                        
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editarMensagem">Editar mensagem</button>        
    </div>
    <br>
    <div style="border: 1px dashed lightskyblue; padding: 7px;">
        <img src="../include/imagens/minimizar.png" width="25" height="25" onclick="minimize('myTableVeiculo');"> 
        <img src="../include/imagens/maximizar.png" width="25" height="25" onclick="maximize('myTableVeiculo');">        
        <span style="margin-left: 14px; font-weight: bold;">RELATÓRIO DE VEÍCULOS</span>
    </div>
    <br>    
    <table class="table table-bordered">
        <thead>            
            <tr>
                <th colspan="7">
                    <form accept-charset="UTF-8" id="filtro" action="../Controller/SVPController.php?action=getAllList" method="get">
                        <input type="hidden" name="action" value="getAllList">
                        <div class="form-group">
                            <div class="form-row">                                    
                                <div class="col">
                                    Exibindo veículos com data de entrada de <input type="date" id="inicio" name="inicio" required value="<?= $inicio ?>" onchange="update();"> até <input type="date" id="fim" name="fim" required value="<?= $fim ?>" onchange="update();"> 
                                </div>                                                                
                            </div>                
                        </div>
                    </form>
                </th>
            </tr>
            <tr>
                <th colspan="25">                    
                    <div id="contador" style="margin: 7px; font-size: 14px; font-weight: bold; color: #cc0000;"></div>
                </th>
            </tr>
            <tr>                
                <th>Tipo Veículo / Placa</th>                
                <th>Modelo / Cor</th>                         
                <th>Nome Completo / Identidade</th>                
                <th>Destino</th>
                <th>Data Entrada / Data Saída</th>                                 
                <th>
                    <?php if (isAdminLevel($ADICIONAR_SVP)) { ?>
                        <a href="../Controller/SVPController.php?action=veiculo_insert"><img src='../include/imagens/adicionar.png' width='25' height='25' title='Adicionar'></a>
                    <?php } ?>
                </th>                
            </tr>
        </thead>
        <tbody id="myTableVeiculo">   
            <?php if (is_array($objectList) && isAdminLevel($LISTAR_SVP)) { ?> 
                <?php foreach ($objectList as $object): ?>
                    <tr>                                           
                        <td style="text-align: center;">
                            <?= $object->getTipoVeiculo() ?> / <?= $object->getPlaca() ?>
                        </td>
                        <td>
                            <?= $object->getModelo() ?> / <input type="color" value="<?= $object->getCor() ?>" disabled>
                        </td>         
                        <td><?= $object->getNomeCompleto() ?> / <?= $object->getIdentidade() ?></td>
                        <td><?= $object->getDestino() ?></td>
                        <td><?= $object->getDataEntrada() ?> / <?= $object->getDataSaida() ?></td>                        
                        <td style="white-space: nowrap">
                            <?php if (isAdminLevel($EDITAR_SVP)) { ?>
                                <a href="../Controller/SVPController.php?action=veiculo_update&id=<?= $object->getId() ?>"><img src='../include/imagens/editar.png' width='25' height='25' title='Editar'></a>
                            <?php } ?>
                            <?php if (isAdminLevel($EXCLUIR_SVP)) { ?>
                                <a href="#" onclick="confirm('Confirma a remoção do item?') ? document.location = '../Controller/SVPController.php?action=veiculo_delete&id=<?= $object->getId() ?>' : '';"><img src='../include/imagens/excluir.png' width='25' height='25' title='Excluir'></a>
                            <?php } ?>
                        </td>
                    </tr>                    
                <?php endforeach; ?>    
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="editarMensagem" tabindex="-1" role="dialog" aria-labelledby="mensagemLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mensagemLabel">Mensagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                  
                <?php
                $dateDif = date_diff(new DateTime($secaoDAO->getBySecao("SVP")->getDataAtualizacaoOriginal()), $hoje);
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
                <h6 style="font-size: 16px;"><b>Data atualização:</b> <?= $secaoDAO->getBySecao("SVP")->getDataAtualizacao(); ?> - <span style="font-weight: bold; color: <?= $color ?>;"><?= empty($secaoDAO->getBySecao("SVP")->getDataAtualizacao()) ? "" : $alert; ?></span></h6>
                <h6 style="font-size: 16px;"><b>Mensagem:</b> <?= $secaoDAO->getBySecao("SVP")->getMensagem(); ?></h6>
            </div>
            <div class="modal-footer">                
                <form accept-charset="UTF-8" id="formMapaDaForca" action="../Controller/SVPController.php?action=mensagem_update" method="post">                    
                    <?php if (isAdminLevel($EDITAR_SVP)) { ?>                        
                        <textarea name="mensagem" cols="81" placeholder="Mensagem opcional para o Comandante" maxlength="700"><?= $secaoDAO->getBySecao("SVP")->getMensagem(); ?></textarea><br>
                        <input type="submit" class="btn btn-primary" value="Atualizar">
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#myInputVeiculo").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myTableVeiculo tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                countRows();
            });
        });
    });

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function countRows() {
        let rowCount = $('#myTableVeiculo tr:visible').length;
        var message = rowCount + (rowCount > 1 || rowCount === 0 ? " ocorrências" : " ocorrência");
        document.getElementById("contador").innerHTML = message;
    }

    countRows();
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<?php
require_once '../include/footer.php';
