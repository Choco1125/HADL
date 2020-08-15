let botonRegistrarse = document.getElementById("btn-registrarse");

let email = document.getElementById("email");
let nombre = document.getElementById("nombre");
let celular = document.getElementById("celular");

botonRegistrarse.addEventListener("click", async () => {
  let formData = new FormData();

  formData.append("email", email.value);
  formData.append("nombre", nombre.value);
  formData.append("celular", celular.value);
  Spinner.start("btn-registrarse");
  let res = await consumidor.post("registrarse", "registrarse", formData);
  Spinner.end("btn-registrarse");

  console.log(res);

  switch (res.status) {
   case 201:
		 Alerta.show('success','Solicitud enviada exitosamente');
     break;
   case 404:
   case 400:
     let errores = res.error;
     errores.forEach(({ input, mensaje }) =>
       Erro.set(`${input}_group`, mensaje)
     );
     break;
   default:
     console.log(res);
     break;
  }
});
