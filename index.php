<?php

session_start();

if(isset($_SESSION['usuario_id'])){

    if($_SESSION['rol'] == 'admin'){

        header("Location: paginas/dashboardAdmin.php");

    }else{

        header("Location: paginas/dashboard.php");
    }

    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!--logo señal telefonica-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   
     <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>

   <div class="barraNoticias">
    <div class="textoMovimiento">
          <img src="img/aguila.png" class="aguilaTicker" alt="">
          
         ¡Liberación Móvil MX te permite liberar dispositivos móviles en minutos🕒!
         Si eres nuevo crea una cuenta gratis 👤
        ¡Soporte disponible  <i class="fa-brands fa-whatsapp"></i> !
        Compatible con múltiples compañías📱 
         ¡Plataforma segura y confiable🔐!
        <img src="img/aguila.png" class="aguilaTicker" alt="">
    </div>
   </div>
   
  <div class="login">

     <div class="signal-bars">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
     </div>

     <h1 class="titulo" >Liberación Móvil MX</h1>
       <img src="img/aguila.png" class="logoAguila" alt="">
        <form action="" class="contenido" id="formIngresar">

      
           
            <input type="email" name="correo" id="correo" placeholder="Ingresa tu correo electronico">
        
            <div class="input-password">
            <input type="password" name="password" id="verpassw" placeholder="Ingresa tu contraseña">
            <span class="toggle-password" onclick="togglePassword()">👁</span>
         </div>
        

            <div class="botons">
            <button type="submit" id="btnIniciarSesion"  class="btnUno" >Ingresar</button>
            
            <button type="button" id="btnCrearCuenta"  class="btnDos" onclick="window.location.href='paginas/crearCuenta.html'" style="color: wheat;" >👤Crear cuenta</button>
            </div>

            <p class="olvido">
                ¿Olvidaste tu contraseña?
                <a href="paginas/recuperarCuenta.html" class="recupera">click aqui.</a>
            </p>
        </form>
        <div id="notificacionIngresar"></div>
    </div>

      <script src="js/notificaciones.js"></script>
      <script src="js/login/ingresar.js"></script>
   
      
</body>
</html>