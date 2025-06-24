<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="TipoColeta",
 *     type="object",
 *     required={"id_tipo_coleta", "nome"},
 *     @OA\Property(property="id_tipo_coleta", type="integer", example=1),
 *     @OA\Property(property="nome", type="string", example="Alimento"),
 *      @OA\Property(property="descricao", type="string", example="Qualquer tipo de vestimenta")
 * )
 */
class TipoColeta extends Model {
    protected $table = 'tipos_coleta';
    protected $primaryKey = 'id_tipo_coleta';
    public $timestamps = false;

    protected $fillable = ['nome'];

    protected $casts = [
        'id_tipo_coleta' => 'integer',
        'nome' => 'string',
    ];

    public function instituicoes() {
        return $this->belongsToMany(Instituicao::class, 'instituicao_tipos_coleta', 'id_tipo_coleta', 'id_instituicao');
    }
}
