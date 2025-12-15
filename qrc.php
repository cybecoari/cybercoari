<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>QR Code com Logo</title>
<style>
  #container {
    position: relative;
    width: 256px;
    height: 256px;
  }
  #logo {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px; /* tamanho da logo */
    border-radius: 16px;
  }
</style>
</head>
<body>

<div id="container">
  <div id="qrcode"></div>
  <img id="logo" src="cyber/imagens/logo.png">
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
new QRCode(document.getElementById("qrcode"), {
    text: "https://cybercoari.com.br",
    width: 256,
    height: 256,
    correctLevel: QRCode.CorrectLevel.H
});
</script>

</body>
</html>