<?php
// ==========================
// 🚫 Protege o validador
// ==========================
define('API_ACCESS_GRANTED', true);

// ==========================
// ⚙️ Inclui configuração e validador
// ==========================
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/validar_token.php';

// Agora o token já foi validado automaticamente!
// Se o código chegar até aqui, o token é válido e ativo ✅

// ==========================
// 💾 Exemplo de consulta real
// ==========================
$stmt = $pdo->query("SELECT id, username, nome_completo, email, tipo_usuario FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ==========================
// 📤 Retorna resposta JSON
// ==========================
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    "status" => "sucesso",
    "mensagem" => "Dados obtidos com sucesso",
    "dados" => $usuarios
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);