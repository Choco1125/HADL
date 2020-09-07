const actualizar = document.getElementById('btn-crear');

const new_password = document.getElementById('new_password');
const new_password_repeat = document.getElementById('new_password_repeat');

actualizar.addEventListener('click', async () => {
  let formData = new FormData();

  formData.append('new_password', new_password.value);
  formData.append('new_password_repeat', new_password_repeat.value);
  Spinner.start('btn-crear');
  let res = await consumidor.post('cuenta', 'actualizar_contraseña', formData);
  Spinner.end('btn-crear');
  console.log(res);
  switch (res.status) {
    case 200:
      location.href = `${appLinkDomain}/cuenta/contrasena`;
      break;
    case 400:
      let errores = res.errores;
      errores.forEach(({ input, mensaje }) => Erro.set(`${input}_group`, mensaje));
      break;
    default:
      console.log(res);
      break;
  }

});
