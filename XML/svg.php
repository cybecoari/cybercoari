<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Conversor de Imagem para SVG</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
      margin: 0;
      padding: 20px;
      color: #333;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    .container {
      max-width: 900px;
      width: 100%;
      margin: 20px auto;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }
    
    h1 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 25px;
      font-weight: 700;
      font-size: 2.4rem;
      background: linear-gradient(45deg, #2575fc, #6a11cb);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .upload-area {
      border: 3px dashed #3498db;
      border-radius: 12px;
      padding: 40px;
      text-align: center;
      cursor: pointer;
      background: rgba(52, 152, 219, 0.05);
      transition: all 0.3s ease;
      margin-bottom: 25px;
      position: relative;
      overflow: hidden;
    }
    
    .upload-area:hover {
      background: rgba(52, 152, 219, 0.1);
      border-color: #2980b9;
      transform: translateY(-3px);
      box-shadow: 0 7px 15px rgba(0, 0, 0, 0.1);
    }
    
    .upload-area p {
      margin: 0;
      font-size: 1.2rem;
      color: #3498db;
      font-weight: 500;
    }
    
    .upload-area i {
      font-size: 3.5rem;
      color: #3498db;
      margin-bottom: 15px;
      display: block;
    }
    
    .hidden {
      display: none;
    }
    
    .preview, .result {
      margin-top: 30px;
      text-align: center;
      padding: 25px;
      border-radius: 12px;
      background: #f9f9f9;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .preview h3, .result h3 {
      margin-top: 0;
      color: #2c3e50;
      font-weight: 600;
      margin-bottom: 20px;
      font-size: 1.5rem;
    }
    
    img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
      margin-top: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      border: 1px solid #e0e0e0;
    }
    
    svg {
      max-width: 100%;
      height: auto;
      margin-top: 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background: #fff;
      padding: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }
    
    .buttons {
      margin-top: 30px;
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }
    
    button {
      padding: 14px 28px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .btn-converter {
      background: linear-gradient(to right, #3498db, #2980b9);
      color: #fff;
    }
    
    .btn-converter:hover {
      background: linear-gradient(to right, #2980b9, #2575fc);
      transform: translateY(-3px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    
    .btn-download {
      background: linear-gradient(to right, #27ae60, #219653);
      color: #fff;
    }
    
    .btn-download:hover {
      background: linear-gradient(to right, #219653, #1e8449);
      transform: translateY(-3px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    
    .btn-limpar {
      background: linear-gradient(to right, #e74c3c, #c0392b);
      color: #fff;
    }
    
    .btn-limpar:hover {
      background: linear-gradient(to right, #c0392b, #a93226);
      transform: translateY(-3px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    
    .options {
      margin-top: 25px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      justify-content: center;
      align-items: center;
      padding: 25px;
      border-radius: 12px;
      background: #f9f9f9;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .option-group {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
    
    label {
      font-size: 14px;
      font-weight: 600;
      color: #2c3e50;
    }
    
    input[type="number"], input[type="range"], select {
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 14px;
      background: white;
      box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    input[type="checkbox"] {
      transform: scale(1.3);
      margin-right: 8px;
    }
    
    .status {
      margin-top: 20px;
      text-align: center;
      font-size: 16px;
      padding: 15px;
      border-radius: 8px;
      font-weight: 500;
    }
    
    .status.success { 
      background: #d4edda; 
      color: #155724; 
      border: 1px solid #c3e6cb;
    }
    
    .status.error { 
      background: #f8d7da; 
      color: #721c24; 
      border: 1px solid #f5c6cb;
    }
    
    .placeholder {
      text-align: center;
      color: #aaa;
      font-size: 18px;
      padding: 50px 0;
    }
    
    .file-info {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
      color: #666;
      font-weight: 500;
      padding: 10px;
      background: #f0f0f0;
      border-radius: 6px;
    }
    
    .progress {
      height: 12px;
      background: #f0f0f0;
      border-radius: 10px;
      margin: 20px 0;
      overflow: hidden;
      box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .progress-bar {
      height: 100%;
      background: linear-gradient(to right, #3498db, #6a11cb);
      width: 0%;
      transition: width 0.5s ease;
      border-radius: 10px;
    }
    
    .value-display {
      font-weight: 600;
      color: #2575fc;
      margin-left: 5px;
    }
    
    @media (max-width: 768px) {
      .container {
        padding: 20px;
      }
      
      .options {
        grid-template-columns: 1fr;
      }
      
      .buttons {
        flex-direction: column;
        align-items: center;
      }
      
      button {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>🔄 Conversor de Imagem para SVG</h1>
    <div class="upload-area" id="uploadArea">
      <i>📁</i>
      <p>Arraste e solte uma imagem aqui ou clique para selecionar</p>
      <input type="file" id="uploadInput" accept="image/*" hidden>
    </div>

    <div class="options hidden" id="options">
      <div class="option-group">
        <label for="scale">Escala: <span class="value-display" id="scaleValue">0.5</span></label>
        <input type="range" id="scale" min="0.1" max="1" step="0.05" value="0.5">
      </div>
      <div class="option-group">
        <label for="width">Largura (px):</label>
        <input type="number" id="width" min="50" max="1000" step="10" value="300">
      </div>
      <div class="option-group">
        <label for="height">Altura (px):</label>
        <input type="number" id="height" min="50" max="1000" step="10" value="300">
      </div>
      <div class="option-group">
        <label for="quality">Qualidade: <span class="value-display" id="qualityValue">3</span></label>
        <input type="range" id="quality" min="1" max="10" value="3">
      </div>
      <div class="option-group">
        <label for="colorMode">Modo de cores:</label>
        <select id="colorMode">
          <option value="binary">Preto e branco</option>
          <option value="grayscale">Tons de cinza</option>
          <option value="limited" selected>Cores limitadas</option>
          <option value="full">Cores completas</option>
        </select>
      </div>
      <div class="option-group">
        <label><input type="checkbox" id="center"> Centralizar</label>
        <label><input type="checkbox" id="simplify" checked> Simplificar caminhos</label>
      </div>
    </div>

    <div class="preview hidden" id="previewContainer">
      <h3>Pré-visualização:</h3>
      <img id="preview" alt="Prévia da imagem">
      <div class="file-info" id="previewInfo"></div>
    </div>

    <div class="progress hidden" id="progressBar">
      <div class="progress-bar" id="progressBarInner"></div>
    </div>

    <div class="buttons">
      <button class="btn-converter hidden" id="converterBtn">
        <span>🔄</span> Converter para SVG
      </button>
      <button class="btn-download hidden" id="baixarBtn">
        <span>💾</span> Baixar SVG
      </button>
      <button class="btn-limpar hidden" id="limparBtn">
        <span>🗑️</span> Limpar
      </button>
    </div>

    <div class="status hidden" id="status"></div>

    <div class="result hidden" id="resultContainer">
      <h3>Resultado (SVG):</h3>
      <div id="svgResult"></div>
      <div class="file-info" id="svgInfo"></div>
    </div>

    <div class="placeholder" id="placeholder">
      Nenhuma imagem carregada ainda.
    </div>
  </div>

  <!-- Biblioteca ImageTracer -->
  <script src="https://cdn.jsdelivr.net/gh/jankovicsandras/imagetracerjs/imagetracer_v1.2.1.js"></script>

  <script>
    // Elementos da interface
    const uploadArea = document.getElementById('uploadArea');
    const uploadInput = document.getElementById('uploadInput');
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('previewContainer');
    const previewInfo = document.getElementById('previewInfo');
    const options = document.getElementById('options');
    const converterBtn = document.getElementById('converterBtn');
    const baixarBtn = document.getElementById('baixarBtn');
    const limparBtn = document.getElementById('limparBtn');
    const statusDiv = document.getElementById('status');
    const resultContainer = document.getElementById('resultContainer');
    const svgResult = document.getElementById('svgResult');
    const svgInfo = document.getElementById('svgInfo');
    const placeholderDiv = document.getElementById('placeholder');
    const progressBar = document.getElementById('progressBar');
    const progressBarInner = document.getElementById('progressBarInner');
    const scaleValue = document.getElementById('scaleValue');
    const qualityValue = document.getElementById('qualityValue');

    // Variáveis de estado
    let imagemCarregada = null;
    let svgGerado = null;
    let originalSvgContent = null;
    let originalFileSize = 0;

    // Event Listeners
    uploadArea.addEventListener('click', () => uploadInput.click());
    
    uploadInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        originalFileSize = file.size;
        const reader = new FileReader();
        reader.onload = function(e) {
          imagemCarregada = new Image();
          imagemCarregada.onload = function() {
            preview.src = imagemCarregada.src;
            previewInfo.textContent = `Tamanho original: ${formatFileSize(originalFileSize)} | Dimensões: ${imagemCarregada.width} × ${imagemCarregada.height}px`;
            previewContainer.classList.remove('hidden');
            options.classList.remove('hidden');
            converterBtn.classList.remove('hidden');
            limparBtn.classList.remove('hidden');
            progressBar.classList.remove('hidden');
            placeholderDiv.classList.add('hidden');
            
            // Definir valores iniciais
            const scale = parseFloat(document.getElementById('scale').value);
            document.getElementById('width').value = Math.round(imagemCarregada.width * scale);
            document.getElementById('height').value = Math.round(imagemCarregada.height * scale);
          };
          imagemCarregada.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });

    // Atualizar valores exibidos
    document.getElementById('scale').addEventListener('input', function() {
      scaleValue.textContent = this.value;
      if (imagemCarregada) {
        document.getElementById('width').value = Math.round(imagemCarregada.width * this.value);
        document.getElementById('height').value = Math.round(imagemCarregada.height * this.value);
      }
    });

    document.getElementById('quality').addEventListener('input', function() {
      qualityValue.textContent = this.value;
    });

    // Botão de conversão - CORREÇÃO PRINCIPAL
    converterBtn.addEventListener('click', function() {
      if (!imagemCarregada) {
        showStatus("Nenhuma imagem carregada!", "error");
        return;
      }

      showStatus("Convertendo imagem, aguarde...", "success");
      progressBarInner.style.width = '30%';

      // Usar setTimeout para permitir a atualização visual antes do processamento pesado
      setTimeout(function() {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        const scale = parseFloat(document.getElementById('scale').value);
        const width = parseInt(document.getElementById('width').value);
        const height = parseInt(document.getElementById('height').value);

        canvas.width = width;
        canvas.height = height;
        
        // Desenhar a imagem no canvas
        ctx.drawImage(imagemCarregada, 0, 0, width, height);
        progressBarInner.style.width = '60%';

        const imageData = ctx.getImageData(0, 0, width, height);
        const quality = parseInt(document.getElementById('quality').value);
        const colorMode = document.getElementById('colorMode').value;
        const simplifyPaths = document.getElementById('simplify').checked;
        
        // Configurações para o tracer
        const optionsTracer = {
          ltres: 1 + (10 - quality) * 0.5,
          qtres: 1 + (10 - quality) * 0.5,
          pathomit: Math.max(8 - quality, 1),
          numberofcolors: colorMode === 'binary' ? 2 : 
                         colorMode === 'grayscale' ? 16 : 
                         colorMode === 'limited' ? 32 : 256,
          colorquantcycles: 3,
          minpathsize: simplifyPaths ? 2 + quality : 1,
          simplifytolerance: simplifyPaths ? (10 - quality) * 0.5 : 0,
          roundcoords: 1,
          viewbox: false,
          desc: false,
          blurradius: quality > 5 ? 0 : 1,
          blurdelta: 20
        };

        progressBarInner.style.width = '80%';
        
        // CORREÇÃO: Chamada correta para a função de conversão
        try {
          // Usando a biblioteca ImageTracer corretamente
          svgGerado = ImageTracer.imagedataToSVG(imageData, optionsTracer);
          originalSvgContent = svgGerado;
          
          // Exibir o SVG resultante
          svgResult.innerHTML = svgGerado;
          resultContainer.classList.remove('hidden');
          baixarBtn.classList.remove('hidden');
          
          // Calcular e mostrar o tamanho do SVG
          const svgSize = new Blob([svgGerado], {type: "image/svg+xml"}).size;
          const compressionRatio = (originalFileSize / svgSize).toFixed(1);
          svgInfo.textContent = `Tamanho do SVG: ${formatFileSize(svgSize)} | Redução: ${compressionRatio}x | Dimensões: ${width} × ${height}px`;
          
          showStatus("Conversão concluída com sucesso!", "success");
          progressBarInner.style.width = '100%';
          
          // Resetar a barra de progresso após 2 segundos
          setTimeout(() => {
            progressBarInner.style.width = '0%';
          }, 2000);
        } catch (error) {
          showStatus("Erro na conversão: " + error.message, "error");
          progressBarInner.style.width = '0%';
        }
      }, 100);
    });

    // Botão de download
    baixarBtn.addEventListener('click', function() {
      if (!svgGerado) return;

      const width = parseInt(document.getElementById('width').value);
      const height = parseInt(document.getElementById('height').value);
      const center = document.getElementById('center').checked;

      let svgContent;
      if (center) {
        svgContent = `<svg width="${width}" height="${height}" xmlns="http://www.w3.org/2000/svg"><g transform="translate(${width/2},${height/2}) translate(${-width/2},${-height/2})">${originalSvgContent}</g></svg>`;
      } else {
        svgContent = `<svg width="${width}" height="${height}" xmlns="http://www.w3.org/2000/svg">${originalSvgContent}</svg>`;
      }

      // Otimização final: remover espaços em branco desnecessários
      svgContent = svgContent.replace(/\s+/g, ' ').trim();
      
      const blob = new Blob([svgContent], { type: "image/svg+xml" });
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = "imagem_convertida.svg";
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      URL.revokeObjectURL(url);
    });

    // Botão de limpar
    limparBtn.addEventListener('click', function() {
      uploadInput.value = '';
      previewContainer.classList.add('hidden');
      options.classList.add('hidden');
      converterBtn.classList.add('hidden');
      limparBtn.classList.add('hidden');
      resultContainer.classList.add('hidden');
      progressBar.classList.add('hidden');
      placeholderDiv.classList.remove('hidden');
      baixarBtn.classList.add('hidden');
      statusDiv.classList.add('hidden');
      svgResult.innerHTML = '';
      imagemCarregada = null;
      svgGerado = null;
      originalSvgContent = null;
      previewInfo.textContent = '';
      svgInfo.textContent = '';
      progressBarInner.style.width = '0%';
    });

    // Funções auxiliares
    function showStatus(message, type) {
      statusDiv.textContent = message;
      statusDiv.className = 'status ' + type;
      statusDiv.classList.remove('hidden');
    }

    function formatFileSize(bytes) {
      if (bytes < 1024) return bytes + ' bytes';
      else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
      else return (bytes / 1048576).toFixed(1) + ' MB';
    }

    // Suporte a arrastar e soltar
    uploadArea.addEventListener('dragover', function(e) {
      e.preventDefault();
      uploadArea.style.background = 'rgba(52, 152, 219, 0.1)';
      uploadArea.style.borderColor = '#2980b9';
    });

    uploadArea.addEventListener('dragleave', function() {
      uploadArea.style.background = 'rgba(52, 152, 219, 0.05)';
      uploadArea.style.borderColor = '#3498db';
    });

    uploadArea.addEventListener('drop', function(e) {
      e.preventDefault();
      uploadArea.style.background = 'rgba(52, 152, 219, 0.05)';
      uploadArea.style.borderColor = '#3498db';
      
      if (e.dataTransfer.files.length) {
        uploadInput.files = e.dataTransfer.files;
        const event = new Event('change');
        uploadInput.dispatchEvent(event);
      }
    });
  </script>
</body>
</html>