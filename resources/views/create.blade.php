<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Mentor</title>
    <!--
      CSS CORRIGIDO E RESPONSIVO
      Este é o CSS de MÚLTIPLAS ETAPAS que você forneceu,
      agora aplicado ao seu HTML.
    -->
    <style>
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }

        body {
          font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
          background-color: #ffffff;
          background-image: url('../img/Component6.png');
          background-size: cover;
          background-repeat: no-repeat;
          background-position: center;
          min-height: 100vh;
          /* Centraliza o formulário */
          display: flex;
          align-items: center;
          justify-content: center;
          padding: 1rem;
        }

        .form-wrapper {
          width: 100%;
          max-width: 900px; /* Aumentado para melhor comportar o layout */
          margin: 2rem auto;
          background: white;
          border-radius: 1rem;
          padding: 2rem;
          box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .header {
          display: flex;
          align-items: center;
          gap: 1rem; /* Aumentado o gap */
          margin-bottom: 2rem;
        }

        .logo {
          width: 3rem; /* Diminuído para um ícone */
          height: 3rem;
          border-radius: 0.4rem;
          display: flex;
          align-items: center;
          justify-content: center;
          background-color: #f3f4f6;
        }

        .logo-icon {
            /* Placeholder para o logo, você pode usar um <img> aqui */
            width: 4rem;
            height: 4rem;
            font-size: 1.5rem;
            font-weight: bold;
            color: #2563eb;
        }

        .logo-icon img{
            width: 50px;
        }

        .logo-text {
          font-size: 1.5rem; /* Aumentado */
          font-weight: 700; /* Mais forte */
          color: #1f2937;
        }

        .logo-subtitle {
          font-size: 1rem; /* Aumentado */
          color: #2563eb;
        }

        .navigation {
          max-width: 100%;
          margin: 0 auto 2rem;
        }

        .nav-icons {
          display: flex;
          /* CORREÇÃO: Ativado 'space-between' */
          justify-content: space-between;
          align-items: flex-start;
          margin-bottom: 0.5rem;
        }

        .nav-icon {
          width: 3rem;
          height: 3rem;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          background: #e5e7eb;
          color: #9ca3af;
          cursor: pointer;
          transition: all 0.3s ease;
          font-weight: 600;
        }

        .nav-icon.active {
          background: #2563eb;
          color: white;
        }

        .nav-icon.completed {
            background: #10B981; /* Verde para concluído */
            color: white;
        }

        .progress-bar {
          width: 100%;
          height: 0.5rem;
          background: #e5e7eb;
          border-radius: 9999px;
          margin-bottom: 0.5rem;
          position: relative;
          overflow: hidden;
        }

        .progress-fill {
          position: absolute;
          top: 0;
          left: 0;
          height: 100%;
          background: #2563eb;
          border-radius: 9999px;
          transition: width 0.3s ease;
          width: 0%; /* JS vai controlar isso */
        }

        .nav-labels {
          display: flex;
          justify-content: space-between;
          align-items: flex-start;
        }

        .nav-label {
          flex: 1;
          max-width: 200px;
          text-align: left;
        }

        /* Alinhamento dos labels */
        .nav-label:nth-child(2) { text-align: center; }
        .nav-label:last-child { text-align: right; }

        .nav-label-title {
          font-size: 0.875rem;
          font-weight: 500;
          color: #6b7280; /* Cor padrão (cinza) */
          margin-bottom: 0;
        }

        .nav-label-title.active {
          color: #1f2937; /* Cor do label ativo (preto) */
        }

        /* Removido (não usado no novo HTML) */
        /* .nav-label-status { ... } */

        /* Form */
        .tab-content {
          display: none; /* Esconde todas as abas por padrão */
        }

        .tab-content.active {
          display: block; /* Mostra apenas a aba ativa */
        }

        /* Grid para o formulário */
        .form-grid {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 1.5rem;
        }

        .form-section {
          display: flex;
          flex-direction: column;
          gap: 1.5rem;
        }

        .form-group {
          display: flex;
          flex-direction: column;
        }

        .form-group label {
          font-size: 0.875rem;
          font-weight: 500;
          color: #374151;
          margin-bottom: 0.5rem;
        }

        .form-group input[type="text"],
        .form-group select,
        .form-group textarea {
          width: 100%;
          padding: 0.75rem;
          background: #f3f4f6;
          border: 1px solid #e5e7eb; /* Borda sutil */
          border-radius: 0.5rem;
          font-size: 1rem;
          font-family: inherit;
          color: #1f2937;
        }

        .form-group input[type="text"]:focus,
        .form-group select:focus,
        .form-group textarea:focus {
          outline: none;
          border-color: #2563eb;
          box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        /* Form Actions */
        .form-actions {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-top: 2rem;
        }

        .btn-back,
        .btn-next,
        button[type="submit"] /* Adicionado estilo para o submit */
         {
          display: flex;
          align-items: center;
          gap: 0.5rem;
          padding: 0.75rem 2rem;
          border-radius: 0.5rem;
          font-size: 1rem;
          font-weight: 500;
          cursor: pointer;
          transition: all 0.2s ease;
          border: none;
        }

        .btn-back {
          background: transparent;
          color: #374151;
          border: 1px solid #d1d5db;
        }

        .btn-back:hover {
          background: #f9fafb;
        }

        .btn-next,
        button[type="submit"] {
          background: #334155;
          color: white;
          margin-left: auto;
        }

        .btn-next:hover,
        button[type="submit"]:hover {
          background: #1e293b;
        }

        button[type="submit"] {
            margin-left: 0; /* Reseta o margin-left para o botão de submit */
        }

        /* Area Selection (Disponibilidade) */
        .area-selection {
          max-width: 800px;
          margin: 0 auto;
        }

        .area-selection h2 {
          font-size: 1.5rem;
          font-weight: 700;
          color: #1f2937;
          text-align: center;
          margin-bottom: 1.5rem;
        }

        .area-description {
          text-align: center;
          color: #6b7280;
          margin-bottom: 2rem;
        }

        .area-options {
          display: flex;
          flex-direction: column;
          gap: 1rem;
        }

        /* Estilo para os fieldsets */
        fieldset {
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        legend {
            font-weight: 600;
            padding: 0 0.5rem;
            color: #1f2937;
            font-size: 1.1rem;
        }

        /* Grid para os checkboxes */
        .checkbox-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* 2 colunas */
            gap: 1rem;
        }

        .area-option {
          display: flex;
          align-items: center;
          padding: 1rem;
          border: 2px solid #e5e7eb;
          border-radius: 0.5rem;
          cursor: pointer;
          transition: all 0.2s ease;
        }

        .area-option:hover {
          border-color: #93c5fd;
        }

        /* NOVO: Estilo para Checkbox (baseado no seu CSS) */
        .area-option input[type="checkbox"] {
          width: 1.25rem;
          height: 1.25rem;
          margin-right: 1rem;
          cursor: pointer;
          accent-color: #2563eb; /* Moderno */
        }

        /* NOVO: Estilo para Checkbox selecionado */
        .area-option:has(input[type="checkbox"]:checked) {
          border-color: #2563eb;
          background: #eff6ff;
        }

        .area-option-content {
          flex: 1;
        }

        .area-option-title {
          font-weight: 600;
          color: #1f2937;
        }

        .error {
            color: #EF4444;
            font-size: 0.875em;
            margin-top: 5px;
        }

        .success {
            color: #10B981;
            background: #D1FAE5;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }


        /* --- Todas as outras classes (Questions, Thank You) --- */
        /* ... (O resto do seu CSS de 'Questions' e 'Thank You'
               iria aqui, mas não é usado neste formulário) ... */

        /* -------------------------- */
        /* --- RESPONSIVIDADE --- */
        /* -------------------------- */

        /* Tablet */
        @media (max-width: 1024px) {
          /* Já coberto pelo max-width de 900px no form-wrapper */
        }

        /* Mobile */
        @media (max-width: 768px) {
            body {
                padding: 1rem 0.5rem;
                display: block; /* Remove o centramento vertical */
            }

            .form-wrapper {
                padding: 1.5rem 1rem;
                margin: 1rem auto;
            }

            .form-wrapper h2 {
                font-size: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .header {
                margin-bottom: 1.5rem;
            }

            .logo-text {
                font-size: 1.25rem;
            }

            .logo-subtitle {
                font-size: 0.875rem;
            }

            /* Navegação Mobile */
            .navigation {
                margin-bottom: 1.5rem;
            }

            .nav-icon {
                width: 2.5rem;
                height: 2.5rem;
                font-size: 0.875rem;
            }

            .nav-labels {
                flex-wrap: wrap;
                gap: 0.5rem;
                justify-content: space-between;
            }

            .nav-label {
                max-width: 150px;
                flex: 0 1 auto; /* Não cresce */
            }

            .nav-label:last-child {
                text-align: right;
            }

            .nav-label-title {
                font-size: 0.75rem;
            }

            /* Formulário Mobile */
            .form-grid {
                grid-template-columns: 1fr; /* Coluna única */
                gap: 0;
            }

            /* Checkbox grid mobile */
            .checkbox-grid {
                grid-template-columns: 1fr; /* Coluna única */
            }

            .form-group {
                margin-bottom: 1rem; /* Reduz espaço */
            }

            /* Ações do Form Mobile */
            .form-actions {
                flex-direction: column-reverse; /* Avançar em cima */
                gap: 0.75rem;
                margin-top: 1.5rem;
            }

            .btn-back,
            .btn-next,
            button[type="submit"] {
                width: 100%;
                justify-content: center;
                padding: 0.875rem 1.5rem;
            }

            .btn-next {
                margin-left: 0;
            }

            /* Area Selection Mobile */
            .area-selection h2 {
                font-size: 1.25rem;
                margin-bottom: 1rem;
            }

            .area-description {
                font-size: 0.875rem;
                margin-bottom: 1.5rem;
            }

            .area-option {
                padding: 0.875rem;
            }

            .area-option-title {
                font-size: 0.9375rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 0.5rem;
            }

            .form-wrapper {
                padding: 1.5rem 0.75rem;
            }

            .nav-icon {
                width: 2.2rem;
                height: 2.2rem;
                font-size: 0.75rem;
            }

            .nav-label {
                max-width: 100px;
            }

            .nav-label:nth-child(2) {
                text-align: center;
            }

            .nav-label-title {
                font-size: 0.6875rem;
            }

            .checkbox-grid {
                grid-template-columns: 1fr; /* Mantém 1 coluna */
            }

            .area-option {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body>

    <div class="form-wrapper">

        <!-- Cabeçalho -->
        <div class="header">
            <div class="logo">
                <!-- Use um <img> ou um ícone aqui -->
                <span class="logo-icon"><img src="{{ asset('img/parceiros/5.png') }}" alt=""></span>
            </div>
            <div>
                <div class="logo-text">Cadastro de Mentor</div>
                <div class="logo-subtitle">HackHealth DevMenthors</div>
            </div>
        </div>

        <!-- Barra de Navegação por Etapas -->
        <div class="navigation">
            <div class="nav-icons">
                <div class="nav-icon active" id="icon-1">1</div>
                <div class="nav-icon" id="icon-2">2</div>
                <div class="nav-icon" id="icon-3">3</div>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="progress-fill"></div>
            </div>
            <div class="nav-labels">
                <div class="nav-label"><span class="nav-label-title active" id="label-1">Dados Pessoais</span></div>
                <div class="nav-label"><span class="nav-label-title" id="label-2">Disponibilidade</span></div>
                <div class="nav-label"><span class="nav-label-title" id="label-3">Finalizar</span></div>
            </div>
        </div>

        <!-- Exibe mensagem de sucesso -->
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <!-- Exibe erros gerais (ex: erro de banco) -->
        @if($errors->has('msg'))
            <div class="error">{{ $errors->first('msg') }}</div>
        @endif

        <form action="{{ route('hackathon.mentor.store') }}" method="POST">
            @csrf

            <!-- ETAPA 1: DADOS PESSOAIS -->
            <div id="tab-1" class="tab-content active">
                <div class="form-section">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required>
                            @error('nome') <div class="error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="rg">RG</label>
                            <input type="text" id="rg" name="rg" value="{{ old('rg') }}">
                            @error('rg') <div class="error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="instituicao">Instituição</label>
                            <input type="text" id="instituicao" name="instituicao" value="{{ old('instituicao') }}">
                            @error('instituicao') <div class="error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="especialidade">Principais Especialidade</label>
                            <input type="text" id="especialidade" name="especialidade" value="{{ old('especialidade') }}">
                            @error('especialidade') <div class="error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <!-- Botão "Avançar" que chama o JavaScript -->
                    <button type="button" class="btn-next" onclick="nextTab('tab-1', 'tab-2')">Avançar</button>
                </div>
            </div>

            <!-- ETAPA 2: DISPONIBILIDADE (Usando o estilo .area-selection) -->
            <div id="tab-2" class="tab-content">
                <div class="area-selection">
                    <h2>Sua Disponibilidade</h2>
                    <p class="area-description">Selecione todos os períodos em que você pode dar mentoria. (Pelo menos um é obrigatório)</p>

                    @error('disponibilidade') <div class="error" style="margin-bottom: 1rem;">{{ $message }}</div> @enderror
                    @error('disponibilidade.*') <div class="error" style="margin-bottom: 1rem;">{{ $message }}</div> @enderror

                    <fieldset>
                        <legend>Dia 29</legend>
                        <div class="checkbox-grid">
                            <label class="area-option">
                                <input type="checkbox" name="disponibilidade[]" value="29_manha">
                                <span class="area-option-title">Manhã</span>
                            </label>
                             <label class="area-option">
                                <input type="checkbox" name="disponibilidade[]" value="29_tarde">
                                <span class="area-option-title">Tarde</span>
                            </label>
                             <label class="area-option">
                                <input type="checkbox" name="disponibilidade[]" value="29_noite">
                                <span class="area-option-title">Noite</span>
                            </label>
                             <label class="area-option">
                                <input type="checkbox" name="disponibilidade[]" value="29_madrugada">
                                <span class="area-option-title">Madrugada</span>
                            </label>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Dia 30</legend>
                         <div class="checkbox-grid">
                            <label class="area-option">
                                <input type="checkbox" name="disponibilidade[]" value="30_manha">
                                <span class="area-option-title">Manhã</span>
                            </label>
                             <label class="area-option">
                                <input type="checkbox" name="disponibilidade[]" value="30_tarde">
                                <span class="area-option-title">Tarde</span>
                            </label>
                             <label class="area-option">
                                <input type="checkbox" name="disponibilidade[]" value="30_noite">
                                <span class="area-option-title">Noite</span>
                            </label>
                             <label class="area-option">
                                <input type="checkbox" name="disponibilidade[]" value="30_madrugada">
                                <span class="area-option-title">Madrugada</span>
                            </label>
                        </div>
                    </fieldset>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-back" onclick="prevTab('tab-2', 'tab-1')">Voltar</button>
                    <button type="button" class="btn-next" onclick="nextTab('tab-2', 'tab-3')">Avançar</button>
                </div>
            </div>

            <!-- ETAPA 3: FINALIZAR -->
            <div id="tab-3" class="tab-content">
                <div class="area-selection" style="padding: 2rem 0;">
                    <h2 style="margin-bottom: 1rem;">Quase lá!</h2>
                    <p class="area-description">Revise seus dados nas etapas anteriores. Ao clicar em "Enviar Cadastro", você confirma sua inscrição como mentor para os períodos selecionados.</p>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-back" onclick="prevTab('tab-3', 'tab-2')">Voltar</button>
                    <!-- O botão final é do tipo "submit" -->
                    <button type="submit">Enviar Cadastro</button>
                </div>
            </div>
        </form>
    </div>

    <!-- SCRIPT PARA NAVEGAÇÃO DAS ABAS -->
    <script>
        function updateProgress(activeTabId) {
            const progressFill = document.getElementById('progress-fill');
            const icons = {
                'tab-1': document.getElementById('icon-1'),
                'tab-2': document.getElementById('icon-2'),
                'tab-3': document.getElementById('icon-3')
            };
            const labels = {
                'tab-1': document.getElementById('label-1'),
                'tab-2': document.getElementById('label-2'),
                'tab-3': document.getElementById('label-3')
            };

            // Reseta todos
            Object.values(icons).forEach(icon => icon.classList.remove('active', 'completed'));
            Object.values(labels).forEach(label => label.classList.remove('active'));

            // Aplica estilos com base na aba ativa
            if (activeTabId === 'tab-1') {
                progressFill.style.width = '0%';
                icons['tab-1'].classList.add('active');
                labels['tab-1'].classList.add('active');
            } else if (activeTabId === 'tab-2') {
                progressFill.style.width = '50%';
                icons['tab-1'].classList.add('completed');
                icons['tab-2'].classList.add('active');
                labels['tab-2'].classList.add('active');
            } else if (activeTabId === 'tab-3') {
                progressFill.style.width = '100%';
                icons['tab-1'].classList.add('completed');
                icons['tab-2'].classList.add('completed');
                icons['tab-3'].classList.add('active');
                labels['tab-3'].classList.add('active');
            }
        }

        function nextTab(currentTabId, nextTabId) {
            document.getElementById(currentTabId).classList.remove('active');
            document.getElementById(nextTabId).classList.add('active');
            updateProgress(nextTabId);
        }

        function prevTab(currentTabId, prevTabId) {
            document.getElementById(currentTabId).classList.remove('active');
            document.getElementById(prevTabId).classList.add('active');
            updateProgress(prevTabId);
        }

        // Inicializa o progresso na primeira aba
        document.addEventListener('DOMContentLoaded', () => {
            updateProgress('tab-1');
        });
    </script>
</body>
</html>
