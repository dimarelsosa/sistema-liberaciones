
//recuperar contraseña olvidada
async function recuperarCuenta(){

    const boton =
    document.querySelector(".btnContinuar");

    boton.disabled = true;
    boton.innerText = "Enviando...";

    const correo =
    document.getElementById("correoRecuperar").value;

    const respuestaServidor = await fetch(
        "../php/recuperarCuenta.php",
        {
            method:"POST",

            headers:{
                "Content-Type":
                "application/x-www-form-urlencoded"
            },

            body:`correo=${correo}`
        }
    );

    const resultado =
    await respuestaServidor.text();

    // VOLVER A ACTIVAR BOTON
    boton.disabled = false;
    boton.innerText = "Continuar";

    if(resultado.trim() == "ok"){

        mostrarMensaje(
            "Revisa tu correo electrónico",
            "ok",
            "notificacionRecuperar"
        );

    }else if(resultado.trim() == "correo_no_existe"){

        mostrarMensaje(
            "Correo no encontrado",
            "error",
            "notificacionRecuperar"
        );

    }else{

        mostrarMensaje(
            "Error al enviar correo",
            "error",
            "notificacionRecuperar"
        );
    }
}