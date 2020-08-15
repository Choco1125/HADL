function botonActivar(id) {
    let boton  = document.createElement('button');
    boton.classList.add('btn','btn-outline-success','btn-sm','btn-estado');
    boton.dataset.estado = 'inactivo';
    boton.id = id;
    boton.innerHTML = 'Activar';

    return boton;
}

function botonDesctivar(id) {
    let boton  = document.createElement('button');
    boton.classList.add('btn','btn-outline-danger','btn-sm','btn-estado');
    boton.dataset.estado = 'activo';
    boton.id = id;
    boton.innerHTML = 'Desactivar';

    return boton;
}

function toggleButton(id) {
    let tr = document.getElementById(`botones-${id}`);
    let boton = document.getElementById(`${id}`);

    let estado = boton.dataset.estado;
    tr.removeChild(boton);
		console.log(estado);
    if(estado == 'inactivo' || estado == 'solicitando'){
        tr.appendChild(botonDesctivar(id));
    }else{
        tr.appendChild(botonActivar(id));
    }

    agregar_evento();
}

function agregar_evento() {
    let botones = document.getElementsByClassName('btn-estado');
    for (let i = 0; i < botones.length; i++) {
        let id = botones.item(i).id;
        let estado = botones.item(i).dataset.estado;


        botones.item(i).addEventListener('click', async ()=>{
            Spinner.start(id);
            let formData = new FormData();
            formData.append('id',id);
            formData.append('estado',estado);
            let res = await consumidor.post('usuarios','cambiar_estado',formData);
            Spinner.end(id);
            switch (res.status) {
                case 200:
                    toggleButton(res.datos.id);
                    break;
                case 500:
                    alert('error');
                    break;
                default:
                    console.log(res);
                    break;
            }
            
        });
    }
}

document.addEventListener('DOMContentLoaded', async () => agregar_evento());
