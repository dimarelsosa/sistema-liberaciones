
    function ocultarTodo(){
        document.getElementById("formInicio").style.display="none";
        document.getElementById("formTelcel").style.display="none";
        document.getElementById("formAtti").style.display="none";
        document.getElementById("formUnefon").style.display="none";
        document.getElementById("formMovistar").style.display="none";
        document.getElementById("formPedidos").style.display="none";
    }


    function liberacionTelcel(){
        ocultarTodo();
        document.getElementById("formTelcel").style.display="flex";
    }

    function liberacionAtit(){
        ocultarTodo();
        document.getElementById("formAtti").style.display="flex";
    }

    function liberacionUnefon(){
        ocultarTodo();
        document.getElementById("formUnefon").style.display="flex";
    }

    function liberacionMovistar(){
        ocultarTodo();
        document.getElementById("formMovistar").style.display="flex";
    }
    function ventanaInicio(){
        ocultarTodo();
        document.getElementById("formInicio").style.display="flex";
        
    }

    function verPedidos(){
        ocultarTodo();
        document.getElementById("formPedidos").style.display="flex";
    }



  /*scrip activar boton  clickeado y desabilitar cuando se clickea otro boton*/
    const allBotones = document.querySelectorAll(".botones button, .inicio, .btnPedidos");
          allBotones.forEach(presion=>{
          presion.addEventListener("click", ()=>{
          allBotones.forEach(limpiar=>limpiar.classList.remove("activo"));
          presion.classList.add("activo");
          });
          });

   