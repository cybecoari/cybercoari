<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Gerador de QR Code</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #6e48aa 0%, #9d50bb 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            width: 100%;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.97);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        header {
            background: linear-gradient(90deg, #6e48aa 0%, #9d50bb 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        h1 {
            font-size: 2.3rem;
            margin-bottom: 10px;
        }
        
        .subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .content {
            display: flex;
            flex-wrap: wrap;
            padding: 30px;
            gap: 30px;
        }
        
        .settings-panel {
            flex: 1;
            min-width: 300px;
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .preview-panel {
            flex: 1;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 1.3rem;
            color: #2c3e50;
            border-bottom: 2px solid #6e48aa;
            padding-bottom: 8px;
        }
        
        .section-title i {
            margin-right: 10px;
            color: #6e48aa;
            font-size: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 18px;
        }
        
        label {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            font-weight: 600;
            color: #34495e;
        }
        
        label i {
            margin-right: 8px;
            font-size: 1.2rem;
        }
        
        input[type="text"], input[type="color"], select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        input[type="text"]:focus, select:focus {
            border-color: #6e48aa;
            outline: none;
            box-shadow: 0 0 0 3px rgba(110, 72, 170, 0.2);
        }
        
        .color-picker {
            display: flex;
            gap: 15px;
        }
        
        .color-option {
            flex: 1;
        }
        
        .qr-container {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 300px;
            width: 100%;
        }
        
        #qrcode {
            padding: 15px;
            background: white;
            border-radius: 10px;
        }
        
        .btn-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .download-btn {
            background: linear-gradient(90deg, #6e48aa 0%, #9d50bb 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            flex: 1;
            min-width: 200px;
        }
        
        .download-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        
        .tips {
            background: #f0e6ff;
            border-left: 5px solid #6e48aa;
            padding: 20px;
            border-radius: 0 10px 10px 0;
            margin-top: 25px;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            background: #f1f3f5;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }
            
            h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Container principal -->
    <div class="container">
        <header>
            <h1><i class="bi bi-qr-code"></i> Meu Gerador de QR Code</h1>
            <p class="subtitle">Crie QR codes personalizados</p>
        </header>
        
        <div class="content">
            <div class="settings-panel">
                <div class="section">
                    <div class="section-title">
                        <i class="bi bi-sliders"></i>
                        <h2>Configurações</h2>
                    </div>
                    
                    <div class="form-group">
                        <label for="qr-content">
                            <i class="bi bi-link-45deg"></i> Conteúdo do QR Code
                        </label>
                        
    <input type="text" id="qr-content" placeholder="https://cybercoari.com.br" value="https://cybercoari.com.br">
                    </div>
    
    <!-- gera o qrcode -->                
      <div class="preview-panel">
                <div class="section">
                    <div class="section-title">
                        <i class="bi bi-qr-code"></i>
                        <h1>Visualização</h1>
                    </div>
                    <div class="qr-container">
                        <div id="qrcode"></div>
                    </div>
                    
                     <button id="generate-btn" class="download-btn">
                        <i class="bi bi-arrow-clockwise"></i> Gerar QR Code
                    </button><br>
    
    <button id="download-btn" class="download-btn">
                        <i class="bi bi-download"></i> Baixar QR Code
                    </button>
                    
                </div>
            </div>
        </div>
        
        <!-- -->
         <button id="generate-btn" class="download-btn">
                        <i class="bi bi-arrow-clockwise"></i> Gerar QR Code
                    </button>
                </div>
            </div>
                        
                        <input type="text" id="qr-content" placeholder="https://cybercoari.com.br" value="https://cybercoari.com.br">
                    </div> 
                    
                    <div class="form-group">
                        <label>
                            <i class="bi bi-palette-fill"></i> Cores
                        </label>
                        <div class="color-picker">
                            <div class="color-option">
                                <label for="qr-color">Cor do QR Code</label>
                                <input type="color" id="qr-color" value="#000000">
                            </div>
                            <div class="color-option">
                                <label for="bg-color">Cor de Fundo</label>
                                <input type="color" id="bg-color" value="#FFFFFF">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="qr-size">
                            <i class="bi bi-arrows-fullscreen"></i> Tamanho
                        </label>
                        <select id="qr-size">
                            <option value="120">Pequeno (120x120)</option>
                            <option value="180" selected>Médio (180x180)</option>
                            <option value="250">Grande (250x250)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="qr-correction">
                            <i class="bi bi-shield-check"></i> Correção de Erros
                        </label>
                        <select id="qr-correction">
                            <option value="L">Baixa (7%)</option>
                            <option value="M" selected>Média (15%)</option>
                            <option value="Q">Alta (25%)</option>
                            <option value="H">Muito Alta (30%)</option>
                        </select>
                    </div>
                    
                   <!-- <button id="generate-btn" class="download-btn">
                        <i class="bi bi-arrow-clockwise"></i> Gerar QR Code
                    </button>
                </div>
            </div>-->
            
            <!--<div class="preview-panel">
                <div class="section">
                    <div class="section-title">
                        <i class="bi bi-qr-code"></i>
                        <h2>Visualização</h2>
                    </div>
                    <div class="qr-container">
                        <div id="qrcode"></div>
                    </div>
                    <button id="download-btn" class="download-btn">
                        <i class="bi bi-download"></i> Baixar QR Code
                    </button>
                </div>
            </div>
        </div>-->
        
        <footer>
            <p>Meu Gerador de QR Code &copy; <span id="current-year"></span></p>
        </footer>
    </div>
    
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('current-year').textContent = new Date().getFullYear();
            
        const qrContent = document.getElementById('qr-content');
        const qrColor = document.getElementById('qr-color');
        const bgColor = document.getElementById('bg-color');
        const qrSize = document.getElementById('qr-size');
        const qrCorrection = document.getElementById('qr-correction');
        const generateBtn = document.getElementById('generate-btn');
        const downloadBtn = document.getElementById('download-btn');
        const qrcodeDiv = document.getElementById('qrcode');
            
            let qrCode = null;
            
            function generateQRCode() {
                if (qrCode) {
                    qrCode.clear();
                    qrcodeDiv.innerHTML = '';
                }
                
                const content = qrContent.value || 'https://cybercoari.com.br';
                const size = parseInt(qrSize.value);
                const color = qrColor.value;
                const bg = bgColor.value;
                const correction = qrCorrection.value;
                
                qrCode = new QRCode(qrcodeDiv, {
                    text: content,
                    width: size,
                    height: size,
                    colorDark: color,
                    colorLight: bg,
                    correctLevel: QRCode.CorrectLevel[correction]
                });
            }
            
            function downloadQRCode() {
                const canvas = qrcodeDiv.querySelector('canvas');
                if (canvas) {
                    const link = document.createElement('a');
                    link.download = 'meu-qrcode.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                }
            }
            
            generateBtn.addEventListener('click', generateQRCode);
            downloadBtn.addEventListener('click', downloadQRCode);
            
            // Gerar QR Code inicial
            generateQRCode();
            
            // Atualizações em tempo real
            qrColor.addEventListener('input', generateQRCode);
            bgColor.addEventListener('input', generateQRCode);
            qrSize.addEventListener('change', generateQRCode);
            qrCorrection.addEventListener('change', generateQRCode);
            qrContent.addEventListener('input', generateQRCode);
        });
    </script>
</body>
</html>