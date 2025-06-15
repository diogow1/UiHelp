<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Instituições</title>

    <meta property="og:image" content="../assets/img/icons/favicon.png" />
    <link rel="icon" href="../assets/img/icons/favicon.png" type="image/png">
    
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/gestao.css">
    
</head>
<body class="body-admin">

    <form action="php/logout.php" id="logout" method="POST">
        <button type="submit" class="logout-button">Sair</button>
    </form>
    
    
    <h1 class="titulo-admin">Gerenciamento de Instituições</h1>

    <!-- Botões para alternar entre pendentes e aprovadas -->
    <div class="selecao-tabelas">
        <button onclick="mostrarTabela('pendentes')">Pendentes</button>
        <button onclick="mostrarTabela('aprovadas')">Aprovadas</button>
    </div>

    <!-- Tabela de Instituições Pendentes -->
    <div id="pendentes" class="tabela centralizado">
        <h2>Instituições Pendentes</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>CNPJ</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Dias e Horários</th>
                    <th>Instagram</th>
                    <th>Whatsapp</th>
                    <th>Categorias</th>
                    <th>Tipo de Serviço</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start();
                if (!isset($_SESSION['autenticado'])) {
                    header("Location: login");
                    exit;
                }

                include '../php/config/conexao.php';
                $sql_pendentes = "SELECT * FROM instituicoes WHERE status = 'pendente'";
                $result_pendentes = $conn->query($sql_pendentes);

                if ($result_pendentes->num_rows > 0) {
                    while ($row = $result_pendentes->fetch_assoc()) {
                        $id_instituicao = $row['id_instituicao'];

                        // Buscar horários da instituição (exibindo Abertura e Fechamento separados)
                        $sql_horarios = "SELECT dia_inicio, dia_fim, abertura, fechamento FROM horarios_funcionamento WHERE id_instituicao = $id_instituicao";
                        $result_horarios = $conn->query($sql_horarios);

                        // Buscar categorias/tipos de coleta
                        $sql_coletas = "SELECT tc.* FROM tipos_coleta tc JOIN instituicao_tipos_coleta itc ON tc.id_tipo_coleta = itc.id_tipo_coleta WHERE itc.id_instituicao = $id_instituicao";
                        $result_coletas = $conn->query($sql_coletas);

                        echo "<tr>";

                        echo "<td>" . htmlspecialchars($row['cnpj']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";

                        // Endereço agrupado com quebras de linha
                        echo "<td>";
                        echo htmlspecialchars($row['logradouro']) . ", " . htmlspecialchars($row['numero']) . "<br>";
                        echo htmlspecialchars($row['bairro']) . "<br>";
                        echo htmlspecialchars($row['cidade']) . " - " . htmlspecialchars($row['uf']) . "<br>";
                        echo "CEP: " . htmlspecialchars($row['cep']);
                        echo "</td>";

                        echo "<td>" . htmlspecialchars($row['telefone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";

                        echo "<td>";
                        if ($result_horarios && $result_horarios->num_rows > 0) {
                            while ($horario = $result_horarios->fetch_assoc()) {
                                $dia = ($horario['dia_inicio'] === $horario['dia_fim']) 
                                    ? $horario['dia_inicio'] 
                                    : $horario['dia_inicio'] . " à " . $horario['dia_fim'];
                                $abertura = date('H:i', strtotime($horario['abertura']));
                                $fechamento = date('H:i', strtotime($horario['fechamento']));
                                echo "<p>$dia: $abertura às $fechamento</p>";
                            }
                        } else {
                            echo "<p>Não informado</p>";
                        }
                        echo "</td>";

                        echo "<td><a href='" . htmlspecialchars($row['instagram']) . "' target='_blank'>" . htmlspecialchars($row['instagram']) . "</a></td>";
                        echo "<td><a href='https://wa.me/" . htmlspecialchars($row['whatsapp']) . "' target='_blank'>" . htmlspecialchars($row['whatsapp']) . "</a></td>";

                        //Tipos de coleta
                        echo "<td>";
                        if ($result_coletas && $result_coletas->num_rows > 0) {
                            while ($coleta = $result_coletas->fetch_assoc()) {
                                echo "<p title='" . htmlspecialchars($coleta['descricao']) . "'>" . htmlspecialchars($coleta['nome']) . "</p>";
                            }
                        } else {
                            echo "Não informado";
                        }
                        echo "</td>";

                        //Tipos de serviço
                        echo "<td>";
                        switch ($row['tipo_servico']) {
                            case 'coleta':
                                echo "Coleta";
                                break;
                            case 'distribuicao':
                                echo "Distribuição";
                                break;
                            case 'distribuicao':
                                echo "Distribuição e Coleta";
                                break;
                            default:
                                echo "Não informado";
                        }
                        echo "</td>";

                        echo "<td><img src='" . htmlspecialchars($row['imagem']) . "' width='100' alt='Imagem da instituição'></td>";

                        echo "<td>";
                        echo "<button class='aprovar-instituicao' onclick='abrirModal(" . $row['id_instituicao'] . ")'>Aprovar</button>";
                        echo "<a href='php/ADM/excluir_instituicao_pendente.php?id=" . htmlspecialchars($row['id_instituicao']) . "' onclick=\"return confirm('Tem certeza que deseja reprovar esta instituição?');\">";
                        echo "<button class='reprovar-instituicao' type='button'>Reprovar</button>";
                        echo "</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>Nenhuma instituição pendente encontrada</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Tabela de Instituições Aprovadas -->
    <div id="aprovadas" class="tabela centralizado" style="display: none;">
        <h2>Instituições Aprovadas</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>CNPJ</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Dias e Horários</th>
                    <th>Instagram</th>
                    <th>Whatsapp</th>
                    <th>Categorias</th>
                    <th>Tipo de Serviço</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql_aprovadas = "SELECT * FROM instituicoes WHERE status = 'aprovado'";
                $result_aprovadas = $conn->query($sql_aprovadas);
                if ($result_aprovadas->num_rows > 0) {
                    while ($row = $result_aprovadas->fetch_assoc()) {
                        $id_instituicao = $row['id_instituicao'];

                        // Buscar horários da instituição (exibindo Abertura e Fechamento separados)
                        $sql_horarios = "SELECT dia_inicio, dia_fim, abertura, fechamento FROM horarios_funcionamento WHERE id_instituicao = $id_instituicao";
                        $result_horarios = $conn->query($sql_horarios);

                        // Buscar categorias/tipos de coleta
                        $sql_coletas = "SELECT tc.* FROM tipos_coleta tc JOIN instituicao_tipos_coleta itc ON tc.id_tipo_coleta = itc.id_tipo_coleta WHERE itc.id_instituicao = $id_instituicao";
                        $result_coletas = $conn->query($sql_coletas);

                        echo "<tr>";

                        echo "<td>" . htmlspecialchars($row['cnpj']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";

                        // Endereço agrupado com quebras de linha
                        echo "<td>";
                        echo htmlspecialchars($row['logradouro']) . ", " . htmlspecialchars($row['numero']) . "<br>";
                        echo htmlspecialchars($row['bairro']) . "<br>";
                        echo htmlspecialchars($row['cidade']) . " - " . htmlspecialchars($row['uf']) . "<br>";
                        echo "CEP: " . htmlspecialchars($row['cep']);
                        echo "</td>";

                        echo "<td>" . htmlspecialchars($row['telefone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";

                        echo "<td>";
                        if ($result_horarios && $result_horarios->num_rows > 0) {
                            while ($horario = $result_horarios->fetch_assoc()) {
                                $dia = ($horario['dia_inicio'] === $horario['dia_fim']) 
                                    ? $horario['dia_inicio'] 
                                    : $horario['dia_inicio'] . " à " . $horario['dia_fim'];
                                $abertura = date('H:i', strtotime($horario['abertura']));
                                $fechamento = date('H:i', strtotime($horario['fechamento']));
                                echo "<p>$dia: $abertura às $fechamento</p>";
                            }
                        } else {
                            echo "<p>Não informado</p>";
                        }
                        echo "</td>";

                        echo "<td><a href='" . htmlspecialchars($row['instagram']) . "' target='_blank'>" . htmlspecialchars($row['instagram']) . "</a></td>";
                        echo "<td><a href='https://wa.me/" . htmlspecialchars($row['whatsapp']) . "' target='_blank'>" . htmlspecialchars($row['whatsapp']) . "</a></td>";

                        //Tipos de coleta
                        echo "<td>";
                        if ($result_coletas && $result_coletas->num_rows > 0) {
                            while ($coleta = $result_coletas->fetch_assoc()) {
                                echo "<p title='" . htmlspecialchars($coleta['descricao']) . "'>" . htmlspecialchars($coleta['nome']) . "</p>";
                            }
                        } else {
                            echo "Não informado";
                        }
                        echo "</td>";

                        //Tipos de serviço
                        echo "<td>";
                        switch ($row['tipo_servico']) {
                            case 'coleta':
                                echo "Coleta";
                                break;
                            case 'distribuicao':
                                echo "Distribuição";
                                break;
                            case 'distribuicao':
                                echo "Distribuição e Coleta";
                                break;
                            default:
                                echo "Não informado";
                        }
                        echo "</td>";

                        echo "<td><img src='" . htmlspecialchars($row['imagem']) . "' width='100' alt='Imagem da instituição'></td>";

                        // Ações
                        echo "<td><a href='php/ADM/excluir_instituicao_aprovada.php?id=" . htmlspecialchars($row['id_instituicao']) . "' onclick=\"return confirm('Tem certeza que deseja excluir esta instituição?');\">";
                        echo "<button class='excluir-instituicao' type='button'>Excluir</button>";
                        echo "</a></td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>Nenhuma instituição aprovada encontrada.</td></tr>";
                }


        ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para Aprovação -->
    <div id="modalForm" class="modal">
        <form action="../php/ADM/aprovar_instituicao.php" method="POST">
            <span class="modal-close">&times;</span>
            <h2>Adicione Latitude e Longitude</h2>
            <input type="hidden" name="id" id="instituicaoId">
            <label for="latitude">Latitude:</label>
            <input type="text" name="latitude" id="latitude" required>
            <label for="longitude">Longitude:</label>
            <input type="text" name="longitude" required>
            <button type="submit">Aprovar</button>
        </form>
    </div>

    <!-- Modal para Ampliar Imagem -->
    <div id="imageModal" class="modal-imagem" style="display: none;">
        <span id="closeImageModal" class="img-close">&times;</span>
        <img id="modalImage" src="" alt="Imagem Ampliada" style="max-width: 90%; max-height: 90%; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);">
    </div>


    
    <script>
        function mostrarTabela(tabela) {
        // Esconde ambas as tabelas
        document.getElementById('pendentes').style.display = 'none';
        document.getElementById('aprovadas').style.display = 'none';

        // Remove a classe de centralização das tabelas
        document.getElementById('pendentes').classList.remove('centralizado');
        document.getElementById('aprovadas').classList.remove('centralizado');

        // Mostra a tabela selecionada e aplica a centralização
        const tabelaSelecionada = document.getElementById(tabela);
        tabelaSelecionada.style.display = 'flex';
        tabelaSelecionada.classList.add('centralizado');
    }
    </script>

    <script src="../assets/js/gestao/script.js"></script>

</body>
</html>
