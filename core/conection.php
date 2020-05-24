<?php
    abstract class Connection{
        protected $coexion_db;

        public function __construct(){
            try {
                $dsn = DB_DRIVER.':host='.DB_HOST.';dbname='. DB_NAME;
                $this->db_connection = new PDO($dsn,DB_USER,DB_PASS);
                $this->db_connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $ex) {
                echo $ex->getMessage();
                die();
            }
        }
    }