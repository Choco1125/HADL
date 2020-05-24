<?php   
    class View{
        public $styles = [];
		public $scripts = [];
		public $active_nav_option = '';
		public $title_page = '';

		function render($view){
			require 'views/'.$view.'.php';
		}

		function set_title_page($tile){
			$this->title_page = $tile;
		}

		function get_title_page(){
			return $this->title_page;
		}
    }