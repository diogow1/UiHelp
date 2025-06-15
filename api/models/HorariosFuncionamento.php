<?php 
use Illuminate\Database\Eloquent\Model;

class HorariosFuncionamento extends Model {
    protected $table = 'horarios_funcionamento';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_instituicao',
        'dia_inicio',
        'dia_fim',
        'abertura',
        'fechamento'
    ];

    public function instituicao() {
        return $this->belongsTo(Instituicao::class, 'id_instituicao', 'id_instituicao');
    }
}

?>