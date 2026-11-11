<?php

session_start();
header('Content-Type: application/json');

$conexion = new mysqli("localhost", "root", "", "liberaciones");

if($conexion->connect_error){
    die(json_encode([
        "status" => "error",
        "mensaje" => "Error con el servidor"
    ]));
}

if(empty($_POST['correo']) || empty($_POST['password'])){
    echo json_encode([
        "status" => "error",
        "mensaje" => "Datos incompletos"
    ]);
    exit();
}

$correo   = $_POST['correo'];
$password = $_POST['password'];

$stmt = $conexion->prepare("SELECT id, nombre, correo, password, rol FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if($resultado->num_rows > 0){

    $usuario = $resultado->fetch_assoc();

    if(password_verify($password, $usuario['password'])){

$_SESSION['usuario_id'] = $usuario['id'];
$_SESSION['nombre'] = $usuario['nombre'];
$_SESSION['correo'] = $usuario['correo'];
$_SESSION['rol'] = $usuario['rol'];

echo json_encode([
    "status" => "ok",
    "rol" => $usuario['rol']
]);
    }else{
        echo json_encode([
            "status" => "error",
            "mensaje" => "Contraseña incorrecta"
        ]);
    }

}else{
    echo json_encode([
        "status" => "error",
        "mensaje" => "El correo no existe"
    ]);
}

$stmt->close();
$conexion->close();
?>