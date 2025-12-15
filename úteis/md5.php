<?php
$resultado = null;
$erro = null;
$progresso = null;
$posicaoHoje = null;
$hash = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $texto = $_POST['texto'] ?? '';

    if ($texto) {
        try {
            // Gerar hash MD5
            $hash = md5($texto);
            
            $resultado = [
                'texto' => htmlspecialchars($texto),
                'hash' => $hash,
                'timestamp' => date('d/m/Y H:i:s')
            ];

        } catch (Exception $e) {
            $erro = "Erro ao gerar hash MD5.";
        }
    } else {
        $erro = "Por favor, digite um texto para gerar o hash.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gerador de Hash MD5</title>
  <?php
    $title = "Cybercoari - Gerador de MD5";
    include __DIR__ . "/../includes/header.php";
    include __DIR__ . "/../includes/cdn.php";
  ?>
  <link rel="stylesheet" href="/assets/css/darkmode.css?v=5">
  <style>
    .container { max-width: 800px; margin-top: 30px; }
    .card { border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .hash-result { 
        background: #f8f9fa; 
        border: 1px dashed #dee2e6;
        padding: 15px;
        border-radius: 6px;
        font-family: monospace;
        word-break: break-all;
        margin: 15px 0;
    }
    .dark-mode .hash-result {
        background: #2d3748;
        border-color: #4a5568;
        color: #e2e8f0;
    }
    .copy-btn { cursor: pointer; transition: all 0.3s; }
    .copy-btn:hover { transform: scale(1.05); }
  </style>
</head>
<body class="<?= $tema === 'escuro' ? 'dark-mode bg-dark text-white' : 'bg-light' ?>">

  <div class="container">
    <a href="/painel.php" class="btn btn-outline-primary mb-3">
      <i class="bi bi-arrow-left-circle"></i> Voltar para o Painel
    </a>

    <h2 class="mb-4"><i class="bi bi-shield-lock"></i> Gerador de Hash MD5</h2>

    <!-- Formulário -->
    <form method="post" class="mb-4">
      <div class="mb-3">
        <label for="texto" class="form-label">Texto para gerar hash MD5:</label>
        <textarea name="texto" id="texto" 
                  class="form-control" 
                  rows="4"
                  placeholder="Digite o texto que deseja converter para MD5..."
                  required><?= htmlspecialchars($_POST['texto'] ?? '') ?></textarea>
        <div class="form-text">O hash MD5 será gerado a partir do texto digitado.</div>
      </div>
      <button type="submit" class="btn btn-primary w-100 mb-2">
        <i class="bi bi-hash"></i> Gerar Hash MD5
      </button>
    </form>

    <!-- Mensagens de erro -->
    <?php if ($erro): ?>
      <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle"></i> <?= $erro ?>
      </div>
    <?php endif; ?>

    <!-- Resultado -->
    <?php if ($resultado): ?>
      <div class="card p-3 mb-4 <?= $tema === 'escuro' ? 'bg-dark text-white' : 'bg-white' ?>">
        <h4 class="mb-3"><i class="bi bi-file-earmark-text"></i> Resultado</h4>
        
        <div class="mb-3">
          <strong>Texto original:</strong>
          <div class="hash-result"><?= $resultado['texto'] ?></div>
        </div>

        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center">
            <strong>Hash MD5:</strong>
            <button class="btn btn-sm btn-outline-secondary copy-btn" onclick="copiarHash()">
              <i class="bi bi-clipboard"></i> Copiar
            </button>
          </div>
          <div class="hash-result" id="hash-result"><?= $resultado['hash'] ?></div>
        </div>

        <div class="text-muted small">
          <i class="bi bi-clock"></i> Gerado em: <?= $resultado['timestamp'] ?>
        </div>
      </div>

      <!-- SweetAlert + Som -->
      <audio id="sucesso" src="https://cybercoari.com.br/cyber/audio/sucesso.mp3" autoplay></audio>
      <script>
        // Função para copiar hash
        function copiarHash() {
          const hash = document.getElementById('hash-result').textContent;
          navigator.clipboard.writeText(hash).then(() => {
            // Feedback visual
            const btn = document.querySelector('.copy-btn');
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check2"></i> Copiado!';
            btn.classList.remove('btn-outline-secondary');
            btn.classList.add('btn-success');
            
            setTimeout(() => {
              btn.innerHTML = originalHtml;
              btn.classList.remove('btn-success');
              btn.classList.add('btn-outline-secondary');
            }, 2000);
          });
        }
        
        // Alert de sucesso
        setTimeout(() => {
          Swal.fire({
            icon: 'success',
            title: 'Hash MD5 Gerado!',
            html: 'Hash MD5 gerado com sucesso!',
            timer: 3000,
            showConfirmButton: false
          });
        }, 500);
      </script>
    <?php endif; ?>
  </div>

  <?php include __DIR__ . "/../includes/footer.php"; ?>
</body>
</html>