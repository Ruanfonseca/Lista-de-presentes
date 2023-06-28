
function imprimirPDF() {
    // Fazer uma requisição AJAX para o arquivo PHP que gera o PDF
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // PDF gerado com sucesso
            var pdfUrl = 'http://localhost:8087/gerarPDF.php';
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




/* Ação para deletar */
$(document).on("click", ".apagar", function () {
    var nomePresente = $(this).data("nome");
    $("#modal-apagar").data("presente", nomePresente);
    $("#modal-apagar").modal("show");
  });
  
  // Ação do botão "Finalizar"
  $(document).on("submit", "#form-apagar", function (e) {
    e.preventDefault();
    ApagarPresente();
  });
  
  function ApagarPresente() {
    var senha = $("#senha").val();
    var presente = $("#modal-apagar").data("presente");
  
    // Enviar os dados para o servidor via AJAX
    $.ajax({
      url: "ApagarPresente.php",
      type: "POST",
      data: {senha: senha, presente: presente },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          $("#msg-apagar").removeClass("alert alert-danger").addClass("alert alert-success").text("O Presente foi apagado com sucesso.");
          // Fechar o modal após 3 segundos
          setTimeout(function () {
            $("#modal-apagar").modal("hide");
          }, 3000);
        } else {
          $("#msg-apagar").removeClass("alert alert-danger").addClass("alert alert-success").text("Não foi possível apagar");
          setTimeout(function () {
            $("#modal-apagar").modal("hide");
          }, 3000);
        }
      },
      error: function () {
        $("#msg-apagar").removeClass("alert alert-danger").addClass("alert alert-success").text("O Presente foi apagado com sucesso.");
        setTimeout(function () {
          $("#modal-apagar").modal("hide");
        }, 3000);
      }
    });
}
// Função para adicionar o evento de clique ao botão
function AdicionarPresente() {
  // Exibe o modal
  $('#modal-adicionar').modal('show');
}

// Evento de submissão do formulário
$('#form-adicionar').submit(function(event) {
  event.preventDefault(); // Previne o comportamento padrão de submissão do formulário

  // Obter o valor do campo de entrada
  var nomePresente = $('#nomepresente').val();
  var senhaAdicionar = $('#senhaAdicionar').val();

  $.ajax({
    url: "AdicionarPresente.php",
    type: "POST",
    data: { nomePresente: nomePresente, senhaAdicionar: senhaAdicionar },
    dataType: "json",
    success: function(response) {
      if (response.success) {
        
        $("#msg-nomepresente").removeClass("alert alert-danger").addClass("alert alert-success").text("O Presente foi adicionado com sucesso.");
       

        // Fechar o modal após 3 segundos
        setTimeout(function() {
          $("#modal-adicionar").modal("hide");
        }, 60000);

      } else {
        $("#msg-nomepresente").removeClass("alert alert-success").addClass("alert alert-danger").text("Não foi possível adicionar o presente.");
        // Fechar o modal após 3 segundos
        setTimeout(function() {
          $("#modal-adicionar").modal("hide");
        }, 60000);
       }
    },
    error: function() {
      $("#msg-nomepresente").removeClass("alert alert-danger").addClass("alert alert-success").text("O Presente foi adicionado com sucesso.");
      // Fechar o modal após 3 segundos
      setTimeout(function() {
        $("#modal-adicionar").modal("hide");
      }, 60000);
    
    }
  });

  // Fechar o modal após a conclusão do processamento $('#modal-adicionar').modal('hide');
  
});
