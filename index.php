<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Notícias</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset e configurações gerais */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Estilo do cabeçalho e menu */
        header {
            background-color: #1a365d;
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo i {
            font-size: 2rem;
            color: #4299e1;
        }
        
        .logo h1 {
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        .logo span {
            color: #4299e1;
        }
        
        .date-time {
            font-size: 0.9rem;
            color: #cbd5e0;
        }
        
        /* Menu de navegação */
        nav {
            background-color: #2d3748;
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
        }
        
        .nav-links li {
            position: relative;
        }
        
        .nav-links a {
            display: block;
            padding: 15px 20px;
            color: #e2e8f0;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover {
            background-color: #4a5568;
            color: white;
        }
        
        .nav-links a.active {
            background-color: #4299e1;
            color: white;
        }
        
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 10px;
        }
        
        /* Conteúdo principal */
        main {
            padding: 30px 0;
        }
        
        .page-title {
            font-size: 2rem;
            color: #2d3748;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #4299e1;
        }
        
        /* Layout de notícias */
        .news-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }
        
        .highlight-news {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        
        .highlight-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
        
        .highlight-content {
            padding: 25px;
        }
        
        .highlight-category {
            display: inline-block;
            background-color: #4299e1;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .highlight-title {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: #2d3748;
        }
        
        .highlight-excerpt {
            color: #4a5568;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }
        
        .highlight-meta {
            display: flex;
            justify-content: space-between;
            color: #718096;
            font-size: 0.9rem;
        }
        
        /* Notícias secundárias */
        .secondary-news {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .news-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        
        .news-card:hover {
            transform: translateY(-5px);
        }
        
        .news-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .news-content {
            padding: 20px;
        }
        
        .news-category {
            display: inline-block;
            background-color: #e2e8f0;
            color: #4a5568;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .news-title {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #2d3748;
        }
        
        .news-excerpt {
            color: #718096;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }
        
        .news-meta {
            display: flex;
            justify-content: space-between;
            color: #a0aec0;
            font-size: 0.85rem;
        }
        
        /* Barra lateral */
        .sidebar {
            background-color: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: fit-content;
        }
        
        .sidebar-title {
            font-size: 1.3rem;
            color: #2d3748;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .sidebar-news {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .sidebar-news:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .sidebar-news h3 {
            font-size: 1rem;
            margin-bottom: 8px;
        }
        
        .sidebar-news p {
            font-size: 0.9rem;
            color: #718096;
        }
        
        /* Newsletter */
        .newsletter {
            background-color: #4299e1;
            color: white;
            padding: 25px;
            border-radius: 8px;
            margin-top: 30px;
        }
        
        .newsletter h3 {
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .newsletter p {
            margin-bottom: 20px;
            font-size: 0.95rem;
            opacity: 0.9;
        }
        
        .newsletter-form {
            display: flex;
            gap: 10px;
        }
        
        .newsletter-input {
            flex-grow: 1;
            padding: 12px 15px;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .newsletter-button {
            background-color: #1a365d;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        
        .newsletter-button:hover {
            background-color: #2d3748;
        }
        
        /* Rodapé */
        footer {
            background-color: #1a365d;
            color: white;
            padding: 40px 0 20px;
            margin-top: 50px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .footer-section h3 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #4299e1;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: #cbd5e0;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: #4299e1;
        }
        
        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #2d3748;
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .social-icons a:hover {
            background-color: #4299e1;
        }
        
        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #2d3748;
            color: #a0aec0;
            font-size: 0.9rem;
        }
        
        /* Responsividade */
        @media (max-width: 992px) {
            .news-container {
                grid-template-columns: 1fr;
            }
            
            .secondary-news {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: #2d3748;
                flex-direction: column;
                box-shadow: 0 5px 10px rgba(0,0,0,0.1);
            }
            
            .nav-links.active {
                display: flex;
            }
            
            .menu-toggle {
                display: block;
            }
            
            .header-top {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .date-time {
                align-self: flex-end;
            }
            
            .highlight-image {
                height: 300px;
            }
            
            .highlight-title {
                font-size: 1.5rem;
            }
            
            .newsletter-form {
                flex-direction: column;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .highlight-image {
                height: 250px;
            }
            
            .highlight-title {
                font-size: 1.3rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Cabeçalho e Menu -->
    <header>
        <div class="container">
            <div class="header-top">
                <div class="logo">
                    <i class="fas fa-newspaper"></i>
                    <h1>Portal<span>News</span></h1>
                </div>
                <div class="date-time" id="currentDateTime"></div>
            </div>
        </div>
        
        <nav>
            <div class="container nav-container">
                <ul class="nav-links" id="navLinks">
                    <li><a href="#home" class="active"><i class="fas fa-home"></i> Início</a></li>
                    <li><a href="#politics"><i class="fas fa-landmark"></i> Política</a></li>
                    <li><a href="#economy"><i class="fas fa-chart-line"></i> Economia</a></li>
                    <li><a href="#sports"><i class="fas fa-futbol"></i> Esportes</a></li>
                    <li><a href="#tech"><i class="fas fa-microchip"></i> Tecnologia</a></li>
                    <li><a href="#entertainment"><i class="fas fa-film"></i> Entretenimento</a></li>
                </ul>
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </nav>
    </header>
    
    <!-- Conteúdo Principal -->
    <main class="container">
        <h2 class="page-title">Notícias em Destaque</h2>
        
        <div class="news-container">
            <!-- Coluna Principal -->
            <div class="main-column">
                <!-- Destaque Principal -->
                <article class="highlight-news">
                    <img src="https://images.unsplash.com/photo-1588681664899-f142ff2dc9b1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Reunião política internacional" class="highlight-image">
                    <div class="highlight-content">
                        <span class="highlight-category">Política Internacional</span>
                        <h3 class="highlight-title">Cúpula Global discute acordos climáticos e cooperação econômica</h3>
                        <p class="highlight-excerpt">Líderes mundiais se reúnem em Genebra para discutir novas metas climáticas e estratégias de cooperação econômica pós-pandemia. O encontro busca estabelecer diretrizes para a redução de emissões até 2030.</p>
                        <div class="highlight-meta">
                            <span><i class="far fa-clock"></i> 2 horas atrás</span>
                            <span><i class="far fa-eye"></i> 2.4k visualizações</span>
                        </div>
                    </div>
                </article>
                
                <!-- Notícias Secundárias -->
                <div class="secondary-news">
                    <article class="news-card">
                        <img src="https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Mercado financeiro" class="news-image">
                        <div class="news-content">
                            <span class="news-category">Economia</span>
                            <h4 class="news-title">Bolsa de Valores atinge maior alta do ano após anúncio do governo</h4>
                            <p class="news-excerpt">Índice principal sobe 3,2% impulsionado por setores de tecnologia e energia. Analistas projetam crescimento econômico de 2,5% para o próximo trimestre.</p>
                            <div class="news-meta">
                                <span><i class="far fa-clock"></i> 5 horas atrás</span>
                                <span><i class="far fa-comment"></i> 42 comentários</span>
                            </div>
                        </div>
                    </article>
                    
                    <article class="news-card">
                        <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Jogo de futebol" class="news-image">
                        <div class="news-content">
                            <span class="news-category">Esportes</span>
                            <h4 class="news-title">Time local vence clássico após 10 anos e avança na copa nacional</h4>
                            <p class="news-excerpt">Vitória por 2x1 emociona torcida no estádio lotado. Próximo jogo será contra o líder do campeonato no próximo domingo.</p>
                            <div class="news-meta">
                                <span><i class="far fa-clock"></i> 8 horas atrás</span>
                                <span><i class="far fa-comment"></i> 128 comentários</span>
                            </div>
                        </div>
                    </article>
                    
                    <article class="news-card">
                        <img src="https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Evento de tecnologia" class="news-image">
                        <div class="news-content">
                            <span class="news-category">Tecnologia</span>
                            <h4 class="news-title">Nova geração de processadores promete revolucionar inteligência artificial</h4>
                            <p class="news-excerpt">Fabricante anuncia chips com capacidade 5x maior para tarefas de machine learning. Produto chega ao mercado no próximo semestre.</p>
                            <div class="news-meta">
                                <span><i class="far fa-clock"></i> 1 dia atrás</span>
                                <span><i class="far fa-comment"></i> 76 comentários</span>
                            </div>
                        </div>
                    </article>
                    
                    <article class="news-card">
                        <img src="https://images.unsplash.com/photo-1489599809516-9827b6d1cf13?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Festival de cinema" class="news-image">
                        <div class="news-content">
                            <span class="news-category">Entretenimento</span>
                            <h4 class="news-title">Festival de Cinema anuncia programação com produções de 30 países</h4>
                            <p class="news-excerpt">Evento acontece no mês que vem com mostras competitivas e homenagens. Ingressos começam a ser vendidos a partir de amanhã.</p>
                            <div class="news-meta">
                                <span><i class="far fa-clock"></i> 1 dia atrás</span>
                                <span><i class="far fa-comment"></i> 31 comentários</span>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            
            <!-- Barra Lateral -->
            <aside class="sidebar">
                <h3 class="sidebar-title">Mais Lidas</h3>
                
                <div class="sidebar-news">
                    <h4>Novas leis trabalhistas entram em vigor a partir do próximo mês</h4>
                    <p><i class="far fa-clock"></i> 3 horas atrás</p>
                </div>
                
                <div class="sidebar-news">
                    <h4>Pesquisa revela aumento no uso de aplicativos de saúde mental</h4>
                    <p><i class="far fa-clock"></i> 6 horas atrás</p>
                </div>
                
                <div class="sidebar-news">
                    <h4>Descoberta arqueológica muda entendimento sobre civilização antiga</h4>
                    <p><i class="far fa-clock"></i> 1 dia atrás</p>
                </div>
                
                <div class="sidebar-news">
                    <h4>Previsão do tempo: frente fria chega ao país no fim de semana</h4>
                    <p><i class="far fa-clock"></i> 1 dia atrás</p>
                </div>
                
                <div class="sidebar-news">
                    <h4>Entrevista exclusiva com vencedor do prêmio literário internacional</h4>
                    <p><i class="far fa-clock"></i> 2 dias atrás</p>
                </div>
                
                <!-- Newsletter -->
                <div class="newsletter">
                    <h3>Assine nossa Newsletter</h3>
                    <p>Receba as principais notícias diretamente no seu e-mail.</p>
                    <form class="newsletter-form">
                        <input type="email" class="newsletter-input" placeholder="Seu melhor e-mail" required>
                        <button type="submit" class="newsletter-button">Assinar</button>
                    </form>
                </div>
            </aside>
        </div>
    </main>
    
    <!-- Rodapé -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>PortalNews</h3>
                    <p>O portal de notícias mais confiável e atualizado. Trazendo informação de qualidade 24 horas por dia.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Categorias</h3>
                    <ul class="footer-links">
                        <li><a href="#">Política</a></li>
                        <li><a href="#">Economia</a></li>
                        <li><a href="#">Esportes</a></li>
                        <li><a href="#">Tecnologia</a></li>
                        <li><a href="#">Entretenimento</a></li>
                        <li><a href="#">Saúde</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Links Úteis</h3>
                    <ul class="footer-links">
                        <li><a href="#">Sobre nós</a></li>
                        <li><a href="#">Contato</a></li>
                        <li><a href="#">Política de Privacidade</a></li>
                        <li><a href="#">Termos de Uso</a></li>
                        <li><a href="#">Anuncie</a></li>
                        <li><a href="#">Trabalhe Conosco</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Contato</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> Av. Paulista, 1000 - São Paulo, SP</li>
                        <li><i class="fas fa-phone"></i> (11) 9999-9999</li>
                        <li><i class="fas fa-envelope"></i> contato@portalnews.com</li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 PortalNews. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Menu responsivo
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');
        
        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
        
        // Fechar menu ao clicar em um link (para dispositivos móveis)
        const navItems = document.querySelectorAll('.nav-links a');
        navItems.forEach(item => {
            item.addEventListener('click', () => {
                navLinks.classList.remove('active');
            });
        });
        
        // Atualizar data e hora
        function updateDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            const dateTimeString = now.toLocaleDateString('pt-BR', options);
            document.getElementById('currentDateTime').textContent = dateTimeString;
        }
        
        // Atualizar a cada minuto
        updateDateTime();
        setInterval(updateDateTime, 60000);
        
        // Newsletter form
        const newsletterForm = document.querySelector('.newsletter-form');
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = this.querySelector('.newsletter-input');
            const email = emailInput.value;
            
            if(email) {
                alert(`Obrigado por assinar nossa newsletter! Você receberá as notícias em: ${email}`);
                emailInput.value = '';
            }
        });
        
        // Destaque ao passar o mouse sobre as notícias
        const newsCards = document.querySelectorAll('.news-card');
        newsCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.boxShadow = '0 5px 15px rgba(0,0,0,0.05)';
            });
        });
    </script>
</body>
</html>