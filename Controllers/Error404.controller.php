<?php
    class Error404 extends Controller{
        public function __construct(){
            parent::__construct();
            $this->view->set_title_page('Error');
        }

        public function render(){
            $this->view->render('404/index');
        }
    }