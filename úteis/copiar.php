<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Copiar Site Externo</title>
  <?php include __DIR__ . "/../includes/header.php"; ?>

  <!-- Bootstrap + ícones -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Highlight.js (claro e escuro) -->
  <link id="hljs-light" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css" disabled>
  <link id="hljs-dark" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" disabled>

  <style>
    pre {
      max-height: 500px;
      overflow: auto;
      border-radius: .5rem;
      padding: 1rem;
    }
  </style>
</head>
<body class="bg-<?php echo $tema === 'escuro' ? 'dark text-light' : 'light'; ?>">
  <div class="container py-4">
    <h3 class="text-center mb-4">
      <i class="bi bi-globe"></i> Copiar Site Externo
    </h3>

    <!-- Formulário -->
    <div class="input-group mb-3">
      <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
      <input type="text" id="url" class="form-control" placeholder="https://exemplo.com.br">
      <button class="btn btn-primary" onclick="copiarSite()">
        <i class="bi bi-files"></i> Copiar
      </button>
    </div>

    <!-- Resultado -->
    <div id="resultado" class="d-none">
      <div class="d-flex justify-content-end gap-2 mb-2">
        <button class="btn btn-sm btn-outline-secondary" id="btnCopiar"><i class="bi bi-clipboard"></i> Copiar Código</button>
        <button class="btn btn-sm btn-outline-success" id="btnBaixar"><i class="bi bi-download"></i> Baixar HTML</button>
      </div>
      <pre><code id="codigoFonte" class="language-html"></code></pre>
    </div>
  </div>

  <!-- Sons -->
  <audio id="sucesso" src="https://cybercoari.com.br/cyber/audio/success.mp3" preload="auto"></audio>
  <audio id="erro" src="https://cybercoari.com.br/cyber/audio/error.mp3" preload="auto"></audio>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
   <?php include __DIR__ . "/../includes/footer.php"; ?>

  <script>
    // Ativa tema do Highlight.js conforme sessão PHP
    const temaAtual = "<?php echo $tema; ?>";
    if (temaAtual === "escuro") {
      document.getElementById("hljs-dark").disabled = false;
    } else {
      document.getElementById("hljs-light").disabled = false;
    }

    hljs.highlightAll();

    // Função para formatar HTML (indentação)
    function formatarHTML(html) {
      let formatted = '';
      const regex = /(>)(<)(\/*)/g;
      html = html.replace(regex, '$1\n$2$3');
      let pad = 0;
      html.split('\n').forEach(function(node) {
        if (node.match(/<\/\w/)) pad -= 2;
        formatted += ' '.repeat(pad) + node.trim() + '\n';
        if (node.match(/<\w([^>]*[^/])?>/)) pad += 2;
      });
      return formatted.trim();
    }

    // Função principal
    async function copiarSite() {
      const url = $("#url").val().trim();
      const proxy = "https://api.codetabs.com/v1/proxy?quest=";

      if (!url.startsWith("http")) {
        $("#erro")[0].play();
        Swal.fire({ icon: "warning", title: "URL inválida", text: "Inclua http:// ou https:// no início." });
        return;
      }

      try {
        const response = await fetch(proxy + encodeURIComponent(url));
        if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);

        let html = await response.text();
        if (!html) throw new Error("Conteúdo vazio retornado.");

        // Formatar e exibir
        let codigoFormatado = formatarHTML(html);
        $("#codigoFonte").text(codigoFormatado);
        hljs.highlightAll();

        $("#resultado").removeClass("d-none");
        $("#sucesso")[0].play();
        Swal.fire({ icon: "success", title: "Sucesso", text: "Código carregado com sucesso!", timer: 2000, showConfirmButton: false });
      } catch (error) {
        $("#erro")[0].play();
        Swal.fire({ icon: "error", title: "Erro ao copiar", text: error.message });
      }
    }

    // Copiar código
    $(document).on("click", "#btnCopiar", function() {
      const codigo = $("#codigoFonte").text();
      navigator.clipboard.writeText(codigo).then(() => {
        $("#sucesso")[0].play();
        Swal.fire({ icon: "success", title: "Copiado!", text: "Código HTML copiado para a área de transferência.", timer: 1500, showConfirmButton: false });
      });
    });

    // Baixar código
    $(document).on("click", "#btnBaixar", function() {
      let codigo = $("#codigoFonte").text();
      codigo = formatarHTML(codigo);

      const urlDigitada = $("#url").val().trim();
      let nomeArquivo = "site-copiado.html";
      try {
        const dominio = new URL(urlDigitada).hostname;
        nomeArquivo = dominio + ".html";
      } catch (e) {}

      const blob = new Blob([codigo], { type: "text/html;charset=utf-8" });
      const link = document.createElement("a");
      link.href = URL.createObjectURL(blob);
      link.download = nomeArquivo;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);

      $("#sucesso")[0].play();
      Swal.fire({ icon: "success", title: "Download iniciado", text: "Arquivo HTML formatado sendo baixado.", timer: 1500, showConfirmButton: false });
    });
  </script>
</body>
</html>