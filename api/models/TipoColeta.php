<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="TipoColeta",
 *     type="object",
 *     required={"id_tipo_coleta", "nome"},
 *     @OA\Property(property="id_tipo_coleta", type="integer", example=1),
 *     @OA\Property(property="nome", type="string", example="Papel")
 * )
 */
class TipoColeta extends Model {
    protected $table = 'tipos_coleta';
    protected $primaryKey = 'id_tipo_coleta';
    public $timestamps = false;

    public function instituicoes() {
        return $this->belongsToMany(Instituicao::class, 'instituicao_tipos_coleta', 'id_tipo_coleta', 'id_instituicao');
    }
}
?>