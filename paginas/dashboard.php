<?php

session_start();

if(!isset($_SESSION['usuario_id'])){

    header("Location: ../index.php");
    exit();
}

$nombre = $_SESSION['nombre'];
$correo = $_SESSION['correo'];

$idUsuario = $_SESSION['usuario_id'];

$conexion = new mysqli("localhost", "root", "", "liberaciones");

$stmt = $conexion->prepare("
SELECT apellidos, telefono
FROM usuarios
WHERE id = ?
");

$stmt->bind_param("i", $idUsuario);
$stmt->execute();

$resultado = $stmt->get_result();
$datos = $resultado->fetch_assoc();

$apellidos = $datos['apellidos'];
$telefono = $datos['telefono'];

$stmt->close();
$conexion->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css">

    <title>Document</title>
</head>
<body>

<div class="contenedor">
<div class="barra">

  <div class="lado-izquierdo">
    <button class="inicio"   id="btnInicio" onclick="ventanaInicio()"> <i class="fa-solid fa-house" style="color: #eeeff3;"></i></button>
  <button class="verSaldo" id="verSaldo">
   Cargando saldo...
</button>
    <button class="btnComprarSaldo" id="btnComprarSaldo" onclick="comprarSaldo()">➕ Comprar</button>
  </div>


  <div class="botones">
    <button class="btnTelcel" title="Selecciona tu compañia actual"   onclick="liberacionTelcel()"  >
        <img src="../img/Telce.png" alt="">
    </button>

    <button class="btnAtit" title="Selecciona tu compañia actual"     onclick="liberacionAtit()"   >
        <img src="../img/At&t.png" alt="">
    </button>
    
    <button class="btnUnefon" title="Selecciona tu compañia actual"   onclick="liberacionUnefon()">
        <img src="../img/Unefon.png" alt="">
    </button>

    <button class="btnMovistar" title="Selecciona tu compañia actual" onclick="liberacionMovistar()"> 
        <img src="../img/Movistar.png" alt="">
    </button>
       </div>

  <div class="lado-derecho">
    <button class="btnPedidos" onclick="verPedidos()">MIS PEDIDOS✅</button>
    <button class="btnConfiguracion" onclick="verAjustes()">⚙️Mi perfil</button>
    <button class="btnSalir" onclick="window.location.href='../php/logout.php'"> ⏻ Cerrar Sesión </button>
  </div>
    </div> 

    
  
                            <!--VENTANA BIENVENIDO-->
<div id="formInicio" style="display: flex;  flex-direction: column; align-items:center;">
    <h1 style="color: rgb(220, 93, 13);" >Liberación Móvil MX.</h1>
    
    <p class="mensaje">Desbloquea tu equipo nacional de manera rápida, segura y 100% confiable. </p>
    <p class="mensaje">Solo seleccionas tu compañía actual e ingresas el <strong>IMEI</strong> del equipo a liberar.</p>
    <p class="mensaje">En caso de que no quede el proceso se te reintegra el saldo en el momento.</p>
    <p style="font-size: 25px;"><strong>"Sin bloqueos, sin complicaciones".</strong></p>
    <br>
    <br>
    <br>
    <p class="nota"><strong>Nota:</strong> Es importante verificar que el equipo no tenga reporte de imei.</p>
   <p class="nota">
  Verificar status del equipo 
  <a href="https://www.ift.org.mx/usuarios-y-audiencias/consulta-de-imei" target="_blank">
    aquí
  </a>
</p>
    <p class="nota">Contáctanos por WhatsApp y recibe atención inmediata.</p>
    
</div>

<!-- BOTÓN WHATSAPP -->
<a href="https://wa.me/529535404889" target="_blank" class="btn-whatsapp">
    <i class="fa-brands fa-whatsapp"></i>
    <span> Soporte por WhatsApp</span>
</a>
                           <!--VENTANA TELCEL-->
<div class="telcel" id="formTelcel" style="display: none; flex-direction: column; align-items: center;" >
    <h1 class="tituloTelcel">Servicio de liberacion movil, compañia actual: <strong style="color: rgb(26, 3, 102);">TELCEL</strong></h1>
    <p class="avisoTelcel">Antes de continuar con el proceso, por favor verifica que el  </p>
    <p class="avisoeTelcel">equipo pida codigo de liberacion y no tenga reporte de <strong>IMEI</strong></p>
    <p class="avisoeTelcel"> "Marca <strong> *#06# </strong> en tu telefono para obtener el IMEI"</p>
   
    <!--Input escribir imei-->
    <div class="contenedorOpciones">

      <!--liberacion de 50 opcion 1-->
      <div class="card">
        <h3>Código telcel México[Económico]<i class="fi fi-mx bandera"></i></h3>
        <p>Probabilidad de éxito 70%.</p>
        <h4>$50.00 MXN</h4>
        <p class="time">Tiempo:⏱️Minutos</p>
        <button  onclick="comprar('telcel',50)">Realizar pedido</button>
      </div>

      <div class="card">
        <h3>Código telcel México[Intermedio]<i class="fi fi-mx bandera"></i></h3>
        <p>Probabilidad de éxito 85%.</p>
        <h4>$70.00 MXN</h4>
        <p class="time">Tiempo:⏱️Minutos</p>
        <button  onclick="comprar('telcel',70)">Realizar pedido</button>
      </div>

      <div class="card">
        <h3>Código telcel México[Premium]<i class="fi fi-mx bandera"></i></h3>
        <p>Probabilidad de éxito 95%.</p>
        <h4>$150.00 MXN</h4>
        <p class="time">Tiempo:⏱️Minutos</p>
        <button onclick="comprar('telcel',150)">Realizar pedido</button>
      </div>

    </div>
    

</div>
                           <!--VENTANA ATTI-->
<div class="atti"   id="formAtti" style="display: none; flex-direction: column; align-items: center;">
    <h1 class="tituloTelcel">Servicio de liberacion movil, compañia actual: <strong style="color: rgb(26, 3, 102); color: #00A8E0;;">AT&T.</strong></h1>
    <p class="avisoTelcel">Antes de continuar con el proceso, por favor verifica que el  </p>
    <p class="avisoeTelcel">equipo pida codigo de liberacion y no tenga reporte de <strong>IMEI</strong></p>
    <p class="avisoeTelcel"> "Marca <strong> *#06# </strong> en tu telefono para obtener el IMEI"</p>
     <div class="contenedorOpciones">

      <!--liberacion de 50 opcion 1-->
      <div class="card">
        <h3 style="color: #00A8E0;;">Código AT&T México[Económico]<i class="fi fi-mx bandera"></i></h3>
        <p>Probabilidad de éxito 70%.</p>
        <h4>$50.00 MXN</h4>
        <p class="time">Tiempo:⏱️Minutos</p>
        <button  onclick="comprar('atti',50)">Realizar pedido</button>
      </div>

      <div class="card">
        <h3 style="color: #00A8E0;;">Código AT&T México[Intermedio]<i class="fi fi-mx bandera"></i></h3>
        <p>Probabilidad de éxito 85%.</p>
        <h4>$70.00 MXN</h4>
        <p class="time">Tiempo:⏱️Minutos</p>
        <button  onclick="comprar('atti',70)">Realizar pedido</button>
      </div>

      <div class="card">
        <h3 style="color: #00A8E0;;">Código AT&T México[Premium]<i class="fi fi-mx bandera"></i></h3>
        <p>Probabilidad de éxito 95%.</p>
        <h4>$150.00 MXN</h4>
        <p class="time">Tiempo:⏱️Minutos</p>
        <button onclick="comprar('atti',150)">Realizar pedido</button>
      </div>

    </div>
    
</div>

                           <!--VENTANA UNEFON-->
<div class="unefon" id="formUnefon" style="display: none; flex-direction: column; align-items: center;">
    <h1 class="tituloTelcel">Servicio de liberacion movil, compañia actual: <strong style="color: #FFD100;">UNEFON</strong></h1>
    <p class="avisoTelcel">Antes de continuar con el proceso, por favor verifica que el  </p>
    <p class="avisoeTelcel">equipo pida codigo de liberacion y no tenga reporte de <strong>IMEI</strong></p>
    <p class="avisoeTelcel"> "Marca <strong> *#06# </strong> en tu telefono para obtener el IMEI"</p>
     <div class="contenedorOpciones">

      <!--liberacion de 50 opcion 1-->
      <div class="card">
        <h3 style="color: #FFD100;">Código Unefon México[Económico]<i class="fi fi-mx bandera"></i></h3>
        <p>Probabilidad de éxito 70%.</p>
        <h4>$50.00 MXN</h4>
        <p class="time">Tiempo:⏱️Minutos</p>
        <button  onclick="comprar('unefon',50)">Realizar pedido</button>
      </div>

      <div class="card">
        <h3 style="color: #FFD100;">Código Unefon México[Intermedio]<i class="fi fi-mx bandera"></i></h3>
        <p>Probabilidad de éxito 85%.</p>
        <h4>$70.00 MXN</h4>
        <p class="time">Tiempo:⏱️Minutos</p>
        <button  onclick="comprar('unefon',70)">Realizar pedido</button>
      </div>

      <div class="card">
        <h3 style="color: #FFD100;">Código Unefon México[Premium]<i class="fi fi-mx bandera"></i></h3>
        <p>Probabilidad de éxito 95%.</p>
        <h4>$150.00 MXN</h4>
        <p class="time">Tiempo:⏱️Minutos</p>
        <button onclick="comprar('unefon',150)">Realizar pedido</button>
      </div>

    </div>
</div>

                           <!--VENTANA MOVISTAR-->
<div class="Movistar" id="formMovistar" style="display: none; flex-direction: column; align-items: center;">
      <h1 class="tituloTelcel">Servicio de liberacion movil, compañia actual: <strong style="color: rgb(26, 3, 102); color: green;">MOVISTAR</strong></h1>
    <p class="avisoTelcel">Antes de continuar con el proceso, por favor verifica que el  </p>
    <p class="avisoeTelcel">equipo pida codigo de liberacion y no tenga reporte de <strong>IMEI</strong></p>
    <p class="avisoeTelcel"> "Marca <strong> *#06# </strong> en tu telefono para obtener el IMEI"</p>
     <div class="contenedorOpciones">

      <!--liberacion de 50 opcion 1-->
      <div class="card">
        <h3 style="color: green;">Código Movistar México[Económico]<i class="fi fi-mx bandera"></i></h3>
        <p>Probabilidad de éxito 70%.</p>
        <h4>$50.00 MXN</h4>
        <p class="time">Tiempo:⏱️Minutos</p>
        <button  onclick="comprar('movistar',50)">Realizar pedido</button>
      </div>

      <div class="card">
        <h3 style="color: green;">Código Movistar México[Intermedio]<i class="fi fi-mx bandera"></i></h3>
        <p>Probabilidad de éxito 85%.</p>
        <h4>$70.00 MXN</h4>
        <p class="time">Tiempo:⏱️Minutos</p>
        <button  onclick="comprar('movistar',70)">Realizar pedido</button>
      </div>

      <div class="card">
        <h3 style="color: green;">Código Movistar México[Premium]<i class="fi fi-mx bandera"></i></h3>
        <p>Probabilidad de éxito 95%.</p>
        <h4>$150.00 MXN</h4>
        <p class="time">Tiempo:⏱️Minutos</p>
        <button onclick="comprar('movistar',150)">Realizar pedido</button>
      </div>

    </div>
</div>


<!--Ventanita de compraRr codigo de liberacion-->
<div id="formVentana" class="formVentana">
  <div class="contenidoVentana">
    <button class="cerrarVentana" onclick="cerrarVentanita()">X</button>
    <h2 id="tituloLiberacion"></h2>
    <h3 id="costoLiberacion"></h3>
    <label for="imeiLiberacion">IMEI</label>
   <input 
  type="text" id="imeiLiberacion" name="imeiLiberacion" maxlength="15" inputmode="numeric" pattern="\d{15}"
  required placeholder="Ingresa el IMEI (15 dígitos)" oninput="this.value = this.value.replace(/\D/g,'')"
>
    <button class="btnConfirmarPedido" onclick="confirmarPedido()">Realizar pedido</button>
    
  </div>
</div>
<div id="notificacionPedido"></div>

<!--ventanita de targeta a depositar "comprar saldo"-->
<div class="formDeposito" id="formDeposito" style="display: none;  margin:auto;">
  <div class="contenidoDeposito">
    <button class="btncerrarDeposito" onclick="cerrarDeposito()" title="Cerrar">X</button>
    <h2 style="text-align: center;">Instrucciones de pago 💳</h2>
    <h2>Banco Azteca</h2>
    <label for="">Targeta:</label>
    <input type="text" value="4027 6600 4156 8850" readonly >
    <br>
    <br>
    <label for="">CLABE</label>
    <input type="text" name="" id="" value="1276 5101 3052 7081 29" readonly>
        <p class="number">enviar comprobante por WhatsApp: 953-540-4889</p>
     <p style="color: rgb(186, 186, 186); text-align: center;"> <strong>Titular: Ing. Dimarel Sosa Moreno. </strong></p>
  </div>
</div>

<!--form ver pedidos -->
<div class="formPedidos" id="formPedidos" style="display: none; margin: auto;">
 <table class="tablaPedidos">
    <thead>
      <tr>
          <th>ID Pedido</th>
          <th>IMEI</th>
          <th>Compañía</th>
          <th>Estado</th>
          <th>Resultado</th>
          <th>Costo</th>
          <th>Reembolsado</th>
          <th>Fecha</th>
      </tr>
    </thead>
    <tbody id="tbodyPedidos">
    </tbody>
 </table>
</div>
</div>

       <!--Ajustes-->
    <!-- AJUSTES -->
<div class="formAjustes" id="formAjustes" style="display: none; margin: auto;">

    <div class="cuadroAjustes">

        <button class="cerrarAjust"
                id="cerrar"
                onclick="cerrarAjustes()"
                title="Cerrar">
            X
        </button>

          <h2>Mi Perfil.</h2>

        <!-- Avatar -->
        <div class="avatarPerfil">
             <?php echo strtoupper(substr($nombre,0,1)); ?>
        </div>

      
        
        <div class="campoPerfil">
          <label for="">Correo electronico:</label>
          <input type="email" value="<?php echo $correo; ?>" readonly>
        </div>

        <div class="campoPerfil">
          <label for="">Nombre:</label>
          <input type="text" value="<?php echo $nombre; ?>" readonly>
        </div>


        <div class="campoPerfil">
          <label for="">Apellidos:</label>
          <input type="text"   id="apellidos" value="<?php echo $apellidos; ?>">
        </div>

        <div class="campoPerfil">
          <label for="">Telefono:</label>
          <input type="tel" id="telefono" value="<?php echo $telefono; ?>" maxlength="10"
>
        </div>

        <button class="btnGuardarPerfil" onclick="guardarPerfil()">💾 Guardar cambios</button>
         <div id="notificacionPerfil"></div> 
       

    </div>

</div>

   <script src="../js/liberaciones/mostraryocultar.js"></script>
   <script src="../js/liberaciones/solicitudesImei.js"></script>

</body>
</html>