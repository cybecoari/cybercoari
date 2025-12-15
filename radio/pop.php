<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rádio + Playlist Premium</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;}
body{background:linear-gradient(135deg,#1a2a6c,#b21f1f,#fdbb2d);color:#fff;min-height:100vh;display:flex;flex-direction:column;align-items:center;padding:20px;}
.container{max-width:900px;width:100%;background:rgba(0,0,0,0.8);border-radius:20px;padding:30px;box-shadow:0 10px 30px rgba(0,0,0,0.5);}
header{text-align:center;margin-bottom:30px;}
h1{font-size:2.5rem;margin-bottom:10px;text-shadow:2px 2px 4px rgba(0,0,0,0.5);}
.subtitle{font-size:1.2rem;color:#ccc;margin-bottom:20px;}
.search-container{width:100%;margin-bottom:20px;}
.search-box{width:100%;padding:12px 20px;border-radius:30px;border:none;background:rgba(255,255,255,0.1);color:white;font-size:1rem;outline:none;}
.search-box::placeholder{color:#aaa;}
.player{background: rgba(30,30,40,0.95);border-radius:15px;padding:25px;margin-bottom:30px;transition:all 0.3s ease;}
.station-info{display:flex;align-items:center;margin-bottom:25px;}
.station-logo{width:100px;height:100px;border-radius:50%;background: linear-gradient(45deg,#3498db,#9b59b6);display:flex;align-items:center;justify-content:center;font-size:2rem;margin-right:20px;box-shadow:0 5px 15px rgba(0,0,0,0.3);transition: transform 1s linear;}
.station-logo.playing{animation: spin 4s linear infinite;}
@keyframes spin{from{transform:rotate(0deg);}to{transform:rotate(360deg);}}
.station-details{flex:1;}
.station-name{font-size:1.8rem;margin-bottom:5px;}
.station-genre{color:#aaa;font-size:1.1rem;margin-bottom:10px;}
.now-playing{font-size:1.2rem;color:#3498db;}
.controls{display:flex;justify-content:center;align-items:center;margin:20px 0;}
.control-btn{background:#3498db;border:none;border-radius:50%;width:60px;height:60px;margin:0 15px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:white;transition:all 0.3s ease;box-shadow:0 5px 15px rgba(0,0,0,0.3);}
.control-btn:hover{transform: scale(1.1);background:#2980b9;}
.play-btn{width:70px;height:70px;font-size:1.8rem;}
.progress-container{width:100%;margin:15px 0;}
.progress-bar{width:100%;height:6px;background:#555;border-radius:3px;cursor:pointer;position:relative;}
.progress{height:100%;background:#3498db;border-radius:3px;width:0%;transition:width 0.1s ease;}
.progress-time{display:flex;justify-content:space-between;margin-top:5px;font-size:0.8rem;color:#aaa;}
.volume-control{display:flex;align-items:center;margin-top:20px;}
.volume-icon{margin-right:10px;font-size:1.2rem;}
.volume-slider{flex:1;height:5px;-webkit-appearance:none;background:#555;border-radius:5px;outline:none;}
.volume-slider::-webkit-slider-thumb{-webkit-appearance:none;width:18px;height:18px;border-radius:50%;background:#3498db;cursor:pointer;}
.stations{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:15px;margin-top:20px;}
.station-card{background: rgba(40,40,50,0.8);border-radius:10px;padding:15px;text-align:center;cursor:pointer;transition: all 0.3s ease;position:relative;}
.station-card:hover{background: rgba(60,60,70,0.9);transform: translateY(-5px);}
.station-card.active{background: rgba(52,152,219,0.3);border:1px solid #3498db;}
.station-card-icon{font-size:2rem;margin-bottom:10px;}
.station-card-name{font-size:1.1rem;margin-bottom:5px;}
.station-card-genre{font-size:0.9rem;color:#aaa;}
.station-card-type{position:absolute;top:10px;right:10px;font-size:0.7rem;background:#3498db;padding:2px 6px;border-radius:10px;}
.history{margin-top:20px;max-height:100px;overflow-y:auto;background: rgba(0,0,0,0.3);padding:10px;border-radius:10px;font-size:0.9rem;}
.history ul{list-style-type:none;padding-left:0;}
.history li{margin-bottom:5px;padding:5px;border-radius:5px;background:rgba(255,255,255,0.05);}
footer{text-align:center;margin-top:30px;color:#ccc;font-size:0.9rem;}
.loading{color:#ff9900;font-style:italic;}
.error{color:#e74c3c;font-style:italic;}
.no-results{text-align:center;padding:20px;color:#aaa;font-style:italic;}
.loading-spinner{display:inline-block;width:20px;height:20px;border:3px solid rgba(255,255,255,.3);border-radius:50%;border-top-color:#fff;animation:spin 1s ease-in-out infinite;margin-right:10px;}
@keyframes spin{to{transform:rotate(360deg);}}
@media(max-width:600px){.container{padding:15px}.station-info{flex-direction:column;text-align:center}.station-logo{margin-right:0;margin-bottom:15px}.stations{grid-template-columns:repeat(2,1fr)}}
</style>
</head>
<body>
<div class="container">
<header>
<h1>Rádio + Playlist Premium</h1>
<p class="subtitle">Tanto estações online quanto músicas locais</p>
<div class="search-container">
<input type="text" class="search-box" placeholder="Buscar estações ou músicas...">
</div>
</header>

<div class="player">
<div class="station-info">
<div class="station-logo"><span></span></div>
<div class="station-details">
<h2 class="station-name">Estação/Música Principal</h2>
<p class="station-genre">Descrição/Artista</p>
<p class="now-playing">Clique em play para começar</p>
</div>
</div>

<div class="progress-container" id="progress-container" style="display:none;">
<div class="progress-bar">
<div class="progress"></div>
</div>
<div class="progress-time">
<span class="current-time">0:00</span>
<span class="duration">0:00</span>
</div>
</div>

<div class="controls">
<button class="control-btn prev-btn">⏮</button>
<button class="control-btn play-btn">▶</button>
<button class="control-btn next-btn">⏭</button>
</div>

<div class="volume-control">
<span class="volume-icon">🔊</span>
<input type="range" min="0" max="100" value="80" class="volume-slider">
</div>

<div class="history"><strong>Histórico:</strong><ul id="history-list"></ul></div>
</div>

<h2>Lista de Mídia</h2>
<div class="stations" id="media-cards"></div>
<div id="no-results" class="no-results" style="display:none;">Nenhum resultado encontrado</div>

<footer>
<p>Rádio Online &copy; 2025 - Todos os direitos reservados</p>
</footer>
</div>

<audio id="radio-stream"></audio>

<script>
document.addEventListener('DOMContentLoaded',()=>{
const playBtn=document.querySelector('.play-btn');
const prevBtn=document.querySelector('.prev-btn');
const nextBtn=document.querySelector('.next-btn');
const mediaContainer=document.getElementById('media-cards');
const volumeSlider=document.querySelector('.volume-slider');
const nowPlaying=document.querySelector('.now-playing');
const stationName=document.querySelector('.station-name');
const stationGenre=document.querySelector('.station-genre');
const stationLogo=document.querySelector('.station-logo');
const audioElement=document.getElementById('radio-stream');
const historyList=document.getElementById('history-list');
const searchBox=document.querySelector('.search-box');
const noResults=document.getElementById('no-results');
const progressContainer=document.getElementById('progress-container');
const progressBar=document.querySelector('.progress');
const currentTimeEl=document.querySelector('.current-time');
const durationEl=document.querySelector('.duration');

let isPlaying=false;
let currentIndex=0;
let history=[];
let filteredMediaList=[];

// Lista combinada: estações online + músicas locais
const mediaList=[
  {
      type:"radio", 
      name:"Rádio Cyber FM", 
      logo:"🎵", 
      nowPlaying:"Mix de sucessos", 
      src:"https://live.hunter.fm/sertanejo_normal"
  },
  {
      type:"radio", 
      name:"Rádio Rock", 
      logo:"🎸", 
      nowPlaying:"Rock clássico", 
      src:"https://stream-158.zeno.fm/0r0xa7p0g1zuv?zs=4hWf3bXwS4i7V5jK1rT8PQ"
  },
  {
      type:"music", 
      name:"Música Local 1", 
      artist:"Artista A", 
      logo:"🎶", 
      nowPlaying:"Música Local 1", 
      duration: "3:45",
      src:"musicas/musica1.mp3"
  },
  {
      type:"music", 
      name:"Música Local 2", 
      artist:"Artista B", 
      logo:"🎧", 
      nowPlaying:"Música Local 2", 
      duration: "4:20",
      src:"musicas/musica2.mp3"
  },
  {
      type:"radio", 
      name:"Rádio Jazz", 
      logo:"🎷", 
      nowPlaying:"Jazz suave", 
      src:"https://stream-158.zeno.fm/0c4x0a3h0pzuv?zs=H8jK2nM5qR7tV1wY4zB6c9"
  },
  {
      type:"music", 
      name:"Música Local 3", 
      artist:"Artista C", 
      logo:"🎤", 
      nowPlaying:"Música Local 3", 
      duration: "2:55",
      src:"musicas/musica3.mp3"
  }
];

// Inicializa a lista filtrada
filteredMediaList = [...mediaList];

// Gera os cards dinamicamente
function renderMediaCards() {
  mediaContainer.innerHTML = '';
  
  if (filteredMediaList.length === 0) {
    noResults.style.display = 'block';
    return;
  }
  
  noResults.style.display = 'none';
  
  filteredMediaList.forEach((item,index)=>{
    const div=document.createElement('div');
    div.className='station-card';
    if(item===mediaList[currentIndex]) div.classList.add('active');
    div.setAttribute('data-index',mediaList.indexOf(item));
    div.innerHTML=`<div class="station-card-icon">${item.logo}</div>
                   <div class="station-card-name">${item.name}</div>
                   <div class="station-card-genre">${item.type==='radio' ? 'Estação' : item.artist}</div>
                   <div class="station-card-type">${item.type==='radio' ? 'Rádio' : 'Música'}</div>`;
    mediaContainer.appendChild(div);
  });
}

// Atualiza histórico
function updateHistory(item){
  const historyItem = `${item.name} - ${item.nowPlaying}`;
  // Evita duplicatas consecutivas
  if (history.length === 0 || history[0] !== historyItem) {
    history.unshift(historyItem);
    if(history.length>5) history.pop();
    historyList.innerHTML=history.map(h=>`<li>${h}</li>`).join('');
  }
}

// Carrega mídia
function loadMedia(index){
  if(index<0||index>=mediaList.length) return;
  currentIndex=index;
  const item=mediaList[index];
  stationName.textContent=item.name;
  stationGenre.textContent=item.type==='music'?item.artist:'Estação';
  stationLogo.querySelector('span').textContent=item.logo;
  nowPlaying.innerHTML='<span class="loading-spinner"></span>Carregando...';
  
  // Mostrar/ocultar controles de progresso para músicas locais
  if (item.type === 'music') {
    progressContainer.style.display = 'block';
    durationEl.textContent = item.duration || '0:00';
  } else {
    progressContainer.style.display = 'none';
  }
  
  audioElement.src=item.src;
  document.querySelectorAll('.station-card').forEach(c=>c.classList.remove('active'));
  document.querySelector(`.station-card[data-index="${index}"]`).classList.add('active');
  
  if(isPlaying) playMedia();
}

// Atualiza barra de progresso
function updateProgress(e) {
  const { duration, currentTime } = e.srcElement;
  if (isNaN(duration)) return;
  
  const progressPercent = (currentTime / duration) * 100;
  progressBar.style.width = `${progressPercent}%`;
  
  // Atualizar tempo atual
  let minutes = Math.floor(currentTime / 60);
  let seconds = Math.floor(currentTime % 60);
  seconds = seconds < 10 ? '0' + seconds : seconds;
  currentTimeEl.textContent = `${minutes}:${seconds}`;
}

// Reproduz
function playMedia(){
  audioElement.play().then(()=>{
    isPlaying=true;
    playBtn.textContent="⏸";
    stationLogo.classList.add('playing');
    nowPlaying.textContent=`Tocando agora: ${mediaList[currentIndex].nowPlaying}`;
    updateHistory(mediaList[currentIndex]);
  }).catch((error)=>{
    console.error("Erro na reprodução:", error);
    nowPlaying.textContent="Erro ao reproduzir";
    isPlaying = false;
    playBtn.textContent="▶";
    stationLogo.classList.remove('playing');
  });
}

// Pausa
function pauseMedia(){
  audioElement.pause();
  isPlaying=false;
  playBtn.textContent="▶";
  stationLogo.classList.remove('playing');
  nowPlaying.textContent="Reprodução pausada";
}

// Define a posição da música baseada no clique na barra de progresso
function setProgress(e) {
  const width = this.clientWidth;
  const clickX = e.offsetX;
  const duration = audioElement.duration;
  
  audioElement.currentTime = (clickX / width) * duration;
}

// Filtra a lista de mídia
function filterMedia(searchTerm) {
  if (!searchTerm) {
    filteredMediaList = [...mediaList];
  } else {
    filteredMediaList = mediaList.filter(item => 
      item.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      (item.artist && item.artist.toLowerCase().includes(searchTerm.toLowerCase())) ||
      item.nowPlaying.toLowerCase().includes(searchTerm.toLowerCase())
    );
  }
  renderMediaCards();
}

// Eventos
playBtn.addEventListener('click',()=>{
  if(isPlaying) {
    pauseMedia();
  } else {
    if(!audioElement.src) loadMedia(currentIndex);
    playMedia();
  }
});

prevBtn.addEventListener('click',()=>{
  let n=currentIndex-1;
  if(n<0) n=mediaList.length-1;
  loadMedia(n);
});

nextBtn.addEventListener('click',()=>{
  let n=(currentIndex+1)%mediaList.length;
  loadMedia(n);
});

audioElement.addEventListener('ended',()=>{
  let n=(currentIndex+1)%mediaList.length;
  loadMedia(n);
  if(isPlaying) playMedia();
});

audioElement.addEventListener('timeupdate', updateProgress);
audioElement.addEventListener('canplay', () => {
  if (mediaList[currentIndex].type === 'music') {
    let duration = audioElement.duration;
    let minutes = Math.floor(duration / 60);
    let seconds = Math.floor(duration % 60);
    seconds = seconds < 10 ? '0' + seconds : seconds;
    durationEl.textContent = `${minutes}:${seconds}`;
  }
});

volumeSlider.addEventListener('input',()=>{
  audioElement.volume=volumeSlider.value/100;
});

// Clique nos cards
mediaContainer.addEventListener('click', function(e) {
  const card = e.target.closest('.station-card');
  if (card) {
    loadMedia(parseInt(card.getAttribute('data-index')));
  }
});

// Clique na barra de progresso
progressContainer.querySelector('.progress-bar').addEventListener('click', setProgress);

// Busca em tempo real
searchBox.addEventListener('input', (e) => {
  filterMedia(e.target.value);
});

// Inicializa
renderMediaCards();
loadMedia(0);
});
</script>
</body>
</html>