<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/funcoes.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/rodape.php");
isLogged($sid);
?>

<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<title>Consulta IP / Domínio — versão robusta</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<style>
  body{font-family:Arial,Helvetica,sans-serif;background:#f4f6fb;color:#222;margin:18px;}
  h1{text-align:center}
  .row{display:flex;gap:8px;justify-content:center;margin-bottom:8px;flex-wrap:wrap}
  input{padding:8px;border-radius:6px;border:1px solid #ccc;width:240px}
  button{padding:8px 12px;border-radius:6px;border:none;background:#2b7cff;color:#fff;cursor:pointer;transition:background 0.2s}
  button:hover{background:#1a6be5}
  button:disabled{background:#a0a0a0;cursor:not-allowed}
  #info{max-width:900px;margin:12px auto;background:#fff;padding:12px;border-radius:8px;box-shadow:0 4px 18px rgba(0,0,0,0.06)}
  #map{height:320px;border-radius:6px;margin-top:10px}
  .error{color:#b00020;text-align:center;margin:10px 0}
  pre.console{background:#0b1220;color:#9be7ff;padding:8px;border-radius:6px;overflow:auto;max-height:160px}
  label{display:block;text-align:center;margin-bottom:6px}
  .loading{display:inline-block;width:16px;height:16px;border:2px solid rgba(255,255,255,0.3);border-radius:50%;border-top-color:#fff;animation:spin 1s ease-in-out infinite;margin-left:8px}
  @keyframes spin{to{transform:rotate(360deg)}}
  .info-grid{display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:12px;margin-bottom:12px}
  .info-item{background:#f8f9fc;padding:8px;border-radius:4px}
  .info-label{font-weight:bold;color:#555;font-size:0.9em}
  .copy-btn{background:#666;padding:2px 6px;font-size:0.7em;margin-left:4px;border-radius:3px}
  .copy-btn:hover{background:#555}
</style>
</head>
<body>
  <h1>Consulta de IP / Domínio (robusta)</h1>

  <div class="row">
    <form id="ipForm" onsubmit="return false;">
      <label>Consultar IP</label>
      <input id="ipInput" placeholder="ex: 8.8.8.8" />
      <button id="btnIp">Consultar IP</button>
      <button id="btnMyIp" type="button">Meu IP</button>
    </form>

    <form id="domainForm" onsubmit="return false;">
      <label>Consultar domínio</label>
      <input id="domainInput" placeholder="ex: google.com" />
      <button id="btnDomain">Consultar domínio</button>
    </form>
  </div>

  <div id="error" class="error" style="display:none"></div>

  <div id="info" style="display:none">
    <div class="info-grid">
      <div class="info-item">
        <div class="info-label">IP</div>
        <span id="infoIp">-</span>
        <button class="copy-btn" onclick="copyToClipboard('infoIp')">Copiar</button>
      </div>
      <div class="info-item">
        <div class="info-label">País</div>
        <span id="infoCountry">-</span>
      </div>
      <div class="info-item">
        <div class="info-label">Região</div>
        <span id="infoRegion">-</span>
      </div>
      <div class="info-item">
        <div class="info-label">Cidade</div>
        <span id="infoCity">-</span>
      </div>
      <div class="info-item">
        <div class="info-label">ISP / Org</div>
        <span id="infoIsp">-</span>
        <button class="copy-btn" onclick="copyToClipboard('infoIsp')">Copiar</button>
      </div>
      <div class="info-item">
        <div class="info-label">Fuso</div>
        <span id="infoTimezone">-</span>
      </div>
    </div>
    <div><strong>Localização:</strong> <span id="infoLocation">-</span></div>
    <div id="map"></div>
  </div>

  <h3 style="text-align:center">Console (mensagens para debug)</h3>
  <pre class="console" id="devConsole"></pre>

 <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
/*
  Estratégia melhorada:
  - Cache de consultas para evitar requisições repetidas
  - Validação de entrada mais robusta
  - Melhor tratamento de erros com fallbacks
  - Indicadores de carregamento
  - Funcionalidade de copiar dados
  - Otimização de chamadas de API
*/

const els = {
  ipInput: document.getElementById('ipInput'),
  domainInput: document.getElementById('domainInput'),
  btnIp: document.getElementById('btnIp'),
  btnDomain: document.getElementById('btnDomain'),
  btnMyIp: document.getElementById('btnMyIp'),
  error: document.getElementById('error'),
  infoBox: document.getElementById('info'),
  infoIp: document.getElementById('infoIp'),
  infoCountry: document.getElementById('infoCountry'),
  infoRegion: document.getElementById('infoRegion'),
  infoCity: document.getElementById('infoCity'),
  infoIsp: document.getElementById('infoIsp'),
  infoLocation: document.getElementById('infoLocation'),
  infoTimezone: document.getElementById('infoTimezone'),
  devConsole: document.getElementById('devConsole')
};

// Cache simples para evitar consultas repetidas
const queryCache = new Map();

// Adicionar indicadores de carregamento aos botões
function setLoading(button, isLoading) {
  if (isLoading) {
    button.disabled = true;
    button.innerHTML += '<span class="loading"></span>';
  } else {
    button.disabled = false;
    button.innerHTML = button.textContent;
  }
}

function logDev(...args){
  console.log(...args);
  const timestamp = new Date().toLocaleTimeString();
  els.devConsole.textContent += `[${timestamp}] ` + args.map(a => (typeof a === 'object'? JSON.stringify(a,null,2): String(a))).join(' ') + '\n\n';
  els.devConsole.scrollTop = els.devConsole.scrollHeight;
}

function showError(msg){
  els.error.style.display = 'block';
  els.error.textContent = msg;
  logDev('ERROR:', msg);
}

function clearError(){
  els.error.style.display = 'none';
  els.error.textContent = '';
}

function showInfoBox(){ els.infoBox.style.display = 'block'; }
function hideInfoBox(){ els.infoBox.style.display = 'none'; }

// Validação de entrada
function isValidIP(ip) {
  return /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ip);
}

function isValidDomain(domain) {
  return /^[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?(\.[a-zA-Z]{2,})+$/.test(domain);
}

// Helpers de fetch com fallback via allorigins (para dev)
async function fetchJsonWithFallback(url){
  // Verificar cache primeiro
  if (queryCache.has(url)) {
    logDev('Retornando do cache:', url);
    return queryCache.get(url);
  }
  
  logDev('Tentando:', url);
  try {
    const r = await fetch(url);
    if (!r.ok) throw new Error('HTTP ' + r.status);
    
    const text = await r.text();
    try {
      const json = JSON.parse(text);
      logDev('Resposta direta OK');
      // Armazenar no cache por 5 minutos
      queryCache.set(url, json);
      setTimeout(() => queryCache.delete(url), 300000);
      return json;
    } catch(e){
      throw new Error('JSON.parse falhou (direto): ' + e.message);
    }
  } catch (err) {
    logDev('Erro direto:', err.message || err);
    // tenta via CORS proxy (apenas para DEV/test)
    try {
      const proxy = 'https://api.allorigins.win/raw?url=' + encodeURIComponent(url);
      logDev('Tentando proxy CORS:', proxy);
      const r2 = await fetch(proxy);
      if (!r2.ok) throw new Error('Proxy HTTP ' + r2.status);
      const text2 = await r2.text();
      const json2 = JSON.parse(text2);
      logDev('Resposta via proxy OK');
      // Armazenar no cache
      queryCache.set(url, json2);
      setTimeout(() => queryCache.delete(url), 300000);
      return json2;
    } catch(proxyErr){
      logDev('Erro proxy:', proxyErr.message || proxyErr);
      throw new Error('Falha ao buscar (direto e via proxy). Ver console para detalhes.');
    }
  }
}

// Função para obter dados geográficos de um IP
async function getGeoForIP(ip){
  // Verificar cache primeiro
  const cacheKey = `geo-${ip}`;
  if (queryCache.has(cacheKey)) {
    logDev('Retornando dados geográficos do cache para:', ip);
    return queryCache.get(cacheKey);
  }
  
  // Tenta providers conhecidos (https e nomes de campos diferentes)
  const candidates = [
    `https://ipwhois.app/json/${ip}`,    // ipwhois
    `https://ipwhois.io/json/${ip}`,     // ipwhois mirror
    `https://ipapi.co/${ip}/json/`,      // ipapi
    `https://ip-api.com/json/${ip}`      // ip-api
  ];

  for (const url of candidates){
    try {
      const data = await fetchJsonWithFallback(url);
      // Normaliza latitude/longitude (lat/lon ou latitude/longitude)
      const lat = data.latitude ?? data.lat ?? (data.location && (data.location.latitude ?? data.location.lat));
      const lon = data.longitude ?? data.lon ?? (data.location && (data.location.longitude ?? data.location.lon));
      // E campos comuns
      const country = data.country ?? data.country_name ?? data.countryCode;
      const region = data.regionName ?? data.region ?? data.region_name;
      const city = data.city ?? data.city_name;
      const isp = data.isp ?? data.org ?? data.orgName ?? data.orgname;
      const timezone = data.timezone ?? data.utc ?? data.time_zone ?? data.tz;
      const queryIp = data.ip ?? data.query ?? ip;

      // Se encontramos dados válidos, retornamos
      if (country || city || (lat && lon)) {
        const result = {lat: Number(lat), lon: Number(lon), country, region, city, isp, timezone, query: queryIp};
        // Armazenar no cache
        queryCache.set(cacheKey, result);
        setTimeout(() => queryCache.delete(cacheKey), 300000);
        return result;
      }
    } catch(e){
      // ignora e tenta o próximo provider
      logDev('Provider falhou:', url, e.message || e);
    }
  }
  throw new Error('Nenhum provider retornou dados válidos para o IP');
}

// Resolve domínio -> pega primeiro registro A (dns.google)
async function resolveDomainToIP(domain){
  // Verificar cache primeiro
  const cacheKey = `dns-${domain}`;
  if (queryCache.has(cacheKey)) {
    logDev('Retornando resolução DNS do cache para:', domain);
    return queryCache.get(cacheKey);
  }
  
  try {
    const url = `https://dns.google/resolve?name=${encodeURIComponent(domain)}&type=A`;
    const data = await fetchJsonWithFallback(url);
    if (data && data.Answer && data.Answer.length>0){
      // Encontrar primeira entrada que pareça um IPv4
      for (const a of data.Answer){
        const candidate = (a.data || '').trim();
        if (/^(\d{1,3}\.){3}\d{1,3}$/.test(candidate)) {
          // Armazenar no cache
          queryCache.set(cacheKey, candidate);
          setTimeout(() => queryCache.delete(cacheKey), 300000);
          return candidate;
        }
      }
      // fallback: retorna o primeiro .data mesmo assim
      const result = data.Answer[0].data;
      queryCache.set(cacheKey, result);
      setTimeout(() => queryCache.delete(cacheKey), 300000);
      return result;
    }
    throw new Error('Sem registros A');
  } catch (err) {
    logDev('Erro ao resolver domínio:', err.message || err);
    throw err;
  }
}

/* Mapa Leaflet */
let map, marker;
function updateMap(lat, lon){
  if (lat == null || lon == null) return;
  if (!map){
    map = L.map('map').setView([lat, lon], 9);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { 
      attribution: '© OpenStreetMap',
      maxZoom: 18
    }).addTo(map);
    marker = L.marker([lat, lon]).addTo(map);
  } else {
    map.setView([lat, lon], 9);
    if (!marker) {
      marker = L.marker([lat, lon]).addTo(map);
    } else {
      marker.setLatLng([lat, lon]);
    }
  }
}

/* UI update */
function fillInfo(obj){
  els.infoIp.textContent = obj.query ?? '-';
  els.infoCountry.textContent = obj.country ?? '-';
  els.infoRegion.textContent = obj.region ?? '-';
  els.infoCity.textContent = obj.city ?? '-';
  els.infoIsp.textContent = obj.isp ?? '-';
  els.infoLocation.textContent = (obj.lat != null && obj.lon != null) ? `${obj.lat}, ${obj.lon}` : '-';
  els.infoTimezone.textContent = obj.timezone ?? '-';
  if (obj.lat != null && obj.lon != null) updateMap(obj.lat, obj.lon);
  showInfoBox();
  clearError();
}

// Função para copiar texto para a área de transferência
function copyToClipboard(elementId) {
  const text = document.getElementById(elementId).textContent;
  navigator.clipboard.writeText(text).then(() => {
    logDev('Texto copiado: ' + text);
  }).catch(err => {
    logDev('Falha ao copiar texto: ', err);
  });
}

/* Eventos */
els.btnIp.addEventListener('click', async ()=>{
  const ip = els.ipInput.value.trim();
  if (!ip) return showError('Digite um IP.');
  if (!isValidIP(ip)) return showError('Formato de IP inválido.');
  
  try {
    setLoading(els.btnIp, true);
    logDev('Iniciando consulta IP', ip);
    const data = await getGeoForIP(ip);
    fillInfo(data);
  } catch(e){
    showError(e.message || 'Erro ao consultar IP');
  } finally {
    setLoading(els.btnIp, false);
  }
});

els.btnDomain.addEventListener('click', async ()=>{
  const d = els.domainInput.value.trim();
  if (!d) return showError('Digite um domínio.');
  if (!isValidDomain(d)) return showError('Formato de domínio inválido.');
  
  try {
    setLoading(els.btnDomain, true);
    logDev('Iniciando resolução de domínio', d);
    const ip = await resolveDomainToIP(d);
    logDev('Domínio -> IP:', ip);
    const data = await getGeoForIP(ip);
    fillInfo(data);
  } catch (e){
    showError(e.message || 'Erro ao resolver domínio');
  } finally {
    setLoading(els.btnDomain, false);
  }
});

els.btnMyIp.addEventListener('click', detectMyIP);

// Permitir submissão por Enter
els.ipInput.addEventListener('keypress', (e) => {
  if (e.key === 'Enter') els.btnIp.click();
});

els.domainInput.addEventListener('keypress', (e) => {
  if (e.key === 'Enter') els.btnDomain.click();
});

async function detectMyIP(){
  try {
    setLoading(els.btnMyIp, true);
    logDev('Detectando IP público (ipify)');
    // Tenta múltiplos serviços para maior confiabilidade
    const services = [
      'https://api64.ipify.org?format=json',
      'https://api.ipify.org?format=json',
      'https://icanhazip.com/json'
    ];
    
    let ip = null;
    for (const service of services) {
      try {
        const r = await fetch(service);
        if (r.ok) {
          const data = await r.json();
          ip = data.ip || (typeof data === 'string' ? data.trim() : null);
          if (ip) break;
        }
      } catch (e) {
        logDev(`Serviço ${service} falhou:`, e.message);
      }
    }
    
    if (!ip) throw new Error('Não foi possível detectar IP');
    
    els.ipInput.value = ip;
    const geoData = await getGeoForIP(ip);
    fillInfo(geoData);
  } catch (e){
    showError('Não foi possível detectar seu IP automaticamente. (' + (e.message || e) + ')');
  } finally {
    setLoading(els.btnMyIp, false);
  }
}

/* Detecta automaticamente ao carregar */
window.addEventListener('load', () => {
  // limpa console dev
  els.devConsole.textContent = 'Aplicação carregada. Iniciando detecção automática de IP...\n\n';
  // detecta IP público — com timeout pequeno para dar feedback rápido
  setTimeout(() => {
    detectMyIP().catch(err => logDev('detectMyIP falhou: ', err));
  }, 250);
});

/* Dica: se você estiver abrindo index.html via file://, rode um servidor local:
   - Python 3:  python -m http.server 8000
   - Node (serve): npx serve
   Isso evita "origin null" que quebra algumas APIs.
*/
</script>
</body>
</html>