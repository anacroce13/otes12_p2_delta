<?php
    // Especificando o formato JSON para as APIs e seus parâmetros de requisição.
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // includes necessários
    include_once '../../config/conexao.php';
    include_once '../../classe/requisitante.php';

    // Instanciar conexão
    $database = new Conexao();
    $db = $database->conectar();

    // Criar objeto
    $item = new Requisitante($db);

    // Verificar se o parâmetro está sendo passado
    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    // Buscar método relacionado na classe
    $item->buscarRequisitante();

    if($item->id != null){
        // montar array de retorno
        $requisitanteArr = array(
            "id" =>  $item->id,
            "nome_requisitante" => $item->nome_requisitante
        );
      
        // Retorno bem sucedido
        http_response_code(200);
        echo json_encode($requisitanteArr);
    }
      
    else{
        // Retornar erro 404 NOT FOUND
        http_response_code(404);

        // Mensagem em JSON do erro
        echo json_encode(
            array("retorno" => "Registro não encontrado.")
        );
    }
?>