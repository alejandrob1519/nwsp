$(document).ready(function () {
	//lanzar mensaje de alerta antes de efectuar borrado de registro en listarficha
$('.borrar-icon').live('click', function(){
   	var url = $(this).attr('href');
   	var accion = confirm('Estas seguro que deseas eliminar el registro?');
   	if(accion == true){
      location.href = url;
       return true;
	}else{
       return false;
   	}
});

});