<?php
    require_once '../phpConfig.php';
    require_once BASE_PATH . 'models/banco.service.class.php';
    require_once BASE_PATH . 'models/disciplina.service.class.php';
    require_once BASE_PATH . 'models/usuario.service.class.php';
    require_once BASE_PATH . 'models/auth.service.class.php';
    
    $oUsuario = new Usuario();
    $oAuth = new Auth();
    $oAuth->require_logout();
    
    $mostrar_msg = [
        'tipo' => '',
        'title' => '',
        'msg' => '',
        'acao' => ''
    ];
    
    $titulo = 'Login';
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
        
            <div class="container center col-6 espaco-top">
                <form action="" method="POST" id="form1">
                    <input type="hidden" name="acao" value="" id="acao">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="button" class="btn btn-success"  id="btnLogin">Login</button>
                    
                    <a href="cadastro.php">
                        <button type="button" class="btn btn-info">Cadastre-se</button>
                    </a>
                </form>
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
