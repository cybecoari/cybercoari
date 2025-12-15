<?php
// ================== CONFIGURAÇÕES INICIAIS ==================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

// ================== SESSÃO ==================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ================== INCLUDES ==================
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/function.php';
require_once __DIR__ . '/sessao.php';

// ================== STATUS ONLINE ==================
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];

    // Atualiza acesso e mantém usuário online
    $stmt = $pdo->prepare("UPDATE usuarios SET ultimo_acesso = NOW(), status_online = 1 WHERE id = ?");
    $stmt->execute([$usuario_id]);

    // Define offline quem está inativo há mais de 2 minutos
    $pdo->query("UPDATE usuarios SET status_online = 0 WHERE TIMESTAMPDIFF(MINUTE, ultimo_acesso, NOW()) > 2");
}