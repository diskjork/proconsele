$(document).on('ready',function(){

$("label:contains('Fecha')").append('<span class="required">*</span>');
//$("label:contains('Descripcion')").append('<span class="required">*</span>')
$("span.wh-relational-column").append('<i class="icon-chevron-down"></i>');
$("span.wh-relational-column").find("i").tooltip({
	title: "Mostrar"
	});
//función para cambiar el ícono utilizado para desplegar el asiento en la grilla
$("span.wh-relational-column").find("i").click(function(){
 	var clase=$(this).attr('class');
 	switch(clase){
 		case "icon-chevron-down":
 			$(this).removeClass("icon-chevron-down");
 			$(this).addClass("icon-chevron-up");
 			$(this).tooltip('destroy');
 			$(this).tooltip({
				title: "Ocultar"
			});
 			break;
 		case "icon-chevron-up":
 			$(this).removeClass("icon-chevron-up");
 			$(this).addClass("icon-chevron-down");
 			$(this).tooltip('destroy');
 			$(this).tooltip({
				title: "Mostrar"
			});
 			break;
 	}
 	
});
formato();
$("#id_member").click(function(){
	newElem();
	
});
$("#boton-submit").click(function(){
	chekpartidadoble();
});
});
function formato(){
	var cont1=$("table.table.mmf_table > tbody > tr").size();
	var cont2=$("table.table.mmf_table > tbody > tr[style*='display:none;']").size();
	var cTR=cont1-cont2;
	for(i=1;i<=cTR;i++){
		var n=4*(i-1); 
		var id_input=$("td.mmf_cell:eq("+n+") > select").attr("id");
		//alert(id_input);
		if(id_input == null){
			var id_input=$("td.mmf_cell:eq("+n+") > input").attr("id");
			
		}

		var id=id_input;
		//alert(id);
		var cuenta=viewid(0,0,id,1);
		var debe=viewid(0,0,id,2);
		var haber=viewid(0,0,id,3);
		var index=viewid(0,0,id,4);
	

	$("#"+cuenta).css("width","100%");
	$("#"+debe).css("width","70px");
	$("#"+haber).css("width","70px");
	$("#"+debe).removeAttr("readonly");
	
	$("#"+haber).attr("readonly","true");
	
	}
}
function newElem(idinput){
	if(idinput == null){
		
	var cont1=$("table.table.mmf_table > tbody > tr").size();
	var cont2=$("table.table.mmf_table > tbody > tr[style*='display:none;']").size();
	var cTR=cont1-cont2;
	//alert(cTR);
		var n=4*(cTR-1); 
		var id_input=$("td.mmf_cell:eq("+n+") > select").attr("id");
		//alert(id_input);
		if(id_input == null){
			var id_input=$("td.mmf_cell:eq("+n+") > input").attr("id");
			
		}

		var id=id_input;
		//alert(id);
		var cuenta=viewid(0,0,id,1);
		var debe=viewid(0,0,id,2);
		var haber=viewid(0,0,id,3);
		var index=viewid(0,0,id,4);
	}

	$("#"+cuenta).css("width","100%");
	$("#"+debe).css("width","70px");
	$("#"+haber).css("width","70px");
	$("#"+debe).removeAttr("readonly");
	
	$("#"+haber).attr("readonly","true");
	
}

function debeBlock(id){
	var haber=viewid(1,1,id,3);
	var id_nro=viewid(1,1,id,5);
	if(id_nro != null){
		$(id_nro).tooltip('destroy');
	}
	$("#"+id).val(null);
	$("#"+id).removeAttr("readonly");
	$("#"+id).tooltip('destroy');
	$("#"+haber).val(null);
	$("#"+haber).attr("readonly","true");
	$("#"+haber).tooltip({
		title: "Toque para activar"
	});
	

}

function haberBlock(id){
	var debe=viewid(2,2,id,2);
	var id_nro=viewid(2,2,id,6);
	if(id_nro != null){
		$(id_nro).tooltip('destroy');
	}

	$("#"+id).val(null);
	$("#"+id).removeAttr("readonly");
	$("#"+id).tooltip('destroy');
	$("#"+debe).val(null);
	$("#"+debe).attr("readonly","true");
	$("#"+debe).tooltip({
		title: "Toque para activar"
	});
	
	
}
function solonumeromod(event) {
    if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
        (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode >= 35 && event.keyCode <= 39) || (event.keyCode == 110 || event.keyCode == 190) ) {
            return;
        }
        else {
        
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) ) {
                event.preventDefault();
            }
        }
    }

function chekpartidadoble(){
	
	var cTR=$("table.table.mmf_table > tbody > tr").size();
	var totaldebe=0;
	var totalhaber=0;
	if(cTR != 0){
		
	for(i=0;i < cTR;i++){
		var n=1;
		n=n+(4*i);
		m=n+1;
		var debe=parseFloat($( "td.mmf_cell:eq("+n+") > input" ).val());
		
			if(!isNaN(debe)){
				
				//debe=$.isNumeric(debe);
				console.log("n="+n+"\n debe="+debe);
				totaldebe=totaldebe + debe;
			}
		
		
		var haber=parseFloat($( "td.mmf_cell:eq("+m+") > input" ).val());
		
			if(!isNaN(haber)){
				
				//haber=$.isNumeric(haber);
				console.log("n="+n+"\n hebe="+haber);
				totalhaber=totalhaber+haber;
			}
			
	}
		
	}
	console.log("totaldebe="+totaldebe+"\nTotalhaber="+totalhaber);
	$("#Asiento_totalhaber").val(totalhaber);
	$("#Asiento_totaldebe").val(totaldebe);
}
function viewid(cantidad1,cantidad2, id , atributo){
	//cantidad2: para obtener el indice de los input sin error de validación
	//canitdad1: lo mismo de arriba pero en el caso de error 

	var novalidado="_n___"; //cdo los datos no se validan -> 5 unidades
	var update="_u___"; //cdo se actualiza la factura -> 5 unidads
	var id_input=id;
	//detalleasiento  
	var a=id_input.substring(14,19); //cadena desde cuando termina #detalleasiento" + "_n___" -> suma 19
	switch(cantidad1){
		case (0): //select cuenta_idcuenta
			var cant1=15;
			break;
		case (1): //input debe
			var cant1=4;
			break;
		case (2): //input haber
			var cant1=5;
			break;
		
		}
	switch(cantidad2){
	case (0): //input Detalleasiento_cuenta_idcuenta
		var cant2=30;
		break;
	case (1): //input Detalleasiento_debe
		var cant2=19;
		break;
	case (2): //input Detalleasiento_haber
		var cant2=20;
		break;
	
	}
 if( a == novalidado || a == update){
	 //alert("si");
		var strlargo= id_input.length;
		//alert(strlargo);
		var strfincadena= strlargo - cant1;
		//identificador del input "entero"
		indexid=id_input.substring(14,strfincadena);
		//número del identificador del input clonado
		var indice=indexid.substring(5,indexid.length);
		switch(atributo){
			case (1): //Tipo de cuenta "cuenta_idcuenta"
				var id_nombre_cuenta_idcuenta="Detalleasiento"+indexid+"cuenta_idcuenta";
				return id_nombre_cuenta_idcuenta;
				break;
			case (2): //Identificador de "debe"
				var id_nombre_debe="Detalleasiento"+indexid+"debe";
				return id_nombre_debe;
				break;
			case (3): //Identificador de "haber"
				var id_nombre_haber="Detalleasiento"+indexid+"haber";
				return id_nombre_haber;
				break;
			
			case (4): //devuelve el nro del elemento clonado
				return indice; 
				break;
			case (5) :  //para obtener el id del elemento anterior para el caso del tooltip
				var nro_anterior=indice - 1;
				
				if(nro_anterior  == 0 ){
					nro_anterior="";
				}
				var id_anterior="Detalleasiento"+a+nro_anterior+"debe";
				return id_anterior;
			case (6) : //para obtener el id del elemento anterior para el caso del tooltip
				var nro_anterior=indice - 1;
				if(nro_anterior  == 0 ){
					nro_anterior="";
				}
				var id_anterior="Detalleasiento"+a+nro_anterior+"haber";
				return id_anterior;
			} 
	}else {
		indexid = id_input.substring(cant2,id_input.length);
		switch(atributo){
		case (1): //Identificador "cuenta_idcuenta"
			var id_nombre_cuenta_idcuenta="Detalleasiento_cuenta_idcuenta"+indexid;
			return id_nombre_cuenta_idcuenta;
			break;
		case (2): //Identificador "debe"
				var id_nombre_debe="Detalleasiento_debe"+indexid;
				return id_nombre_debe;
				break;
		case (3): //Identificador "haber"
			var id_nombre_haber="Detalleasiento_haber"+indexid;
			return id_nombre_haber;
			break;
		case(4):
			
			//var indice=indexid.substring(5,indexid.length);
			return indexid;
			break;
		case (5) :  //para obtener el id del elemento anterior para el caso del tooltip
				if(parseInt(indexid) > 1){
					var nro_anterior= parseInt(indexid) - 2;
					if(nro_anterior == 0){
						var id_anterior="Detalleasiento_debe";
					} else {
						var id_anterior="Detalleasiento_debe"+nro_anterior;
					}
				return id_anterior;
				
				} else {
					return null;
				}
				
		case (6) : //para obtener el id del elemento anterior para el caso del tooltip
				if(parseInt(indexid) > 1){
					var nro_anterior= parseInt(indexid) - 2;
					if(nro_anterior == 0){
						var id_anterior="Detalleasiento_haber";
					} else {
						var id_anterior="Detalleasiento_haber"+nro_anterior;
					}
				return id_anterior;
				
				} else {
					return null;
				}
							
		}
		
	}
}