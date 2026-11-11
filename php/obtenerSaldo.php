<?php

session_start();

$conn = new mysqli("localhost", "root", "", "liberaciones");

if($conn->connect_error){
    die("Error de conexión");
}

if(!isset($_SESSION['usuario_id'])){

    echo json_encode([
        "success" => false
    ]);

    exit();
}

$id = $_SESSION['usuario_id'];

$sql = "SELECT saldo FROM usuarios WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

$usuario = $resultado->fetch_assoc();

echo json_encode([
    "success" => true,
    "saldo" => $usuario["saldo"]
]);

$stmt->close();
$conn->close();

?>