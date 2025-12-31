<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/funcoes.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/cyber.php");
isLogged($sid);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Consulta de IP e Localização</title>
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
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .container {
            max-width: 1000px;
            width: 100%;
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
            max-width: 600px;
            margin: 0 auto;
        }
        
        .search-card {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }
        
        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
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
        
        input {
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
            align-self: flex-end;
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
        
        .info-card {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }
        
        .info-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .info-title {
            font-size: 1.5rem;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .info-item {
            background-color: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 10px;
        }
        
        .info-label {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-size: 1.1rem;
            font-weight: 500;
        }
        
        .map-container {
            height: 300px;
            border-radius: 15px;
            overflow: hidden;
            margin-top: 20px;
            background-color: rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .map-placeholder {
            text-align: center;
            padding: 20px;
        }
        
        .map-placeholder i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #4facfe;
        }
        
        footer {
            margin-top: auto;
            text-align: center;
            padding: 20px;
            opacity: 0.7;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .search-form {
                flex-direction: column;
            }
            
            .input-field {
                min-width: 100%;
            }
            
            .btn {
                width: 100%;
            }
            
            .info-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .loading i {
            font-size: 2rem;
            margin-bottom: 10px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .error-message {
            display: none;
            background: linear-gradient(to right, #ff758c, #ff7eb3);
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }
        
        .success-message {
            display: none;
            background: linear-gradient(to right, #4ade80, #22c55e);
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Consulta de IP e Localização</h1>
            <p class="card-description">Descubra informações sobre qualquer endereço IP e sua localização geográfica</p>
        </header>
        
        <div class="search-card">
            <form class="search-form" id="ip-form">
                <div class="input-field">
                    <label for="ip-address">Endereço IP:</label>
                    <input type="text" id="ip-address" placeholder="Digite um endereço IP (ex: 8.8.8.8)" required>
                </div>
                <button type="submit" id="search-btn" class="btn">
                    <i class="fas fa-search"></i> Consultar
                </button>
            </form>
        </div>
        
        <div class="error-message" id="error-message">
            <i class="fas fa-exclamation-circle"></i>
            <span id="error-text">Erro ao buscar informações do IP</span>
        </div>
        
        <div class="success-message" id="success-message">
            <i class="fas fa-check-circle"></i>
            <span id="success-text">Informações carregadas com sucesso!</span>
        </div>
        
        <div class="loading" id="loading">
            <i class="fas fa-spinner"></i>
            <p>Buscando informações...</p>
        </div>
        
        <div class="info-card">
            <div class="info-header">
                <h2 class="info-title">Informações do IP</h2>
                <button id="my-ip-btn" class="btn">Meu IP</button>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Endereço IP</div>
                    <div class="info-value" id="info-ip">-</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">País</div>
                    <div class="info-value" id="info-country">-</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Região</div>
                    <div class="info-value" id="info-region">-</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Cidade</div>
                    <div class="info-value" id="info-city">-</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">CEP</div>
                    <div class="info-value" id="info-zip">-</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Provedor de Internet</div>
                    <div class="info-value" id="info-isp">-</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Coordenadas</div>
                    <div class="info-value" id="info-location">-</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Fuso Horário</div>
                    <div class="info-value" id="info-timezone">-</div>
                </div>
            </div>
            
            <div class="map-container">
                <div class="map-placeholder">
                    <i class="fas fa-map-marked-alt"></i>
                    <p>O mapa será exibido aqui após a consulta</p>
                </div>
            </div>
        </div>
        
        <footer>
            <p>Consulta de IP &copy; 2023 - Desenvolvido para fins educacionais</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ipForm = document.getElementById('ip-form');
            const myIpBtn = document.getElementById('my-ip-btn');
            const ipInput = document.getElementById('ip-address');
            const loading = document.getElementById('loading');
            const errorMessage = document.getElementById('error-message');
            const successMessage = document.getElementById('success-message');
            const errorText = document.getElementById('error-text');
            
            // Elementos de informação
            const infoIp = document.getElementById('info-ip');
            const infoCountry = document.getElementById('info-country');
            const infoRegion = document.getElementById('info-region');
            const infoCity = document.getElementById('info-city');
            const infoZip = document.getElementById('info-zip');
            const infoIsp = document.getElementById('info-isp');
            const infoLocation = document.getElementById('info-location');
            const infoTimezone = document.getElementById('info-timezone');
            
            // Função para validar o formato do IP
            function isValidIP(ip) {
                const ipRegex = /^(\d{1,3}\.){3}\d{1,3}$/;
                if (!ipRegex.test(ip)) return false;
                
                // Verifica se cada octeto está entre 0 e 255
                return ip.split('.').every(octet => {
                    const num = parseInt(octet, 10);
                    return num >= 0 && num <= 255;
                });
            }
            
            // Função para exibir mensagem de erro
            function showError(message) {
                errorText.textContent = message;
                errorMessage.style.display = 'block';
                successMessage.style.display = 'none';
                
                // Esconder a mensagem após 5 segundos
                setTimeout(() => {
                    errorMessage.style.display = 'none';
                }, 5000);
            }
            
            // Função para exibir mensagem de sucesso
            function showSuccess() {
                errorMessage.style.display = 'none';
                successMessage.style.display = 'block';
                
                // Esconder a mensagem após 3 segundos
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 3000);
            }
            
            // Função para buscar informações de IP usando uma API real
            async function fetchIPInfo(ip) {
                loading.style.display = 'block';
                errorMessage.style.display = 'none';
                
                try {
                    // Usando a API ipapi.co para buscar informações de IP
                    const response = await fetch(`https://ipapi.co/${ip}/json/`);
                    
                    if (!response.ok) {
                        throw new Error('Falha ao buscar informações do IP');
                    }
                    
                    const data = await response.json();
                    
                    if (data.error) {
                        throw new Error(data.reason || 'IP não encontrado');
                    }
                    
                    // Preenche as informações na interface
                    infoIp.textContent = data.ip || '-';
                    infoCountry.textContent = data.country_name || data.country || '-';
                    infoRegion.textContent = data.region || data.region_code || '-';
                    infoCity.textContent = data.city || '-';
                    infoZip.textContent = data.postal || '-';
                    infoIsp.textContent = data.org || data.asn || '-';
                    infoLocation.textContent = data.latitude && data.longitude 
                        ? `${data.latitude}, ${data.longitude}` 
                        : '-';
                    infoTimezone.textContent = data.timezone || '-';
                    
                    showSuccess();
                } catch (error) {
                    console.error('Erro ao buscar informações:', error);
                    showError(error.message || 'Erro ao buscar informações do IP');
                } finally {
                    loading.style.display = 'none';
                }
            }
            
            // Função para buscar o IP atual do usuário
            async function getMyIP() {
                loading.style.display = 'block';
                
                try {
                    // Usando a API ipify para obter o IP público
                    const response = await fetch('https://api.ipify.org?format=json');
                    
                    if (!response.ok) {
                        throw new Error('Falha ao obter o IP atual');
                    }
                    
                    const data = await response.json();
                    
                    if (!data.ip) {
                        throw new Error('Não foi possível obter o IP atual');
                    }
                    
                    ipInput.value = data.ip;
                    await fetchIPInfo(data.ip);
                } catch (error) {
                    console.error('Erro ao obter IP:', error);
                    showError(error.message || 'Erro ao obter seu IP');
                    loading.style.display = 'none';
                }
            }
            
            // Evento de envio do formulário
            ipForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const ip = ipInput.value.trim();
                
                if (!ip) {
                    showError('Por favor, digite um endereço IP');
                    ipInput.focus();
                    return;
                }
                
                if (!isValidIP(ip)) {
                    showError('Por favor, digite um endereço IP válido');
                    ipInput.focus();
                    return;
                }
                
                fetchIPInfo(ip);
            });
            
            // Evento de clique no botão "Meu IP"
            myIpBtn.addEventListener('click', getMyIP);
            
            // Buscar o IP do usuário ao carregar a página
            getMyIP();
        });
    </script>
</body>
</html>