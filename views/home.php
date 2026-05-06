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
    
    $acao = $_POST['acao'] ?? '';

    if($acao == 'login'){
        $param['email'] = $_POST['email'] ?? '';
        $param['senha'] = $_POST['password'] ?? '';
        
        $login = $oUsuario->login($param);
        if($login['error'] === false)
        {
            $usuario = $login['item'];
            session_start();
            $_SESSION['user_id'] = $usuario['id_usuario'];
            $_SESSION['user_name'] = $usuario['nome'];
            $_SESSION['user_email'] = $usuario['email'];
            $_SESSION['logged'] = true;
            $_SESSION['last_activity'] = time();

            $mostrar_msg = [
                'tipo' => 'success',
                'title' => 'Sucesso',
                'msg' => $login['msg'],
                'acao' => 'redirect'
            ]; 
        }
        else 
        {
            $mostrar_msg = [
                'tipo' => 'error',
                'title' => 'Erro',
                'msg' => $login['msg'],
                'acao' => 'renew'
            ]; 
        }
    }
?>
<body>
    <main>
            <h1>
                <?= $_SESSION['user_name'] ?? 'Sem sessão' ?> -
                <?=$_SESSION['user_id'] ?? 'Sem id' ?>
            </h1>
            <div class="container center col-6 espaco-top">
                <h1>Bem-vindo ao sistema de gerenciamento de estudos</h1>
                <a href="login.php" class="btn btn-primary">Login</a>
                <a href="cadastro.php" class="btn btn-secondary">Cadastrar</a>
            </div>
        
    </main>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../static/js/tools.js"></script>
<script src="../static/js/login.js"></script>

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
