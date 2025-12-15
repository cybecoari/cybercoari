<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../config/funcoes.php';
require_once __DIR__ . '/../config/debug.php';

// garante login e define tema ANTES de qualquer saída
checkLogin();
$usuario = getUsuario($pdo);
$tema = ($_SESSION['tema'] ?? 'claro') === 'escuro' ? 'escuro' : 'claro';

// Inclui header (apenas head; verifique se header.php NÃO abre <body>)
$title = "Consulta de IP por Domínio";
include __DIR__ . "/../includes/header.php";
?>
<!-- Certifique-se de que header.php NÃO já abriu <body> -->
<link rel="stylesheet" href="/assets/css/darkmode.css?v=7"> <!-- seu darkmode -->
</head>
<body class="<?= $tema === 'escuro' ? 'dark-mode bg-dark text-white' : 'bg-light text-dark' ?>">
  <div class="container py-4">
    <h2><i class="bi bi-search"></i> Consulta de IP por Domínio</h2>

    <div class="my-3">
      <input type="text" id="domain" class="form-control mb-3" placeholder="Digite um domínio (ex: google.com)" autocomplete="off">

      <div class="d-grid mb-2">
        <button class="btn btn-primary" onclick="consultarIP()"><i class="bi bi-search"></i> Consultar</button>
      </div>

      <div class="d-grid">
        <a href="/painel.php" class="btn btn-secondary"><i class="bi bi-speedometer2"></i> Voltar</a>
      </div>
    </div>

    <div id="result"></div>
  </div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
</body>
</html>