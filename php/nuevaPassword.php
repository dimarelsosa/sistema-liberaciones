<?php

$conexion = new mysqli(
    "localhost",
    "root",
    "",
    "liberaciones"
);

// OBTENER TOKEN
$token = $_GET["token"];

// VALIDAR TOKEN
$sql = "
SELECT *
FROM usuarios
WHERE token_recuperacion='$token'
AND expira_token > NOW()
";

$resultado = $conexion->query($sql);

// SI TOKEN INVALIDO
if($resultado->num_rows <= 0){

    die("Token inválido o expirado");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Nueva contraseña</title>

<style>

body{

    background:#111;

    display:flex;

    justify-content:center;

    align-items:center;

    height:100vh;

    font-family:Arial;
}

.contenedor{

    background:white;

    padding:40px;

    border-radius:15px;

    width:350px;

    text-align:center;
}

input{

    width:100%;

    padding:12px;

    margin-top:15px;

    border-radius:10px;

    border:1px solid gray;

    box-sizing:border-box;
}

button{

    width:100%;

    padding:12px;

    margin-top:20px;

    border:none;

    border-radius:10px;

    background:green;

    color:white;

    font-size:16px;

    cursor:pointer;
}

#mensaje{

    margin-top:15px;

    color:white;

    padding:12px;

    border-radius:10px;

    display:none;
}

</style>

</head>

<body>

<div class="contenedor">

    <h2>Nueva contraseña</h2>

    <p>
        Ingresa una nueva contraseña segura
    </p>

    <input type="password" id="nuevaPassword" placeholder="Nueva contraseña">
     <br> 
    <input type="password" id="confirmarPassword"  placeholder="Confirmar contraseña">

    <button onclick="guardarPassword()">
        Guardar contraseña
    </button>

    <div id="mensaje"></div>

</div>

<script>

function mostrarMensaje(texto, tipo){

    const mensaje =
    document.getElementById("mensaje");

    mensaje.style.display = "block";

    mensaje.innerText = texto;

    if(tipo == "ok"){

        mensaje.style.background = "green";

    }else{

        mensaje.style.background = "red";
    }
}

async function guardarPassword(){

    const nuevaPassword =
    document.getElementById("nuevaPassword")
    .value.trim();

    const confirmarPassword=document.getElementById("confirmarPassword").value.trim();

   // VALIDAR 8 CARACTERES
if(nuevaPassword.length < 8){

    mostrarMensaje(
        "La contraseña debe tener mínimo 8 caracteres",
        "error"
    );

    return;
}

// VALIDAR COINCIDENCIA
if(nuevaPassword != confirmarPassword){

    mostrarMensaje(
        "Las contraseñas no coinciden",
        "error"
    );

    return;
}

    // ENVIAR
    const respuestaServidor =
  await fetch("../php/guardarNuevaPassword.php",{

        method:"POST",

        headers:{
            "Content-Type":
            "application/x-www-form-urlencoded"
        },

        body:
        `token=<?php echo $token; ?>
        &password=${nuevaPassword}`
    });

    const resultado =
    await respuestaServidor.text();

    console.log(resultado);

    // EXITO
    if(resultado == "ok"){

        mostrarMensaje(
            "Contraseña actualizada",
            "ok"
        );

        // REDIRECCION LOGIN
        setTimeout(() => {

            window.location.href =
            "../index.php";

        }, 2000);

    }else{

        mostrarMensaje(
            "Error al actualizar contraseña",
            "error"
        );
    }
}

</script>

</body>
</html>