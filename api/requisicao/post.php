<?php
    // Especificando o formato JSON para as APIs e seus parâmetros de requisição.
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // includes necessários
    include_once '../../config/conexao.php';
    include_once '../../classe/requisicao.php';

    // Instanciar conexão
    $database = new Conexao();
    $db = $database->conectar();

    // Criar objeto
    $item = new Requisicao($db);

    // Buscar dados para criar registro
    $input = json_decode(file_get_contents("php://input"));

    $item->requisitante = $input->requisitante;
    $item->sistema = $input->sistema;
    $item->data_requisicao = date($input->data_requisicao);
    $item->status = $input->status;
    
    if($item->criarRequisicao()){
        echo 'Requisição criada com sucesso!';
    } else{
        echo 'Não foi possível criar a requisição. Erro na entrada de dados.';
    }
?>