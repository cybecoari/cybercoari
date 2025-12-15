<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rádio Cyber Automática</title>
<style>
body {
  background:#121212; color:#fff;
  font-family:Arial,sans-serif;
  display:flex; justify-content:center; align-items:center;
  height:100vh; margin:0;
}
.radio-player {
  background:#1e1e1e; padding:30px;
  border-radius:15px; text-align:center;
  max-width:500px; width:90%;
  box-shadow:0 4px 15px rgba(0,0,0,0.5);
}
.radio-player h1 { margin-bottom:20px; color:#ff4b5c; }

.controls { display:flex; justify-content:center; align-items:center; margin-bottom:20px; }
button {
  background:#333; border:none; border-radius:50%;
  width:50px; height:50px; font-size:1.2rem; color:#fff;
  cursor:pointer; margin:0 5px; transition:background 0.3s;
}
button:hover { background:#444; }
#playBtn { background:#ff4b5c; }
#playBtn:hover { background:#ff6b7c; }
button.active { background:#ff4b5c; }

#currentTrack { margin:10px 0; font-size:0.9rem; color:#ccc; height:20px; }

#progressContainer { width:100%; height:10px; background:#333; border-radius:5px; overflow:hidden; margin:15px 0; cursor:pointer; }
#progressBar { height:100%; width:0%; background:#ff4b5c; transition:width 0.1s; }

#volumeContainer { display:flex; align-items:center; margin-bottom:15px; }
#volumeSlider { width:100%; margin-left:10px; }

#playlist {
  list-style:none; padding:0;
  max-height:180px; overflow-y:auto; margin-top:10px; text-align:left;
}
#playlist li {
  padding:8px 5px; border-bottom:1px solid #333;
  cursor:pointer; transition:background 0.2s;
}
#playlist li:hover { background:#2a2a2a; }
#playlist li.active { color:#ff4b5c; font-weight:bold; }

.status { margin:10px 0; font-size:0.9rem; }
.status.loading::before { content:"⏳ "; color:#ffb347; }
.status.error::before { content:"❌ "; color:#ff4b5c; }
.status.success::before { content:"✅ "; color:#4CAF50; }

.debug {
  background:#2a2a2a; padding:10px; border-radius:5px;
  margin-top:10px; font-size:0.8rem; text-align:left;
  max-height:100px; overflow-y:auto;
}

@media (max-width:600px) {
  .radio-player { padding:15px; }
  button { width:40px; height:40px; font-size:1rem; }
  .debug { font-size:0.7rem; }
}
</style>
</head>
<body>

<div class="radio-player">
  <h1>Rádio Cyber <span id="modeIndicator" class="mode-indicator">MÚSICAS</span></h1>
  <div id="currentTrack">Selecione uma música</div>
  <div class="controls">
    <button id="prevBtn">⏮️</button>
    <button id="playBtn">▶</button>
    <button id="nextBtn">⏭️</button>
    <button id="loopBtn">🔁</button>
  </div>

  <div id="progressContainer"><div id="progressBar"></div></div>

  <div id="volumeContainer">
    <label for="volumeSlider">🔊</label>
    <input type="range" id="volumeSlider" min="0" max="1" step="0.01" value="0.8">
  </div>

  <div id="status" class="status"></div>

  <ul id="playlist"></ul>

  <div id="debug" class="debug"></div>
  <audio id="audio" preload="auto" crossorigin="anonymous"></audio>
</div>

<script>
const audio = document.getElementById('audio');
const playBtn = document.getElementById('playBtn');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const loopBtn = document.getElementById('loopBtn');
const playlistEl = document.getElementById('playlist');
const progressBar = document.getElementById('progressBar');
const volumeSlider = document.getElementById('volumeSlider');
const currentTrackEl = document.getElementById('currentTrack');
const statusEl = document.getElementById('status');
const debugEl = document.getElementById('debug');

let musicList = [];
let currentTrack = 0;
let isPlaying = false;
let isLoop = false;

// === DEBUG ===
function debugLog(msg, type = 'info') {
  const color = type === 'error' ? '#ff4b5c' : type === 'success' ? '#4CAF50' : '#fff';
  const time = new Date().toLocaleTimeString();
  debugEl.innerHTML += `<span style="color:${color}">[${time}] ${msg}</span><br>`;
  debugEl.scrollTop = debugEl.scrollHeight;
}

// === CARREGA PLAYLIST LOCAL ===
function loadPlaylist() {
  fetch('playlist.php')
    .then(res => res.json())
    .then(data => {
      musicList = data || [];
      buildPlaylist();
      debugLog(`🎶 ${musicList.length} músicas carregadas`, 'success');
    })
    .catch(err => {
      debugLog('❌ Erro ao carregar playlist: ' + err, 'error');
      musicList = [];
      buildPlaylist();
    });
}

// === CONSTRÓI LISTA ===
function buildPlaylist() {
  playlistEl.innerHTML = '';
  if (musicList.length === 0) {
    playlistEl.innerHTML = '<li>Nenhuma música encontrada</li>';
    return;
  }
  musicList.forEach((m, i) => {
    const li = document.createElement('li');
    li.textContent = m.title;
    li.onclick = () => playMusicTrack(i);
    playlistEl.appendChild(li);
  });
  updatePlaylistUI();
}

// === ATUALIZA SELEÇÃO ===
function updatePlaylistUI() {
  document.querySelectorAll('#playlist li').forEach((li, i) => {
    li.classList.toggle('active', i === currentTrack);
  });
}

// === REPRODUZ MÚSICA ===
function playMusicTrack(i) {
  if (!musicList[i]) return;
  currentTrack = i;
  const track = musicList[i];

  audio.pause();
  isPlaying = false;

  audio.src = track.url;
  audio.preload = "auto";
  audio.loop = isLoop;

  statusEl.textContent = 'Carregando música...';
  statusEl.className = 'status loading';

  const playPromise = audio.play();
  if (playPromise !== undefined) {
    playPromise.then(() => {
      isPlaying = true;
      playBtn.textContent = '⏸';
      currentTrackEl.textContent = '🎵 ' + track.title;
      statusEl.textContent = 'Reproduzindo música local';
      statusEl.className = 'status success';
      progressBar.style.background = '#ff4b5c';
      updatePlaylistUI();
      debugLog(`▶ Tocando: ${track.title}`, 'success');
    }).catch(e => {
      debugLog('❌ Erro ao tocar música: ' + e, 'error');
      statusEl.textContent = 'Erro ao reproduzir música';
      statusEl.className = 'status error';
    });
  }
}

// === CONTROLES ===
playBtn.onclick = () => {
  if (!audio.src && musicList.length) {
    playMusicTrack(0);
    return;
  }
  if (!isPlaying) {
    audio.play().then(() => {
      isPlaying = true;
      playBtn.textContent = '⏸';
      statusEl.textContent = 'Reproduzindo';
      statusEl.className = 'status success';
    });
  } else {
    audio.pause();
    isPlaying = false;
    playBtn.textContent = '▶';
    statusEl.textContent = '⏸ Pausado';
    statusEl.className = 'status';
  }
};

nextBtn.onclick = () => playMusicTrack((currentTrack + 1) % musicList.length);
prevBtn.onclick = () => playMusicTrack((currentTrack - 1 + musicList.length) % musicList.length);

loopBtn.onclick = () => {
  isLoop = !isLoop;
  loopBtn.classList.toggle('active', isLoop);
  audio.loop = isLoop;
  statusEl.textContent = isLoop ? '🔁 Loop ativado' : 'Loop desativado';
  statusEl.className = 'status';
};

volumeSlider.oninput = () => { audio.volume = volumeSlider.value; };

audio.addEventListener('timeupdate', () => {
  if (audio.duration) {
    const progress = (audio.currentTime / audio.duration) * 100;
    progressBar.style.width = progress + '%';
  }
});

audio.addEventListener('ended', () => {
  if (!isLoop) nextBtn.onclick();
});

// === INICIALIZAÇÃO ===
audio.volume = volumeSlider.value;
loadPlaylist();
debugLog('🎵 Player Música inicializado!', 'success');
</script>
</body>
</html>