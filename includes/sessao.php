<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ================== MENSAGENS COM SWEETALERT ==================
function setFlash($tipo, $mensagem) {
    $_SESSION['flash'] = [
        'tipo' => $tipo,
        'mensagem' => $mensagem,
        'timestamp' => time()
    ];
}

function mostrarFlash($opcoesPersonalizadas = []) {
    if (!isset($_SESSION['flash'])) return;

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    $tiposValidos = ['success','error','warning','info','question'];
    $tipo = in_array($flash['tipo'], $tiposValidos) ? $flash['tipo'] : 'info';
    $msg = htmlspecialchars($flash['mensagem'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

    $opcoesPadrao = [
        'icon' => $tipo,
        'title' => $msg,
        'confirmButtonColor' => '#238636',
        'timer' => ($tipo === 'success') ? 3000 : null,
        'timerProgressBar' => true,
    ];

    $opcoes = array_merge($opcoesPadrao, $opcoesPersonalizadas);
    $opcoesJson = json_encode($opcoes, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swal !== 'undefined') {
            Swal.fire($opcoesJson);
        } else {
            alert('$msg');
        }
    });
    </script>";
}

// ================== ÚTIL PARA USO MANUAL ==================
function atualizarUltimoAcesso($pdo, $usuario_id) {
    $stmt = $pdo->prepare("UPDATE usuarios SET ultimo_acesso = NOW(), status_online = 1 WHERE id = ?");
    $stmt->execute([$usuario_id]);
}