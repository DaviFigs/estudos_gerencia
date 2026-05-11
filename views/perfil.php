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

$titulo = 'Perfil: ' . $_SESSION['user_name'];

include BASE_PATH . 'base/head.php';
include BASE_PATH . 'base/header.php';
?>

<main class="d-flex justify-content-center align-items-center text-center" style="min-height: 80vh;">
    <div>
        <h1 class="fw-bold">Página em Desenvolvimento</h1>

        <h2 class="text-muted">
            Acalme-se <?= $_SESSION['user_name'] ?>!
            <br>
            <a href="home.php">Voltar</a>
        </h2>
    </div>
</main>

<?php include BASE_PATH . 'base/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../static/js/tools.js"></script>
<script src="../static/js/perfil.js"></script>