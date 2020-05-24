<?php
    class Home  extends Controller{
        public function __construct(){
            parent::__construct();

            $this->view->set_title_page('Inicio');            
        }

        public function render(){
            
        }
    }