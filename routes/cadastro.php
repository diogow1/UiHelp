
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/cadastro.css">
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">


    <meta property="og:image" content="../assets/img/icons/favicon.png" />
    <link rel="icon" href="../assets/img/icons/favicon.png" type="image/png">

    <!-- links do style do select -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



</head>
<body class="cadastro">

    <form id="cnpjForm" action="php/processa_cadastro.php" method="POST" enctype="multipart/form-data">
        <h1>Cadastre Sua Instituição</h1>

        <!-- 1. Identificação -->
        <label for="cnpjInput">CNPJ *</label>
        <input type="text" name="cnpj" id="cnpjInput" maxlength="18" placeholder="Digite o CNPJ" required>

        <label for="nome">Nome da Instituição *</label>
        <input type="text" name="nome" id="nome" placeholder="Digite o nome da instituição" required>

        <label for="descricao">Descrição</label>
        <input type="text" name="descricao" id="descricao" placeholder="Comente um pouco sobre sua organização! (max: 200 caracteres)">

        <!-- 2. Endereço -->
        <label for="cep">CEP *</label>
        <input type="text" name="cep" id="cep" maxlength="8" placeholder="Digite o CEP" required>

        <div class="input-row">
            <div class="input-group small">
                <label for="uf">Estado/UF *</label>
                <input type="text" name="uf" id="uf" maxlength="2" placeholder="UF" required>
            </div>

            <div class="input-group">
                <label for="cidade">Cidade *</label>
                <input type="text" name="cidade" id="cidade" placeholder="Cidade" required>
            </div>
        </div>

        <label for="bairro">Bairro *</label>
        <input type="text" name="bairro" id="bairro" placeholder="Bairro" required>

        <div class="input-row">
            <div class="input-group">
                <label for="logradouro">Rua/Logradouro *</label>
                <input type="text" name="logradouro" id="logradouro" placeholder="Rua/Logradouro" required>
            </div>

            <div class="input-group small">
                <label for="numero">Nº * </label>
                <input type="number" name="numero" id="numero" placeholder="Número" required>
            </div>
        </div>

        <label for="complemento">Complemento</label>
        <input type="text" name="complemento" id="complemento" placeholder="Ex: Interfone 101">

        <!-- 3. Contato -->
        <label for="email">Email *</label>
        <input type="email" name="email" id="email" placeholder="Email" required>

        <label for="telefone">Telefone *</label>
        <input type="text" name="telefone" id="telefone" placeholder="Telefone" required>

        <div class="input-row">
            <div class="input-group">
                <label for="whatsapp">Whatsapp</label>
                <input type="text" name="whatsapp" id="whatsapp" placeholder="Número de Whatsapp">
            </div>

            <div class="input-group">
                <label for="instagram">Instagram (Link)</label>
                <input type="text" name="instagram" id="instagram" placeholder="Ex: https://www.instagram.com/ui.help">
            </div>
        </div>

        <!-- 4. Horário de funcionamento -->
        <h3 style="margin-bottom: 10px; color:#333;">Horários de Funcionamento *</h3>
        

        <div id="horarios-container">

        </div>
        
        <button type="button" class="btn-adicionar" onclick="adicionarDia()">＋ Adicionar dia</button>




        <!-- 5. Serviços -->
        <label for="coletas">Tipos de Coletas e Serviços: *</label>
        <select name="coletas[]" id="coletas" multiple="multiple" required>
            <option value="1">Roupas</option>
            <option value="5">Móveis</option>
            <option value="3">Brinquedos</option>
            <option value="4">Alimentos</option>
            <option value="2">Resíduos</option>
        </select>

        <select id="tipo_servico" name="tipo_servico" required>
            <option value="" disabled selected>Selecione...</option>
            <option value="coleta">Coleta</option>
            <option value="distribui">Distribuição</option>
            <option value="distribuicao_e_coleta">Distribuição e Coleta</option>
        </select>

        <!-- 6. Imagem -->
        <label for="imagem" class="custom-file-upload">
            <span class="upload-text">Escolha uma imagem (.png ou .jpeg)</span>
            <input type="file" name="imagem" id="imagem" accept="image/png, image/jpeg">
        </label>
        <div id="preview-container">
            <img id="preview-image" src="#" alt="Pré-visualização" style="display: none;" />
        </div>
        <div id='obs'>
            <span>*O envio de uma imagem de sua instituição (foto ou logo) é obrigatório.</span>
        </div>


        <!-- 7. Botões -->
        <button type="submit" id="submit-btn">Enviar</button>
        <div id='divVoltar'><a href="/"><button type="button" id="back-btn">Voltar</button></a></div>

        <p id="status-cadastro"></p>
    </form>


</body>
<script>

const inputImagem = document.getElementById("imagem");
const previewImage = document.getElementById("preview-image");

inputImagem.addEventListener("change", () => {
    const file = inputImagem.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            previewImage.style.display = "block";
            fileNameSpan.textContent = inputImagem.files[0].name;

        };
        reader.readAsDataURL(file);
    } else {
        previewImage.src = "#";
        previewImage.style.display = "none";
    }
});


$(document).ready(function() {
    $('#coletas').select2({
    placeholder: "Selecione os tipos de coleta",
    width: '100%'
    });
});



</script>
<script src="../assets/js/cadastro/script.js"></script>
<script src="../assets/js/cadastro/viaCepAPI.js"></script>
<script src="../assets/js/cadastro/diasH.js"></script>

</html>
