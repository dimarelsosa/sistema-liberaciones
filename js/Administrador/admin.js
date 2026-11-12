let clienteActual = null;
let callbackConfirm = null;
let pedidoActualCodigo = null;

         const BOTONES =document.querySelectorAll(".botones button");
            BOTONES.forEach(presion=>{
                presion.addEventListener("click",() =>{
            BOTONES.forEach(remover=>remover.classList.remove("prendido"));
                presion.classList.add("prendido");
                });
            });

   


        function ocultarTodo(){
            document.getElementById("formPedidos").style.display="none";
            document.getElementById("formEditar").style.display="none";
            document.getElementById("formClientes").style.display="none";
            document.getElementById("welcomeAguila").style.display="none";
        }

        function pedidosClientes(){
             ocultarTodo();
             document.getElementById("formPedidos").style.display="flex";
             cargarPedidos()
            
        }

        function modificarClientes(){
            ocultarTodo();
            document.getElementById("formEditar").style.display="flex";
             cargarClientesEditar();
        }
        
        function totalClientes(){
            ocultarTodo();
            document.getElementById("formClientes").style.display="flex";
            cargarClientes();
        }


  



        
      // cargar clientes (formClientes)
async function cargarClientes(){

    try{

        const respuesta = await fetch("../php/obtenerClientes.php");

        const clientes = await respuesta.json();

        const tbody = document.getElementById("tbodyClientes");

        tbody.innerHTML = "";

        clientes.forEach(cliente => {

            tbody.innerHTML += `
            
            <tr>

                <td>${cliente.id}</td>

                <td>
                    ${cliente.nombre} ${cliente.apellidos}
                </td>

                <td>${cliente.correo}</td>

                <td>${cliente.rol}</td>

                <td>${cliente.telefono}</td>

                <td>
                    $${parseFloat(cliente.saldo).toFixed(2)}
                </td>

                <td>${cliente.fecha_registro}</td>

             

                <td>${cliente.total_pedidos}</td>

                <td>
    <button onclick="abrirModalSaldo(${cliente.id}, ${cliente.saldo})">
        +Saldo
    </button>
</td>


            </tr>

            `;
        });

    }catch(error){

        console.error("Error al cargar clientes:", error);
    }
}

cargarClientes();





//ver pedidos de los clientes
async function cargarPedidos(){

    try{

        const respuestaServidor = await fetch("../php/obtenerPedidosAdmin.php");

        const listaPedidos = await respuestaServidor.json();

        

        // VALIDAR SI ES ARRAY
        if(!Array.isArray(listaPedidos)){

            console.error("La respuesta NO es un array");

            return;
        }

        const cuerpoTablaPedidos = document.getElementById("tbodyPedidos");

        cuerpoTablaPedidos.innerHTML = "";

        listaPedidos.forEach(pedido => {

            const costo = parseFloat(pedido.costo);

     const estado = (pedido.estado || "")
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .trim()
            .toUpperCase();

            let claseFila = "";

            if (estado.includes("COMPLETADO") || estado.includes("EXITO")) {
                claseFila = "pedido-verde";     // 🟢 Éxito
            } else if (estado.includes("RECHAZADO")) {
                claseFila = "pedido-rojo";      // 🔴 Rechazado
            } else {
                claseFila = "pedido-amarillo";  // 🟡 Pendiente / Recién solicitado
            }

            cuerpoTablaPedidos.innerHTML += `
            
            <tr class="${claseFila}">

                <td>${pedido.id_pedido}</td>

                <td>${pedido.nombre_usuario}</td>
                
                <td>${pedido.correo_usuario}</td>

                <td>${pedido.imei}</td>

                <td>${pedido.compania}</td>

                <td>${pedido.estado}</td>

                <td>${pedido.resultado}</td>

                <td>$${parseFloat(pedido.costo).toFixed(2)}</td>

                <td>${pedido.reembolsado}</td>

                <td>${pedido.fecha_pedido}</td>

                <td>

                    <button onclick="aprobarPedido(${pedido.id_pedido})">
                        ✅ Éxito
                    </button>

                    <button onclick="rechazarPedido(${pedido.id_pedido}, ${pedido.id_usuario}, ${costo})">
                        ❌ Rechazar
                    </button>

                </td>

            </tr>
            `;
        });

    }catch(error){

        console.error("Error cargarPedidos:", error);
    }
}

// EJECUTAR CARGA DE PEDIDOS
cargarPedidos();


// ACTUALIZAR CADA 3 SEGUNDOS
setInterval(() => {

    cargarPedidos();

}, 3000);



// ABRIR MODAL CODIGO
function aprobarPedido(idPedido){

    pedidoActualCodigo = idPedido;

    document.getElementById("modalCodigo").style.display = "flex";
}



// CERRAR MODAL
function cerrarModalCodigo(){

    document.getElementById("modalCodigo").style.display = "none";

    document.getElementById("inputCodigo").value = "";
}



// CONFIRMAR CODIGO
async function confirmarCodigo(){

    const codigo = document.getElementById("inputCodigo").value.trim();

    if(codigo == ""){

        mostrarMensaje("Ingresa un código", "error", "notificacionAgregarSaldo");

        return;
    }

    const res = await fetch("../php/aprobarPedido.php",{

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:
        `id_pedido=${pedidoActualCodigo}&codigo=${codigo}`
    });

   const resultado = (await res.text()).trim();
   console.log(resultado);

    if(resultado == "ok"){

        mostrarMensaje("Pedido aprobado", "success", "notificacionAgregarSaldo");

        cerrarModalCodigo();

        cargarPedidos();

    }else{

        mostrarMensaje("Error al aprobar", "error", "notificacionAgregarSaldo");
    }
}


//RECHAZAR CODIGO NO ENCONTRADO

async function rechazarPedido(idPedido, idUsuario, costo){
   
    console.log("CLICK RECHAZAR");

    mostrarConfirmacion(
        `¿Reembolsar $${costo} al cliente?`,

        async () => {

            const res = await fetch("../php/rechazarPedido.php",{

                method:"POST",

                headers:{
                    "Content-Type":"application/x-www-form-urlencoded"
                },

                body:
                `id_pedido=${idPedido}&id_usuario=${idUsuario}&costo=${costo}`
            });

            const resultado = (await res.text()).trim();
            console.log(resultado);
if(resultado == "ok"){

    mostrarMensaje(
        "Pedido rechazado y saldo reembolsado",
        "success",
        "notificacionAgregarSaldo"
    );

    cargarPedidos();

}else if(resultado == "ya_reembolsado"){

  mostrarMensaje("Este pedido ya fue reembolsado", "error", "notificacionYaFueReembolsado");

}else{

    mostrarMensaje(
        "Error al rechazar",
        "error",
        "notificacionAgregarSaldo"
    );
}

        }
    );
}




//abrir modal 
function abrirModalSaldo(id, saldoActual) {
    clienteActual = id;

    document.getElementById("modalSaldo").style.display = "flex";
    document.getElementById("infoCliente").innerText =
        `Saldo actual: $${saldoActual}`;
}


//confirma saldo
async function confirmarSaldo() {

    let monto = Number(document.getElementById("inputSaldo").value);

    if (isNaN(monto) || monto <= 0) {
        mostrarMensaje("Monto inválido", "error", "notificacionAgregarSaldo");
        return;
    }

    mostrarConfirmacion(`¿Agregar $${monto} al cliente?`, async () => {
        await ejecutarAgregarSaldo(monto);
    });
}
//ejecutar fetch
async function ejecutarAgregarSaldo(monto) {

    try {
        const res = await fetch("../php/agregarSaldo.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `id=${clienteActual}&monto=${monto}`
        });

        const text = await res.text();
        console.log("RESPUESTA:", text);

        const data = JSON.parse(text);

        if (data.success) {
            mostrarMensaje("Saldo agregado correctamente", "success", "notificacionAgregarSaldo");
            cerrarModal();
            cargarClientes();
        } else {
            mostrarMensaje("Error al agregar saldo", "error", "notificacionAgregarSaldo");
        }

    } catch (error) {
        console.log(error);
        mostrarMensaje("Error de conexión", "error", "notificacionAgregarSaldo");
    }
}

function mostrarConfirmacion(mensaje, callback) {
    document.getElementById("textoConfirm").innerText = mensaje;
    document.getElementById("modalConfirm").style.display = "flex";
    callbackConfirm = callback;
}

function cancelarConfirm() {
    document.getElementById("modalConfirm").style.display = "none";
    callbackConfirm = null;
}

function aceptarConfirm() {
    document.getElementById("modalConfirm").style.display = "none";

    if (callbackConfirm) {
        callbackConfirm();
    }
}

function cerrarModal() {
    document.getElementById("modalSaldo").style.display = "none";
    document.getElementById("inputSaldo").value = "";
}


//formulario editar clientes
// FORMULARIO EDITAR CLIENTES

async function cargarClientesEditar() {

    // PETICION AL PHP
    const respuestaServidor = await fetch("../php/obtenerClientes.php");

    // CONVERTIR A JSON
    const listaClientes = await respuestaServidor.json();

    // TBODY DE LA TABLA
    const cuerpoTablaEditar = document.getElementById("tbodyEditar");

    // LIMPIAR TABLA
    cuerpoTablaEditar.innerHTML = "";

    // RECORRER CLIENTES
    listaClientes.forEach(cliente => {

        cuerpoTablaEditar.innerHTML += `
        
              <tr id="filaCliente${cliente.id}">

            <td>${cliente.id}</td>

            <td>${cliente.nombre}</td>

            <td>${cliente.correo}</td>

            <td>${cliente.telefono}</td>

            <td>${cliente.saldo}</td>

            <td>${cliente.fecha_registro}</td>

            <td>

                <button onclick="editarCliente(${cliente.id})">
                    Editar
                </button>

                <button onclick="eliminarCliente(${cliente.id})">
                Eliminar
                </button>

            </td>

        </tr>

        `;
    });
}

// EJECUTAR FUNCION
cargarClientesEditar();



// FUNCION EDITAR CLIENTE
function editarCliente(idCliente){

    // OBTENER FILA
    const filaCliente = document.getElementById(`filaCliente${idCliente}`);

    // OBTENER TD
    const columnas = filaCliente.querySelectorAll("td");

    // OBTENER DATOS ACTUALES
    const nombreActual = columnas[1].innerText;

    const correoActual = columnas[2].innerText;

    const telefonoActual = columnas[3].innerText;

    const saldoActual = columnas[4].innerText;

    // REEMPLAZAR POR INPUTS
    columnas[1].innerHTML = `
        <input type="text" value="${nombreActual}">
    `;

    columnas[2].innerHTML = `
        <input type="text" value="${correoActual}">
    `;

    columnas[3].innerHTML = `
        <input type="text" value="${telefonoActual}">
    `;

    columnas[4].innerHTML = `
        <input type="number" value="${saldoActual}">
    `;

    // BOTONES
    columnas[6].innerHTML = `
    
        <button onclick="guardarCliente(${idCliente})">
            Guardar
        </button>

        <button onclick="cargarClientesEditar()">
            Cancelar
        </button>

    `;
}



// GUARDAR CLIENTE
async function guardarCliente(idCliente){

    // OBTENER FILA
    const filaCliente = document.getElementById(`filaCliente${idCliente}`);

    // OBTENER INPUTS
    const inputs = filaCliente.querySelectorAll("input");

    // OBTENER VALORES
    const nombreCliente = inputs[0].value;

    const correoCliente = inputs[1].value;

    const telefonoCliente = inputs[2].value;

    const saldoCliente = inputs[3].value;

    // ENVIAR AL PHP
    const respuestaServidor = await fetch("../php/editarCliente.php", {

        method: "POST",

        headers: {
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:
        `id=${idCliente}&nombre=${nombreCliente}&correo=${correoCliente}&telefono=${telefonoCliente}&saldo=${saldoCliente}`
    });

    // RESPUESTA
    const resultado = await respuestaServidor.text();

    console.log(resultado);

    // VALIDAR
    if(resultado == "ok"){

        mostrarMensaje(
            "Cliente actualizado",
            "ok",
            "notificacionEditarCliente"
        );

        cargarClientesEditar();

    }else{

        mostrarMensaje(
            "Error al actualizar",
            "error",
            "notificacionEditarCliente"
        );
    }
}

//Eliminar cliente
// ELIMINAR CLIENTE
function eliminarCliente(idCliente){

    mostrarConfirmacion(

        "¿Deseas eliminar este cliente?",

        async () => {

            const respuestaServidor = await fetch("../php/eliminarCliente.php", {

                method: "POST",

                headers:{
                    "Content-Type":"application/x-www-form-urlencoded"
                },

                body: `id=${idCliente}`
            });

            const resultado = await respuestaServidor.text();

            console.log(resultado);

            // VALIDAR
            if(resultado == "ok"){

                mostrarMensaje(
                    "Cliente eliminado",
                    "ok",
                    "notificacionEditarCliente"
                );

                cargarClientesEditar();

            }else{

                mostrarMensaje(
                    "Error al eliminar",
                    "error",
                    "notificacionEditarCliente"
                );
            }

        }
    );
}



// BUSCADOR DE CLIENTES
document.getElementById("buscadorEditar").addEventListener("keyup", function(){

    // TEXTO DEL INPUT
    const textoBusqueda = this.value.toLowerCase();

    // FILAS DE LA TABLA
    const filasClientes = document.querySelectorAll("#tbodyEditar tr");

    // RECORRER FILAS
    filasClientes.forEach(fila => {

        // TEXTO COMPLETO DE LA FILA
        const textoFila = fila.innerText.toLowerCase();

        // VALIDAR SI COINCIDE
        if(textoFila.includes(textoBusqueda)){

            fila.style.display = "";

        }else{

            fila.style.display = "none";
        }
    });
});