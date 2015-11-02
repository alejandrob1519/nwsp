function encry(){
    //form1.codigo.value=document.form1.clave.value;
    form1.clave.value=encriptar(document.form1.clave.value);
}

function confirmar(url){
	if(confirm("Realmente desea eliminar este registro?")){
		window.location=url;
	}
}

function popup(URL)
{
	window.open(URL, "Consultas", "width=1000,height=600,hotkeys=no");
}

function caducidad()
{
	var x = form1.mes.value;
	var y = form1.anio.value;
	
	switch(x){
		case '1':
		var sumarDias=parseInt(5);
	   
		var fecha=y+"/"+"01"+"/"+"31";
		
		fecha=fecha.replace("-", "/").replace("-", "/");   
	   
		fecha= new Date(fecha);
		fecha.setDate(fecha.getDate()+90);
	   
		var anio=fecha.getFullYear();
		var mes= fecha.getMonth();
		var dia= fecha.getDate();
	   
		if(mes.toString().length<2){
		  mes="0".concat(mes);        
		}    
	   
		if(dia.toString().length<2){
		  dia="0".concat(dia);        
		}

		form1.fecha_cad.value = dia+"/"+mes+"/"+anio;
		break;
		case '2':
		var sumarDias=parseInt(5);
	   
		var fecha=y+"/"+"02"+"/"+"28";
		
		fecha=fecha.replace("-", "/").replace("-", "/");   
	   
		fecha= new Date(fecha);
		fecha.setDate(fecha.getDate()+90);
	   
		var anio=fecha.getFullYear();
		var mes= fecha.getMonth();
		var dia= fecha.getDate();
	   
		if(mes.toString().length<2){
		  mes="0".concat(mes);        
		}    
	   
		if(dia.toString().length<2){
		  dia="0".concat(dia);        
		}

		form1.fecha_cad.value = dia+"/"+mes+"/"+anio;
		break;
		case '3':
		var sumarDias=parseInt(5);
	   
		var fecha=y+"/"+"03"+"/"+"31";
		
		fecha=fecha.replace("-", "/").replace("-", "/");   
	   
		fecha= new Date(fecha);
		fecha.setDate(fecha.getDate()+90);
	   
		var anio=fecha.getFullYear();
		var mes= fecha.getMonth();
		var dia= fecha.getDate();
	   
		if(mes.toString().length<2){
		  mes="0".concat(mes);        
		}    
	   
		if(dia.toString().length<2){
		  dia="0".concat(dia);        
		}

		form1.fecha_cad.value = dia+"/"+mes+"/"+anio;
		break;
		case '4':
		var sumarDias=parseInt(5);
	   
		var fecha=y+"/"+"04"+"/"+"30";
		
		fecha=fecha.replace("-", "/").replace("-", "/");   
	   
		fecha= new Date(fecha);
		fecha.setDate(fecha.getDate()+90);
	   
		var anio=fecha.getFullYear();
		var mes= fecha.getMonth();
		var dia= fecha.getDate();
	   
		if(mes.toString().length<2){
		  mes="0".concat(mes);        
		}    
	   
		if(dia.toString().length<2){
		  dia="0".concat(dia);        
		}

		form1.fecha_cad.value = dia+"/"+mes+"/"+anio;
		break;
		case '5':
		var sumarDias=parseInt(5);
	   
		var fecha=y+"/"+"05"+"/"+"31";
		
		fecha=fecha.replace("-", "/").replace("-", "/");   
	   
		fecha= new Date(fecha);
		fecha.setDate(fecha.getDate()+90);
	   
		var anio=fecha.getFullYear();
		var mes= fecha.getMonth();
		var dia= fecha.getDate();
	   
		if(mes.toString().length<2){
		  mes="0".concat(mes);        
		}    
	   
		if(dia.toString().length<2){
		  dia="0".concat(dia);        
		}

		form1.fecha_cad.value = dia+"/"+mes+"/"+anio;
		break;
		case '6':
		var sumarDias=parseInt(5);
	   
		var fecha=y+"/"+"06"+"/"+"30";
		
		fecha=fecha.replace("-", "/").replace("-", "/");   
	   
		fecha= new Date(fecha);
		fecha.setDate(fecha.getDate()+90);
	   
		var anio=fecha.getFullYear();
		var mes= fecha.getMonth();
		var dia= fecha.getDate();
	   
		if(mes.toString().length<2){
		  mes="0".concat(mes);        
		}    
	   
		if(dia.toString().length<2){
		  dia="0".concat(dia);        
		}

		form1.fecha_cad.value = dia+"/"+mes+"/"+anio;
		break;
		case '7':
		var sumarDias=parseInt(5);
	   
		var fecha=y+"/"+"07"+"/"+"31";
		
		fecha=fecha.replace("-", "/").replace("-", "/");   
	   
		fecha= new Date(fecha);
		fecha.setDate(fecha.getDate()+90);
	   
		var anio=fecha.getFullYear();
		var mes= fecha.getMonth();
		var dia= fecha.getDate();
	   
		if(mes.toString().length<2){
		  mes="0".concat(mes);        
		}    
	   
		if(dia.toString().length<2){
		  dia="0".concat(dia);        
		}

		form1.fecha_cad.value = dia+"/"+mes+"/"+anio;
		break;
		case '8':
		var sumarDias=parseInt(5);
	   
		var fecha=y+"/"+"08"+"/"+"31";
		
		fecha=fecha.replace("-", "/").replace("-", "/");   
	   
		fecha= new Date(fecha);
		fecha.setDate(fecha.getDate()+90);
	   
		var anio=fecha.getFullYear();
		var mes= fecha.getMonth();
		var dia= fecha.getDate();
	   
		if(mes.toString().length<2){
		  mes="0".concat(mes);        
		}    
	   
		if(dia.toString().length<2){
		  dia="0".concat(dia);        
		}

		form1.fecha_cad.value = dia+"/"+mes+"/"+anio;
		break;
		case '9':
		var sumarDias=parseInt(5);
	   
		var fecha=y+"/"+"09"+"/"+"30";
		
		fecha=fecha.replace("-", "/").replace("-", "/");   
	   
		fecha= new Date(fecha);
		fecha.setDate(fecha.getDate()+90);
	   
		var anio=fecha.getFullYear();
		var mes= fecha.getMonth();
		var dia= fecha.getDate();
	   
		if(mes.toString().length<2){
		  mes="0".concat(mes);        
		}    
	   
		if(dia.toString().length<2){
		  dia="0".concat(dia);        
		}

		form1.fecha_cad.value = dia+"/"+mes+"/"+anio;
		break;
		case '10':
		var sumarDias=parseInt(5);
	   
		var fecha=y+"/"+"10"+"/"+"31";
		
		fecha=fecha.replace("-", "/").replace("-", "/");   
	   
		fecha= new Date(fecha);
		fecha.setDate(fecha.getDate()+90);
	   
		var anio=fecha.getFullYear();
		var mes= fecha.getMonth();
		var dia= fecha.getDate();
	   
		if(mes.toString().length<2){
		  mes="0".concat(mes);        
		}    
	   
		if(dia.toString().length<2){
		  dia="0".concat(dia);        
		}

		form1.fecha_cad.value = dia+"/"+mes+"/"+anio;
		break;
		case '11':
		var sumarDias=parseInt(5);
	   
		var fecha=y+"/"+"11"+"/"+"30";
		
		fecha=fecha.replace("-", "/").replace("-", "/");   
	   
		fecha= new Date(fecha);
		fecha.setDate(fecha.getDate()+90);
	   
		var anio=fecha.getFullYear();
		var mes= fecha.getMonth();
		var dia= fecha.getDate();
	   
		if(mes.toString().length<2){
		  mes="0".concat(mes);        
		}    
	   
		if(dia.toString().length<2){
		  dia="0".concat(dia);        
		}

		form1.fecha_cad.value = dia+"/"+mes+"/"+anio;
		break;
		case '12':
		var sumarDias=parseInt(5);
	   
		var fecha=y+"/"+"12"+"/"+"31";
		
		fecha=fecha.replace("-", "/").replace("-", "/");   
	   
		fecha= new Date(fecha);
		fecha.setDate(fecha.getDate()+90);
	   
		var anio=fecha.getFullYear();
		var mes= fecha.getMonth();
		var dia= fecha.getDate();
	   
		if(mes.toString().length<2){
		  mes="0".concat(mes);        
		}    
	   
		if(dia.toString().length<2){
		  dia="0".concat(dia);        
		}

		form1.fecha_cad.value = dia+"/"+mes+"/"+anio;
		break;
	}
}

function caduca(){
	x = document.form1.activar.value;
	
	if(x == 'on'){
		document.form1.fecha_cad.disabled=false;
	}else{
		document.form1.fecha_cad.disabled=true;
	}
}
