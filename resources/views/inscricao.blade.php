@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/inscricao.css') }}">
    
    <style>
        .responsavel-box {
            background-color: #f0f7ff;
            border: 2px dashed #0056b3;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        .responsavel-title {
            color: #0056b3;
            font-weight: bold;
            font-size: 1rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .responsavel-box .form-group label {
            color: #004085;
        }
    </style>

    @if(isset($vagasEsgotadas) && $vagasEsgotadas)
        <div class="thank-you-screen" style="display: flex; align-items: center; justify-content: center; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; background: white; font-family: 'Inter', sans-serif;">
        <div class="thank-you-content" style="text-align: center; max-width: 90%; width: 450px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#ff4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 20px;">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
            <h1 style="color: #0f172a; margin-bottom: 10px;">Inscrições Encerradas!</h1>
            <p style="color: #64748b;">Infelizmente, atingimos o limite de participantes para este evento.</p>
            <a href="{{ url('/') }}" style="margin-top: 30px; display: inline-block; padding: 12px 30px; background: #1e293b; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">Voltar para o Site</a>
        </div>
    </div>

    @else

    <div id="thankYouScreen" class="thank-you-screen" style="display: none; align-items: center; justify-content: center; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; background: rgba(255,255,255,0.98); backdrop-filter: blur(4px); font-family: 'Inter', system-ui, sans-serif;">
        <img src="{{ asset('img/azul.png') }}" alt="" class="img-azul-thankyou">
        <img src="{{ asset('img/preto.png') }}" alt="" class="img-preto-thankyou">
        
        <div class="thank-you-content" style="max-width: 500px; width: 90%; padding: 40px; border-radius: 24px; background: #ffffff; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); text-align: center;">

            <div style="background: #ecfdf5; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>

            <h1 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 8px;">Inscrição Confirmada</h1>
            <p style="color: #475569; font-size: 1rem; line-height: 1.5; margin-bottom: 25px;">
                Sua participação no <strong>HackHealth</strong> foi registrada.
            </p>
            
            <div style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; margin-bottom: 25px; text-align: left;">
                <h4 style="margin: 0 0 5px 0; color: #1e293b; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Oportunidade de Mentoria</h4>
                <p style="margin: 0; color: #64748b; font-size: 0.9rem; line-height: 1.4;">
                    Gostaríamos de convidá-lo para conhecer o <strong>DevMenthors</strong>: uma iniciativa exclusiva para networking e evolução técnica.
                </p>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                <button onclick="irParaEcossistema()" style="background: #1e293b; color: #ffffff; border: none; padding: 14px; border-radius: 10px; font-weight: 600; cursor: pointer; font-size: 0.95rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                    Conhecer Projeto DevMenthors
                </button>
                
                <a href="{{ url('/') }}" style="color: #94a3b8; text-decoration: none; font-size: 0.85rem; font-weight: 500;">
                    Retornar à página inicial
                </a>
            </div>
        </div>
    </div>

        <div class="container" id="mainContainer">
            <div class="form-wrapper">
                <div class="header">
                    <div class="logo">
                        <div class="logo-icon">
                          <a href="/hackhealth"><img src="{{ asset('img/parceiros/5.png') }}" alt="" class="logo" /></a>
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
                    @csrf
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
                                        <label for="cpf">CPF</label>
                                        <input type="text" id="cpf" name="cpf" required placeholder="000.000.000-00" oninput="mascaraCPF(this)" maxlength="14" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="telefone">Telefone (Whatsapp)</label>
                                        <input type="tel" id="telefone" name="telefone" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="nascimento">Data de Nascimento</label>
                                        <input type="date" id="nascimento" name="nascimento" required onchange="verificarMaioridade()">
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

                                <div id="secao-responsavel" class="responsavel-box" style="display: none;">
                                    <div class="responsavel-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                        Dados do Responsável Legal
                                    </div>
                                    <div class="form-group">
                                        <label for="nome_responsavel">Nome Completo do Responsável</label>
                                        <input type="text" id="nome_responsavel" name="nome_responsavel">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="telefone_responsavel">Telefone do Responsável</label>
                                            <input type="tel" id="telefone_responsavel" name="telefone_responsavel">
                                        </div>
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
                                    <input type="text" id="curso" name="curso" maxlength="60">
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
                                    Anterior
                                </button>
                                <button type="button" class="btn-question-next" id="btnQuestionNext" style="display: none;">
                                    Próxima
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-back" id="btnBack" style="display: none;">
                            Voltar
                        </button>
                        <button type="button" class="btn-next" id="btnNext">
                            <span id="btnNextText">Next</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        
        <script>
            const API_SUBMIT_URL = "{{ url('api/submit-quiz') }}";

            function nextStep(step) {
                document.querySelectorAll('.success-step').forEach(div => {
                    div.style.display = 'none';
                });
                const nextDiv = document.getElementById('step-' + step);
                if (nextDiv) nextDiv.style.display = 'block';
            }

            function inscreverAutomaticamente() {
    const btn = document.getElementById('btnConfirmAuto');
    if(btn) {
        btn.disabled = true;
        btn.innerText = "Processando...";
    }

    const dadosParaAluno = {
        nome: formState.formData.nome,
        email: formState.formData.email,
        cpf: formState.formData.cpf,
        telefone: formState.formData.telefone,
        nascimento: formState.formData.nascimento,
        cidade: formState.formData.cidade,
        nome_responsavel: formState.formData.nome_responsavel || null,
        telefone_responsavel: formState.formData.telefone_responsavel || null
    };

    axios.post("/inscricao-aluno-automatica", { formData: dadosParaAluno })
        .then(response => {
            alert("Sucesso: " + response.data.message);
            window.location.href = "/"; 
        })
        .catch(error => {
            console.error(error);
            let msg = error.response?.data?.message || "Erro de conexão (404). Verifique as rotas do servidor.";
            alert(msg);
            if(btn) {
                btn.disabled = false;
                btn.innerText = "Sim, pode cadastrar!";
            }
        });
}
        </script>

        {{-- Importante: O arquivo JS vem por último para não dar conflito --}}
        <script src="{{ asset('js/inscricao.js') }}"></script>
    @endif
@endsection