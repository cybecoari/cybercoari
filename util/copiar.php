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
  <title>Copiar Site Externo</title>

  <style>
    body {
      background-color: #16213e;
      color: #fff;
    }
    .container {
      margin-top: 50px;
      max-width: 700px;
    }
    #resultado {
      white-space: pre-wrap;
      background: #fff;
      color: #000;
      padding: 20px;
      border: 1px solid #ccc;
      max-height: 400px;
      overflow: auto;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h3 class="mb-4 text-center">
    <i class="bi bi-globe"></i> Copiar Site Externo
    </h3>

    <div class="input-group mb-3">
      <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
      <input type="text" id="url" class="form-control" placeholder="https://exemplo.com.br">
      <button class="btn btn-primary" onclick="copiarSite()">
        <i class="bi bi-files"></i> Copiar
      </button>
    </div>

    <div id="resultado" class="rounded shadow-sm"></div>
  </div>

  <audio id="sucesso" src="https://cybercoari.com.br/cyber/audio/sucesso.mp3" preload="auto"></audio>
  <!-- <audio id="erro" src="https://cybercoari.com.br/cyber/audio/success.mp3" preload="auto"></audio> -->

  <script>
    async function copiarSite() {
      const url = $("#url").val().trim();
      const proxy = "https://api.codetabs.com/v1/proxy?quest=";

      if (!url.startsWith("http")) {
        $("#erro")[0].play();
        Swal.fire({
          icon: "warning",
          title: "URL inválida",
          text: "Por favor, inclua http:// ou https:// no início da URL."
        });
        return;
      }

      try {
        const response = await fetch(proxy + encodeURIComponent(url));

        if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);

        const html = await response.text();

        if (!html) throw new Error("Conteúdo vazio retornado.");

        $("#resultado").html(
          html.replace(/</g, "&lt;").replace(/>/g, "&gt;")
        );

        $("#sucesso")[0].play();
        Swal.fire({
          icon: "success",
          title: "Sucesso",
          text: "HTML copiado com sucesso!",
          showConfirmButton: false,
          timer: 2000
        });

      } catch (error) {
        $("#erro")[0].play();
        Swal.fire({
          icon: "error",
          title: "Erro ao copiar",
          text: error.message
        });
      }
    }
  </script>
</body>
</html>