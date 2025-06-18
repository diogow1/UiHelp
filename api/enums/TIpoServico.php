<?php
namespace App\Enums;

class TipoServico {
    public const COLETA = 'coleta';
    public const DISTRIBUICAO = 'distribuicao';
    public const DISTRIBUICAO_E_COLETA = 'distribuicao_e_coleta';

    public static function all(): array {
        return [
            self::COLETA,
            self::DISTRIBUICAO,
            self::DISTRIBUICAO_E_COLETA,
        ];
    }
}
