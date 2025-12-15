<link rel="stylesheet" href="https://cybercoari.com.br/cyber/css/bootstrap.min.css">  
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">  

<style>  
  .navbar {  
    display: flex;  
    justify-content: space-between;  
    align-items: center;  
    padding: 0.6rem 1rem;  
    background-color: #fff;  
    border-bottom: 1px solid #ddd;  
    position: relative;  
    z-index: 1000;  
  }  

  .dark-mode .navbar {  
    background-color: #16213e;  
    border-color: #333;  
  }  

  .menu-toggle {  
    background: none;  
    border: none;  
    font-size: 1.5rem;  
    color: inherit;  
    cursor: pointer;  
  }  

  /* Botão do tema redondo e transparente */  
  #theme-toggle {  
    background-color: transparent;  
    border: none;  
    border-radius: 50%;  
    padding: 8px;  
    cursor: pointer;  
    font-size: 1.4rem;  
    color: inherit;  
    display: flex;  
    align-items: center;  
    justify-content: center;  
    transition: background-color 0.3s ease;  
  }  

  #theme-toggle:hover {  
    background-color: rgba(255,255,255,0.1);  
  }  

  #sidebar {  
    position: fixed;  
    top: 0;  
    left: -250px;  
    width: 250px;  
    height: 100%;  
    background-color: #f8f9fa;  
    color: #212529;  
    padding: 1rem;  
    transition: left 0.3s ease-in-out;  
    z-index: 999;  
    overflow-y: auto;  
  }  

  #sidebar.active {  
    left: 0;  
  }  

  #sidebar h5 {  
    font-weight: 600;  
    margin-bottom: 1rem;  
    color: #007bff;  
  }  

  #sidebar a {  
    display: flex;  
    align-items: center;  
    color: #16213e;  
    text-decoration: none;  
    padding: 0.6rem 0.5rem;  
    border-radius: 4px;  
    transition: background-color 0.3s, color 0.3s;  
    font-size: 15px;  
  }  

  #sidebar a i {  
    margin-right: 10px;  
    font-size: 1.2rem;  
  }  

  #sidebar a:hover {  
    background-color: #e2e6ea;  
    color: #0d6efd;  
  }  

  body.dark-mode {  
    background-color: #16213e;  
    color: #f8f9fa;  
  }  

  body.dark-mode #sidebar {  
    background-color: #1f2d3d;  
    color: #f8f9fa;  
  }  

  body.dark-mode #sidebar h5 {  
    color: #0dcaf0;  
  }  

  body.dark-mode #sidebar a {  
    color: #f8f9fa;  
  }  

  body.dark-mode #sidebar a:hover {  
    background-color: #0d6efd;  
    color: #fff;  
  }  
</style>  

<!-- Menu lateral -->  
<div id="sidebar">  
  <h5>Menu</h5>
  <!-- menu lateral -->
 <div class="sidebar-profile text-center py-3">
  
  <img src="<?= e($usuario['banner']); ?>"   
   alt="Banner"   
   style="max-width:100%; width:<?= e($usuario['banner_largura'] ?? 400); ?>px; height:<?= e($usuario['banner_altura'] ?? 200); ?>px; border-radius:10px;">
  <h6 class="mb-1"><?= e($usuario['usuario']); ?></h6>
  <small class="text-muted d-block" style="font-size: 0.85rem;"><?= e($usuario['email']); ?></small>
</div>
  <!-- -->

  
  <a href="/admin/perfil.php"><i class="bi bi-person-circle"></i> Perfil</a>
  <?php if (function_exists('isAdmin') && isAdmin()): ?>
    <a href="/admin/cadastro.php"><i class="bi bi-person-plus"></i> Cadastro</a>
    <a href="/admin/mensagens.php"><i class="bi bi-chat-dots"></i> Gerenciar Mensagens</a>
  <?php endif; ?>
  <a href="/admin/mudarsenha.php"><i class="bi bi-key"></i> Mudar Senha</a>
  <a href="/admin/pedidos.php"><i class="bi bi-bag-check"></i> Pedidos</a>
  <a href="/app/list_apps.php"><i class="bi bi-grid"></i> App</a>
  <a href="/loja/"><i class="bi bi-shop"></i> Loja</a>
  <a href="/home.php"><i class="bi bi-house"></i> Home</a>
  <a href="/scr/"><i class="bi bi-cloud"></i> APIs</a>
  <a href="/uteis/"><i class="bi bi-tools"></i> Ferramentas</a>
  
  <a href="/logout.php"><i class="bi bi-box-arrow-right"></i> Sair</a>
</div>

<!-- Barra de navegação superior -->  
<nav class="navbar">  
  <button class="menu-toggle" onclick="toggleSidebar();">  
    <i class="bi bi-list"></i>  
  </button>  

  <!-- Botão de tema arredondado -->  
  <button id="theme-toggle" title="Alternar tema">  
    <i id="theme-icon" class="bi <?= $tema === 'escuro' ? 'bi-sun-fill' : 'bi-moon-stars-fill'; ?>"></i>  
  </button>  
</nav>  

<center>  
  <img src="<?= e($usuario['banner']); ?>"   
   alt="Banner"   
   style="max-width:100%; width:<?= e($usuario['banner_largura'] ?? 400); ?>px; height:<?= e($usuario['banner_altura'] ?? 200); ?>px; border-radius:10px;">  

  <!-- Saudação -->  
  <h3 class="text-center mt-2">Bem-vindo, <?= e($usuario['usuario']); ?>!</h3>  

  <!-- Relógio -->  
  <div class="relogio-container">  
      <h5 id="saudacao"></h5>  
      <div id="data" class="data"></div>  
      <div id="hora" class="hora"></div>  
  </div>  
</center>  

  <script>  
  const sidebar = document.getElementById('sidebar');  
  const toggleBtn = document.getElementById('dark-mode-toggle');  
  const body = document.body;  
  
  function toggleSidebar() {  
    sidebar.classList.toggle('active');  
  }  
  
  // Aplica o tema salvo da sessão PHP  
  <?php if ($tema === 'escuro'): ?>  
    body.classList.add('dark-mode');  
  <?php endif; ?>  
  
  // Alternar Dark/Light Mode  
  toggleBtn.addEventListener('click', () => {  
    body.classList.toggle('dark-mode');  
    const isDark = body.classList.contains('dark-mode');  
  
    // Troca ícone  
    toggleBtn.innerHTML = isDark  
      ? '<i class="bi bi-sun-fill"></i>'  
      : '<i class="bi bi-moon-stars-fill"></i>';  
  
    // Salva no banco via POST  
    const formData = new FormData();  
    formData.append('tema', isDark ? 'escuro' : 'claro');  
  
    fetch('/includes/salvartema.php', {  
      method: 'POST',  
      body: formData  
    })  
    .then(res => res.json())  
    .then(data => {  
      if (data.status !== 'ok') {  
        console.error('Erro ao salvar tema:', data.message);  
      }  
    })  
    .catch(err => console.error('Erro no fetch:', err));  
  });  
  </script>