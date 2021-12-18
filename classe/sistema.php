<?php
    class Sistema{

        // Atributos de conexão
        private $conn;
        private $db_table = "sistema";

        // Atributos da entidade (são as colunas da tabela vinculada à essa classe/entidade)
        public $id;
        public $nome_sistema;

        // Instanciar conexão
        public function __construct($db){
            $this->conn = $db;
        }

        /** 
            Abaixo, métodos das operações de CRUD desta classe
            */

        // CREATE (criar registro)
        public function criarsistema(){
            $sql = "INSERT INTO ". $this->db_table .
                   "SET
                        nm_sistema = :nome_sistema";
        
            $stmt = $this->conn->prepare($sql);
        
            // vincular dados
            $stmt->bindParam(":nome_sistema", $this->nome_sistema);
        
            // tentar inserir
            if($stmt->execute()){
                echo "Registro inserido com sucesso!";
                return true;
            }

            // tratar falha
            echo "Não foi possível inserir o registro.";
            return false;
        }

        // READ ALL (buscar todos os registros)
        public function buscarsistemas(){
            $sql = "SELECT cd_sistema AS id, 
                           nm_sistema AS nome_sistema
                    FROM " . $this->db_table;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        }

        // READ (buscar registro específico)
        public function buscarsistema(){
            $sql = "SELECT cd_sistema, 
                           nm_sistema
                      FROM ". $this->db_table . "
                    WHERE  id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            // retornar única row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $row['cd_sistema'];
            $this->nome_sistema = $row['nm_sistema'];

            return $row;
        }   

        // UPDATE (Atualizar registro)
        public function atualizarsistema(){
            $sql = "UPDATE ". $this->db_table ."
                    SET
                        nm_sistema = :nome_sistema
                    WHERE 
                        cd_sistema = :id";
        
            $stmt = $this->conn->prepare($sql);
        
            // vincular dados
            $stmt->bindParam(":nome_sistema", $this->nome_sistema);
            $stmt->bindParam(":id", $this->id);
        
            // tentar atualizar
            if($stmt->execute()){
               echo "Registro atualizado com sucesso!";
               return true;
            }

            // tratar falha
            echo "Não foi possível atualizar o registro.";
            return false;
        }

        // DELETE (Excluir registro)
        function excluirsistema(){
            $sql = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
        
            $stmt->bindParam(1, $this->id);
        
            // tentar excluir
            if($stmt->execute()){
                echo "Registro excluído com sucesso. (Ops, tomara que você tenha desejado fazer isto mesmo!)";
                return true;
            }
            echo "Não foi possível excluir o registro.";
            return false;
        }

    }
?>