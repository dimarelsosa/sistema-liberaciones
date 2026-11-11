<?php
header('Content-Type: application/json');



error_reporting(0);

$conn = new mysqli("localhost", "root", "", "liberaciones");

if ($conn->connect_error) {
    echo json_encode(["success" => false]);
    exit;
}

$id = $_POST['id'] ?? 0;
$monto = $_POST['monto'] ?? 0;

$stmt = $conn->prepare("UPDATE usuarios SET saldo = saldo + ? WHERE id = ?");
$stmt->bind_param("di", $monto, $id);

$ok = $stmt->execute();

echo json_encode(["success" => $ok]);

$stmt->close();
$conn->close();
?>