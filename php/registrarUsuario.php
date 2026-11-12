<?php

session_start();
$conexion = new mysqli("localhost", "root", "", "liberaciones");

if ($conexion->connect_error) {
    die("Error con el servidor: " . $conexion->connect_error);
}

$nombre    = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$telefono  = $_POST['numero'];
$correo    = $_POST['correo'];
$password  = $_POST['password'];

// Encriptar contraseña
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Verificar si el correo ya existe
$stmt = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    echo "El correo ya está registrado";
    exit();
}

// Insertar usuario
$stmt = $conexion->prepare("INSERT INTO usuarios (nombre, apellidos, telefono, correo, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nombre, $apellidos, $telefono, $correo, $passwordHash);

if ($stmt->execute()) {
    echo "ok";
} else {
    echo "error";
}
?>