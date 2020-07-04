<?php
    class Home  extends Controller{
        public function __construct(){
            parent::__construct();
            if(!$this->is_login()){
                header('location: '.URL.'');
            }
            $this->view->active = 'home';
            $this->view->set_title_page('Inicio');
        }

        public function render(){
            $this->view->render($_SESSION['rol'] == 'admin' ? 'admin/home/index' : 'user/home/index');
        }
    }
