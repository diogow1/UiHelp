<?php
    $status = $_GET['status'] ?? 'error';
    $message = $_GET['message'] ?? 'Erro desconhecido';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UiHelp</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/aviso.css">

    <meta property="og:image" content="../assets/img/icons/favicon.png" />
    <link rel="icon" href="../assets/img/icons/favicon.png" type="image/png">

</head>
<body>

<section id='box'>
    <div id='divImg'>
        <a href="/"><img src="../assets/img/icons/icon2.png" alt="">
    </div></a> 
    <div id='divTitulo'>
        <h1><?= htmlspecialchars($message) ?></h1>
    </div>
    <div id='divDescricao'>
        <?php
        if ($message == 'Sua inscrição foi enviada!' && $status == "success"){
            echo '<span>Sua inscrição foi enviada para o nosso time e será analisada a veracidade das informações. Caso aprovado, será exibido em nosso mapa! Tenha paciência, isso pode levar alguns dias.</span>';
        } elseif ($status == 'error'){
            echo '<span>Ocorreu algum erro, sentimos muito. Entre em contato conosco para podermos te ajudar! Nosso <a href="https://www.instagram.com/ui.help/">Instagram</a> e <a href="https://wa.me/5548991967983">Whatsapp</a></span>';
        }
        ?>

    </div>
    <div id='divVoltar'>
        <a href="/"><button>Página Inicial</button></a>
    </div>
</section>
    
</body>
</html>
