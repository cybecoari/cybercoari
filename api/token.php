<?php
/**
 * Gera um token seguro
 *
 * @param int $length Tamanho do token (padrão: 32 bytes)
 * @return string Token hexadecimal seguro
 */
function gerarToken($length = 32) {
    // Gera bytes aleatórios seguros
    $bytes = random_bytes($length);

    // Converte para hexadecimal
    return bin2hex($bytes);
}

/**
 * Exemplo de uso:
 * $token = gerarToken(); // 64 caracteres hexadecimais
 */