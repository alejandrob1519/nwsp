<script type="text/javascript">
$(document).ready(function(){
	
	var menu_ul = $('.menu > li > ul'),
		   menu_a  = $('.menu > li > a');
	
	menu_ul.hide();
	
	menu_a.click(function(e) {
		e.preventDefault();
		if(!$(this).hasClass('active')) {
			menu_a.removeClass('active');
			menu_ul.filter(':visible').slideUp('normal');
			$(this).addClass('active').next().stop(true,true).slideDown('normal');
		} else {
			$(this).removeClass('active');
			$(this).next().stop(true,true).slideUp('normal');
		}
	
	});
	
	<?php
	
	if($this->uri->segment(3)=='principal'){
		echo '$("#house").show();';
		echo '$("#usu").hide();';
		echo '$("#inter").hide();';
		echo '$("#mante").hide();';
		echo '$("#niv").hide();';
		echo '$("#base").hide();';
	}
	
	if($this->uri->segment(2)=='usuario' || $this->uri->segment(2)=='fichas' && ($this->uri->segment(3)=='listarUsuariosAdministradores' || $this->uri->segment(3)=='listarUsuarios' || $this->uri->segment(3)=='listarNiveles' || $this->uri->segment(3)=='listarTematicos' || $this->uri->segment(3)=='listarAccesos' || $this->uri->segment(3)=='registrar' || $this->uri->segment(3)=='modificar' || $this->uri->segment(3)=='listarCaducados')){
		echo '$("#house").hide();';
		echo '$("#usu").show();';
		echo '$("#inter").hide();';
		echo '$("#mante").hide();';
		echo '$("#niv").hide();';
		echo '$("#base").hide();';
	}
	
	if($this->uri->segment(2)=='sistema' || $this->uri->segment(2)=='fichas' && ($this->uri->segment(3)=='listarMenu' || $this->uri->segment(3)=='listarSubMenu' || $this->uri->segment(3)=='listarBarra' || $this->uri->segment(3)=='listarEstado' || $this->uri->segment(3)=='listarAplicaciones' || $this->uri->segment(3)=='listarMenuFicha')){
		echo '$("#house").hide();';
		echo '$("#usu").hide();';
		echo '$("#inter").show();';
		echo '$("#mante").hide();';
		echo '$("#niv").hide();';
		echo '$("#base").hide();';
	}
	
	if(($this->uri->segment(2)=='sistema' || $this->uri->segment(2)=='estratos' || $this->uri->segment(2)=='student') && ($this->uri->segment(3)=='listarEnfermedades' || $this->uri->segment(3)=='listarClasificacion' || $this->uri->segment(3)=='listarDiagno' || $this->uri->segment(3)=='listarEtnias' || $this->uri->segment(3)=='listarSubEtnias' || $this->uri->segment(3)=='index')){
		echo '$("#house").hide();';
		echo '$("#usu").hide();';
		echo '$("#inter").hide();';
		echo '$("#mante").show();';
		echo '$("#niv").hide();';
		echo '$("#base").hide();';
	}
	
	if($this->uri->segment(2)=='sistema' && ($this->uri->segment(3)=='listarDiresas' || $this->uri->segment(3)=='listarRedes' || $this->uri->segment(3)=='listarMicroredes' || $this->uri->segment(3)=='addMicrored' || $this->uri->segment(3)=='listarEstablecimientos' || $this->uri->segment(3)=='listarDepartamentos' || $this->uri->segment(3)=='listarProvincias' || $this->uri->segment(3)=='listarDistritos')){
		echo '$("#house").hide();';
		echo '$("#usu").hide();';
		echo '$("#inter").hide();';
		echo '$("#mante").hide();';
		echo '$("#niv").show();';
		echo '$("#base").hide();';
	}
	
	if($this->uri->segment(2)=='sistema' || $this->uri->segment(2)=='reportes' || $this->uri->segment(2)=='exportar' || $this->uri->segment(2)=='calidad' || $this->uri->segment(3)=='listarCierre' || $this->uri->segment(3)=='listarAuditoria' || $this->uri->segment(3)=='proceso' || $this->uri->segment(3)=='notificacion' || $this->uri->segment(3)=='notificacionAutoriza' || $this->uri->segment(3)=='exportar' || $this->uri->segment(3)=='boletines' || $this->uri->segment(3)=='listarCierreModulos'){
		echo '$("#house").hide();';
		echo '$("#usu").hide();';
		echo '$("#inter").hide();';
		echo '$("#mante").hide();';
		echo '$("#niv").hide();';
		echo '$("#base").show();';
	}
	
	if($this->uri->segment(2)=='index' && ($this->uri->segment(3)=='logout')){
		echo '$("#house").hide();';
		echo '$("#usu").hide();';
		echo '$("#mante").hide();';
		echo '$("#niv").hise();';
		echo '$("#base").show();';
	}
	?>
});
</script>

<ul class="menu">
    <li class="item0"><a href="#">Inicio <span>01</span></a>
        <ul id="house">
            <li id="home" class="subitem1"><a href="<?php echo site_url('backend/index/principal'); ?>">Principal </a></li>
        </ul>
    </li>
    <li class="item1"><a href="#">Usuarios <span>06</span></a>
        <ul id="usu">
            <?php if($this->session->userdata('nivel') == '1'){?>
            <li><a href="<?php echo site_url('backend/usuario/listarUsuariosAdministradores'); ?>">Usuarios Administradores </a></li><?php }?>
            <li><a href="<?php echo site_url('backend/usuario/listarUsuarios'); ?>">Usuarios Operadores </a></li>
            <li><a href="<?php echo site_url('backend/fichas/listarAccesos'); ?>">Usuarios Fichas </a></li>
            <li><a href="<?php echo site_url('backend/usuario/listarNiveles'); ?>">Niveles de usuario </a></li>
            <li><a href="<?php echo site_url('backend/usuario/listarTematicos'); ?>">Equipos Tem&aacute;ticos </a></li>
            <li><a href="<?php echo site_url('backend/usuario/listarCaducados'); ?>">Usuarios Caducados </a></li>
        </ul>
    </li>
    <li class="item6"><a href="#">Interface <span>06</span></a>
        <ul id="inter">
            <li><a href="<?php echo site_url('backend/sistema/listarMenu'); ?>">Men&uacute; del sistema </a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarSubMenu'); ?>">Sub-Men&uacute; del sistema </a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarBarra'); ?>">Barra de accesos </a></li>
            <li><a href="<?php echo site_url('backend/fichas/listarAplicaciones'); ?>">M&oacute;dulo de Fichas </a></li>
            <li><a href="<?php echo site_url('backend/fichas/listarMenuFicha'); ?>">Men&uacute; de Fichas </a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarEstado'); ?>">Estado de mantenimiento </a></li>
        </ul>
    </li>
    <li class="item2"><a href="#">Mantenimiento <span>07</span></a>
        <ul id="mante">
            <li><a href="<?php echo site_url('backend/sistema/listarEnfermedades'); ?>">Enfermedades vigiladas </a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarClasificacion'); ?>">Tipo de vigilancia </a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarDiagno'); ?>">Clasificaci&oacute;n de diagn&oacute;sticos </a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarEtnias'); ?>">Clasificaci&oacute;n de Etnias </a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarSubEtnias'); ?>">Clasificaci&oacute;n de Sub-Etnias </a></li>
            <li><a href="<?php echo site_url('backend/estratos/index'); ?>">Estratificaci&oacute;n de Mapas</a></li>
            <li><a href="<?php echo site_url('backend/student/index'); ?>">T de student</a></li>
        </ul>
    </li>
    <li class="item3"><a href="#">Niveles <span>07</span></a>
        <ul id="niv">
            <li><a href="<?php echo site_url('backend/sistema/listarDiresas'); ?>">Direcciones de salud </a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarRedes'); ?>">Redes de salud </a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarMicroredes'); ?>">Microredes de salud </a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarEstablecimientos'); ?>">Establecimientos de salud </a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarDepartamentos'); ?>">Departamentos </a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarProvincias'); ?>">Provincias </a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarDistritos'); ?>">Distritos </a></li>
        </ul>
    </li>
    <li class="item4"><a href="#">Notificaci&oacute;n <span>09</span></a>
        <ul id="base">
            <li><a href="<?php echo site_url('backend/exportar'); ?>">Descargar la base de datos</a></li>
            <li><a href="<?php echo site_url('backend/reportes/notificacionAutoriza'); ?>">Autorizaci&oacute;n de la notificaci&oacute;n</a></li>
            <li><a href="<?php echo site_url('backend/reportes/notificacion'); ?>">Reporte de notificaci&oacute;n</a></li>
            <li><a href="<?php echo site_url('backend/reportes/cobertura'); ?>">Reporte de coberturas</a></li>
            <li><a href="<?php echo site_url('backend/calidad'); ?>">Control de Calidad</a></li>
            <li><a href="<?php echo site_url('backend/reportes/boletines'); ?>">Tablas para boletines</a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarAuditoria'); ?>">Auditor&iacute;a</a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarCierre'); ?>">Cierre de Base de Datos </a></li>
            <li><a href="<?php echo site_url('backend/sistema/listarCierreModulos'); ?>">Cierre de m&oacute;dulos </a></li>
        </ul>
    </li>
    <li class="item5"><a href="#">Terminar sesión <span>01</span></a>
        <ul>
            <li><a href="<?php echo site_url('backend/index/logout');?>">Desconectar </a></li>
        </ul>
    </li>
</ul>