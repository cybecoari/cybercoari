<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner de Rede Wi-Fi Real</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .device {
            padding: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }
        .online { color: green; }
        .offline { color: red; }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:disabled {
            background: #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Scanner de Rede Wi-Fi</h1>
        
        <div id="networkInfo">
            <p><strong>Seu IP Local:</strong> <span id="localIp">Detectando...</span></p>
            <p><strong>Rede a Escanear:</strong> <span id="networkRange">Detectando...</span></p>
        </div>
        
        <button id="scanBtn">Iniciar Escaneamento</button>
        <button id="stopBtn" disabled>Parar</button>
        
        <div id="status" style="margin: 10px 0; padding: 10px; background: #e9ecef; border-radius: 5px;">
            Pronto para escanear
        </div>
        
        <div id="results">
            <h3>Dispositivos Encontrados:</h3>
            <div id="devicesList"></div>
        </div>
    </div>

    <script>
        class NetworkScanner {
            constructor() {
                this.isScanning = false;
                this.foundDevices = [];
                this.scanBtn = document.getElementById('scanBtn');
                this.stopBtn = document.getElementById('stopBtn');
                this.status = document.getElementById('status');
                this.devicesList = document.getElementById('devicesList');
                this.localIpEl = document.getElementById('localIp');
                this.networkRangeEl = document.getElementById('networkRange');
                
                this.init();
            }
            
            async init() {
                await this.detectNetworkInfo();
                this.setupEventListeners();
            }
            
            async detectNetworkInfo() {
                try {
                    const localIP = await this.getLocalIP();
                    if (localIP) {
                        this.localIpEl.textContent = localIP;
                        
                        // Determinar faixa de rede (assume /24)
                        const networkBase = localIP.split('.').slice(0, 3).join('.');
                        this.networkRange = `${networkBase}.1-254`;
                        this.networkRangeEl.textContent = this.networkRange;
                    }
                } catch (error) {
                    this.localIpEl.textContent = 'Não detectado';
                    this.networkRangeEl.textContent = 'Não detectada';
                }
            }
            
            getLocalIP() {
                return new Promise((resolve) => {
                    const RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
                    
                    if (!RTCPeerConnection) {
                        resolve(null);
                        return;
                    }
                    
                    const pc = new RTCPeerConnection({ iceServers: [] });
                    pc.createDataChannel('');
                    pc.createOffer().then(pc.setLocalDescription.bind(pc));
                    
                    pc.onicecandidate = (ice) => {
                        if (!ice || !ice.candidate || !ice.candidate.candidate) return;
                        const myIP = /([0-9]{1,3}(\.[0-9]{1,3}){3})/.exec(ice.candidate.candidate)[1];
                        resolve(myIP);
                        pc.onicecandidate = () => {};
                        pc.close();
                    };
                });
            }
            
            setupEventListeners() {
                this.scanBtn.addEventListener('click', () => this.startScan());
                this.stopBtn.addEventListener('click', () => this.stopScan());
            }
            
            async startScan() {
                this.isScanning = true;
                this.scanBtn.disabled = true;
                this.stopBtn.disabled = false;
                this.foundDevices = [];
                this.devicesList.innerHTML = '';
                
                this.status.textContent = 'Iniciando escaneamento...';
                this.status.style.background = '#fff3cd';
                
                const localIP = this.localIpEl.textContent;
                if (!localIP || localIP === 'Não detectado') {
                    this.status.textContent = 'Erro: Não foi possível detectar a rede local';
                    this.status.style.background = '#f8d7da';
                    return;
                }
                
                const networkBase = localIP.split('.').slice(0, 3).join('.');
                
                // Escanear IPs de 1 a 20 (limitado para demonstração)
                for (let i = 1; i <= 20 && this.isScanning; i++) {
                    const ip = `${networkBase}.${i}`;
                    await this.checkDevice(ip);
                    this.status.textContent = `Escaneando... Verificado ${i}/20`;
                }
                
                this.finishScan();
            }
            
            async checkDevice(ip) {
                return new Promise((resolve) => {
                    // Tentativa 1: Usando fetch para verificar se há um servidor web
                    fetch(`http://${ip}`, { 
                        method: 'HEAD',
                        mode: 'no-cors',
                        cache: 'no-cache'
                    })
                    .then(() => {
                        this.addDevice(ip, 'online', 'Servidor Web');
                        resolve(true);
                    })
                    .catch(() => {
                        // Tentativa 2: Usando Image para verificar se responde
                        const img = new Image();
                        img.onload = () => {
                            this.addDevice(ip, 'online', 'Dispositivo com serviço web');
                            resolve(true);
                        };
                        img.onerror = () => {
                            this.addDevice(ip, 'online', 'Dispositivo responde');
                            resolve(true);
                        };
                        
                        // Timeout após 1 segundo
                        setTimeout(() => {
                            // Se chegou aqui, provavelmente offline
                            resolve(false);
                        }, 1000);
                        
                        img.src = `http://${ip}/favicon.ico?t=${Date.now()}`;
                    });
                });
            }
            
            addDevice(ip, status, info) {
                const device = {
                    ip,
                    status,
                    info,
                    timestamp: new Date().toLocaleTimeString()
                };
                
                this.foundDevices.push(device);
                this.updateDevicesList();
            }
            
            updateDevicesList() {
                this.devicesList.innerHTML = '';
                
                this.foundDevices.forEach(device => {
                    const deviceEl = document.createElement('div');
                    deviceEl.className = `device ${device.status}`;
                    deviceEl.innerHTML = `
                        <div>
                            <strong>${device.ip}</strong>
                            <br><small>${device.info} - ${device.timestamp}</small>
                        </div>
                        <div class="${device.status}">
                            ${device.status === 'online' ? '🟢 Online' : '🔴 Offline'}
                        </div>
                    `;
                    this.devicesList.appendChild(deviceEl);
                });
            }
            
            stopScan() {
                this.isScanning = false;
                this.finishScan();
                this.status.textContent = 'Escaneamento interrompido pelo usuário';
                this.status.style.background = '#d1ecf1';
            }
            
            finishScan() {
                this.isScanning = false;
                this.scanBtn.disabled = false;
                this.stopBtn.disabled = true;
                
                this.status.textContent = `Escaneamento concluído. ${this.foundDevices.length} dispositivos encontrados.`;
                this.status.style.background = '#d4edda';
            }
        }
        
        // Inicializar o scanner quando a página carregar
        document.addEventListener('DOMContentLoaded', () => {
            new NetworkScanner();
        });
    </script>
</body>
</html>