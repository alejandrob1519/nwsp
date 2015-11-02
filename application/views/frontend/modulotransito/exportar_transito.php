<?php
$atributos = array('id'=>'formexp', 'name'=>'formexp');
echo form_open('modulotransito/exportar', $atributos);
?>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
		<center><h4><strong><i class="fa fa-database fa-lg"></i>  Exportaci&oacute;n de Base de Datos</strong></h4></center>
        </div>
        <div class="panel-body">
        	<div role="tabpanel">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                        <label for="diresa_not">Diresa</label>
                          <div class="form-group">
                              <?php
                              echo form_dropdown('cod_dir', $diresa, set_value('cod_dir'), 'id="diresa_not" class="form-control" ');
                              ?>
                          </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <label for="redes_les">Red</label>
                        <div class="form-group">
                            <?php
                            echo form_dropdown('redes_not', $redes, set_value('redes_not'), 'id="redes_not" class="form-control" ');
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <label for="microred_not">Microred</label>
                        <div class="form-group">
                            <?php
                            echo form_dropdown('microred_not', $microred, set_value('microred_not'), 'id="microred_not" class="form-control" ');
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <label for="cod_eess">eess</label>
                        <div class="form-group" >
                            <?php
                            echo form_dropdown('cod_eess', $establec, set_value('cod_eess'), 'id="cod_eess" class="form-control"');
                            ?>
                        </div>
                    </div>
                        <div class="col-sm-6 col-lg-3">
                                <label for="ano_exp">Año</label>
                                <div class="form-group">
                                <?php
                                    echo form_dropdown('ano_exp', $anio, set_value('ano_exp'), 'id="ano_exp" class="form-control"');
                                ?>
                                </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                                <label for="ano_exp">Tipo Base</label>
                                <div class="form-group">
                                <?php $tipo_base = array('' => 'Elegir base..', 'xls' => 'Formato Excel', 'dbf' => 'Formato dbf');
                                    echo form_dropdown('tipo_base', $tipo_base, set_value('tipo_base'), 'id="tipo_base" class="form-control"');
                                ?>
                                </div>
                        </div>
                    </div>
                    <div class="panel-footer" style="overflow:hidden;text-align:right;">                    
                       <div class="form-group col-xs-offset-4 col-sm-offset-8 col-lg-offset-9">
                                <button onClick="exportandoms()" type="submit" name="enviar" class="btn btn-primary ladda-button" data-style="expand-right"><span class="ladda-label">EXPORTAR BASE</span><span class="ladda-spinner"></span><div class="ladda-progress" style="width: 0px;"></div></button>
                                <a class="btn btn-primary" href="<?php echo base_url();?>">CANCELAR</a>
                       </div>
                       <div id="exportandoms"></div>
                    </div>
            </div>
  		</div>
    </div>
</div>
<?php
    echo form_close();
?>