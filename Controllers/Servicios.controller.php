<?php
    class Servicios extends Controller{
        public function __construct(){
            parent::__construct();
            $this->view->active = 'servicios';
            $this->view->set_title_page('Servicios');
        }

        public function render(){
            $this->view->render('admin/servicios/solicitud');
        }

        public function catalogo(){
            $this->view->render('admin/servicios/catalogo');
        }

        public function solicitud(){
            $this->view->render('admin/servicios/solicitud');
        }

    }