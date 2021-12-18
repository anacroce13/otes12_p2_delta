<?php 
    class Conexao {
        private $host = "localhost";
        private $nomebanco = "p2_delta";
        private $usuario = "root";
        private $password = "b9db9f36a4";

        public $conn;

        public function conectar(){
            $this->conn = null;
            try{
                // String de conexão padrão do mysql
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->nomebanco, $this->usuario, $this->password);
                // Setar conexão para UTF-8 (o collation adotado do banco de dados é utf8_general_ci)
                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Erro de conexão ao banco de dados: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }  
?>