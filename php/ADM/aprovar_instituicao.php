<?php
session_start();
$admin_id = $_SESSION['admin_id'];


include '../config/conexao.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];


    $sql = "UPDATE instituicoes SET latitude = ?, longitude = ?, id_admin = ?, status = 'aprovado' WHERE id_instituicao = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro no prepare(): " . $conn->error);
    }

    $stmt->bind_param("ddii", $latitude, $longitude, $admin_id, $id);


    if (!$stmt->execute()) {
        echo "Erro ao atualizar: " . $stmt->error;
    }


    $stmt->close();
    $conn->close();

    header("Location: /gestao");
    exit();
}
?>
