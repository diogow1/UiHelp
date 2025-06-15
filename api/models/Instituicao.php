<?php

use Illuminate\Database\Eloquent\Model;

class Instituicao extends Model {
    protected $table = 'instituicoes';
    protected $primaryKey = 'id_instituicao';
    public $timestamps = false;

    protected $casts = [
        'tipo_servico' => 'string',
    ];

    public function usuario() {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function tiposColeta() {
        return $this->belongsToMany(TipoColeta::class, 'instituicao_tipos_coleta', 'id_instituicao', 'id_tipo_coleta');
    }

    public function horariosFuncionamento() {
        return $this->hasMany(HorariosFuncionamento::class, 'id_instituicao', 'id_instituicao');
    }

    //Tipo de servico ENUM
    public function setTipoServicoAttribute($tipo) {
        if (!in_array($tipo, TipoServico::all())) {
            throw new InvalidArgumentException("Tipo de serviço inválido");
        }
        $this->attributes['tipo_servico'] = $tipo;
    }

    public function getTipoServicoAttribute($value) {
        if (!in_array($value, TipoServico::all())) {
            return null; // ou valor default
        }
        return $value;
    }
}
