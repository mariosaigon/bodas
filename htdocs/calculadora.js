

    //////////////////7INICIO PASTEL
    var granTotal=0;
   
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

          if(invitados>=150)
          {
            precioUnitarioPastel=1.45;
          }



           //al final, muestro precio final
           var precioFinal=invitados*precioUnitarioPastel;
            precioFinal=Math.round(precioFinal * 100) / 100;
            granTotal=granTotal+precioFinal;
            $('#granTotal').text('$'+granTotal);
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

          if(invitados>=150)
          {
            precioUnitarioPastel=2.95;
          }

           //al final, muestro precio final
           var precioFinal=invitados*precioUnitarioPastel;
           precioFinal=Math.round(precioFinal * 100) / 100;
           granTotal=granTotal+precioFinal;
            $('#granTotal').text('$'+granTotal);
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

//inicio mesa de postres

$('input[name=postres]').click(function() 
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
      var x = document.getElementById("consoPostres");
      if(document.getElementById("postres").checked == true)
        {
          console.log("apretado");
          
          if (x.style.display === "none") 
          {
          $(x).show('slow');
          }   
          //rango de precios
          if(invitados<=50)
          {
            precioUnitarioPastel=1.2;
          }

          if(invitados>50 && invitados<150)
          {
            precioUnitarioPastel=1.16;
          }

          if(invitados>=150)
          {
            precioUnitarioPastel=1.12;
          }

           //al final, muestro precio final
           var precioFinal=invitados*precioUnitarioPastel;
           precioFinal=Math.round(precioFinal * 100) / 100;
           granTotal=granTotal+precioFinal;
            $('#granTotal').text('$'+granTotal);
           console.log("El precio final es: "+precioFinal);
           $('#preciopostres').text('$'+precioFinal);
        }
        else
        {
            console.log("desapretado");
            $(x).hide('slow');        
        }
   
  } //fin de else si no hayinvitados
  
  
});
//
/////inicio pechuga rellena
$('input[name=rellena]').click(function() 
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
      var x = document.getElementById("consoRellena");
      if(document.getElementById("rellena").checked == true)
        {
          console.log("apretado");
          
          if (x.style.display === "none") 
          {
          $(x).show('slow');
          }   
          //rango de precios
          if(invitados>50 && invitados<99)
          {
            precioUnitarioPastel=8;
          }

          if(invitados>100 && invitados<200)
          {
            precioUnitarioPastel=7.25;
          }

          if(invitados>=200)
          {
            precioUnitarioPastel=6.85;
          }

           //al final, muestro precio final
           var precioFinal=invitados*precioUnitarioPastel;
           precioFinal=Math.round(precioFinal * 100) / 100;
           console.log("El precio final es: "+precioFinal);
           $('#preciorellena').text('$'+precioFinal);
            granTotal=granTotal+precioFinal;
            $('#granTotal').text('$'+granTotal);
        }
        else
        {
            console.log("desapretado");
            $(x).hide('slow');        
        }
   
  } //fin de else si no hayinvitados
  
  
});
//////// inicio pechuga suprema
$('input[name=suprema]').click(function() 
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
      var x = document.getElementById("consoSuprema");
      if(document.getElementById("suprema").checked == true)
        {
          console.log("apretado");
          
          if (x.style.display === "none") 
          {
          $(x).show('slow');
          }   
          //rango de precios
         if(invitados>50 && invitados<99)
          {
            precioUnitarioPastel=7.2;
          }

          if(invitados>100 && invitados<200)
          {
            precioUnitarioPastel=6.5;
          }

          if(invitados>=200)
          {
            precioUnitarioPastel=6.25;
          }

           //al final, muestro precio final
           var precioFinal=invitados*precioUnitarioPastel;
           precioFinal=Math.round(precioFinal * 100) / 100;
           console.log("El precio final es: "+precioFinal);
           $('#preciosuprema').text('$'+precioFinal);
            granTotal=granTotal+precioFinal;
            $('#granTotal').text('$'+granTotal);
        }
        else
        {
            console.log("desapretado");
            $(x).hide('slow');        
        }
   
  } //fin de else si no hayinvitados
  
});
//////// inicio lomito cerdo
$('input[name=cerdo]').click(function() 
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
      var x = document.getElementById("consoCerdo");
      if(document.getElementById("cerdo").checked == true)
        {
          console.log("apretado");
          
          if (x.style.display === "none") 
          {
          $(x).show('slow');
          }   
          //rango de precios
         if(invitados>50 && invitados<99)
          {
            precioUnitarioPastel=7.5;
          }

          if(invitados>100 && invitados<200)
          {
            precioUnitarioPastel=7;
          }

          if(invitados>=200)
          {
            precioUnitarioPastel=6.35;
          }

           //al final, muestro precio final
           var precioFinal=invitados*precioUnitarioPastel;
           precioFinal=Math.round(precioFinal * 100) / 100;
           console.log("El precio final es: "+precioFinal);
           $('#preciocerdo').text('$'+precioFinal);
            granTotal=granTotal+precioFinal;
            $('#granTotal').text('$'+granTotal);
        }
        else
        {
            console.log("desapretado");
            $(x).hide('slow');        
        }
   
  } //fin de else si no hayinvitados
  
});
//////// inicio lomito res
$('input[name=res]').click(function() 
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
      var x = document.getElementById("consoRes");
      if(document.getElementById("res").checked == true)
        {
          console.log("apretado");
          
          if (x.style.display === "none") 
          {
          $(x).show('slow');
          }   
          //rango de precios
         if(invitados>50 && invitados<99)
          {
            precioUnitarioPastel=8;
          }

          if(invitados>100 && invitados<200)
          {
            precioUnitarioPastel=7.5;
          }

          if(invitados>=200)
          {
            precioUnitarioPastel=7;
          }

           //al final, muestro precio final
           var precioFinal=invitados*precioUnitarioPastel;
           precioFinal=Math.round(precioFinal * 100) / 100;
           console.log("El precio final es: "+precioFinal);
           $('#preciores').text('$'+precioFinal);
            granTotal=granTotal+precioFinal;
            $('#granTotal').text('$'+granTotal);
        }
        else
        {
            console.log("desapretado");
            $(x).hide('slow');        
        }
   
  } //fin de else si no hayinvitados
  
});

//////// inicio parrillada
$('input[name=parrillada]').click(function() 
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
      var x = document.getElementById("consoParrillada");
      if(document.getElementById("parrillada").checked == true)
        {
          console.log("apretado");
          
          if (x.style.display === "none") 
          {
          $(x).show('slow');
          }   
          //rango de precios
         if(invitados>50 && invitados<99)
          {
            precioUnitarioPastel=8.5;
          }

          if(invitados>100 && invitados<200)
          {
            precioUnitarioPastel=7.5;
          }

          if(invitados>=200)
          {
            precioUnitarioPastel=7;
          }

           //al final, muestro precio final
           console.log("en parrillada: precioUnitario es "+precioUnitarioPastel+" y invitados son "+invitados);
           var precioFinal=invitados*precioUnitarioPastel;
           precioFinal=Math.round(precioFinal * 100) / 100;
           console.log("El precio final es: "+precioFinal);
           $('#precioparrillada').text('$'+precioFinal);
            granTotal=granTotal+precioFinal;
            $('#granTotal').text('$'+granTotal);
        }
        else
        {
            console.log("desapretado");
            $(x).hide('slow');        
        }
   
  } //fin de else si no hayinvitados
  
});

//////// inicio barra libre
$('input[name=barra]').click(function() 
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
      var x = document.getElementById("consoBarra");
      if(document.getElementById("barra").checked == true)
        {
          console.log("apretado");
          
          if (x.style.display === "none") 
          {
          $(x).show('slow');
          }   
          //rango de precios
         if(invitados>0 && invitados<150)
          {
            precioUnitarioPastel=2.99;
          }

          if(invitados>=150)
          {
            precioUnitarioPastel=2.49;
          }
           //al final, muestro precio final
           //console.log("en parrillada: precioUnitario es "+precioUnitarioPastel+" y invitados son "+invitados);
           var precioFinal=invitados*precioUnitarioPastel;
           precioFinal=Math.round(precioFinal * 100) / 100;
           console.log("El precio final es: "+precioFinal);
           $('#preciobarra').text('$'+precioFinal);
            granTotal=granTotal+precioFinal;
            $('#granTotal').text('$'+granTotal);
        }
        else
        {
            console.log("desapretado");
            $(x).hide('slow');        
        }
   
  } //fin de else si no hayinvitados
  
});
