<nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand hidden-sm" href="<?php echo base_url();?>"><img src="<?php echo base_url()?>assets/images/logo.png" width="260" /></a>
  </div>

  <div class="collapse navbar-collapse navbar-ex1-collapse" id="menu-principal">
    <ul class="nav navbar-nav">
        <li class="item0"><a href="<?php echo site_url('sifilisMaterna/principal'); ?>"><strong><i class="fa fa-home"></i> Inicio</strong></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <strong><i class="fa fa-table"></i> Fichas</strong> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo site_url('sifilisMaterna/listarCasos');?>"><i class="fa fa-file-text-o"></i> Nueva Ficha</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo site_url('sifilisMaterna/listarSifilis');?>"><i class="fa fa-list"></i> Listar Fichas</a></li>            
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <strong><i class="fa fa-cog"></i> Reportes/Procesos</strong> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo site_url('sifilisMaterna/exportarSifilis');?>"><i class="fa fa-database"></i> Exportar Base Datos</a></li>
            <li class="divider"></li>
            <li><a href="#"><i class="fa fa-bar-chart"></i> Generar Gr&aacute;ficos</a></li>
            <li class="divider"></li>
            <li><a href="#"><i class="fa fa-line-chart"></i> Seguimiento de casos</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <strong><i class="fa fa-file"></i> Documentos</strong> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url('public/tmp/ficha_sifilis_materna.pdf');?>" target="_blank" download><i class="fa fa-download"></i>
              Formato Ficha</a>
            </li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url('public/tmp/Directiva_sifilis_materna.pdf');?>" target="_blank" download><i class="fa fa-download"></i>
              Norma Tecnica</a>
            </li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url('public/tmp/Diccionario_de_variables_sifilis_materna_congenita.pdf');?>" target="_blank" download><i class="fa fa-download"></i>
              Diccionario Variables</a>
            </li>
          </ul>
        </li>
        <li ><a href="<?php echo site_url('index/principal');?>"><strong><i class="fa fa-sign-out"></i> Salir</strong></a></li>
     </ul>
  </div>
</nav>