var $form1 = $('#form1');
var $acao = $('#acao');
var $btnCadastro = $('#btnCadastro');
var $email = $('#email');
var $nome = $('#nome');
var $password = $('#password');

$(document).ready(function() {
    $btnCadastro.on('click', function() {
        if($email.val() =='' || $password.val() == '' || $nome.val() == '') {
            Swal.fire('Erro!', 'Preencha todos os campos', 'error');
        }
        else{
            $acao.val('cadastro');
            $form1.submit();
        }

    });

});