const Erro = {
    set: function(id,mensaje){
        let grupo = document.getElementById(id);
        
        let input = grupo.children[1];
        let span = grupo.children[2];

        input.classList.add('is-invalid');
        span.innerHTML = mensaje;

        input.addEventListener('change', ()=>{
            input.classList.remove('is-invalid');
            span.innerHTML = '';
        });
    }
}