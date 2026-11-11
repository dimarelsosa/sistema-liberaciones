<?php

session_start();
$conn = new mysqli("localhost", "root", "", "liberaciones");

if($conn->connect_error){
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT 
    usuarios.id,
    usuarios.nombre,
    usuarios.apellidos,
    usuarios.telefono,
    usuarios.correo,
    usuarios.saldo,
    usuarios.fecha_registro,
    usuarios.rol,

    (
        SELECT COUNT(*) 
        FROM pedidos 
        WHERE pedidos.id_usuario = usuarios.id
    ) AS total_pedidos

FROM usuarios

ORDER BY usuarios.id ASC";

$resultado = $conn->query($sql);

$clientes = [];

while($fila = $resultado->fetch_assoc()){

    $clientes[] = $fila;
}

header('Content-Type: application/json');

echo json_encode($clientes);

$conn->close();

?>