<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="HorariosFuncionamento",
 *     type="object",
 *     required={"id", "id_instituicao", "dia_inicio", "dia_fim", "abertura", "fechamento"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="id_instituicao", type="integer", example=1),
 *     @OA\Property(property="dia_inicio", type="string", example="Segunda-feira"),
 *     @OA\Property(property="dia_fim", type="string", example="Sexta-feira"),
 *     @OA\Property(property="abertura", type="string", format="time", example="08:00"),
 *     @OA\Property(property="fechamento", type="string", format="time", example="18:00")
 * )
 */
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