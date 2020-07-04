const btnEliminar = document.getElementById('btn-eliminar');

function agregarEventoParaBotonesEliminar() {
    let botones = document.getElementsByClassName('btn-outline-danger');
    for (let i = 0; i < botones.length; i++) {
        botones.item(i).addEventListener('click',()=>
            btnEliminar.dataset.cotizacion = botones.item(i).dataset.cotizacion
        );
    }
}

function eliminarFila(id) {
    let tabla =document.getElementById('tbl');
    let tr = document.getElementById(id);

    tabla.removeChild(tr);
    agregarEventoParaBotonesEliminar();
}

btnEliminar.addEventListener('click',async ()=>{
    Spinner.start('btn-eliminar');
    let cotizacionId =  btnEliminar.dataset.cotizacion;

    let formData = new FormData();
    formData.append('id',cotizacionId);

    let respuesta = await consumidor.post('cotizaciones','delete',formData);
    
    if(respuesta.status){
      Alerta.show('success','Cotización eliminada');
      $('#eliminar').modal('hide');
      eliminarFila(cotizacionId);
    }else{
      $('#eliminar').modal('hide');
      console.error(respuesta);
    }

    Spinner.end('btn-eliminar'); 
});

agregarEventoParaBotonesEliminar();
