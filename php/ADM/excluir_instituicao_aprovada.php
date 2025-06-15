<?php
include '../config/conexao.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM instituicoes WHERE id_instituicao = ? AND status = 'aprovado'"; //
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Instituição excluída com sucesso!'); window.location.href = '/gestao';</script>";
    } else {
        echo "<script>alert('Erro ao excluir a instituição: " . $stmt->error . "'); window.location.href = '/gestao';</script>";
    }


    $stmt->close();
}

$conn->close();
?>
