class Participante extends Model
{
    protected $table = 'form_submissions';

    protected $fillable = [
        'nome',
        'email',
        'cpf', 
        'telefone',
        'nascimento',
        'sexo',
        'estado',
        'cidade',
        'curso',
        'linkedin',
        'sobre',
        'nome_responsavel',
        'cpf_responsavel', 
        'telefone_responsavel' 
    ];
}

