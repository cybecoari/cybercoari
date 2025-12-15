<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TV Cyber Online Ao Vivo</title>
<style>
body {
  background:#121212; color:#fff;
  font-family:Arial,sans-serif;
  margin:0; padding:20px;
  display:flex; justify-content:center; align-items:flex-start;
  min-height:100vh;
}
.tv-container {
  display:flex; flex-direction:row;
  background:#000; border:6px solid #222;
  border-radius:15px; overflow:hidden;
  max-width:900px; width:95%;
  box-shadow:0 0 30px rgba(0,0,0,0.8);
}
.channel-list {
  width:220px; background:#111; padding:10px;
  overflow-y:auto; max-height:500px;
}
.channel-list h2 { font-size:1rem; margin-bottom:10px; color:#ffb347; }
.channel-list button {
  width:100%; margin-bottom:5px;
  padding:8px; border:none; border-radius:5px;
  background:#222; color:#fff; cursor:pointer;
  text-align:left; transition:0.2s;
}
.channel-list button.active, .channel-list button:hover { background:#ff4b5c; }

.tv-screen-container { flex:1; padding:10px; display:flex; flex-direction:column; align-items:center; }
#channelName { font-weight:bold; font-size:1rem; margin-bottom:5px; color:#ffb347; }
video { width:100%; max-height:500px; border-radius:10px; background:#000; }
.controls { margin-top:10px; display:flex; justify-content:center; gap:10px; flex-wrap:wrap; }
button.control-btn {
  padding:10px 15px; border:none; border-radius:5px;
  background:#ff4b5c; color:#fff; cursor:pointer; font-size:1rem;
  transition:0.2s;
}
button.control-btn:hover { background:#ff6b7c; }
#volumeContainer { margin-top:10px; display:flex; align-items:center; gap:10px; justify-content:center; }

@media (max-width:700px){
  .tv-container { flex-direction:column; max-width:95%; }
  .channel-list { width:100%; max-height:150px; display:flex; overflow-x:auto; gap:5px; }
  .channel-list button { flex:0 0 auto; width:auto; }
}
</style>
</head>
<body>

<div class="tv-container">
  <div class="channel-list">
    <h2>Canais Ao Vivo</h2>
    <div id="channels"></div>
  </div>
  <div class="tv-screen-container">
    <div id="channelName">Carregando canal...</div>
    <video id="tv" controls autoplay></video>
    <div id="volumeContainer">
      <label>🔊</label>
      <input type="range" id="volumeSlider" min="0" max="1" step="0.01" value="0.8">
    </div>
    <div class="controls">
      <button class="control-btn" onclick="prevChannel()">⏮️ Anterior</button>
      <button class="control-btn" onclick="playPause()">▶/⏸ Play/Pause</button>
      <button class="control-btn" onclick="nextChannel()">⏭️ Próximo</button>
      <button class="control-btn" onclick="fullScreen()">⛶ Tela Cheia</button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
const tv = document.getElementById('tv');
const channelName = document.getElementById('channelName');
const channelsContainer = document.getElementById('channels');
const volumeSlider = document.getElementById('volumeSlider');

let liveChannels = [
  { name:'Big Buck Bunny - HLS', url:'https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8' },
  { name:'Sintel - HLS', url:'https://bitdash-a.akamaihd.net/content/sintel/hls/playlist.m3u8' },
  { name:'Tears of Steel - HLS', url:'https://test-streams.mux.dev/pts_shift/master.m3u8' }
];

let currentChannel = 0;
let hls = null;

// Cria lista de canais
function buildChannelList(){
  channelsContainer.innerHTML = '';
  liveChannels.forEach((c,i)=>{
    const btn = document.createElement('button');
    btn.textContent = c.name;
    btn.onclick = ()=>{ currentChannel=i; loadChannel(); }
    btn.id = 'channelBtn'+i;
    channelsContainer.appendChild(btn);
  });
}
function highlightActiveChannel(){
  liveChannels.forEach((_,i)=>{
    const btn = document.getElementById('channelBtn'+i);
    if(btn) btn.classList.toggle('active', i===currentChannel);
  });
}

// Carrega canal HLS
function loadChannel(){
  const channel = liveChannels[currentChannel];
  channelName.textContent = channel.name;
  highlightActiveChannel();
  
  if(Hls.isSupported()){
    if(hls) hls.destroy();
    hls = new Hls();
    hls.loadSource(channel.url);
    hls.attachMedia(tv);
    hls.on(Hls.Events.MANIFEST_PARSED, ()=> tv.play());
  } else if(tv.canPlayType('application/vnd.apple.mpegurl')){
    tv.src = channel.url;
    tv.play();
  } else {
    alert('Seu navegador não suporta HLS');
  }
}

// Controles
function nextChannel(){ currentChannel=(currentChannel+1)%liveChannels.length; loadChannel(); }
function prevChannel(){ currentChannel=(currentChannel-1+liveChannels.length)%liveChannels.length; loadChannel(); }
function playPause(){ if(tv.paused) tv.play(); else tv.pause(); }
volumeSlider.oninput = ()=>{ tv.volume=volumeSlider.value; }
function fullScreen(){ if(tv.requestFullscreen) tv.requestFullscreen(); }

// Inicialização
buildChannelList();
loadChannel();
</script>

</body>
</html>