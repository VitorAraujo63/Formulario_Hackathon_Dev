@extends('layouts.app')

@section('content')
<div class="container">
    <img src="{{ asset('img/azul.png') }}" alt="" class="img-azul">
    <img src="{{ asset('img/preto.png') }}" alt="" class="img-preto">

    <nav class="navbar">
        <img src="{{ asset('img/parceiros/4.png') }}" alt="">
    </nav>

    <div class="vagas">
        <div class="vagas-box">300 Vagas disponíveis</div>
    </div>

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
                <a href="{{ route('inscricao') }}" class="btn btn-primario">Inscrever-se</a>
                <a href="#" class="btn btn-secundario">Regulamento</a>
            </div>
        </div>
    </main>
</div>
@endsection
