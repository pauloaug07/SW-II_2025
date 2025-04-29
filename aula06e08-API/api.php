<?php
header("Content-Type: application/json; charset=UTF-8");

$metodo = $_SERVER['REQUEST_METHOD'];

// recupera o arquivo json
$arquivo = "usuarios.json";

// verifica se o arquivo existe
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([], JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE));
}

$usuarios = json_decode(file_get_contents($arquivo), true);

switch ($metodo) {
    case 'GET':
        // verifica se há um parametro "id" na URL
        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);
            $usuario_encontrado = null;

            // procura o usuario pelo ID
            foreach ($usuarios as $usuario) {
                if ($usuario['id'] == $id) {
                    $usuario_encontrado = $usuario;
                    break;
                }
            }

            if ($usuario_encontrado) {
                echo json_encode($usuario_encontrado, JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(404);
                echo json_encode(["erro" => "Usuário não encontrado"], JSON_UNESCAPED_UNICODE);
            }
        } else {
            // retorna todos os usuarios
            echo json_encode($usuarios, JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
        }

        break;

    case 'POST':
        $dados = json_decode(file_get_contents('php://input'), true);

        // verifica os campos obrigatorios (sem exigir ID)
        if (!isset($dados["nome"]) || !isset($dados["email"])) {
            http_response_code(400);
            echo json_encode(["erro" => "Nome e e-mail são obrigatorios."], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // gera um novo ID unico
        $novo_id = 1;
        if (!empty($usuarios)) {
            $ids = array_column($usuarios, "id");
            $novo_id = max($ids) + 1;
        }

        $novoUsuario = [
            "id" => $novo_id,
            "nome" => $dados["nome"],
            "email" => $dados["email"]
        ];

        // adiciona o novo usuario
        $usuarios[] = $novoUsuario;

        // salvando o arquivo
        file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE));
        echo json_encode(
            [
                "mensagem" => "Usuário inserido com sucesso! ",
                "usuarios" => $usuarios
            ],
            JSON_UNESCAPED_UNICODE
        );
        break;

    default:
        http_response_code(405);
        echo json_encode(["erro" => "Método não permitido."], JSON_UNESCAPED_UNICODE);
        break;
}
?>