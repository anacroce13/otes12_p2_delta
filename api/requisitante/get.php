<?php
    // Especificando o formato JSON para as APIs.
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // includes necessários
    include_once '../../config/conexao.php';
    include_once '../../classe/requisitante.php';

    // Instanciar conexão
    $database = new Conexao();
    $db = $database->conectar();

    // Criar objeto
    $itens = new Requisitante($db);

    // Buscar método relacionado na classe
    $stmt = $itens->buscarRequisitantes();
    
    // Contar itens
    $i = $stmt->rowCount();

    // Tratar retorno
    if($i > 0){
        
        $requisitanteArr = array();
        $requisitanteArr["dados"] = array();
        $requisitanteArr["cardinalidade"] = $i;

        // Loop para buscar todos os registros
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "nome_requisitante" => $nome_requisitante
            );

            array_push($requisitanteArr["dados"], $e);
        }
        // exportar em JSON
        echo json_encode($requisitanteArr);
    }

    else{
        // Retornar erro 404 NOT FOUND
        http_response_code(404);

        // Mensagem em JSON do erro
        echo json_encode(
            array("retorno" => "Nenhum registro encontrado.")
        );
    }
?>