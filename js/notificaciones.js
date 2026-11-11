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
    div.style.top = "20px";
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
