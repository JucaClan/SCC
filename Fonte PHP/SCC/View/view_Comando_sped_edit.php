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
$action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_ADD_SLASHES);
if ($action === "sped_update" || $action === "sped_insert") {
    $button = '<button type="submit" class="btn btn-primary">Salvar</button>';
} else {
    $button = "<button type='button' class='btn btn-primary' onclick='document.location = history.back();'>Voltar</button>";
}
?>
<div class="container">     
    <form accept-charset="UTF-8" action="../Controller/ComandoController.php?action=sped_<?= $object->getId() > 0 ? "update" : "insert" ?>&id=<?= $object->getId() ?>" class="needs-validation" novalidate method="post">
        <h2><?= $object->getId() > 0 ? "Editar" : "Inserir" ?> Documento | <a href="#" onclick="history.back(-1);">Voltar</a> | <?= $button ?></h2>    
        <hr>    
        <input type="hidden" name="lastURL" value="<?= $_SERVER["HTTP_REFERER"] ?>"> 
        <div class="form-group">
            <div class="form-row">                
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Tipo</span>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                &nbsp;<input type="radio" class="form-check-input" id="tipoDocumento" name="tipo" value="Documento" <?= $object->getTipo() == "Documento" || empty($object->getTipo()) ? "checked" : "" ?>>Documento
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="tipoMissao" name="tipo" value="Missao" <?= $object->getTipo() == "Missao" ? "checked" : "" ?>>Missão
                            </label>
                        </div>                        
                    </div>                    
                </div>   
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">                
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Título</span>
                        <input type="text" class="form-control" id="titulo" placeholder="Exemplo: DIEx nº 01-Comando/2º BE Cmb ou Ofício nº 01-Comando/2º BE Cmb" name="titulo" required value="<?= $object->getTitulo() ?>" maxlength="1150">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;Informar título.</div>
                    </div>                    
                </div>   
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">            
                <div class="col">                    
                    <div class="input-group-prepend">
                        <span class="input-group-text">Prazo</span>
                        <input type="date" class="form-control" id="prazo" name="prazo" required value="<?= $object->getPrazo() ?>">
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
                        <span class="input-group-text">Responsável</span>
                        <input type="text" class="form-control" id="responsavel" placeholder="Digite o nome de guerra do responsável..." name="responsavel" oninput="this.value = this.value.toUpperCase()" value="<?= $object->getResponsavel() ?>" maxlength="250">
                        <div class="valid-feedback">&nbsp;</div>
                        <div class="invalid-feedback">&nbsp;Informar responsável.</div>
                    </div>                    
                </div>                    
            </div>
        </div>                      
        <!--        <div class="form-group">
                    <div class="form-row">                                            
                        <div class="col">                    
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data de recebimento</span>
                                <input type="date" class="form-control" id="data" name="data" value="<?= $object->getData() ?>">
                                <div class="valid-feedback">&nbsp;</div>
                                <div class="invalid-feedback">&nbsp;Informar data de recebimento.</div>
                            </div>
                        </div>                
                    </div>
                </div>-->
        <div class="form-group">
            <div class="form-row">                                            
                <div class="col">                    
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="resolvido" name="resolvido" <?= $object->getResolvido() == 1 ? "checked" : "" ?> value="1" onclick="labelResolvido();">
                        <label class="custom-control-label" for="resolvido" id="labelResolvido"><span style="color: red;font-weight: bold;">Não resolvido</span></label>
                    </div>                    
                </div>                
            </div>
        </div>   
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

    function labelResolvido() {
        var resolvido = document.getElementById('resolvido').checked;
        if (resolvido === true) {
            document.getElementById('labelResolvido').innerHTML = "<span style='color: green;font-weight: bold;'>Resolvido</span>";
            resolvido = 1;
        } else {
            document.getElementById('labelResolvido').innerHTML = "<span style='color: red;font-weight: bold;'>Não resolvido</span>";
            resolvido = 0;
        }
    }
    labelResolvido();
</script>
<?php
require_once '../include/footer.php';
