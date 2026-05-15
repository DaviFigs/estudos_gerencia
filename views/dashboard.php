<?php
require_once '../phpConfig.php';

require_once BASE_PATH . 'models/banco.service.class.php';
require_once BASE_PATH . 'models/disciplina.service.class.php';
require_once BASE_PATH . 'models/usuario.service.class.php';
require_once BASE_PATH . 'models/auth.service.class.php';
require_once BASE_PATH . 'tools.php';

$oUsuario = new Usuario();
$oDiscplina = new Disciplina();
$oAuth = new Auth();
$oTools = new Tools();

$oAuth->requireLogin();

$mostrar_msg = [
    'tipo' => '',
    'title' => '',
    'msg' => '',
    'acao' => ''
];

$param_user['id_usuario'] = $_SESSION['user_id'] ?? 0;

$disciplinas_usuario = $oDiscplina->listar_disciplinas($param_user);
$estatisticas_disciplinas = $oDiscplina->buscar_estatiscas_disciplina_usuario($param_user);
$dados_usuario = $oUsuario->buscar_dados_usuario($param_user);

$titulo = 'DashBoard: ' . $_SESSION['user_name'];

include BASE_PATH . 'base/head.php';
include BASE_PATH . 'base/header.php';
?>

<div class="container ">
    
    
</div>

<?php include BASE_PATH . 'base/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../static/js/tools.js"></script>
<script src="../static/js/perfil.js"></script>