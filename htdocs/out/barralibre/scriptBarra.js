var numInvitados;
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
        if ($(this).is(':checked')) 
        {
        	var cantidad=$("#cantidadInvitados").val();
        	if(cantidad.localeCompare("")==0)//si no hay cantidad de invitados; dar error y no hacer nada
        	{
        		alert("Cantidad de invitados vacía");
        		// 1 deschequeo lo marcado
        		$(this).prop("checked", false);

        		//2 pongo en clase error roja el input de invitados cantidad
        		$( "#contenedorInvitados" ).addClass( "has-error" );
        	}

        	else
        	{
        		//hacer cuestiones con los precios
        		console.log("Id de la bebida seleccionado "+this.value);
        		console.log("Cantidad de invitados: "+numInvitados);
        	}
            
        }
});
           


function myFunction() {
	// 	var error = document.getElementById("fechita").value;
	// if(error == "")
	// {
 //    alert("NO FECHA")
  
	// }
	//para hacer la consulta necesito tres cosas: si quiere institucion o municipalidad, fecha inicio, fecha fin
  var x = document.getElementById("estadistica").value; //console.log("ID grupo: "+x);
  //console.log("You selected: " + x);
   var dataf1=[];
   var arrayInstituciones=[];

   //console.log("ANTES DEL AJAX------------FECHA INICIO:"+fechaInicio);
	$.ajax({
                        url:"consultaConformadas.php?estadistica="+x,
                        success:function(result)
                        {
							   //tengo un array de ids de documentos que corresponde a esta estadística que me piden.
                              datosf1 = JSON.parse(result);
                              var cantidadCompletos=0;
                             //alert(result);
                              for (var index in datosf1) 
                              {
                             
                              arrayInstituciones.push(datosf1[index][0])
                              
                              
                             }

                             // var id=datosf1[0];
                             // var institucion=datosf1[1];
                             // var autoridadProp=datosf1[2];
                             // var autoridadSup=datosf1[3];
                             // var tegProp=datosf1[4];
                             // var tegSup=datosf1[5];
                             // var sprop=datosf1[6];
                             // var splup=datosf1[7];
                            
								
			var cabecerilla=""	
			if(x==1)
			{
				cabecerilla="Comisiones de instituciones del Gobierno Central";
			}
			if(x==2)
			{
				cabecerilla="Comisiones de municipalidades";
			}
			if(x==3)
			{
				cabecerilla="Comisionados - Instituciones y municipalidades exoneradas de conformar CEG";
			}				
			var textofinal=""	
			var cabecita='<div class="box box-success box-solid"><div class="box-header with-border"><h3 class="box-title">Reporte de comisiones no conformadas del tipo '+cabecerilla+' </h3></div><div class="box-body">'				
			var texto="<table id='data2' class=\"table table-bordered table-striped\"><thead><tr><th>N°</th><th>Institución</th></tr></thead><tbody>" 
			var contenido=""

			var cont=1;
			         for (var index in arrayInstituciones) 
                              {

                              	contenido=contenido+"<tr>"
                              contenido=contenido+"<td>"
                              contenido=contenido+cont;
                              contenido=contenido+"</td>"
                              cont++;


                        
                              contenido=contenido+"<td>"
                              contenido=contenido+arrayInstituciones[index]
                              contenido=contenido+"</td>"


                        


                              contenido=contenido+"</tr>"
                             }
                             
             //var totalito= arrayCantidades.reduce(function(a, b) { return a + b; }, 0);
			var finalTabla="<tfoot><tr><td>TOTAL</td><td><b>"+Number(cont-1)+"</b></td></tr></tfoot></tbody></table></div></div>"
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
