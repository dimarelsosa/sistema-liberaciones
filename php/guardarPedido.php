<?php

session_start();

$conexion = new mysqli("localhost", "root", "", "liberaciones");

if($conexion->connect_error){
    die("Error de conexion");
}

// VALIDAR SESIÓN
if(!isset($_SESSION['usuario_id'])){

    echo "sesion_expirada";
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

$imei     = $_POST["imei"];
$compania = $_POST["compania"];
$costo    = $_POST["costo"];


// 🔥 CONSULTAR SALDO ACTUAL
$sqlSaldo = "SELECT saldo FROM usuarios WHERE id = '$id_usuario'";
$resultadoSaldo = $conexion->query($sqlSaldo);

$usuario = $resultadoSaldo->fetch_assoc();

$saldoActual = $usuario["saldo"];


// 🔥 VALIDAR SI TIENE SALDO SUFICIENTE
if($saldoActual < $costo){

    echo "saldo_insuficiente";
    exit();
}


// 🔥 DESCONTAR SALDO
$nuevoSaldo = $saldoActual - $costo;

$sqlDescontar = "UPDATE usuarios 
SET saldo = '$nuevoSaldo' 
WHERE id = '$id_usuario'";

$conexion->query($sqlDescontar);


$sql = "INSERT INTO pedidos 
(id_usuario, imei, compania, estado, resultado, costo, reembolsado)

VALUES 
('$id_usuario', '$imei', '$compania', 'pendiente', 'Procesando', '$costo', 'No')";

if($conexion->query($sql) === TRUE){

    echo "ok";

}else{

    echo "error";
}

?>
