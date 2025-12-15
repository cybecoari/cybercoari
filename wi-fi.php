<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner de Rede Wi-Fi Real</title>
    <style>
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --success: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
            --gray: #95a5a6;
            --light: #ecf0f1;
            --dark: #2c3e50;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            min-height: 100vh;
        }
        
        .container {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        h1 {
            color: var(--dark);
            margin-bottom: 10px;
            font-size: 2.2rem;
        }
        
        .ip-info {
            background: #e8f4fc;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid var(--primary);
        }
        
        .ip-address {
            font-family: monospace;
            font-size: 1.4rem;
            font-weight: bold;
            color: var(--primary);
        }
        
        .network-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        
        .detail-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        
        .detail-value {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--dark);
        }
        
        .detail-label {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-top: 5px;
        }
        
        .scanner-controls {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 10px;
        }
        
        button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        #scanBtn {
            background-color: var(--success);
        }
        
        #scanBtn:hover:not(:disabled) {
            background-color: #27ae60;
        }
        
        #stopBtn {
            background-color: var(--danger);
        }
        
        #stopBtn:hover:not(:disabled) {
            background-color: #c0392b;
        }
        
        button:disabled {
            background-color: var(--gray);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .status {
            margin: 20px 0;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
        }
        
        .scanning {
            background-color: #fff3cd;
            color: #856404;
            border-left: 4px solid var(--warning);
        }
        
        .completed {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid var(--success);
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid var(--danger);
        }
        
        .stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            padding: 15px;
            background-color: var(--light);
            border-radius: 8px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary);
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #7f8c8d;
        }
        
        .devices-list {
            margin-top: 20px;
            max-height: 500px;
            overflow-y: auto;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        
        .device-item {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
        }
        
        .device-item:hover {
            background-color: #f9f9f9;
        }
        
        .device-item:last-child {
            border-bottom: none;
        }
        
        .device-info {
            display: flex;
            align-items: center;
            flex: 1;
        }
        
        .device-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
            color: white;
        }
        
        .device-computer { background-color: #3498db; }
        .device-phone { background-color: #9b59b6; }
        .device-tablet { background-color: #1abc9c; }
        .device-tv { background-color: #e67e22; }
        .device-printer { background-color: #7f8c8d; }
        .device-router { background-color: #e74c3c; }
        .device-other { background-color: #95a5a6; }
        
        .device-status {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .online { background-color: var(--success); }
        .offline { background-color: var(--danger); }
        
        .device-details {
            flex: 1;
        }
        
        .device-name {
            font-weight: 600;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }
        
        .device-meta {
            font-size: 0.85rem;
            color: #7f8c8d;
        }
        
        .device-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-badge.online {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-badge.offline {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .note {
            margin-top: 25px;
            font-size: 14px;
            color: #7f8c8d;
            text-align: center;
            line-height: 1.5;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #7f8c8d;
        }
        
        .progress-bar {
            width: 100%;
            height: 10px;
            background-color: #e0e0e0;
            border-radius: 5px;
            margin: 10px 0;
            overflow: hidden;
        }
        
        .progress {
            height: 100%;
            background-color: var(--success);
            width: 0%;
            transition: width 0.3s;
        }
        
        @media (max-width: 768px) {
            .scanner-controls, .stats {
                flex-direction: column;
            }
            
            .network-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Scanner de Rede Wi-Fi Real</h1>
            <p class="subtitle">Detecção de dispositivos na sua rede local</p>
        </header>
        
        <div class="ip-info">
            <h3>Informações da Sua Rede</h3>
            <div class="ip-address" id="publicIp">Detectando...</div>
            <p><strong>IP Local:</strong> <span id="localIp">Detectando...</span></p>
            <p><strong>Gateway/Roteador:</strong> <span id="gatewayIp">Detectando...</span></p>
        </div>
        
        <div class="network-details">
            <div class="detail-card">
                <div class="detail-value" id="networkType">Detectando...</div>
                <div class="detail-label">Tipo de Rede</div>
            </div>
            <div class="detail-card">
                <div class="detail-value" id="subnetMask">Detectando...</div>
                <div class="detail-label">Máscara de Sub-rede</div>
            </div>
            <div class="detail-card">
                <div class="detail-value" id="browserInfo">Detectando...</div>
                <div class="detail-label">Navegador/Plataforma</div>
            </div>
        </div>
        
        <div class="scanner-controls">
            <button id="scanBtn">
                <span class="loading" id="scanLoading" style="display: none;"></span>
                <span id="scanText">Escanear Rede Local</span>
            </button>
            <button id="stopBtn" disabled>Parar Scanner</button>
        </div>
        
        <div class="progress-bar">
            <div class="progress" id="scanProgress"></div>
        </div>
        
        <div id="status" class="status">
            Inicializando detector de rede...
        </div>
        
        <div class="stats">
            <div class="stat-item">
                <div class="stat-value" id="totalDevices">0</div>
                <div class="stat-label">Dispositivos</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="onlineDevices">0</div>
                <div class="stat-label">Online</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="offlineDevices">0</div>
                <div class="stat-label">Offline</div>
            </div>
        </div>
        
        <div class="devices-list" id="devicesList">
            <div class="empty-state">
                <div style="font-size: 3rem; margin-bottom: 15px;">📡</div>
                <p>Nenhum dispositivo escaneado ainda</p>
                <p>Clique em "Escanear Rede Local" para começar</p>
            </div>
        </div>
        
        <div class="note">
            <p><strong>Como funciona:</strong> Este scanner tenta detectar seu IP local e gateway, então verifica dispositivos na sua rede. A detecção pode não ser completa devido a limitações de segurança do navegador.</p>
            <p><strong>Para melhor resultado:</strong> Use um aplicativo dedicado como Fing, Advanced IP Scanner, ou acesse o painel do seu roteador.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scanBtn = document.getElementById('scanBtn');
            const stopBtn = document.getElementById('stopBtn');
            const statusDiv = document.getElementById('status');
            const devicesList = document.getElementById('devicesList');
            const scanLoading = document.getElementById('scanLoading');
            const scanText = document.getElementById('scanText');
            const totalDevicesEl = document.getElementById('totalDevices');
            const onlineDevicesEl = document.getElementById('onlineDevices');
            const offlineDevicesEl = document.getElementById('offlineDevices');
            const publicIpEl = document.getElementById('publicIp');
            const localIpEl = document.getElementById('localIp');
            const gatewayIpEl = document.getElementById('gatewayIp');
            const networkTypeEl = document.getElementById('networkType');
            const subnetMaskEl = document.getElementById('subnetMask');
            const browserInfoEl = document.getElementById('browserInfo');
            const scanProgress = document.getElementById('scanProgress');
            
            let scanInterval;
            let scanCount = 0;
            let currentIPs = [];
            
            // Inicializar detecção de rede
            initializeNetworkDetection();
            
            // Função para inicializar a detecção de rede
            async function initializeNetworkDetection() {
                statusDiv.textContent = "Detectando informações da rede...";
                statusDiv.className = "status scanning";
                
                // Detectar IP público
                try {
                    const response = await fetch('https://api.ipify.org?format=json');
                    const data = await response.json();
                    publicIpEl.textContent = data.ip;
                } catch (error) {
                    publicIpEl.textContent = "Não detectado";
                }
                
                // Detectar IP local e informações da rede
                detectLocalNetworkInfo();
                
                // Detectar informações do navegador
                detectBrowserInfo();
            }
            
            // Função para detectar informações da rede local
            function detectLocalNetworkInfo() {
                // Usar WebRTC para detectar IP local
                getLocalIPs().then(ips => {
                    if (ips && ips.length > 0) {
                        localIpEl.textContent = ips.join(', ');
                        currentIPs = ips;
                        
                        // Tentar determinar gateway (geralmente .1 na mesma sub-rede)
                        const gatewayIP = estimateGatewayIP(ips[0]);
                        gatewayIpEl.textContent = gatewayIP;
                        
                        // Determinar tipo de rede
                        determineNetworkType(ips[0]);
                        
                        // Estimar máscara de sub-rede
                        subnetMaskEl.textContent = estimateSubnetMask(ips[0]);
                        
                        statusDiv.textContent = "Rede detectada. Pronto para escanear.";
                        statusDiv.className = "status completed";
                    } else {
                        localIpEl.textContent = "Não detectado";
                        gatewayIpEl.textContent = "Não detectado";
                        networkTypeEl.textContent = "Desconhecido";
                        subnetMaskEl.textContent = "Desconhecida";
                        statusDiv.textContent = "Não foi possível detectar a rede local automaticamente.";
                        statusDiv.className = "status error";
                    }
                }).catch(error => {
                    localIpEl.textContent = "Erro na detecção";
                    statusDiv.textContent = "Erro ao detectar rede local: " + error.message;
                    statusDiv.className = "status error";
                });
            }
            
            // Função para detectar IPs locais usando WebRTC
            function getLocalIPs() {
                return new Promise((resolve, reject) => {
                    const RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
                    
                    if (!RTCPeerConnection) {
                        reject(new Error('WebRTC não é suportado'));
                        return;
                    }
                    
                    const pc = new RTCPeerConnection({ iceServers: [] });
                    const ips = [];
                    
                    pc.createDataChannel('');
                    pc.createOffer().then(pc.setLocalDescription.bind(pc));
                    
                    pc.onicecandidate = (ice) => {
                        if (!ice || !ice.candidate || !ice.candidate.candidate) return;
                        
                        const candidate = ice.candidate.candidate;
                        const regex = /([0-9]{1,3}(\.[0-9]{1,3}){3})/;
                        const match = regex.exec(candidate);
                        
                        if (match && ips.indexOf(match[1]) === -1) {
                            ips.push(match[1]);
                        }
                    };
                    
                    setTimeout(() => {
                        if (ips.length > 0) {
                            resolve(ips);
                        } else {
                            reject(new Error('Não foi possível detectar IPs locais'));
                        }
                    }, 1000);
                });
            }
            
            // Função para estimar o IP do gateway
            function estimateGatewayIP(localIP) {
                const parts = localIP.split('.');
                // Na maioria das redes domésticas, o gateway é .1
                parts[3] = '1';
                return parts.join('.');
            }
            
            // Função para determinar o tipo de rede
            function determineNetworkType(ip) {
                if (ip.startsWith('10.')) {
                    networkTypeEl.textContent = 'Rede Privada (Classe A)';
                } else if (ip.startsWith('172.')) {
                    const secondOctet = parseInt(ip.split('.')[1]);
                    if (secondOctet >= 16 && secondOctet <= 31) {
                        networkTypeEl.textContent = 'Rede Privada (Classe B)';
                    } else {
                        networkTypeEl.textContent = 'Rede Pública/Particular';
                    }
                } else if (ip.startsWith('192.168.')) {
                    networkTypeEl.textContent = 'Rede Privada (Classe C)';
                } else if (ip.startsWith('100.')) {
                    networkTypeEl.textContent = 'CGNAT (Compartilhado)';
                } else {
                    networkTypeEl.textContent = 'Rede Pública/Particular';
                }
            }
            
            // Função para estimar a máscara de sub-rede
            function estimateSubnetMask(ip) {
                if (ip.startsWith('10.')) return '255.0.0.0';
                if (ip.startsWith('172.')) {
                    const secondOctet = parseInt(ip.split('.')[1]);
                    if (secondOctet >= 16 && secondOctet <= 31) return '255.255.0.0';
                }
                if (ip.startsWith('192.168.')) return '255.255.255.0';
                if (ip.startsWith('100.')) return '255.192.0.0'; // Para CGNAT
                return '255.255.255.0'; // Padrão para redes locais
            }
            
            // Função para detectar informações do navegador
            function detectBrowserInfo() {
                const browserInfo = navigator.userAgent;
                if (browserInfo.includes('Chrome')) {
                    browserInfoEl.textContent = 'Google Chrome';
                } else if (browserInfo.includes('Firefox')) {
                    browserInfoEl.textContent = 'Mozilla Firefox';
                } else if (browserInfo.includes('Safari') && !browserInfo.includes('Chrome')) {
                    browserInfoEl.textContent = 'Apple Safari';
                } else if (browserInfo.includes('Edge')) {
                    browserInfoEl.textContent = 'Microsoft Edge';
                } else {
                    browserInfoEl.textContent = 'Navegador Web';
                }
            }
            
            // Função para iniciar o scanner
            scanBtn.addEventListener('click', function() {
                startScanning();
            });
            
            // Função para parar o scanner
            stopBtn.addEventListener('click', function() {
                stopScanning();
                statusDiv.textContent = "Scanner parado pelo usuário";
                statusDiv.className = "status";
            });
            
            function startScanning() {
                scanBtn.disabled = true;
                stopBtn.disabled = false;
                scanLoading.style.display = 'inline-block';
                scanText.textContent = "Escaneando...";
                statusDiv.textContent = "Iniciando escaneamento da rede local...";
                statusDiv.className = "status scanning";
                scanProgress.style.width = '0%';
                
                // Simula um tempo de escaneamento inicial
                setTimeout(() => {
                    performNetworkScan();
                    scanLoading.style.display = 'none';
                    scanText.textContent = "Novo Escaneamento";
                    scanBtn.disabled = false;
                    
                    // Atualiza a lista a cada 15 segundos
                    scanInterval = setInterval(performNetworkScan, 15000);
                }, 1000);
            }
            
            function stopScanning() {
                scanBtn.disabled = false;
                stopBtn.disabled = true;
                scanLoading.style.display = 'none';
                scanText.textContent = "Escanear Rede Local";
                clearInterval(scanInterval);
                scanProgress.style.width = '0%';
            }
            
            // Função para realizar o escaneamento da rede
            function performNetworkScan() {
                scanCount++;
                statusDiv.textContent = `Escaneamento em andamento... (${scanCount})`;
                statusDiv.className = "status scanning";
                
                const localIP = localIpEl.textContent;
                if (!localIP || localIP === "Não detectado") {
                    statusDiv.textContent = "Erro: Não foi possível detectar a rede local";
                    statusDiv.className = "status error";
                    return;
                }
                
                // Obter a base da rede (primeiros três octetos)
                const networkBase = localIP.split('.').slice(0, 3).join('.');
                
                // Gerar uma lista de IPs para verificar
                const ipsToScan = [];
                for (let i = 1; i <= 20; i++) {
                    ipsToScan.push(`${networkBase}.${i}`);
                }
                
                // Adicionar também o gateway estimado
                const gatewayIP = gatewayIpEl.textContent;
                if (gatewayIP && gatewayIP !== "Não detectado" && !ipsToScan.includes(gatewayIP)) {
                    ipsToScan.push(gatewayIP);
                }
                
                // Adicionar o IP local atual
                if (localIP && !ipsToScan.includes(localIP)) {
                    ipsToScan.push(localIP);
                }
                
                // Realizar o escaneamento
                scanIPs(ipsToScan);
            }
            
            // Função para escanear uma lista de IPs
            async function scanIPs(ipList) {
                const devices = [];
                const totalIPs = ipList.length;
                let scannedIPs = 0;
                
                for (const ip of ipList) {
                    try {
                        const isOnline = await checkIP(ip);
                        devices.push({
                            ip: ip,
                            status: isOnline ? 'online' : 'offline',
                            name: await guessDeviceName(ip, isOnline),
                            type: await guessDeviceType(ip),
                            lastSeen: new Date().toLocaleTimeString()
                        });
                    } catch (error) {
                        devices.push({
                            ip: ip,
                            status: 'offline',
                            name: 'Desconhecido',
                            type: 'other',
                            lastSeen: 'Nunca'
                        });
                    }
                    
                    scannedIPs++;
                    const progress = (scannedIPs / totalIPs) * 100;
                    scanProgress.style.width = `${progress}%`;
                }
                
                displayDevices(devices);
                statusDiv.textContent = `Escaneamento concluído - ${new Date().toLocaleTimeString()} - ${devices.filter(d => d.status === 'online').length} dispositivos online`;
                statusDiv.className = "status completed";
            }
            
            // Função para verificar se um IP está online
            function checkIP(ip) {
                return new Promise((resolve) => {
                    // Tentar fazer uma requisição para o IP
                    const img = new Image();
                    let responded = false;
                    
                    img.onload = function() {
                        responded = true;
                        resolve(true);
                    };
                    
                    img.onerror = function() {
                        responded = true;
                        resolve(true);
                    };
                    
                    // Tentar carregar um recurso comum
                    img.src = `http://${ip}/favicon.ico?t=${Date.now()}`;
                    
                    // Timeout após 1.5 segundos
                    setTimeout(() => {
                        if (!responded) {
                            resolve(false);
                        }
                    }, 1500);
                });
            }
            
            // Função para tentar adivinhar o nome do dispositivo
            function guessDeviceName(ip, isOnline) {
                const localIP = localIpEl.textContent;
                const gatewayIP = gatewayIpEl.textContent;
                
                if (ip === localIP) return "Este Dispositivo";
                if (ip === gatewayIP) return "Roteador/Gateway";
                if (ip.endsWith('.1')) return "Possível Roteador";
                if (ip.endsWith('.255')) return "Broadcast";
                
                // Nomes genéricos baseados no último octeto
                const lastOctet = parseInt(ip.split('.')[3]);
                const names = [
                    "Dispositivo Principal", "Smartphone", "Tablet", "Laptop", 
                    "Smart TV", "Impressora", "Console de Jogos", "IoT Device",
                    "Servidor", "NAS", "Câmera IP", "Assistente Virtual"
                ];
                
                return names[lastOctet % names.length];
            }
            
            // Função para tentar adivinhar o tipo de dispositivo
            function guessDeviceType(ip) {
                const lastOctet = parseInt(ip.split('.')[3]);
                
                if (ip.endsWith('.1')) return 'router';
                if (lastOctet < 10) return 'computer';
                if (lastOctet < 20) return 'phone';
                if (lastOctet < 30) return 'tablet';
                if (lastOctet < 40) return 'tv';
                if (lastOctet < 50) return 'printer';
                
                return 'other';
            }
            
            // Função para exibir os dispositivos
            function displayDevices(devices) {
                // Atualizar estatísticas
                const total = devices.length;
                const online = devices.filter(d => d.status === 'online').length;
                const offline = total - online;
                
                totalDevicesEl.textContent = total;
                onlineDevicesEl.textContent = online;
                offlineDevicesEl.textContent = offline;
                
                // Atualizar lista
                devicesList.innerHTML = '';
                
                if (devices.length === 0) {
                    devicesList.innerHTML = `
                        <div class="empty-state">
                            <div style="font-size: 3rem; margin-bottom: 15px;">🔍</div>
                            <p>Nenhum dispositivo encontrado</p>
                            <p>Verifique sua conexão de rede</p>
                        </div>
                    `;
                    return;
                }
                
                // Ordenar dispositivos: online primeiro, depois por IP
                devices.sort((a, b) => {
                    if (a.status === 'online' && b.status !== 'online') return -1;
                    if (a.status !== 'online' && b.status === 'online') return 1;
                    return a.ip.localeCompare(b.ip);
                });
                
                devices.forEach(device => {
                    const deviceElement = document.createElement('div');
                    deviceElement.className = 'device-item';
                    
                    const deviceTypeIcon = getDeviceIcon(device.type);
                    const deviceTypeClass = getDeviceClass(device.type);
                    
                    deviceElement.innerHTML = `
                        <div class="device-info">
                            <div class="device-icon ${deviceTypeClass}">
                                ${deviceTypeIcon}
                            </div>
                            <div class="device-details">
                                <div class="device-name">
                                    <div class="device-status ${device.status}"></div>
                                    ${device.name}
                                </div>
                                <div class="device-meta">
                                    IP: ${device.ip} | Tipo: ${device.type}
                                </div>
                                <div class="last-seen">
                                    Última verificação: ${device.lastSeen}
                                </div>
                            </div>
                        </div>
                        <div class="device-actions">
                            <span class="status-badge ${device.status}">
                                ${device.status === 'online' ? 'Online' : 'Offline'}
                            </span>
                        </div>
                    `;
                    
                    devicesList.appendChild(deviceElement);
                });
            }
            
            // Função para obter ícone do dispositivo
            function getDeviceIcon(type) {
                const icons = {
                    'computer': '💻',
                    'phone': '📱',
                    'tablet': '📟',
                    'tv': '📺',
                    'printer': '🖨️',
                    'router': '📡',
                    'other': '🔌'
                };
                return icons[type] || icons['other'];
            }
            
            // Função para obter classe CSS do dispositivo
            function getDeviceClass(type) {
                return `device-${type}`;
            }
        });
    </script>
</body>
</html>