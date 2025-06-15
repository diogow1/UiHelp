<?php

class UsuarioController {

    public function index() {
        $usuarios = Usuario::all();
        header('Content-Type: application/json');
        echo json_encode($usuarios);
    }

    public function show($id) {
        $usuario = Usuario::find($id);
        header('Content-Type: application/json');
        if ($usuario) {
            echo json_encode($usuario);
        } else {
            http_response_code(404);
            echo json_encode(['erro' => 'Usuário não encontrado'], JSON_UNESCAPED_UNICODE);
        }
    }
}
