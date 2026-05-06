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
    include BASE_PATH . 'base/header.php';
    
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
        
            <div class="container center col-6 espaco-top">
                <form action="" method="POST" id="form1">
                    <input type="hidden" name="acao" value="" id="acao">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="button" class="btn btn-success"  id="btnCadastro">Cadastrar</button>
                    
                    <a href="login.php">
                        <button type="button" class="btn btn-info">Já tenho conta</button>
                    </a>
                </form>
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
