<?php
    session_start();
    require_once '../phpConfig.php';
    require_once BASE_PATH . 'models/banco.service.class.php';
    require_once BASE_PATH . 'models/disciplina.service.class.php';
    require_once BASE_PATH . 'models/usuario.service.class.php';
    require_once BASE_PATH . 'models/auth.service.class.php';
    
    $oUsuario = new Usuario();
    $oDiscplina = new Disciplina();
    $oAuth = new Auth();
    
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

    if($acao == 'buscar_disciplinas'){
        
    }
?>
<body>
    <main>
        <form action="" id="form1">
            <input type="hidden" name="acao" id="acao" value="">
            <input type="hidden" name="tempo_inicial" id="tempo_inicial" value="">
            <input type="hidden" name="modo" id="modo" value="cron">
            <div class="row">
                <div class="container col-3">
                    <select name="disciplina_id" id="disciplina_id">
                        <option value="">Selecione uma disciplina</option>
                        <?
                            foreach($disciplinas_usuario['items'] as $disciplina)
                            {?>
                                <option value="<?= $disciplina['id_disciplina'] ?>"><?= $disciplina['nome'] ?></option>
                            <?}
                        ?>
                    </select>
                </div>
                <div class="container col-6">
                    <div class="cronometro-container">
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-info" id="btnCronometro">Cronômetro</button>
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
                    </div>
                </div>
                <div class="container col-3">
                    <h4>Últimos Estudos</h4>
                    <?
                        foreach($ultimos_estudos['items'] as $estudo)
                        {?>
                            <div class="estudo-item">
                                <strong><?= $estudo['nome'] ?></strong><br>
                                Início: <?= date('d/m/Y H:i:s', strtotime($estudo['dia_hora_inicio'])) ?><br>
                                Fim: <?= date('d/m/Y H:i:s', strtotime($estudo['dia_hora_fim'])) ?><br>
                                Duração: <?= gmdate('H:i:s', strtotime($estudo['dia_hora_fim']) - strtotime($estudo['dia_hora_inicio'])) ?>
                            </div>
                        <?}
                    ?>
                </div>
            </div>
        </form>
    </main>
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
