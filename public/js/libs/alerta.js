const Alerta = {
    show: function (tipo,mensaje) {
        let alerta = document.getElementById('alerta');
        alerta.classList.add(`alert-${tipo}`);
        alerta.innerHTML = mensaje;
        setTimeout(()=>{
            alerta.classList.remove(`alert-${tipo}`);
            alerta.innerHTML = '';
        },2000);
    }
}