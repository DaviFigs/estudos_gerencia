var $form1 = $('#form1');
var $acao = $('#acao');
var $btnLogin = $('#btnLogin');
var $email = $('#email');
var $password = $('#password');
var $hora_acesso = $('#hora_acesso');

$(document).ready(function() {

    $btnLogin.on('click', function() {
        if($email.val() == '' || $password.val() == '') {

            Swal.fire('Erro!', 'Preencha todos os campos', 'error');

        }
        else {

            // pega data/hora do navegador
            let agora = new Date();
            let dataHora =
                agora.getFullYear() + '-' +
                String(agora.getMonth() + 1).padStart(2, '0') + '-' +
                String(agora.getDate()).padStart(2, '0') + ' ' +
                String(agora.getHours()).padStart(2, '0') + ':' +
                String(agora.getMinutes()).padStart(2, '0') + ':' +
                String(agora.getSeconds()).padStart(2, '0');

            $hora_acesso.val(dataHora);
            $acao.val('login');
            $form1.submit();
        }

    });

});