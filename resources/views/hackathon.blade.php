@extends('layouts.app')

@section('content')
<div class="container">
    <img src="{{ asset('img/azul.png') }}" alt="" class="img-azul">
    <img src="{{ asset('img/preto.png') }}" alt="" class="img-preto">

    <nav class="navbar">
        <a href="{{ url('/') }}"><img src="{{ asset('img/parceiros/4.png') }}" alt=""></a>
    </nav>

    <div class="vagas">
        {{-- Lógica para exibir contador ou mensagem de esgotado --}}
        <div class="vagas-box {{ $vagasRestantes <= 0 ? 'esgotado' : '' }}">
            @if($vagasRestantes > 0)
                {{ $vagasRestantes }} Vagas disponíveis
            @else
                Vagas Esgotadas!
            @endif
        </div>
    </div>
<div class="main-layout">
    <main class="main">
        <div class="conteudo">
            <div>
                <p class="bem-vindo">Bem vindo ao</p>
                <h1 class="titulo">
                    <span class="azul">HackHealth</span>
                    <span class="cinza">DevMenthors</span>
                </h1>
            </div>

            <div class="texto">
                <p>
                    O <span class="azul negrito">DevMenthors</span>, com o apoio da Universidade de Marília -
                    Unimar e de empresas líderes da cidade, tem a honra de apresentar um evento único: um
                    <span class="azul negrito">HackHealth</span> épico de
                    <span class="azul negrito">30 horas</span>. Mais do que uma competição, é uma imersão
                    total para mentes criativas e apaixonadas por tecnologia.
                </p>

                <p>
                    Serão dois dias intensos, nos dias <span class="azul negrito">29 e 30 de Novembro</span>,
                    onde você vai se juntar a uma equipe de pessoas com a mesma paixão por inovação. O desafio é grande,
                    mas a recompensa é ainda maior: desenvolver uma solução inovadora para resolver um problema real da
                    nossa sociedade.
                </p>

                <p>
                    Você terá a chance de aprender com mentores experientes, fazer networking com
                    <span class="azul negrito">profissionais do mercado</span>, e o mais importante, colocar
                    todo o seu conhecimento em prática.
                </p>

                <p>
                    Prepare-se para viver uma experiência inesquecível, cheia de código, colaboração, e, é claro, muita
                    pizza e café!
                </p>

                <p class="destaque">Inscreva-se e garanta seu lugar neste grande desafio!</p>
            </div>


            <div class="botoes">
                {{-- Lógica para remover o botão de inscrição se as vagas acabarem --}}
                @if($vagasRestantes > 0)
                    <a href="{{ route('inscricao') }}" class="btn btn-primario">Inscrever-se</a>
                @else
                    <button class="btn btn-secundario" disabled style="cursor: not-allowed; opacity: 0.8; background:rgb(205, 8, 8); color:#fff;">Inscrições Encerradas</button>
                @endif

                <a href="#" class="btn btn-secundario">Regulamento</a>
            </div>
        </div>
    </main>

    {{-- 💡 SIDEBAR DOS PARCEIROS --}}
        <section class="partners-sidebar">
            <h2 class="section-title-center">Nossos Parceiros</h2>
            <div class="partners-logos carousel-container">
                <div class="carousel-track">
                    <img src="{{ asset('img/parceiros/hbu.png') }}" alt="Logo HBU">
                    <img src="{{ asset('img/parceiros/prefeitura_marilia2.png') }}" alt="Logo Prefeitura Marília">
                    <img src="{{ asset('img/parceiros/unimagem.png') }}" alt="Logo Unimagem">
                    <img src="{{ asset('img/parceiros/unimar_blue.png') }}" alt="Logo Unimar">
                    <img src="{{ asset('img/parceiros/unimed.png') }}" alt="Logo Unimed">
                </div>
            </div>
        </section>
    {{-- FIM DO SIDEBAR --}}
</div>
</div>
@endsection
