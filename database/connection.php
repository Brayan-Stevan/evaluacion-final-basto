<?php
    class database{
        private $hostname = "localhost" ;
        private $database = "nequi" ;
        private $username = "root";
        private $password = "";
        private $charset = "utf8";
        private $port = "3306";
        function conectar()
        {
            try{
                $conexion = "mysql:host=". $this->hostname .";port=" . $this->port . "; dbname=" . $this->database . "; charset=" .$this->charset;
                $option = [
                    PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false 
                ];
            
            $pdo = new PDO($conexion, $this->username, $this->password, $option);
            return $pdo;
            }
            catch(PDOException $e){
                echo "Error de Conexion: " . $e->getMessage();
                exit;
            };

            
        }

    }
?>