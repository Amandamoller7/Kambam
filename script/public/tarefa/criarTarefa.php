<?php
include '../../Db/conexao.php';

$usuarios = $mysqli->query("SELECT id, nome FROM usuarios");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao_tarefa'] ?? '';
    $setor = $_POST['setor'] ?? '';
    $prioridade = $_POST['prioridade'] ?? '';
    $data_cadastro = $_POST['data_cadastro'] ?? '';
    $status_tarefa = $_POST['status_atividade'] ?? '';
    $usuario_responsavel = $_POST['id_usuario'] ?? '';

    if ($descricao_tarefa && $setor && $prioridade && $data_cadastro && $status_tarefa && $id_usuario) {
        $stmt = $mysqli->prepare("
            INSERT INTO tarefas (descricao_tarefa, setor, prioridade, data_cadastro, status_atividade, id_usuario)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sssssi", $descricao_tarefa, $setor, $prioridade, $data_cadastro, $status_atividade, $id_usuario);
        $stmt->execute();
        header('Location: lerTarefas.php');
        exit;
    } else {
        $erro = "Preencha todos os campos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color:rgb(0, 86, 179);">
    <div class="container-fluid">
        <h3 class="text-white">Gerenciamento de Tarefas</h3>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link text-white" href="create-usuarios.php">Usuários</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="create-tarefas.php">Tarefas</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="read-gerenciar.php">Gerenciar</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <h2>Cadastro</h2>
    <?php if (!empty($erro)): ?><div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Descrição:</label>
            <input type="text" name="descricao" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Setor:</label>
            <input type="text" name="setor" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Prioridade:</label>
            <select name="prioridade" class="form-select" required>
                <option value="">Selecione</option>
                <option value="Baixa">Baixa</option>
                <option value="Média">Média</option>
                <option value="Alta">Alta</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Data de Cadastro:</label>
            <input type="date" name="data_cadastro" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Status da Tarefa:</label>
            <select name="status_tarefa" class="form-select" required>
                <option value="">Selecione:</option>
                <option value="Fazer">Fazer</option>
                <option value="Fazendo">Fazendo</option>
                <option value="Pronto">Pronto</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">ID:</label>
            <select name="usuario_responsavel" class="form-select" required>
                <option value="">Selecione</option>
                <?php while($u = $usuarios->fetch_assoc()): ?>
                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nome']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-12">
            <button class="btn btn-primary">Cadastrar Tarefa</button>
        </div>
    </form>
</div>
</body>
</html>