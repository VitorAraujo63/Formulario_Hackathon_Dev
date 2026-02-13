@extends('layouts.app')

@section('content')
<div class="ecosystem-container" style="max-width: 800px; margin: 50px auto; padding: 40px; background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center;">
    <h1 style="color: #2563eb; font-size: 2.5rem;">Bem-vindo ao Ecossistema DevMenthors</h1>
    <p style="font-size: 1.2rem; color: #64748b; margin-bottom: 30px;">
        Você deu o primeiro passo no Hackathon, mas a jornada não para por aqui.
    </p>

    <div class="presentation-content" style="text-align: left; line-height: 1.8; color: #475569;">
        <h3>O que é o projeto?</h3>
        <p>O DevMenthors é uma aceleradora de talentos que conecta o aprendizado acadêmico com as demandas reais do mercado de trabalho.</p>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 30px 0;">
            <div style="background: #f8fafc; padding: 20px; border-radius: 12px;">
                <h4 style="margin: 0; color: #1e293b;">Mentorias</h4>
                <p style="font-size: 0.9rem;">Encontros semanais com devs seniores do mercado.</p>
            </div>
            <div style="background: #f8fafc; padding: 20px; border-radius: 12px;">
                <h4 style="margin: 0; color: #1e293b;">Networking</h4>
                <p style="font-size: 0.9rem;">Canal direto com empresas parceiras em busca de novos talentos.</p>
            </div>
        </div>
    </div>

    <hr style="margin: 40px 0; opacity: 0.1;">

    <div class="cta-section">
        <h3>Pronto para se tornar um Aluno Oficial?</h3>
        <p>Escolha como deseja prosseguir com sua matrícula:</p>
        
        <div style="display: grid; gap: 15px; margin-top: 20px;">
            <button onclick="confirmarUsoDeDados()" style="background: #16a34a; color: white; border: none; padding: 20px; border-radius: 10px; font-weight: bold; cursor: pointer; font-size: 1.1rem;">
                Quero ser aluno usando meus dados do Hackathon
            </button>

            <a href="{{ url('/inscricao-aluno') }}" style="background: #f1f5f9; color: #475569; padding: 15px; border-radius: 10px; text-decoration: none; font-weight: bold;">
                Preencher um novo formulário de aluno
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmarUsoDeDados() {
        const dados = sessionStorage.getItem('dados_inscricao_hackathon');
        
        if (!dados) {
            Swal.fire('Aviso', 'Não encontramos seus dados recentes. Por favor, preencha o formulário manual.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Usar dados anteriores?',
            text: "Podemos utilizar seu Nome, E-mail, CPF e Telefone informados no formulário do Hackathon para te matricular?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sim, pode usar!',
            cancelButtonText: 'Não, cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                inscreverComoAlunoAutomatico();
            }
        });
    }

    async function inscreverComoAlunoAutomatico() {
    const dadosHackathon = JSON.parse(sessionStorage.getItem('dados_inscricao_hackathon'));

    try {
        const response = await axios.post("{{ route('aluno.register_ecosystem') }}", { 
            formData: dadosHackathon 
        });
        
        Swal.fire({
            title: 'Sucesso!',
            text: response.data.message || 'Você agora é um aluno DevMenthors!',
            icon: 'success'
        }).then(() => {
            sessionStorage.removeItem('dados_inscricao_hackathon');
            window.location.href = "{{ url('/') }}";
        });
    } catch (error) {
        console.error(error);
        if (error.response && error.response.status === 422) {
            Swal.fire('Aviso', error.response.data.message, 'info');
        } else {
            Swal.fire('Erro', 'Houve um problema ao processar seu cadastro. Verifique se você preencheu o CPF no formulário.', 'error');
        }
    }
}
</script>
@endsection