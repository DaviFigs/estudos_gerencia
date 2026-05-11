<?php
    session_start();
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
    
    $titulo = 'Home';
    include BASE_PATH . 'base/head.php';
    include BASE_PATH . 'base/header.php';

    
    
    $param['id_usuario'] = $_SESSION['user_id'];
        
        $disciplinas_usuario = $oDiscplina->listar_disciplinas($param);
        $ultimos_estudos = $oDiscplina->listar_ultimos_estudos($param);


    $acao = $_POST['acao'] ?? '';

    if($acao == 'salvar_estudo')
    {
        $param['disciplina_id'] = $_POST['disciplina_id'];
        $param['id_usuario'] = $_SESSION['user_id'];
        $param['duracao'] = $_POST['duracao_estudo'];
        $param['tempo_inicial'] = $_POST['tempo_inicial'];
        $param['tempo_final'] = $_POST['tempo_final'];


        $resultadoDisciplina = $oDiscplina->salvar_estudo($param);

        if($resultadoDisciplina['error'] ==  true){
            $mostrar_msg = [
                'tipo' => 'error',
                'title' => 'Erro',
                'msg' => $resultadoDisciplina['msg'],
                'acao' => 'renew'
            ]; 
        }
        else{
            $mostrar_msg = [
                'tipo' => 'success',
                'title' => 'Sucesso',
                'msg' => $resultadoDisciplina['msg'],
                'acao' => 'renew'
            ]; 
        }
        
    }
?>
<body id="body">
    <main>
        <form action="" id="form1" method="post">
            <input type="hidden" name="acao" id="acao" value="">
            <input type="hidden" name="tempo_inicial" id="tempo_inicial" value="">
            <input type="hidden" name="tempo_final" id="tempo_final" value="">
            <input type="hidden" name="duracao_estudo" id="duracao_estudo">
            <input type="hidden" name="modo" id="modo" value="cron">
            <input type="hidden" name="disciplina_id" id="disciplina_id">

            <div class="row">
                <div class="container col-3">
                    <div class="disciplinas-scroll">
                        <? foreach($disciplinas_usuario['items'] as $disciplina){ ?>
                            <div 
                                class="disciplina-item"
                                data-id="<?= $disciplina['id_disciplina'] ?>"
                                data-cor="<?= $disciplina['cor'] ?>"
                                style="border-left-color: <?= htmlspecialchars($disciplina['cor'] ?? '#3b82f6') ?>">
                                
                                <div class="disciplina-header">
                                    <span class="disciplina-nome"><?= htmlspecialchars($disciplina['nome']) ?></span>
                                    <?= $oTools->segundosParaHorario($disciplina['tempo_de_estudo']) ?>
                                    <span class="disciplina-cor" style="background-color: <?= htmlspecialchars($disciplina['cor'] ?? '#3b82f6') ?>"></span>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
                <div class="container col-6">
                    <div class="cronometro-container">
                        <div class="row">
                            <div class="col-12">
                                <button disabled type="button" class="btn btn-info" id="btnCronometro">Cronômetro</button>
                                <button type="button" class="btn btn-primary" id="btnTemporizador">Temporizador</button>
                            </div>
                        </div>
                        <div class="cronometro-display">
                            <span class="cronometro-tempo"
                                id="cronometro"
                                contenteditable="false">
                                00:00:00
                            </span> 
                        </div>
                        <div class="cronometro-controles">
                            <button type="button" class="btn btn-cronometro btn-iniciar-pausar" id="btnIniciarPausar">▶ Iniciar</button>
                            <button type="button" class="btn btn-cronometro btn-parar" id="btnParar">⏹ Parar</button>
                        </div>
                        <button disabled type="button" class="btn btn-success" id="btnSalvarEstudo">Salvar Estudo</button>
                    </div>
                </div>
                <div class="container col-3">
                    <div class="estudos-scroll">
                        <?
                            foreach($ultimos_estudos['items'] as $estudo)
                            {
                                $data_inicio = strtotime($estudo['data_inicio']);
                                $data_fim = strtotime($estudo['data_fim']);
                                $cor = $estudo['cor']
                            ?>
                                <div class="estudo-item" style="border-left:4px solid <?=$cor?>">
                                    <div class="estudo-header">
                                        <span class="estudo-nome"><?= htmlspecialchars($estudo['nome']) ?></span>
                                        <span class="estudo-data" style="background-color:<?=$cor?>;"><?= date('d/m/Y', $data_inicio) ?></span>
                                    </div>
                                    <div class="estudo-horarios">
                                        <div class="horario">
                                            <span class="time"><?= date('H:i:s', $data_inicio) ?> → <?= date('H:i:s', $data_fim) ?></span>
                                        </div>
                                
                                    </div>
                                    <div class="estudo-duracao" style="background: linear-gradient(135deg, <?=$cor?> 0%, <?=$cor?> 100%);">
                                        <span class="duracao-label">Duração:</span>
                                        <span class="duracao-valor"><?= $oTools->segundosParaHorario($estudo['duracao_segundos']) ?></span>
                                    </div>
                                </div>
                            <?}
                        ?>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <?=include BASE_PATH . 'base/footer.php';?>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../static/js/tools.js"></script>
<script src="../static/js/home.js"></script>

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
