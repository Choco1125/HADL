let botonLogin = document.getElementById('btn-login');

let email = document.getElementById('email');

botonLogin.addEventListener('click', async () => {

  let formData = new FormData();

  formData.append('email', email.value);
  Spinner.start('btn-login');
  let res = await consumidor.post('recuperar', 'recuperar_contrasena', formData);
  Spinner.end('btn-login');
  switch (res.status) {
    case 200:
      alert('Por favor revisa tu correo.');
      location.href = appLinkDomain + '/main';
      break;
    case 404:
    case 400:
      let errores = res.errores;
      errores.forEach(({ input, mensaje }) => Erro.set(`${input}_group`, mensaje));
      break;
    default:
      console.log(res);
      break;
  }
});
