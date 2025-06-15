<?php

use Illuminate\Database\Eloquent\Model;

class TipoColeta extends Model {
    protected $table = 'tipos_coleta';
    protected $primaryKey = 'id_tipo_coleta';
    public $timestamps = false;

    public function instituicoes() {
        return $this->belongsToMany(Instituicao::class, 'instituicao_tipos_coleta', 'id_tipo_coleta', 'id_instituicao');
    }
}
?>