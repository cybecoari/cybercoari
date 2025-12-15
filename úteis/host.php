<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Consulta IP / Host</title>
  <?php
    $title = "Cybercoari - Consulta IP/Host";
    include __DIR__ . "/../includes/header.php";
    include __DIR__ . "/../includes/cdn.php";
  ?>
  <link rel="stylesheet" href="/assets/css/darkmode.css?v=5">
  <style>
    .container { max-width: 700px; margin-top: 30px; }
    .card { border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
  </style>
</head>
<body class="<?= $tema === 'escuro' ? 'dark-mode bg-dark text-white' : 'bg-light' ?>">

  <div class="container">
    <a href="/painel.php" class="btn btn-outline-primary mb-3">
      <i class="bi bi-arrow-left-circle"></i> Voltar para o Painel
    </a>

    <h2 class="mb-4"><i class="bi bi-globe2"></i> Consulta de IP / Host</h2>

    <!-- Formulário -->
    <form method="post" class="mb-4">
      <div class="mb-3">
        <input type="text" name="host" id="host" class="form-control"
               placeholder="Ex: google.com.br" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-search"></i> Consultar
      </button>
    </form>

    <!-- Resultado -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
      <?php
        $host = trim($_POST['host']);
        $ip = gethostbyname($host);
      ?>
      <?php if (filter_var($ip, FILTER_VALIDATE_IP)): ?>
        <?php
          $ping = @shell_exec("ping -c 1 $ip");
          $status = (strpos($ping, '1 received') !== false) ? 'Online' : 'Offline';

          $api = @file_get_contents("http://ip-api.com/json/$ip");
          $dados = json_decode($api, true);

          $pais = $dados['country'] ?? 'Desconhecido';
          $org = $dados['org'] ?? 'Desconhecido';
        ?>
        <div class="card p-3 mb-4 <?= $tema === 'escuro' ? 'bg-dark text-white' : 'bg-white' ?>">
          <h4 class="mb-3"><i class="bi bi-clipboard-data"></i> Resultado da Consulta</h4>
          <p><i class="bi bi-globe"></i> <strong>Host:</strong> <?= htmlspecialchars($host) ?></p>
          <p><i class="bi bi-cpu"></i> <strong>IP:</strong> <?= htmlspecialchars($ip) ?></p>
          <p><i class="bi bi-wifi"></i> <strong>Status:</strong> 
            <span class="<?= $status === 'Online' ? 'text-success' : 'text-danger' ?>">
              <?= $status ?>
            </span>
          </p>
          <p><i class="bi bi-geo-alt"></i> <strong>País:</strong> <?= htmlspecialchars($pais) ?></p>
          <p><i class="bi bi-building"></i> <strong>Data Center:</strong> <?= htmlspecialchars($org) ?></p>
        </div>
      <?php else: ?>
        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i> Domínio inválido.</div>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <!-- Rodapé -->
  <?php 
    $anoAtual = date("Y");
    $versaoSistema = "1.0";
    $usuarioNome = $_SESSION['usuario_nome'] ?? "Sistema";
  ?>
  <footer class="text-center mt-4 py-3 border-top">
    <p class="mb-1">
      &copy; <?= $anoAtual ?> - <?= htmlspecialchars($usuarioNome) ?> | 
      Versão <?= $versaoSistema ?>
    </p>
  </footer>

  <?php include __DIR__ . "/../includes/footer.php"; ?>
</body>
</html>