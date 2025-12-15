<?php
require_once __DIR__ . '/../includes/init.php';

// ================== Protege página ==================
protegerPagina();
$nivelUsuario = $_SESSION['nivel'] ?? 'comum';
$usuarioIdLogado = $_SESSION['usuario_id'] ?? null;

// ================== Processa POST ==================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = limparPost('usuario_id');
    $nova_senha = limparPost('nova_senha');
    $confirmar_senha = limparPost('confirmar_senha');

    // Usuário comum só pode alterar a própria senha
    if ($nivelUsuario !== 'admin') $usuario_id = $usuarioIdLogado;

    if (!$usuario_id || !$nova_senha || !$confirmar_senha) {
        setError("Preencha todos os campos!");
    } elseif ($nova_senha !== $confirmar_senha) {
        setError("As senhas não coincidem!");
    } else {
        $stmt = $pdo->prepare("SELECT id, nome FROM usuarios WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $usuario_id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            setError("Usuário não encontrado!");
        } else {
            $hash = gerarHashSenha($nova_senha);
            $stmt = $pdo->prepare("UPDATE usuarios SET senha_hash = :hash WHERE id = :id");
            $stmt->execute([':hash' => $hash, ':id' => $usuario_id]);

            setSuccess("Senha de <strong>{$usuario['nome']}</strong> atualizada com sucesso!");
        }
    }
}

// ================== Lista usuários ==================
$usuarios = [];
if ($nivelUsuario === 'admin') {
    $stmt = $pdo->query("SELECT id, nome, tipo_usuario FROM usuarios ORDER BY nome ASC");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-BR" id="html-theme">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mudar Senha - Sistema</title>
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
    max-width: 550px;
    margin: 3rem auto;
    background: var(--cor-card-fundo);
    border: 1px solid var(--cor-borda);
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
select, input {
    width: 100%;
    padding: 10px;
    margin: 8px 0 16px;
    border-radius: 6px;
    border: 1px solid var(--cor-borda);
    background: var(--cor-fundo);
    color: var(--cor-texto);
}
button {
    width: 100%;
    padding: 10px;
    background: var(--cor-link);
    border: none;
    border-radius: 6px;
    color: white;
    font-weight: bold;
    cursor: pointer;
}
button:hover {
    background: var(--cor-link-hover);
}
a.voltar {
    display: block;
    text-align: center;
    margin-top: 1rem;
    color: var(--cor-link);
    text-decoration: none;
}
a.voltar:hover {
    text-decoration: underline;
}
label { font-weight: bold; }
</style>
</head>
<body>
<div class="container">
    <h2 style="text-align:center;">Alterar Senha</h2>
    <form method="POST" autocomplete="off">
        <?php if ($nivelUsuario === 'admin'): ?>
            <label for="usuario_id">Selecione o Usuário</label>
            <select id="usuario_id" name="usuario_id" required>
                <option value="">Selecione...</option>
                <?php foreach ($usuarios as $u): ?>
                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nome']) ?> (<?= $u['tipo_usuario'] ?>)</option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <label for="nova_senha">Nova Senha</label>
        <input type="password" id="nova_senha" name="nova_senha" placeholder="Digite a nova senha" required>

        <label for="confirmar_senha">Confirmar Nova Senha</label>
        <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme a nova senha" required>

        <button type="submit">Atualizar Senha</button>
    </form>
    <a href="/painel.php" class="voltar">← Voltar ao Painel</a>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    loadThemePreference();

    <?php if (temErro()): ?>
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            html: '<?= getErro() ?>',
            confirmButtonColor: '#d33'
        });
    <?php elseif (temSucesso()): ?>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso',
            html: '<?= getSucesso() ?>',
            confirmButtonColor: '#3085d6'
        }).then(() => {
            window.location.href = '/painel.php';
        });
    <?php endif; ?>
});
</script>
</body>
</html>