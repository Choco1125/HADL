let btn = document.getElementById('btn-crear');

let nombre = document.getElementById('nombre');
let descripcion = document.getElementById('descripcion');
let precio = document.getElementById('precio');

let tbl = document.getElementById('tbl');

function agregarFila(id, nombre,descripcion,precio) {
    let tr = document.createElement('tr');
    let valores = [nombre,descripcion,precio,id];
    for (let i = 0; i < valores.length; i++) {
        let td = document.createElement('td');
        td.innerHTML = valores[i];
        tr.appendChild(td);
    }
    tbl.appendChild(tr);
}

btn.addEventListener('click',async ()=>{

    let formData = new FormData();
    formData.append('nombre',nombre.value);
    formData.append('descripcion',descripcion.value);
    formData.append('precio',precio.value);
    Spinner.start('btn-crear');
    let res = await consumidor.post('servicios','crear_servicio',formData);
    Spinner.end('btn-crear');
    switch (res.status) {
        case 201:
            let datos = res.datos;
            agregarFila(datos.id,datos.nombre,datos.descripcion,datos.precio);
            nombre.value = '';
            descripcion.value = '';
            precio.value = '';
            $('#crear').modal('hide');
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

