<?php
    // Especificando o formato JSON para as APIs e seus parâmetros de requisição.
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // includes necessários
    include_once '../../config/conexao.php';
    include_once '../../classe/sistema.php';

    // Instanciar conexão
    $database = new Conexao();
    $db = $database->conectar();

    // Criar objeto
    $item = new Sistema($db);

    // Buscar dados para criar registro
    $input = json_decode(file_get_contents("php://input"));

    $item->id = $input->id;
    
    if($item->excluirSistema()){
        echo 'Sistema excluído com sucesso. (Ops, tomara que você tenha desejado fazer isto mesmo!)';
    } else{
        echo 'Não foi possível excluir o registro do sistema. Identificador inválido.';
    }
?>