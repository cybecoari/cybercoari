<?php
require_once __DIR__ . '/../includes/init.php';

header('Content-Type: application/json');

// Recebe o token via GET ou POST
$token = $_GET['token'] ?? $_POST['token'] ?? null;

if (!$token) {
    echo json_encode(['success' => false, 'error' => 'Token não enviado']);
    exit;
}

// Remove tokens expirados automaticamente (opcional, já tem no painel)
$pdo->query("DELETE FROM api_tokens WHERE status='pending_payment' AND expires_at <= NOW()");

// Verifica se o token existe, está pago e não expirou
$stmt = $pdo->prepare("
    SELECT t.id, t.token_hash, t.label, t.price, t.status, t.paid, t.expires_at, u.nome AS owner_nome
    FROM api_tokens t
    JOIN usuarios u ON u.id = t.owner_user_id
    WHERE t.token_hash = :token
");
$stmt->execute([':token' => $token]);
$tokenData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tokenData) {
    echo json_encode(['success' => false, 'error' => 'Token inválido']);
    exit;
}

// Verifica expiração e pagamento
$agora = new DateTime();
$expires = new DateTime($tokenData['expires_at']);
if ($tokenData['status'] !== 'paid' || $expires < $agora) {
    echo json_encode(['success' => false, 'error' => 'Token expirado ou não pago']);
    exit;
}

// Retorna dados do token
echo json_encode([
    'success' => true,
    'token' => $tokenData['token_hash'],
    'owner' => $tokenData['owner_nome'],
    'label' => $tokenData['label'],
    'price' => $tokenData['price'],
    'expires_at' => $tokenData['expires_at']
]);