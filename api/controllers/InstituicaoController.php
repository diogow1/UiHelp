<?php

class InstituicaoController {

    public function index() {
        $instituicoes = Instituicao::with(['usuario', 'tiposColeta', 'horariosFuncionamento'])->get();
        header('Content-Type: application/json');
        echo json_encode($instituicoes, JSON_UNESCAPED_UNICODE);
    }

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
