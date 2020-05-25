const Spinner = {
    create: function(){
        let spinner = document.createElement('div');
        spinner.setAttribute('id','spinner');
        spinner.classList.add('spinner-border','spinner-border-sm');
        return spinner;
    },
    start: function(id){
        let elemento = document.getElementById(id);
        elemento.setAttribute('disabled','');
        elemento.appendChild(this.create());
    },
    end: function(id){
        let elemento = document.getElementById(id);
        elemento.removeAttribute('disabled');
        elemento.removeChild(document.getElementById('spinner'));
    }
}