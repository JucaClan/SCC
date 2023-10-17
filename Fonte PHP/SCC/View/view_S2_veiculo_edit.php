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
 * publicada pela Free Software Foundation (RPF); na versão 3 da
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
$hoje = date('Y-m-d');
?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="../include/js/jquery-mask/jquery.mask.min.js"></script>
<div class="container">  
    <form accept-charset="UTF-8" action="../Controller/S2Controller.php?action=veiculo_<?= $object->getId() > 0 ? "update" : "insert" ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post">
        <h2><?= $object->getId() > 0 ? "Editar" : "Inserir" ?> Veículo | <a href="#" onclick="history.back(-1);">Voltar</a> | <button type="submit" class="btn btn-primary">Salvar</button></h2>
        <hr>    
        <input type="hidden" name="lastURL" value="<?= $_SERVER["HTTP_REFERER"] ?>">          
        <div class="form-group">
            <div class="form-row">                 
                <div class="col">                      
                    <div class="input-group-prepend">
                        <span class="input-group-text">Tipo Veículo</span>                        
                        <select name="tipoVeiculo" class="form-control" required>                                                                                       
                            <option value="" <?= $object->getTipoVeiculo() == "" ? "selected" : "" ?> disabled>Selecione um tipo de veículo</option>                                
                            <option value="Civil" <?= $object->getTipoVeiculo() == "Civil" ? "selected" : "" ?>>Civil</option>                            
                            <option value="Militar" <?= $object->getTipoVeiculo() == "Militar" ? "selected" : "" ?>>Militar</option>   
                        </select>
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;Obrigatório</div>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Placa</span>
                        <input type="text" class="form-control" id="Placa" placeholder="Qual a placa do veiculo?" name="placa" maxlength="10" oninput="this.value = this.value.toUpperCase()" value="<?= $object->getPlaca() ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>        
        <div class="form-group">
            <div class="form-row"> 
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Modelo</span>
                        <input type="text" class="form-control" id="modelo" placeholder="Qual o modelo do veiculo?" name="modelo" oninput="this.value = this.value.toUpperCase()" maxlength="30" value="<?= $object->getModelo() ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Cor</span>
                        <input type="color" class="form-control" id="cor" placeholder="Qual a cor do veiculo?" name="cor"  maxlength="20" value="<?= $object->getCor() ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>     
        <div class="form-group">
            <div class="form-row"> 
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Nome Completo</span>
                        <input type="text" class="form-control" id="nomeCompleto" name="nomeCompleto" placeholder="Qual o nome completo?" maxlength="80" oninput="this.value = this.value.toUpperCase()" value="<?= $object->getNomeCompleto(); ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>  
                </div> 
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Identidade</span>
                        <input type="text" class="form-control" id="identidade" name="identidade" placeholder="Qual o CPF?" value="<?= $object->getIdentidade(); ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div> 
                </div> 
            </div> 
        </div> 
        <div class="form-group">
            <div class="form-row"> 
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Destino</span>
                        <input type="text" class="form-control" id="destino" name="destino" maxlength="70" oninput="this.value = this.value.toUpperCase()" placeholder="Qual o destino?" value="<?= $object->getDestino(); ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                                                         
                </div>                                
            </div>
        </div>            
        <?php
        try {
            $dataEntrada = explode(" ", $object->getDataEntrada());
            if (count($dataEntrada) < 2) {
                $dataEntrada[0] = "";
                $dataEntrada[1] = "";
            }
            $dataSaida = explode(" ", $object->getDataSaida());

            if (count($dataSaida) < 2) {
                $dataSaida[0] = "";
                $dataSaida[1] = "";
            }
        } catch (Exception $e) {
            echo "Ocorreu um problema na manipulação de datas, informe o Administrador do Sistema.";
        }
        ?>
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Data de Entrada</span> 
                        <input type="date" class="form-control" id="dataEntrada" name="dataEntrada"  value="<?= empty($dataEntrada[0]) ? $hoje : $dataEntrada[0] ?>" required>
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
                </div>
                <div class="col">                                       
                    <input type="time" class="form-control" id="horaEntrada" name="horaEntrada"value="<?= $dataEntrada[1] ?>">                        
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Data de saída</span>
                        <input type="date" class="form-control" id="dataSaida" name="dataSaida"value="<?= $dataSaida[0] ?>">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;</div>
                    </div>                    
                </div>
                <div class="col">                                       
                    <input type="time" class="form-control" id="horaSaida" name="horaSaida"value="<?= $dataSaida[1] ?>">                        
                </div>                                    
            </div>
        </div>    
        <div class="form-group">
            <div class="form-row">
                <div class="col">                    

                </div>                                               
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Salvar</button>
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
        $('[name=placa]').mask('SSS-0A00');
        $('[name=identidade]').mask('000.000.000-00');
    });
</script>
<?php
require_once '../include/footer.php';
