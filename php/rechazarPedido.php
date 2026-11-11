<?php

$conn = new mysqli("localhost","root","","liberaciones");

if($conn->connect_error){
    die("error");
}

$id_pedido = $_POST["id_pedido"];
$id_usuario = $_POST["id_usuario"];
$costo = $_POST["costo"];


// VERIFICAR SI YA FUE REEMBOLSADO (Corregido 'id' en lugar de 'id_pedido')
$sqlVerificar = "SELECT reembolsado FROM pedidos WHERE id = '$id_pedido'";

$resultadoVerificar = $conn->query($sqlVerificar);

$pedido = $resultadoVerificar->fetch_assoc();

if(trim(strtolower($pedido["reembolsado"])) == "si"){
    echo "ya_reembolsado";
    exit;
}


// REEMBOLSAR SALDO AL USUARIO
$sqlSaldo = "
UPDATE usuarios 
SET saldo = saldo + '$costo'
WHERE id = '$id_usuario'
";

$conn->query($sqlSaldo);


// ACTUALIZAR PEDIDO (Corregido estado='cancelado' y WHERE id='$id_pedido')
$sqlPedido = "
UPDATE pedidos 
SET 
estado = 'rechazado',
resultado = 'No compatible',
reembolsado = 'Si'
WHERE id = '$id_pedido'
";

if($conn->query($sqlPedido)){
    echo "ok";
}else{
    echo "error";
}

$conn->close();

?>