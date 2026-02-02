<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrições Indisponíveis - DevMenthors</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/logos/1.png') }}">


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

        /* ONDAS */
        .wave {
            position: absolute;
            top: 0;
            z-index: 1;
            height: 76%;
            width: auto;
            object-fit: contain;
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
            justify-content: center;
            align-items: center;
        }

        @media (min-width: 769px) {
            .navbar .container {
                justify-content: flex-start;
            }
        }

        .logo-text {
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .logo-text img {
            height: 90px;
            width: auto;
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
            max-width: 700px; /* Aumentado levemente para caber o novo texto */
            margin-bottom: 35px;
            line-height: 1.7;
            color: #555;
        }

        /* --- NOVOS ESTILOS DE BOTÕES --- */
        .buttons-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .cta-button {
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-block;
        }

        /* Botão Principal (HackHealth) - Azul Destacado */
        .btn-primary {
            background-color: #2563EB;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
            border: 1px solid transparent;
        }

        .btn-primary:hover {
            background-color: #1D4ED8;
            transform: translateY(-2px);
        }

        /* Botão Secundário (Home) - Branco/Discreto */
        .btn-secondary {
            background-color: transparent;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }

        .btn-secondary:hover {
            background-color: #f9fafb;
            color: #111827;
            border-color: #d1d5db;
        }

        /* --- ESTILOS RESPONSIVOS --- */
        @media (max-width: 992px) {
            .wave {
                height: 80%;
                transform: translateY(30%);
            }
        }

        @media (max-width: 768px) {
            .hero {
                height: auto;
                min-height: 100vh;
                padding-bottom: 60px;
            }

            .wave { display: none; }

            .navbar .container {
                flex-direction: column;
                gap: 15px;
                justify-content: center;
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

            .buttons-container {
                flex-direction: column;
                width: 100%;
            }

            .cta-button {
                width: 100%;
                max-width: 300px;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 { font-size: 32px; }
            .hero-content p { font-size: 14px; }
            .logo-text img { height: 60px; }
        }

    </style>
</head>
<body>

    <section class="hero">
        <img src="{{ asset('img/left.png') }}" alt="Onda decorativa esquerda" class="wave wave-left">
        <img src="{{ asset('img/right.png') }}" alt="Onda decorativa direita" class="wave wave-right">

        <header class="navbar">
            <div class="container">
                <a href="/" class="logo-text"><img src="{{ asset('img/logos/2.png') }}" alt="DevMenthors Logo"></a>
            </div>
        </header>

        <div class="hero-content">
            <h1>
                Inscrições <span class="text-blue">indisponíveis</span> no momento
            </h1>

            <p>
                As inscrições para o Volta às Aulas não estão disponíveis no momento, mas aproveite a oportunidade e venha participar do mais novo evento do DevMenthors, o HackHealth.
            </p>

            <div class="buttons-container">
                <a href="/" class="cta-button btn-secondary">Voltar para a Home</a>

                <a href="{{ route('hackathon') }}" class="cta-button btn-primary">Conhecer o HackHealth</a>
            </div>
        </div>
    </section>

    </body>
</html>
