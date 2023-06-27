<?php
require_once 'vendor/autoload.php';
//https://subzero-abuse.000webhostapp.com

// Configurando o acesso ao banco de dados
$servername = "127.0.0.1";
$username = "root";
$password = "ruan123";
$dbname = "casamentodb";

// Função para retornar os presentes disponíveis
function getPresentesDisponiveis() {
    // Criar uma conexão
    $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);

    // Verificar se há erros de conexão
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Consulta SQL para obter os presentes disponíveis
    $sql = "SELECT * FROM Disponiveis";
    $result = $conn->query($sql);

    // Verificar se foram encontrados resultados
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        // Fechar a conexão
        $conn->close();
        return $data;
    } else {
        // Fechar a conexão
        $conn->close();
        return null;
    }
}



// Função para retornar os presentes escolhidos
function getPresentesEscolhidos() {
    // Criar uma conexão
    $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);

    // Verificar se há erros de conexão
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Consulta SQL para obter os presentes escolhidos
    $sql = "SELECT * FROM escolhidos";
    $result = $conn->query($sql);

    // Verificar se foram encontrados resultados
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        // Fechar a conexão
        $conn->close();
        return $data;
    } else {
        // Fechar a conexão
        $conn->close();
        return null;
    }
}
$presentesDisponiveis = getPresentesDisponiveis();
$presentesEscolhidos = getPresentesEscolhidos();



?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/bebe.png">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Lista de Presentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>

    <h1 class="titulo">Lista de Presentes</h1>
    <br/>

    <div class="imagemCENTRAL">
      <img class="imgLOGO" src="images/foto_cha.jpg" />
    </div>

    <br/>
    <br/>
    <h2 class="titulo">Disponíveis</h2>

    <div class="table-wrapper-scroll-y my-custom-scrollbar">
      <table class="table tabela tableINTERNA table-bordered table-striped mb-0">
        <thead>
          <tr>
            <th scope="col">Ordem</th>
            <th scope="col">Nome do Presente</th>
            <th scope="col">Ação</th>
          </tr>
        </thead>
        <tbody id="tabela-disponiveis">
          <?php
          //se for diferente de vazio, exponha na tela
          if (!empty($presentesDisponiveis)) {
            foreach ($presentesDisponiveis as $presente) {
              echo "<tr>";
              echo "<th scope='row'>" . $presente['codigo'] . "</th>";
              echo "<td>" . $presente['presentedisponivel'] . "</td>";
              echo "<td><button type='button' class='btn btn-primary escolha' data-nome='" . $presente['presentedisponivel'] . "'>Escolher</button></td>";
              echo "</tr>";
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  
    <!-- Modal de escolha -->
    <div class="modal fade" id="modal-mensagem" tabindex="-1" role="dialog" aria-labelledby="modal-mensagem-label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="modal-mensagem-label">Escolha de Presente</h4>
          </div>
          <div class="modal-body">
            <form id="form-escolha">
              <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" placeholder="Digite o nome">
              </div>
              <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="tel" class="form-control" id="telefone" placeholder="Digite o telefone">
              </div>
              <br/>
              <div class="msg" id="msg"></div>
              <button type="submit" class="btn btn-success">Finalizar</button>
            </form>
          </div>
        </div>
      </div>
    </div>


    <br/>
    <br/>
    <br/>
    <br/>
    <h2 class="titulo">Escolhidos</h2>

    <div class="table-wrapper-scroll-y my-custom-scrollbar">
      <table class="table tabela tableINTERNA table-bordered table-striped mb-0">
        <thead>
          <tr>
            <th scope="col">Ordem</th>
            <th scope="col">Nome do Presente</th>
            <th scope="col">Quem escolheu?</th>
          </tr>
        </thead>
        <tbody id="tabela-escolhidos">
          <?php
          //se for diferente de vazio, exponha na tela
          if (!empty($presentesEscolhidos)) {
            foreach ($presentesEscolhidos as $presente) {
              echo "<tr>";
              echo "<th scope='row'>" . $presente['codigo'] . "</th>";
              echo "<td>" . $presente['presente'] . "</td>";
              echo "<td>" . $presente['nome'] . "</td>";
              echo "</tr>";
            }
          }
          ?>
        </tbody>
      </table>
    </div>
    <br/>
    <br/>
    <br/>
    <br/>

    <div class="BotaoContainer">
    <div class="BotaoImprimir">
    <button type="button" class="btn btn-success" onclick="imprimirPDF()">Imprimir</button>
  </div>
  <div class="BotaoAtualizar">
  <button type="button" class="btn btn-success" onclick="Atualizar()">Atualizar</button>
</div>

      </div>


    <footer class="bg-light text-center text-lg-start">
      <div class="text-center p-3" style=" background-color: rgba(220,220,220);">
        <a href = "https://github.com/Ruanfonseca" style="color:#000;">© 2023 RuanFonseca Desenvolvedor</a>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <script>

function imprimirPDF() {
    // Fazer uma requisição AJAX para o arquivo PHP que gera o PDF
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // PDF gerado com sucesso
            var pdfUrl = 'http://localhost:8085/gerarPDF.php';
            // Abrir o PDF em uma nova aba
            window.open(pdfUrl, '_blank');
        }
    };
    xhttp.open("GET", "gerarPDF.php", true);
    xhttp.send();
}

function Atualizar() {
  location.reload();
}



function finalizarEscolha() {
  var nome = $("#nome").val();
  var telefone = $("#telefone").val();
  var presente = $("#modal-mensagem").data("presente");
 
  // Enviar os dados para o servidor via AJAX
  $.ajax({
    url: "registraESCO.php",
    type: "POST",
    data: { nome: nome, telefone: telefone, presente: presente },
    dataType: "json",
    success: function (response) {
      if (response.success) {
        // Atualizar a tabela de escolhidos
        var tabelaEscolhidos = $("#tabela-escolhidos");
        tabelaEscolhidos.empty();

        $.each(response.escolhidos, function (index, escolhido) {
          tabelaEscolhidos.append("<tr>" +
            "<th scope='row'>" + escolhido.codigo + "</th>" +
            "<td>" + escolhido.presentedisponivel + "</td>" +
            "<td>" + escolhido.nome + "</td>" +
            "</tr>");
        });
        // Exibir mensagem de sucesso
        $("#msg").removeClass("alert alert-danger").addClass("alert alert-success").text("Escolha de presente finalizada com sucesso.");

        // Fechar o modal após 3 segundos
        setTimeout(function () {
          $("#modal-mensagem").modal("hide");
        },1000000);
      } else {
        alert("Erro ao finalizar a escolha de presente. Por favor, tente novamente.");
      }
    },
    error: function () {
      $("#msg").removeClass("alert alert-danger").addClass("alert alert-success").text("Escolha de presente finalizada com sucesso.");
      setTimeout(function () {
          $("#modal-mensagem").modal("hide");
        },1000000);
    }
  });
}


      // Ação do botão "Escolher"
      $(document).on("click", ".escolha", function () {
        var nomePresente = $(this).data("nome");
        $("#modal-mensagem").data("presente", nomePresente);
        $("#modal-mensagem").modal("show");
      });

      // Ação do botão "Finalizar"
      $(document).on("submit", "#form-escolha", function (e) {
        e.preventDefault();
        finalizarEscolha();
      });
    </script>
  </body>
</html>
