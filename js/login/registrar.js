//Mostrar y ocultar contraseña
function togglePassword() {
  const pass = document.getElementById("verpassw");

  if (!pass) {
    console.log("No encontró el input");
    return;
  }

  pass.type = pass.type === "password" ? "text" : "password";
}

document.addEventListener("DOMContentLoaded", function(){
document.getElementById("btnRegistrarme").addEventListener("click", function(e){
  e.preventDefault();

  const Nombre     = document.getElementById("nombre").value.trim();
  const Apellidos  = document.getElementById("apellidos").value.trim();
  const Numero     = document.getElementById("numero").value.trim();
  const Correo     = document.getElementById("correo").value.trim();
  const Password   =document.getElementById("verpassw").value.trim();
  if(Nombre===""|| Apellidos===""|| Numero===""|| Correo===""|| Password===""){
     mostrarMensaje("❌ Por Favor llena todos los campos.", "error", "notificacionRegistro" );
     return;
  }

   const formRegistrarUsuario= new FormData();
         formRegistrarUsuario.append("nombre", Nombre);
         formRegistrarUsuario.append("apellidos",Apellidos);
         formRegistrarUsuario.append("numero", Numero);
         formRegistrarUsuario.append("correo", Correo);
         formRegistrarUsuario.append("password", Password);

         fetch("../php/registrarUsuario.php",{
          method: "POST",
          body: formRegistrarUsuario
         })

         .then(registrar=>registrar.text())
         .then(respuesta=>{
          if(respuesta.trim()=="ok"){
            mostrarMensaje("✔ Registro exitoso.", "ok", "notificacionRegistro");
            document.getElementById("formRegistrar").reset();
          }else{
            mostrarMensaje("❌ Ocurrio un error, intentelo de nuevo", "error", "notificacionRegistro");
          }
         }).catch(()=>{
          mostrarMensaje("❌ error con el servidor", "error", "notificacionRegistro");
         });
         });
});
