<?php
require_once __DIR__ . '/../includes/init.php';

// ================================
// Verifica login
// ================================
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

// ================================
// Busca dados do usuário
// ================================
$usuario = 'Usuário';
$tipo = 'comum';
$modoEscuro = $_SESSION['modo_escuro'] ?? false;

try {
    $stmt = $pdo->prepare("
        SELECT nome, tipo_usuario AS tipo, modo_escuro 
        FROM usuarios 
        WHERE id = :id LIMIT 1
    ");
    $stmt->execute(['id' => $_SESSION['usuario_id']]);
    $dadosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dadosUsuario) {
        $usuario = $dadosUsuario['nome'] ?? 'Usuário';
        $tipo = $dadosUsuario['tipo'] ?? 'comum';
        $modoEscuro = (bool)($dadosUsuario['modo_escuro'] ?? false);
        $_SESSION['modo_escuro'] = $modoEscuro;
    }
} catch (Exception $e) {
    $usuario = 'Usuário';
    $tipo = 'comum';
    $modoEscuro = false;
}

// ================================
// Tema fallback
// ================================
$temaUsuarioFallback = $modoEscuro ? 'noturno' : 'diurno';

// ================================
// Contadores iniciais
// ================================
$usuariosOnline = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE ultimo_acesso >= (NOW() - INTERVAL 5 MINUTE)")->fetchColumn();
$totalUsuarios = $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();

$stmtTokens = $pdo->prepare("SELECT COUNT(*) FROM api_tokens WHERE owner_user_id = :user_id");
$stmtTokens->execute(['user_id' => $_SESSION['usuario_id']]);
$totalTokens = $stmtTokens->fetchColumn();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Painel <?= ucfirst($tipo) ?> - Sistema</title>

<!-- Bootstrap e ícones -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
:root {
    --cor-fundo: #fff;
    --cor-card-fundo: #fff;
    --cor-borda: #ced4da;
    --cor-texto: #000;
    --cor-link: #6f42c1;
    --cor-link-hover: #5a2ea6;
}
body.modo-escuro {
    --cor-fundo: #0d1117;
    --cor-card-fundo: #16213e;
    --cor-borda: #30363d;
    --cor-texto: #fff;
    --cor-link: #8b5cf6;
    --cor-link-hover: #16213e;
}
body {
    background-color: var(--cor-fundo);
    color: var(--cor-texto);
    font-family: "Poppins", sans-serif;
}
a { text-decoration: none; color: inherit; }

.header-painel {
    background-color: var(--cor-link);
    color: #fff;
    border-radius: 15px;
    padding: 25px;
    text-align: center;
    margin-bottom: 25px;
}
.header-painel img {
    width: 80px;
    border-radius: 50%;
    background: #fff;
    padding: 5px;
    margin-bottom: 10px;
}
.btn-toggle-theme {
    position: absolute;
    top: 20px;
    right: 20px;
    border: none;
    background: none;
    color: #fff;
    font-size: 1.5rem;
    cursor: pointer;
}

.painel-card {
    background-color: var(--cor-card-fundo);
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    padding: 25px;
    text-align: center;
    transition: 0.3s;
    border:1px solid var(--cor-borda);
}
.painel-card:hover {
    transform: translateY(-4px);
    background-color: var(--cor-link-hover);
    color: #fff;
}
.painel-card i { font-size: 2rem; margin-bottom: 10px; }
.footer { text-align: center; margin-top: 30px; color: #888; }
</style>
</head>

<body>
    <!-- Cabeçalho -->
    <div class="container position-relative">
        <div class="header-painel">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="avatar">
            
    <h4><marquee class="dhr-marquee" direction="left">Seja Bem Vindo(a), <?= htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8') ?></marquee></h4>        
    
    <!--<h4>BEM-VINDO(A), <?= htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8') ?> </h4>-->
            <span class="badge bg-light text-dark"><?= htmlspecialchars(ucfirst($tipo), ENT_QUOTES, 'UTF-8') ?></span>
            <!--<button class="btn-toggle-theme" id="btn-toggle-theme" title="Alternar tema">
                <i class="fa-solid fa-moon"></i>
            </button> -->
        </div>
    </div>

    <div class="container">
        <div class="row g-3">

            <!-- Status Usuários online -->
            <div class="col-6 col-md-3">
            <!--    <a href="#">
                    <div class="painel-card">
                        <i class="fa-solid fa-signal text-success"></i>
                        <h6>Online (<span id="usuarios-online"><?= $usuariosOnline ?></span>)</h6>
                    </div>
                </a>-->
            </div>

            <!-- Total de usuários -->
            <div class="col-6 col-md-3">
            <!--    <a href="#">
                    <div class="painel-card">
                        <i class="fa-solid fa-users text-info"></i>
                        <h6>Total Usuários (<?= $totalUsuarios ?>)</h6>
                    </div>
                </a> -->
            </div>

            <!-- Criar Cadastro -->
            <div class="col-6 col-md-3">
                <a href="/radio/indexz.php">
                    <div class="painel-card">
                        <i class="fa-solid fa-user-gear text-info"></i>
                        <h6>Musicas</h6>
                    </div>
                </a>
            </div>

            <!-- Mudar Senha -->
            <div class="col-6 col-md-3">
                <a href="/radio/radios.php">
                    <div class="painel-card">
                        <i class="fa-solid fa-radio text-warning"></i>
                        <h6>Rádios </h6>
                    </div>
                </a>
            </div>

            <!-- Painel Tokens -->
            <div class="col-6 col-md-3">
               <a href="admin/painel_token.php">
                    <div class="painel-card">
                        <i class="fa-solid fa-key text-info"></i>
                        <h6>Painel Tokens (<?= $totalTokens ?>)</h6>
                    </div>
                </a>
            </div>

            <!-- Contas SSH -->
            <div class="col-6 col-md-3">
               <a href="contas_ssh.php">
                    <div class="painel-card">
                        <i class="fa-solid fa-shield-halved text-success"></i>
                        <h6>Contas SSH</h6>
                    </div>
                </a>
            </div>

            <!-- Servidores -->
            <div class="col-6 col-md-3">
                <a href="servidores.php">
                    <div class="painel-card">
                        <i class="fa-solid fa-server text-warning"></i>
                        <h6>Servidores</h6>
                    </div>
                </a>
            </div>

            <!-- Tickets -->
            <div class="col-6 col-md-3">
                <a href="tickets.php">
                    <div class="painel-card">
                        <i class="fa-solid fa-ticket text-primary"></i>
                        <h6>Tickets</h6>
                    </div>
                </a>
            </div>

            <!-- Notificações -->
            <div class="col-6 col-md-3">
                <a href="radio/radios.php">
                    <div class="painel-card">
                        <i class="fa-solid fa-bell text-danger"></i>
                        <h6>Notificações</h6>
                    </div>
                </a>
            </div>

            <!-- Sair -->
            <div class="col-6 col-md-3">
                <a href="logout.php">
                    <div class="painel-card">
                        <i class="fa-solid fa-power-off text-danger"></i>
                        <h6>Sair</h6>
                    </div>
                </a>
            </div>
        </div>

        <div class="footer">
            <p>© <?= date('Y') ?> CYBERCOARI</p>
        </div>
    </div>

  <script src="https://cybercoari.com.br/cyber/js/sweetalert2.all.min.js"></script>
  <script src="/assets/js/app.js" defer></script>
  <script src="/assets/js/painel.js" defer></script>
</body>
</html>