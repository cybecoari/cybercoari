<?php
require_once __DIR__ . '/includes/init.php';

// Se o usuário estiver logado, marca como offline
if (isset($_SESSION['usuario_id'])) {
    $stmt = $pdo->prepare("UPDATE usuarios SET status_online = 0 WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['usuario_id']]);
}

// Encerra a sessão normalmente
session_unset();
session_destroy();

setSuccess("Você saiu do sistema com sucesso!");
redirecionar('login.php');