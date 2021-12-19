<?php
    // Especificando o formato JSON para as APIs.
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // includes necessários
    include_once '../../config/conexao.php';
    include_once '../../classe/requisicao.php';

    // Instanciar conexão
    $database = new Conexao();
    $db = $database->conectar();

    // Criar objeto
    $itens = new requisicao($db);

    // Buscar método relacionado na classe
    $stmt = $itens->buscarRequisicoes();
    
    // Contar itens
    $i = $stmt->rowCount();

    // Tratar retorno
    if($i > 0){
        
        $requisicaoArr = array();
        $requisicaoArr["dados"] = array();
        $requisicaoArr["cardinalidade"] = $i;

        // Loop para buscar todos os registros
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "requisitante" => $requisitante,
                "sistema" => $sistema,
                "data_requisicao" => $data_requisicao,
                "status" => $status
            );

            array_push($requisicaoArr["dados"], $e);
        }
        // exportar em JSON
        echo json_encode($requisicaoArr);
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