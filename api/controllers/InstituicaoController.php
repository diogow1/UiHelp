<?php
namespace App\Controllers;
use App\Models\Instituicao;

/**
 * @OA\Info(
 *     version="1.0.2",
 *     title="Instituições",
 *     description="Documentação da API"
 * )
 */

/**
 * @OA\Tag(
 *     name="Instituições",
 *     description="Operações de instituições"
 * )
 */

class InstituicaoController {

   /**
     * @OA\Get(
     *     path="/api/instituicoes",
     *     tags={"Instituições"},
     *     summary="Listar todas as instituições ou filtrar por UF, cidade, bairro e tipo de coleta",
     *     @OA\Parameter(
     *         name="uf",
     *         in="query",
     *         required=false,
     *         description="Sigla do estado (UF)",
     *         @OA\Schema(type="string", example="SC")
     *     ),
     *     @OA\Parameter(
     *         name="cidade",
     *         in="query",
     *         required=false,
     *         description="Nome da cidade",
     *         @OA\Schema(type="string", example="Palhoça")
     *     ),
     *     @OA\Parameter(
     *         name="bairro",
     *         in="query",
     *         required=false,
     *         description="Nome do bairro",
     *         @OA\Schema(type="string", example="Ponte do Imaruim")
     *     ),
     *     @OA\Parameter(
     *         name="tipo_coleta",
     *         in="query",
     *         required=false,
     *         description="Um ou mais tipos de coleta (separados por vírgula)",
     *         @OA\Schema(type="string", example="Roupas,Alimentos")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de instituições filtradas ou completas",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Instituicao"))
     *     )
     * )
     */
    public function index() {
        $query = Instituicao::with(['usuario', 'tiposColeta', 'horariosFuncionamento']);

        if (isset($_GET['uf']) && !empty($_GET['uf'])) {
            $query->where('uf', strtoupper($_GET['uf']));
        }

        if (isset($_GET['cidade']) && !empty($_GET['cidade'])) {
            $query->where('cidade', 'LIKE', '%' . $_GET['cidade'] . '%');
        }

        if (isset($_GET['bairro']) && !empty($_GET['bairro'])) {
            $query->where('bairro', 'LIKE', '%' . $_GET['bairro'] . '%');
        }

        if (isset($_GET['tipo_coleta']) && !empty($_GET['tipo_coleta'])) {
            $tipos = array_map('trim', explode(',', $_GET['tipo_coleta']));
            $query->whereHas('tiposColeta', function($q) use ($tipos) {
                $q->whereIn('nome', $tipos);
            });
        }


        $instituicoes = $query->get();

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
     *         description="ID da instituição",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados da instituição",
     *         @OA\JsonContent(ref="#/components/schemas/Instituicao")
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
