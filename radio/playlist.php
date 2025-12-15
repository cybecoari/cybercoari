<?php
$baseDir = "../cyber/musicas/";
$playlist = [];

// Lê todas as subpastas
$subdirs = glob($baseDir . "*", GLOB_ONLYDIR);

foreach($subdirs as $dir){
    $files = glob($dir . "/*.mp3"); // pega MP3 de cada subpasta
    foreach($files as $file){
        $playlist[] = [
            "title" => basename($file, ".mp3"),
            "url" => $file
        ];
    }
}

// Inclui MP3 diretamente na pasta principal
$mainFiles = glob($baseDir . "*.mp3");
foreach($mainFiles as $file){
    $playlist[] = [
        "title" => basename($file, ".mp3"),
        "url" => $file
    ];
}

echo json_encode($playlist);
?>