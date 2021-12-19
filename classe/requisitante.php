<?php
    class Requisitante{

        // Atributos de conexão
        private $conn;
        private $db_table = "requisitante";

        // Atributos da entidade (são as colunas da tabela vinculada à essa classe/entidade)
        public $id;
        public $nome_requisitante;

        // Instanciar conexão
        public function __construct($db){
            $this->conn = $db;
        }

        /** 
            Abaixo, métodos das operações de CRUD desta classe
            */

        // CREATE (criar registro)
        public function criarRequisitante(){
            $sql = "INSERT INTO ". $this->db_table .
                   " SET
                        nm_requisitante = :nome_requisitante";
        
            $stmt = $this->conn->prepare($sql);
        
            // vincular dados
            $stmt->bindParam(":nome_requisitante", $this->nome_requisitante);
        
            // tentar inserir
            if($stmt->execute()){
                echo "Registro inserido com sucesso!";
                return true;
            }

            // tratar falha
            echo "Não foi possível inserir o registro.";
            print_r($stmt->errorInfo());
            return false;
        }

        // READ ALL (buscar todos os registros)
        public function buscarRequisitantes(){
            $sql = "SELECT cd_requisitante AS id, 
                           nm_requisitante AS nome_requisitante
                    FROM " . $this->db_table;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        }

        // READ (buscar registro específico)
        public function buscarRequisitante(){
            $sql = "SELECT cd_requisitante, 
                           nm_requisitante
                      FROM ". $this->db_table . "
                    WHERE  cd_requisitante = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            // retornar única row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $row['cd_requisitante'];
            $this->nome_requisitante = $row['nm_requisitante'];

            return $row;
        }   

        // UPDATE (Atualizar registro)
        public function atualizarRequisitante(){
            $sql = "UPDATE ". $this->db_table ."
                    SET
                        nm_requisitante = :nome_requisitante
                    WHERE 
                        cd_requisitante = :id";
        
            $stmt = $this->conn->prepare($sql);
        
            // vincular dados
            $stmt->bindParam(":nome_requisitante", $this->nome_requisitante);
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
        function excluirRequisitante(){
            $sql = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
        
            $stmt->bindParam(1, $this->id);
        
            // tentar excluir
            if($stmt->execute()){
                return true;
            }
            echo "Não foi possível excluir o registro.";
            return false;
        }

    }
?>