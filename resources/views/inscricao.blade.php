@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="css/inscricao.css">
<body>
    <div id="thankYouScreen" class="thank-you-screen" style="display: none;">
        <div class="thank-you-content">
            <svg class="thank-you-icon" ...></svg>
            <h1>Obrigado!</h1>
            <p class="thank-you-subtitle">Sua inscrição foi enviada com sucesso.</p>
            <p class="thank-you-message">Boa sorte no DevMenthors HackHealth!</p>

            <a href="{{ url('/') }}" class="btn-voltar-site">
                Voltar para o Site
            </a>
        </div>
    </div>

    <div class="container" id="mainContainer">
        <div class="form-wrapper">
            <div class="header">
            <div class="logo">
                    <div class="logo-icon">
                      <img src="{{ asset('img/parceiros/5.png') }}" alt="" class="logo" />
                    </div>
            </div>
                <span class="logo-text">DevMenthors</span>
            </div>
            <div class="navigation">
                <div class="nav-icons">

                    <div class="nav-icon active" data-tab="personal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="m16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="nav-icon" data-tab="skills">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5a3 3 0 1 0-5.997.125 4 4 0 0 0-2.526 5.77 4 4 0 0 0 .556 6.588A4 4 0 1 0 12 18Z"/><path d="M12 5a3 3 0 1 1 5.997.125 4 4 0 0 1 2.526 5.77 4 4 0 0 1-.556 6.588A4 4 0 1 1 12 18Z"/><path d="M15 13a4.5 4.5 0 0 1-3-4 4.5 4.5 0 0 1-3 4"/><path d="M17.599 6.5a3 3 0 0 0 .399-1.375"/><path d="M6.003 5.125A3 3 0 0 0 6.401 6.5"/><path d="M3.477 10.896a4 4 0 0 1 .585-.396"/><path d="M19.938 10.5a4 4 0 0 1 .585.396"/><path d="M6 18a4 4 0 0 1-1.967-.516"/><path d="M19.967 17.484A4 4 0 0 1 18 18"/></svg>
                    </div>
                    <div class="nav-icon" data-tab="questions">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    </div>
                </div>

                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>

                <div class="nav-labels">
                    <div class="nav-label">
                        <div class="nav-label-title">Informações pessoais</div>
                        <div class="nav-label-status">Em progresso</div>
                    </div>
                    <div class="nav-label">
                        <div class="nav-label-title">Área de interesse</div>
                        <div class="nav-label-status">Pendente</div>
                    </div>
                    <div class="nav-label">
                        <div class="nav-label-title">Perguntas técnicas</div>
                        <div class="nav-label-status">Pendente</div>
                    </div>
                </div>
            </div>
            <form id="devmenthors-form">
                <div class="tab-content active" data-tab="personal">
                    <div class="form-grid">
                        <div class="form-section">
                            <div class="form-group">
                                <label for="nome">Nome completo</label>
                                <input type="text" id="nome" name="nome" maxlength="80" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" id="email" name="email" required maxlength="50">
                                </div>
                                <div class="form-group">
                                    <label for="telefone">Telefone (Whatsapp)</label>
                                    <input type="tel" id="telefone" name="telefone" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="nascimento">Data de Nascimento</label>
                                    <input type="date" id="nascimento" name="nascimento" required>
                                </div>
                                <div class="form-group">
                                    <label for="sexo">Sexo</label>
                                    <select id="sexo" name="sexo" required>
                                        <option value="">Selecione</option>
                                        <option value="masculino">Masculino</option>
                                        <option value="feminino">Feminino</option>
                                        <option value="outro">Outro</option>
                                        <option value="nao-informar">Prefiro não informar</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group small">
                                    <label for="estado">Estado</label>
                                    <select id="estado" name="estado" required>
                                        <option value="">Selecione</option>
                                        <option value="Acre">AC - Acre</option>
                                        <option value="Alagoas">AL - Alagoas</option>
                                        <option value="Amapá">AP - Amapá</option>
                                        <option value="Amazonas">AM - Amazonas</option>
                                        <option value="Bahia">BA - Bahia</option>
                                        <option value="Ceará">CE - Ceará</option>
                                        <option value="Distrito Federal">DF - Distrito Federal</option>
                                        <option value="Espírito Santo">ES - Espírito Santo</option>
                                        <option value="Goiás">GO - Goiás</option>
                                        <option value="Maranhão">MA - Maranhão</option>
                                        <option value="Mato Grosso">MT - Mato Grosso</option>
                                        <option value="Mato Grosso do Sul">MS - Mato Grosso do Sul</option>
                                        <option value="Minas Gerais">MG - Minas Gerais</option>
                                        <option value="Pará">PA - Pará</option>
                                        <option value="Paraíba">PB - Paraíba</option>
                                        <option value="Paraná">PR - Paraná</option>
                                        <option value="Pernambuco">PE - Pernambuco</option>
                                        <option value="Piauí">PI - Piauí</option>
                                        <option value="Rio de Janeiro">RJ - Rio de Janeiro</option>
                                        <option value="Rio Grande do Norte">RN - Rio Grande do Norte</option>
                                        <option value="Rio Grande do Sul">RS - Rio Grande do Sul</option>
                                        <option value="Rondônia">RO - Rondônia</option>
                                        <option value="Roraima">RR - Roraima</option>
                                        <option value="Santa Catarina">SC - Santa Catarina</option>
                                        <option value="São Paulo">SP - São Paulo</option>
                                        <option value="Sergipe">SE - Sergipe</option>
                                        <option value="Tocantins">TO - Tocantins</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" id="cidade" name="cidade" maxlength="50" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="curso">Curso/Área de Formação</label>
                                <input type="text" id="curso" name="curso" maxlength="60" required>
                            </div>

                            <div class="form-group">
                                <label for="linkedin">Link do LinkedIn</label>
                                <input type="url" id="linkedin" name="linkedin">
                            </div>
                        </div>

                        <div class="form-section-sidebar">
                            <div class="form-group">
                                <label for="sobre">Fale sobre você</label>
                                <textarea id="sobre" name="sobre" rows="20"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content" data-tab="skills">
                    <div class="area-selection">
                        <h2>Selecione sua área de interesse</h2>
                        <p class="area-description">Escolha a área em que você tem mais experiência ou interesse para responder perguntas técnicas específicas.</p>

                        <div class="area-options">
                            <label class="area-option">
                                <input type="radio" name="selectedArea" value="Front-End">
                                <div class="area-option-content">
                                    <div class="area-option-title">Front-End</div>
                                    <div class="area-option-description">HTML, CSS, JavaScript, React, Vue, Angular</div>
                                </div>
                            </label>

                            <label class="area-option">
                                <input type="radio" name="selectedArea" value="Back-End">
                                <div class="area-option-content">
                                    <div class="area-option-title">Back-End</div>
                                    <div class="area-option-description">Node.js, Python, Java, APIs, Bancos de Dados</div>
                                </div>
                            </label>

                            <label class="area-option">
                                <input type="radio" name="selectedArea" value="Full-Stack">
                                <div class="area-option-content">
                                    <div class="area-option-title">Full-Stack</div>
                                    <div class="area-option-description">Front-End + Back-End, Desenvolvimento completo</div>
                                </div>
                            </label>

                            <label class="area-option">
                                <input type="radio" name="selectedArea" value="Documentação Figma">
                                <div class="area-option-content">
                                    <div class="area-option-title">Documentação Figma</div>
                                    <div class="area-option-description">Design, Prototipagem, UI/UX, Design Systems</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="tab-content" data-tab="questions">
                    <div class="questions-container">
                        <div class="questions-header">
                            <h2 id="questionsTitle">Perguntas Técnicas</h2>
                            <span id="questionCounter" class="question-counter">Pergunta 1 de 6</span>
                        </div>

                        <div class="question-progress-bar">
                            <div class="question-progress-fill"></div>
                        </div>

                        <div id="questionContent" class="question-content">
                            <div class="question-level">Nível: Fácil</div>
                            <h3 class="question-text"></h3>
                            <div class="question-options"></div>
                        </div>
                        <div class="question-navigation">
                            <button type="button" class="btn-question-back" id="btnQuestionBack" style="display: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                                Anterior
                            </button>
                            <button type="button" class="btn-question-next" id="btnQuestionNext" style="display: none;">
                                Próxima
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-back" id="btnBack" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                        Voltar
                    </button>
                    <button type="button" class="btn-next" id="btnNext">
                        <span id="btnNextText">Next</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="js/inscricao.js"></script>
</body>
</html>
@endsection
