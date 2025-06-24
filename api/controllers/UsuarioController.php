<?php
namespace App\Controllers;

use App\Models\Usuario;

/**
 * @OA\Tag(
 *     name="Usuários",
 *     description="Operações relacionadas aos usuários"
 * )
 */
class UsuarioController {

    /**
     * @OA\Get(
     *     path="/api/usuarios",
     *     tags={"Usuários"},
     *     summary="Listar todos os usuários",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Usuario")
     *         )
     *     )
     * )
     */
    public function index() {
        header('Content-Type: application/json; charset=utf-8');
        $usuarios = Usuario::all();
        echo json_encode($usuarios, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @OA\Get(
     *     path="/api/usuarios/{id}",
     *     tags={"Usuários"},
     *     summary="Obter um usuário pelo ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados do usuário",
     *         @OA\JsonContent(ref="#/components/schemas/Usuario")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="erro", type="string", example="Usuário não encontrado")
     *         )
     *     )
     * )
     */
    public function show($id) {
        header('Content-Type: application/json; charset=utf-8');
        $usuario = Usuario::find($id);
        if ($usuario) {
            echo json_encode($usuario, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(['erro' => 'Usuário não encontrado'], JSON_UNESCAPED_UNICODE);
        }
    }
}
