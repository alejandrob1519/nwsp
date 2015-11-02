<?php
$atributos = array('id'=>'form1', 'name'=>'form1');
echo form_open(null, $atributos);
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
                              echo form_dropdown('diresa', $diresa, set_value('diresa'), 'id="diresa" class="form-control" ');
                              ?>
                          </div>
                    </div>
                    <div class="col-sm-6 col-lg-2">
                        <label for="redes_les">Red</label>
                        <div class="form-group">
                            <?php
                            echo form_dropdown('redes', $redes, set_value('redes'), 'id="redes" class="form-control" ');
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-2">
                        <label for="microred_not">Microred</label>
                        <div class="form-group">
                            <?php
                            echo form_dropdown('microred', $microred, set_value('microred'), 'id="microred" class="form-control" ');
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <label for="cod_eess">eess</label>
                        <div class="form-group" >
                            <?php
                            echo form_dropdown('establec', $establec, set_value('establec'), 'id="establec" class="form-control"');
                            ?>
                        </div>
                    </div>
                        <div class="col-sm-6 col-lg-2">
                                <label for="ano_exp">Año</label>
                                <div class="form-group">
								<?php 
                                $anio = array();
                                    
                                for($i=date("Y");$i>=2014;$i--)
                                {
                                    $anio[$i] = $i;
                                }
                            
                                echo form_error('anoExport', '<div class="warning">', '</div>'); 
                                
                                echo form_dropdown('anoExport', $anio, set_value('anoExport'), 'id="anoExport" class="form-control"');
                                ?>
                                </div>
                        </div>
                    </div>
                    <div class="panel-footer" style="overflow:hidden;text-align:right;">                    
                       <div class="form-group col-xs-offset-4 col-sm-offset-8 col-lg-offset-9">
                                <button onClick="exportandoms()" type="submit" name="enviar" class="btn btn-primary ladda-button" data-style="expand-right"><span class="ladda-label">EXPORTAR BASE</span><span class="ladda-spinner"></span><div class="ladda-progress" style="width: 0px;"></div></button>
                                <a class="btn btn-primary" href="<?php echo base_url().'index.php/chikungunya/principal';?>">CANCELAR</a>
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