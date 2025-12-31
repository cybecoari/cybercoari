<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner de Portas e Hosts</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1a2a6c, #2a5298);
            color: #fff;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .card-description {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .scanner-card {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }
        
        .input-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .input-field {
            flex: 1;
            min-width: 250px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        input, select {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            font-size: 1rem;
        }
        
        input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .btn {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn-stop {
            background: linear-gradient(to right, #ff758c, #ff7eb3);
        }
        
        .results {
            margin-top: 30px;
        }
        
        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .results-title {
            font-size: 1.5rem;
        }
        
        .results-content {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 15px;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .result-item {
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
        }
        
        .result-item:last-child {
            border-bottom: none;
        }
        
        .port-open {
            color: #4ade80;
        }
        
        .port-closed {
            color: #f87171;
        }
        
        .progress-bar {
            height: 6px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            margin-top: 10px;
            overflow: hidden;
        }
        
        .progress {
            height: 100%;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            width: 0%;
            transition: width 0.3s ease;
        }
        
        .status {
            margin-top: 15px;
            font-style: italic;
            opacity: 0.8;
        }
        
        @media (max-width: 768px) {
            .input-group {
                flex-direction: column;
            }
            
            .input-field {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Scanner de Portas e Hosts</h1>
            <p class="card-description">Identifique portas abertas e hosts ativos na sua rede</p>
        </header>
        
        <div class="scanner-card">
            <div class="input-group">
                <div class="input-field">
                    <label for="host">Host ou IP:</label>
                    <input type="text" id="host" placeholder="Ex: 192.168.1.1 ou exemplo.com">
                </div>
                
                <div class="input-field">
                    <label for="ports">Portas:</label>
                    <input type="text" id="ports" placeholder="Ex: 80,443 ou 1-1000">
                </div>
                
                <div class="input-field">
                    <label for="speed">Velocidade:</label>
                    <select id="speed">
                        <option value="slow">Lenta</option>
                        <option value="medium" selected>Média</option>
                        <option value="fast">Rápida</option>
                    </select>
                </div>
            </div>
            
            <div class="input-group">
                <button id="scan-btn" class="btn">Iniciar Escaneamento</button>
                <button id="stop-btn" class="btn btn-stop" disabled>Parar</button>
            </div>
            
            <div class="progress-bar">
                <div id="progress" class="progress"></div>
            </div>
            
            <div id="status" class="status">Pronto para escanear...</div>
        </div>
        
        <div class="scanner-card results">
            <div class="results-header">
                <h2 class="results-title">Resultados</h2>
                <button id="clear-btn" class="btn">Limpar</button>
            </div>
            
            <div id="results-content" class="results-content">
                <div class="result-item">
                    <span>Os resultados do scan aparecerão aqui</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scanBtn = document.getElementById('scan-btn');
            const stopBtn = document.getElementById('stop-btn');
            const clearBtn = document.getElementById('clear-btn');
            const hostInput = document.getElementById('host');
            const portsInput = document.getElementById('ports');
            const progressBar = document.getElementById('progress');
            const statusText = document.getElementById('status');
            const resultsContent = document.getElementById('results-content');
            
            let isScanning = false;
            let scanTimer = null;
            
            // Função para validar o formato do host
            function isValidHost(host) {
                // Validação simples de IP ou domínio
                const ipRegex = /^(\d{1,3}\.){3}\d{1,3}$/;
                const domainRegex = /^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})+$/;
                
                return ipRegex.test(host) || domainRegex.test(host);
            }
            
            // Função para validar o formato das portas
            function parsePorts(portsText) {
                const ports = [];
                
                // Verifica se é um intervalo (ex: 1-1000)
                if (portsText.includes('-')) {
                    const [start, end] = portsText.split('-').map(p => parseInt(p.trim()));
                    
                    if (!isNaN(start) && !isNaN(end) && start > 0 && end <= 65535 && start <= end) {
                        for (let i = start; i <= end; i++) {
                            ports.push(i);
                        }
                    }
                } 
                // Verifica se é uma lista de portas (ex: 80,443,22)
                else if (portsText.includes(',')) {
                    portsText.split(',').forEach(port => {
                        const portNum = parseInt(port.trim());
                        if (!isNaN(portNum) && portNum > 0 && portNum <= 65535) {
                            ports.push(portNum);
                        }
                    });
                } 
                // Porta única
                else {
                    const portNum = parseInt(portsText.trim());
                    if (!isNaN(portNum) && portNum > 0 && portNum <= 65535) {
                        ports.push(portNum);
                    }
                }
                
                return ports;
            }
            
            // Função para simular o escaneamento (em um cenário real, isso seria feito com WebSockets ou outra tecnologia)
            function simulatePortScan(host, ports, speed) {
                isScanning = true;
                scanBtn.disabled = true;
                stopBtn.disabled = false;
                
                let delay;
                switch(speed) {
                    case 'slow': delay = 200; break;
                    case 'fast': delay = 50; break;
                    default: delay = 100;
                }
                
                let scanned = 0;
                const total = ports.length;
                
                resultsContent.innerHTML = '';
                statusText.textContent = 'Escaneando...';
                
                scanTimer = setInterval(() => {
                    if (scanned >= total) {
                        stopScan();
                        statusText.textContent = 'Escaneamento concluído!';
                        return;
                    }
                    
                    const port = ports[scanned];
                    // Simula se a porta está aberta (apenas para demonstração)
                    const isOpen = Math.random() > 0.7;
                    
                    const resultItem = document.createElement('div');
                    resultItem.className = 'result-item';
                    
                    const portText = document.createElement('span');
                    portText.textContent = `Porta ${port}`;
                    
                    const statusSpan = document.createElement('span');
                    statusSpan.textContent = isOpen ? 'ABERTA' : 'FECHADA';
                    statusSpan.className = isOpen ? 'port-open' : 'port-closed';
                    
                    resultItem.appendChild(portText);
                    resultItem.appendChild(statusSpan);
                    resultsContent.appendChild(resultItem);
                    
                    // Atualiza a barra de progresso
                    const progressPercent = (scanned / total) * 100;
                    progressBar.style.width = `${progressPercent}%`;
                    
                    scanned++;
                    statusText.textContent = `Escaneando... ${scanned}/${total} portas`;
                    
                    // Rolagem automática para o resultado mais recente
                    resultsContent.scrollTop = resultsContent.scrollHeight;
                }, delay);
            }
            
            // Função para parar o escaneamento
            function stopScan() {
                clearInterval(scanTimer);
                isScanning = false;
                scanBtn.disabled = false;
                stopBtn.disabled = true;
                statusText.textContent = 'Escaneamento interrompido';
            }
            
            // Evento de clique no botão de escanear
            scanBtn.addEventListener('click', () => {
                const host = hostInput.value.trim();
                const portsText = portsInput.value.trim();
                const speed = document.getElementById('speed').value;
                
                if (!host) {
                    statusText.textContent = 'Por favor, informe um host ou IP';
                    hostInput.focus();
                    return;
                }
                
                if (!isValidHost(host)) {
                    statusText.textContent = 'Por favor, informe um host ou IP válido';
                    hostInput.focus();
                    return;
                }
                
                if (!portsText) {
                    statusText.textContent = 'Por favor, informe as portas a serem escaneadas';
                    portsInput.focus();
                    return;
                }
                
                const ports = parsePorts(portsText);
                if (ports.length === 0) {
                    statusText.textContent = 'Nenhuma porta válida foi informada';
                    portsInput.focus();
                    return;
                }
                
                if (ports.length > 1000) {
                    statusText.textContent = 'Muitas portas para escanear. Por favor, limite a 1000 portas.';
                    portsInput.focus();
                    return;
                }
                
                simulatePortScan(host, ports, speed);
            });
            
            // Evento de clique no botão de parar
            stopBtn.addEventListener('click', stopScan);
            
            // Evento de clique no botão de limpar
            clearBtn.addEventListener('click', () => {
                resultsContent.innerHTML = '';
                progressBar.style.width = '0%';
                statusText.textContent = 'Pronto para escanear...';
            });
        });
    </script>
</body>
</html>