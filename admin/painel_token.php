<?php
require_once __DIR__ . '/../includes/init.php';

// ============================
// 🔒 Permissão: somente admin
// ============================
if (!usuarioLogado() || ($_SESSION['nivel'] ?? 'usuario') !== 'admin') {
    setError("Acesso negado! Apenas administradores podem criar tokens.");
    redirecionar('painel.php');
    exit;
}

$modoEscuro = $_SESSION['modo_escuro'] ?? false;
$temaUsuario = $_SESSION['tema_usuario'] ?? ($modoEscuro ? 'noturno' : 'diurno');

// ============================
// ⚙️ Ativar token manualmente
// ============================
if (isset($_GET['ativar_id'])) {
    $id = (int)$_GET['ativar_id'];
    $stmt = $pdo->prepare("UPDATE api_tokens SET status='active', paid=1 WHERE id=:id");
    $stmt->execute([':id' => $id]);
    setSuccess("Token ID $id ativado com sucesso.");
    redirecionar('painel_token.php');
    exit;
}

// ============================
// 🧹 Revogar token manualmente
// ============================
if (isset($_GET['revogar_id'])) {
    $id = (int)$_GET['revogar_id'];
    $stmt = $pdo->prepare("UPDATE api_tokens SET status='revoked' WHERE id=:id");
    $stmt->execute([':id' => $id]);
    setSuccess("Token ID $id revogado com sucesso.");
    redirecionar('painel_token.php');
    exit;
}

// ============================
// 🧩 Criar novo token
// ============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $owner_user_id = (int)limparPost('owner_user_id');
    $label = limparPost('label');
    $price = (float)limparPost('price');
    $validadeDias = (int)limparPost('validade_dias');

    if ($owner_user_id && $label && $validadeDias > 0) {
        $token_hash = gerarToken(16);
        $expires_at = date('Y-m-d H:i:s', strtotime("+$validadeDias days"));

        $stmt = $pdo->prepare("
            INSERT INTO api_tokens (token_hash, owner_user_id, label, price, status, paid, created_at, expires_at)
            VALUES (:token, :owner, :label, :price, 'pending_payment', 0, NOW(), :expires)
        ");
        $stmt->execute([
            ':token' => $token_hash,
            ':owner' => $owner_user_id,
            ':label' => $label,
            ':price' => $price,
            ':expires' => $expires_at
        ]);

        setSuccess("Token criado com sucesso: $token_hash (expira em $validadeDias dias)");
    } else {
        setError("Preencha todos os campos corretamente!");
    }
}

// ============================
// 🧹 Limpa tokens expirados pendentes
// ============================
$pdo->query("DELETE FROM api_tokens WHERE status='pending_payment' AND paid = 0 AND expires_at <= NOW()");

// ============================
// 👥 Buscar usuários
// ============================
$usuarios = $pdo->query("SELECT id, nome FROM usuarios ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC);

// ============================
// 📜 Buscar tokens existentes
// ============================
$tokens = $pdo->query("
    SELECT t.*, u.nome AS owner_nome 
    FROM api_tokens t
    JOIN usuarios u ON u.id = t.owner_user_id
    ORDER BY t.id DESC
")->fetchAll(PDO::FETCH_ASSOC);

// ============================
// 📊 Resumo de tokens por usuário
// ============================
$contagemTokens = $pdo->query("
    SELECT 
        u.id AS usuario_id,
        u.nome,
        SUM(CASE WHEN t.status='active' AND t.paid=1 THEN 1 ELSE 0 END) AS ativos,
        SUM(CASE WHEN t.status='pending_payment' AND t.paid=0 THEN 1 ELSE 0 END) AS pendentes,
        SUM(CASE WHEN t.status='revoked' THEN 1 ELSE 0 END) AS revogados,
        SUM(CASE WHEN t.expires_at < NOW() AND t.paid=0 THEN 1 ELSE 0 END) AS expirados
    FROM usuarios u
    LEFT JOIN api_tokens t ON t.owner_user_id = u.id
    GROUP BY u.id
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR" id="html-theme" class="<?= $modoEscuro ? 'modo-escuro' : '' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gerenciar Tokens - Sistema</title>
<link rel="stylesheet" href="/assets/css/app.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/js/temas.js" defer></script>
<style>
.container { max-width: 1000px; margin: 3rem auto; padding: 2rem; background: var(--cor-card-fundo); border: 1px solid var(--cor-borda); border-radius: 12px; }
input, select { width: 100%; padding: 10px; margin-bottom: 12px; border-radius: 6px; border: 1px solid var(--cor-borda); background: var(--cor-fundo); color: var(--cor-texto); }
button { padding: 10px 20px; background: var(--cor-btn-primaria); color: #fff; border: none; border-radius: 6px; cursor: pointer; }
button:hover { background: var(--cor-btn-primaria-hover); }
table { width: 100%; border-collapse: collapse; margin-top: 2rem; }
th, td { padding: 8px; border: 1px solid var(--cor-borda); text-align: left; }
th { background: var(--cor-btn-primaria); color: #fff; }
.ativo { color: green; font-weight: bold; }
.pendente { color: orange; font-weight: bold; }
.revoked { color: red; font-weight: bold; }
</style>
</head>
<body>
<div class="container">
    <h2>Criar Novo Token</h2>
    <form method="POST" autocomplete="off">
        <label>Proprietário</label>
        <select name="owner_user_id" required>
            <option value="">Selecione um usuário</option>
            <?php foreach($usuarios as $u): ?>
                <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Label do Token</label>
        <input type="text" name="label" placeholder="Ex: Token API XYZ" required>

        <label>Preço</label>
        <input type="number" step="0.01" name="price" placeholder="0.00" required>

        <label>Validade do Token</label>
        <select name="validade_dias" required>
            <option value="">Selecione a validade</option>
            <option value="30">30 dias</option>
            <option value="90">90 dias</option>
            <option value="180">180 dias</option>
            <option value="365">1 ano</option>
        </select>

        <button type="submit">Criar Token</button>
    </form>

    <h2 style="margin-top:2rem;">Resumo de Tokens por Usuário</h2>
    <table>
        <thead>
            <tr><th>Usuário</th><th>Ativos</th><th>Pendentes</th><th>Revogados</th><th>Expirados</th></tr>
        </thead>
        <tbody>
            <?php foreach($contagemTokens as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['nome']) ?></td>
                <td><?= $c['ativos'] ?></td>
                <td><?= $c['pendentes'] ?></td>
                <td><?= $c['revogados'] ?></td>
                <td><?= $c['expirados'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 style="margin-top:2rem;">Tokens Existentes</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Token</th><th>Usuário</th><th>Label</th>
                <th>Preço</th><th>Status</th><th>Pago</th>
                <th>Criado em</th><th>Expira em</th><th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tokens as $t): ?>
            <tr>
                <td><?= $t['id'] ?></td>
                <td><?= $t['token_hash'] ?></td>
                <td><?= htmlspecialchars($t['owner_nome']) ?></td>
                <td><?= htmlspecialchars($t['label']) ?></td>
                <td>R$ <?= number_format($t['price'],2,",",".") ?></td>
                <td class="<?= $t['status'] ?>"><?= ucfirst($t['status']) ?></td>
                <td><?= $t['paid'] ? 'Sim' : 'Não' ?></td>
                <td><?= $t['created_at'] ?></td>
                <td><?= $t['expires_at'] ?></td>
                <td>
                    <?php if(!$t['paid']): ?>
                        <button class="btn-ativar" data-id="<?= $t['id'] ?>">Ativar</button>
                    <?php endif; ?>
                    <?php if($t['status'] !== 'revoked'): ?>
                        <button class="btn-revogar" data-id="<?= $t['id'] ?>">Revogar</button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    activateTheme('<?= $temaUsuario ?>');

    // SweetAlert feedback
    <?php if(temErro()): ?>
        Swal.fire({ icon:'error', title:'Erro', text:'<?= getErro() ?>' });
    <?php elseif(temSucesso()): ?>
        Swal.fire({ icon:'success', title:'Sucesso', text:'<?= getSucesso() ?>' });
    <?php endif; ?>

    // Confirmar ativação
    document.querySelectorAll('.btn-ativar').forEach(btn => {
        btn.addEventListener('click', () => {
            Swal.fire({
                title: 'Ativar Token?',
                text: 'O token será marcado como pago e ativo.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sim, ativar',
                cancelButtonText: 'Cancelar'
            }).then(res => {
                if (res.isConfirmed) {
                    window.location.href = '?ativar_id=' + btn.dataset.id;
                }
            });
        });
    });

    // Confirmar revogação
    document.querySelectorAll('.btn-revogar').forEach(btn => {
        btn.addEventListener('click', () => {
            Swal.fire({
                title: 'Revogar Token?',
                text: 'Essa ação não pode ser desfeita!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sim, revogar',
                cancelButtonText: 'Cancelar'
            }).then(res => {
                if (res.isConfirmed) {
                    window.location.href = '?revogar_id=' + btn.dataset.id;
                }
            });
        });
    });
});
</script>
</body>
</html>