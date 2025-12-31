<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Compressor Base64</title>
  
  <style>
    body {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      padding: 20px 0;
    }
    .container {
      max-width: 900px;
    }
    .card {
      border: none;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }
    .card-header {
      background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
      border: none;
    }
    .preview-img {
      max-width: 100%;
      max-height: 250px;
      margin: 15px 0;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    textarea {
      font-family: monospace;
      font-size: 12px;
      height: 200px;
    }
    .file-info {
      background-color: #f8f9fa;
      border-radius: 8px;
      padding: 12px;
      margin: 12px 0;
    }
    .drop-zone {
      border: 2px dashed #2ecc71;
      border-radius: 10px;
      padding: 25px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s;
      background-color: rgba(46, 204, 113, 0.05);
    }
    .drop-zone:hover, .drop-zone.dragover {
      background-color: rgba(46, 204, 113, 0.1);
      border-color: #27ae60;
    }
    .drop-zone i {
      font-size: 42px;
      color: #2ecc71;
      margin-bottom: 12px;
    }
    .compression-options {
      background-color: #f8f9fa;
      border-radius: 10px;
      padding: 15px;
      margin: 15px 0;
    }
    .stats-box {
      background-color: #e9ecef;
      border-radius: 8px;
      padding: 10px 15px;
      margin: 10px 0;
    }
    .btn-compress {
      background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
      border: none;
      color: white;
    }
    .btn-compress:hover {
      background: linear-gradient(135deg, #27ae60 0%, #219653 100%);
      color: white;
    }
    .slider-value {
      font-weight: bold;
      color: #27ae60;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow-lg">
          <div class="card-header text-white">
            <h4 class="mb-0"><i class="fas fa-compress-arrows-alt me-2"></i>Compressor de Imagem para Base64</h4>
            <p class="mb-0 mt-1">Gere o menor código Base64 possível para suas imagens</p>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <div class="drop-zone" id="dropZone">
                <i class="fas fa-cloud-upload-alt"></i>
                <h5>Arraste e solte uma imagem aqui</h5>
                <p class="text-muted">ou</p>
                <label for="fileInput" class="btn btn-success file-input-label">
                  <i class="fas fa-folder-open me-1"></i>Selecione um arquivo
                </label>
                <input type="file" class="d-none" id="fileInput" accept="image/*">
                <p class="small text-muted mt-2">Formatos suportados: JPG, PNG, GIF, SVG, WEBP</p>
                <p class="small text-muted">Tamanho máximo: 5MB</p>
              </div>
            </div>

            <div id="fileInfo" class="file-info d-none">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <strong>Arquivo:</strong> <span id="fileName"></span><br>
                  <strong>Tamanho:</strong> <span id="fileSize"></span><br>
                  <strong>Tipo:</strong> <span id="fileType"></span>
                </div>
                <button class="btn btn-sm btn-secondary" onclick="clearSelection()">
                  <i class="fas fa-times me-1"></i>Limpar
                </button>
              </div>
            </div>

            <div id="preview" class="text-center mb-3"></div>

            <div id="compressionSection" class="d-none">
              <div class="compression-options">
                <h5 class="mb-3"><i class="fas fa-sliders-h me-2"></i>Opções de Compressão</h5>
                
                <div class="mb-3">
                  <label for="qualitySlider" class="form-label">Qualidade da imagem: <span id="qualityValue" class="slider-value">100%</span></label>
                  <input type="range" class="form-range" id="qualitySlider" min="10" max="100" value="0">
                  <div class="form-text">Qualidade menor = arquivo menor, mas perda de qualidade</div>
                </div>
                
                <div class="mb-3">
                  <label for="widthInput" class="form-label">Largura máxima (px):</label>
                  <input type="number" class="form-control" id="widthInput" value="50" min="100" max="4000">
                  <div class="form-text">Redimensionar para largura específica</div>
                </div>
                
                <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" id="removeMetadata" checked>
                  <label class="form-check-label" for="removeMetadata">
                    Remover metadados (reduz tamanho)
                  </label>
                </div>
                
                <button class="btn btn-compress w-100" onclick="compressImage()">
                  <i class="fas fa-compress-arrows-alt me-1"></i>Comprimir Imagem
                </button>
              </div>
              
              <div class="stats-box">
                <div class="row">
                  <div class="col-md-6">
                    <strong>Original:</strong> <span id="originalSize">0 KB</span>
                  </div>
                  <div class="col-md-6">
                    <strong>Comprimido:</strong> <span id="compressedSize">0 KB</span>
                  </div>
                  <div class="col-md-12 mt-2">
                    <strong>Redução:</strong> <span id="reduction">0%</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="base64Output" class="form-label">Código Base64 Comprimido:</label>
              <textarea id="base64Output" class="form-control" readonly></textarea>
            </div>

            <div class="d-flex gap-2 flex-wrap">
              <button class="btn btn-success flex-fill" onclick="copyBase64()">
                <i class="fas fa-copy me-1"></i>Copiar Base64
              </button>
              <button class="btn btn-primary flex-fill" onclick="generateImgTag()">
                <i class="fas fa-code me-1"></i>Gerar &lt;img&gt;
              </button>
              <button class="btn btn-info flex-fill" onclick="generateCSSBackground()">
                <i class="fas fa-paint-brush me-1"></i>Gerar CSS
              </button>
            </div>
          </div>
        </div>
        
        <div class="mt-4 p-3 bg-light rounded">
          <h5><i class="fas fa-lightbulb me-2"></i>Dicas para usar Base64 no seu site:</h5>
          <ul class="mb-0">
            <li>Use para imagens pequenas (até 100KB) para reduzir requisições HTTP</li>
            <li>Não use para imagens muito grandes, pois aumenta o tamanho do HTML/CSS</li>
            <li>Teste a compatibilidade com navegadores antigos</li>
            <li>Considere usar WebP para melhor compressão</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script>
    const fileInput = document.getElementById('fileInput');
    const dropZone = document.getElementById('dropZone');
    const preview = document.getElementById('preview');
    const base64Output = document.getElementById('base64Output');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const fileType = document.getElementById('fileType');
    const compressionSection = document.getElementById('compressionSection');
    const qualitySlider = document.getElementById('qualitySlider');
    const qualityValue = document.getElementById('qualityValue');
    const originalSizeElem = document.getElementById('originalSize');
    const compressedSizeElem = document.getElementById('compressedSize');
    const reductionElem = document.getElementById('reduction');
    const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
    
    let originalFile = null;
    let originalFileSize = 0;

    // Configuração do drag and drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
      dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
      e.preventDefault();
      e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
      dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
      dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
      dropZone.classList.add('dragover');
    }

    function unhighlight() {
      dropZone.classList.remove('dragover');
    }

    dropZone.addEventListener('drop', handleDrop, false);
    dropZone.addEventListener('click', () => fileInput.click(), false);
    fileInput.addEventListener('change', handleFileSelect, false);
    
    // Atualizar valor do slider de qualidade
    qualitySlider.addEventListener('input', function() {
      qualityValue.textContent = this.value + '%';
    });

    function handleDrop(e) {
      const dt = e.dataTransfer;
      const files = dt.files;
      
      if (files.length) {
        handleFiles(files);
      }
    }

    function handleFileSelect() {
      if (fileInput.files.length) {
        handleFiles(fileInput.files);
      }
    }

    function handleFiles(files) {
      const file = files[0];
      
      // Verificar se é uma imagem
      if (!file.type.match('image.*')) {
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: 'Por favor, selecione apenas arquivos de imagem!'
        });
        return;
      }
      
      // Verificar tamanho do arquivo
      if (file.size > MAX_FILE_SIZE) {
        Swal.fire({
          icon: 'error',
          title: 'Arquivo muito grande',
          text: 'O arquivo selecionado excede o limite de 5MB. Por favor, selecione um arquivo menor.'
        });
        return;
      }
      
      // Salvar arquivo original
      originalFile = file;
      originalFileSize = file.size;
      
      // Exibir informações do arquivo
      fileName.textContent = file.name;
      fileSize.textContent = formatFileSize(file.size);
      fileType.textContent = file.type;
      fileInfo.classList.remove('d-none');
      compressionSection.classList.remove('d-none');
      
      // Atualizar estatísticas
      originalSizeElem.textContent = formatFileSize(file.size);
      compressedSizeElem.textContent = formatFileSize(file.size);
      reductionElem.textContent = '0%';
      
      // Exibir preview da imagem original
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.innerHTML = `
          <div class="alert alert-info py-2 small" role="alert">
            <i class="fas fa-info-circle me-1"></i>Preview da imagem original
          </div>
          <img src="${e.target.result}" alt="preview" class="preview-img img-thumbnail">
        `;
      };
      reader.readAsDataURL(file);
    }

    function formatFileSize(bytes) {
      if (bytes < 1024) return bytes + ' bytes';
      else if (bytes < 1048576) return (bytes / 1024).toFixed(2) + ' KB';
      else return (bytes / 1048576).toFixed(2) + ' MB';
    }

    function clearSelection() {
      fileInput.value = '';
      preview.innerHTML = '';
      base64Output.value = '';
      fileInfo.classList.add('d-none');
      compressionSection.classList.add('d-none');
      originalFile = null;
    }

    function compressImage() {
      if (!originalFile) {
        Swal.fire({
          icon: 'warning',
          title: 'Ops...',
          text: 'Nenhuma imagem foi selecionada ainda!'
        });
        return;
      }
      
      const quality = parseInt(qualitySlider.value) / 100;
      const maxWidth = parseInt(widthInput.value);
      const removeMetadata = document.getElementById('removeMetadata').checked;
      
      // Mostrar loading
      Swal.fire({
        title: 'Comprimindo...',
        text: 'Por favor, aguarde enquanto processamos sua imagem',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading()
        }
      });
      
      // Processar a imagem
      const reader = new FileReader();
      reader.onload = function(e) {
        const img = new Image();
        img.onload = function() {
          // Calcular novas dimensões mantendo a proporção
          let width = img.width;
          let height = img.height;
          
          if (width > maxWidth) {
            height = (height * maxWidth) / width;
            width = maxWidth;
          }
          
          // Criar canvas para redimensionar e comprimir
          const canvas = document.createElement('canvas');
          canvas.width = width;
          canvas.height = height;
          const ctx = canvas.getContext('2d');
          ctx.drawImage(img, 0, 0, width, height);
          
          // Obter imagem comprimida
          let compressedDataURL;
          if (removeMetadata && originalFile.type === 'image/jpeg') {
            // Para JPEG, podemos remover metadados
            compressedDataURL = canvas.toDataURL('image/jpeg', quality);
          } else {
            compressedDataURL = canvas.toDataURL(originalFile.type, quality);
          }
          
          // Calcular tamanho comprimido
          const compressedSize = compressedDataURL.length - compressedDataURL.indexOf(',') - 1;
          const compressedSizeKB = (compressedSize / 1024).toFixed(2);
          const reduction = ((originalFileSize - compressedSize) / originalFileSize * 100).toFixed(2);
          
          // Atualizar estatísticas
          compressedSizeElem.textContent = formatFileSize(compressedSize);
          reductionElem.textContent = reduction + '%';
          
          // Exibir preview da imagem comprimida
          preview.innerHTML = `
            <div class="alert alert-success py-2 small" role="alert">
              <i class="fas fa-check-circle me-1"></i>Imagem comprimida - ${compressedSizeKB} KB (${reduction}% menor)
            </div>
            <img src="${compressedDataURL}" alt="preview comprimida" class="preview-img img-thumbnail">
          `;
          
          // Exibir código Base64
          base64Output.value = compressedDataURL;
          
          // Fechar loading
          Swal.close();
        };
        img.src = e.target.result;
      };
      reader.readAsDataURL(originalFile);
    }

    function copyBase64() {
      if (!base64Output.value) {
        Swal.fire({
          icon: 'warning',
          title: 'Ops...',
          text: 'Nenhuma imagem foi comprimida ainda!'
        });
        return;
      }
      base64Output.select();
      navigator.clipboard.writeText(base64Output.value);
      Swal.fire({
        icon: 'success',
        title: 'Copiado!',
        text: 'O código Base64 foi copiado para a área de transferência.',
        showConfirmButton: false,
        timer: 2000
      });
    }

    function generateImgTag() {
      if (!base64Output.value) {
        Swal.fire({
          icon: 'warning',
          title: 'Ops...',
          text: 'Nenhuma imagem foi comprimida ainda!'
        });
        return;
      }
      const imgTag = `<img src="${base64Output.value}" alt="imagem">`;
      Swal.fire({
        icon: 'info',
        title: 'Tag &lt;img&gt; pronta!',
        html: `<textarea class="form-control mt-2" rows="3" readonly>${imgTag}</textarea>`,
        width: 600,
        confirmButtonText: 'Fechar'
      });
    }

    function generateCSSBackground() {
      if (!base64Output.value) {
        Swal.fire({
          icon: 'warning',
          title: 'Ops...',
          text: 'Nenhuma imagem foi comprimida ainda!'
        });
        return;
      }
      const cssCode = `background-image: url(${base64Output.value});`;
      Swal.fire({
        icon: 'info',
        title: 'CSS Background pronta!',
        html: `<textarea class="form-control mt-2" rows="3" readonly>${cssCode}</textarea>`,
        width: 600,
        confirmButtonText: 'Fechar'
      });
    }
  </script>
</body>
</html>