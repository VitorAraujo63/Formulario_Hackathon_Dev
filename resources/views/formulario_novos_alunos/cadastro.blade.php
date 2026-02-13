@extends('layouts.app')

@section('title', 'DevMenthors | Inscrição ')

@section('content')
    <style>
        body {
            margin: 0; padding: 0;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f0f2f5;
            background-image: url("{{ asset('img/Component6.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .main-card {
            background: rgba(255, 255, 255, 0.98);
            max-width: 900px;
            margin: 40px auto;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            padding: 40px;
            position: relative;
        }

        .header-section {
            text-align: center; margin-bottom: 40px; padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }
        .header-logo { max-width: 120px; margin-bottom: 15px; }
        .header-title { font-size: 2rem; font-weight: 800; color: #1a202c; margin: 0; }
        .header-subtitle { color: #64748b; font-size: 1rem; margin-top: 5px; }

        .section-block { margin-bottom: 30px; }
        .section-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .section-number {
            background: #2563eb; color: white; width: 30px; height: 30px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 0.9rem;
        }
        .section-title { font-size: 1.2rem; font-weight: 700; color: #334155; }
        .form-grid { display: grid; grid-template-columns: 1fr; gap: 15px; }
        @media (min-width: 768px) {
            .form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        }
        label { display: block; font-size: 0.9rem; font-weight: 600; color: #475569; margin-bottom: 5px; }
        input, select, textarea {
            width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0;
            border-radius: 8px; font-size: 1rem; background-color: #f8fafc;
            transition: 0.3s ease; box-sizing: border-box;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #2563eb; background-color: white; outline: none;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .btn-submit {
            width: 100%; padding: 15px; background: #2563eb; color: white;
            border: none; border-radius: 10px; font-size: 1.1rem; font-weight: bold;
            cursor: pointer; transition: background 0.3s, transform 0.2s; margin-top: 20px;
        }
        .btn-submit:hover { background: #1d4ed8; transform: translateY(-2px); }

        .radio-options { display: flex; gap: 15px; }
        .radio-label {
            flex: 1; padding: 10px; border: 2px solid #e2e8f0; border-radius: 8px;
            text-align: center; cursor: pointer; font-weight: 600; color: #64748b; transition: 0.2s;
        }
        .radio-label:hover { border-color: #cbd5e1; }
        input[type="radio"]:checked + .radio-label {
            border-color: #2563eb; background-color: #eff6ff; color: #2563eb;
        }
        input[type="radio"] { display: none; }

        .hidden { display: none; }
        .overlay-screen {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999;
            display: flex; justify-content: center; align-items: center; text-align: center;
            background-color: #ffffff;
        }
        .success-bg {
            background-image: url("{{ asset('img/azul.png') }}"), url("{{ asset('img/preto.png') }}");
            background-position: top left, bottom right;
            background-repeat: no-repeat, no-repeat;
            background-size: 400px auto, 400px auto;
        }
        @media (max-width: 768px) {
            .success-bg { background-size: 150px auto, 150px auto; }
            .main-card { margin: 20px; padding: 20px; }
        }
        .result-card {
            max-width: 500px; padding: 40px; background: white; border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15); position: relative; width: 90%;
        }
        .btn-home {
            display: inline-block; margin-top: 30px; padding: 12px 35px;
            background: #007bff; color: white; text-decoration: none; border-radius: 50px;
            font-weight: bold; transition: 0.3s;
        }
        .btn-home:hover { background: #0056b3; transform: scale(1.05); }
        .logo-rodape { max-width: 150px; width: 100%; height: auto; margin-top: 20px; }
    </style>

<body>

    @if(session('success'))
        <div class="overlay-screen success-bg">
            <div class="result-card">
                <div style="width: 70px; height: 70px; background: #dcfce7; border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <h1 style="color: #1e293b; margin-bottom: 10px; font-size: 26px;">Inscrição Confirmada!</h1>
                <p style="color: #64748b; font-size: 16px; margin-bottom: 20px;">Recebemos seus dados com sucesso.</p>
                <div style="background: #f1f5f9; padding: 15px; border-radius: 10px; margin: 20px 0;">
                    <h3 style="color: #2563eb; margin: 0 0 5px 0; font-size: 18px;">Bem-vindo ao DevMenthors!</h3>
                    <p style="color: #475569; font-size: 14px; margin: 0;">Prepare-se para uma experiência incrível de aprendizado.</p>
                </div>
                <a href="{{ route('home') }}" class="btn-home">Voltar para o Início</a>
            </div>
        </div>
    
    @elseif(isset($vagasEsgotadas) && $vagasEsgotadas)
        <div class="overlay-screen">
            <div class="result-card">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 15px;"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <h1 style="color: #333;">Inscrições Encerradas</h1>
                <p style="color: #666;">O limite de vagas foi atingido.</p>
                <a href="{{ route('home') }}" class="btn-home" style="background: #64748b;">Voltar para o Site</a>
            </div>
        </div>

    @else
        <div class="main-card">
        <div class="header-section">
                <a href="/">
                    <img src="{{ asset('img/logo_rodape.png') }}" alt="DevMenthors" class="header-logo">
                </a>
                <h1 class="header-title">
                    Sua Jornada na <span style="color: #2563eb;">Tecnologia</span> Começa Aqui
                </h1>
                <p class="header-subtitle" style="max-width: 600px; margin: 10px auto 0; line-height: 1.6;">
                    Você está prestes a dar o passo mais importante para o seu futuro profissional. 
                    Preencha os dados abaixo e garanta sua vaga nesta experiência transformadora.
                </p>
            </div>

            <form method="POST" action="{{ route('aluno.store') }}" id="student-form">
                @csrf 

                <div class="section-block">
                    <div class="section-header">
                        <div class="section-number">1</div>
                        <div class="section-title">Dados do Aluno</div>
                    </div>
                    
                    <div class="form-grid">
                        <div>
                            <label for="nome_completo">Nome Completo</label>
                            <input type="text" id="nome_completo" name="nome_completo" required placeholder="Nome do aluno" 
                                   maxlength="100" oninput="validarTexto(this)">
                        </div>

                        <div class="form-row-2">
                            <div>
                                <label for="data_nascimento">Data de Nascimento</label>
                                <input type="date" id="data_nascimento" name="data_nascimento" required
                                       min="1900-01-01" max="2030-12-31">
                            </div>
                            <div>
                                <label for="serie">Série / Ano Escolar</label>
                                <select id="serie" name="serie" required>
                                    <option value="">Selecione...</option>
                                    <option value="8_ano">8º Ano</option>
                                    <option value="9_ano">9º Ano</option>
                                    <option value="1_em">1º Ano Ensino Médio</option>
                                    <option value="2_em">2º Ano Ensino Médio</option>
                                    <option value="3_em">3º Ano Ensino Médio</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="escola">Instituição de Ensino</label>
                            <input type="text" id="escola" name="escola" required placeholder="Nome da escola" 
                                   maxlength="100" oninput="validarTexto(this)">
                        </div>

                        <div class="form-row-2">
                            <div>
                                <label for="email_aluno">E-mail do Aluno</label>
                                <input type="email" id="email_aluno" name="email_aluno" placeholder="aluno@email.com" maxlength="100">
                            </div>

                            <div>
                                <label for="cpf">CPF do Aluno</label>
                                {{-- O maxlength 14 permite os 11 números + 2 pontos + 1 traço --}}
                                <input type="text" 
                                    id="cpf" 
                                    name="cpf" 
                                    required 
                                    placeholder="000.000.000-00" 
                                    maxlength="14" 
                                    oninput="mascaraCPF(this)"
                                    inputmode="numeric">
                            </div>

                            <div>
                                <label for="telefone_aluno">WhatsApp do Aluno</label>
                                <input type="tel" id="telefone_aluno" name="telefone_aluno" placeholder="(00) 00000-0000"
                                       maxlength="15" oninput="mascaraTelefone(this)">
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

                <div class="section-block">
                    <div class="section-header">
                        <div class="section-number">2</div>
                        <div class="section-title">Dados do Responsável</div>
                    </div>

                    <div class="form-grid">
                        <div>
                            <label for="nome_responsavel">Nome do Responsável</label>
                            <input type="text" id="nome_responsavel" name="nome_responsavel" required placeholder="Pai, Mãe ou Tutor"
                                   maxlength="100" oninput="validarTexto(this)">
                        </div>

                        <div class="form-row-2">
                            <div>
                                <label for="email_responsavel">E-mail do Responsável</label>
                                <input type="email" id="email_responsavel" name="email_responsavel" required maxlength="100">
                            </div>
                            <div>
                                <label for="telefone_responsavel">WhatsApp do Responsável</label>
                                <input type="tel" id="telefone_responsavel" name="telefone_responsavel" required placeholder="(00) 00000-0000"
                                       maxlength="15" oninput="mascaraTelefone(this)">
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

                <div class="section-block">
                    <div class="section-header">
                        <div class="section-number">3</div>
                        <div class="section-title">Informações Adicionais</div>
                    </div>

                    <div class="form-grid">
                        <div>
                            <label style="margin-bottom: 10px;">Possui conhecimento em programação?</label>
                            <div class="radio-options">
                                <label>
                                    <input type="radio" name="tem_conhecimento" value="0" checked onclick="toggleKnowledge(false)">
                                    <div class="radio-label">Não, sou iniciante</div>
                                </label>
                                <label>
                                    <input type="radio" name="tem_conhecimento" value="1" onclick="toggleKnowledge(true)">
                                    <div class="radio-label">Sim, já conheço</div>
                                </label>
                            </div>
                        </div>

                        <div id="knowledge_details" class="hidden">
                            <label for="descricao_conhecimento" style="margin-top: 15px;">Detalhe seu conhecimento:</label>
                            <textarea id="descricao_conhecimento" name="descricao_conhecimento" rows="3" placeholder="Ex: Curso de Lógica, Python básico..." maxlength="500"></textarea>
                        </div>

                        <div>
                            <label for="onde_conheceu" style="margin-top: 15px;">Como nos conheceu?</label>
                            <select id="onde_conheceu" name="onde_conheceu" required>
                                <option value="">Selecione...</option>
                                <option value="Instagram">Instagram</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Indicacao_Amigo">Indicação de Amigo</option>
                                <option value="Escola">Na Escola</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                CONCLUIR INSCRIÇÃO
                </button>
            </form>
        </div>

        <script>
            function toggleKnowledge(show) {
                const details = document.getElementById('knowledge_details');
                const textarea = document.getElementById('descricao_conhecimento');
                if (show) {
                    details.classList.remove('hidden');
                    textarea.required = true;
                } else {
                    details.classList.add('hidden');
                    textarea.value = '';
                    textarea.required = false;
                }
            }

            function mascaraTelefone(input) {   
                let v = input.value;
                v = v.replace(/\D/g, "");           
                v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); 
                v = v.replace(/(\d)(\d{4})$/, "$1-$2");    
                input.value = v;
            }

            function validarTexto(input) {
                input.value = input.value.replace(/[0-9]/g, "");
            }

            function mascaraCPF(i) {
                let v = i.value.replace(/\D/g, "");

                if (v.length > 11) {
                    v = v.substring(0, 11);
                }

                v = v.replace(/(\d{3})(\d)/, "$1.$2");      
                v = v.replace(/(\d{3})(\d)/, "$1.$2");      
                v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); 

                i.value = v;
            }
        </script>
    @endif
</body>
</html>
@endsection