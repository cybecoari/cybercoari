<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/funcoes.php");
isLogged($sid); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gerador de Link WhatsApp</title>
  <meta name="description" content="Gere links diretos para conversas no WhatsApp com facilidade.">
  <meta name="theme-color" content="#25D366">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22> </text></svg>">
  
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <style>
    :root {
      --whatsapp-green: #25D366;
      --whatsapp-light: #dcf8c6;
      --whatsapp-dark: #128C7E;
      --background: #f0f2f5;
      --card-bg: #ffffff;
      --text-primary: #3b4a54;
      --text-secondary: #667781;
      --border-radius: 12px;
      --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
      background: var(--background);
      color: var(--text-primary);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      line-height: 1.5;
    }

    header {
      background: var(--whatsapp-green);
      color: white;
      padding: 1.2rem 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    header span { font-size: 1.3rem; font-weight: 600; }

    .nb-buttons a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      transition: all 0.3s ease;
    }

    .nb-buttons a:hover { background: rgba(255, 255, 255, 0.3); transform: scale(1.05); }

    .nb-buttons i { font-size: 1.5rem; color: white; }

    main {
      flex: 1;
      padding: 1.5rem 1rem;
      max-width: 600px;
      margin: 0 auto;
      width: 100%;
    }

    .card {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .card-title {
      font-size: 1.2rem;
      margin-bottom: 1rem;
      color: var(--text-primary);
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .card-title i { color: var(--whatsapp-green); }

    footer {
      background: var(--card-bg);
      padding: 1.5rem;
      box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
      border-top-left-radius: var(--border-radius);
      border-top-right-radius: var(--border-radius);
    }

    .frm-new-number { display: flex; flex-direction: column; gap: 1rem; }

    .input-group { display: flex; gap: 0.5rem; }

    .npt-number, .npt-ddi {
      padding: 1rem;
      font-size: 1rem;
      border: 2px solid #e6e6e6;
      border-radius: var(--border-radius);
      outline: none;
      transition: border-color 0.3s;
    }

    .npt-number:focus, .npt-ddi:focus { border-color: var(--whatsapp-green); }

    .npt-ddi { width: 80px; text-align: center; }

    .group-btn { display: flex; gap: 0.5rem; }

    .btn {
      display: flex; align-items: center; justify-content: center; gap: 0.5rem;
      padding: 1rem; font-size: 1rem; font-weight: 600;
      border: none; border-radius: var(--border-radius);
      cursor: pointer; transition: all 0.3s ease; flex: 1;
    }

    .btn-ws { background: var(--whatsapp-green); color: white; }
    .btn-ws:hover { background: var(--whatsapp-dark); transform: translateY(-2px); }

    .btn-sh { background: var(--whatsapp-light); color: var(--text-primary); }
    .btn-sh:hover { background: #c6e9b5; transform: translateY(-2px); }

    ul.last-numbers { list-style: none; padding: 0; margin: 0; }
    ul.last-numbers li {
      background: var(--card-bg);
      padding: 1rem;
      border-radius: var(--border-radius);
      margin-bottom: 0.75rem;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: var(--shadow);
      transition: all 0.3s ease;
      border-left: 4px solid var(--whatsapp-green);
    }
    ul.last-numbers li:hover { transform: translateX(5px); }

    .number { font-weight: bold; color: var(--text-primary); }
    .time { font-size: 0.85em; color: var(--text-secondary); }

    .empty-state { text-align: center; padding: 2rem; color: var(--text-secondary); }
    .empty-state i { font-size: 3rem; margin-bottom: 1rem; color: #ccc; }

    @media (max-width: 480px) { .input-group { flex-direction: column; } .group-btn { flex-direction: column; } }

    .sr-only {
      position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px;
      overflow: hidden; clip: rect(0,0,0,0); border: 0;
    }
  </style>
</head>
<body>

  <header>
    <span>Gerador de Link WhatsApp</span>
    <div class="nb-buttons">
      <a href="https://wa.me/5597984189502" target="_blank" rel="noopener" aria-label="Fale conosco no WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
      </a>
    </div>
  </header>

  <main>
    <div class="card">
      <h2 class="card-title"><i class="fa-solid fa-clock-rotate-left"></i> Números recentes</h2>
      <ul class="last-numbers"></ul>
      <div class="empty-state" id="emptyState" style="display: none;">
        <i class="fa-solid fa-comments"></i>
        <p>Nenhum número recente</p>
        <small>Os números que você converter aparecerão aqui</small>
      </div>
    </div>
  </main>

  <footer>
    <form class="frm-new-number">
      <div class="input-group">
        <label for="ws-ddi" class="sr-only">Código do país (DDI)</label>
        <input id="ws-ddi" class="npt-ddi" type="text" placeholder="+55" value="55" maxlength="3" aria-label="Código do país">

        <label for="ws-number" class="sr-only">Número de telefone</label>
        <input id="ws-number" class="npt-number" type="text" placeholder="(00) 00000-0000" autocomplete="off" pattern="[0-9 ()-]+$" required aria-label="Digite o número de telefone">
      </div>
      <div class="group-btn">
        <button type="submit" class="btn btn-ws"><i class="fa-solid fa-message"></i> WhatsApp</button>
        <button type="button" class="btn btn-sh" aria-label="Compartilhar link" id="shareButton">
          <i class="fa-solid fa-share-nodes"></i> Compartilhar
        </button>
      </div>
    </form>
  </footer>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Sons MP3 -->
  <audio id="sound-success" preload="auto">
    <source src="https://assets.mixkit.co/sfx/preview/mixkit-unlock-game-notification-253.mp3" type="audio/mp3">
  </audio>
  <audio id="sound-error" preload="auto">
    <source src="https://assets.mixkit.co/sfx/preview/mixkit-wrong-answer-fail-notification-946.mp3" type="audio/mp3">
  </audio>

  <script>
    const $frmNewNumber = document.querySelector('.frm-new-number');
    const $btnSh = document.querySelector('#shareButton');
    const $nptNumber = document.querySelector('#ws-number');
    const $nptDDI = document.querySelector('#ws-ddi');
    const $lastNumbers = document.querySelector('.last-numbers');
    const $emptyState = document.querySelector('#emptyState');
    const sndSuccess = document.getElementById('sound-success');
    const sndError = document.getElementById('sound-error');

    const setMask = (value, mask, ini = 0) => mask.replace(/\*/g, () => value[ini++] || '');
    const onlyNumbers = (number) => (String(number).match(/\d+/g) || []).join('');
    const openWhats = (ddi, number) => window.open(`https://wa.me/${ddi}${number}`, '_blank');
    const formatTime = (date) => new Date(date).toLocaleString('pt-BR');

    const saveNumber = (strNumber) => {
      const listLastNumbers = JSON.parse(localStorage.getItem('numbers') || '[]');
      const filteredList = listLastNumbers.filter(item => item.phone !== strNumber);
      filteredList.unshift({ phone: strNumber, time: Date.now() });
      localStorage.setItem('numbers', JSON.stringify(filteredList.slice(0, 10)));
    }

    const showLastNumbers = () => {
      const listLastNumbers = JSON.parse(localStorage.getItem('numbers') || '[]');
      $lastNumbers.textContent = '';
      if (listLastNumbers.length === 0) { $emptyState.style.display = 'block'; return; }
      $emptyState.style.display = 'none';
      listLastNumbers.forEach((number, index) => {
        const li = document.createElement('li');
        li.innerHTML = `<p class="number">${number.phone}</p><span class="time">${formatTime(number.time)}</span>`;
        li.addEventListener('click', () => openWhats("55", onlyNumbers(number.phone)));
        $lastNumbers.appendChild(li);
      });
    }

    const maskPhone = (phoneNumber) => {
      return phoneNumber.length < 11
        ? setMask(phoneNumber, '(**) ****-****')
        : setMask(phoneNumber, '(**) *****-****');
    }

    const isValidPhone = (number) => {
      const cleaned = onlyNumbers(number);
      return cleaned.length >= 10 && cleaned.length <= 11;
    }

    $frmNewNumber.addEventListener('submit', (ev) => {
      ev.preventDefault();
      const ddi = onlyNumbers($nptDDI.value) || "55";
      const number = onlyNumbers($nptNumber.value);
      if (!isValidPhone(number)) {
        sndError.play();
        Swal.fire({ icon: 'error', title: 'Número inválido', text: 'Digite DDD + 8 ou 9 dígitos', confirmButtonColor: '#25D366', timer: 2500 });
        return;
      }
      const masked = maskPhone(number);
      saveNumber(masked);
      showLastNumbers();
      openWhats(ddi, number);
      sndSuccess.play();
      $nptNumber.style.borderColor = '#25D366';
      setTimeout(() => $nptNumber.style.borderColor = '#e6e6e6', 1000);
    });

    $nptNumber.addEventListener('input', (ev) => {
      const value = onlyNumbers(ev.target.value);
      ev.target.value = value.length > 2 ? maskPhone(value) : value;
    });

    $btnSh.addEventListener('click', () => {
      const ddi = onlyNumbers($nptDDI.value) || "55";
      const number = onlyNumbers($nptNumber.value);
      if (!isValidPhone(number)) {
        sndError.play();
        Swal.fire({ icon: 'warning', title: 'Número inválido', text: 'Digite um número válido para compartilhar', confirmButtonColor: '#25D366', timer: 2500 });
        return;
      }
      const shareUrl = `https://wa.me/${ddi}${number}`;
      const shareText = `Conversar no WhatsApp: ${maskPhone(number)}`;
      if (navigator.share) {
        navigator.share({ title: 'Link do WhatsApp', text: shareText, url: shareUrl })
          .catch(() => copyToClipboard(shareUrl));
      } else {
        copyToClipboard(shareUrl);
      }
    });

    const copyToClipboard = (text) => {
      navigator.clipboard.writeText(text).then(() => {
        Swal.fire({ icon: 'success', title: 'Link copiado!', text: 'O link foi copiado para a área de transferência', confirmButtonColor: '#25D366', timer: 2000 });
      });
    }

    window.addEventListener('DOMContentLoaded', () => {
      showLastNumbers();
      const urlParams = new URLSearchParams(window.location.search);
      const phoneParam = onlyNumbers(urlParams.get('phone') || '');
      if (phoneParam && isValidPhone(phoneParam)) {
        $nptNumber.value = maskPhone(phoneParam);
      }
    });
  </script>

</body>
</html>