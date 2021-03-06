<?php
include('includes/headerAdmin.php');
include ('./controle/verificaLogin.php');

include("./config/config.php");
include("./classes/DBConnection.php");
$database = new DBConnection($localhost);
?>
<!-- Primeira caixa -->
<section class="container pg-add-dpv">
    <div class="row primeira">
        <div class="col-md-6">
            <div class="card formulario-add-dpv">
                <h5 class="card-header">Verificar Dispositivo</h5>
                <div class="card-body">
                    <form method="post" action="controle/dispoditivoDAO.php">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- confirmar senha -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text " id="basic-addon1"><i class="fas fa-lightbulb"></i></span>
                                    </div>
                                    <input name="dispositivo" class="form-control" title="ID do dispositivo" type="text">
                                </div>
                            </div>
                            <!-- botoes de limpar e cadastrar -->
                        </div>
                        <div>
                            <input type="submit" title="Clique para cadastrar" value="Vincular" class="btn btn-success btn-cadastrar">
                            <input type="reset"  title="Clique para limpar os campos" value="Limpar" class="btn btn-success btn-limpar">
                        </div>
                    </form>
                </div>
            </div>

            <div class="card formulario-add-dpv">
                <h5 class="card-header">Selecionar uma configuração para o Dispositivo</h5>
                <div class="card-body">

                    <form method="post" action="controle/selecionarDispositivoDAO.php">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Selecione o dispositivo</label>
                                <select name="dispositivo" class="custom-select">
                                    <option> </option>
                                    <?php
                                    $sql_um = "SELECT dpv_id FROM dispositivo WHERE usuario_usu_id = {$_SESSION['usu_id']}";
                                    $rows_um = $database->getQuery($sql_um);

                                    foreach ($rows_um as $row) {
                                        ?>
                                        <option><?php echo $row['dpv_id']; ?></option>

                                        <?php
                                    }
                                    ?>

                                </select>

                            </div>

                            <br><br><br><br>

                            <div class="col-md-12">
                                <label>Selecione a configuração</label>
                                <select name="configuracao" class="custom-select">
                                    <option> </option>
                                    <?php
                                    $sql_dois = "SELECT config_id, config_eletronico FROM configuracao WHERE usuario_usu_id = {$_SESSION['usu_id']}";
                                    $rows_dois = $database->getQuery($sql_dois);

                                    foreach ($rows_dois as $row) {
                                        ?>
                                        <option><?php echo $row['config_eletronico']; ?></option>
                                        <?php
                                    }
                                    ?>

                                </select>
                            </div>
                            <!-- botoes de limpar e cadastrar -->
                        </div>
                        <br>
                        <div>
                            <input type="submit" title="Clique para cadastrar" value="Selecionar" class="btn btn-success btn-cadastrar">
                            <input type="reset"  title="Clique para limpar os campos" value="Limpar" class="btn btn-success btn-limpar">
                        </div>
                    </form>
                </div>
            </div>
            <br>
        </div>

        <div class="col-md-6">
            <div class="card formulario-add-conf-dpv">
                <h5 class="card-header">Editar uma Configuração</h5>
                <div class="card-body">

                    <form method="post" action="controle/editarConfDispositivo.php" >

                        <div class="row">
                            <div class="col-md-12">
                                <label>Selecione a configuracao</label>

                                <select id="o" onchange="teste()" name="dispositivo" class="custom-select dispositivos">

                                    <?php
                                    $sql_tres = "SELECT * FROM configuracao WHERE usuario_usu_id = {$_SESSION['usu_id']}";
                                    $rows_tres = $database->getQuery($sql_tres);
                                    //echo "<option> </option>";

                                    foreach ($rows_tres as $row) {
                                        echo "<option value='" . $row['config_id'] . "'";
                                        if (isset($_GET['eletronico'])) {
                                            if ($_GET['eletronico'] == $row['config_id']) {
                                                echo "selected";
                                            }
                                        }
                                        echo ">" . $row['config_eletronico'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>                     
                        <div class="row">
                            <?php
                            $tensao = "";
                            $taxa = "";
                            $localizacao = "";
                            $eletronico = "";
                            if (isset($_GET['eletronico'])) {
                                $sql_tres = "SELECT * FROM configuracao WHERE config_id = " . $_GET['eletronico'];
                                $rows_tres = $database->getQuery($sql_tres);
                                foreach ($rows_tres as $row) {
                                    $tensao = $row['config_tensao'];
                                    $taxa = $row['config_taxa'];
                                    $localizacao = $row['config_localizacao'];
                                    $eletronico = $row['config_eletronico'];
                                }
                            }
                            ?>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text " id="basic-addon1"><i class="fas fa-bolt"></i></span>
                                    </div>
                                    <input name="tensao" value="<?php echo $tensao; ?>" class="form-control" title="Digite a tensão" placeholder="Tensão" required="required" type="text">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text " id="basic-addon1"><i class="fas fa-map-marked-alt"></i></span>
                                    </div>
                                    <input name="localizacao" value="<?php echo $localizacao; ?>"class="form-control" title="Localização do dispositivo" placeholder="Localização" required="required" type="text">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- senha do usuario -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-file-invoice-dollar"></i></span>
                                    </div>
                                    <input name="wats" value="<?php echo $taxa; ?>"class="form-control" title="Wats por hora" type="text" placeholder="Taxa">
                                </div>

                                <!-- senha do usuario -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text " id="basic-addon1"><i class="fas fa-plug"></i></span>
                                    </div>
                                    <input name="eletronico" value="<?php echo $eletronico; ?>" class="form-control" title="Digite o eletronico conectado" placeholder="Eletronico" required="required" type="text">
                                </div>
                            </div>
                        </div>

                        <script>
                            function teste() {
                                var x = document.getElementById("o");
                                window.location = '?eletronico=' + x.value;
                            }
                        </script>

                        <div>
                            <input type="submit" title="Clique para atualizar" value="Atualizar" class="btn btn-success btn-entrar btn-cadastrar">
                            <input type="reset"  title="Clique para limpar os campos" value="Limpar" class="btn btn-success btn-entrar btn-limpar">
                        </div>

                    </form>
                </div>
            </div>
            <div class="card formulario-add-conf-dpv">
                <h5 class="card-header">Adicionar uma Configuração</h5>
                <div class="card-body">

                    <form method="post" action="controle/addConfDispositivo.php" >
                        <div class="row">   
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text " id="basic-addon1"><i class="fas fa-bolt"></i></span>
                                    </div>
                                    <input name="tensao" class="form-control" title="Digite a tensão" placeholder="Tensão" required="required" type="text">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text " id="basic-addon1"><i class="fas fa-map-marked-alt"></i></span>
                                    </div>
                                    <input name="localizacao" class="form-control" title="Localização do dispositivo" placeholder="Localização" required="required" type="text">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- senha do usuario -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-file-invoice-dollar"></i></span>
                                    </div>
                                    <input name="wats" class="form-control" title="Wats por hora" type="text" placeholder="Taxa">
                                </div>

                                <!-- senha do usuario -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text " id="basic-addon1"><i class="fas fa-plug"></i></span>
                                    </div>
                                    <input name="eletronico" class="form-control" title="Digite o eletronico conectado" placeholder="Eletronico" required="required" type="text">
                                </div>
                            </div>
                        </div>

                        <div>
                            <input type="submit" title="Clique para atualizar" value="Cadastrar" class="btn btn-success btn-entrar btn-cadastrar">
                            <input type="reset"  title="Clique para limpar os campos" value="Limpar" class="btn btn-success btn-entrar btn-limpar">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include("includes/footer.php");
