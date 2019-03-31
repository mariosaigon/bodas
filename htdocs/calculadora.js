

    //////////////////7INICIO PASTEL
   
$('input[name=pastel]').click(function() 
{
  var precioUnitarioPastel=0;
    var invitados=document.getElementById("invitados").value;
    console.log("El número de invitados es : "+invitados);
  if(invitados.localeCompare("")==0)
  {
    alert("Indique la cantidad de invitados.");
  }

  else
  {
      var x = document.getElementById("consoPastel");
      if(document.getElementById("pastel").checked == true)
        {
          console.log("apretado");
          
          if (x.style.display === "none") 
          {
          $(x).show('slow');
          }   
          //rango de precios
          if(invitados<=50)
          {
            precioUnitarioPastel=1.55;
          }

          if(invitados>50 && invitados<150)
          {
            precioUnitarioPastel=1.50;
          }

          if(invitados>150)
          {
            precioUnitarioPastel=1.45;
          }





           //al final, muestro precio final
           var precioFinal=invitados*precioUnitarioPastel;
            precioFinal=Math.round(precioFinal * 100) / 100;
           console.log("El precio final es: "+precioFinal);
           $('#preciopastel').text('$'+precioFinal);
        }
        else
        {
            console.log("desapretado");
            $(x).hide('slow');        
        }
   
  } //fin de else si no hayinvitados
  
  
});
    //////////// FIN PASTEL

    //inicio sweet pack
$('input[name=sweet]').click(function() 
{
  var precioUnitarioPastel=0;
    var invitados=document.getElementById("invitados").value;
    console.log("El número de invitados es : "+invitados);
  if(invitados.localeCompare("")==0)
  {
    alert("Indique la cantidad de invitados.");
  }

  else
  {
      var x = document.getElementById("consoSweet");
      if(document.getElementById("sweet").checked == true)
        {
          console.log("apretado");
          
          if (x.style.display === "none") 
          {
          $(x).show('slow');
          }   
          //rango de precios
          if(invitados<=50)
          {
            precioUnitarioPastel=3.15;
          }

          if(invitados>50 && invitados<150)
          {
            precioUnitarioPastel=3.00;
          }

          if(invitados>150)
          {
            precioUnitarioPastel=2.95;
          }

           //al final, muestro precio final
           var precioFinal=invitados*precioUnitarioPastel;
           precioFinal=Math.round(precioFinal * 100) / 100;
           console.log("El precio final es: "+precioFinal);
           $('#preciosweet').text('$'+precioFinal);
        }
        else
        {
            console.log("desapretado");
            $(x).hide('slow');        
        }
   
  } //fin de else si no hayinvitados
  
  
});






    /////// fin sweet pack





