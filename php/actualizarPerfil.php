<?php

session_start();

if(!isset($_SESSION['usuario_id'])){
    exit("No autorizado");
}

$conexion = new mysqli("localhost","root","","liberaciones");

if($conexion->connect_error){
    exit("Error de conexión");
}

$idUsuario = $_SESSION['usuario_id'];

$apellidos = trim($_POST['apellidos']);
$telefono = trim($_POST['telefono']);

$stmt = $conexion->prepare("
UPDATE usuarios
SET apellidos = ?, telefono = ?
WHERE id = ?
");

$stmt->bind_param("ssi", $apellidos, $telefono, $idUsuario);

if($stmt->execute()){
    echo "ok";
}else{
    echo "error";
}

$stmt->close();
$conexion->close();