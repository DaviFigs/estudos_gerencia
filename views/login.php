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
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <h1>Entrar</h1>
                    <p>Acesse sua conta de estudos</p>
                </div>

                <form action="" method="POST" id="form1">
                    <input type="hidden" name="acao" id="acao" value="">
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-input" id="email" name="email" placeholder="seu@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-input" id="password" name="password" placeholder="••••••••" required>
                    </div>

                    <button type="button" class="btn btn-auth btn-primary" id="btnLogin">
                        ▶ Entrar
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Não tem conta? <a href="cadastro.php" class="auth-link">Cadastre-se aqui</a></p>
                </div>
            </div>
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
