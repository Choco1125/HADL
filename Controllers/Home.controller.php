<?php
    class Home  extends Controller{
        public function __construct(){
            parent::__construct();
            $this->view->active = 'home';
            $this->view->set_title_page('Inicio');
        }

        public function render(){
            $this->view->render('admin/home/index');
        }
    }