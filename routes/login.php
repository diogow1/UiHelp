<?php
session_start();
include '../php/config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha_digitada = $_POST['senha'];

    // Verifica o usuário no banco de dados
    $sql = "SELECT * FROM admin WHERE user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verifica a senha usando password_verify
        if (password_verify($senha_digitada, $user['password'])) {
            // Autenticação bem-sucedida
            $_SESSION['autenticado'] = true;
            header("Location: gestao");
            $_SESSION['admin_id'] = $user['id'];
            exit;
        } else {
            $erro = "Usuário ou senha incorretos.";
        }
    } else {
        $erro = "Usuário ou senha incorretos.";
    }

    



    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <meta property="og:image" content="../assets/img/icons/favicon.png" />
    <link rel="icon" href="../assets/img/icons/favicon.png" type="image/png">
</head>
<body class="login-page">

    <div class="logo-container"> 
        <a href="/"><img src="assets/img/icons/logo.png" alt="Logo da UiHelp"></a>
    </div>
    
    <div class="login-container">
        <form method="POST" action="">
            <label>Usuário:</label>
            <input type="text" name="usuario" required>
            
            <label>Senha:</label>
            <input type="password" name="senha" required>
            
            <button type="submit">Logar</button>
            <?php if (isset($erro)) echo "<p class='error-message'>$erro</p>"; ?>
        </form>
    </div>
</body>
</html>
