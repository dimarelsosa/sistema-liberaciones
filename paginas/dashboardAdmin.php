<?php

session_start();

if(!isset($_SESSION['usuario_id'])){

    header("Location: ../index.php");
    exit();
    
}
// Conexión rápida para obtener el nombre del admin actual
$conexion = new mysqli("localhost", "root", "", "liberaciones");
$id_admin = $_SESSION['usuario_id'];
$sql_admin = "SELECT nombre FROM usuarios WHERE id = $id_admin";
$res_admin = $conexion->query($sql_admin);
$nombre_admin = "Administrador";

if($res_admin && $fila_admin = $res_admin->fetch_assoc()){
    $nombre_admin = $fila_admin['nombre'];
}
$conexion->close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/menuAdmin.css">
<title>Panel de Administración</title>
</head>
<body>
    <div class="rectangulo">
      <div style="text-align: center; padding: 15px 10px; border-bottom: 1px solid rgba(255,255,255,0.15); margin-bottom: 15px;">
            <span style="font-size: 11px; display: block; color: #aaa; text-transform: uppercase; letter-spacing: 1px;">⚙️ Administrador</span>
            <span style="font-size: 15px; font-weight: bold; color: #D4AF37;"><?php echo htmlspecialchars($nombre_admin); ?></span>
        </div>
      
        <button class="btnSaldo" onclick="saldo()">Saldo:</button>
        <div class="botones">
            
            <button onclick="pedidosClientes()"> 🔓 Pedidos</button>
            <button onclick="modificarClientes()">✏️ Editar clientes</button>
            <button onclick="totalClientes()">📋Total clientes</button> 
        </div>
      <button class="btnSalir" onclick="window.location.href='../php/logout.php'"> ⏻ Cerrar Sesión </button>
     
    </div>

    <div class="welcomeAguila" id="welcomeAguila">
       <img src="../img/aguila.png" class="aguilaHome" id="aguilaHome" style="display:block; margin:auto;  width:100%; max-width: 700px;" >
      <h1 style="text-align: center; color: #D4AF37;">Liberacion Movil MX</h1>
    
    </div>
    
    

    <!--Formulario pedidos-->
     <div class="formPedidos" id="formPedidos" style="display: none;">
       <table class="tablaPedidos">
        <thead>
            <tr>
                <th>ID PEDIDO</th>
                <th>CLIENTE</th>
                <th>CORREO</th>
                <th>IMEI</th>
                <th>COMPAÑIA</th>
                <th>ESTADO</th>
                <th>RESULTADO</th>
                <th>COSTO</th>
                <th>REEMBOLSO</th>
                <th>FECHA DE PEDIDO</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody id="tbodyPedidos"></tbody>
       </table>
     </div> 

     <!-- MODAL CODIGO -->
<div id="modalCodigo" class="modalSaldo" style="display:none;">

  <div class="modalContenido">

    <h2>Ingresar código</h2>

    <input type="text" id="inputCodigo" placeholder="Código de liberación">

    <div class="botonesModal">
      <button onclick="cerrarModalCodigo()">Cancelar</button>
      <button onclick="confirmarCodigo()">Guardar</button>
    </div>

  </div>

</div>




<div class="formEditar" id="formEditar" style="display: none;">

 
    <!-- Buscador -->
     <input type="text"  id="buscadorEditar" class="buscar" placeholder="Buscar Cliente...">

    <table class="tablaEditar">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>CORREO</th>
                <th>TELEFONO</th>
                <th>SALDO</th>
                <th>FECHA REGISTRO</th>
                <th>ACCIONES</th>
            </tr>
        </thead>

        <tbody id="tbodyEditar">
            
        </tbody>
    </table>

   <!-- Notificaciones -->
    <div id="notificacionEditarCliente"></div>
</div>





     <div class="formClientes" id="formClientes" style="display: none;">
      <table class="tablaClientes">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>CORREO</th>
                <th>ROL</th>
                <th>TELEFONO</th>
                <th>SALDO</th>
                <th>FECHA REGISTRO</th>
                <th>TOTAL PEDIDOS</th>
                <th>OPCIONES</th>
            </tr>
        </thead>
        <tbody id="tbodyClientes">

        </tbody>
      </table>
      <!-- BOTÓN EN TU TABLA (OPCIONES) -->


<!-- MODAL -->
<div id="modalSaldo" class="modalSaldo">
  <div class="modalContenido">

    <h2>Agregar saldo</h2>

    <p id="infoCliente"></p>

    <input type="number" id="inputSaldo" placeholder="Monto a agregar">

    <div class="botonesModal">
      <button onclick="cerrarModal()">Cancelar</button>
      
      <button onclick="confirmarSaldo()">Agregar</button>
    </div>
    <div id="notificacionAgregarSaldo"></div>
  </div>
</div>
</div>


   <div id="modalConfirm" class="modalSaldo" style="display:none;">
  <div class="modalContenido">
    <h3 id="textoConfirm"></h3>

    <div class="botonesModal">
      <button onclick="cancelarConfirm()">Cancelar</button>
      <button onclick="aceptarConfirm()">Aceptar</button>
    </div>
  </div>
</div>

<!--notificacion de que -->
<div id="notificacionYaFueReembolsado"></div>
     
     <script src="../js/notificaciones.js"></script>
    <script src="../js/Administrador/admin.js"></script>
  
</body>
</html>