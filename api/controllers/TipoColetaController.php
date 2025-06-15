<?php 

class TipoColetaController {
    
    public function index() {
        $tipos = TipoColeta::all();
        header('Content-Type: application/json');
        echo json_encode($tipos);
    }

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
