<?php
session_start();

// Tema
$tema = $_SESSION['tema'] ?? 'claro';
$title = "Cybercoari - Painel";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calculadora de IMC</title>

  <?php include __DIR__ . "/../includes/header.php"; ?>
  <?php include __DIR__ . "/../includes/cdn.php"; ?>

  <!-- Bootstrap + Ícones -->
  <link href="https://cybercoari.com.br/cyber/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Darkmode -->
  <link rel="stylesheet" href="/assets/css/darkmode.css?v=7">

  <!-- SweetAlert2 -->
  <script src="https://cybercoari.com.br/cyber/js/sweetalert2.all.min.js"></script>
</head>
<body class="<?= $tema === 'escuro' ? 'dark-mode bg-dark text-white' : 'bg-light text-dark' ?>">

  <div class="container py-4">
    <h1 class="text-center mb-4"><i class="bi bi-calculator"></i> Calculadora de IMC</h1>

    <!-- Formulário -->
    <div class="card shadow-sm <?= $tema === 'escuro' ? 'bg-dark text-light' : 'bg-white' ?>">
      <div class="card-body">
        <div class="mb-3">
          <label for="peso" class="form-label">Peso (kg):</label>
          <input type="number" id="peso" class="form-control" placeholder="Ex: 70" step="0.1" min="20" max="300">
        </div>

        <div class="mb-3">
          <label for="altura" class="form-label">Altura (m):</label>
          <input type="number" id="altura" class="form-control" placeholder="Ex: 1.75" step="0.01" min="1.20" max="2.50">
        </div>

        <button class="btn btn-primary w-100" onclick="calcularIMC()">
          <i class="bi bi-heart-pulse"></i> Calcular IMC
        </button>
      </div>
    </div>

    <!-- Tabela de referência -->
    <div class="mt-4">
      <h4>Tabela de Referência</h4>
      <table class="table table-bordered table-striped <?= $tema === 'escuro' ? 'table-dark' : '' ?>">
        <thead>
          <tr>
            <th>IMC</th>
            <th>Classificação</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>Abaixo de 18,5</td><td>Abaixo do peso</td></tr>
          <tr><td>18,5 - 24,9</td><td>Peso normal</td></tr>
          <tr><td>25 - 29,9</td><td>Sobrepeso</td></tr>
          <tr><td>30 - 34,9</td><td>Obesidade Grau I</td></tr>
          <tr><td>35 - 39,9</td><td>Obesidade Grau II</td></tr>
          <tr><td>Acima de 40</td><td>Obesidade Grau III</td></tr>
        </tbody>
      </table>
    </div>

    <div class="mt-3 text-muted small">
      <p>O IMC (Índice de Massa Corporal) é um cálculo simples que ajuda a identificar se a pessoa está no peso ideal. 
      Ele foi desenvolvido por Lambert Quételet no século XIX e é usado até hoje como referência rápida de saúde.</p>
    </div>
  </div>

  <?php include __DIR__ . "/../includes/footer.php"; ?>

  <script>
    function calcularIMC() {
      const peso = parseFloat(document.getElementById('peso').value);
      const altura = parseFloat(document.getElementById('altura').value);

      if (isNaN(peso) || isNaN(altura) || peso <= 0 || altura <= 0) {
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: 'Por favor, insira valores válidos para peso e altura!'
        });
        return;
      }

      const imc = peso / (altura * altura);
      const imcArredondado = imc.toFixed(1);

      let classificacao = "";
      let cor = "";

      if (imc < 18.5) {
        classificacao = "Abaixo do peso";
        cor = "#3498db";
      } else if (imc < 25) {
        classificacao = "Peso normal";
        cor = "#2ecc71";
      } else if (imc < 30) {
        classificacao = "Sobrepeso";
        cor = "#f39c12";
      } else if (imc < 35) {
        classificacao = "Obesidade Grau I";
        cor = "#e67e22";
      } else if (imc < 40) {
        classificacao = "Obesidade Grau II";
        cor = "#d35400";
      } else {
        classificacao = "Obesidade Grau III";
        cor = "#c0392b";
      }

      Swal.fire({
        title: 'Resultado do IMC',
        html: `<h3>Seu IMC: ${imcArredondado}</h3><p>Classificação: <b>${classificacao}</b></p>`,
        icon: 'info',
        confirmButtonText: 'Fechar',
        background: '<?= $tema === "escuro" ? "#1e1e1e" : "#fff" ?>',
        color: '<?= $tema === "escuro" ? "#fff" : "#000" ?>'
      });
    }
  </script>
</body>
</html>