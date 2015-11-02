<?php
$ano1 = $anio-2;
$ano2 = $anio-1;
$ano3 = $anio;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->layout->getTitle(); ?></title>
<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />
<link href="<?php echo base_url()?>public/css/blitzer/jquery-ui-1.10.4.custom.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/pro_drop_1.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/index.css" rel='stylesheet' type='text/css' media='all' />
<script type="text/javascript" src="<?php echo base_url();?>public/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/highcharts/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/highcharts/js/modules/exporting.js"></script>

<script language="javascript">
$(function () {
	$("#cargando").fadeIn(100);
	var highchartsOptions = Highcharts.setOptions(Highcharts.theme);		 
	Highcharts.setOptions({
		lang: {
				decimalPoint: ',',
				resetZoom: 'Reset zoom',
				resetZoomTitle: 'Reset zoom à 1:1',
				downloadPNG: "Descargar en formato imágen PNG",
				downloadJPEG: "Descargar en formato imágen JPEG",
				downloadPDF: "Descargar en formato documento PDF",
				downloadSVG: "Descargar en formato vector imágen SVG",
				exportButtonTitle: "Exportar imágen o documento",
				printChart: "Imprimir el gráfico",
				loading: "Cargando..."
		}
	  });			
	  $('#centroArriba').highcharts({
		  chart: {
			  type: 'column'
		  },
		  title: {
			  enabled: false,
			  text: ''
		  },
		  subtitle: {
			  text: ''
		  },
		  xAxis: {
			type: 'category',
            plotLines: [{ 
/*                color: '#E6E6E6',
                width: 420,
                value: 76,
                id: 'plotline-1'
*/            }],
			labels: {
				  maxStaggerLines: 1,
				  rotation: -90,
				  align: 'right',
				  style: {
					  fontSize: '8px',
					  fontFamily: 'Verdana, sans-serif'
				  }
			  }
		  },
		  yAxis: {
			  min: 0,
			  title: {
				  text: 'Casos notificados'
			  },
			  labels: {
				  style: {
					  fontSize: '8px',
					  fontFamily: 'Verdana, sans-serif'
				  },
				  formatter: function() {
					  return this.value / 1;
				  }
			  }
		  },
		  legend: {
			  enabled: false,
			  title: 
			  {
				  text: <?php echo $ano1." | ".$ano2." | ".$ano3;?>
			  }
		  },
		  tooltip: {
			  pointFormat: 'Casos: <b>{point.y}</b>',
		  },
		  series: [{
			  name: 'Semanas Epidemiológicas',
			  data: (<?php echo $array;?>),
			  dataLabels: {
				  enabled: false,
				  rotation: -90,
				  color: '#FFFFFF',
				  align: 'right',
				  x: 4,
				  y: 10,
				  style: {
					  fontSize: '10px',
					  fontFamily: 'Verdana, sans-serif',
					  textShadow: '0 0 3px black'
				  }
			  }
		  }]
	  });

	  $('#centroIzquierda').highcharts({
		  chart: {
			  type: 'column'
		  },
		  title: {
			  enabled: false,
			  text: ''
		  },
		  subtitle: {
			  text: ''
		  },
		  xAxis: {
			  type: 'category',
			  labels: {
				  maxStaggerLines: 1,
				  align: 'center',
				  style: {
					  fontSize: '8px',
					  fontFamily: 'Verdana, sans-serif'
				  }
			  }
		  },
		  yAxis: {
			  min: 0,
			  title: {
				  text: 'Casos notificados'
			  },
			  labels: {
				  style: {
					  fontSize: '8px',
					  fontFamily: 'Verdana, sans-serif'
				  },
				  formatter: function() {
					  return this.value / 1;
				  }
			  }
		  },
		  legend: {
			  enabled: false
		  },
		  tooltip: {
			  pointFormat: 'Casos: <b>{point.y}</b>',
		  },
		  series: [{
			  name: 'Años',
			  data: (<?php echo $array1;?>),
			  dataLabels: {
				  enabled: false,
				  rotation: -90,
				  color: '#FFFFFF',
				  align: 'right',
				  x: 4,
				  y: 10,
				  style: {
					  fontSize: '10px',
					  fontFamily: 'Verdana, sans-serif',
					  textShadow: '0 0 3px black'
				  }
			  }
		  }]
	});

	$('#centroDerecha').highcharts({
		chart: {
			type: 'area'
		},
		colors: ['#F3F781', '#81F7D8', '#ffffff', '#08088A', '#1aadce', 
	   '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a'],
		title: {
			text: ''
		},
		subtitle: {
			text: ''
		},
		xAxis: {
			categories: (<?php echo $array6;?>),
            plotLines: [{ 
                color: '#F78181',
                width: 490,
                value: 26,
                id: 'plotline-1'
            }],
			tickmarkPlacement: 'on',
			title: {
				enabled: false
			},
			  labels: {
				  maxStaggerLines: 1,
				  align: 'center',
				  style: {
					  fontSize: '8px',
					  fontFamily: 'Verdana, sans-serif'
				  }
			  }
		},
		yAxis: {
			title: {
				text: 'Casos notificados'
			},
			labels: {
				style: {
					fontSize: '8px',
					fontFamily: 'Verdana, sans-serif'
				},
				formatter: function() {
					return this.value / 1;
				}
			}
		},
		tooltip: {
		        crosshairs: true,
		        shared: true,
		        valueSuffix: ' Casos'
		},
		plotOptions: {
			area: {
				stacking: 'normal',
				lineColor: '#666666',
				lineWidth: 0,
				marker: {
					enabled: false,
					lineWidth: 0,
					lineColor: '#666666'
				}
			}
		},
		series: [{
			<?php echo $array4;?>
		}, {
			<?php echo $array3;?>
		}, {
			<?php echo $array2;?>
		},
		{
			type: 'column',
			<?php echo $array5; ?>
		}]
	});
	
	$('#cargando').fadeOut(500);
});
</script>

<script language="javascript">
$(window).on('load', function(){
	$('#cargando').fadeOut(500);
}); 
</script>

</head>

<body>
<div id="cargando" 
    style="cursor:pointer;
    background-image: url(<?php echo base_url();?>public/images/cargando.gif);
    background-repeat:no-repeat;
    background-position:center;
    background-size:10%;
    background-color: rgba(0, 0, 0, 0.7);
    width:100%;
    height:100%;
    color:#fff;
    text-align:center;
    height:92%;
    position:absolute;
    top:0;
    left:0;
    z-index:6;
    display: block;
    opacity: 1;">
</div>
<link href="<?php echo base_url();?>public/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />

<div class="headerNotiWeb">
<?php
	$session_id = $this->session->userdata('usuario');
	$nivel_id = $this->session->userdata('nivel');
	$grabar_id = $this->session->userdata('grabar');
	$nivel = $this->login_model->buscarNivel($nivel_id);
?>
&nbsp;<b>DIRECCION GENERAL DE EPIDEMIOLOGIA</b> / Nivel: <?php echo $nivel->nombre; ?> / Usuario: <?php echo $session_id;?>
</div>

<div class="container">
    <!--El div que orderna los demás divs-->
    <div class='clearbox'></div>

    <!--El div que contiene el menú-->
    <div class="sidebar">
	  <?php
          include_once("public/menu/menu_frontend.php");
      ?>
    </div>

    <!--El div que contiene la barra de accesos-->
    <div class="sidebar">
	  <?php
          include_once("public/menu/barra_frontend.php");
      ?>
    </div>

    <div class="content1">
	<?php
        $atributos = array('id'=>'form1', 'name'=>'form1');
        echo form_open(null, $atributos);
    ?>
    <fieldset class="formulario">
      <input type="button" id="botonSalir" name="salida" value="      Retornar" title="Retornar a la página anterior" onclick="javascript: location.href='graficos'" />
      <div class='contenedor'>
          <div style="font-size:14px; font-weight:bold; text-align:center; padding:15px;">Neumonías en menores de 5 años, por semanas epidemiológicas: Años <?php echo $ano1." - ".$ano2." - ".$ano3;?> - Nivel: <?php echo $vector;?></div>
          <div id="centroArriba"></div> 
          <div id="centroIzquierda"></div> 
          <div id="centroDerecha"></div> 
      </div>
    </fieldset>
    <?php
        echo form_close();
    ?>
    </div>
</div>
<div class="footer">
    <p><?php echo "NotiWeb, pertenece a la Direcci&oacute;n General de Epidemiolog&iacute;a del Ministerio de Salud del Per&uacute;.";?></p>
    <p><?php echo "Copyright (c) ".date("Y"). ". Todos los derechos reservados.";?></p>
</div>
</body>
</html>

