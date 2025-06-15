<?php
header('Content-Type: text/html');
include 'config/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cnpj = $_POST['cnpj'];
    $nome = $_POST['nome'];
    $uf = $_POST['uf'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $cep = $_POST['cep'];
    $complemento = $_POST['complemento'];
    $tipo_servico = $_POST['tipo_servico'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $coletas = $_POST['coletas'];
    $descricao = $_POST['descricao'];
    $horariosEDias = $_POST['horarios'];
    $instagram = $_POST['instagram'] ?? null;
    $whatsapp = $_POST['whatsapp'] ?? null;



    // Verifica se o CNPJ já está aprovado
    $sql_verifica = "SELECT * FROM instituicoes WHERE cnpj = ? AND status = 'aprovado'";
    $stmt_verifica = $conn->prepare($sql_verifica);
    $stmt_verifica->bind_param("s", $cnpj);
    $stmt_verifica->execute();
    $resultado = $stmt_verifica->get_result();

    if ($resultado->num_rows > 0) {
        echo "<script>
            alert('Instituição já cadastrada');
            window.location.href = '../../cadastro';
        </script>";
        exit;
    }
    $stmt_verifica->close();

    // Configurações para upload da imagem
    $tamanho_maximo = 50 * 1024 * 1024; // 50MB
    $tipos_permitidos = ['image/png', 'image/jpeg'];

    if (!isset($_FILES['imagem']) || $_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>
            alert('Erro no upload da imagem. Tente novamente.');
            window.location.href = '../../cadastro';
        </script>";
        exit;
    }

    // Coletando os dados da imagem
    $imagem = $_FILES['imagem']['name'];
    $imagem_temp = $_FILES['imagem']['tmp_name'];
    $imagem_tamanho = $_FILES['imagem']['size'];
    $diretorio = "../storage/uploads/";

    // Verifica tipo MIME
    $mime_tipo = mime_content_type($imagem_temp);
    if (!in_array($mime_tipo, $tipos_permitidos)) {
        echo "<script>
            alert('Formato de imagem inválido. Apenas PNG e JPEG são permitidos.');
            window.location.href = '../../cadastro';
        </script>";
        exit;
    }

    // Verifica tamanho
    if ($imagem_tamanho > $tamanho_maximo) {
        echo "<script>
            alert('O arquivo é muito grande. Tamanho máximo permitido: 50MB.');
            window.location.href = '../../cadastro';
        </script>";
        exit;
    }

    // Gera nome único para evitar sobrescrita
    $extensao = pathinfo($imagem, PATHINFO_EXTENSION);
    $nome_unico = uniqid('img_') . '.' . $extensao;
    $caminho_imagem = $diretorio . $nome_unico;

    // Move arquivo para o diretório
    if (!move_uploaded_file($imagem_temp, $caminho_imagem)) {
        echo "<script>
            alert('Erro ao fazer upload da imagem.');
            window.location.href = '../../cadastro';
        </script>";
        exit;
    }

    // Insere dados no banco
    $sqlInsert = "INSERT INTO instituicoes 
        (cnpj, nome, uf, cidade, bairro, logradouro, numero, cep, complemento, telefone, email, imagem, descricao, tipo_servico, instagram, whatsapp) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmtInsertInstituicao = $conn->prepare($sqlInsert);

    if (!$stmtInsertInstituicao) {
        echo "Erro no prepare: " . $conn->error;
    exit;
}

    if ($stmtInsertInstituicao) {
        $stmtInsertInstituicao->bind_param(
            "ssssssssssssssss", //Tipos de dados
            $cnpj, $nome, $uf, $cidade, $bairro, $logradouro, $numero, $cep, $complemento, 
            $telefone, $email, $caminho_imagem, $descricao, $tipo_servico, 
            $instagram, $whatsapp
        );




        if ($stmtInsertInstituicao->execute()) {
            $idInstituicao = $stmtInsertInstituicao->insert_id; // Pega o id da instituição gerado na query


            // Insere cada tipo de coleta
            foreach ($coletas as $coleta) {
                $stmtInsertColeta = $conn->prepare("INSERT INTO instituicao_tipos_coleta (id_instituicao, id_tipo_coleta) VALUES (?, ?)");
                $stmtInsertColeta->bind_param("ii", $idInstituicao, $coleta);
                $stmtInsertColeta->execute();
                $stmtInsertColeta->close();
            }

            
            // Insere os horarios + dias no banco
            if (!empty($horariosEDias) && is_array($horariosEDias)) {
                foreach ($horariosEDias as $horario) {
                    $diaInicio = $horario['dia_inicio'];
                    $diaFim = $horario['dia_fim'];
                    $abertura = $horario['abertura'];
                    $fechamento = $horario['fechamento'];


                    $stmtHorario = $conn->prepare("INSERT INTO horarios_funcionamento (id_instituicao, dia_inicio, dia_fim, abertura, fechamento) VALUES (?, ?, ?, ?, ?)");
                    $stmtHorario->bind_param("issss", $idInstituicao, $diaInicio, $diaFim, $abertura, $fechamento);
                    $stmtHorario->execute();
                    $stmtHorario->close();
                }
            }


            header("Location: ../../aviso?status=success&message=" . urlencode("Sua inscrição foi enviada!"));
            exit;

        } else {
            echo "<script>
                alert('Houve algum erro com seus dados, verifique eles e tente novamente.');
                window.location.href = '../../cadastro';
            </script>";
        }

        $stmtInsertInstituicao->close();
    } else {
        header("Location: ../../aviso?status=error&message=" . urlencode("Erro no Servidor"));
        exit;
    }
}

$conn->close();
?>