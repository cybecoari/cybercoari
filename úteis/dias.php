<?php
$resultado = null;
$erro = null;
$progresso = null;
$posicaoHoje = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inicio = $_POST['data_inicio'] ?? '';
    $final = $_POST['data_final'] ?? '';

    if ($inicio && $final) {
        try {
            $dataInicio = new DateTime($inicio);
            $dataFinal = new DateTime($final);

            if ($dataFinal < $dataInicio) {
                $erro = "A data final não pode ser menor que a data inicial.";
            } else {
                $diferenca = $dataInicio->diff($dataFinal);
                $resultado = [
                    'inicio' => $dataInicio->format('d/m/Y'),
                    'final' => $dataFinal->format('d/m/Y'),
                    'dias' => $diferenca->days,
                    'anos' => $diferenca->y,
                    'meses' => $diferenca->m,
                    'dias_restantes' => $diferenca->d
                ];

                // Progresso
                $hoje = new DateTime();
                if ($hoje < $dataInicio) {
                    $progresso = 0;
                } elseif ($hoje > $dataFinal) {
                    $progresso = 100;
                } else {
                    $diasTotal = $diferenca->days;
                    $diasPassados = $dataInicio->diff($hoje)->days;
                    $progresso = round(($diasPassados / $diasTotal) * 100);
                }

                // Posição do marcador "Hoje"
                if ($progresso > 0 && $progresso < 100) {
                    $posicaoHoje = $progresso;
                }
            }
        } catch (Exception $e) {
            $erro = "Erro ao processar datas.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contador de Dias</title>
  <?php
    $title = "Cybercoari - Contador de Dias";
    include __DIR__ . "/../includes/header.php";
    include __DIR__ . "/../includes/cdn.php";
  ?>
  <link rel="stylesheet" href="/assets/css/darkmode.css?v=5">
  <style>
    .container { max-width: 800px; margin-top: 30px; }
    .card { border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .progress { height: 30px; font-weight: bold; font-size: 14px; }
    .progress-bar { transition: width 1s ease-in-out; }
    .timeline {
      position: relative;
      margin: 40px 0 20px;
      height: 4px;
      background: #dee2e6;
      border-radius: 2px;
    }
    .timeline .marcador {
      position: absolute;
      top: -10px;
      transform: translateX(-50%);
      text-align: center;
    }
    .timeline .marcador span {
      display: block;
      font-size: 12px;
      margin-top: 20px;
    }
    .marcador .dot {
      width: 14px;
      height: 14px;
      border-radius: 50%;
      display: inline-block;
      border: 2px solid #fff;
      box-shadow: 0 0 4px rgba(0,0,0,0.3);
    }
    .inicio .dot { background: #198754; }
    .fim .dot { background: #dc3545; }
    .hoje .dot { background: #ffc107; }
  </style>
</head>
<body class="<?= $tema === 'escuro' ? 'dark-mode bg-dark text-white' : 'bg-light' ?>">

  <div class="container">
    <a href="/painel.php" class="btn btn-outline-primary mb-3">
      <i class="bi bi-arrow-left-circle"></i> Voltar para o Painel
    </a>

    <h2 class="mb-4"><i class="bi bi-calendar-range"></i> Contador de Dias</h2>

    <!-- Formulário -->
    <form method="post" class="mb-4">
      <div class="mb-3">
        <label for="data_inicio" class="form-label">Data de Início:</label>
        <input type="date" name="data_inicio" id="data_inicio" 
               class="form-control" required 
               value="<?= htmlspecialchars($_POST['data_inicio'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label for="data_final" class="form-label">Data Final:</label>
        <input type="date" name="data_final" id="data_final" 
               class="form-control" required 
               value="<?= htmlspecialchars($_POST['data_final'] ?? '') ?>">
      </div>
      <button type="submit" class="btn btn-primary w-100 mb-2">
        <i class="bi bi-calculator"></i> Calcular
      </button>
    </form>

    <!-- Mensagens -->
    <?php if ($erro): ?>
      <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle"></i> <?= $erro ?>
      </div>
    <?php endif; ?>

    <?php if ($resultado): ?>
      <div class="card p-3 mb-4 <?= $tema === 'escuro' ? 'bg-dark text-white' : 'bg-white' ?>">
        <h4 class="mb-3"><i class="bi bi-clock-history"></i> Resultado</h4>
        <p><strong>De:</strong> <?= $resultado['inicio'] ?> <strong>até:</strong> <?= $resultado['final'] ?></p>
        <p><strong>Total:</strong> <?= $resultado['dias'] ?> dias</p>
        <p>Ou: <?= $resultado['anos'] ?> anos, <?= $resultado['meses'] ?> meses e <?= $resultado['dias_restantes'] ?> dias</p>

        <!-- Barra de Progresso -->
        <?php if ($progresso !== null): ?>
          <div class="my-3">
            <label><i class="bi bi-activity"></i> Progresso do Período:</label>
            <div class="progress">
              <div class="progress-bar <?= $progresso == 100 ? 'bg-danger' : 'bg-success' ?>" 
                   role="progressbar" 
                   style="width: <?= $progresso ?>%;" 
                   aria-valuenow="<?= $progresso ?>" aria-valuemin="0" aria-valuemax="100">
                <?= $progresso ?>%
              </div>
            </div>
          </div>

          <!-- Linha do Tempo -->
          <div class="timeline">
            <div class="marcador inicio" style="left:0%">
              <div class="dot"></div>
              <span><?= $resultado['inicio'] ?></span>
            </div>
            <?php if ($posicaoHoje): ?>
              <div class="marcador hoje" style="left:<?= $posicaoHoje ?>%">
                <div class="dot"></div>
                <span>Hoje</span>
              </div>
            <?php endif; ?>
            <div class="marcador fim" style="left:100%">
              <div class="dot"></div>
              <span><?= $resultado['final'] ?></span>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- SweetAlert + Som -->
      <audio id="sucesso" src="https://cybercoari.com.br/cyber/audio/sucesso.mp3" autoplay></audio>
      <script>
        setTimeout(() => {
          Swal.fire({
            icon: 'success',
            title: 'Cálculo Concluído!',
            html: '<b><?= $resultado['dias'] ?></b> dias entre as datas!',
            timer: 3000,
            showConfirmButton: false
          });
        }, 500);
      </script>
    <?php endif; ?>
  </div>

  <!-- Rodapé -->


  <?php include __DIR__ . "/../includes/footer.php"; ?>
</body>
</html>