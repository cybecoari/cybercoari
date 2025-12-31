<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/funcoes.php");
isLogged($sid); 

// Conectar ao banco de dados
try {
    $conn = new PDO("mysql:host=localhost;dbname=cyber_painel", "cyber_painel", "@cybercoari");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

// Processar download
if (isset($_GET['download']) && isset($_GET['app'])) {
    $app_id = $_GET['app'];
    
    // Atualizar contador no banco de dados
    $stmt = $conn->prepare("UPDATE app_downloads SET download_count = download_count + 1 WHERE app_id = ?");
    $stmt->execute([$app_id]);
    
    // Redirecionar para o download real
    $download_urls = [
    'conecta4g' => 'https://cybercoari.com.br/cyber/download/cyber.apk',
    'vpnpremium' => 'https://cybercoari.com.br/cyber/download/vpn-premium.apk',
    'mediaplayer' => 'https://cybercoari.com.br/cyber/download/media-player.apk',
    'filemanager' => 'https://cybercoari.com.br/cyber/download/file-manager.apk',
    'socialplus' => 'https://cybercoari.com.br/cyber/download/social-plus.apk',
    'cleaner' => 'https://cybercoari.com.br/cyber/download/cleaner-pro.apk'
    ];
    
    if (isset($download_urls[$app_id])) {
    header("Location: " . $download_urls[$app_id]);
    exit();
    }
}

// Buscar contadores atuais
$stmt = $conn->query("SELECT app_id, app_name, download_count FROM app_downloads");
$download_counts = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $download_counts[$row['app_id']] = $row;
}

// Usuários online e cadastros
$onlineInfo = getUsuariosOnlineInfo() ?? ['total' => 0];
$usuariosOnline = $onlineInfo['total'];
$totalCadastros = getTotalCadastros();  

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>APK Store - Conecta4G</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <style>
    :root {
      --primary-color: #443C68;
      --secondary-color: #66347F;
      --accent-color: #62CDFF;
      --success-color: #28a745;
      --warning-color: #ffc107;
      --info-color: #17a2b8;
      --danger-color: #dc3545;
      --dark-color: #212529;
    }
    
    body {
      background: #16213e;
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
    }
    /** usuário online e cadastro */
    .numero-online {
        color: #28a745;
        font-weight: bold;
    }
    .numero-cadastros {
        color: #007bff;
        font-weight: bold;
    }
    .corUsuario {
        color: #28a745;
        font-weight: bold;
    }
    p {
      font-size: 20px;
      font-weight: bold;
      color: #000;
      margin: 0.5px 0;
      line-height: 1.3;
    }
    
    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    
    .store-container {
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .store-header {
      text-align: center;
      margin-bottom: 40px;
      padding: 30px;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    
    .store-title {
      font-size: 3rem;
      font-weight: 700;
      color: var(--primary-color);
      margin-bottom: 10px;
    }
    
    .store-subtitle {
      font-size: 1.3rem;
      color: var(--secondary-color);
      margin-bottom: 20px;
    }
    
    .app-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 25px;
      margin-bottom: 40px;
    }
    
    .app-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 25px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
      border: 1px solid rgba(255, 255, 255, 0.2);
      position: relative;
    }
    
    .app-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }
    
    .download-badge {
      position: absolute;
      top: 15px;
      left: 15px;
      background: linear-gradient(45deg, var(--success-color), #1e7e34);
      color: white;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
    }
    
    .app-header {
      text-align: center;
      margin-bottom: 20px;
      margin-top: 10px;
    }
    
    .app-icon {
      width: 80px;
      height: 80px;
      border-radius: 20px;
      margin-bottom: 15px;
      object-fit: cover;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .app-name {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--dark-color);
      margin-bottom: 5px;
    }
    
    .app-version {
      color: #6c757d;
      font-size: 0.9rem;
    }
    
    .app-features {
      list-style: none;
      padding: 0;
      margin-bottom: 25px;
    }
    
    .app-features li {
      padding: 8px 0;
      color: #495057;
      border-bottom: 1px solid #e9ecef;
      display: flex;
      align-items: center;
    }
    
    .app-features li:last-child {
      border-bottom: none;
    }
    
    .app-features li i {
      margin-right: 12px;
      width: 20px;
      text-align: center;
      color: var(--success-color);
    }
    
    .app-info {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      border-radius: 15px;
      padding: 15px;
      margin-bottom: 20px;
    }
    
    .info-item {
      display: flex;
      justify-content: space-between;
      padding: 5px 0;
      color: #495057;
    }
    
    .download-btn {
      background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
      color: white;
      border: none;
      border-radius: 50px;
      padding: 15px 25px;
      font-size: 1rem;
      font-weight: 600;
      width: 100%;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(102, 52, 127, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
    }
    
    .download-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(102, 52, 127, 0.4);
      color: white;
    }
    
    .download-btn i {
      margin-right: 10px;
    }
    
    .category-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
    }
    
    .badge-tools {
      background: linear-gradient(45deg, var(--info-color), #138496);
      color: white;
    }
    
    .badge-social {
      background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
      color: white;
    }
    
    .badge-security {
      background: linear-gradient(45deg, var(--success-color), #1e7e34);
      color: white;
    }
    
    .badge-entertainment {
      background: linear-gradient(45deg, var(--warning-color), #e0a800);
      color: black;
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
      transition: all 0.3s ease;
      text-decoration: none;
    }
    
    .home-btn:hover {
      transform: scale(1.1);
      color: var(--secondary-color);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }
    
    /* Responsividade */
    @media (max-width: 768px) {
      .store-header {
        padding: 20px;
        margin: 10px;
      }
      
      .store-title {
        font-size: 2.2rem;
      }
      
      .app-grid {
        grid-template-columns: 1fr;
      }
      
      .app-card {
        padding: 20px;
      }
    }
  </style>
</head>

<body>
  <div class="store-container">
    <!-- Cabeçalho -->
    <div class="store-header">
    <!--<h1 class="store-title">
    <i class="fas fa-store me-2"></i>APK STORE
    </h1>-->
    
    <center>
        <a href="home.php">
            <img class="mt-3" src="<?= getConfig('logo') ?>" width="<?= getConfig('largura') ?>" height="<?= getConfig('altura') ?>">
        </a><br>
        <p>Bem-vindo(a) <b class="corUsuario"><?= getNickById($uid) ?></b>!</p>

        <p>Online: <span class="numero-online"><?= $usuariosOnline ?></span></p>
        <p>Cadastros: <span class="numero-cadastros"><?= $totalCadastros ?></span></p>
    </center>
    <!-- aqui está -->
    
    <p class="store-subtitle">Downloads de aplicativos premium</p>
    <p class="text-muted">
    <i class="fas fa-shield-alt me-2"></i>Todos os aplicativos são verificados e seguros
    </p>
    </div>

    <!-- Grid de Aplicativos -->
    <div class="app-grid">
    
    <!-- App 1: Conecta4G -->
    <div class="app-card">
    <span class="download-badge">
    <i class="fas fa-download"></i> <?= number_format($download_counts['conecta4g']['download_count']) ?>
    </span>
    <span class="category-badge badge-tools">FERRAMENTAS</span>
    <div class="app-header">
    <img src="https://cybercoari.com.br/cyber/imagens/logo.png" class="app-icon" alt="Conecta4G">
    <h3 class="app-name">Painel Conecta4G</h3>
    <span class="app-version">v2.0</span>
    </div>
        
    <ul class="app-features">
    <li><i class="fas fa-check"></i> Gerenciamento de servidores</li>
    <li><i class="fas fa-check"></i> Configuração de payloads</li>
    <li><i class="fas fa-check"></i> Interface moderna</li>
    <li><i class="fas fa-check"></i> Multi-usuário</li>
        </ul>
        
    <div class="app-info">
    <div class="info-item">
    <span>Tamanho:</span>
    <span>4.19 MB</span>
    </div>
    <div class="info-item">
    <span>Downloads:</span>
    <span><?= number_format($download_counts['conecta4g']['download_count']) ?>+</span>
    </div>
    <div class="info-item">
    <span>Requer:</span>
    <span>Android 8.0+</span>
    </div>
    </div>
        
    <a href="?download=true&app=conecta4g" class="download-btn" onclick="showDownloadProgress('conecta4g')">
    <i class="fas fa-download"></i> BAIXAR APK
    </a>
    </div>

    <!-- App 2: VPN Premium -->
    <div class="app-card">
    <span class="download-badge">
    <i class="fas fa-download"></i> <?= number_format($download_counts['vpnpremium']['download_count']) ?>
    </span>
    <span class="category-badge badge-security">SEGURANÇA</span>
    <div class="app-header">
    <img src="https://img.icons8.com/fluency/96/private2.png" class="app-icon" alt="VPN Premium">
    <h3 class="app-name">CYBER VPN</h3>
    <span class="app-version">v 3</span>
    </div>
        
    <ul class="app-features">
    <li><i class="fas fa-check"></i> Conexão segura</li>
    <li><i class="fas fa-check"></i> Sem limites de dados</li>
    <li><i class="fas fa-check"></i> Servidores globais</li>
    <li><i class="fas fa-check"></i> Zero logs</li>
        </ul>
        
    <div class="app-info">
    <div class="info-item">
    <span>Tamanho:</span>
    <span>4.19 MB</span>
    </div>
    <div class="info-item">
    <span>Downloads:</span>
    <span><?= number_format($download_counts['vpnpremium']['download_count']) ?>+</span>
    </div>
    <div class="info-item">
    <span>Requer:</span>
    <span>Android 7.0+</span>
    </div>
    </div>
        
    <a href="?download=true&app=vpnpremium" class="download-btn" onclick="showDownloadProgress('vpnpremium')">
    <i class="fas fa-download"></i> BAIXAR APK
    </a>
    </div>

      <!-- App 3: Media Player -->
      <div class="app-card">
        <span class="download-badge">
          <i class="fas fa-download"></i> <?= number_format($download_counts['mediaplayer']['download_count']) ?>
        </span>
        <span class="category-badge badge-entertainment">ENTRETENIMENTO</span>
        <div class="app-header">
          <img src="https://img.icons8.com/fluency/96/music.png" class="app-icon" alt="Media Player">
          <h3 class="app-name">Media Player Pro</h3>
          <span class="app-version">v1.5.3</span>
        </div>
        
        <ul class="app-features">
          <li><i class="fas fa-check"></i> Todos os formatos</li>
          <li><i class="fas fa-check"></i> Equalizador 10 bandas</li>
          <li><i class="fas fa-check"></i> Sem anúncios</li>
          <li><i class="fas fa-check"></i> 4K support</li>
        </ul>
        
        <div class="app-info">
          <div class="info-item">
            <span>Tamanho:</span>
            <span>12.4 MB</span>
          </div>
          <div class="info-item">
            <span>Downloads:</span>
            <span><?= number_format($download_counts['mediaplayer']['download_count']) ?>+</span>
          </div>
          <div class="info-item">
            <span>Requer:</span>
            <span>Android 9.0+</span>
          </div>
        </div>
        
        <a href="?download=true&app=mediaplayer" class="download-btn" onclick="showDownloadProgress('mediaplayer')">
          <i class="fas fa-download"></i> BAIXAR APK
        </a>
      </div>

      <!-- App 4: File Manager -->
      <div class="app-card">
        <span class="download-badge">
          <i class="fas fa-download"></i> <?= number_format($download_counts['filemanager']['download_count']) ?>
        </span>
        <span class="category-badge badge-tools">FERRAMENTAS</span>
        <div class="app-header">
          <img src="https://img.icons8.com/fluency/96/folder-inuse.png" class="app-icon" alt="File Manager">
          <h3 class="app-name">File Manager Pro</h3>
          <span class="app-version">v2.1.4</span>
        </div>
        
        <ul class="app-features">
          <li><i class="fas fa-check"></i> Nuvem integrada</li>
          <li><i class="fas fa-check"></i> Compressão ZIP/RAR</li>
          <li><i class="fas fa-check"></i> Root explorer</li>
          <li><i class="fas fa-check"></i> FTP/SSH support</li>
        </ul>
        
        <div class="app-info">
          <div class="info-item">
            <span>Tamanho:</span>
            <span>6.9 MB</span>
          </div>
          <div class="info-item">
            <span>Downloads:</span>
            <span><?= number_format($download_counts['filemanager']['download_count']) ?>+</span>
          </div>
          <div class="info-item">
            <span>Requer:</span>
            <span>Android 8.0+</span>
          </div>
        </div>
        
        <a href="?download=true&app=filemanager" class="download-btn" onclick="showDownloadProgress('filemanager')">
          <i class="fas fa-download"></i> BAIXAR APK
        </a>
      </div>

      <!-- App 5: Social Media -->
      <div class="app-card">
        <span class="download-badge">
          <i class="fas fa-download"></i> <?= number_format($download_counts['socialplus']['download_count']) ?>
        </span>
        <span class="category-badge badge-social">SOCIAL</span>
        <div class="app-header">
          <img src="https://img.icons8.com/fluency/96/instagram-new.png" class="app-icon" alt="Social Plus">
          <h3 class="app-name">Social Plus</h3>
          <span class="app-version">v1.8.2</span>
        </div>
        
        <ul class="app-features">
          <li><i class="fas fa-check"></i> Multi-plataforma</li>
          <li><i class="fas fa-check"></i> Download de mídia</li>
          <li><i class="fas fa-check"></i> Modo escuro</li>
          <li><i class="fas fa-check"></i> Sem anúncios</li>
        </ul>
        
        <div class="app-info">
          <div class="info-item">
            <span>Tamanho:</span>
            <span>18.3 MB</span>
          </div>
          <div class="info-item">
            <span>Downloads:</span>
            <span><?= number_format($download_counts['socialplus']['download_count']) ?>+</span>
          </div>
          <div class="info-item">
            <span>Requer:</span>
            <span>Android 10.0+</span>
          </div>
        </div>
        
        <a href="?download=true&app=socialplus" class="download-btn" onclick="showDownloadProgress('socialplus')">
          <i class="fas fa-download"></i> BAIXAR APK
        </a>
      </div>

      <!-- App 6: Cleaner -->
      <div class="app-card">
        <span class="download-badge">
          <i class="fas fa-download"></i> <?= number_format($download_counts['cleaner']['download_count']) ?>
        </span>
        <span class="category-badge badge-tools">OTIMIZAÇÃO</span>
        <div class="app-header">
          <img src="https://img.icons8.com/fluency/96/cleaning.png" class="app-icon" alt="Cleaner Pro">
          <h3 class="app-name">Cleaner Pro</h3>
          <span class="app-version">v1.3.7</span>
        </div>
        
        <ul class="app-features">
          <li><i class="fas fa-check"></i> Limpeza profunda</li>
          <li><i class="fas fa-check"></i> Boost de performance</li>
          <li><i class="fas fa-check"></i> Economia de bateria</li>
          <li><i class="fas fa-check"></i> Cooler integrado</li>
        </ul>
        
        <div class="app-info">
          <div class="info-item">
            <span>Tamanho:</span>
            <span>7.5 MB</span>
          </div>
          <div class="info-item">
            <span>Downloads:</span>
            <span><?= number_format($download_counts['cleaner']['download_count']) ?>+</span>
          </div>
          <div class="info-item">
            <span>Requer:</span>
            <span>Android 8.0+</span>
          </div>
        </div>
        
        <a href="?download=true&app=cleaner" class="download-btn" onclick="showDownloadProgress('cleaner')">
          <i class="fas fa-download"></i> BAIXAR APK
        </a>
      </div>
    </div>
  </div>

  <!-- Botão Home -->
  <a href="home.php" class="home-btn">
    <i class="fas fa-home"></i>
  </a>

  <script>
    function showDownloadProgress(appId) {
      const button = event.target;
      const originalText = button.innerHTML;
      
      // Simular progresso visual
      button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> PREPARANDO...';
      button.style.opacity = '0.7';
      
    // O download real será iniciado pelo href do link
    // A contagem já é feita automaticamente pelo PHP
    }
    
    // Atualizar contadores a cada 30 segundos
    setInterval(() => {
      window.location.reload();
    }, 30000);
  </script>
</body>
</html>