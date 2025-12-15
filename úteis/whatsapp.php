<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gerador de Link WhatsApp</title>
  <?php
    $title = "Cybercoari - Gerador WhatsApp";
    include __DIR__ . "/../includes/header.php";
    include __DIR__ . "/../includes/cdn.php";
  ?>
  <meta name="description" content="Gere links diretos para conversas no WhatsApp com facilidade.">
  <meta name="theme-color" content="#25D366">
  <link rel="stylesheet" href="/assets/css/darkmode.css?v=5">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    .container { max-width: 700px; margin-top: 30px; }
    .list-group-item { cursor: pointer; }
    .list-group-item:hover { background: rgba(37, 211, 102, 0.1); }
    footer form { gap: 10px; }
  </style>
</head>
<body class="<?= $tema === 'escuro' ? 'dark-mode bg-dark text-white' : 'bg-light' ?>">

  <header class="bg-success text-white p-3 d-flex justify-content-between align-items-center">
    <span class="fw-bold"><i class="bi bi-whatsapp"></i> Gerador de Link WhatsApp</span>
    <div>
      <a href="https://wa.me/5597984189502" target="_blank" rel="noopener" class="text-white fs-4">
        <i class="bi bi-chat-dots"></i>
      </a>
    </div>
  </header>

  <main class="container py-4">
    <h5 class="mb-3"><i class="bi bi-clock-history"></i> Últimos números</h5>
    <ul class="list-group last-numbers"></ul>
  </main>

  <footer class="border-top py-3 <?= $tema === 'escuro' ? 'bg-dark text-white' : 'bg-white' ?>">
    <div class="container">
      <form class="frm-new-number row g-2">
        <div class="col-md-8">
          <input id="ws-number" class="form-control npt-number" type="text" 
                 placeholder="(00) 00000-0000" autocomplete="off" 
                 aria-label="Digite o número de telefone" 
                 pattern="[0-9 ()-]+$" required>
        </div>
        <div class="col-md-4 d-flex gap-2">
          <button type="submit" class="btn btn-success w-100">
            <i class="bi bi-whatsapp"></i> WhatsApp
          </button>
          <button type="button" class="btn btn-primary w-100 btn-sh">
            <i class="bi bi-share-fill"></i> Compartilhar
          </button>
        </div>
      </form>
    </div>
  </footer>

  <!-- SweetAlert2 -->
  <script src="https://cybercoari.com.br/cyber/js/sweetalert2.all.min.js"></script>

  <!-- Sons MP3 -->
  <audio id="sound-success" src="https://cybercoari.com.br/cyber/audio/success.mp3" preload="auto"></audio>
  <audio id="sound-error" src="https://cybercoari.com.br/cyber/audio/error.mp3" preload="auto"></audio>
  
  <?php 
    $anoAtual = date("Y");
    $versaoSistema = "1.0";
    $usuarioNome = $_SESSION['usuario_nome'] ?? "Sistema";
  ?>
  <div class="text-center mt-4 py-3 border-top">
    <p class="mb-1">
      &copy; <?= $anoAtual ?> - <?= htmlspecialchars($usuarioNome) ?> | 
      Versão <?= $versaoSistema ?>
    </p>
  </div>

  <?php include __DIR__ . "/../includes/footer.php"; ?>

  <script>
    const $frmNewNumber = document.querySelector('.frm-new-number');
    const $btnSh = document.querySelector('.btn-sh');
    const $nptNumber = document.querySelector('.npt-number');
    const $lastNumbers = document.querySelector('.last-numbers');
    const sndSuccess = document.getElementById('sound-success');
    const sndError = document.getElementById('sound-error');

    const setMask = (value, mask, ini = 0) => mask.replace(/\*/g, () => value[ini++] || '');
    const onlyNumbers = (number) => (String(number).match(/\d+/g) || []).join('');
    const openWhats = (number) => window.open(`https://wa.me/55${number}`, '_blank');
    const formatTime = (date) => new Date(date).toLocaleString('pt-br');

    const saveNumber = (strNumber) => {
      const listLastNumbers = JSON.parse(localStorage.getItem('numbers') || '[]');
      listLastNumbers.unshift({ phone: strNumber, time: Date.now() });
      localStorage.setItem('numbers', JSON.stringify(listLastNumbers.splice(0, 10)));
    }

    const showLastNumbers = () => {
      const listLastNumbers = JSON.parse(localStorage.getItem('numbers') || '[]');
      $lastNumbers.textContent = '';
      listLastNumbers.forEach(number => {
        $lastNumbers.innerHTML += `
          <li class="list-group-item d-flex justify-content-between align-items-center"
              onclick="openWhats(${onlyNumbers(number.phone)})">
            <span class="fw-bold">${number.phone}</span>
            <small class="text-muted">${formatTime(number.time)}</small>
          </li>`;
      });
    }

    const maskPhone = (phoneNumber) => {
      return phoneNumber.length < 11
        ? setMask(phoneNumber, '(**) ****-****')
        : setMask(phoneNumber, '(**) *****-****');
    }

    const clearInputNumber = () => $frmNewNumber.reset();

    $frmNewNumber.addEventListener('submit', (ev) => {
      ev.preventDefault();
      const number = onlyNumbers($nptNumber.value);
      if (number.length < 10) {
        sndError.play();
        return Swal.fire('Erro', 'Número inválido!', 'error');
      }
      const masked = maskPhone(number);
      saveNumber(masked);
      showLastNumbers();
      openWhats(number);
      sndSuccess.play();
      clearInputNumber();
    });

    $nptNumber.addEventListener('keyup', (ev) => {
      const value = onlyNumbers(ev.target.value);
      ev.target.value = value.length > 8 ? maskPhone(value) : value;
    });

    $btnSh.addEventListener('click', () => {
      const number = onlyNumbers($nptNumber.value);
      if (navigator.share && number.length >= 10) {
        navigator.share({
          title: 'Link do WhatsApp',
          text: 'Link do WhatsApp para o número ' + maskPhone(number),
          url: 'https://wa.me/55' + number,
        }).catch((error) => console.log('Erro ao compartilhar:', error));
      } else {
        sndError.play();
        Swal.fire('Atenção', 'Navegador não suporta compartilhamento ou número inválido.', 'warning');
      }
    });

    window.onload = showLastNumbers;
  </script>

</body>
</html>