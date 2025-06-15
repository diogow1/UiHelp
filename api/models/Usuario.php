<?php
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model {
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; // não tem created_at updated_at

    protected $hidden = ['password']; // não retorna a senha
}
