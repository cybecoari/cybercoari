<?php
require_once __DIR__ . '/../includes/init.php';
protegerPagina();

$nivelUsuario = $_SESSION['nivel'] ?? 'comum';
$usuarioId = $_SESSION['usuario_id'] ?? 0;

// ================== CADASTRAR ==================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'criar') {
    $nome = limparPost('nome');
    $email = limparPost('email');
    $senha = limparPost('senha');
    $tipo = limparPost('tipo_usuario');

    if ($nivelUsuario !== 'admin') $tipo = 'comum';

    if ($nome && $email && $senha && $tipo) {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            setError("E-mail já cadastrado!");
        } else {
            $hash = gerarHashSenha($senha);
            $stmt = $pdo->prepare("
                INSERT INTO usuarios (nome, email, senha_hash, tipo_usuario, ativo, modo_escuro)
                VALUES (:nome, :email, :senha, :tipo, 1, 0)
            ");
            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':senha' => $hash,
                ':tipo' => $tipo
            ]);
            setSuccess("Usuário criado com sucesso!");
        }
    } else {
        setError("Preencha todos os campos!");
    }
}

// ================== EXCLUIR ==================
if (isset($_GET['excluir']) && $nivelUsuario === 'admin') {
    $id = (int)$_GET['excluir'];
    if ($id !== $usuarioId) {
        $pdo->prepare("DELETE FROM usuarios WHERE id = :id")->execute([':id' => $id]);
        setSuccess("Usuário excluído com sucesso!");
    } else {
        setError("Você não pode se excluir!");
    }
    header("Location: cadastro.php");
    exit;
}

// ================== EDITAR ==================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'editar' && $nivelUsuario === 'admin') {
    $id = (int)$_POST['id'];
    $novoNome = limparPost('nome');
    if ($novoNome) {
        $pdo->prepare("UPDATE usuarios SET nome = :n WHERE id = :id")->execute([':n' => $novoNome, ':id' => $id]);
        setSuccess("Nome atualizado com sucesso!");
    } else {
        setError("Nome não pode estar vazio!");
    }
    header("Location: cadastro.php");
    exit;
}

// ================== LISTAR ==================
if ($nivelUsuario === 'admin') {
    $usuarios = $pdo->query("SELECT id, nome, email, tipo_usuario FROM usuarios ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->prepare("SELECT id, nome, email, tipo_usuario FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $usuarioId]);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-BR" id="html-theme">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gerenciar Usuários</title>
<link rel="stylesheet" href="/assets/css/app.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/js/temas.js" defer></script>

<style>
body {
    font-family: Arial, sans-serif;
    background: var(--cor-fundo);
    color: var(--cor-texto);
    margin: 0;
    padding: 0;
}
.container {
    max-width: 700px;
    margin: 3rem auto;
    background: var(--cor-card-fundo);
    border: 1px solid var(--cor-borda);
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
input, select {
    width: 100%;
    padding: 10px;
    margin: 8px 0 16px;
    border-radius: 6px;
    border: 1px solid var(--cor-borda);
}
button {
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    color: white;
    font-weight: bold;
}
.btn-editar { background: #f0ad4e; }
.btn-excluir { background: #d9534f; }
.btn-editar:hover { background: #ec971f; }
.btn-excluir:hover { background: #c9302c; }
.tabela {
    width: 100%;
    border-collapse: collapse;
    margin-top: 2rem;
}
.tabela th, .tabela td {
    border: 1px solid var(--cor-borda);
    padding: 8px;
    text-align: left;
}
.tabela th {
    background: var(--cor-link);
    color: white;
}
</style>
</head>
<body>
<div class="container">
    <h2 style="text-align:center;">Cadastrar Novo Usuário</h2>
    <form method="POST" autocomplete="off">
        <input type="hidden" name="acao" value="criar">
        <label>Nome</label>
        <input type="text" name="nome" required>
        <label>E-mail</label>
        <input type="email" name="email" required>
        <label>Senha</label>
        <input type="password" name="senha" required>
        <label>Tipo</label>
        <select name="tipo_usuario" required>
            <?php if ($nivelUsuario === 'admin'): ?>
                <option value="admin">Administrador</option>
            <?php endif; ?>
            <option value="comum" selected>Comum</option>
        </select>
        <button type="submit" style="width:100%;background:var(--cor-link);">Cadastrar</button>
    </form>

    <h3 style="margin-top:2rem;">Usuários Cadastrados</h3>
    <table class="tabela">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Tipo</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['nome']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= ucfirst($u['tipo_usuario']) ?></td>
                <td>
                    <?php if ($nivelUsuario === 'admin'): ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="acao" value="editar">
                            <input type="hidden" name="id" value="<?= $u['id'] ?>">
                            <input type="text" name="nome" value="<?= htmlspecialchars($u['nome']) ?>" style="width:120px;">
                            <button type="submit" class="btn-editar">Salvar</button>
                        </form>
                        <button class="btn-excluir" onclick="confirmarExclusao(<?= $u['id'] ?>)">Excluir</button>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="/painel.php" class="voltar">← Voltar ao Painel</a>
</div>

<script>
function confirmarExclusao(id) {
    Swal.fire({
        title: 'Tem certeza?',
        text: 'Essa ação não pode ser desfeita!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, excluir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'cadastro.php?excluir=' + id;
        }
    });
}

<?php if (temErro()): ?>
Swal.fire({ icon: 'error', title: 'Erro', text: '<?= getErro() ?>', confirmButtonColor: '#d33' });
<?php elseif (temSucesso()): ?>
Swal.fire({ icon: 'success', title: 'Sucesso', text: '<?= getSucesso() ?>', confirmButtonColor: '#3085d6' });
<?php endif; ?>
</script>
</body>
</html>