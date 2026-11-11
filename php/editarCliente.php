<?php

$conn = new mysqli("localhost", "root", "", "liberaciones");

if($conn->connect_error){
    die("error");
}

// RECIBIR DATOS
$id = $_POST["id"];
$nombre = $_POST["nombre"];
$correo = $_POST["correo"];
$telefono = $_POST["telefono"];
$saldo = $_POST["saldo"];

// ACTUALIZAR
$sql = "UPDATE usuarios 
SET 
nombre='$nombre',
correo='$correo',
telefono='$telefono',
saldo='$saldo'
WHERE id='$id'";

if($conn->query($sql)){
    echo "ok";
}else{
    echo "error";
}