const estados = [
  
];

const telefoneInput = document.getElementById("telefone");

telefoneInput.addEventListener("input", function (e) {
  let value = e.target.value.replace(/\D/g, "");

  if (value.length > 11) {
      value = value.slice(0, 11);
  }

  value = value.replace(/^(\d{2})(\d)/g, "($1) $2");
  value = value.replace(/(\d{5})(\d)/, "$1-$2");

  e.target.value = value;
});

const cidadeInput = document.getElementById("cidade");

cidadeInput.addEventListener("input", function (e) {
  e.target.value = e.target.value.replace(/[0-9]/g, "");
});

const estadoSelect = document.getElementById("estado");

estados.forEach(uf => {
  const option = document.createElement("option");
  option.value = uf;
  option.textContent = uf;
  estadoSelect.appendChild(option);
});

const technicalQuestions = {
  "Front-End": {
    facil: [
      {
        question: "O que é HTML?",
        options: ["Uma linguagem de programação", "Uma linguagem de marcação", "Um banco de dados", "Um framework"],
        correct: 1,
      },
      {
        question: "Qual propriedade CSS é usada para mudar a cor do texto?",
        options: ["text-color", "font-color", "color", "text-style"],
        correct: 2,
      },
    ],
    media: [
      {
        question: "O que é o Virtual DOM no React?",
        options: [
          "Uma cópia do DOM real mantida em memória",
          "Um banco de dados virtual",
          "Um servidor virtual",
          "Uma API do navegador",
        ],
        correct: 0,
      },
      {
        question: "Qual hook do React é usado para gerenciar estado?",
        options: ["useEffect", "useState", "useContext", "useReducer"],
        correct: 1,
      },
    ],
    dificil: [
      {
        question: "O que é Server-Side Rendering (SSR)?",
        options: [
          "Renderização no cliente",
          "Renderização no servidor antes de enviar ao cliente",
          "Renderização em tempo real",
          "Renderização assíncrona",
        ],
        correct: 1,
      },
      {
        question: "Qual é a diferença entre useMemo e useCallback?",
        options: [
          "Não há diferença",
          "useMemo memoriza valores, useCallback memoriza funções",
          "useMemo é mais rápido",
          "useCallback é deprecated",
        ],
        correct: 1,
      },
    ],
  },
  "Back-End": {
    facil: [
      {
        question: "O que é uma API REST?",
        options: [
          "Um banco de dados",
          "Uma interface de programação que usa HTTP",
          "Uma linguagem de programação",
          "Um framework",
        ],
        correct: 1,
      },
      {
        question: "Qual método HTTP é usado para buscar dados?",
        options: ["POST", "PUT", "GET", "DELETE"],
        correct: 2,
      },
    ],
    media: [
      {
        question: "O que é middleware em Node.js?",
        options: [
          "Um banco de dados",
          "Funções que têm acesso ao request e response",
          "Um tipo de servidor",
          "Uma biblioteca",
        ],
        correct: 1,
      },
      {
        question: "O que é SQL Injection?",
        options: [
          "Um tipo de banco de dados",
          "Uma vulnerabilidade de segurança",
          "Um método de otimização",
          "Uma linguagem de programação",
        ],
        correct: 1,
      },
    ],
    dificil: [
      {
        question: "O que é o padrão Repository Pattern?",
        options: [
          "Um padrão de UI",
          "Um padrão que abstrai a camada de acesso a dados",
          "Um padrão de autenticação",
          "Um padrão de cache",
        ],
        correct: 1,
      },
      {
        question: "O que é Event-Driven Architecture?",
        options: [
          "Arquitetura baseada em eventos assíncronos",
          "Arquitetura de banco de dados",
          "Arquitetura de frontend",
          "Arquitetura de cache",
        ],
        correct: 0,
      },
    ],
  },
  "Full-Stack": {
    facil: [
      {
        question: "O que significa Full-Stack?",
        options: ["Apenas frontend", "Apenas backend", "Frontend e backend", "Apenas banco de dados"],
        correct: 2,
      },
      {
        question: "O que é um framework?",
        options: ["Um banco de dados", "Uma estrutura que facilita o desenvolvimento", "Uma linguagem", "Um servidor"],
        correct: 1,
      },
    ],
    media: [
      {
        question: "O que é CORS?",
        options: [
          "Um banco de dados",
          "Mecanismo de segurança para requisições cross-origin",
          "Uma linguagem",
          "Um framework",
        ],
        correct: 1,
      },
      {
        question: "O que é JWT?",
        options: ["Um banco de dados", "Um token de autenticação", "Uma linguagem", "Um servidor"],
        correct: 1,
      },
    ],
    dificil: [
      {
        question: "O que é Microservices Architecture?",
        options: [
          "Arquitetura monolítica",
          "Arquitetura com serviços independentes e desacoplados",
          "Arquitetura de frontend",
          "Arquitetura de cache",
        ],
        correct: 1,
      },
      {
        question: "O que é GraphQL?",
        options: ["Um banco de dados", "Uma linguagem de consulta para APIs", "Um framework", "Uma biblioteca de UI"],
        correct: 1,
      },
    ],
  },
  "Documentação Figma": {
    facil: [
      {
        question: "O que é o Figma?",
        options: ["Um editor de código", "Uma ferramenta de design colaborativo", "Um banco de dados", "Um framework"],
        correct: 1,
      },
      {
        question: "O que são frames no Figma?",
        options: ["Containers para organizar elementos", "Tipos de texto", "Cores", "Plugins"],
        correct: 0,
      },
    ],
    media: [
      {
        question: "O que são componentes no Figma?",
        options: ["Elementos reutilizáveis", "Cores", "Fontes", "Plugins"],
        correct: 0,
      },
      {
        question: "O que é Auto Layout no Figma?",
        options: ["Um plugin", "Recurso para criar layouts responsivos automaticamente", "Um tipo de frame", "Uma cor"],
        correct: 1,
      },
    ],
    dificil: [
      {
        question: "O que são variantes no Figma?",
        options: ["Tipos de cores", "Diferentes estados de um componente agrupados", "Tipos de texto", "Plugins"],
        correct: 1,
      },
      {
        question: "O que é Design System no contexto do Figma?",
        options: [
          "Um plugin",
          "Conjunto organizado de componentes, estilos e padrões reutilizáveis",
          "Um tipo de frame",
          "Uma biblioteca de ícones",
        ],
        correct: 1,
      },
    ],
  },
}

const formState = {
  activeTab: "personal",
  selectedArea: "",
  currentQuestionIndex: 0,
  userAnswers: [],
  formData: {
    nome: "",
    email: "",
    telefone: "",
    nascimento: "",
    sexo: "",
    estado: "",
    cidade: "",
    curso: "",
    linkedin: "",
    sobre: "",
  },
}

const tabs = [
  {
    id: "personal",
    title: "Informações pessoais",
    requiredFields: ["nome", "email", "telefone", "nascimento", "sexo", "estado", "cidade", "curso"],
  },
  { id: "skills", title: "Área de interesse", requiredFields: [] },
  { id: "questions", title: "Perguntas técnicas", requiredFields: [] },
]

// Elementos do DOM
const navIcons = document.querySelectorAll(".nav-icon")
const tabContents = document.querySelectorAll(".tab-content")
const navLabels = document.querySelectorAll(".nav-label")
const progressFill = document.querySelector(".progress-fill")
const btnBack = document.getElementById("btnBack")
const btnNext = document.getElementById("btnNext")
const btnNextText = document.getElementById("btnNextText")
const form = document.getElementById("devmenthors-form")
const thankYouScreen = document.getElementById("thankYouScreen")
const mainContainer = document.getElementById("mainContainer")
const btnQuestionBack = document.getElementById("btnQuestionBack")
const btnQuestionNext = document.getElementById("btnQuestionNext")

function getAllQuestions() {
  if (!formState.selectedArea) return []
  const area = technicalQuestions[formState.selectedArea]
  return [...area.facil, ...area.media, ...area.dificil]
}

function renderCurrentQuestion() {
  const allQuestions = getAllQuestions()
  const currentQuestion = allQuestions[formState.currentQuestionIndex]

  if (!currentQuestion) return

  const questionCounter = document.getElementById("questionCounter")
  const questionsTitle = document.getElementById("questionsTitle")
  const questionContent = document.getElementById("questionContent")
  const questionProgressFill = document.querySelector(".question-progress-fill")

  // Atualizar título e contador
  questionsTitle.textContent = `Perguntas Técnicas - ${formState.selectedArea}`
  questionCounter.textContent = `Pergunta ${formState.currentQuestionIndex + 1} de 6`

  // Atualizar barra de progresso das perguntas
  const questionProgress = ((formState.currentQuestionIndex + 1) / 6) * 100
  questionProgressFill.style.width = `${questionProgress}%`

  // Determinar nível da pergunta
  let level = "Fácil"
  if (formState.currentQuestionIndex >= 2 && formState.currentQuestionIndex < 4) {
    level = "Médio"
  } else if (formState.currentQuestionIndex >= 4) {
    level = "Difícil"
  }

  // Renderizar pergunta
  questionContent.innerHTML = `
    <div class="question-level">Nível: ${level}</div>
    <h3 class="question-text">${currentQuestion.question}</h3>
    <div class="question-options">
      ${currentQuestion.options
        .map(
          (option, index) => `
        <button type="button" class="question-option ${formState.userAnswers[formState.currentQuestionIndex] === index ? "selected" : ""}" data-answer="${index}">
          <div class="question-option-letter">${String.fromCharCode(65 + index)}</div>
          <span class="question-option-text">${option}</span>
        </button>
      `,
        )
        .join("")}
    </div>
  `

  // Adicionar event listeners para as opções
  const optionButtons = questionContent.querySelectorAll(".question-option")
  optionButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const answerIndex = Number.parseInt(button.dataset.answer)
      handleAnswerQuestion(answerIndex)
    })
  })

  // Mostrar botão "Anterior" se não estiver na primeira pergunta
  if (formState.currentQuestionIndex > 0) {
    btnQuestionBack.style.display = "flex"
  } else {
    btnQuestionBack.style.display = "none"
  }

  // Mostrar botão "Próxima" se já respondeu a pergunta atual e não está na última
  if (formState.userAnswers[formState.currentQuestionIndex] !== undefined && formState.currentQuestionIndex < 5) {
    btnQuestionNext.style.display = "flex"
  } else {
    btnQuestionNext.style.display = "none"
  }
}

function handleAnswerQuestion(answerIndex) {
  formState.userAnswers[formState.currentQuestionIndex] = answerIndex

  // Atualizar a visualização para destacar a resposta selecionada
  const optionButtons = document.querySelectorAll(".question-option")
  optionButtons.forEach((button, index) => {
    if (index === answerIndex) {
      button.classList.add("selected")
    } else {
      button.classList.remove("selected")
    }
  })

  if (formState.currentQuestionIndex < 5) {
    btnQuestionNext.style.display = "flex"
  }

  // Atualizar progresso e botão principal
  updateProgress()
  updateNextButton()

  // Se todas as perguntas foram respondidas, mostrar botão Finalizar
  if (formState.userAnswers.length === 6 && formState.userAnswers.every((answer) => answer !== undefined)) {
    btnNext.style.display = "flex"
    btnNextText.textContent = "Finalizar"
  }
}

function validateTab(tabId) {
  const tab = tabs.find((t) => t.id === tabId)
  if (!tab) return false

  if (tabId === "skills") {
    return formState.selectedArea !== ""
  }

  if (tabId === "questions") {
    return formState.userAnswers.length === 6
  }

  return tab.requiredFields.every((field) => {
    const value = formState.formData[field]
    return value && value.trim() !== ""
  })
}

// Atualizar progresso
function updateProgress() {
  const currentIndex = tabs.findIndex((t) => t.id === formState.activeTab)
  const isCurrentTabComplete = validateTab(formState.activeTab)

  let progress
  if (isCurrentTabComplete) {
    progress = ((currentIndex + 1) / tabs.length) * 100
  } else {
    const baseProgress = (currentIndex / tabs.length) * 100
    const segmentProgress = (1 / tabs.length) * 100
    progress = baseProgress + segmentProgress / 2
  }

  progressFill.style.width = `${progress}%`
}

// Atualizar status das abas
function updateTabStatus() {
  const currentIndex = tabs.findIndex((t) => t.id === formState.activeTab)

  navLabels.forEach((label, index) => {
    const title = label.querySelector(".nav-label-title")
    const status = label.querySelector(".nav-label-status")

    if (index < currentIndex) {
      title.classList.add("active")
      status.textContent = "Completo"
      status.classList.remove("in-progress")
      status.classList.add("completed")
    } else if (index === currentIndex) {
      title.classList.add("active")
      status.textContent = "Em progresso"
      status.classList.add("in-progress")
      status.classList.remove("completed")
    } else {
      title.classList.remove("active")
      status.textContent = "Pendente"
      status.classList.remove("in-progress", "completed")
    }
  })
}

// Atualizar ícones de navegação
function updateNavIcons() {
  const currentIndex = tabs.findIndex((t) => t.id === formState.activeTab)

  navIcons.forEach((icon, index) => {
    icon.classList.remove("active", "completed")

    if (index < currentIndex) {
      icon.classList.add("completed")
    } else if (index === currentIndex) {
      icon.classList.add("active")
    }
  })
}

function changeTab(tabId) {
  formState.activeTab = tabId

  // Atualizar conteúdo das abas
  tabContents.forEach((content) => {
    content.classList.remove("active")
    if (content.dataset.tab === tabId) {
      content.classList.add("active")
    }
  })

  // Se mudou para aba de perguntas, renderizar primeira pergunta
  if (tabId === "questions" && formState.userAnswers.length === 0) {
    renderCurrentQuestion()
  }

  // Atualizar botões
  if (tabId === "personal") {
    btnBack.style.display = "none"
  } else if (tabId === "questions") {
    btnBack.style.display = "none"
  } else {
    btnBack.style.display = "flex"
  }

  if (tabId === "questions" && formState.userAnswers.length === 6) {
    btnNextText.textContent = "Finalizar"
  } else {
    btnNextText.textContent = "Next"
  }

  // Esconder botão Next na aba de perguntas até responder todas
  if (tabId === "questions") {
    if (formState.userAnswers.length < 6) {
      btnNext.style.display = "none"
    } else {
      btnNext.style.display = "flex"
    }
  } else {
    btnNext.style.display = "flex"
  }

  // Atualizar estado visual
  updateNavIcons()
  updateTabStatus()
  updateProgress()
  updateNextButton()
}

// Atualizar botão Next
function updateNextButton() {
  const isValid = validateTab(formState.activeTab)
  btnNext.disabled = !isValid

  // Mostrar botão Next na aba de perguntas se todas foram respondidas
  if (formState.activeTab === "questions" && formState.userAnswers.length === 6) {
    btnNext.style.display = "flex"
  }
}

form.addEventListener("input", (e) => {
  const field = e.target.name
  const value = e.target.value

  if (field && formState.formData.hasOwnProperty(field)) {
    formState.formData[field] = value
    updateProgress()
    updateNextButton()
  }
})

form.addEventListener("change", (e) => {
  if (e.target.name === "selectedArea") {
    formState.selectedArea = e.target.value
    updateProgress()
    updateNextButton()
  }
})

// Event listeners para navegação
navIcons.forEach((icon, index) => {
  icon.addEventListener("click", () => {
    const tabId = icon.dataset.tab
    const currentIndex = tabs.findIndex((t) => t.id === formState.activeTab)

    // Permitir navegação apenas para abas anteriores ou se a aba atual estiver válida
    if (index <= currentIndex || validateTab(formState.activeTab)) {
      changeTab(tabId)
    }
  })
})

btnBack.addEventListener("click", () => {
  const currentIndex = tabs.findIndex((t) => t.id === formState.activeTab)
  if (currentIndex > 0) {
    const previousTab = tabs[currentIndex - 1].id
    // Não permitir voltar para aba de perguntas
    if (previousTab === "questions") {
      changeTab(tabs[currentIndex - 2].id)
    } else {
      changeTab(previousTab)
    }
  }
})

btnNext.addEventListener("click", async (e) => {
  const currentIndex = tabs.findIndex((t) => t.id === formState.activeTab)

  if (formState.activeTab === "questions" && formState.userAnswers.length === 6) {

    e.preventDefault();
    // Finalizar formulário e mostrar tela de agradecimento
    console.log("Formulário enviado:", formState.formData)
    console.log("Área selecionada:", formState.selectedArea)
    console.log("Respostas:", formState.userAnswers)

    const payload = {
      formData: formState.formData,
      selectedArea: formState.selectedArea,
      userAnswers: formState.userAnswers,
    };

    console.log("Enviando payload:", payload);

    try {
      const response = await axios.post('http://127.0.0.1:8000/api/submit-quiz', payload);
      console.log(response.data.message);
      thankYouScreen.style.display = "flex";
      mainContainer.style.display = "none";
      return;
    } catch (error) {
      console.error("Erro ao enviar formulário:", error);
      console.log("ERROR MESSAGE:", error.response?.data || error.message);
      if (error.response && error.response.data && error.response.data.errors) {
        alert("Erro de validação: " + JSON.stringify(error.response.data.errors));
      } else if (error.response && error.response.data && error.response.data.error) {
        alert("Erro: " + error.response.data.error);
      } else {
        alert("Houve um erro inesperado. Tente novamente.");
      }
    }
  } else if (validateTab(formState.activeTab) && currentIndex < tabs.length - 1) {
    changeTab(tabs[currentIndex + 1].id)
  }
})  

btnQuestionBack.addEventListener("click", () => {
  if (formState.currentQuestionIndex > 0) {
    formState.currentQuestionIndex--
    renderCurrentQuestion()
  }
})

btnQuestionNext.addEventListener("click", () => {
  if (formState.currentQuestionIndex < 5) {
    formState.currentQuestionIndex++
    renderCurrentQuestion()
  }
})

updateProgress()
updateTabStatus()
updateNextButton()
