<?php
    class Controller{

		public $view;

        function __construct(){

			$this->view = new View();

			if(session_status() !== 'PHP_SESSION_ACTIVE'){
				session_start();
			}
		}	

		function load_model($model){
            $file_controller = 'models/'.$model.'.model.php';
            
			if(file_exists($file_controller)){
				require $file_controller;
			}
		}

		public function set_value($value){
			return isset($value)? $value : '';
		}

		public function is_admin(){
			return isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin';
		}
    }