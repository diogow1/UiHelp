<?php
header('Content-Type: application/json');


include 'config/conexao.php';

// Consultar dados das instituições com latitude e longitude
$sql = "SELECT id_instituicao, nome, uf, cidade, bairro, logradouro, numero, cep, complemento, telefone, email, descricao, tipo_servico, imagem, instagram, whatsapp, latitude, longitude FROM instituicoes WHERE latitude IS NOT NULL AND longitude IS NOT NULL";
$result = $conn->query($sql);

$instituicoes = array();

// Verificar se há registros
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_instituicao = $row['id_instituicao'];

        //Consulta dos tipos de coleta
        $sql_coletas = "SELECT tc.* FROM tipos_coleta tc JOIN instituicao_tipos_coleta itc ON tc.id_tipo_coleta = itc.id_tipo_coleta WHERE itc.id_instituicao = $id_instituicao";
        $result_coletas = $conn->query($sql_coletas);

        $tipos_coleta = array();
        if ($result_coletas && $result_coletas->num_rows > 0) {
            while ($coleta = $result_coletas->fetch_assoc()) {
                $tipos_coleta[] = $coleta; 
            }
        } 

        // Consulta dos horários de funcionamento
        $sql_horarios = "SELECT dia_inicio, dia_fim, abertura, fechamento FROM horarios_funcionamento WHERE id_instituicao = $id_instituicao";
        $result_horarios = $conn->query($sql_horarios);

        $horarios = array();
        if ($result_horarios && $result_horarios->num_rows > 0) {
            while ($horario = $result_horarios->fetch_assoc()) {
                $horarios[] = $horario;
            }
        }

        // Adiciona os tipos de coleta e horários ao resultado
        $row['tipos_coleta'] = $tipos_coleta;
        $row['horarios_funcionamento'] = $horarios;

        // Adiciona a instituição (com tipos de coleta)
        $instituicoes[] = $row;
    }

    
}

// Retornar os dados em formato JSON
echo json_encode($instituicoes);

$conn->close();
?>
