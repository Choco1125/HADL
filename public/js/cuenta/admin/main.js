const actualizar = document.getElementById('btn-crear');

const id = document.getElementById('id');
const nombres = document.getElementById('nombre');
const email = document.getElementById('email');


actualizar.addEventListener('click', async () => {
  let formData = new FormData();

  formData.append('id', id.value);
  formData.append('nombres', nombres.value);
  formData.append('email', email.value);
  Spinner.start('btn-crear');
  let res = await consumidor.post('cuenta', 'actualizar', formData);
  Spinner.end('btn-crear');
  switch (res.status) {
    case 200:
      location.href = `${appLinkDomain}/cuenta`;
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
