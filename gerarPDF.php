<?php
require_once 'vendor/autoload.php';


use Dompdf\Dompdf;

function gerarPDF()
{
    function getPresentesEscolhidos()
    {
        $servername = "localhost";
        $username = "root";
        $password = "ruan123";
        $dbname = "casamentodb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }

        $sql = "SELECT codigo, presente, nome, telefone FROM escolhidos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $presentesEscolhidos = array();

            while ($row = $result->fetch_assoc()) {
                $presente = array(
                    'Ordem' => $row['codigo'],
                    'Nome do Presente' => $row['presente'],
                    'Quem escolheu?' => $row['nome'],
                    'Telefone' => $row['telefone']
                );
                $presentesEscolhidos[] = $presente;
            }

            return $presentesEscolhidos;
        } else {
            return array();
        }

        $conn->close();
    }

    $presentesEscolhidos = getPresentesEscolhidos();

    if (!empty($presentesEscolhidos)) {
        $pdf = new Dompdf();
        
        $html = '
        <!DOCTYPE>
        <html>"
         <body>
         <h1>Lista de Presentes Escolhidos</h1>
         </body>
        ';

        $data = array();
        foreach ($presentesEscolhidos as $presente) {
            $data[] = array(
                'Ordem' => $presente['Ordem'],
                'Nome do Presente' => $presente['Nome do Presente'],
                'Quem escolheu?' => $presente['Quem escolheu?'],
                'Telefone' => $presente['Telefone']
            );
        }

        $html .= '<table>';
        $html .= '<tr>';
        $html .= '<th>Ordem</th>';
        $html .= '<th>Nome do Presente</th>';
        $html .= '<th>Quem escolheu?</th>';
        $html .= '<th>Telefone</th>';
        $html .= '</tr>';
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $value) {
                $html .= '<td>' . $value . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';

        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        // Definir o nome do arquivo PDF gerado
        $pdfFileName = 'presentes_escolhidos.pdf';

        // Salvar o arquivo PDF no servidor
        $pdf->stream($pdfFileName, array('Attachment' => false));

        // Retornar o URL do PDF gerado para o JavaScript
        echo $pdfFileName;
        exit;
    }
}

// Chamar a função para gerar o PDF
gerarPDF();
?>
