<?php

$conexion = new mysqli(
    "localhost",
    "root",
    "",
    "liberaciones"
);

// RECIBIR DATOS
$token = trim($_POST["token"]);

$passwordNueva = trim($_POST["password"]);

// VALIDAR PASSWORD
if(strlen($passwordNueva) < 8){

    echo "error";

    exit();
}

// ENCRIPTAR PASSWORD
$passwordHash = password_hash(
    $passwordNueva,
    PASSWORD_DEFAULT
);

// ACTUALIZAR PASSWORD
$sql = "
UPDATE usuarios
SET
password='$passwordHash',
token_recuperacion=NULL,
expira_token=NULL
WHERE token_recuperacion='$token'
";

$resultado = $conexion->query($sql);

// RESPUESTA
if($resultado && $conexion->affected_rows > 0){

    echo "ok";

}else{

    echo "error";
}

?>