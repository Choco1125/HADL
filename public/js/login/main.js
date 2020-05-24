let botonLogin = document.getElementById('btn-login');

let email = document.getElementById('email');
let password = document.getElementById('password');

botonLogin.addEventListener('click',async()=>{


    let formData = new FormData();

    formData.append('email',email.value);
    formData.append('password',password.value);
    Spinner.start('btn-login');
    let res = await consumidor.post('main','login',formData );
    Spinner.end('btn-login');

    switch(res.status){
        case 200:
            location.href = 'home';
            break;
        case 404:
        case 400:
            let errores = res.error;
            errores.forEach(({input,mensaje})=>Erro.set(`${input}_group`,mensaje));
            break;
        default:
            console.log(res);
            break;
    }
});