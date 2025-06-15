<?php
#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
#error_reporting(E_ALL);
header('Content-Type: application/json');

require_once 'config/db.php';

// models e controllers
require_once __DIR__ . '/models/Instituicao.php';
require_once __DIR__ . '/models/Usuario.php';
require_once __DIR__ . '/models/TipoColeta.php';
require_once __DIR__ . '/models/HorariosFuncionamento.php';

require_once __DIR__ . '/controllers/InstituicaoController.php';
require_once __DIR__ . '/controllers/UsuarioController.php';
require_once __DIR__ . '/controllers/TipoColetaController.php';


require_once __DIR__ . '/enums/TipoServico.php';

$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// caminho base da API
$basePath = '/api';

// Remove o basePath da URL
$rota = trim(substr($requestPath, strlen($basePath)), '/');

// Separa a rota em partes (ex: ['instituicoes', '3'])
$partes = explode('/', $rota);
$recurso = $partes[0] ?? '';
$id = $partes[1] ?? null;

// Roteamento
switch ($recurso) {
    case 'instituicoes':
        $controller = new InstituicaoController();
        if ($id) {
            $controller->show($id);
        } else {
            $controller->index();
        }
        break;

    case 'usuarios':
        $controller = new UsuarioController();
        if ($id) {
            $controller->show($id);
        } else {
            $controller->index();
        }
        break;

    case 'tipos-coleta':
        $controller = new TipoColetaController();
        if ($id) {
            $controller->show($id);
        } else {
            $controller->index();
        }
        break;

    case '':
        echo json_encode(['status' => 'online', 'mensagem' => 'API funcionando'], JSON_UNESCAPED_UNICODE);
        break;

    default:
        http_response_code(404);
        echo json_encode(['status' => 'error', 'mensagem' => 'Rota não encontrada'], JSON_UNESCAPED_UNICODE);
        break;
}
