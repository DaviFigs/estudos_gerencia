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

    //verificando sessão
    $oAuth->requireLogin();

    $mostrar_msg = [
        'tipo' => '',
        'title' => '',
        'msg' => '',
        'acao' => ''
    ];
    
    $param_user['id_usuario'] = $_SESSION['user_id'] ?? 0;
    $disciplinas_usuario = $oDiscplina->buscar_estatiscas_disciplina_usuario($param_user);


    $titulo = 'Disciplinas';
    include BASE_PATH . 'base/head.php';
    include BASE_PATH . 'base/header.php';
    
    $acao = $_POST['acao'] ?? '';

    if($acao == 'criar_disciplina'){

        $param['id_usuario'] = $_SESSION['user_id'] ?? 0;
        $param['nome'] = $_POST['nome_disciplina'] ?? '';
        $param['importancia'] = $_POST['importancia'] ?? '';
        $param['cor'] = $_POST['cor'] ?? '';
        $param['descricao'] = $_POST['descricao'] ?? '';
        
        $disciplina_criada = $oDiscplina->criar_disciplina($param);
        if($disciplina_criada['error'] === false)
        {
            $mostrar_msg = [
                'tipo' => 'success',
                'title' => 'Sucesso',
                'msg' => $disciplina_criada['msg'],
                'acao' => 'renew'
            ]; 
        }
        else 
        {
            $mostrar_msg = [
                'tipo' => 'error',
                'title' => 'Erro',
                'msg' => $disciplina_criada['msg'],
                'acao' => 'renew'
            ]; 
        }
    }

    if($acao == 'excluir_disciplina') {
        $param['id_disciplina'] = $_POST['id_disciplina'];
        $disciplinas_usuario = $oDiscplina->excluir_disciplina($param);
    }
?>
<body>
    <main>
        
        <div class="container-fluid">
            
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body text-center py-4">
                    <h3 class="mb-2 fw-semibold text-dark">
                        Gerencie suas disciplinas
                    </h3>
                </div>
            </div>
            <button class="btn btn-outline-dark btn-lg rounded-3 mb-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDisciplina">
                <i class="bi bi-plus-circle me-1"></i> Nova Disciplina
            </button>

            <!-- Grid de Cards -->
            <div class="cards-grid">
                <?php
                    if(!empty($disciplinas_usuario['items'])) {
                        foreach($disciplinas_usuario['items'] as $disciplina) {
                            $cor = $disciplina['cor'] ?? '#667eea';
                            $importancia = strtolower($disciplina['importancia'] ?? '1');
                ?>
                    <div class="card card-disciplina">
                        <div class="card-header" style="background-color: <?= htmlspecialchars($cor) ?>;">
                            <h5 style="color:white;" class="card-title mb-0"><?= htmlspecialchars($oTools->formatar_nome_disciplina($disciplina['nome'])) ?></h5>
                        </div>
                        <div class="card-body">
                            
                            <span class="badge-importancia badge-<?= $importancia ?>">
                                <?php
                                    if($importancia == 3) echo '🔴 Alta';
                                    else if($importancia == 2) echo '🟡 Média';
                                    else echo '🟢 Baixa';
                                ?>
                            </span>
                            
                            <div class="tempo-estudo">
                                Tempo Estudado: <span style="color:<?=$cor?>"><?= $oTools->segundosParaHorario($disciplina['total_segundos']) ?></span><br>
                                Tempo Médio de Estudo: <span style="color:<?=$cor?>"><?= $oTools->segundosParaHorario($disciplina['media_segundos']) ?></span>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    } else {
                ?>
                    <div class="alert alert-info" role="alert">
                        📚 Nenhuma disciplina criada ainda. Clique em "Nova Disciplina" para começar!
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </main>
</body>


<div class="modal fade" id="modalDisciplina" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Nova Disciplina</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="formDisciplina" method="post">
            <input type="hidden" name="acao" id="acao" value="">
            <!-- Nome -->
            <div class="form-floating mb-3">
            <input type="text" name="nome_disciplina" class="form-control" id="nome_disciplina" placeholder="Nome da disciplina">
            <label for="nome_disciplina">Nome da disciplina</label>
            </div>

            <!-- Descrição -->
            <div class="form-floating mb-3">
            <textarea name="descricao" class="form-control" id="descricao" style="height: 100px;" placeholder="Descrição"></textarea>
            <label for="descricao">Descrição</label>
            </div>

            <!-- Importância -->
            <div class="mb-3">
            <label for="importancia" class="form-label">Importância</label>
            <select name="importancia" id="importancia" class="form-select">
                <option value="">Selecione</option>
                <option value="alta">🔴 Alta</option>
                <option value="média">🟡 Média</option>
                <option value="baixa">🟢 Baixa</option>
            </select>
            </div>

            <!-- Cor -->
            <div class="mb-3">
            <label for="cor" class="form-label">Cor da disciplina</label>
            <div class="d-flex align-items-center gap-2">
                <input type="color" name="cor" id="cor" class="form-control form-control-color">
                <span class="text-muted small">Escolha uma cor</span>
            </div>
            </div>

        </form>
        </div>

      <div class="modal-footer">
        <button class="btn btn-success" id="btnCriarDisciplina">Salvar</button>
      </div>

    </div>
  </div>
</div>

<?=include BASE_PATH . 'base/footer.php';?>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../static/js/tools.js"></script>
<script src="../static/js/disciplinas.js"></script>

<script>
    <?php
        if(!empty($mostrar_msg['msg']))
        {
    ?>
            mostrarMensagem(
                '<?= $mostrar_msg['tipo'] ?>',
                '<?= $mostrar_msg['title'] ?>',
                '<?= addslashes($mostrar_msg['msg']) ?>',
                '<?= $mostrar_msg['acao'] ?>'
            );
    <?php
        }
    ?>
</script>
