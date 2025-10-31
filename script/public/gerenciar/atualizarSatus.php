<?php
include '../includes/conexao.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $mysqli->query("
        UPDATE tarefas 
        SET atualizarStatus = CASE 
            WHEN atualizarStatus = 'Fazer' THEN 'Fazendo'
            WHEN atualizarStatus = 'Fazendo' THEN 'Pronto'
            ELSE 'Fazer'
        END
        WHERE id = $id
    ");
}
header('Location: lerTarefas.php');
exit;
?>