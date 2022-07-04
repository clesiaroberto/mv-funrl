<?php
    namespace funeraria\config;
    
    class config {

        private $version = '1.0';
        private $server = "localhost";
        private $user = "root";
        private $pass = "";
        private $name = "funeraria";
        private $uri;

        protected $basepath;
        protected $conn;

        function close($con) {
            mysqli_close($con);
        }

        function getCurrentUri(){
            $this->basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
            $this->uri = substr($_SERVER['REQUEST_URI'], strlen($this->basepath));
            $this->uri = '/' . trim($this->uri, '/');
            return $this->uri;
        }

        function open() {
            try {
                $this->conn = mysqli_connect($this->server, $this->user, $this->pass, $this->name);
                // Alterar o conjunto de caracteres para utf8
                $this->conn -> set_charset("utf8");
                return $this->conn;
            } catch(\PDOException $e) {
                echo "H&aacute; algum problema na conex&atilde;o: " . $e->getMessage();
            }
        }

        function to_remove_accents($string){
            return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"), explode(" ","a A e E i I o O u U n N c C"), $string);
        }
    }
?>