<?php
require_once __DIR__ . '/../includes/init.php';
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap e ��cones -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<body class="<?= $tema === 'escuro' ? 'dark-mode bg-dark text-white' : 'bg-light' ?>">
<div class="container mt-4 py-3">
    <a href="/painel.php" class="btn btn-outline-primary mb-3">
        <i class="bi bi-arrow-left-circle"></i> Voltar para o Painel
    </a>

    <div class="card <?= $tema === 'escuro' ? 'bg-dark border-light' : 'bg-white border-dark' ?>">
        <div class="card-header bg-primary text-white">
            <h2 class="text-center mb-0"><i class="bi bi-image"></i> Compressor Inteligente</h2>
        </div>
        <div class="card-body">

            <!-- Upload -->
            <div class="mb-3">
                <label class="form-label">Selecione sua imagem (JPG, PNG, WEBP):</label>
                <input type="file" id="imageInput" class="form-control" accept="image/jpeg, image/png, image/webp">
            </div>

            <!-- Opções -->
            <div class="mb-3">
                <label class="form-label">Técnica de Compressão:</label>
                <select id="compressionType" class="form-select">
                    <option value="smart">Redimensionamento Inteligente</option>
                    <option value="lossless">Compressão Lossless (PNG apenas)</option>
                    <option value="webp">Conversão para WEBP</option>
                </select>
            </div>

            <div id="qualityControl" class="mb-3">
                <label class="form-label">Qualidade: <span id="qualityValue">95</span>%</label>
                <input type="range" class="form-range" id="qualitySlider" min="80" max="100" value="95">
                <small class="text-muted">(Acima de 95% preserva melhor a qualidade)</small>
            </div>

            <div id="resizeControl" class="mb-3">
                <label class="form-label">Largura máxima (px):</label>
                <input type="number" id="maxWidth" class="form-control" value="1920" min="100" max="3840">
                <small class="text-muted">A altura será ajustada proporcionalmente</small>
            </div>

            <!-- Botão -->
            <button id="compressBtn" class="btn btn-primary w-100 py-2 mb-3">
                <i class="bi bi-gear"></i> Otimizar Imagem
            </button>

            <!-- Resultados -->
            <div id="results" style="display:none;">
                <hr>
                <h5 class="text-center mb-3">Resultados da Otimização</h5>
                <div class="comparison-container">
                    <div class="comparison-box">
                        <h6>Original</h6>
                        <img id="originalPreview" class="img-fluid rounded border border-secondary">
                        <div class="mt-2"><span id="originalSize" class="badge bg-secondary"></span></div>
                    </div>
                    <div class="comparison-box">
                        <h6>Otimizada</h6>
                        <img id="compressedPreview" class="img-fluid rounded border border-primary">
                        <div class="mt-2"><span id="compressedSize" class="badge bg-primary"></span></div>
                    </div>
                </div>
                <button id="downloadBtn" class="btn btn-success w-100 mt-3">
                    <i class="bi bi-download"></i> Baixar Imagem Otimizada
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Rodapé -->
<?php 
$anoAtual = date("Y");
$versaoSistema = "1.0";
$usuarioNome = $_SESSION['usuario_nome'] ?? "Sistema";
?>
<footer class="text-center mt-4 py-3 border-top">
    <p class="mb-1">&copy; <?= $anoAtual ?> - <?= htmlspecialchars($usuarioNome) ?> | Versão <?= $versaoSistema ?></p>
</footer>

<?php include __DIR__ . "/../includes/footer.php"; ?>

<style>
    .comparison-container { display: flex; gap: 20px; flex-wrap: wrap; }
    .comparison-box { flex: 1; text-align: center; }
    .comparison-box img { max-width: 100%; height: auto; }
</style>

<script>
const imageInput = document.getElementById('imageInput');
const compressionType = document.getElementById('compressionType');
const qualitySlider = document.getElementById('qualitySlider');
const qualityValue = document.getElementById('qualityValue');
const maxWidth = document.getElementById('maxWidth');
const compressBtn = document.getElementById('compressBtn');
const results = document.getElementById('results');
const originalPreview = document.getElementById('originalPreview');
const compressedPreview = document.getElementById('compressedPreview');
const originalSize = document.getElementById('originalSize');
const compressedSize = document.getElementById('compressedSize');
const downloadBtn = document.getElementById('downloadBtn');

let originalImage = null;
let optimizedImageBlob = null;

qualitySlider.addEventListener('input', () => {
    qualityValue.textContent = qualitySlider.value;
});

compressionType.addEventListener('change', () => {
    if (compressionType.value === 'smart' || compressionType.value === 'webp') {
        document.getElementById('resizeControl').style.display = 'block';
        document.getElementById('qualityControl').style.display = 'block';
    } else {
        document.getElementById('resizeControl').style.display = 'none';
        document.getElementById('qualityControl').style.display = 'none';
    }
});

imageInput.addEventListener('change', (e) => {
    if (e.target.files.length === 0) return;
    const file = e.target.files[0];
    originalImage = file;

    const reader = new FileReader();
    reader.onload = (event) => {
        originalPreview.src = event.target.result;
        originalSize.textContent = formatFileSize(file.size);
    };
    reader.readAsDataURL(file);
    results.style.display = 'none';
});

compressBtn.addEventListener('click', async () => {
    if (!originalImage) {
        Swal.fire({ icon: 'error', title: 'Erro', text: 'Selecione uma imagem primeiro!' });
        new Audio('https://cybercoari.com.br/cyber/audio/erro.mp3').play();
        return;
    }
    compressBtn.disabled = true;
    compressBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Processando...';

    try {
        const type = compressionType.value;
        const quality = parseInt(qualitySlider.value) / 100;
        const maxWidthValue = parseInt(maxWidth.value);
        optimizedImageBlob = await processImage(originalImage, type, quality, maxWidthValue);
        compressedPreview.src = URL.createObjectURL(optimizedImageBlob);
        compressedSize.textContent = formatFileSize(optimizedImageBlob.size);
        results.style.display = 'block';

        Swal.fire({ icon: 'success', title: 'Sucesso', text: 'Imagem otimizada com sucesso!' });
        new Audio('https://cybercoari.com.br/cyber/audio/sucesso.mp3').play();
    } catch (error) {
        Swal.fire({ icon: 'error', title: 'Erro', text: 'Falha ao processar imagem.' });
        new Audio('https://cybercoari.com.br/cyber/audio/erro.mp3').play();
    } finally {
        compressBtn.disabled = false;
        compressBtn.innerHTML = '<i class="bi bi-gear"></i> Otimizar Imagem';
    }
});

downloadBtn.addEventListener('click', () => {
    if (!optimizedImageBlob) return;
    const a = document.createElement('a');
    a.href = URL.createObjectURL(optimizedImageBlob);
    a.download = getOptimizedFileName(originalImage.name, compressionType.value);
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(a.href);

    Swal.fire({ icon: 'info', title: 'Download', text: 'Imagem baixada com sucesso!' });
    new Audio('https://cybercoari.com.br/cyber/audio/copiado.mp3').play();
});

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024, sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function getOptimizedFileName(originalName, type) {
    const ext = originalName.split('.').pop().toLowerCase();
    const nameWithoutExt = originalName.substring(0, originalName.lastIndexOf('.'));
    if (type === 'webp') return `${nameWithoutExt}.webp`;
    if (type === 'lossless' && ext !== 'png') return `${nameWithoutExt}_optimized.png`;
    return `${nameWithoutExt}_optimized.${ext}`;
}

async function processImage(file, type, quality, maxWidth) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = (event) => {
            const img = new Image();
            img.onload = () => {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                let width = img.width, height = img.height;
                if (width > maxWidth) {
                    height = Math.round((height * maxWidth) / width);
                    width = maxWidth;
                }
                canvas.width = width;
                canvas.height = height;
                ctx.imageSmoothingQuality = 'high';
                ctx.drawImage(img, 0, 0, width, height);

                let mimeType;
                if (type === 'webp') mimeType = 'image/webp';
                else if (type === 'lossless' && file.type.includes('png')) mimeType = 'image/png';
                else mimeType = file.type || 'image/jpeg';

                canvas.toBlob((blob) => {
                    if (!blob) return reject(new Error('Falha na otimização'));
                    resolve(blob);
                }, mimeType, quality);
            };
            img.onerror = () => reject(new Error('Erro ao carregar imagem'));
            img.src = event.target.result;
        };
        reader.onerror = () => reject(new Error('Erro ao ler arquivo'));
        reader.readAsDataURL(file);
    });
}
</script>
</body>
</html>