/*

Cambiar texto ingles de botones en bootstrap-tour.min.js
template: .....
&laquo; Prev
Next &raquo;
Pause</button>
End tour</button>
*/

$(document).ready(function(){
	
	(function(){
		var requerido = "<br><span style='color:red;'> Campo Requerido</span>";
		var tour = new Tour({
			storage : false
		});
		
		tour.addSteps([
			/* Principal*/
			{
			element: ".nav.navbar-nav",
			placement: "bottom",
			backdrop: true,
			title: "Bienvenido " + $('#nombreUsuario').text(),
			content: "Este es el MENU PRINCIPAL. Puedes darle clic en cada uno de ellos para ver en contenido (SUBMENUS)"
			},
		  
		  	{
		    element: ".row-centered",
		    placement: "bottom",
		    backdrop: true,
		    title: "Acceso Directo",
		    content: "Estos son los 3 accesos mas frecuentes NUEVA FICHA | LISTAR FICHAS | EXPORTAR."
		  	},

			/* Nueva Ficha*/
			{
			element: ".segmented-control",
			placement: "bottom",
			backdrop: true,
			title: "Hola " + $('#nombreUsuario').text(),
			content: "Debes elegir una de las fuentes de financiamiento" + requerido
			},
		  
		  {
		    element: "#eess_notificante",
		    placement: "bottom",
		    backdrop: true,
		    title: "Establecimiento notificante",
		    content: "Eess que notifica la ficha de transito." + requerido
		  },
		  {
		    element: ".nav.nav-tabs",
		    placement: "top",
		    backdrop: true,
		    title: "Pestañas de Ficha",
		    content: "para desplazarce por cada Pestaña puedes hacer clic en cada uno de ellos ó en el boton siguiente/atras de abajo.",
		    onNext : function(tour){
		    	$('#ref_es').prop('checked', true);
		    	element = document.getElementById("contenido_oculto");
	    		element.style.display='block';
	    	}
		  },
		  {
		    element: "#bloque1",
		    placement: "top",
		    backdrop: true,
		    title: "Historia Clinica y Referencia",
		    content: "Ingresar el numero de historia clinica y de ser el caso el eess de la REFERENCIA de donde procede (origen)"
		  },
		  {
		    element: "#bloque1",
		    placement: "bottom",
		    backdrop: true,
		    title: "en proceso..",
		    content: "Estamos en proceso de culminar nuestro manual en linea, si le es util comentanos al correo institucional notificacion@dge.gob.pe"
		  },
		  {
		    element: ".finallll",
		    placement: "top",
		    backdrop: true,
		    orphan: true,
		    title: "Gracias!!.",
		    content: function(){ return "por tomarte un tiempo, "+$('#nombreUsuario').text()+"!" }
		  },

		]);

		// Initialize the tour
		tour.init();

		// Start the tour
		$('#iniciar-manual').on('click', function(){
			tour.restart();
		});



	}());






});
