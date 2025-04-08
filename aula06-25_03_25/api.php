<?php 

    // Cabeçalho
    header("Content-Type: application/json"); // define o tipo de resposta
    $metodo = $_SERVER['REQUEST_METHOD'];

    // Conteúdo
    $usuarios = [
        ["id" => 1, "nome" => "Maria Souza", "email" => "maria@email.com"],
        ["id" => 2, "nome" => "Joao Silva", "email" => "joao@email.com"]
    ];
    
    switch ($metodo) {
        case 'GET':
            // echo "AQUI AÇÕES DO MÉTODO GET";
            // Converte para JSON e retorna
            echo json_encode($usuarios);
            break;
        case 'POST':
            // echo "AQUI AÇÕES DO MÉTODO POST";
            $dados = json_decode(file_get_contents('php://input'), true);
            // print_r($dados);
            $novoUsuario = [
                "id" => $dados["id"],
                "nome" => $dados["nome"],
                "email" => $dados["email"]
            ];

            // Adiciona o novo usuário ao array existente
            array_push($usuarios, $novoUsuario);
            echo json_encode('Usuario inserido com sucesso!');
            print_r($usuarios);

            break;
        default:
            echo "MÉTODO NÃO ENCONTRADO";
            break;
    };

?>