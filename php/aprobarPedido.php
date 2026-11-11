<?php
$conn = new mysqli("localhost", "root", "", "liberaciones");

if($conn->connect_error){
    die("Error de conexión");
}

$idPedido = $_POST["id_pedido"];
$codigo = $_POST["codigo"];

// 1. Obtener los datos del pedido antes de modificarlo (necesitamos el costo, el usuario y su estado de reembolso actual)
$sqlInfo = "SELECT id_usuario, costo, reembolsado FROM pedidos WHERE id = '$idPedido'";
$resultadoInfo = $conn->query($sqlInfo);

if($resultadoInfo && $fila = $resultadoInfo->fetch_assoc()){
    $id_usuario = $fila['id_usuario'];
    $costo = $fila['costo'];
    $reembolsado_actual = trim(strtolower($fila['reembolsado']));

    // 2. CONTABILIDAD: Si el pedido estaba como reembolsado ("si") y ahora lo pasamos a éxito, 
    // se le debe volver a descontar el costo al usuario porque el servicio ya fue entregado.
    if($reembolsado_actual === "si" || $reembolsado_actual === "sí"){
        $sqlDescontar = "UPDATE usuarios SET saldo = saldo - '$costo' WHERE id = '$id_usuario'";
        $conn->query($sqlDescontar);
    }
}

// 3. ACTUALIZAR PEDIDO: Marcamos como completado, guardamos el código y REESTABLECEMOS el reembolso a 'No'
$sql = "UPDATE pedidos 
SET estado = 'completado',
    resultado = 'Codigo: $codigo',
    reembolsado = 'No'
WHERE id = '$idPedido'";

if($conn->query($sql)){
    echo "ok";
} else {
    echo "error";
}

$conn->close();
?>