<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Usuario",
 *     type="object",
 *     required={"id_usuario", "nome", "email"},
 *     @OA\Property(property="id_usuario", type="integer", example=1),
 *     @OA\Property(property="nome", type="string", example="Usuario"),
 *     @OA\Property(property="email", type="string", format="email", example="usuario@email.com")
 * )
 */
class Usuario extends Model {
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = ['nome', 'email'];
    protected $hidden = ['password'];

    protected $casts = [
        'email' => 'string',
    ];
}
