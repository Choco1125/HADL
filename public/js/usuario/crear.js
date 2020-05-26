const crear = document.getElementById('btn-crear');

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

crear.addEventListener('click',async ()=>{
    let formData = new FormData();

    formData.append('nombres',nombres.value);
    formData.append('email',email.value);
    formData.append('rol',rol.value);
    formData.append('estado',estado.value);
    formData.append('nit',nit.value);
    formData.append('celular',celular.value);
    formData.append('direccion',direccion.value);

    let res =await consumidor.post('usuario','nuevo',formData);

    switch (res.status) {
        case 200:
            
            break;
        case 400:
            let errores = [];
            errores.forEach(({input,mensaje})=>);
            break;
        default:
            console.log(res);    
            break;
    }
});