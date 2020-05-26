<?php 

    class App {

        public function __construct(){
            $url = isset($_GET['url'])?$_GET['url']:null;
            $url = rtrim($url,'/');
            $url = explode("/",$url);


            if(empty($url[0])){
                $controlador_archivo = 'Controllers/Main.controller.php';
                require $controlador_archivo;
                $controlador = new Main();
                $controlador->render();
            }else{
                $controlador_archivo = 'Controllers/'.ucfirst($url[0]).'.controller.php';

                if(file_exists($controlador_archivo)){
                    require $controlador_archivo;
                    $controlador = new $url[0];

                    $numero_parametros = sizeof($url);

                    if($numero_parametros>1){
                        if($numero_parametros>2){
                            $parametros = [];

                            for ($i=2; $i < $numero_parametros; $i++) { 
                                array_push($parametros,$url[$i]);
                            }

                            $controlador->{$url[1]}($parametros);

                        }else{
                            $controlador->{$url[1]}();
                        }
                    }else{
                        $controlador->render();
                    }
                }else{

                    require 'Controllers/Error404.controller.php';
                    $controlador = new Error404();
                    $controlador->render();
                }
            }
        }

    }