$(document).on('ready',function(){
$("#boton-submit").attr("disabled","disabled");
//$("#Compras_descrecar").parent().append("<span> %</span>");
//$("#Compras_importeIIBB").attr('readonly','true');
 

$("#Compras_nrodefactura").keydown(function(event){
	solonumeromod(event);});
$("#Compras_importeIIBB").keydown(function(event){
	solonumeromod(event);});
$("#Compras_ivatotal").keydown(function(event){
		solonumeromod(event);});
$("#Compras_importeneto").keydown(function(event){
		solonumeromod(event);});

sumatotal();
//botonsubmit();

var checked=$("#Compras_iibb").attr('checked');
if(!(checked == "checked")){
   $("#Compras_importeIIBB").attr('readonly','true');
   $("#Compras_importeIIBB").val("");
}
$("#Compras_iibb").click(function() {  
        if($("#Compras_iibb").is(':checked')) {  
          $("#Compras_importeIIBB").removeAttr('readonly');
          $("#Compras_importeIIBB").val("");
                    
         // sumatotal();
        } else {  
            $("#Compras_importeIIBB").attr('readonly','true');
            $("#Compras_importeIIBB").val("");
           
          //  sumatotal();
        }  
    }); 
$("#Compras_iva").on('change',function() {  
       var value = $('option:selected', this).attr('value');
      if(value == 1){
        $("#Compras_ivatotal").attr('readonly',true);
      } else {
        $("#Compras_ivatotal").removeAttr('readonly');
      }
});
var valor=$('option:selected', '#Compras_tipofactura').attr('value');
if( valor == 3){
      $("#Compras_ivatotal").val("");
      $("#Compras_ivatotal").attr('readonly',true);
}
$("#Compras_tipofactura").on('change',function() {  
     var value = $('option:selected', this).attr('value');
    if(value == 3){
      $("#Compras_ivatotal").val("");
      $("#Compras_ivatotal").attr('readonly',true);
    } else {
      $("#Compras_ivatotal").removeAttr('readonly');
    }
  });
 
});

function botonsubmit(){
 
  if($("#Compras_importeneto").val() == "") {
    //alert("style:"+tr+"---columnas: "+columnas);
    $("#boton-submit").attr("disabled","disabled");
    //$("#boton-submit").removeAttr("disabled"); }
   }else {
    //$("#boton-submit").attr("disabled","disabled");
    $("#boton-submit").removeAttr("disabled");
  }
  
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
function blockiva(){
  var totaliva=parseFloat($("#Compras_ivatotal").val());
  totalIvaTrasfor = $.number(totaliva, 2);
   $("#ivablock").text(totalIvaTrasfor);
}
function sumatotal(){

  var totalpercepcionIIBB=parseFloat($("#Compras_importeIIBB").val());
  var totaliva=parseFloat($("#Compras_ivatotal").val());
  var totalneto=parseFloat($("#Compras_importeneto").val());
  if(totalpercepcionIIBB >= totalneto || totaliva >= totalneto){
    alert("Importe IVA o Importe IIBB no pueden ser mayores que Importe Neto.")
    $("#Compras_ivatotal").val("");
    $("#Compras_importeneto").val("");
  }
  var seleccion=$('option:selected', "#Compras_tipofactura").attr('value');
  console.log(totaliva);
  if((seleccion == 1) && (isNaN(totaliva)) && (!isNaN(totalneto))){
   
     
    alert('Complete "Importe IVA" No puede ser nulo ');
     $("#Compras_importeneto").val("");
     

  }
  totalnetotransfor = $.number( totalneto, 2 );
  totalIvaTrasfor = $.number(totaliva, 2);
  $("#totalnetoblock").text(totalnetotransfor);
  
  $("#ivablock").text(totalIvaTrasfor);
  botonsubmit();
  }