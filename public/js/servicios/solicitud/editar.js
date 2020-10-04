let servicios = [];
let crear = document.getElementById('btn-servicio');
let cardBody = document.getElementById('card-body');
let guardar = document.getElementById('btn-guardar');

async function getServicios() {
    let res = await consumidor.get('servicios', 'todos_servicios');
    if (res.status == 200) {
        servicios = res.datos;
    } else {
        console.log(res);
    }
}

function agregarASelect(select) {
    let op = document.createElement('option');
    op.innerHTML = 'Seleccionas un servicos';
    op.setAttribute('value', 'null');
    select.appendChild(op);
    servicios.forEach(servicio => {
        let option = document.createElement('option');
        option.innerHTML = servicio.nombre;
        option.setAttribute('value', servicio.id);
        select.appendChild(option);
    });
}

function nuevoSelect() {

    let formGroup = document.createElement('div');
    formGroup.classList.add('form-group');

    let select = document.createElement('select');
    select.classList.add('custom-select', 'col-11');
    select.setAttribute('name', 'servicios')

    let boton = document.createElement('button');
    boton.classList.add('btn', 'btn-link', 'btn-sm', 'text-center', 'col-1');
    boton.innerHTML = `<i class="fas fa-times text-danger"></i>`;

    boton.addEventListener('click', () => {
        if (document.getElementsByClassName('custom-select').length > 1) {
            cardBody.removeChild(formGroup);
        } else {
            Alerta.show('danger', 'La solicitud debe incluir mínimo un servicio.');
        }
    });

    formGroup.appendChild(select);
    formGroup.appendChild(boton);
    cardBody.appendChild(formGroup);

    agregarASelect(select);
}

function addEventeButtons() {
    let botonesEliminar = document.getElementsByClassName('btn-link');
    for (let i = 0; i < botonesEliminar.length; i++) {
        botonesEliminar.item(i).addEventListener('click', () => {

            if (document.getElementsByClassName('custom-select').length > 2) {
                cardBody.removeChild(botonesEliminar.item(i).parentElement);
            } else {
                Alerta.show('danger', 'La solicitud debe incluir mínimo un servicio.');
            }

            addEventeButtons();
        });
    }
}

crear.addEventListener('click', () => nuevoSelect());

guardar.addEventListener('click', async () => {
    let selects = document.getElementsByName('servicios');
    let usuario = document.getElementById('usuario');

    let datos = [];

    for (let i = 0; i < selects.length; i++) {
        if (selects.item(i).value != 'null') {
            datos.push(selects.item(i).value);
        }
    }

    if (usuario.value == '') {
        datos = [];
        Erro.set('usuario_group', 'Debes seleccionar un cliente');
    }

    if (datos.length > 0) {
        let descripcion = document.getElementById('descripcion');
        let fechaEntrega = document.getElementById('fecha_entrega');
        let solicitudId = guardar.dataset.solicitud;
        let listo = document.getElementById('listo');
        let formData = new FormData();

        formData.append('solicitudId', solicitudId);
        formData.append('descripcion', descripcion.value);
        formData.append('servicios', datos);
        formData.append('cliente', usuario.value);
        formData.append('fechaEntrega', fechaEntrega.value);
        formData.append('listo', listo.checked ? 1 : 0);

        Spinner.start('btn-guardar');

        let res = await consumidor.post('servicios', 'actualizar_solicitud', formData);
        Spinner.end('btn-guardar');

        switch (res.status) {
            case 200:
                location.href = `${appLinkDomain}/servicios/solicitud`;
                break;
            case 400:
                let errores = res.error;
                errores.forEach(({ input, mensaje }) => Erro.set(`${input}_group`, mensaje));
                break;

            default:
                console.log(res);
                break;
        }
    } else {
        Alerta.show('warning', 'No hay servicios para guardar.');
    }
});

document.addEventListener('DOMContentLoaded', async () => {
    await getServicios();
    addEventeButtons();

});