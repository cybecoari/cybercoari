<?php
require_once __DIR__ . '/includes/init.php';

// ================== Redireciona se já logado ==================
if (usuarioLogado()) {
    redirecionar('painel.php');
}

// ================== Processa login ==================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identificador = limparPost('identificador');
    $senha = limparPost('senha');

    if (!empty($identificador) && !empty($senha)) {
        $stmt = $pdo->prepare("
            SELECT * FROM usuarios 
            WHERE (email = :id OR nome = :id) AND ativo = 1
            LIMIT 1
        ");
        $stmt->execute([':id' => $identificador]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            setError("Usuário ou e-mail não encontrado!");
        } elseif (!password_verify($senha, $usuario['senha_hash'])) {
            setError("Senha incorreta!");
        } else {
            // ================== Login bem-sucedido ==================
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['nivel'] = $usuario['tipo_usuario'];
            $_SESSION['modo_escuro'] = (bool)$usuario['modo_escuro'];
            $_SESSION['tema_usuario'] = $usuario['modo_escuro'] ? 'noturno' : 'diurno';

            // Atualiza último acesso
            $stmt = $pdo->prepare("UPDATE usuarios SET ultimo_acesso = NOW() WHERE id = :id");
            $stmt->execute([':id' => $usuario['id']]);

            setSuccess("Login realizado com sucesso!");
            redirecionar('painel.php');
        }
    } else {
        setError("Preencha todos os campos!");
    }
}

// ================== Total de usuários ==================
$totalUsuarios = $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();

// ================== Usuários online (últimos 5 minutos) ==================
$usuariosOnline = $pdo->query("
    SELECT COUNT(*) 
    FROM usuarios 
    WHERE ultimo_acesso >= (NOW() - INTERVAL 5 MINUTE)
")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="pt-BR" id="html-theme">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Sistema</title>

  <link rel="stylesheet" href="assets/css/app.css">
  <!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="assets/js/temas.js" defer></script>

<style>
body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background: var(--cor-fundo);
    color: var(--cor-texto);
    font-family: Arial, sans-serif;
}
.login-card {
    background: var(--cor-card-fundo);
    border: 1px solid var(--cor-borda);
    padding: 2rem;
    border-radius: 12px;
    width: 100%;
    max-width: 380px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
input {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
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
button:hover { background: var(--cor-link-hover); }
.stats {
    text-align: center;
    margin-bottom: 1rem;
}
.stats h3 { margin: 4px 0; }
</style>
</head>
<body>
<div class="login-card">
    <div class="stats">
        <h3>Usuários online: <span id="usuarios-online"><?= $usuariosOnline ?></span></h3>
        <h3>Total de usuários: <?= $totalUsuarios ?></h3>
    </div>

    <form method="POST" autocomplete="off">
        <label for="identificador">Usuário ou E-mail</label>
        <input type="text" id="identificador" name="identificador" placeholder="Digite seu usuário ou e-mail" required>

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>

        <button type="submit">Entrar</button>
    </form>
    <br>
    
    <!-- entra no web mail -->     
    <center>
    <a href="https://webmail.cybercoari.com.br/" class="d-block mb-2">
    <i class="bi bi-envelope"></i> Conta Email
    </a>
    </center>
    
</div>
   
   

  <script src="https://cybercoari.com.br/cyber/js/sweetalert2.all.min.js"></script>
  <script src="assets/js/app.js" defer></script>
  <script src="assets/js/login.js" defer></script>

  <!--<script>
document.addEventListener('DOMContentLoaded', () => {
    loadThemePreference();

    // ================== Flash messages ==================
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
        });
    <?php endif; ?>

    // ================== Atualiza usuários online via AJAX ==================
    function atualizarOnline() {
        fetch('includes/online.php', { cache: 'no-store' })
            .then(res => res.json())
            .then(data => {
                if (data && typeof data.online !== 'undefined') {
                    document.getElementById('usuarios-online').textContent = data.online;
                }
            })
            .catch(err => console.error('Erro ao atualizar online:', err));
    }

    // Atualiza imediatamente ao carregar
    atualizarOnline();

    // Atualiza a cada 60 segundos
    setInterval(atualizarOnline, 60000);
});
</script> -->
</body>
</html>