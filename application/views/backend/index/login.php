<div class="container">
	<?php
        $atributos = array('id'=>'form1', 'name'=>'form1');
        echo form_open(null, $atributos);
    ?>
    <div class="row">
        <div class="col-xs-9 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-5 col-md-offset-4 col-lg-4 col-lg-offset-4">
            <div class="login-container">
                <div class="row">
                  <div class="hidden-xs hidden-md hidden-lg">
                      <img src="<?php echo base_url()?>public/images/logo.png" width="300px;" />
                  </div>
                </div>
                <hr />
                <div class="avatar"><br />
                    <img src="<?php echo base_url()?>public/images/login.JPG" width="65" height="60" />
                </div>            
                <hr />
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <?php echo form_error('usuario', '<div class="warning" style="position: relative;">', '</div>'); ?> 
                        <input type="text" class="form-control" name="usuario" title="Registre su usuario asignado" value="" placeholder="Usuario" autocomplete="off" autofocus />
                    </div>    
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-star"></span></span>
                        <?php echo form_error('clave', '<div class="warning" style="position: relative;">', '</div>'); ?> 
                        <input type="password" class="form-control" name="clave" title="Registre su contrase&ntilde;a asignada" value="" placeholder="Contrase&ntilde;a" />
                    </div>
                </div>
                <button type="submit" name="enviar" class="btn btn-primary"><span class="glyphicon glyphicon-lock"></span> Acceder</button>
            </div>
            <br />
             <center><h6>Para una mejor visualizaci&oacute;n se recomienda una resoluci&oacute;n de pantalla de 1280 x 1024 px.<br /><br />
             Se recomienda <b>Google Chrome</b> o <b>Mozilla Firefox</b></h6></center>
        </div>
    </div>     
	<?php
        echo form_close();
    ?>
</div>  