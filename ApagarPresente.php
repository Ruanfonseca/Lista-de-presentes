<?php

// Verificar se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar se todos os campos foram enviados
    if (isset($_POST["senha"]) && isset($_POST["presente"])) {
        // Obter os valores enviados
        $senha = $_POST["senha"];
        $presente = $_POST["presente"];


        $servername = "127.0.0.1";
        $username = "root";
        $password = "ruan123";
        $dbname = "casamentodb";

        if($senha == "12345") {
           
        // Criar uma conexão
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar se há erros de conexão
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }else{
            echo "Conexão ta ok";
        }

        // Chamar a função para excluir o presente da tabela Disponiveis
        Deletar($presente, $conn);

        $conn->close();

        // Responder com sucesso
        $response = array("success" => true);
        header("Content-Type: application/json");
        echo json_encode($response);
        exit;
       }else{
            // Responder com falso
            $response = array("success" => false);
            header("Content-Type: application/json");
            echo json_encode($response);
        }
  }
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
