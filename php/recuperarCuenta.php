<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

$conexion = new mysqli(
    "localhost",
    "root",
    "",
    "liberaciones"
);

$correo = $_POST["correo"];

// BUSCAR USUARIO
$sql = "SELECT * FROM usuarios
WHERE correo='$correo'";

$resultado = $conexion->query($sql);

// SI EXISTE
if($resultado->num_rows > 0){

    // GENERAR TOKEN
    $token = bin2hex(random_bytes(32));

    // EXPIRACION 1 HORA
    $expira = date(
        "Y-m-d H:i:s",
        strtotime("+1 hour")
    );

    // GUARDAR TOKEN
    $sqlActualizar = "
    UPDATE usuarios
    SET
    token_recuperacion='$token',
    expira_token='$expira'
    WHERE correo='$correo'
    ";

    $conexion->query($sqlActualizar);

    // LINK RECUPERACION
$link =
"http://localhost/liberaciones/php/nuevaPassword.php?token=$token";

   


    $mail = new PHPMailer(true);

try{

    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';

    $mail->SMTPAuth = true;

    $mail->Username =
    'brandonmartinezherrera91@gmail.com';

    $mail->Password =
    'cbshlqaetegwqtkn';

    $mail->SMTPSecure =
    PHPMailer::ENCRYPTION_STARTTLS;

    $mail->Port = 587;

    $mail->setFrom(
        'brandonmartinezherrera91@gmail.com',
        'Liberacion Movil MX'
    );

    $mail->addAddress($correo);

    $mail->isHTML(true);

    $mail->Subject =
    'Recuperacion de contraseña';

    $mail->Body = "
    <h2>Recuperar contraseña</h2>

    <p>Haz clic en el siguiente enlace:</p>

    <a href='$link'>
    Cambiar contraseña
    </a>
    ";

    $mail->send();

    echo 'ok';

}catch(Exception $e){

    echo 'error_correo';
}

}else{

    echo "correo_no_existe";
}