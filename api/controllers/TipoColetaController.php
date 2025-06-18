<?php 
namespace App\Controllers;
use App\Models\TipoColeta;
/**
 * @OA\Tag(
 *     name="Tipos de Coleta",
 *     description="Operações relacionadas aos tipos de coleta"
 * )
 */

class TipoColetaController {

    /**
     * @OA\Get(
     *     path="/api/tipos-coleta",
     *     tags={"Tipos de Coleta"},
     *     summary="Listar todos os tipos de coleta",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tipos de coleta",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TipoColeta"))
     *     )
     * )
     */
    public function index() {
        $tipos = TipoColeta::all();
        header('Content-Type: application/json');
        echo json_encode($tipos);
    }
        /**
     * @OA\Get(
     *     path="/api/tipos-coleta/{id}",
     *     tags={"Tipos de Coleta"},
     *     summary="Obter um tipo de coleta pelo ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do tipo de coleta",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados do tipo de coleta",
     *         @OA\JsonContent(ref="#/components/schemas/TipoColeta")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de coleta não encontrado"
     *     )
     * )
     */
    
    public function show($id) {
        $tipo = TipoColeta::find($id);
        header('Content-Type: application/json');
        if ($tipo) {
            echo json_encode($tipo);
        } else {
            http_response_code(404);
            echo json_encode(['erro' => 'Tipo de coleta não encontrado'], JSON_UNESCAPED_UNICODE);
        }
    }
}
