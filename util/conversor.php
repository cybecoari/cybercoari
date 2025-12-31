<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/funcoes.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/cyber.php");
isLogged($sid);


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Conversor de IP - Ferramenta Útil</title>
  
  <style>
    :root {
      --primary-color: #443C68;
      --secondary-color: #66347F;
      --accent-color: #62CDFF;
      --success-color: #28a745;
      --dark-color: #212529;
    }
    
    body {
      background: #16213e;
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
      color: white;
    }
    
    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    
    .converter-container {
      max-width: 800px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
    }
    
    .header {
      text-align: center;
      margin-bottom: 30px;
    }
    
    .header h1 {
      color: var(--primary-color);
      font-weight: 700;
      margin-bottom: 10px;
      font-size: 2.5rem;
    }
    
    .header p {
      color: #666;
      font-size: 1.1rem;
    }
    
    .converter-card {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      border-radius: 15px;
      padding: 25px;
      margin-bottom: 25px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .converter-title {
      color: var(--primary-color);
      font-weight: 600;
      margin-bottom: 20px;
      font-size: 1.3rem;
      display: flex;
      align-items: center;
    }
    
    .converter-title i {
      margin-right: 10px;
      color: var(--secondary-color);
    }
    
    .form-control {
      border-radius: 10px;
      padding: 15px;
      border: 2px solid #e9ecef;
      font-size: 1rem;
      transition: all 0.3s;
    }
    
    .form-control:focus {
      border-color: var(--accent-color);
      box-shadow: 0 0 0 0.2rem rgba(98, 205, 255, 0.25);
    }
    
    .btn-convert {
      background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
      color: white;
      border: none;
      border-radius: 10px;
      padding: 15px 25px;
      font-weight: 600;
      transition: all 0.3s;
      width: 100%;
      margin-top: 15px;
    }
    
    .btn-convert:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(102, 52, 127, 0.3);
    }
    
    .result-box {
      background: white;
      border-radius: 10px;
      padding: 20px;
      margin-top: 20px;
      border: 2px dashed var(--accent-color);
    }
    
    .result-title {
      color: var(--dark-color);
      font-weight: 600;
      margin-bottom: 10px;
      font-size: 1.1rem;
    }
    
    .result-content {
      color: var(--primary-color);
      font-family: 'Courier New', monospace;
      font-size: 1rem;
      word-break: break-all;
    }
    
    .btn-copy {
      background: linear-gradient(45deg, var(--success-color), #1e7e34);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 10px 20px;
      font-weight: 600;
      transition: all 0.3s;
      margin-top: 15px;
      width: 100%;
    }
    
    .btn-copy:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
    
    .home-btn {
      position: fixed;
      width: 60px;
      height: 60px;
      bottom: 20px;
      right: 20px;
      background: white;
      color: var(--primary-color);
      border-radius: 50%;
      text-align: center;
      font-size: 24px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      z-index: 1000;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s;
      text-decoration: none;
    }
    
    .home-btn:hover {
      transform: scale(1.1);
      color: var(--secondary-color);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }
    
    /* Responsividade */
    @media (max-width: 768px) {
      .converter-container {
        padding: 20px;
        margin: 10px;
      }
      
      .header h1 {
        font-size: 2rem;
      }
      
      .converter-card {
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="converter-container">
    <div class="header">
      <h1><i class="fas fa-exchange-alt"></i> CONVERSOR DE IP</h1>
      <p>Ferramenta útil para conversão entre IPv4 e IPv6</p>
    </div>
    
    <!-- Conversor IPv4 para IPv6 -->
    <div class="converter-card">
      <h3 class="converter-title">
        <i class="fas fa-arrow-right"></i> CONVERSOR DE IPv4 PARA IPv6
      </h3>
      
      <div class="mb-3">
        <label for="ip" class="form-label">DIGITE O ENDEREÇO IPv4:</label>
        <input type="text" id="ip" name="ip" placeholder="Exemplo: 192.168.1.1" 
               class="form-control" required>
      </div>
      
      <button onclick="convertIP()" class="btn-convert">
        <i class="fas fa-sync-alt"></i> CONVERTER
      </button>
      
      <div id="result" class="result-box" style="display: none;">
        <div class="result-title">RESULTADO:</div>
        <div class="result-content" id="resultContent"></div>
      </div>
      
      <button id="copyButton" onclick="copyResult()" class="btn-copy" style="display: none;">
        <i class="fas fa-copy"></i> COPIAR RESULTADO
      </button>
    </div>
    
    <!-- Conversor IPv6 para IPv4 -->
    <div class="converter-card">
      <h3 class="converter-title">
        <i class="fas fa-arrow-left"></i> CONVERSOR DE IPv6 PARA IPv4
      </h3>
      
      <div class="mb-3">
        <label for="ipv6" class="form-label">DIGITE O ENDEREÇO IPv6:</label>
        <input type="text" id="ipv6" name="ipv6" 
               placeholder="Exemplo: ::FFFF:c0a8:0101" 
               class="form-control" required>
      </div>
      
      <button onclick="convertIPv6()" class="btn-convert">
        <i class="fas fa-sync-alt"></i> CONVERTER
      </button>
      
      <div id="resultIPv6" class="result-box" style="display: none;">
        <div class="result-title">RESULTADO:</div>
        <div class="result-content" id="resultContentIPv6"></div>
      </div>
      
      <button id="copyButtonIPv6" onclick="copyResultIPv6()" class="btn-copy" style="display: none;">
        <i class="fas fa-copy"></i> COPIAR RESULTADO
      </button>
    </div>
  </div>
  
  <!-- Botão Home -->
  <a href="/" class="home-btn">
    <i class="fas fa-home"></i>
  </a>

  <!-- Toastify JS -->
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  
  <script>
    function convertIP() {
      var ip = document.getElementById("ip").value;
      
      if (!ip) {
        showToast("Por favor, digite um endereço IPv4 válido.", "error");
        return;
      }
      
      // Validar formato IPv4
      var ipv4Pattern = /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/;
      var match = ip.match(ipv4Pattern);
      
      if (!match) {
        showToast("Formato de IPv4 inválido.", "error");
        return;
      }
      
      // Validar cada octeto
      for (var i = 1; i <= 4; i++) {
        var octet = parseInt(match[i]);
        if (octet > 255) {
          showToast("Valor de octeto inválido (deve ser entre 0 e 255).", "error");
          return;
        }
      }
      
      // Converter para IPv6
      var ipv6 = "::FFFF:" + 
                 parseInt(match[1], 10).toString(16).padStart(2, '0') +
                 parseInt(match[2], 10).toString(16).padStart(2, '0') + ":" +
                 parseInt(match[3], 10).toString(16).padStart(2, '0') +
                 parseInt(match[4], 10).toString(16).padStart(2, '0');
      
      // Formatar para melhor visualização
      var formattedIPv6 = ipv6.toUpperCase();
      
      document.getElementById("resultContent").innerHTML = 
        "<strong>IPv4:</strong> " + ip + "<br>" +
        "<strong>IPv6 (mapeado):</strong> " + formattedIPv6;
      
      document.getElementById("result").style.display = "block";
      document.getElementById("copyButton").style.display = "block";
      
      showToast("Conversão realizada com sucesso!", "success");
    }

    function copyResult() {
      var resultText = document.getElementById("resultContent").innerText;
      copyToClipboard(resultText);
      showToast("Resultado copiado para a área de transferência!", "success");
    }

    function convertIPv6() {
      var ipv6Input = document.getElementById("ipv6").value.trim();
      
      if (!ipv6Input) {
        showToast("Por favor, digite um endereço IPv6 válido.", "error");
        return;
      }
      
      // Expandir endereços IPv6 abreviados
      var expandedIPv6 = expandIPv6(ipv6Input);
      if (!expandedIPv6) {
        showToast("Formato de IPv6 inválido.", "error");
        return;
      }
      
      // Verificar se é um IPv4 mapeado em IPv6 (::FFFF:xxxx:xxxx)
      if (expandedIPv6.startsWith("0000:0000:0000:0000:0000:FFFF:") || 
          expandedIPv6.startsWith("0000:0000:0000:0000:0000:ffff:")) {
        
        // Extrair os últimos 32 bits (parte IPv4)
        var parts = expandedIPv6.split(':');
        var hexPart1 = parts[6] || '';
        var hexPart2 = parts[7] || '';
        
        if (hexPart1.length === 4 && hexPart2.length === 4) {
          // Converter os dois últimos grupos hexadecimais para IPv4
          var ipv4 = 
            parseInt(hexPart1.substring(0, 2), 16) + "." +
            parseInt(hexPart1.substring(2, 4), 16) + "." +
            parseInt(hexPart2.substring(0, 2), 16) + "." +
            parseInt(hexPart2.substring(2, 4), 16);
          
          document.getElementById("resultContentIPv6").innerHTML = 
            "<strong>IPv6:</strong> " + ipv6Input + "<br>" +
            "<strong>IPv4 (mapeado):</strong> " + ipv4;
          
          document.getElementById("resultIPv6").style.display = "block";
          document.getElementById("copyButtonIPv6").style.display = "block";
          
          showToast("Conversão realizada com sucesso!", "success");
          return;
        }
      }
      
      showToast("O endereço IPv6 não é um IPv4 mapeado válido (formato ::FFFF:xxxx:xxxx).", "error");
    }

    // Função para expandir endereços IPv6 abreviados
    function expandIPv6(ipv6) {
      // Verificar se há uma abreviação com ::
      if (ipv6.includes('::')) {
        var parts = ipv6.split('::');
        var leftParts = parts[0] ? parts[0].split(':').filter(Boolean) : [];
        var rightParts = parts[1] ? parts[1].split(':').filter(Boolean) : [];
        
        var missingParts = 8 - (leftParts.length + rightParts.length);
        if (missingParts < 0) {
          return null; // Formato inválido
        }
        
        // Preencher com zeros os grupos faltantes
        var zeros = Array(missingParts).fill('0000');
        var allParts = leftParts.concat(zeros).concat(rightParts);
        
        // Preencher cada grupo com zeros à esquerda se necessário
        for (var i = 0; i < 8; i++) {
          allParts[i] = allParts[i].padStart(4, '0');
        }
        
        return allParts.join(':');
      } else {
        // Sem abreviação ::, apenas garantir que cada parte tenha 4 dígitos
        var parts = ipv6.split(':');
        if (parts.length !== 8) return null;
        
        for (var i = 0; i < 8; i++) {
          parts[i] = parts[i].padStart(4, '0');
        }
        
        return parts.join(':');
      }
    }

    function copyResultIPv6() {
      var resultText = document.getElementById("resultContentIPv6").innerText;
      copyToClipboard(resultText);
      showToast("Resultado copiado para a área de transferência!", "success");
    }

    function copyToClipboard(text) {
      var tempInput = document.createElement("textarea");
      document.body.appendChild(tempInput);
      tempInput.value = text;
      tempInput.select();
      document.execCommand("copy");
      document.body.removeChild(tempInput);
    }

    function showToast(message, type) {
      Toastify({
        text: message,
        duration: 3000,
        gravity: "top",
        position: "center",
        backgroundColor: type === "success" ? "green" : "red",
        stopOnFocus: true
      }).showToast();
    }
  </script>
</body>
</html>