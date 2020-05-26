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
			return isset($value)? trim($value) : '';
		}

		public function is_admin(){
			return isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin';
		}
		public function is_valid_email($email){
            return preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $email);
		}
		public function is_valid_number($value){
			return is_numeric($value);
		}

		public function formatear_numero($value){
			return str_replace(['-','.',' '],'',$value);
		}
    }