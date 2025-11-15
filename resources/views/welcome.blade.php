<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevMenthors Clone</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* --- Reset e Estilos Globais --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            color: #222;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* --- Seção Hero (Topo) --- */
        .hero {
            background-color: #fff;
            height: 100vh;
            min-height: 650px;
            position: relative;
            overflow: hidden;
            color: #222;
            display: flex;
            flex-direction: column;
        }

        /* REINCORPORANDO AS IMAGENS DAS ONDAS */
        .wave {
            position: absolute;
            top: 0;
            z-index: 1; 
            height: 76%; /* Ocupa a altura total do hero */
            width: auto; /* Mantém a proporção da imagem */
            object-fit: contain; /* Ajusta a imagem dentro do contêiner sem cortar */
        }

        .wave-left {
            left: 0;
            top: auto; 
            bottom: 0;
        }

        .wave-right {
            right: 0;
            top: auto;
            bottom: 0; 
        }

        /* --- Navbar (Cabeçalho) --- */
        .navbar {
            position: relative;
            z-index: 2; 
            padding: 30px 0;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: #222;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-link {
            color: #333;
            text-decoration: none;
            margin-left: 24px;
            font-weight: 600;
        }

        .nav-button {
            background-color: transparent;
            color: #2563EB;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 600;
            margin-left: 24px;
            transition: all 0.3s ease;
            border: 2px solid #2563EB;
        }

        .nav-button:hover {
            background-color: #f0f5ff;
        }

        /* --- Conteúdo Hero --- */
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-bottom: 80px;
        }

        .hero-content h1 {
            font-size: 56px;
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 25px;
            color: #222;
        }
        
        .hero-content h1 .text-blue {
            color: #2563EB;
        }

        .hero-content p {
            font-size: 18px;
            max-width: 600px;
            margin-bottom: 35px;
            line-height: 1.7;
            color: #555;
        }

        .cta-button {
            background-color: #2563EB;
            color: #ffffff;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
        }

        .cta-button:hover {
            background-color: #1D4ED8;
        }

        /* --- Seção de Trilhas --- */
        .tracks-section {
            padding: 80px 0;
        }

        .tracks-section h2 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 15px;
        }

        .tracks-section h2 span {
            color: #2563EB; 
        }

        .tracks-section .section-subtitle {
            text-align: center;
            font-size: 16px;
            color: #666;
            margin-bottom: 50px;
        }

        .tracks-content {
            display: flex;
            align-items: flex-start;
            gap: 40px;
        }

        .tracks-image {
            flex: 1.2;
        }

        .tracks-image .placeholder-image { 
            width: 100%;
            height: 400px;
            background: #e0e0e0;
            border-radius: 8px;
            display:flex;
            align-items:center;
            justify-content:center;
            color: #888;
            font-family: sans-serif;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .tracks-list {
            flex: 1;
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 24px;
        }

        .track-item {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .track-item:last-child {
            margin-bottom: 0;
        }

        .track-icon {
            width: 50px;
            height: 50px;
            flex-shrink: 0; 
        }
        .track-icon .placeholder-icon {
            width: 100%;
            height: 100%;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .placeholder-icon img {
            width: 35px;
            height: 35px;
            object-fit: contain;
        }
        .track-item:nth-child(1) .placeholder-icon {
            background-color: #fde2e2;
        }

        .track-item:nth-child(2) .placeholder-icon {
            background-color: #e2eafc;
        }

        .track-item:nth-child(3) .placeholder-icon {
            background-color: #e2fcec;
        }

        .track-info h3 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #333;
        }

        .track-info p {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }

        /* --- Seções de Conteúdo (O que é / Como funciona) --- */
        .content-section {
            padding: 60px 0;
        }

        .content-split {
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .content-split.reverse {
            flex-direction: row-reverse;
        }

        .text-content {
            flex: 1;
        }

        .text-content h2 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #000;
        }

        .text-content p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }

        .image-placeholder {
            flex: 1;
            height: 300px;
            background-color: #e9ecef;
            border-radius: 8px;
            display:flex;
            align-items:center;
            justify-content:center;
            color: #888;
            font-family: sans-serif;
        }
        
        /* ----------------------------------
         NOVOS ESTILOS (FEEDBACKS)
        ----------------------------------
        */
        .feedbacks-section {
            padding: 80px 0;
            background-color: #f8f9fa; /* Fundo cinza claro */
        }

        .section-title-left {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 40px;
            text-align: left;
        }

        .feedbacks-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 colunas */
            gap: 30px;
        }

        .feedback-card {
            background-color: #ffffff;
            padding: 24px;
            border-radius: 8px;
            /* Sombra suave como no design */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); 
        }

        .feedback-author {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .feedback-author img {
            width: 50px;
            height: 50px;
            border-radius: 50%; /* Avatar circular */
            object-fit: cover;
        }

        .feedback-author h3 {
            font-size: 18px;
            font-weight: 700;
        }

        .feedback-card p {
            font-size: 14px;
            line-height: 1.6;
            color: #555;
        }
        
        /* ----------------------------------
         NOVOS ESTILOS (PARCEIROS)
        ----------------------------------
        */
        .partners-section {
            padding: 80px 0;
        }

        .section-title-center {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 50px;
            text-align: center;
        }

        .partners-logos {
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap; /* Para telas menores */
            gap: 40px;
        }

        .partners-logos img {
            max-height: 60px; /* Controla a altura dos logos */
            width: auto;
            object-fit: contain;
            filter: grayscale(100%); /* Logos em cinza */
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .partners-logos img:hover {
            filter: grayscale(0%);
            opacity: 1;
        }
        
        /* ----------------------------------
         NOVOS ESTILOS (FAQ)
        ----------------------------------
        */
        .faq-section {
            padding: 80px 0;
            background-color: #f8f9fa; /* Fundo cinza claro */
        }

        .faq-header {
            margin-bottom: 40px;
            text-align: left;
        }

        .faq-header h2 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .faq-header h3 {
            font-size: 20px;
            font-weight: 600;
            color: #2563EB; /* Subtítulo azul */
        }

        .faq-list {
            max-width: 900px;
        }

        .faq-item {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 10px;
            border-radius: 8px;
            overflow: hidden; /* Para o border-radius funcionar */
        }

        /* O <summary> é a parte clicável do <details> */
        .faq-item summary {
            padding: 20px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            list-style: none; /* Remove a setinha padrão */
            position: relative;
        }

        .faq-item summary::-webkit-details-marker {
            display: none; /* Remove a setinha (Chrome) */
        }

        /* Adiciona um '+' customizado */
        .faq-item summary::after {
            content: '+';
            position: absolute;
            right: 20px;
            font-size: 20px;
            color: #2563EB;
            transition: transform 0.2s ease;
        }

        /* Quando o item está aberto, gira o '+' para 'x' ou '−' */
        .faq-item[open] summary::after {
            content: '−'; /* Ou '×' */
        }

        /* O conteúdo que aparece ao clicar */
        .faq-item .faq-content {
            padding: 0 20px 20px 20px;
            font-size: 15px;
            line-height: 1.6;
            color: #555;
        }

        /* ----------------------------------
         NOVOS ESTILOS (RODAPÉ)
        ----------------------------------
        */
        .main-footer {
            background-color: #fff; /* Fundo escuro do rodapé */
            color: #222;
            padding-top: 120px; /* Espaço para as ondas */
            position: relative;
            overflow: hidden;
            text-align: left;
        }

        .footer-wave {
            position: absolute;
            top: 0;
            height: 150px; /* Altura da imagem da onda */
            width: auto;
            object-fit: contain;
            z-index: 0; /* Fica por baixo do conteúdo */
        }

        .footer-wave-left {
            left: 0;
            transform: translateY(-50%); /* Ajuste para posicionar a onda na parte superior */
        }

        .footer-wave-right {
            right: 0;
            transform: translateY(-50%); /* Ajuste para posicionar a onda na parte superior */
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start; /* Alinha os itens ao topo */
            flex-wrap: wrap; /* Permite quebrar linha em telas menores */
            padding-bottom: 60px;
            position: relative; /* Para z-index */
            z-index: 1; /* Garante que o conteúdo fique acima das ondas */
        }

        .footer-col {
            flex: 1;
            min-width: 180px; /* Garante que as colunas não fiquem muito pequenas */
            margin-bottom: 30px; /* Espaçamento entre colunas em telas menores */
        }

        .footer-logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 20px;
        }

        .footer-col h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #222;
        }

        .footer-col p,
        .footer-col ul li {
            font-size: 15px;
            color: #222;
            line-height: 1.6;
        }

        .footer-col ul {
            list-style: none;
            padding: 0;
        }

        .footer-col ul li a {
            color: #222;
            text-decoration: none;
            transition: color 0.3s ease;
            display: block;
            margin-bottom: 10px;
        }

        .footer-col ul li a:hover {
            color: #2563EB; /* Cor de destaque ao passar o mouse */
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .social-icon-placeholder {
            width: 40px;
            height: 40px;
            background-color: #555; /* Cor de fundo para o placeholder */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .social-icon-placeholder:hover {
            background-color: #2563EB; /* Cor de destaque ao passar o mouse */
        }

        .footer-bottom {
            background-color: #1a1a1a; /* Fundo mais escuro para o copyright */
            padding: 20px 0;
            text-align: center;
            font-size: 13px;
            color: #888;
        }

        /* --- Media Queries (Responsivo para o Rodapé) --- */
        @media (max-width: 768px) {
            .main-footer {
                padding-top: 80px; /* Menos espaço para ondas no mobile */
                text-align: center;
            }

            .footer-wave {
                height: 100px; /* Ondas menores no mobile */
                transform: translateY(-30%);
            }

            .footer-content {
                flex-direction: column; /* Empilha as colunas */
                align-items: center;
                padding-bottom: 40px;
            }

            .footer-col {
                min-width: unset; /* Remove min-width */
                width: 100%; /* Ocupa largura total */
                margin-bottom: 30px;
            }
            .footer-col:first-child, /* Coluna do logo */
            .footer-col:nth-child(2) { /* Coluna de contato */
                text-align: center;
            }

            .footer-col ul {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .social-icons {
                justify-content: center; /* Centraliza ícones sociais */
            }
        }

        @media (max-width: 480px) {
            .main-footer {
                padding-top: 60px;
            }
            .footer-wave {
                height: 80px;
            }
            .footer-logo {
                max-width: 120px;
            }
            .footer-col h4 {
                font-size: 16px;
                margin-bottom: 15px;
            }
            .footer-col p,
            .footer-col ul li,
            .social-icon-placeholder {
                font-size: 14px;
            }
            .social-icon-placeholder {
                width: 35px;
                height: 35px;
            }
        }


        /* ---------------------------------- */
        /* --- Media Queries (Responsivo) --- */
        /* ---------------------------------- */
        @media (max-width: 992px) { /* Tablets e desktops menores */
            .wave {
                height: 80%;
                transform: translateY(30%);
            }
        }

        @media (max-width: 768px) { /* Tablets na vertical e celulares */
            .hero {
                height: auto; 
                min-height: 70vh; 
                padding-bottom: 60px;
            }

            .wave {
                display: none;
            }

            .navbar .container {
                flex-direction: column;
                gap: 15px;
            }

            .nav-links {
                flex-direction: column; 
                gap: 10px;
            }
            .nav-link, .nav-button {
                margin: 0; 
            }

            .hero-content {
                padding-top: 40px;
                padding-left: 20px;
                padding-right: 20px;
            }

            .hero-content h1 {
                font-size: 38px; 
                line-height: 1.2;
                margin-bottom: 15px;
            }

            .hero-content p {
                font-size: 15px;
                max-width: 90%;
                margin-bottom: 25px;
            }

            .tracks-section {
                padding: 40px 0;
            }
            .tracks-section h2 {
                font-size: 26px;
                margin-bottom: 10px;
            }
            .tracks-section .section-subtitle {
                font-size: 14px;
                margin-bottom: 30px;
            }

            .tracks-content {
                flex-direction: column;
                gap: 30px;
            }

            .tracks-image .placeholder-image {
                height: 250px; 
            }

            .content-section {
                padding: 40px 0;
            }

            .content-split {
                flex-direction: column;
                gap: 30px;
            }

            .content-split.reverse {
                flex-direction: column; 
            }

            .text-content h2 {
                font-size: 28px;
                margin-bottom: 15px;
            }

            .text-content p {
                font-size: 15px;
            }

            .image-placeholder {
                height: 200px;
            }
            
            /* --- NOVOS ESTILOS RESPONSIVOS --- */
            .feedbacks-section,
            .partners-section,
            .faq-section {
                padding: 40px 0;
            }
            .section-title-left,
            .section-title-center,
            .faq-header h2 {
                font-size: 28px;
                margin-bottom: 30px;
            }
            .faq-header h3 {
                font-size: 18px;
            }

            .feedbacks-grid {
                grid-template-columns: 1fr; /* Empilha os feedbacks */
                gap: 20px;
            }
            
            .partners-logos {
                gap: 30px;
            }
            .partners-logos img {
                max-height: 45px; /* Logos menores */
            }

            .faq-item summary {
                padding: 15px;
                font-size: 15px;
            }
            .faq-item .faq-content {
                padding: 0 15px 15px 15px;
                font-size: 14px;
            }
            /* --- FIM DOS NOVOS ESTILOS --- */
        }

        @media (max-width: 480px) { /* Celulares menores */
            .hero-content h1 {
                font-size: 32px;
            }
            .hero-content p {
                font-size: 14px;
            }
            .cta-button {
                padding: 12px 24px;
                font-size: 14px;
            }
            .logo-text {
                font-size: 20px;
            }

            /* --- NOVOS ESTILOS RESPONSIVOS --- */
            .section-title-left,
            .section-title-center,
            .faq-header h2 {
                font-size: 24px;
            }
            .faq-header h3 {
                font-size: 16px;
            }
            .feedback-author img {
                width: 40px;
                height: 40px;
            }
            .feedback-author h3 {
                font-size: 16px;
            }
            .feedback-card p {
                font-size: 13px;
            }
            /* --- FIM DOS NOVOS ESTILOS --- */
        }

    </style>
</head>
<body>

    <section class="hero">
        <img src="{{ asset('img/left.png') }}" alt="Onda decorativa esquerda" class="wave wave-left">
        <img src="{{ asset('img/right.png') }}" alt="Onda decorativa direita" class="wave wave-right">

        <header class="navbar">
            <div class="container">
                <a href="/" class="logo-text">DevMenthors</a>
                <nav class="nav-links">
                    <a href="#" class="nav-link">Entrar</a>
                    <a href="/hackathon" class="nav-button">Hackathon</a>
                </nav>
            </div>
        </header>

        <div class="hero-content">
            <h1>DevMenthors, <br> 
                <span class="text-blue">transformando o futuro</span> <br> 
                <span class="text-blue">uma geração por vez.</span>
            </h1>
            <p>Vá além de código! Junte-se a nós e aprenda, gratuitamente, sobre programação, hard e soft skills, e empreendedorismo. Conte com o apoio de mentores que entendem a sua jornada.</p>
            <a href="#" class="cta-button">Faça parte!</a>
        </div>
    </section>

    <main>

        <section class="tracks-section">
            <div class="container">
                <h2>Inicie sua história na área da tecnologia com <span>DevMenthors</span></h2>
                <p class="section-subtitle">Conheça um pouco de cada uma das trilhas disponíveis.</p>

                <div class="tracks-content">
                    <div class="tracks-image">
                        <div class="placeholder-image">Imagem do Dashboard (560x400)</div>
                    </div>

                    <div class="tracks-list">
                        <div class="track-item">
                            <div class="track-icon">
                                <div class="placeholder-icon"><img src="{{ asset('img/figma.png') }}" alt=""></div>
                            </div>
                            <div class="track-info">
                                <h3>Design</h3>
                                <p>A arte de solucionar problemas e criar experiências memoráveis.</p>
                            </div>
                        </div>

                        <div class="track-item">
                            <div class="track-icon">
                                <div class="placeholder-icon"><img src="{{ asset('img/front.png') }}" alt=""></div>
                            </div>
                            <div class="track-info">
                                <h3>Front-end</h3>
                                <p>Dando forma e fluidez à experiência de quem navega.</p>
                            </div>
                        </div>

                        <div class="track-item">
                            <div class="track-icon">
                                <div class="placeholder-icon"><img src="{{ asset('img/php.png') }}" alt=""></div>
                            </div>
                            <div class="track-info">
                                <h3>Back-end</h3>
                                <p>O cérebro do sistema. Lógica, poder e dados em ação.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-section" style="background-color: #f8f9fa;">
            <div class="container">
                <div class="content-split">
                    <div class="text-content">
                        <h2>O que é o DevMenthors</h2>
                        <p>O DevMenthors nasceu em 2022 para capacitar jovens com habilidades técnicas (hard skills) e interpessoais (soft skills). Nosso foco vai além da tecnologia: ajudamos você a desenvolver liderança, comunicação e trabalho em equipe, preparando-o para os desafios do mercado. Aqui, formamos profissionais completos e prontos para brilhar!</p>
                    </div>
                    <div class="image-placeholder">
                        <p>Placeholder Imagem</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-section">
            <div class="container">
                <div class="content-split reverse">
                    <div class="text-content">
                        <h2>Como o Dev Funciona</h2>
                        <p>No DevMenthors, você aprende fazendo! Com treinamentos em HTML, CSS, JavaScript, PHP e Laravel, jovens desenvolvem projetos reais com o apoio de mentores. Além das habilidades técnicas, também oferecem soft skills como liderança e trabalho em equipe. Quem se destaca vira mentor e ajuda a próxima geração de devs. Junte-se ao ciclo de aprendizado e crescimento!</p>
                    </div>
                    <div class="image-placeholder">
                        <p>Placeholder Imagem</p>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="feedbacks-section">
            <div class="container">
                <h2 class="section-title-left">Feedbacks</h2>
                <div class="feedbacks-grid">
                    <div class="feedback-card">
                        <div class="feedback-author">
                            <img src="{{ asset('img/avatar-enzo.png') }}" alt="Enzo Takaku">
                            <h3>Enzo Takaku</h3>
                        </div>
                        <p>O DevMenthor pra mim foi uma chave que abriu minha mente, eu não queria trabalhar na área de programação, mas decidi entrar pra ver como era e me interessei muito em programar e aprender sempre mais, quando já havia se passado um ano e começamos a dar aulas para outros alunos, vi que o Dev poderia abrir a mente de mais pessoas como eu.</p>
                    </div>
                    <div class="feedback-card">
                        <div class="feedback-author">
                            <img src="{{ asset('img/avatar-marcos.png') }}" alt="Marcos Gabriel">
                            <h3>Marcos Gabriel</h3>
                        </div>
                        <p>Para mim, o Dev foi algo que mudou minha perspectiva de como é a dinâmica de estudos, abrange a programação e aprendizagem que com todas as envolvidos no projeto Devs... Desenvolvi Hard e Soft Skills que hoje fazem parte de quem eu sou e me ajudam a me destacar onde eu vou.</p>
                    </div>
                    <div class="feedback-card">
                        <div class="feedback-author">
                            <img src="{{ asset('img/avatar-victor.png') }}" alt="Victor Hugo">
                            <h3>Victor Hugo</h3>
                        </div>
                        <p>Durante minha trajetória no DevMenthors, tive a oportunidade de aprender e estudar sobre diversas tecnologias, como Docker, Node.js e Flutter, áreas nas quais hoje tenho mais dedicação e familiaridade. Esse processo de evolução constante me levou a ser promovido a mentor, uma posição que me permitiu colaborar com alunos excepcionais.</p>
                    </div>
                    <div class="feedback-card">
                        <div class="feedback-author">
                            <img src="{{ asset('img/avatar-julio.png') }}" alt="Julio Gabriel">
                            <h3>Julio Gabriel</h3>
                        </div>
                        <p>O Dev foi um verdadeiro divisor de águas para mim, contribuindo não apenas no aprendizado, mas também em muitos outros aspectos da minha vida. Hoje, toda a base que tenho em programação foi construída graças ao Dev.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="partners-section">
            <div class="container">
                <h2 class="section-title-center">Nossos Parceiros</h2>
                <div class="partners-logos">
                    <img src="{{ asset('img/logo-unimar.png') }}" alt="Logo Unimar">
                    <img src="{{ asset('img/logo-etec.png') }}" alt="Logo Etec">
                    <img src="{{ asset('img/logo-cps.png') }}" alt="Logo Centro Paula Souza">
                    <img src="{{ asset('img/logo-sebrae.png') }}" alt="Logo Sebrae for Startups">
                </div>
            </div>
        </section>

        <section class="faq-section">
            <div class="container">
                <div class="faq-header">
                    <h2>Dev responde</h2>
                    <h3>Dúvidas Frequentes</h3>
                </div>
                <div class="faq-list">
                    <details class="faq-item">
                        <summary>Como me inscrevo no dev ?</summary>
                        <div class="faq-content">
                            <p>As inscrições abrem periodicamente. Fique de olho em nossas redes sociais e no site oficial para o anúncio das próximas turmas!</p>
                        </div>
                    </details>
                    <details class="faq-item">
                        <summary>Quais os dias de Aula ?</summary>
                        <div class="faq-content">
                            <p>As aulas geralmente ocorrem ao sabados, das 09:00 - 12:00, para que não atrapalhe os estudos por fora.</p>
                        </div>
                    </details>
                    <details class="faq-item">
                        <summary>O DevMenthors é pago ?</summary>
                        <div class="faq-content">
                            <p>Não! O DevMenthors é um projeto totalmente gratuito, focado em levar conhecimento de tecnologia para jovens.</p>
                        </div>
                    </details>
                    <details class="faq-item">
                        <summary>Qual o tempo das Trilhas ?</summary>
                        <div class="faq-content">
                            <p>A duração das trilhas pode variar, mas geralmente são projetadas para serem concluídas em um semestre letivo.</p>
                        </div>
                    </details>
                    <details class="faq-item">
                        <summary>Temos certificados ?</summary>
                        <div class="faq-content">
                            <p>Sim! Ao concluir as trilhas e projetos propostos, os alunos recebem um certificado de participação e conclusão.</p>
                        </div>
                    </details>
                </div>
            </div>
        </section>

    </main>

    <footer class="main-footer">

        <div class="container footer-content">
            <div class="footer-col logo-col">
                <img src="{{ asset('img/logo_rodape.png') }}" alt="Logo DevMenthors" class="footer-logo">
            </div>
            
            <div class="footer-col">
                <h4>Contato</h4>
                <p>contato@devmenthors.com</p>
            </div>
            
            <div class="footer-col">
                <h4>Links</h4>
                <ul>
                    <li><a href="#">Sobre nós</a></li>
                    <li><a href="#">Hackathon</a></li>
                    <li><a href="#">Feedbacks</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h4>Nossas Redes</h4>
                <div class="social-icons">
                    <a href="#" class="social-icon-placeholder"></a>
                    <a href="#" class="social-icon-placeholder"></a>
                    <a href="#" class="social-icon-placeholder"></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2025 DevMenthors. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

</body>
</html>