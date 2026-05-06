var $form1 = $('#form1');
var $acao = $('#acao');
var $btnLogin = $('#btnLogin');
var $email = $('#email');
var $password = $('#password');

$(document).ready(function() {
    $btnLogin.on('click', function() {
        if($email.val() =='' || $password.val() == '') {
            Swal.fire('Erro!', 'Preencha todos os campos', 'error');
        }
        else{
            $acao.val('login');
            $form1.submit();
        }

    });

});