<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrições Encerradas - DevMenthors</title>

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
            /* Modificado para centralizar o logo quando não há links */
            justify-content: center;
            align-items: center;
        }

        /* Centraliza o logo em telas maiores também */
        @media (min-width: 769px) {
            .navbar .container {
                justify-content: flex-start; /* Ou 'center' se preferir */
            }
        }

        .logo-text {
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .logo-text img {
            height: 90px; /* Defina a altura desejada para o seu logo */
            width: auto;
        }

        /* Removido .nav-links e .nav-button pois não são necessários aqui */

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

        /* Novo estilo para a mensagem de redirecionamento */
        .redirect-message {
            font-size: 1rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
            margin-top: -1.5rem;
        }

        .cta-button {
            background-color: #2563EB;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
        }

        .cta-button:hover {
            background-color: #1D4ED8;
        }

        /* --- ESTILOS RESPONSIVOS (Simplificados do seu CSS) --- */

        /* Tablets e desktops menores */
        @media (max-width: 992px) {
            .wave { /* Onda do Hero */
                height: 80%;
                transform: translateY(30%);
            }
        }

        /* Tablets na vertical e celulares */
        @media (max-width: 768px) {
            .hero {
                height: auto;
                min-height: 100vh; /* Garante que ocupe a tela inteira */
                padding-bottom: 60px;
            }

            .wave { /* Onda do Hero */
                display: none;
            }

            .navbar .container {
                flex-direction: column;
                gap: 15px;
                justify-content: center; /* Centraliza o logo */
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
        }

        /* Celulares menores */
        @media (max-width: 480px) {
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
            .logo-text img {
                height: 60px; /* Altura um pouco menor no mobile */
            }
        }

    </style>
</head>
<body>

    <section class="hero">
        <img src="{{ asset('img/left.png') }}" alt="Onda decorativa esquerda" class="wave wave-left">
        <img src="{{ asset('img/right.png') }}" alt="Onda decorativa direita" class="wave wave-right">

        <header class="navbar">
            <div class="container">
                <a href="/" class="logo-text"><img src="{{ asset('img/parceiros/5.png') }}" alt="DevMenthors Logo"></a>
                <!-- Links de navegação removidos desta página -->
            </div>
        </header>

        <div class="hero-content">
            <h1>
                <span class="text-blue">Inscrições</span> Encerradas
            </h1>
            <p>No momento, as inscrições não estão abertas. Fique de olho em nossas redes sociais para o anúncio de futuros eventos!</p>

            <p class="redirect-message">Você será redirecionado para a página principal em 10 segundos...</p>

            <a href="/" class="cta-button">Voltar para a Home</a>
        </div>
    </section>

    <!-- SCRIPT DE REDIRECIONAMENTO -->
    <script>
        setTimeout(function() {
            // Redireciona o usuário para a raiz do site (/)
            window.location.href = '/';
        }, 10000); // 5000 milissegundos = 5 segundos
    </script>

</body>
</html>
