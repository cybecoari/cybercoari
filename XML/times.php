<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galeria Automática CDN - cybercoari</title>
  <style>
    :root {
      --primary-color: #4a6ee0;
      --secondary-color: #6c757d;
      --background-color: #f8f9fa;
      --card-bg: #ffffff;
      --text-color: #333333;
      --border-radius: 12px;
      --shadow: 0 2px 10px rgba(0,0,0,0.08);
      --transition: all 0.3s ease;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      background: var(--background-color);
      margin: 0;
      padding: 20px;
      color: var(--text-color);
      line-height: 1.6;
    }

    header {
      max-width: 1000px;
      margin: 0 auto 30px;
      text-align: center;
    }

    h1 {
      margin-bottom: 8px;
      color: var(--primary-color);
      font-weight: 700;
    }

    .subtitle {
      color: var(--secondary-color);
      margin-bottom: 20px;
    }

    .search-container {
      max-width: 500px;
      margin: 0 auto 20px;
      position: relative;
    }

    #buscaImgs {
      width: 100%;
      padding: 12px 45px 12px 16px;
      border: 2px solid #e1e5e9;
      border-radius: var(--border-radius);
      font-size: 16px;
      transition: var(--transition);
      box-sizing: border-box;
    }

    #buscaImgs:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(74, 110, 224, 0.1);
    }

    .stats {
      display: flex;
      justify-content: space-between;
      max-width: 1000px;
      margin: 0 auto 20px;
      flex-wrap: wrap;
      gap: 15px;
    }

    .stat-box {
      background: var(--card-bg);
      padding: 15px;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      flex: 1;
      min-width: 200px;
    }

    .stat-box h3 {
      margin: 0 0 8px 0;
      font-size: 16px;
      color: var(--secondary-color);
    }

    .stat-box p {
      margin: 0;
      font-size: 24px;
      font-weight: 700;
      color: var(--primary-color);
    }

    .folder-stats {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 10px;
      margin-top: 10px;
    }

    .folder-stat {
      display: flex;
      justify-content: space-between;
      padding: 8px 0;
      border-bottom: 1px solid #eee;
    }

    .folder-name {
      font-weight: 500;
    }

    .folder-count {
      color: var(--secondary-color);
      font-weight: 600;
    }

    .gallery {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 20px;
      max-width: 1000px;
      margin: 0 auto;
    }

    .card {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 15px;
      text-align: center;
      transition: var(--transition);
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .image-container {
      height: 160px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 12px;
      overflow: hidden;
      border-radius: 8px;
      background: #f8f9fa;
    }

    img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
      transition: var(--transition);
    }

    .card:hover img {
      transform: scale(1.05);
    }

    .file-path {
      margin-top: auto;
      font-size: 13px;
      color: var(--secondary-color);
      word-break: break-all;
      line-height: 1.4;
    }

    .no-results {
      grid-column: 1 / -1;
      text-align: center;
      padding: 40px 20px;
      color: var(--secondary-color);
    }

    .loading {
      grid-column: 1 / -1;
      text-align: center;
      padding: 40px 20px;
    }

    .spinner {
      border: 4px solid rgba(0, 0, 0, 0.1);
      border-left-color: var(--primary-color);
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
      margin: 0 auto 20px;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    @media (max-width: 768px) {
      .stats {
        flex-direction: column;
      }
      
      .gallery {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
      }
    }

    @media (max-width: 480px) {
      body {
        padding: 15px;
      }
      
      .gallery {
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 10px;
      }
      
      .card {
        padding: 10px;
      }
      
      .image-container {
        height: 120px;
      }
    }
  </style>
</head>
<body>

  <header>
    <h1>CDN cybercoari</h1>
    <p class="subtitle">Galeria de imagens do repositório GitHub</p>
    
    <div class="search-container">
      <input 
        type="text" 
        id="buscaImgs" 
        placeholder="🔍 Buscar imagem por nome..." 
      >
    </div>
  </header>

  <div class="stats">
    <div class="stat-box">
      <h3>Total de Imagens</h3>
      <p id="contador">0</p>
    </div>
    <div class="stat-box">
      <h3>Imagens Encontradas</h3>
      <p id="contadorFiltrado">0</p>
    </div>
    <div class="stat-box">
      <h3>Pastas</h3>
      <p id="contadorPastas">0</p>
    </div>
  </div>

  <div class="gallery" id="gallery">
    <div class="loading">
      <div class="spinner"></div>
      <p>Carregando imagens...</p>
    </div>
  </div>

  <script>
    // Configurações
    const config = {
      owner: "cybercoari-1",
      repo: "times",
      branch: "main"
    };
    
    // URL base para as imagens
    config.baseURL = `https://cdn.jsdelivr.net/gh/${config.owner}/${config.repo}@${config.branch}/`;

    // Elementos DOM
    const elements = {
      gallery: document.getElementById("gallery"),
      contador: document.getElementById("contador"),
      contadorFiltrado: document.getElementById("contadorFiltrado"),
      contadorPastas: document.getElementById("contadorPastas"),
      buscaImgs: document.getElementById("buscaImgs")
    };

    // Estado da aplicação
    let state = {
      allImages: [],
      filteredImages: [],
      folders: {}
    };

    // Função principal para carregar imagens
    async function carregarImagens() {
      try {
        const apiURL = `https://api.github.com/repos/${config.owner}/${config.repo}/git/trees/${config.branch}?recursive=1`;
        const response = await fetch(apiURL);

        if (!response.ok) {
          if (response.status === 403) {
            throw new Error("Limite de requisições à API do GitHub excedido. Tente novamente em alguns minutos.");
          }
          throw new Error(`Erro ${response.status}: ${response.statusText}`);
        }

        const data = await response.json();
        
        if (!data.tree) {
          throw new Error("Estrutura de dados inesperada da API do GitHub");
        }
        
        processarArquivos(data.tree);
        
      } catch (err) {
        console.error("Erro ao carregar imagens:", err);
        elements.gallery.innerHTML = `
          <div class="no-results">
            <h3>Erro ao carregar imagens</h3>
            <p>${err.message}</p>
            <p>Verifique se o repositório "${config.owner}/${config.repo}" existe e está acessível publicamente.</p>
          </div>
        `;
      }
    }

    // Processa os arquivos retornados pela API
    function processarArquivos(arquivos) {
      const imagens = arquivos.filter(item =>
        item.type === "blob" && /\.(png|jpg|jpeg|svg|gif|webp|bmp)$/i.test(item.path)
      );

      // Atualiza estado
      state.allImages = imagens;
      state.filteredImages = [...imagens];
      
      // Processa pastas
      state.folders = {};
      imagens.forEach(file => {
        const pasta = file.path.includes("/") ? file.path.split("/")[0] : "Raiz";
        state.folders[pasta] = (state.folders[pasta] || 0) + 1;
      });

      // Atualiza interface
      atualizarContadores();
      renderizarGaleria();
      renderizarPastas();
    }

    // Atualiza os contadores na interface
    function atualizarContadores() {
      elements.contador.textContent = state.allImages.length;
      elements.contadorFiltrado.textContent = state.filteredImages.length;
      elements.contadorPastas.textContent = Object.keys(state.folders).length;
    }

    // Renderiza a galeria de imagens
    function renderizarGaleria() {
      if (state.filteredImages.length === 0) {
        elements.gallery.innerHTML = `
          <div class="no-results">
            <h3>Nenhuma imagem encontrada</h3>
            <p>Tente ajustar os termos da busca.</p>
          </div>
        `;
        return;
      }

      elements.gallery.innerHTML = state.filteredImages.map(file => {
        const url = config.baseURL + file.path;
        return `
          <div class="card">
            <div class="image-container">
              <img src="${url}" alt="${file.path}" loading="lazy">
            </div>
            <p class="file-path">${file.path}</p>
          </div>
        `;
      }).join("");
    }

    // Renderiza as estatísticas de pastas
    function renderizarPastas() {
      // Verifica se já existe o container de estatísticas de pastas
      let folderStatsContainer = document.querySelector('.folder-stats-container');
      
      if (!folderStatsContainer) {
        // Cria o container se não existir
        const statsContainer = document.querySelector('.stats');
        folderStatsContainer = document.createElement('div');
        folderStatsContainer.className = 'stat-box folder-stats-container';
        folderStatsContainer.style.flexBasis = '100%';
        folderStatsContainer.style.marginTop = '20px';
        folderStatsContainer.innerHTML = `
          <h3>Imagens por Pasta</h3>
          <div class="folder-stats"></div>
        `;
        statsContainer.appendChild(folderStatsContainer);
      }
      
      const folderStats = folderStatsContainer.querySelector('.folder-stats');
      folderStats.innerHTML = Object.entries(state.folders)
        .sort((a, b) => b[1] - a[1]) // Ordena por quantidade (decrescente)
        .map(([pasta, count]) => `
          <div class="folder-stat">
            <span class="folder-name">${pasta}/</span>
            <span class="folder-count">${count}</span>
          </div>
        `).join("");
    }

    // Filtra as imagens baseado no termo de busca
    function filtrarImagens(termo) {
      if (!termo) {
        state.filteredImages = [...state.allImages];
      } else {
        const termoLower = termo.toLowerCase();
        state.filteredImages = state.allImages.filter(file => 
          file.path.toLowerCase().includes(termoLower)
        );
      }
      
      atualizarContadores();
      renderizarGaleria();
    }

    // Inicialização
    document.addEventListener('DOMContentLoaded', () => {
      carregarImagens();
      
      // Configura o evento de busca
      elements.buscaImgs.addEventListener('input', function() {
        filtrarImagens(this.value);
      });
    });
  </script>
</body>
</html>