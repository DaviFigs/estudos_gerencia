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
    
    $titulo = 'Cadastro';
    include BASE_PATH . 'base/head.php';
    
    $acao = $_POST['acao'] ?? '';

    if($acao == 'cadastro'){
        $param['email'] = $_POST['email'] ?? '';
        $param['senha'] = $_POST['password'] ?? '';
        $param['nome'] = $_POST['nome'] ?? '';

        $cadastro = $oUsuario->cadastrar_usuario($param);
        if($cadastro['error'] === false)
        {
            $usuario = $cadastro['item'];
            $mostrar_msg = [
                'tipo' => 'success',
                'title' => 'Sucesso',
                'msg' => $cadastro['msg'],
                'acao' => 'login'
            ]; 
        }
        else 
        {
            $mostrar_msg = [
                'tipo' => 'error',
                'title' => 'Erro',
                'msg' => $cadastro['msg'],
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
                    <h1>Cadastro</h1>
                    <p>Crie sua conta e comece a estudar</p>
                </div>

                <form action="" method="POST" id="form1">
                    <input type="hidden" name="acao" id="acao" value="">
                    
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-input" id="nome" name="nome" placeholder="Seu nome" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-input" id="email" name="email" placeholder="seu@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-input" id="password" name="password" placeholder="••••••••" required>
                    </div>

                    <button type="button" class="btn btn-auth btn-primary" id="btnCadastro">
                        ✓ Cadastrar
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Já tem conta? <a href="login.php" class="auth-link">Faça login aqui</a></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../static/js/tools.js"></script>
<script src="../static/js/cadastro.js"></script>

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
