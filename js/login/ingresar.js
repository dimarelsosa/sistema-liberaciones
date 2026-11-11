function togglePassword() {

  const pass = document.getElementById("verpassw");

  if (!pass) {
    console.log("No encontró el input");
    return;
  }

  pass.type = pass.type === "password" ? "text" : "password";
}

document.addEventListener("DOMContentLoaded", function(){

  document.getElementById("btnIniciarSesion").addEventListener("click", function(e){

    e.preventDefault();

    const correo = document.getElementById("correo").value.trim();
    const password = document.getElementById("verpassw").value.trim();

    if(correo === "" || password === ""){

      mostrarMensaje("Favor de agregar usuario y contraseña", "error", "notificacionIngresar");
      return;

    }

    // Enviar datos al PHP
    const datos = new FormData();

    datos.append("correo", correo);
    datos.append("password", password);

    fetch("php/iniciarSesion.php", {

      method: "POST",
      body: datos

    })
        .then(res => res.json())
           .then(respuesta => {

//aqui quitamos esto ya que tambien existe admin

     /* if(respuesta.status === "ok"){
        mostrarMensaje( "ok", "notificacionIngresar");

        // Redirigir (ejemplo)
        window.location.href = "paginas/dashboard.html";
        
      }else{
        mostrarMensaje(respuesta.mensaje, "error", "notificacionIngresar");
      }
        */

      if(respuesta.status === "ok"){                                                      

        mostrarMensaje("Inicio de sesión correcto", "ok", "notificacionIngresar");

        if(respuesta.rol === "admin"){

          window.location.href = "paginas/dashboardAdmin.php";

        }else{

          window.location.href = "paginas/dashboard.php";

        }

      }else{

        mostrarMensaje(respuesta.mensaje, "error", "notificacionIngresar");

      }

    })

    .catch(error => {

      console.log(error);

      mostrarMensaje("Error en el servidor", "error", "notificacionIngresar");

    });

  });

});