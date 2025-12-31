<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de QR Code</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --success: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --border-radius: 12px;
            --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--dark);
        }

        .container {
            width: 100%;
            max-width: 800px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            margin: 20px;
        }

        .header {
            background: var(--primary);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .header p {
            opacity: 0.9;
        }

        .content {
            padding: 30px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        @media (max-width: 768px) {
            .content {
                grid-template-columns: 1fr;
            }
        }

        .input-section {
            display: flex;
            flex-direction: column;
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
        }

        input, select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: var(--transition);
        }

        input:focus, select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
        }

        .btn:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }

        .btn i {
            font-size: 14px;
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .btn-success {
            background: var(--success);
        }

        .btn-success:hover {
            background: #3aa7d0;
        }

        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        #qrcode {
            padding: 20px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            min-height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .color-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }

        .history-section {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: var(--border-radius);
        }

        .history-title {
            font-size: 18px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .history-list {
            list-style: none;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            background: white;
            border-radius: var(--border-radius);
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .history-item:hover {
            background: #e9ecef;
        }

        .history-url {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-right: 15px;
        }

        .history-actions {
            display: flex;
            gap: 5px;
        }

        .history-btn {
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            font-size: 16px;
            transition: var(--transition);
        }

        .history-btn:hover {
            color: var(--primary);
        }

        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px 20px;
            background: var(--dark);
            color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateY(100px);
            opacity: 0;
            transition: var(--transition);
            z-index: 1000;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast.success {
            background: #28a745;
        }

        .toast.error {
            background: #dc3545;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: white;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-qrcode"></i> Gerador de QR Code</h1>
            <p>Gere QR Codes personalizados para qualquer URL</p>
        </div>

        <div class="content">
            <div class="input-section">
                <div class="input-group">
                    <label for="link-input"><i class="fas fa-link"></i> Digite a URL</label>
                    <input type="text" id="link-input" placeholder="https://cybercoari.com.br" autocomplete="off">
                </div>

                <div class="input-group">
                    <label for="size-select"><i class="fas fa-expand"></i> Tamanho do QR Code</label>
                    <select id="size-select">
                        <option value="200">Pequeno (200x200)</option>
                        <option value="300" selected>M��dio (300x300)</option>
                        <option value="400">Grande (400x400)</option>
                    </select>
                </div>

                <div class="input-group">
                    <label><i class="fas fa-palette"></i> Personalizar cores</label>
                    <div class="color-options">
                        <div>
                            <label for="color-dark">Cor escura</label>
                            <input type="color" id="color-dark" value="#000000">
                        </div>
                        <div>
                            <label for="color-light">Cor clara</label>
                            <input type="color" id="color-light" value="#ffffff">
                        </div>
                    </div>
                </div>

                <button id="generate-btn" class="btn">
                    <i class="fas fa-bolt"></i> Gerar QR Code
                </button>
            </div>

            <div class="qr-section">
                <div id="qrcode">
                    <p class="placeholder">Seu QR Code aparecer�� aqui</p>
                </div>

                <div class="action-buttons">
                    <button id="download-btn" class="btn btn-success" disabled>
                        <i class="fas fa-download"></i> Download
                    </button>
                    <button id="share-btn" class="btn" disabled>
                        <i class="fas fa-share-alt"></i> Compartilhar
                    </button>
                </div>
            </div>
        </div>

        <div class="history-section">
            <h3 class="history-title"><i class="fas fa-history"></i> Hist��rico de QR Codes</h3>
            <ul id="history-list" class="history-list">
                <li class="history-item empty">Nenhum QR Code gerado ainda</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p>Gerador de QR Code &copy; <?php echo date('Y'); ?></p>
    </div>

    <div id="toast" class="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toast-message"></span>
    </div>

    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos DOM
            const linkInput = document.getElementById('link-input');
            const sizeSelect = document.getElementById('size-select');
            const colorDark = document.getElementById('color-dark');
            const colorLight = document.getElementById('color-light');
            const generateBtn = document.getElementById('generate-btn');
            const downloadBtn = document.getElementById('download-btn');
            const shareBtn = document.getElementById('share-btn');
            const qrcodeDiv = document.getElementById('qrcode');
            const historyList = document.getElementById('history-list');
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');

            // Vari��veis
            let qrcode = null;
            let currentQRCodeData = null;
            let history = JSON.parse(localStorage.getItem('qrcodeHistory')) || [];

            // Inicializar
            renderHistory();

            // Event Listeners
            generateBtn.addEventListener('click', generateQRCode);
            downloadBtn.addEventListener('click', downloadQRCode);
            shareBtn.addEventListener('click', shareQRCode);
            
            linkInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') generateQRCode();
            });

            // Gerar QR Code
            function generateQRCode() {
                const link = linkInput.value.trim();
                if (!link) {
                    showToast('Por favor, digite uma URL v��lida', 'error');
                    linkInput.focus();
                    return;
                }

                // Adicionar https:// se n�0�0o tiver protocolo
                let formattedLink = link;
                if (!/^https?:\/\//i.test(link)) {
                    formattedLink = 'https://' + link;
                }

                const size = parseInt(sizeSelect.value);
                const darkColor = colorDark.value;
                const lightColor = colorLight.value;

                // Limpar QR Code anterior
                if (qrcode) {
                    qrcode.clear();
                } else {
                    qrcodeDiv.innerHTML = '';
                }

                // Criar novo QR Code
                qrcode = new QRCode(qrcodeDiv, {
                    text: formattedLink,
                    width: size,
                    height: size,
                    colorDark: darkColor,
                    colorLight: lightColor,
                    correctLevel: QRCode.CorrectLevel.H
                });

                // Habilitar bot�0�1es
                downloadBtn.disabled = false;
                shareBtn.disabled = false;

                // Salvar dados atuais
                currentQRCodeData = {
                    link: formattedLink,
                    size: size,
                    darkColor: darkColor,
                    lightColor: lightColor,
                    timestamp: new Date().toISOString()
                };

                // Adicionar ao hist��rico
                addToHistory(currentQRCodeData);
                
                showToast('QR Code gerado com sucesso!');
            }

            // Download do QR Code
            function downloadQRCode() {
                if (!qrcode) return;
                
                const canvas = qrcodeDiv.querySelector('canvas');
                if (!canvas) return;
                
                const link = document.createElement('a');
                link.download = 'qrcode.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
                
                showToast('Download iniciado!');
            }

            // Compartilhar QR Code
            function shareQRCode() {
                if (!qrcode) return;
                
                const canvas = qrcodeDiv.querySelector('canvas');
                if (!canvas) return;
                
                canvas.toBlob(function(blob) {
                    if (navigator.share) {
                        navigator.share({
                            title: 'QR Code Gerado',
                            text: 'Confira este QR Code que eu gerei!',
                            files: [new File([blob], 'qrcode.png', { type: 'image/png' })]
                        })
                        .then(() => showToast('Compartilhado com sucesso!'))
                        .catch(error => {
                            if (error.name !== 'AbortError') {
                                copyImageToClipboard(blob);
                            }
                        });
                    } else {
                        copyImageToClipboard(blob);
                    }
                });
            }

            // Copiar imagem para ��rea de transfer��ncia (fallback)
            function copyImageToClipboard(blob) {
                try {
                    navigator.clipboard.write([
                        new ClipboardItem({ 'image/png': blob })
                    ]).then(() => {
                        showToast('QR Code copiado para a ��rea de transfer��ncia!');
                    }).catch(err => {
                        console.error('Erro ao copiar:', err);
                        showToast('N�0�0o foi poss��vel copiar o QR Code', 'error');
                    });
                } catch (err) {
                    console.error('Erro ao copiar:', err);
                    showToast('Seu navegador n�0�0o suporta esta fun�0�4�0�0o', 'error');
                }
            }

            // Adicionar ao hist��rico
            function addToHistory(data) {
                // Evitar duplicatas
                history = history.filter(item => item.link !== data.link);
                
                // Adicionar no in��cio
                history.unshift(data);
                
                // Manter apenas os 10 mais recentes
                if (history.length > 10) {
                    history.pop();
                }
                
                // Salvar no localStorage
                localStorage.setItem('qrcodeHistory', JSON.stringify(history));
                
                // Atualizar a exibi�0�4�0�0o
                renderHistory();
            }

            // Renderizar hist��rico
            function renderHistory() {
                if (history.length === 0) {
                    historyList.innerHTML = '<li class="history-item empty">Nenhum QR Code gerado ainda</li>';
                    return;
                }
                
                historyList.innerHTML = '';
                history.forEach((item, index) => {
                    const li = document.createElement('li');
                    li.className = 'history-item';
                    
                    const url = document.createElement('div');
                    url.className = 'history-url';
                    url.textContent = item.link;
                    url.title = item.link;
                    
                    const actions = document.createElement('div');
                    actions.className = 'history-actions';
                    
                    const viewBtn = document.createElement('button');
                    viewBtn.className = 'history-btn';
                    viewBtn.innerHTML = '<i class="fas fa-eye"></i>';
                    viewBtn.title = 'Visualizar este QR Code';
                    viewBtn.onclick = () => loadFromHistory(item);
                    
                    const deleteBtn = document.createElement('button');
                    deleteBtn.className = 'history-btn';
                    deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
                    deleteBtn.title = 'Remover do hist��rico';
                    deleteBtn.onclick = () => removeFromHistory(index);
                    
                    actions.appendChild(viewBtn);
                    actions.appendChild(deleteBtn);
                    
                    li.appendChild(url);
                    li.appendChild(actions);
                    
                    historyList.appendChild(li);
                });
            }

            // Carregar do hist��rico
            function loadFromHistory(item) {
                linkInput.value = item.link;
                sizeSelect.value = item.size;
                colorDark.value = item.darkColor;
                colorLight.value = item.lightColor;
                
                generateQRCode();
            }

            // Remover do hist��rico
            function removeFromHistory(index) {
                history.splice(index, 1);
                localStorage.setItem('qrcodeHistory', JSON.stringify(history));
                renderHistory();
            }

            // Mostrar toast de notifica�0�4�0�0o
            function showToast(message, type = 'success') {
                toastMessage.textContent = message;
                toast.className = `toast ${type}`;
                toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i> ${toastMessage.outerHTML}`;
                toast.classList.add('show');
                
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }
        });
    </script>
</body>
</html>