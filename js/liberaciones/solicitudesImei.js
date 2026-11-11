       

 let companiaSeleccionada="";
 let costoSeleccionado=0;         

function comprar(comp, prec){
const mostrar=document.getElementById("formVentana");
const tituloL=document.getElementById("tituloLiberacion");
const costoL=document.getElementById("costoLiberacion");

companiaSeleccionada=comp;
costoSeleccionado=prec;
let opcion = "";

if(prec==50){
    opcion="económico";
}else if(prec==70){
    opcion="intermedio";
}else if(prec==150){
    opcion="premium";
}

  tituloL.textContent = comp +" código "+  opcion ;
  costoL.textContent="$" +prec +" MXN";
  
    mostrar.style.display="flex";
}


/*confirmar pedido de imei*/
function confirmarPedido(){
    const imei=document.getElementById("imeiLiberacion").value.trim();
    if(imei.length !=15){
      mostrarMensaje("El imei debe contener 15 numeros", "error", "notificacionPedido");
        return;
    }

 fetch("../php/guardarPedido.php",{
    method: "POST",
    headers:{
        "Content-Type":"application/x-www-form-urlencoded"},
    
        body:
        "imei=" + imei + 
        "&compania=" + companiaSeleccionada +
        "&costo=" + costoSeleccionado
 })
   
.then (enviando=>enviando.text())

.then(resultado=>{

    if(resultado=="sesion_expirada"){

        mostrarMensaje("Tu sesión expiró", "error", "notificacionPedido");

        setTimeout(() => {
            window.location.href="../index.php";
        }, 2000);

        return;
    }

    // 🔥 SALDO INSUFICIENTE
    if(resultado=="saldo_insuficiente"){

        mostrarMensaje("Saldo insuficiente", "error", "notificacionPedido");

        return;
    }

    // 🔥 PEDIDO EXITOSO
    if(resultado=="ok"){

        mostrarMensaje("🎉✓ Pedido Exitoso", "ok", "notificacionPedido");

        cerrarVentanita();

        // 🔥 ACTUALIZAR SALDO EN PANTALLA
        obtenerSaldo();

    }else{

        mostrarMensaje("Error al guardar pedido", "error", "notificacionPedido");
    }
});
}




/*Aqui ya mostramos los depidos*/
function verPedidos(){
    ocultarTodo();/*Aqui yocultamos todos los formularios*/
    document.getElementById("formPedidos").style.display="flex"; /*Mostramos la tabla dibujada*/
    cargarPedidos(); /*llamamos la funcion de abajo caragr pedidos para poder jalarlos*/
    // ACTUALIZAR PEDIDOS AUTOMÁTICAMENTE
setInterval(() => {

    cargarPedidos();

}, 3000);
}
// CARGAR PEDIDOS DEL USUARIO
async function cargarPedidos(){

    try{

        const respuestaServidor = await fetch("../php/obtenerPedidos.php");

        const listaPedidos = await respuestaServidor.json();

        const cuerpoTabla = document.getElementById("tbodyPedidos");

        cuerpoTabla.innerHTML = "";

        listaPedidos.forEach(pedido => {

            cuerpoTabla.innerHTML += `
            
            <tr>

                <td>${pedido.id_pedido}</td>

                <td>${pedido.imei}</td>

                <td>${pedido.compania}</td>

                <td>${pedido.estado}</td>

                <td>${pedido.resultado}</td>

                <td>$${pedido.costo}</td>
                <td>${pedido.reembolsado}</td>
  
                <td>${pedido.fecha_pedido}</td>

            </tr>

            `;
        });

    }catch(error){

        console.log("Error cargar pedidos:", error);
    }
}



    function cerrarVentanita(){
const cerrar=document.getElementById("formVentana");
      cerrar.style.display="none";
      document.getElementById("imeiLiberacion").value="";
      
}

/*VENTANA EMERGENTE COMPRAR SALDO*/
function comprarSaldo(){
const mostrarventana= document.getElementById("formDeposito");
      mostrarventana.style.display="flex";
}

//salir de la ventaba de comprar saldo
function cerrarDeposito(){
const salir=document.getElementById("formDeposito");
      salir.style.display="none";
}

function verAjustes(){
    const ver=document.getElementById("formAjustes");
          ver.style.display="flex";
}

function cerrarAjustes(){
    const cerrar=document.getElementById("formAjustes");
          cerrar.style.display="none";
}


/*notificaciones emergentes*/
function mostrarMensaje(texto, notificacion = "error", ids){

    const div = document.getElementById(ids);

    if(!div){
        console.log("No existe el contenedor:", ids);
        return;
    }

    div.textContent = texto;
    div.style.display = "flex";
    div.style.color = "white";
    div.style.width = "350px";
    div.style.height = "50px";
    div.style.borderRadius = "150px";
    div.style.textAlign = "center";
    div.style.alignItems = "center";
    div.style.justifyContent = "center";

    div.style.position = "fixed";
    div.style.top = "190px";
    div.style.left = "50%";
    div.style.transform = "translateX(-50%)";
    div.style.zIndex = "9999";

    if(notificacion === "ok"){
        div.style.backgroundColor = "green";
    }else{
        div.style.backgroundColor = "red";
    }

    setTimeout(() => {
        div.style.display = "none";
    }, 3000);
}


async function cargarSaldo(){

    try{

        const respuesta = await fetch("../php/obtenerSaldo.php");

        const data = await respuesta.json();

       

        if(data.success){

            document.getElementById("verSaldo").innerHTML =
            "Saldo: $" + parseFloat(data.saldo).toFixed(2);

        }

    }catch(error){

      

    }

}

cargarSaldo();

setInterval(cargarSaldo, 3000);

/*Formulario PERFIL, cambiar apellidos y numero*/
function guardarPerfil(){

    let apellidos = document.getElementById("apellidos").value;
    let telefono = document.getElementById("telefono").value;

    let datos = new FormData();
    datos.append("apellidos", apellidos);
    datos.append("telefono", telefono);

    fetch("../php/actualizarPerfil.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.text())
    .then(respuesta => {

        if(respuesta === "ok"){

            mostrarMensaje ("✅Perfil actualizado correctamente", "ok", "notificacionPerfil");

            setTimeout(() => {
                cerrarAjustes();
            },2000);

        }else{

            mostrarMensaje ("Error al actualizar perfil", "error", "notificacionPerfil");

        }

    })
    .catch(error => {
        console.log(error);
    });

}