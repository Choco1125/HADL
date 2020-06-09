let btnEliminar = document.getElementById('btn-eliminar');

function setListener() {
    let eliminar = document.getElementsByClassName('btn-outline-danger');
    for(let i = 0; i< eliminar.length; i++){
        eliminar.item(i).addEventListener('click',()=>{
            btnEliminar.dataset.id = eliminar.item(i).dataset.id;
        });
    }
}

function eliminarFila(id) {
    let tabla =document.getElementById('tbl');
    let tr = document.getElementById(id);
    console.log(tr);
    tabla.removeChild(tr);
    setListener();
}

btnEliminar.addEventListener('click',async ()=>{
    Spinner.start('btn-eliminar');
    let formData = new FormData();
    formData.append('id',btnEliminar.dataset.id);
    let res = await consumidor.post('servicios','eliminar_solicitud',formData);
    Spinner.end('btn-eliminar');

    if(res.status == 200){
        Alerta.show('success','Servicio eliminado');
        $('#eliminar').modal('hide');
        console.log(btnEliminar.dataset.id);
        eliminarFila(btnEliminar.dataset.id);
    }else{
        console.log(res);
        $('#eliminar').modal('hide');
    }
});

setListener();