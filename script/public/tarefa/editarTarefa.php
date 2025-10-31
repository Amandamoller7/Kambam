<?php
include '../../Db/conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: lerTarefa.php');
    exit;
}

// Buscar tarefa existente
$stmt = $mysqli->prepare("
    SELECT id, descricao_tarefa, setor, prioridade, data_cadastro, status_Atividade, id_usuario
    FROM tarefas WHERE id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$tarefa = $result->fetch_assoc();

if (!$tarefa) {
    die("Tarefa não encontrada.");
}

$usuarios = $mysqli->query("SELECT id, nome FROM usuarios");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao_tarefa'];
    $setor = $_POST['setor'];
    $prioridade = $_POST['prioridade'];
    $data_cadastro = $_POST['data_cadastro'];
    $status_tarefa = $_POST['status_atividade'];
    $usuario_responsavel = $_POST['id_usuario'];

    $update = $mysqli->prepare("
        UPDATE tarefas SET descricao_tarefa=?, setor=?, prioridade=?, data_cadastro=?, status_atividade=?, id_usuario=?
        WHERE id=?
    ");
    $update->bind_param("sssssii", $descricao_tarefa, $setor, $prioridade, $data_cadastro, $status_atividade, $id_usuario, $id);
    $update->execute();

    header('Location: lerTarefas.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarefa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Editar Tarefa #<?= $tarefa['id'] ?></h2>
    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Descrição:</label>
            <input type="text" name="descricao" value="<?= htmlspecialchars($tarefa['descricao_tarefa']) ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Setor:</label>
            <input type="text" name="setor" value="<?= htmlspecialchars($tarefa['setor']) ?>" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Prioridade:</label>
            <select name="prioridade" class="form-select" required>
                <option value="Baixa" <?= $tarefa['prioridade']=='Baixa'?'selected':'' ?>>Baixa</option>
                <option value="Média" <?= $tarefa['prioridade']=='Média'?'selected':'' ?>>Média</option>
                <option value="Alta" <?= $tarefa['prioridade']=='Alta'?'selected':'' ?>>Alta</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Data de Cadastro:</label>
            <input type="date" name="data_cadastro" value="<?= $tarefa['data_cadastro'] ?>" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Status:</label>
            <select name="status_atividade" class="form-select" required>
                <option value="Fazer" <?= $tarefa['status_atividade']=='Fazer'?'selected':'' ?>>Fazer</option>
                <option value="Fazendo" <?= $tarefa['status_atividade']=='Fazendo'?'selected':'' ?>>Fazendo</option>
                <option value="Pronto" <?= $tarefa['status_atividade']=='Pronto'?'selected':'' ?>>Pronto</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Usuário Responsável:</label>
            <select name="id_usuario" class="form-select" required>
                <?php while($u = $usuarios->fetch_assoc()): ?>
                    <option value="<?= $u['id'] ?>" <?= $u['id']==$tarefa['id_usuario']?'selected':'' ?>>
                        <?= htmlspecialchars($u['nome']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-12">
            <button class="btn btn-primary">Salvar Alterações</button>
            <a href="read-gerenciar.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>