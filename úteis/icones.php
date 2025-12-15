<include($_SERVER['DOCUMENT_ROOT'].'/config/cdns.php');

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Ícones do Bootstrap Icons com Pesquisa Funcional</title>
    <link rel="stylesheet" href="https://cybercoari.com.br/cyber/icones/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #6f42c1;
            --secondary: #0d6efd;
            --success: #198754;
            --info: #0dcaf0;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #212529;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #16213e 0%, #e9ecef 100%);
            color: #212529;
            padding: 20px;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        header {
            background: var(--primary);
            color: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            text-align: center;
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .search-container {
            margin: 30px auto;
            max-width: 600px;
            position: relative;
        }
        
        #search {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid var(--primary);
            border-radius: 50px;
            font-size: 1.1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        #search:focus {
            outline: none;
            box-shadow: 0 4px 15px rgba(111, 66, 193, 0.3);
            border-color: var(--info);
        }
        
        .search-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 1.2rem;
        }
        
        .stats {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .stat-card {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            text-align: center;
            min-width: 180px;
        }
        
        .stat-card h3 {
            color: var(--primary);
            font-size: 1.8rem;
            margin-bottom: 5px;
        }
        
        .stat-card p {
            color: #6c757d;
            font-weight: 500;
        }
        
        .filters {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0 30px;
            flex-wrap: wrap;
        }
        
        .filter-btn {
            padding: 8px 20px;
            background: white;
            border: 2px solid var(--primary);
            border-radius: 30px;
            color: var(--primary);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .filter-btn:hover, .filter-btn.active {
            background: var(--primary);
            color: white;
        }
        
        .icons-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .icon-card {
            background: white;
            border-radius: 12px;
            padding: 25px 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .icon-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(111, 66, 193, 0.2);
            border-bottom: 4px solid var(--primary);
        }
        
        .icon-card i {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        
        .icon-card:hover i {
            transform: scale(1.2);
            color: var(--info);
        }
        
        .icon-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--dark);
            word-break: break-word;
        }
        
        .copy-notification {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--success);
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1000;
        }
        
        .copy-notification.show {
            opacity: 1;
        }
        
        .no-results {
            grid-column: 1 / -1;
            text-align: center;
            padding: 50px;
            font-size: 1.2rem;
            color: #6c757d;
            display: none;
        }
        
        .usage {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin: 50px 0;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .usage h2 {
            color: var(--primary);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .usage-code {
            background: #2d2d2d;
            color: #f8f8f2;
            border-radius: 8px;
            padding: 20px;
            overflow-x: auto;
            margin: 20px 0;
            font-family: 'Fira Code', monospace;
        }
        
        footer {
            text-align: center;
            padding: 30px;
            margin-top: 50px;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .icons-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
            
            .stat-card {
                min-width: 140px;
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="bi bi-bootstrap"></i> Bootstrap Icons</h1>
            <p class="subtitle">Biblioteca completa de ícones de código aberto para projetos Bootstrap</p>
        </header>
        
        <div class="search-container">
            <input type="text" id="search" placeholder="Pesquisar ícones (ex: heart, star, arrow...)">
            <div class="search-icon">
                <i class="bi bi-search"></i>
            </div>
        </div>
        
        <div class="stats">
            <div class="stat-card">
                <h3 id="icon-count">0</h3>
                <p>Ícones Disponíveis</p>
            </div>
            <div class="stat-card">
                <h3>100%</h3>
                <p>Grátis e Open Source</p>
            </div>
            <div class="stat-card">
                <h3>1.11.3</h3>
                <p>Versão Atual</p>
            </div>
        </div>
        
        <div class="filters">
            <button class="filter-btn active" data-filter="all">Todos</button>
            <button class="filter-btn" data-filter="arrows">Setas</button>
            <button class="filter-btn" data-filter="media">Mídia</button>
            <button class="filter-btn" data-filter="communication">Comunicação</button>
            <button class="filter-btn" data-filter="devices">Dispositivos</button>
            <button class="filter-btn" data-filter="files">Arquivos</button>
            <button class="filter-btn" data-filter="shapes">Formas</button>
        </div>
        
        <div class="icons-grid" id="icons-container">
            <!-- Os ícones serão gerados por JavaScript -->
        </div>
        
        <div class="no-results" id="no-results">
            <i class="bi bi-search" style="font-size: 3rem; margin-bottom: 15px;"></i>
            <h3>Nenhum ícone encontrado</h3>
            <p>Tente usar termos diferentes ou verifique a ortografia</p>
        </div>
        
        <div class="usage">
            <h2><i class="bi bi-code-slash"></i> Como Usar</h2>
            <p>Para usar qualquer um desses ícones em seu projeto, siga estas etapas:</p>
            
            <div class="usage-code">
                <pre>&lt;!-- 1. Adicione o CDN do Bootstrap Icons no cabeçalho --&gt;
&lt;link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"&gt;

&lt;!-- 2. Use o ícone com a classe "bi" e o nome do ícone --&gt;
&lt;i class="bi bi-<span id="example-icon">heart</span>"&gt;&lt;/i&gt;</pre>
            </div>
            
            <p>Clique em qualquer ícone acima para copiar seu código para a área de transferência.</p>
        </div>
        
        <footer>
            <p>Bootstrap Icons v1.11.3 | Total de <span id="footer-icon-count">0</span> ícones disponíveis</p>
            <p>© 2024 | Projeto Open Source mantido pelo time do Bootstrap</p>
        </footer>
    </div>
    
    <div class="copy-notification" id="copyNotification">
        Código copiado para a área de transferência!
    </div>
    
    <script>
        // Lista completa de ícones Bootstrap (versão 1.11.3)
        // Foram removidos os ícones muito específicos para melhor performance
        const icons = [
            // Setas
            'bi-arrow-up', 'bi-arrow-down', 'bi-arrow-left', 'bi-arrow-right',
            'bi-arrow-up-circle', 'bi-arrow-down-circle', 'bi-arrow-left-circle', 'bi-arrow-right-circle',
            'bi-chevron-up', 'bi-chevron-down', 'bi-chevron-left', 'bi-chevron-right',
            'bi-chevron-double-up', 'bi-chevron-double-down', 'bi-chevron-double-left', 'bi-chevron-double-right',
            'bi-caret-up', 'bi-caret-down', 'bi-caret-left', 'bi-caret-right',
            'bi-arrow-clockwise', 'bi-arrow-counterclockwise', 'bi-arrow-repeat', 'bi-arrow-return-left',
            
            // Mídia
            'bi-play', 'bi-pause', 'bi-stop', 'bi-skip-start', 'bi-skip-end',
            'bi-volume-up', 'bi-volume-down', 'bi-volume-mute', 'bi-volume-off',
            'bi-mic', 'bi-mic-mute', 'bi-camera', 'bi-camera-video', 'bi-camera-reels',
            'bi-image', 'bi-image-alt', 'bi-images', 'bi-film', 'bi-easel',
            
            // Comunicação
            'bi-chat', 'bi-chat-dots', 'bi-chat-left', 'bi-chat-right', 'bi-chat-quote',
            'bi-envelope', 'bi-envelope-open', 'bi-envelope-plus', 'bi-envelope-exclamation',
            'bi-bell', 'bi-bell-slash', 'bi-megaphone', 'bi-telephone', 'bi-telephone-plus',
            'bi-telephone-outbound', 'bi-telephone-inbound', 'bi-telephone-forward', 'bi-telephone-x',
            
            // Dispositivos
            'bi-phone', 'bi-phone-vibrate', 'bi-tablet', 'bi-laptop', 'bi-display',
            'bi-displayport', 'bi-cpu', 'bi-gpu-card', 'bi-motherboard', 'bi-device-ssd',
            'bi-device-hdd', 'bi-keyboard', 'bi-mouse', 'bi-mouse2', 'bi-mouse3',
            'bi-printer', 'bi-projector', 'bi-router', 'bi-usb-drive', 'bi-sd-card',
            
            // Arquivos
            'bi-file', 'bi-file-earmark', 'bi-file-text', 'bi-file-earmark-text', 'bi-file-code',
            'bi-file-earmark-code', 'bi-file-image', 'bi-file-earmark-image', 'bi-file-pdf', 'bi-file-earmark-pdf',
            'bi-file-word', 'bi-file-earmark-word', 'bi-file-excel', 'bi-file-earmark-excel', 'bi-file-ppt',
            'bi-file-earmark-ppt', 'bi-file-zip', 'bi-file-earmark-zip', 'bi-file-font', 'bi-file-earmark-font',
            
            // Formas
            'bi-circle', 'bi-square', 'bi-triangle', 'bi-pentagon', 'bi-hexagon',
            'bi-octagon', 'bi-diamond', 'bi-star', 'bi-star-fill', 'bi-star-half',
            'bi-heart', 'bi-heart-fill', 'bi-heart-half', 'bi-bookmark', 'bi-bookmark-fill',
            'bi-bookmark-star', 'bi-bookmark-star-fill', 'bi-bookmark-plus', 'bi-bookmark-plus-fill',
            
            // Outros populares
            'bi-search', 'bi-house', 'bi-house-door', 'bi-person', 'bi-people', 'bi-person-circle',
            'bi-gear', 'bi-gear-wide', 'bi-wrench', 'bi-tools', 'bi-hammer', 'bi-screwdriver',
            'bi-lock', 'bi-unlock', 'bi-shield', 'bi-shield-check', 'bi-shield-lock', 'bi-shield-exclamation',
            'bi-cloud', 'bi-cloud-download', 'bi-cloud-upload', 'bi-cloud-plus', 'bi-cloud-minus',
            'bi-wifi', 'bi-wifi-off', 'bi-bluetooth', 'bi-lightning', 'bi-lightning-charge',
            'bi-sun', 'bi-moon', 'bi-moon-stars', 'bi-umbrella', 'bi-droplet', 'bi-droplet-half',
            'bi-thermometer', 'bi-thermometer-sun', 'bi-thermometer-snow', 'bi-fire', 'bi-alarm',
            'bi-clock', 'bi-clock-history', 'bi-calendar', 'bi-calendar-check', 'bi-calendar-plus',
            'bi-calendar-event', 'bi-calendar-range', 'bi-credit-card', 'bi-cash', 'bi-coin',
            'bi-wallet', 'bi-wallet2', 'bi-graph-up', 'bi-graph-down', 'bi-bar-chart', 'bi-bar-chart-steps',
            'bi-pie-chart', 'bi-diagram-3', 'bi-diagram-2', 'bi-map', 'bi-globe', 'bi-geo', 'bi-geo-alt',
            'bi-compass', 'bi-flag', 'bi-pin', 'bi-pin-map', 'bi-truck', 'bi-car', 'bi-bicycle', 'bi-airplane',
            'bi-rocket', 'bi-rocket-takeoff', 'bi-ship', 'bi-train', 'bi-train-front', 'bi-bus', 'bi-bus-front',
            'bi-cart', 'bi-cart-plus', 'bi-cart-check', 'bi-cart-x', 'bi-bag', 'bi-bag-plus', 'bi-bag-check',
            'bi-bag-x', 'bi-gift', 'bi-gift-fill', 'bi-box', 'bi-box-seam', 'bi-tag', 'bi-tags', 'bi-receipt',
            'bi-receipt-cutoff', 'bi-scissors', 'bi-pencil', 'bi-pencil-square', 'bi-eraser', 'bi-brush',
            'bi-palette', 'bi-palette2', 'bi-eyedropper', 'bi-paint-bucket', 'bi-bucket', 'bi-magic', 'bi-stickies',
            'bi-sticky', 'bi-nut', 'bi-nut-fill', 'bi-wrench-adjustable', 'bi-wrench-adjustable-circle', 'bi-hammer',
            'bi-screwdriver', 'bi-funnel', 'bi-funnel-fill', 'bi-grid', 'bi-grid-3x3', 'bi-grid-1x2', 'bi-layout-sidebar',
            'bi-layout-sidebar-reverse', 'bi-layout-split', 'bi-layout-text-sidebar', 'bi-layout-text-sidebar-reverse',
            'bi-layout-text-window', 'bi-layout-text-window-reverse', 'bi-layout-three-columns', 'bi-layout-wtf',
            'bi-app', 'bi-app-indicator', 'bi-badge', 'bi-badge-3d', 'bi-badge-4k', 'bi-badge-ad', 'bi-badge-ar',
            'bi-badge-cc', 'bi-badge-hd', 'bi-badge-tm', 'bi-badge-vo', 'bi-badge-vr', 'bi-badge-wc', 'bi-bag-check',
            'bi-bag-dash', 'bi-bag-plus', 'bi-bag-x', 'bi-bank', 'bi-bank2', 'bi-basket', 'bi-basket2', 'bi-basket3',
            'bi-bell', 'bi-bell-fill', 'bi-bell-slash', 'bi-bell-slash-fill', 'bi-bezier', 'bi-bezier2', 'bi-bicycle',
            'bi-binoculars', 'bi-blockquote-left', 'bi-blockquote-right', 'bi-book', 'bi-book-half', 'bi-bookmark-check',
            'bi-bookmark-dash', 'bi-bookmark-heart', 'bi-bookmark-plus', 'bi-bookmark-star', 'bi-bookmark-x', 'bi-bookmarks',
            'bi-bookshelf', 'bi-boombox', 'bi-bootstrap', 'bi-bootstrap-fill', 'bi-bootstrap-reboot', 'bi-border',
            'bi-border-all', 'bi-border-bottom', 'bi-border-center', 'bi-border-inner', 'bi-border-left', 'bi-border-middle',
            'bi-border-outer', 'bi-border-right', 'bi-border-style', 'bi-border-top', 'bi-border-width', 'bi-bounding-box',
            'bi-box-arrow-down-left', 'bi-box-arrow-down-right', 'bi-box-arrow-down', 'bi-box-arrow-in-down', 'bi-box-arrow-in-left',
            'bi-box-arrow-in-right', 'bi-box-arrow-in-up', 'bi-box-arrow-left', 'bi-box-arrow-right', 'bi-box-arrow-up',
            'bi-box-arrow-up-left', 'bi-box-arrow-up-right', 'bi-box-seam', 'bi-box2', 'bi-box2-fill', 'bi-box2-heart',
            'bi-boxes', 'bi-braces', 'bi-bricks', 'bi-briefcase', 'bi-brightness-alt-high', 'bi-brightness-alt-low',
            'bi-brightness-high', 'bi-brightness-low', 'bi-broadcast', 'browser-chrome', 'browser-edge', 'browser-firefox',
            'browser-safari', 'bi-brush', 'bi-bucket', 'bi-bug', 'bi-building', 'bi-bullseye', 'bi-calculator', 'bi-calendar',
            'bi-calendar-check', 'bi-calendar-date', 'bi-calendar-day', 'bi-calendar-event', 'bi-calendar-minus', 'bi-calendar-plus',
            'bi-calendar-range', 'bi-calendar-week', 'bi-calendar-x', 'bi-camera', 'bi-camera-fill', 'bi-camera-reels',
            'bi-camera-video', 'bi-capslock', 'bi-card-checklist', 'bi-card-heading', 'bi-card-image', 'bi-card-list',
            'bi-card-text', 'bi-caret-down', 'bi-caret-left', 'bi-caret-right', 'bi-caret-up', 'bi-cart', 'bi-cart-check',
            'bi-cart-dash', 'bi-cart-plus', 'bi-cart-x', 'bi-cash', 'bi-cash-coin', 'bi-cast', 'bi-chat', 'bi-chat-dots',
            'bi-chat-fill', 'bi-chat-heart', 'bi-chat-left', 'bi-chat-left-dots', 'bi-chat-left-fill', 'bi-chat-left-heart',
            'bi-chat-left-quote', 'bi-chat-left-text', 'bi-chat-quote', 'bi-chat-right', 'bi-chat-right-dots', 'bi-chat-right-fill',
            'bi-chat-right-heart', 'bi-chat-right-quote', 'bi-chat-right-text', 'bi-chat-square', 'bi-chat-square-dots',
            'bi-chat-square-fill', 'bi-chat-square-heart', 'bi-chat-square-quote', 'bi-chat-square-text', 'bi-chat-text',
            'bi-check', 'bi-check-circle', 'bi-check-lg', 'bi-check-square', 'bi-chevron-bar-contract', 'bi-chevron-bar-down',
            'bi-chevron-bar-expand', 'bi-chevron-bar-left', 'bi-chevron-bar-right', 'bi-chevron-bar-up', 'bi-chevron-compact-down',
            'bi-chevron-compact-left', 'bi-chevron-compact-right', 'bi-chevron-compact-up', 'bi-chevron-contract', 'bi-chevron-double-down',
            'bi-chevron-double-left', 'bi-chevron-double-right', 'bi-chevron-double-up', 'bi-chevron-down', 'bi-chevron-expand',
            'bi-chevron-left', 'bi-chevron-right', 'bi-chevron-up', 'bi-circle', 'bi-circle-fill', 'bi-circle-half', 'bi-clipboard',
            'bi-clipboard-check', 'bi-clipboard-data', 'bi-clipboard-minus', 'bi-clipboard-plus', 'bi-clipboard-x', 'bi-clock',
            'bi-clock-fill', 'bi-clock-history', 'bi-cloud', 'bi-cloud-arrow-down', 'bi-cloud-arrow-up', 'bi-cloud-check',
            'bi-cloud-download', 'bi-cloud-fill', 'bi-cloud-fog', 'bi-cloud-fog2', 'bi-cloud-hail', 'bi-cloud-haze', 'bi-cloud-haze2',
            'bi-cloud-lightning', 'bi-cloud-lightning-rain', 'bi-cloud-minus', 'bi-cloud-moon', 'bi-cloud-plus', 'bi-cloud-rain',
            'bi-cloud-rain-heavy', 'bi-clouds', 'bi-cloud-slash', 'bi-cloud-sleet', 'bi-cloud-snow', 'bi-cloud-sun', 'bi-cloud-upload',
            'bi-code', 'bi-code-slash', 'bi-coin', 'bi-collection', 'bi-collection-fill', 'bi-collection-play', 'bi-columns',
            'bi-columns-gap', 'bi-command', 'bi-compass', 'bi-cone', 'bi-cone-striped', 'bi-controller', 'bi-cpu', 'bi-credit-card',
            'bi-credit-card-2-back', 'bi-credit-card-2-front', 'bi-crop', 'bi-cup', 'bi-cup-fill', 'bi-cup-straw', 'bi-currency-bitcoin',
            'bi-currency-dollar', 'bi-currency-euro', 'bi-currency-exchange', 'bi-currency-pound', 'bi-currency-yen', 'bi-cursor',
            'bi-database', 'bi-device-hdd', 'bi-device-ssd', 'bi-diagram-2', 'bi-diagram-3', 'bi-diamond', 'bi-diamond-fill',
            'bi-diamond-half', 'bi-dice-1', 'bi-dice-2', 'bi-dice-3', 'bi-dice-4', 'bi-dice-5', 'bi-dice-6', 'bi-disc',
            'bi-discord', 'bi-display', 'bi-displayport', 'bi-distribute-horizontal', 'bi-distribute-vertical', 'bi-door-closed',
            'bi-door-open', 'bi-dot', 'bi-download', 'bi-dpad', 'bi-dribbble', 'bi-droplet', 'bi-droplet-fill', 'bi-ear',
            'bi-earbuds', 'bi-easel', 'bi-easel2', 'bi-easel3', 'bi-egg', 'bi-egg-fried', 'bi-eject', 'bi-emoji-angry',
            'bi-emoji-dizzy', 'bi-emoji-expressionless', 'bi-emoji-frown', 'bi-emoji-heart-eyes', 'bi-emoji-laughing',
            'bi-emoji-neutral', 'bi-emoji-smile', 'bi-emoji-smile-upside-down', 'bi-emoji-sunglasses', 'bi-emoji-wink',
            'bi-envelope', 'bi-envelope-check', 'bi-envelope-dash', 'bi-envelope-exclamation', 'bi-envelope-fill',
            'bi-envelope-open', 'bi-envelope-open-fill', 'bi-envelope-plus', 'bi-envelope-slash', 'bi-envelope-x',
            'bi-eraser', 'bi-ethernet', 'bi-exclamation', 'bi-exclamation-circle', 'bi-exclamation-diamond',
            'bi-exclamation-lg', 'bi-exclamation-octagon', 'bi-exclamation-square', 'bi-exclamation-triangle',
            'bi-exclude', 'bi-eye', 'bi-eye-fill', 'bi-eye-slash', 'bi-eye-slash-fill', 'bi-eyedropper', 'bi-eyeglasses',
            'bi-facebook', 'bi-fan', 'bi-file', 'bi-file-arrow-down', 'bi-file-arrow-up', 'bi-file-bar-graph',
            'bi-file-binary', 'bi-file-break', 'bi-file-check', 'bi-file-code', 'bi-file-diff', 'bi-file-earmark',
            'bi-file-earmark-arrow-down', 'bi-file-earmark-arrow-up', 'bi-file-earmark-bar-graph', 'bi-file-earmark-binary',
            'bi-file-earmark-break', 'bi-file-earmark-check', 'bi-file-earmark-code', 'bi-file-earmark-diff',
            'bi-file-earmark-easel', 'bi-file-earmark-excel', 'bi-file-earmark-font', 'bi-file-earmark-image',
            'bi-file-earmark-lock', 'bi-file-earmark-lock2', 'bi-file-earmark-medical', 'bi-file-earmark-minus',
            'bi-file-earmark-music', 'bi-file-earmark-pdf', 'bi-file-earmark-person', 'bi-file-earmark-play',
            'bi-file-earmark-plus', 'bi-file-earmark-post', 'bi-file-earmark-ppt', 'bi-file-earmark-ruled',
            'bi-file-earmark-slides', 'bi-file-earmark-spreadsheet', 'bi-file-earmark-text', 'bi-file-earmark-word',
            'bi-file-earmark-x', 'bi-file-earmark-zip', 'bi-file-easel', 'bi-file-excel', 'bi-file-font', 'bi-file-image',
            'bi-file-lock', 'bi-file-lock2', 'bi-file-medical', 'bi-file-minus', 'bi-file-music', 'bi-file-pdf',
            'bi-file-person', 'bi-file-play', 'bi-file-plus', 'bi-file-post', 'bi-file-ppt', 'bi-file-ruled',
            'bi-file-slides', 'bi-file-spreadsheet', 'bi-file-text', 'bi-file-word', 'bi-file-x', 'bi-file-zip',
            'bi-files', 'bi-files-alt', 'bi-film', 'bi-filter', 'bi-filter-circle', 'bi-filter-left', 'bi-filter-right',
            'bi-fingerprint', 'bi-flag', 'bi-flag-fill', 'bi-flower1', 'bi-flower2', 'bi-flower3', 'bi-folder',
            'bi-folder-check', 'bi-folder-fill', 'bi-folder-minus', 'bi-folder-plus', 'bi-folder-symlink', 'bi-folder-x',
            'bi-fonts', 'bi-forward', 'bi-front', 'bi-fullscreen', 'bi-fullscreen-exit', 'bi-funnel', 'bi-funnel-fill',
            'bi-gear', 'bi-gear-fill', 'bi-gear-wide', 'bi-gem', 'bi-gift', 'bi-gift-fill', 'bi-git', 'bi-github',
            'bi-globe', 'bi-globe2', 'bi-google', 'bi-gpu-card', 'bi-grid', 'bi-grid-1x2', 'bi-grid-3x2', 'bi-grid-3x3',
            'bi-grip-horizontal', 'bi-grip-vertical', 'bi-hammer', 'bi-hand-index', 'bi-hand-index-thumb', 'bi-hand-thumbs-down',
            'bi-hand-thumbs-up', 'bi-handbag', 'bi-hash', 'bi-hdd', 'bi-hdd-fill', 'bi-hdd-network', 'bi-hdd-rack',
            'bi-hdd-stack', 'bi-headphones', 'bi-headset', 'bi-heart', 'bi-heart-fill', 'bi-heart-half', 'bi-heart-pulse',
            'bi-hearts', 'bi-hexagon', 'bi-hexagon-fill', 'bi-hexagon-half', 'bi-hospital', 'bi-hourglass', 'bi-hourglass-bottom',
            'bi-hourglass-split', 'bi-hourglass-top', 'bi-house', 'bi-house-door', 'bi-house-fill', 'bi-hr', 'bi-hurricane',
            'bi-image', 'bi-image-alt', 'bi-image-fill', 'bi-images', 'bi-inbox', 'bi-inbox-fill', 'bi-infinity',
            'bi-info', 'bi-info-circle', 'bi-info-lg', 'bi-info-square', 'bi-input-cursor', 'bi-input-cursor-text',
            'bi-instagram', 'bi-intersect', 'bi-journal', 'bi-journal-album', 'bi-journal-arrow-down', 'bi-journal-arrow-up',
            'bi-journal-bookmark', 'bi-journal-check', 'bi-journal-code', 'bi-journal-medical', 'bi-journal-minus',
            'bi-journal-plus', 'bi-journal-richtext', 'bi-journal-text', 'bi-journal-x', 'bi-justify', 'bi-justify-left',
            'bi-justify-right', 'bi-kanban', 'bi-key', 'bi-keyboard', 'bi-ladder', 'bi-lamp', 'bi-laptop', 'bi-layers',
            'bi-layers-fill', 'bi-layers-half', 'bi-layout-sidebar', 'bi-layout-sidebar-inset', 'bi-layout-sidebar-inset-reverse',
            'bi-layout-sidebar-reverse', 'bi-layout-split', 'bi-layout-text-sidebar', 'bi-layout-text-sidebar-reverse',
            'bi-layout-text-window', 'bi-layout-text-window-reverse', 'bi-layout-three-columns', 'bi-layout-wtf',
            'bi-life-preserver', 'bi-lightbulb', 'bi-lightbulb-off', 'bi-lightning', 'bi-lightning-charge', 'bi-link',
            'bi-link-45deg', 'bi-linkedin', 'bi-list', 'bi-list-check', 'bi-list-nested', 'bi-list-ol', 'bi-list-stars',
            'bi-list-task', 'bi-list-ul', 'bi-lock', 'bi-lock-fill', 'bi-magic', 'bi-mailbox', 'bi-mailbox2', 'bi-map',
            'bi-markdown', 'bi-mask', 'bi-mastodon', 'bi-medium', 'bi-megaphone', 'bi-memory', 'bi-menu-app', 'bi-menu-button',
            'bi-menu-button-wide', 'bi-menu-down', 'bi-menu-up', 'bi-messenger', 'bi-meta', 'bi-mic', 'bi-mic-fill', 'bi-mic-mute',
            'bi-microsoft', 'bi-minecart', 'bi-minecart-loaded', 'bi-modem', 'bi-moisture', 'bi-moon', 'bi-moon-fill',
            'bi-moon-stars', 'bi-moon-stars-fill', 'bi-mortarboard', 'bi-motherboard', 'bi-mouse', 'bi-mouse2', 'bi-mouse3',
            'bi-music-note', 'bi-music-note-beamed', 'bi-music-note-list', 'bi-music-player', 'bi-newspaper', 'bi-node-minus',
            'bi-node-plus', 'bi-nut', 'bi-nut-fill', 'bi-octagon', 'bi-octagon-fill', 'bi-octagon-half', 'bi-option', 'bi-outlet',
            'bi-paint-bucket', 'bi-palette', 'bi-palette2', 'bi-paperclip', 'bi-paragraph', 'bi-patch-check', 'bi-patch-exclamation',
            'bi-patch-minus', 'bi-patch-plus', 'bi-patch-question', 'bi-pause', 'bi-pause-btn', 'bi-pause-circle', 'bi-pause-fill',
            'bi-paypal', 'bi-pc', 'bi-pc-display', 'bi-pc-horizontal', 'bi-pc-mouse', 'bi-peace', 'bi-pen', 'bi-pencil',
            'bi-pencil-square', 'bi-pentagon', 'bi-pentagon-half', 'bi-people', 'bi-people-fill', 'bi-percent', 'bi-person',
            'bi-person-badge', 'bi-person-bounding-box', 'bi-person-check', 'bi-person-circle', 'bi-person-dash', 'bi-person-fill',
            'bi-person-lines-fill', 'bi-person-plus', 'bi-person-square', 'bi-person-video', 'bi-person-video2', 'bi-person-video3',
            'bi-person-workspace', 'bi-person-x', 'bi-phone', 'bi-phone-fill', 'bi-phone-flip', 'bi-phone-landscape', 'bi-phone-vibrate',
            'bi-pie-chart', 'bi-pin', 'bi-pin-angle', 'bi-pin-angle-fill', 'bi-pin-fill', 'bi-pin-map', 'bi-pin-map-fill', 'bi-pinterest',
            'bi-pip', 'bi-play', 'bi-play-btn', 'bi-play-circle', 'bi-play-fill', 'bi-playstation', 'bi-plug', 'bi-plus', 'bi-plus-circle',
            'bi-plus-lg', 'bi-plus-square', 'bi-postage', 'bi-postage-fill', 'bi-postage-heart', 'bi-postcard', 'bi-postcard-fill',
            'bi-postcard-heart', 'bi-power', 'bi-printer', 'bi-printer-fill', 'bi-projector', 'bi-puzzle', 'bi-puzzle-fill', 'bi-qr-code',
            'bi-question', 'bi-question-circle', 'bi-question-diamond', 'bi-question-lg', 'bi-question-octagon', 'bi-question-square',
            'bi-quote', 'bi-radioactive', 'bi-receipt', 'bi-receipt-cutoff', 'bi-reception-0', 'bi-reception-1', 'bi-reception-2',
            'bi-reception-3', 'bi-reception-4', 'bi-record', 'bi-record-btn', 'bi-record-circle', 'bi-record-fill', 'bi-recycle',
            'bi-reddit', 'bi-reply', 'bi-reply-all', 'bi-reply-all-fill', 'bi-reply-fill', 'bi-router', 'bi-rss', 'bi-rulers',
            'bi-safe', 'bi-safe-fill', 'bi-safe2', 'bi-safe2-fill', 'bi-save', 'bi-save-fill', 'bi-save2', 'bi-save2-fill', 'bi-scissors',
            'bi-scooter', 'bi-screwdriver', 'bi-sd-card', 'bi-sd-card-fill', 'bi-search', 'bi-search-heart', 'bi-segmented-nav',
            'bi-send', 'bi-send-check', 'bi-send-dash', 'bi-send-exclamation', 'bi-send-fill', 'bi-send-plus', 'bi-send-slash',
            'bi-send-x', 'bi-server', 'bi-share', 'bi-share-fill', 'bi-shield', 'bi-shield-check', 'bi-shield-exclamation',
            'bi-shield-fill', 'bi-shield-fill-check', 'bi-shield-fill-exclamation', 'bi-shield-fill-minus', 'bi-shield-fill-plus',
            'bi-shield-fill-x', 'bi-shield-lock', 'bi-shield-minus', 'bi-shield-plus', 'bi-shield-shaded', 'bi-shield-slash',
            'bi-shield-x', 'bi-shift', 'bi-shift-fill', 'bi-shop', 'bi-shop-window', 'bi-shuffle', 'bi-sign-dead-end', 'bi-sign-do-not-enter',
            'bi-sign-intersection', 'bi-sign-intersection-fill', 'bi-sign-intersection-side', 'bi-sign-intersection-t', 'bi-sign-intersection-t-fill',
            'bi-sign-intersection-y', 'bi-sign-merge-left', 'bi-sign-merge-right', 'bi-sign-no-left-turn', 'bi-sign-no-parking',
            'bi-sign-no-right-turn', 'bi-sign-railroad', 'bi-sign-stop', 'bi-sign-stop-fill', 'bi-sign-stop-lights', 'bi-sign-turn-left',
            'bi-sign-turn-right', 'bi-sign-turn-slight-left', 'bi-sign-turn-slight-right', 'bi-sign-yield', 'bi-signal', 'bi-signpost',
            'bi-signpost-2', 'bi-signpost-fill', 'bi-signpost-split', 'bi-sim', 'bi-sim-fill', 'bi-skip-backward', 'bi-skip-backward-btn',
            'bi-skip-backward-circle', 'bi-skip-backward-fill', 'bi-skip-end', 'bi-skip-end-btn', 'bi-skip-end-circle', 'bi-skip-end-fill',
            'bi-skip-forward', 'bi-skip-forward-btn', 'bi-skip-forward-circle', 'bi-skip-forward-fill', 'bi-skip-start', 'bi-skip-start-btn',
            'bi-skip-start-circle', 'bi-skip-start-fill', 'bi-skype', 'bi-slack', 'bi-slash', 'bi-slash-circle', 'bi-slash-lg', 'bi-slash-square',
            'bi-sliders', 'bi-sliders2', 'bi-sliders2-vertical', 'bi-smartwatch', 'bi-snapchat', 'bi-snow', 'bi-snow2', 'bi-snow3',
            'bi-sort-alpha-down', 'bi-sort-alpha-down-alt', 'bi-sort-alpha-up', 'bi-sort-alpha-up-alt', 'bi-sort-down', 'bi-sort-down-alt',
            'bi-sort-numeric-down', 'bi-sort-numeric-down-alt', 'bi-sort-numeric-up', 'bi-sort-numeric-up-alt', 'bi-sort-up', 'bi-sort-up-alt',
            'bi-soundwave', 'bi-speaker', 'bi-speaker-fill', 'bi-speedometer', 'bi-speedometer2', 'bi-spellcheck', 'bi-spotify', 'bi-square',
            'bi-square-fill', 'bi-square-half', 'bi-stack', 'bi-stack-overflow', 'bi-star', 'bi-star-fill', 'bi-star-half', 'bi-stars',
            'bi-steam', 'bi-stickies', 'bi-stickies-fill', 'bi-sticky', 'bi-sticky-fill', 'bi-stop', 'bi-stop-btn', 'bi-stop-circle',
            'bi-stop-fill', 'bi-stoplights', 'bi-stopwatch', 'bi-stopwatch-fill', 'bi-strava', 'bi-subtract', 'bi-suit-club', 'bi-suit-club-fill',
            'bi-suit-diamond', 'bi-suit-diamond-fill', 'bi-suit-heart', 'bi-suit-heart-fill', 'bi-suit-spade', 'bi-suit-spade-fill',
            'bi-sun', 'bi-sun-fill', 'bi-sunglasses', 'bi-sunrise', 'bi-sunrise-fill', 'bi-sunset', 'bi-sunset-fill', 'bi-symmetry-horizontal',
            'bi-symmetry-vertical', 'bi-table', 'bi-tablet', 'bi-tablet-fill', 'bi-tablet-landscape', 'bi-tablet-landscape-fill', 'bi-tag',
            'bi-tag-fill', 'bi-tags', 'bi-tags-fill', 'bi-telegram', 'bi-telephone', 'bi-telephone-fill', 'bi-telephone-forward',
            'bi-telephone-forward-fill', 'bi-telephone-inbound', 'bi-telephone-inbound-fill', 'bi-telephone-minus', 'bi-telephone-minus-fill',
            'bi-telephone-outbound', 'bi-telephone-outbound-fill', 'bi-telephone-plus', 'bi-telephone-plus-fill', 'bi-telephone-x',
            'bi-telephone-x-fill', 'bi-terminal', 'bi-terminal-fill', 'bi-text-center', 'bi-text-indent-left', 'bi-text-indent-right',
            'bi-text-left', 'bi-text-paragraph', 'bi-text-right', 'bi-textarea', 'bi-textarea-resize', 'bi-textarea-t', 'bi-thermometer',
            'bi-thermometer-half', 'bi-thermometer-high', 'bi-thermometer-low', 'bi-thermometer-snow', 'bi-thermometer-sun',
            'bi-three-dots', 'bi-three-dots-vertical', 'bi-thunderbolt', 'bi-thunderbolt-fill', 'bi-ticket', 'bi-ticket-detailed',
            'bi-ticket-detailed-fill', 'bi-ticket-fill', 'bi-ticket-perforated', 'bi-ticket-perforated-fill', 'bi-tiktok', 'bi-toggle-off',
            'bi-toggle-on', 'bi-toggle2-off', 'bi-toggle2-on', 'bi-toggles', 'bi-toggles2', 'bi-tools', 'bi-tornado', 'bi-train-freight-front',
            'bi-train-front', 'bi-train-lightrail-front', 'bi-translate', 'bi-trash', 'bi-trash-fill', 'bi-trash2', 'bi-trash2-fill',
            'bi-trash3', 'bi-trash3-fill', 'bi-tree', 'bi-tree-fill', 'bi-triangle', 'bi-triangle-fill', 'bi-triangle-half', 'bi-trophy',
            'bi-trophy-fill', 'bi-tropical-storm', 'bi-truck', 'bi-truck-flatbed', 'bi-truck-front', 'bi-tsunami', 'bi-tv', 'bi-tv-fill',
            'bi-twitch', 'bi-twitter', 'bi-type', 'bi-type-bold', 'bi-type-h1', 'bi-type-h2', 'bi-type-h3', 'bi-type-italic', 'bi-type-strikethrough',
            'bi-type-underline', 'bi-ui-checks', 'bi-ui-checks-grid', 'bi-ui-radios', 'bi-ui-radios-grid', 'bi-umbrella', 'bi-umbrella-fill',
            'bi-union', 'bi-unity', 'bi-unlock', 'bi-unlock-fill', 'bi-upc', 'bi-upc-scan', 'bi-upload', 'bi-usb', 'bi-usb-c', 'bi-usb-drive',
            'bi-usb-drive-fill', 'bi-usb-fill', 'bi-usb-micro', 'bi-usb-micro-fill', 'bi-usb-mini', 'bi-usb-mini-fill', 'bi-usb-plug',
            'bi-usb-plug-fill', 'bi-usb-symbol', 'bi-valentine', 'bi-valentine2', 'bi-vector-pen', 'bi-view-list', 'bi-view-stacked',
            'bi-vimeo', 'bi-vinyl', 'bi-vinyl-fill', 'bi-virus', 'bi-virus2', 'bi-voicemail', 'bi-volume-down', 'bi-volume-down-fill',
            'bi-volume-mute', 'bi-volume-mute-fill', 'bi-volume-off', 'bi-volume-off-fill', 'bi-volume-up', 'bi-volume-up-fill',
            'bi-vr', 'bi-wallet', 'bi-wallet-fill', 'bi-wallet2', 'bi-watch', 'bi-water', 'bi-webcam', 'bi-webcam-fill', 'bi-whatsapp',
            'bi-wifi', 'bi-wifi-1', 'bi-wifi-2', 'bi-wifi-off', 'bi-wikipedia', 'bi-wind', 'bi-window', 'bi-window-dash', 'bi-window-desktop',
            'bi-window-dock', 'bi-window-fullscreen', 'bi-window-plus', 'bi-windows', 'bi-window-sidebar', 'bi-window-split', 'bi-window-stack',
            'bi-window-x', 'bi-windows', 'bi-wordpress', 'bi-wrench', 'bi-wrench-adjustable', 'bi-wrench-adjustable-circle',
            'bi-wrench-adjustable-circle-fill', 'bi-x', 'bi-x-circle', 'bi-x-diamond', 'bi-x-diamond-fill', 'bi-x-lg', 'bi-x-octagon',
            'bi-x-octagon-fill', 'bi-x-square', 'bi-xbox', 'bi-yin-yang', 'bi-youtube', 'bi-zoom-in', 'bi-zoom-out'
        ];
        
        // Categorias
        const categories = {
            'arrows': ['arrow', 'chevron', 'caret', 'back', 'forward', 'contract', 'expand'],
            'media': ['play', 'pause', 'stop', 'volume', 'mic', 'camera', 'image', 'video', 'music', 'record', 'film'],
            'communication': ['chat', 'envelope', 'bell', 'telephone', 'megaphone', 'mail', 'send', 'post', 'rss', 'signal'],
            'devices': ['phone', 'tablet', 'laptop', 'display', 'cpu', 'gpu', 'keyboard', 'mouse', 'printer', 'server', 'router', 'watch'],
            'files': ['file', 'folder', 'document', 'image', 'pdf', 'word', 'excel', 'ppt', 'archive', 'save', 'trash', 'clipboard'],
            'shapes': ['circle', 'square', 'triangle', 'diamond', 'star', 'heart', 'bookmark', 'hexagon', 'pentagon', 'octagon', 'oval']
        };
        
        // Função para renderizar ícones
        function renderIcons(filter = 'all', searchTerm = '') {
            const container = document.getElementById('icons-container');
            container.innerHTML = '';
            
            let filteredIcons = icons;
            
            // Aplicar filtro de categoria se não for "all"
            if (filter !== 'all') {
                filteredIcons = icons.filter(icon => {
                    return categories[filter].some(cat => icon.includes(cat));
                });
            }
            
            // Aplicar termo de pesquisa
            if (searchTerm) {
                searchTerm = searchTerm.toLowerCase();
                filteredIcons = filteredIcons.filter(icon => 
                    icon.toLowerCase().includes(searchTerm)
                );
            }
            
            // Atualizar contagem
            document.getElementById('icon-count').textContent = filteredIcons.length;
            document.getElementById('footer-icon-count').textContent = filteredIcons.length;
            
            // Mostrar mensagem se não houver resultados
            const noResults = document.getElementById('no-results');
            if (filteredIcons.length === 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
                
                // Renderizar ícones
                filteredIcons.forEach(icon => {
                    const card = document.createElement('div');
                    card.className = 'icon-card';
                    card.dataset.icon = icon;
                    card.innerHTML = `
                        <i class="bi ${icon}"></i>
                        <div class="icon-name">${icon}</div>
                    `;
                    container.appendChild(card);
                });
            }
        }
        
        // Inicializar
        document.addEventListener('DOMContentLoaded', () => {
            // Renderizar ícones iniciais
            renderIcons();
            
            // Filtros
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    
                    const searchTerm = document.getElementById('search').value;
                    renderIcons(btn.dataset.filter, searchTerm);
                });
            });
            
            // Pesquisa em tempo real
            document.getElementById('search').addEventListener('input', (e) => {
                const searchTerm = e.target.value;
                const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;
                renderIcons(activeFilter, searchTerm);
            });
            
            // Copiar ao clicar
            document.getElementById('icons-container').addEventListener('click', (e) => {
                const card = e.target.closest('.icon-card');
                if (card) {
                    const iconName = card.dataset.icon;
                    const code = `<i class="bi ${iconName}"></i>`;
                    
                    // Copiar para a área de transferência
                    navigator.clipboard.writeText(code).then(() => {
                        // Atualizar exemplo
                        document.getElementById('example-icon').textContent = iconName;
                        
                        // Mostrar notificação
                        const notification = document.getElementById('copyNotification');
                        notification.classList.add('show');
                        
                        setTimeout(() => {
                            notification.classList.remove('show');
                        }, 2000);
                    });
                }
            });
        });
    </script>
</body>
</html>