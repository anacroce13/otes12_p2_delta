<?php
    class Requisicao{

        // Atributos de conexão
        private $conn;
        private $db_table = "requisicao";

        // Atributos da entidade (são as colunas da tabela vinculada à essa classe/entidade)
        public $id;
        public $requisitante;
        public $sistema;
        public $data_requisicao;
        public $status;

        // Instanciar conexão
        public function __construct($db){
            $this->conn = $db;
        }

        /** 
            Abaixo, métodos das operações de CRUD desta classe
            */

        // CREATE (criar registro)
        public function criarRequisicao(){
            $sql = "INSERT INTO ". $this->db_table .
                   "SET
                        cd_requisitante = :requisitante,
                        cd_sistema = :sistema,
                        dt_requisicao = :data_requisicao,
                        status = :status";
        
            $stmt = $this->conn->prepare($sql);
        
            // vincular dados
            $stmt->bindParam(":requisitante", $this->requisitante);
            $stmt->bindParam(":sistema", $this->sistema);
            $stmt->bindParam(":data_requisicao", $this->data_requisicao);
            $stmt->bindParam(":status", $this->status);
        
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
        public function buscarRequisicoes(){
            $sql = "SELECT r.cd_requisicao AS id, 
                           rt.nm_requisitante AS nome_requisitante,
                           s.nm_sistema AS nome_sistema,
                           r.dt_requisicao AS data,
                           r.status AS status
                    FROM requisicao r, requisitante rt, sistema s
                    WHERE r.cd_requisitante = rt.cd_requisitante
                    AND r.cd_sistema = s.cd_sistema";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        }

        // READ (buscar registro específico)
        public function buscarRequisicao(){
            $sql = "SELECT r.cd_requisicao AS id, 
                           rt.nm_requisitante AS nome_requisitante,
                           s.nm_sistema AS nome_sistema,
                           r.dt_requisicao AS data,
                           r.status AS status
                    FROM requisicao r, requisitante rt, sistema s
                    WHERE r.cd_requisitante = rt.cd_requisitante
                    AND r.cd_sistema = s.cd_sistema
                    AND r.cd_requisicao = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            // retornar única row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $row['cd_requisicao'];
            $this->nome_requisitante = $row['nm_requisitante'];
            $this->nome_sistema = $row['nm_sistema'];
            $this->data = $row['dt_requisicao'];
            $this->status = $row['status'];

            return $row;
        }   

        // UPDATE (Atualizar registro)
        public function atualizarRequisicao(){
            $sql = "UPDATE ". $this->db_table ."
                    SET
                        cd_requisitante = :requisitante,
                        cd_sistema = :sistema,
                        dt_requisicao = :data_requisicao,
                        status = :status
                    WHERE 
                        cd_requisicao = :id";
        
            $stmt = $this->conn->prepare($sql);
        
            // vincular dados
            $stmt->bindParam(":nome_requisicao", $this->nome_requisicao);
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
        function excluirRequisicao(){
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