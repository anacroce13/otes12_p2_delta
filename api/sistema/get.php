<?php
    // Especificando o formato JSON para as APIs.
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // includes necessários
    include_once '../../config/conexao.php';
    include_once '../../classe/sistema.php';

    // Instanciar conexão
    $database = new Conexao();
    $db = $database->conectar();

    // Criar objeto
    $itens = new sistema($db);

    // Buscar método relacionado na classe
    $stmt = $itens->buscarsistemas();
    
    // Contar itens
    $i = $stmt->rowCount();

    // creio que a linha abaixo é desnecessária
    // echo json_encode($i);

    // Tratar retorno
    if($i > 0){
        
        $sistemaArr = array();
        $sistemaArr["dados"] = array();
        $sistemaArr["cardinalidade"] = $i;

        // Loop para buscar todos os registros
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "nome_sistema" => $nome_sistema
            );

            array_push($sistemaArr["dados"], $e);
        }
        // exportar em JSON
        echo json_encode($sistemaArr);
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