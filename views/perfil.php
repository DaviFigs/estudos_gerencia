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



$total_sessoes = array_sum(array_column($estatisticas_disciplinas['items'], 'total_sessoes'));
$total_segundos = array_sum(array_column($estatisticas_disciplinas['items'], 'total_segundos'));
$nome =  $dados_usuario['items']['nome'];
$email =  $dados_usuario['items']['email'];
$ultimo_login =  $dados_usuario['items']['ultimo_login'];


$titulo = 'Perfil: ' . $_SESSION['user_name'];

include BASE_PATH . 'base/head.php';
include BASE_PATH . 'base/header.php';
?>

<main class="perfil-container">
    <div class="perfil-header" style="background: <?=$disciplinas_usuario['items'][0]['cor'] ?> ">
        <div class="avatar-section">

            <div class="avatar">
                <img src="../static/imagens/<?= $dados_usuario['items']['url_imagem'] ?>">
            </div>

            <h1><?= htmlspecialchars($nome) ?></h1>

        </div>
    </div>

    <div class="perfil-content">
        <!-- Card Principal -->
        <div class="perfil-card">
            <div class="card-section">
                <h3>Informações Pessoais</h3>
                <div class="info-grid">
                    <div class="info-item" style="border-left:4px solid <?=$disciplinas_usuario['items'][0]['cor'] ?>;">
                        <label>📧 Email</label>
                        <p><?= htmlspecialchars($email) ?></p>
                    </div>
                    <div class="info-item" style="border-left:4px solid <?=$disciplinas_usuario['items'][0]['cor'] ?>;">
                        <label>🕐 Último Login</label>
                        <p><?= $ultimo_login ? date('d/m/Y H:i:s', strtotime($ultimo_login)) : 'Nunca' ?></p>
                    </div>
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="card-section">
                <h3>📊 Estatísticas de Estudo</h3>
                <div class="stats-grid">
                    <div class="stat-card" style="background: <?=$disciplinas_usuario['items'][0]['cor'] ?>">
                        <div class="stat-number"><?= $estatisticas_disciplinas['total'] ?></div>
                        <div class="stat-label">Disciplinas</div>
                    </div>
                    <div class="stat-card" style="background: <?=$disciplinas_usuario['items'][0]['cor'] ?>">
                        <div class="stat-number"><?= $total_sessoes ?></div>
                        <div class="stat-label">Sessões de Estudo</div>
                    </div>
                    <div class="stat-card" style="background: <?=$disciplinas_usuario['items'][0]['cor'] ?>">
                        <div class="stat-number"><?=$oTools->segundosParaHorario($total_segundos)?></div>
                        <div class="stat-label">Tempo Total</div>
                    </div>
                </div>
            </div>

            <!-- Disciplinas -->
            <?php if (!empty($disciplinas_usuario['items'])): ?>
            <div class="card-section">
                <h3>📚 Minhas Disciplinas</h3>
                <div class="disciplinas-list">
                    <?php foreach ($disciplinas_usuario['items'] as $disciplina): ?>
                        <div class="disciplina-badge" style="border-left: 5px solid <?= htmlspecialchars($disciplina['cor'] ?? '#3b82f6') ?>">
                            <span class="badge-color" style="background-color: <?= htmlspecialchars($disciplina['cor'] ?? '#3b82f6') ?>"></span>
                            <span><?= htmlspecialchars($disciplina['nome']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include BASE_PATH . 'base/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../static/js/tools.js"></script>
<script src="../static/js/perfil.js"></script>