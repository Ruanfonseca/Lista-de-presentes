<?php

// Verificar se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar se todos os campos foram enviados
    if (isset($_POST["nome"]) && isset($_POST["telefone"]) && isset($_POST["presente"])) {
        // Obter os valores enviados
        $nome = $_POST["nome"];
        $telefone = $_POST["telefone"];
        $presente = $_POST["presente"];

        $servername = "127.0.0.1";
        $username = "root";
        $password = "ruan123";
        $dbname = "casamentodb";
        // Criar uma conexão
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar se há erros de conexão
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        // Preparar a consulta SQL para inserir os dados na tabela Escolhidos
        $sql = "INSERT INTO escolhidos (nome, telefone, presente) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param("sss", $nome, $telefone, $presente);

        // Executar a consulta SQL
        if ($stmt->execute()) {
            // Sucesso na inserção
            $response = array("success" => true);

            // Chamar a função para excluir o presente da tabela Disponiveis
            Deletar($presente, $conn);

            $stmt->close();
            $conn->close();

            header("Content-Type: application/json");
            echo json_encode($response);
        } else {
            // Erro na inserção
            $response = array("success" => false);
            header("Content-Type: application/json");
            echo json_encode($response);
        }
    } else {
        // Campos faltando
        $response = array("success" => false);
        header("Content-Type: application/json");
        echo json_encode($response);
    }
    exit;
}

// Função para excluir o presente da tabela Disponiveis
function Deletar($presente, $conn) {
    $deleteSql = "DELETE FROM Disponiveis WHERE presentedisponivel = ?";
    $deleteStmt = $conn->prepare($deleteSql);

    if (!$deleteStmt) {
        die("Erro na preparação da consulta de exclusão: " . $conn->error);
    }

    $deleteStmt->bind_param("s", $presente);
    $deleteStmt->execute();

    // Verificar se a exclusão foi bem-sucedida
    if ($deleteStmt->affected_rows > 0) {
        echo "Presente excluído com sucesso da tabela Disponiveis.";
    } else {
        echo "Não foi possível excluir o presente da tabela Disponiveis.";
    }

    $deleteStmt->close();
}
?>
