var numInvitados;
var sumaProbabilidad=0;
function getValueUsingParentTag(){
	var chkArray = [];
	
	/* look for all checkboes that have a parent id called 'checkboxlist' attached to it and check if it was checked */
	$("#macizo input:checked").each(function() {
		chkArray.push($(this).val());
	});
	
	/* we join the array separated by the comma */
	var selected;
	selected = chkArray.join(',') ;
	
	/* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
	if(selected.length > 0)
	{
		//alert("You have selected " + selected);	
		return selected;
	}
	else
	{
		alert("No se ha seleccionado ninguna bebida");	
	}
}
function calculaPrecio(arrayBebidas)
{
$.ajax({
                        url:"calculaPrecio.php?bebidas="+arrayBebidas+"&invitados="+numInvitados,
                        success:function(result)
                        {
							   //tengo un array de ids de documentos que corresponde a esta estadística que me piden.
                              datosf1 = JSON.parse(result);
                             	 var cantidadCompletos=0;
                                 var arrayNombres=[];
                                 var arrayPrecios=[];
                             //alert(datosf1);
                              for (var index in datosf1) 
                              {
                             
                              arrayNombres.push(datosf1[index][0])
                              arrayPrecios.push(datosf1[index][1])
                              
                              
                             }

                             // var id=datosf1[0];
                             // var institucion=datosf1[1];
                             // var autoridadProp=datosf1[2];
                             // var autoridadSup=datosf1[3];
                             // var tegProp=datosf1[4];
                             // var tegSup=datosf1[5];
                             // var sprop=datosf1[6];
                             // var splup=datosf1[7];
                            
											
			var textofinal=""	
			var cabecita='<div class="box box-success box-solid"><div class="box-header with-border"><h3 class="box-title">Resumen de tu barra libre</h3></div><div class="box-body">'				
			var texto="<table id='data2' class=\"table table-bordered table-striped\"><thead><tr><th>Nombre de la bebida</th><th>Precio por persona</th></tr></thead><tbody>" 
			var contenido=""

			var cont=1;
			var precioTotal=0;
			         for (var index in arrayNombres) 
                              {

                              	contenido=contenido+"<tr>"
                              contenido=contenido+"<td>"
                              contenido=contenido+arrayNombres[index]
                              contenido=contenido+"</td>"
                              cont++;


                        
                              contenido=contenido+"<td>$ "
                              contenido=contenido+arrayPrecios[index]
                              contenido=contenido+"</td>"
                        
                              precioTotal=precioTotal+arrayPrecios[index];
                              precioTotal=Math.round(precioTotal * 100) / 100;

                              contenido=contenido+"</tr>"
                             }
                             
             //var totalito= arrayCantidades.reduce(function(a, b) { return a + b; }, 0);
			var finalTabla="<tfoot><tr><td>TOTAL</td><td><b> $"+Number(precioTotal)+"</b></td></tr></tfoot></tbody></table></div></div>"
			textofinal=cabecita+texto+contenido+finalTabla
			document.getElementById("tabla").innerHTML = textofinal
			$('#data2').DataTable({
					dom: 'Bfrtip',
					buttons: [
						{ extend: 'copy', text: 'Copiar' },
						{ extend: 'csvHtml5', title: 'CSV' },
						{ extend: 'excelHtml5', title: 'Excel' },
						{ extend: 'pdfHtml5', title: 'PDF' },
						{ extend: 'print', text: 'Imprimir' },
					],
					'language': {
						'search': 'Buscar',
						'emptyTable': 'Tabla vacía',
						'info': 'Mostrando todas las comisiones de este informe',
						'infoEmpty': 'Está vacía esta tabla',
						'infoFiltered': 'Filtrada',
						'lengthMenu': 'Longitud',
						'loadingRecords': 'Cargando registros',
						'processing': 'Procesando',
						'zeroRecords': 'Sin registros',
						'paginate': {
							'first': 'Primera',
							'last': 'Última',
							'next': 'Siguiente',
							'previous': 'Anterior'
						}
					}
				});// fin de dibujar botones
  								
                        } // fin de success						
						//console.log("b: "+dataf1[1])
                    }); //fin del ajax
}

$("#cantidadInvitados").change(function()
{
        //alert("Añadida cantidad de invitados");
        $( "#contenedorInvitados" ).removeClass( "has-error" );
        $( "#contenedorInvitados" ).addClass( "has-success" );
        numInvitados=$("#cantidadInvitados").val();
    });
///////////////////////////////////////////////
$('input:checkbox').change( //escucho cambios de checkbox
    function(){
        if ($(this).is(':checked')) //si marco una bebida
        {
        	var cantidad=$("#cantidadInvitados").val();
        	if(cantidad.localeCompare("")==0)//si no hay cantidad de invitados; dar error y no hacer nada
        	{
        		alert("Por favor, indicanos el número de invitados a tu evento");
        		// 1 deschequeo lo marcado
        		$(this).prop("checked", false);

        		//2 pongo en clase error roja el input de invitados cantidad
        		$( "#contenedorInvitados" ).addClass("has-error");
        	}

        	else
        	{
        		//hacer cuestiones con los precios
        		//console.log("Id de la bebida seleccionado "+this.value);
        		var seleccionadas=getValueUsingParentTag();
        		console.log("seleccionadas: "+seleccionadas);
        		calculaPrecio(seleccionadas);
        		
		     }// FIN DEL ELSE
            
        }

        else //si la quito (descmarco una bebida)
        {
        	var seleccionadas=getValueUsingParentTag();
        	console.log("seleccionadas: "+seleccionadas);
        	calculaPrecio(seleccionadas);
        }	
});
           