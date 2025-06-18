<?php
$local = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1']);

if ($local) {
    $servername = "localhost";
    $username = "root";        
    $password = "";            
    $dbname = "";
} else {
    // Produção (Hostinger)
    $servername = "localhost";
    $username = "";        
    $password = "";            
    $dbname = "";
}

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>

