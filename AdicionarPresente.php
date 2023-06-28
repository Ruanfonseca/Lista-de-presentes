<?php
// Verificar se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar se todos os campos foram enviados
    if (isset($_POST["nomePresente"]) && isset($_POST["senhaAdicionar"])) {
        // Obter os valores enviados
        $nomePresente = $_POST["nomePresente"];
        $senhaAdicionar = $_POST["senhaAdicionar"];

        $servername = "127.0.0.1";
        $username = "root";
        $password = "ruan123";
        $dbname = "casamentodb";

        if ($senhaAdicionar == "12345") {
            // Criar uma conexão
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar se há erros de conexão
            if ($conn->connect_error) {
                die("Erro de conexão: " . $conn->connect_error);
            }

            // Chamar a função para adicionar o presente na tabela Disponiveis
            Adicionar($nomePresente, $conn);

            $conn->close();

            // Responder com sucesso
            $response = array("success" => true);
            header("Content-Type: application/json");
            echo json_encode($response);
            exit;
        } else {
            // Responder com falha
            $response = array("success" => false);
            header("Content-Type: application/json");
            echo json_encode($response);
        }
    }
}

function Adicionar($nomePresente, $conn) {
    $adicionarSql = "INSERT INTO Disponiveis (presentedisponivel) VALUES (?)";
    $adicionarStmt = $conn->prepare($adicionarSql);

    if (!$adicionarStmt) {
        die("Erro na preparação da consulta de inclusão: " . $conn->error);
    }

    $adicionarStmt->bind_param("s", $nomePresente);
    $adicionarStmt->execute();

    // Verificar se a inserção foi bem-sucedida
    if ($adicionarStmt->affected_rows > 0) {
        echo "Presente adicionado com sucesso na tabela Disponiveis.";
    } else {
        echo "Não foi possível adicionar o presente na tabela Disponiveis.";
    }

    $adicionarStmt->close();
}
?>
