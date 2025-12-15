<?php
// ====================== FUNÇÕES GLOBAIS ======================

// Sanitiza strings
if (!function_exists('limparString')) {
    function limparString($string) {
        return trim(htmlspecialchars($string, ENT_QUOTES, 'UTF-8'));
    }
}

// Limpa POST
if (!function_exists('limparPost')) {
    function limparPost($campo) {
        return isset($_POST[$campo]) ? limparString($_POST[$campo]) : '';
    }
}

// Gera hash de senha
if (!function_exists('gerarHashSenha')) {
    function gerarHashSenha($senha) {
        return password_hash($senha, PASSWORD_DEFAULT);
    }
}

// Verifica senha
if (!function_exists('verificarSenha')) {
    function verificarSenha($senha, $hash) {
        return password_verify($senha, $hash);
    }
}

// Formata data
if (!function_exists('formatarData')) {
    function formatarData($data) {
        return $data ? date('d/m/Y', strtotime($data)) : '';
    }
}

// Formata data e hora
if (!function_exists('formatarDataHora')) {
    function formatarDataHora($dataHora) {
        return $dataHora ? date('d/m/Y H:i', strtotime($dataHora)) : '';
    }
}

// Redireciona
if (!function_exists('redirecionar')) {
    function redirecionar($url) {
        if (!headers_sent()) header("Location: $url");
        else echo "<script>window.location.href='$url';</script>";
        exit;
    }
}

// Checa se usuário está logado
if (!function_exists('usuarioLogado')) {
    function usuarioLogado() {
        return isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id']);
    }
}

// Protege página (verifica login)
if (!function_exists('protegerPagina')) {
    function protegerPagina() {
        if (!usuarioLogado()) redirecionar('login.php');
    }
}

// Gera token aleatório
if (!function_exists('gerarToken')) {
    function gerarToken($tamanho = 32) {
        return bin2hex(random_bytes($tamanho));
    }
}

// Debug seguro
if (!function_exists('debug')) {
    function debug($var) {
        echo '<pre style="background:#f4f4f4; padding:10px; border:1px solid #ccc;">';
        print_r($var);
        echo '</pre>';
    }
}

// ================== MENSAGENS FLASH ==================
if (!function_exists('setError')) {
    function setError($msg) {
        $_SESSION['erro'] = $msg;
    }
}

if (!function_exists('getErro')) {
    function getErro() {
        $msg = $_SESSION['erro'] ?? '';
        unset($_SESSION['erro']);
        return $msg;
    }
}

if (!function_exists('setSuccess')) {
    function setSuccess($msg) {
        $_SESSION['sucesso'] = $msg;
    }
}

if (!function_exists('getSucesso')) {
    function getSucesso() {
        $msg = $_SESSION['sucesso'] ?? '';
        unset($_SESSION['sucesso']);
        return $msg;
    }
}