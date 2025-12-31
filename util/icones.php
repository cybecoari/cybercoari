<?php
//require_once($_SERVER['DOCUMENT_ROOT'] . "/config/funcoes.php");
//isLogged($sid);


// Usuários online e cadastros
//$onlineInfo = getUsuariosOnlineInfo() ?? ['total' => 0];
//$usuariosOnline = $onlineInfo['total'];
//$totalCadastros = getTotalCadastros();

?>

<style>
    .numero-online {
        color: #f0f;
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
        margin: 0.1rem 0;
    }
</style>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galeria de Ícones Font Awesome - Funcional</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
      background: linear-gradient(135deg, #1a2a6c, #b21f1f, #1a2a6c);
      color: #fff;
      min-height: 100vh;
      padding: 20px;
    }
    
    .container {
      max-width: 1400px;
      margin: 0 auto;
    }
    
    header {
      text-align: center;
      padding: 30px 20px;
      margin-bottom: 20px;
    }
    
    h1 {
      font-size: 3.2rem;
      margin-bottom: 15px;
      text-shadow: 0 3px 10px rgba(0,0,0,0.3);
      background: linear-gradient(to right, #ff7e5f, #feb47b);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    
    .subtitle {
      font-size: 1.2rem;
      opacity: 0.9;
      max-width: 700px;
      margin: 0 auto;
      line-height: 1.6;
    }
    
    .controls {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      margin-bottom: 30px;
      padding: 20px;
      background: rgba(255, 255, 255, 0.08);
      border-radius: 15px;
      backdrop-filter: blur(10px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    
    .search-box {
      flex: 1;
      max-width: 500px;
      min-width: 300px;
    }
    
    .search-box input {
      width: 100%;
      padding: 14px 20px;
      border-radius: 50px;
      border: none;
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      color: white;
      font-size: 1.1rem;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
    }
    
    .search-box input:focus {
      outline: none;
      background: rgba(255, 255, 255, 0.25);
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    }
    
    .search-box input::placeholder {
      color: rgba(255, 255, 255, 0.7);
    }
    
    .category-filter {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: center;
    }
    
    .category-btn {
      padding: 10px 20px;
      border-radius: 50px;
      border: none;
      background: rgba(255, 255, 255, 0.1);
      color: white;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      backdrop-filter: blur(5px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }
    
    .category-btn:hover, .category-btn.active {
      background: linear-gradient(135deg, #ff7e5f, #feb47b);
      transform: translateY(-3px);
      box-shadow: 0 7px 15px rgba(0, 0, 0, 0.3);
    }
    
    .icons-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      gap: 25px;
      padding: 20px;
    }
    
    .icon-card {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 25px 15px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      transition: all 0.4s ease;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.1);
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }
    
    .icon-card:hover {
      transform: translateY(-8px);
      background: rgba(255, 255, 255, 0.15);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }
    
    .icon-card:hover .icon-circle {
      transform: scale(1.1);
      background: linear-gradient(135deg, #ff7e5f, #feb47b);
    }
    
    .icon-card:hover .icon-name {
      color: #ffb347;
    }
    
    .icon-circle {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 15px;
      transition: all 0.4s ease;
      border: 2px solid rgba(255, 255, 255, 0.2);
    }
    
    .icon-card i {
      font-size: 32px;
      color: #fff;
      transition: all 0.3s ease;
    }
    
    .icon-name {
      font-size: 0.95rem;
      font-weight: 500;
      text-align: center;
      transition: color 0.3s ease;
      word-break: break-word;
      max-width: 100%;
      padding: 0 5px;
    }
    
    .icon-class {
      font-size: 0.75rem;
      color: rgba(255, 255, 255, 0.7);
      margin-top: 8px;
      text-align: center;
      word-break: break-all;
    }
    
    .no-results {
      grid-column: 1 / -1;
      text-align: center;
      padding: 50px;
      font-size: 1.5rem;
      color: rgba(255, 255, 255, 0.7);
    }
    
    .counter {
      text-align: center;
      margin: 20px 0;
      font-size: 1.1rem;
      color: #ffb347;
    }
    
    footer {
      margin-top: 50px;
      text-align: center;
      padding: 30px;
      font-size: 1.1rem;
      opacity: 0.8;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .highlight {
      color: #ffb347;
      font-weight: 600;
    }
    
    @media (max-width: 768px) {
      .icons-container {
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 15px;
      }
      
      h1 {
        font-size: 2.4rem;
      }
      
      .icon-circle {
        width: 70px;
        height: 70px;
      }
      
      .icon-card i {
        font-size: 28px;
      }
    }
    
    @media (max-width: 480px) {
      .icons-container {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
      }
      
      .icon-circle {
        width: 60px;
        height: 60px;
      }
      
      .icon-card i {
        font-size: 24px;
      }
      
      .icon-name {
        font-size: 0.85rem;
      }
    }
    
    .notification {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      color: white;
      padding: 15px 25px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      transform: translateY(100px);
      opacity: 0;
      transition: all 0.4s ease;
      z-index: 1000;
    }
    
    .notification.show {
      transform: translateY(0);
      opacity: 1;
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <h1>Galeria de Ícones Font Awesome</h1>
      <p class="subtitle">Explore todos os ícones disponíveis na biblioteca Font Awesome 6.5.0. Use a pesquisa para encontrar ícones específicos ou filtre por categoria.</p>
    </header>
    
    <div class="controls">
      <div class="search-box">
        <input type="text" id="searchInput" placeholder="Buscar ícones...">
      </div>
      
      <div class="category-filter">
        <button class="category-btn active" data-category="all">Todos</button>
        <button class="category-btn" data-category="solid">Solid</button>
        <button class="category-btn" data-category="regular">Regular</button>
        <button class="category-btn" data-category="brands">Brands</button>
        <button class="category-btn" data-category="arrows">Setas</button>
        <button class="category-btn" data-category="communication">Comunicação</button>
        <button class="category-btn" data-category="objects">Objetos</button>
      </div>
    </div>
    
    <div class="counter">
      Mostrando <span id="iconCount">0</span> de <span id="totalIcons">0</span> ícones
    </div>
    
    <div class="icons-container" id="iconsContainer">
      <!-- Ícones serão inseridos aqui via JavaScript -->
    </div>
    
    <footer>
      <p>Desenvolvido com <span class="highlight">Font Awesome 6.5.0</span> | Total de ícones disponíveis: <span id="totalCount">0</span></p>
    </footer>
  </div>
  
  <div class="notification" id="notification">Código do ícone copiado!</div>

  <script>
    // Dados dos ícones (corrigidos e funcionais)
    const icons = [
      { name: "arrow-up", style: "solid", category: "arrows", label: "Seta para cima" },
      { name: "arrow-down", style: "solid", category: "arrows", label: "Seta para baixo" },
      { name: "arrow-left", style: "solid", category: "arrows", label: "Seta para esquerda" },
      { name: "arrow-right", style: "solid", category: "arrows", label: "Seta para direita" },
      { name: "comment", style: "solid", category: "communication", label: "Comentário" },
      { name: "comment-dots", style: "solid", category: "communication", label: "Comentário com pontos" },
      { name: "bell", style: "solid", category: "communication", label: "Sino" },
      { name: "camera", style: "solid", category: "objects", label: "Câmera" },
      { name: "envelope", style: "solid", category: "communication", label: "Envelope" },
      { name: "gear", style: "solid", category: "objects", label: "Engrenagem" },
      { name: "house", style: "solid", category: "objects", label: "Casa" },
      { name: "heart", style: "solid", category: "objects", label: "Coração" },
      { name: "star", style: "solid", category: "objects", label: "Estrela" },
      { name: "user", style: "solid", category: "objects", label: "Usuário" },
      { name: "search", style: "solid", category: "objects", label: "Lupa" },
      { name: "lock", style: "solid", category: "objects", label: "Cadeado" },
      { name: "unlock", style: "solid", category: "objects", label: "Cadeado aberto" },
      { name: "trash", style: "solid", category: "objects", label: "Lixeira" },
      { name: "download", style: "solid", category: "arrows", label: "Download" },
      { name: "upload", style: "solid", category: "arrows", label: "Upload" },
      { name: "phone", style: "solid", category: "communication", label: "Telefone" },
      { name: "image", style: "solid", category: "objects", label: "Imagem" },
      { name: "film", style: "solid", category: "objects", label: "Filme" },
      { name: "music", style: "solid", category: "objects", label: "Música" },
      { name: "book", style: "solid", category: "objects", label: "Livro" },
      { name: "flag", style: "solid", category: "objects", label: "Bandeira" },
      { name: "globe", style: "solid", category: "objects", label: "Globo" },
      { name: "paper-plane", style: "solid", category: "objects", label: "Avião de papel" },
      { name: "calendar", style: "solid", category: "objects", label: "Calendário" },
      { name: "clock", style: "solid", category: "objects", label: "Relógio" },
      { name: "sun", style: "solid", category: "objects", label: "Sol" },
      { name: "moon", style: "solid", category: "objects", label: "Lua" },
      { name: "cloud", style: "solid", category: "objects", label: "Nuvem" },
      { name: "key", style: "solid", category: "objects", label: "Chave" },
      { name: "thumbs-up", style: "solid", category: "communication", label: "Curtir" },
      { name: "thumbs-down", style: "solid", category: "communication", label: "Descurtir" },
      { name: "share", style: "solid", category: "communication", label: "Compartilhar" },
      { name: "facebook", style: "brands", category: "brands", label: "Facebook" },
      { name: "twitter", style: "brands", category: "brands", label: "Twitter" },
      { name: "instagram", style: "brands", category: "brands", label: "Instagram" },
      { name: "linkedin", style: "brands", category: "brands", label: "LinkedIn" },
      { name: "youtube", style: "brands", category: "brands", label: "YouTube" },
      { name: "whatsapp", style: "brands", category: "brands", label: "WhatsApp" },
      { name: "github", style: "brands", category: "brands", label: "GitHub" },
      { name: "discord", style: "brands", category: "brands", label: "Discord" },
      { name: "tiktok", style: "brands", category: "brands", label: "TikTok" },
      { name: "reddit", style: "brands", category: "brands", label: "Reddit" },
      { name: "spotify", style: "brands", category: "brands", label: "Spotify" },
      { name: "slack", style: "brands", category: "brands", label: "Slack" },
      { name: "windows", style: "brands", category: "brands", label: "Windows" },
      { name: "apple", style: "brands", category: "brands", label: "Apple" },
      { name: "linux", style: "brands", category: "brands", label: "Linux" },
      { name: "android", style: "brands", category: "brands", label: "Android" },
      { name: "chrome", style: "brands", category: "brands", label: "Chrome" },
      { name: "firefox", style: "brands", category: "brands", label: "Firefox" },
      { name: "safari", style: "brands", category: "brands", label: "Safari" },
      { name: "edge", style: "brands", category: "brands", label: "Edge" },
      { name: "amazon", style: "brands", category: "brands", label: "Amazon" },
      { name: "google", style: "brands", category: "brands", label: "Google" },
      { name: "microsoft", style: "brands", category: "brands", label: "Microsoft" },
      { name: "paypal", style: "brands", category: "brands", label: "PayPal" },
      { name: "visa", style: "brands", category: "brands", label: "Visa" },
      { name: "mastercard", style: "brands", category: "brands", label: "MasterCard" },
      { name: "bitcoin", style: "brands", category: "brands", label: "Bitcoin" },
      { name: "ethereum", style: "brands", category: "brands", label: "Ethereum" },
      { name: "dribbble", style: "brands", category: "brands", label: "Dribbble" },
      { name: "behance", style: "brands", category: "brands", label: "Behance" },
      { name: "figma", style: "brands", category: "brands", label: "Figma" },
      { name: "trello", style: "brands", category: "brands", label: "Trello" },
      { name: "wordpress", style: "brands", category: "brands", label: "WordPress" },
      { name: "shopify", style: "brands", category: "brands", label: "Shopify" },
      { name: "medium", style: "brands", category: "brands", label: "Medium" },
      { name: "stack-overflow", style: "brands", category: "brands", label: "Stack Overflow" },
      { name: "wifi", style: "solid", category: "objects", label: "Wi-Fi" },
      { name: "battery-full", style: "solid", category: "objects", label: "Bateria cheia" },
      { name: "bluetooth", style: "brands", category: "brands", label: "Bluetooth" },
      { name: "car", style: "solid", category: "objects", label: "Carro" },
      { name: "bicycle", style: "solid", category: "objects", label: "Bicicleta" },
      { name: "ship", style: "solid", category: "objects", label: "Navio" },
      { name: "plane", style: "solid", category: "objects", label: "Avião" },
      { name: "train", style: "solid", category: "objects", label: "Trem" },
      { name: "subway", style: "solid", category: "objects", label: "Metrô" },
      { name: "map", style: "solid", category: "objects", label: "Mapa" },
      { name: "location-dot", style: "solid", category: "objects", label: "Localização" },
      { name: "compass", style: "solid", category: "objects", label: "Bússola" },
      { name: "gift", style: "solid", category: "objects", label: "Presente" },
      { name: "credit-card", style: "solid", category: "objects", label: "Cartão de crédito" },
      { name: "money-bill", style: "solid", category: "objects", label: "Cédula" },
      { name: "shopping-cart", style: "solid", category: "objects", label: "Carrinho de compras" },
      { name: "tag", style: "solid", category: "objects", label: "Etiqueta" },
      { name: "trophy", style: "solid", category: "objects", label: "Troféu" },
      { name: "gamepad", style: "solid", category: "objects", label: "Controle de jogo" },
      { name: "headphones", style: "solid", category: "objects", label: "Fones de ouvido" },
      { name: "tv", style: "solid", category: "objects", label: "TV" },
      { name: "laptop", style: "solid", category: "objects", label: "Laptop" },
      { name: "mobile", style: "solid", category: "objects", label: "Celular" },
      { name: "tablet", style: "solid", category: "objects", label: "Tablet" },
      { name: "print", style: "solid", category: "objects", label: "Impressora" },
      { name: "microphone", style: "solid", category: "objects", label: "Microfone" },
      { name: "volume-high", style: "solid", category: "objects", label: "Volume alto" },
      { name: "broom", style: "solid", category: "objects", label: "Vassoura" },
      { name: "lightbulb", style: "solid", category: "objects", label: "Lâmpada" },
      { name: "gem", style: "solid", category: "objects", label: "Gema" },
      { name: "umbrella", style: "solid", category: "objects", label: "Guarda-chuva" },
      { name: "briefcase", style: "solid", category: "objects", label: "Maleta" },
      { name: "stethoscope", style: "solid", category: "objects", label: "Estetoscópio" },
      { name: "syringe", style: "solid", category: "objects", label: "Seringa" },
      { name: "pills", style: "solid", category: "objects", label: "Comprimidos" },
      { name: "flask", style: "solid", category: "objects", label: "Frasco" },
      { name: "dna", style: "solid", category: "objects", label: "DNA" },
      { name: "virus", style: "solid", category: "objects", label: "Vírus" },
      { name: "bacteria", style: "solid", category: "objects", label: "Bactéria" },
      { name: "seedling", style: "solid", category: "objects", label: "Muda" },
      { name: "tree", style: "solid", category: "objects", label: "Árvore" },
      { name: "paw", style: "solid", category: "objects", label: "Pata" },
      { name: "fish", style: "solid", category: "objects", label: "Peixe" },
      { name: "dog", style: "solid", category: "objects", label: "Cachorro" },
      { name: "cat", style: "solid", category: "objects", label: "Gato" },
      { name: "kiwi-bird", style: "solid", category: "objects", label: "Kiwi" },
      { name: "cow", style: "solid", category: "objects", label: "Vaca" },
      { name: "frog", style: "solid", category: "objects", label: "Sapo" },
      { name: "bug", style: "solid", category: "objects", label: "Inseto" },
      { name: "otter", style: "solid", category: "objects", label: "Lontra" },
      { name: "hippo", style: "solid", category: "objects", label: "Hipopótamo" },
      { name: "dragon", style: "solid", category: "objects", label: "Dragão" },
      { name: "feather", style: "solid", category: "objects", label: "Pena" },
      { name: "egg", style: "solid", category: "objects", label: "Ovo" },
      { name: "cookie", style: "solid", category: "objects", label: "Biscoito" },
      { name: "ice-cream", style: "solid", category: "objects", label: "Sorvete" },
      { name: "pizza-slice", style: "solid", category: "objects", label: "Pizza" },
      { name: "burger", style: "solid", category: "objects", label: "Hambúrguer" },
      { name: "mug-hot", style: "solid", category: "objects", label: "Caneca" },
      { name: "wine-glass", style: "solid", category: "objects", label: "Taça de vinho" },
      { name: "martini-glass", style: "solid", category: "objects", label: "Taça de martini" },
      { name: "whiskey-glass", style: "solid", category: "objects", label: "Copo de whiskey" },
      { name: "beer-mug", style: "solid", category: "objects", label: "Caneca de cerveja" },
      { name: "champagne-glass", style: "solid", category: "objects", label: "Taça de champanhe" },
      { name: "basketball", style: "solid", category: "objects", label: "Basquete" },
      { name: "baseball", style: "solid", category: "objects", label: "Beisebol" },
      { name: "football", style: "solid", category: "objects", label: "Futebol americano" },
      { name: "soccer-ball", style: "solid", category: "objects", label: "Bola de futebol" },
      { name: "tennis-ball", style: "solid", category: "objects", label: "Bola de tênis" },
      { name: "volleyball", style: "solid", category: "objects", label: "Vôlei" },
      { name: "golf