let btn = document.getElementById('btn-crear');

let id = document.getElementById('id');
let nombre = document.getElementById('nombre');
let descripcion = document.getElementById('descripcion');
let precio = document.getElementById('precio');

btn.addEventListener('click',async ()=>{

    let formData = new FormData();
    formData.append('id',id.value);
    formData.append('nombre',nombre.value);
    formData.append('descripcion',descripcion.value);
    formData.append('precio',precio.value);
    Spinner.start('btn-crear');
    let res = await consumidor.post('servicios','actualzar_servicio',formData);
    Spinner.end('btn-crear');
    switch (res.status) {
        case 200:
            window.location.href= 'servicios/catalogo';
            break;
        case 400:
            let errores = res.error;
            errores.forEach(({input,mensaje})=>Erro.set(`${input}_group`,mensaje));
            break;
    
        default:
            console.log(res);
            break;
    }
});

