<?php

$conn = new mysqli("localhost", "root", "", "liberaciones");

if($conn->connect_error){
    die("error");
}

// RECIBIR ID
$idCliente = $_POST["id"];

// ELIMINAR
$sql = "DELETE FROM usuarios WHERE id='$idCliente'";

if($conn->query($sql)){
    echo "ok";
}else{
    echo "error";
}