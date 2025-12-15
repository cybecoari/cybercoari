<?php
session_start();
include_once '/../config/config.php';

// Verificar se usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    die(json_encode(['sucesso' => false, 'mensagem' => 'Não logado']));
}

// Ler os dados JSON enviados
$dados = json_decode(file_get_contents('php://input'), true);
$modo_escuro = isset($dados['modo_escuro']) ? ($dados['modo_escuro'] ? 1 : 0) : 0;
$usuario_id = $_SESSION['usuario_id'];

try {
    // Atualizar no banco
    $atualizar = $pdo->prepare("UPDATE usuarios SET modo_escuro = ? WHERE id = ?");
    
    if ($atualizar->execute([$modo_escuro, $usuario_id])) {
        $_SESSION['modo_escuro'] = $modo_escuro;
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro no banco']);
    }
} catch(Exception $erro) {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'mensagem' => $erro->getMessage()]);
}
?>