<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QR Code com Logo</title>

<style>
    .qr-container {
        position: relative;
        display: inline-block;
        width: 256px;
        height: 256px;
        background: white;
    }

    .qr-logo {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        background: white;
        border-radius: 10px;
        padding: 5px;
        z-index: 10;
    }

    .qr-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
</style>
</head>
<body>

<div class="qr-container">
    <div id="qrcode"></div>
    <div class="qr-logo">
        <img src="cyber/imagens/logo.png" alt="Logo">
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    
    new QRCode(document.getElementById("qrcode"), {
        text: "https://cybercoari.com.br/qr.php",
        width: 256,
        height: 256,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });

});
</script>

</body>
</html>