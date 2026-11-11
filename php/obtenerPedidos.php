<?php

session_start();
header('Content-Type: application/json; charset=utf-8');

$conexion = new mysqli("localhost", "root", "", "liberaciones");

if($conexion->connect_error){
    echo json_encode([
        "status" => "error",
        "mensaje" => "Error de conexión"
    ]);
    exit();
}

// Verificar sesión de admin
if(!isset($_SESSION['usuario_id'])){
    echo json_encode([
        "status" => "error",
        "mensaje" => "No hay sesión activa"
    ]);
    exit();
}

// 🔥 CONSULTA CON JOIN PARA TRAER NOMBRE Y CORREO DE TODOS LOS USUARIOS
$sql = "SELECT 
            pedidos.id AS id_pedido, 
            usuarios.nombre AS nombre_usuario, 
            usuarios.correo AS correo_usuario,
            pedidos.imei, 
            pedidos.compania, 
            pedidos.costo, 
            pedidos.estado, 
            pedidos.resultado, 
            pedidos.reembolsado, 
            pedidos.fecha_pedido 
        FROM pedidos 
        JOIN usuarios ON pedidos.id_usuario = usuarios.id 
        ORDER BY pedidos.id DESC";

$resultado = $conexion->query($sql);

$pedidos = [];

if ($resultado) {
    while($fila = $resultado->fetch_assoc()){
        $pedidos[] = $fila;
    }
}

echo json_encode($pedidos);

$conexion->close();

?>