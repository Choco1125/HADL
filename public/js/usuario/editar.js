const actualizar = document.getElementById('btn-actualizar');

const nombres = document.getElementById('nombre');
const email = document.getElementById('email');
const rol = document.getElementById('rol');
const estado = document.getElementById('estado');
const nit = document.getElementById('nit');
const celular = document.getElementById('celular');
const direccion = document.getElementById('direccion');


const contenido = document.getElementById('contenido-usuario');

rol.addEventListener('change',()=>{
    if(rol.value == 'admin'){
        contenido.classList.add('d-none');
    }else{
        contenido.classList.remove('d-none');
    }
})

actualizar.addEventListener('click',async ()=>{
    let id = actualizar.dataset.usuario;
    let formData = new FormData();

    formData.append('id',id);
    formData.append('nombres',nombres.value);
    formData.append('email',email.value);
    formData.append('rol',rol.value);
    formData.append('estado',estado.value);
    formData.append('nit',nit.value);
    formData.append('celular',celular.value);
    formData.append('direccion',direccion.value);
    Spinner.start('btn-actualizar');
    let res = await consumidor.post('usuarios','actualizar',formData);
    Spinner.end('btn-actualizar');
    switch (res.status) {
        case 200:
            location.href = `${appLinkDomain}/usuarios`;
            break;
        case 400:
            let errores = res.errores;
            errores.forEach(({input,mensaje})=>Erro.set(`${input}_group`,mensaje));
            break;
        default:
            console.log(res);    
            break;
    }

});