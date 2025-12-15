<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Conversor IPv4 ↔ IPv6</title>
  <?php 
    $title = "Cybercoari - Conversor IPv4 ↔ IPv6";
    include __DIR__ . "/../includes/header.php"; 
    include __DIR__ . "/../includes/cdn.php"; 
  ?>
  <!-- Darkmode CSS -->
  <link rel="stylesheet" href="/assets/css/darkmode.css?v=5">
  <style>
    .container { max-width: 800px; margin-top: 30px; }
    .back-btn {
      background-color: var(--primary-color);
      color: white;
      padding: 10px 20px;
      font-size: 14px;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 20px;
      transition: background-color 0.3s;
    }
    .back-btn:hover { background-color: #3a5bef; }
    .conversion-section { margin-bottom: 40px; }
    .conversion-section h3 { margin-bottom: 15px; }
    .history { margin-top: 40px; }
    .history-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 6px;
      margin-bottom: 10px;
    }
    .copy-btn {
      background: none;
      border: none;
      color: var(--primary-color);
      font-size: 18px;
      cursor: pointer;
    }
  </style>
</head>
<body class="<?= $tema === 'escuro' ? 'dark-mode bg-dark text-white' : 'bg-light' ?> py-4">
  <div class="container">
    <a href="/painel.php" class="back-btn"><i class="bi bi-arrow-left-circle"></i> Voltar para o Painel</a>

    <h2 class="mb-4"><i class="bi bi-diagram-3"></i> Conversor IPv4 ↔ IPv6</h2>

    <!-- IPv4 para IPv6 -->
    <div class="conversion-section">
      <h3><i class="bi bi-arrow-down"></i> IPv4 para IPv6</h3>
      <div class="mb-3">
        <input type="text" id="ipv4" class="form-control" placeholder="Digite o IPv4 (ex: 192.168.0.1)">
      </div>
      <div>
        <button class="btn btn-primary w-100" onclick="convertIPv4ToIPv6()">
          <i class="bi bi-arrow-right-circle"></i> Converter
        </button>
      </div>
    </div>

    <!-- IPv6 para IPv4 -->
    <div class="conversion-section">
      <h3><i class="bi bi-arrow-up"></i> IPv6 para IPv4</h3>
      <div class="mb-3">
        <input type="text" id="ipv6" class="form-control" placeholder="Digite o IPv6 mapeado (ex: ::ffff:c0a8:0001)">
      </div>
      <div>
        <button class="btn btn-primary w-100" onclick="convertIPv6ToIPv4()">
          <i class="bi bi-arrow-left-circle"></i> Converter
        </button>
      </div>
    </div>

    <!-- Explicação -->
    <div class="explanation <?= $tema === 'escuro' ? 'bg-dark text-white' : 'bg-light' ?> p-3 rounded">
      <h4><i class="bi bi-info-circle"></i> Como funciona?</h4>
      <p><strong>IPv4 → IPv6:</strong> Converte endereços IPv4 em IPv6 mapeados no formato <code>::ffff:xxxx:xxxx</code>.</p>
      <p><strong>IPv6 → IPv4:</strong> Converte endereços IPv6 mapeados de volta para IPv4.</p>
    </div>

    <!-- Histórico -->
    <div class="history">
      <h3><i class="bi bi-clock-history"></i> Histórico</h3>
      <div id="history-list"></div>
    </div>
  </div>

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

  <script>
    let conversionHistory = JSON.parse(localStorage.getItem('ipConversionHistory')) || [];

    function updateHistory() {
      const historyList = $('#history-list');
      historyList.empty();
      if (conversionHistory.length === 0) {
        historyList.append('<p>Nenhuma conversão realizada ainda.</p>');
        return;
      }
      conversionHistory.slice(0, 5).forEach(item => {
        historyList.append(`
          <div class="history-item">
            <div>
              <strong>${item.from}</strong> → <code>${item.to}</code> 
              <small>(${item.type})</small>
            </div>
            <button class="copy-btn" onclick="copyToClipboard('${item.to}')">
              <i class="bi bi-clipboard"></i>
            </button>
          </div>
        `);
      });
    }

    function convertIPv4ToIPv6() {
      const ipv4 = $('#ipv4').val().trim();
      const regex = /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/;
      const match = ipv4.match(regex);
      if (!match || match.slice(1).some(oct => (oct < 0 || oct > 255))) {
        playError();
        Swal.fire({ icon: 'error', title: 'Endereço inválido', text: 'Digite um IPv4 válido (ex: 192.168.0.1)' });
        return;
      }
      const [_, a, b, c, d] = match;
      const hex1 = ((+a << 8) + +b).toString(16).padStart(4, '0');
      const hex2 = ((+c << 8) + +d).toString(16).padStart(4, '0');
      const ipv6 = `::ffff:${hex1}:${hex2}`;
      conversionHistory.unshift({ from: ipv4, to: ipv6, type: 'IPv4 → IPv6', timestamp: new Date().toISOString() });
      localStorage.setItem('ipConversionHistory', JSON.stringify(conversionHistory));
      updateHistory();
      playSuccess();
      Swal.fire({ icon: 'success', title: 'Conversão realizada!', html: `<p><strong>IPv4:</strong> ${ipv4}</p><p><strong>IPv6:</strong> <code>${ipv6}</code></p>` });
    }

    function convertIPv6ToIPv4() {
      const ipv6 = $('#ipv6').val().trim().toLowerCase();
      const regex = /^::ffff:([0-9a-f]{1,4}):([0-9a-f]{1,4})$/;
      const match = ipv6.match(regex);
      if (!match) {
        playError();
        Swal.fire({ icon: 'error', title: 'Endereço inválido', text: 'Digite um IPv6 válido (ex: ::ffff:c0a8:0001)' });
        return;
      }
      const [_, hex1, hex2] = match;
      const dec1 = parseInt(hex1, 16);
      const dec2 = parseInt(hex2, 16);
      const ipv4 = `${(dec1 >> 8) & 0xff}.${dec1 & 0xff}.${(dec2 >> 8) & 0xff}.${dec2 & 0xff}`;
      conversionHistory.unshift({ from: ipv6, to: ipv4, type: 'IPv6 → IPv4', timestamp: new Date().toISOString() });
      localStorage.setItem('ipConversionHistory', JSON.stringify(conversionHistory));
      updateHistory();
      playSuccess();
      Swal.fire({ icon: 'success', title: 'Conversão realizada!', html: `<p><strong>IPv6:</strong> ${ipv6}</p><p><strong>IPv4:</strong> <code>${ipv4}</code></p>` });
    }

    function copyToClipboard(text) {
      navigator.clipboard.writeText(text).then(() => {
        playCopy();
        Swal.fire({ position: 'top-end', icon: 'success', title: 'Copiado!', showConfirmButton: false, timer: 1500 });
      });
    }

    $(document).ready(updateHistory);
  </script>
</body>
</html>