<?php
// ================== CONEXÃO COM O BANCO ==================
$host = 'localhost';
$dbname = 'cyber_cyber';
$user = 'cyber_cyber';
$pass = '@cybercoari'; // coloque sua senha aqui, se tiver

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}