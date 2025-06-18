<?php
namespace App\Controllers;
use App\Models\Instituicao;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Instituições",
 *     description="Documentação da API"
 * )
 */

/**
 * @OA\Tag(
 *     name="Instituições",
 *     description="Operações relacionadas às instituições"
 * )
 */

class InstituicaoController {


    /**
     * @OA\Get(
     *     path="/api/instituicoes",
     *     tags={"Instituições"},
     *     summary="Listar todas as instituições",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de instituições"
     *     )
     * )
     */
    public function index() {
        $instituicoes = Instituicao::with(['usuario', 'tiposColeta', 'horariosFuncionamento'])->get();
        header('Content-Type: application/json');
        echo json_encode($instituicoes, JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * @OA\Get(
     *     path="/api/instituicoes/{id}",
     *     tags={"Instituições"},
     *     summary="Obter uma instituição pelo ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados da instituição"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Instituição não encontrada"
     *     )
     * )
     */

    public function show($id) {
        $instituicao = Instituicao::with(['usuario', 'tiposColeta', 'horariosFuncionamento'])->find($id);
        header('Content-Type: application/json');
        if ($instituicao) {
            echo json_encode($instituicao, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(['erro' => 'Instituição não encontrada'], JSON_UNESCAPED_UNICODE);
        }
    }
}
