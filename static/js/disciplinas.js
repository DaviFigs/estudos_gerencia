var $form1 = $('#form1');
var $formDisciplina = $('#formDisciplina');
var $acao = $('#acao');
var $btnCriarDisciplina = $('#btnCriarDisciplina');
var $email = $('#email');


var $nome_disciplina = $('#nome_disciplina');
var $importancia = $('#importancia');
var $cor = $('#cor');
var $descricao = $('#descricao');

$(document).ready(function() {
    $btnCriarDisciplina.on('click', function() 
    {
        if($nome_disciplina.val() =='' 
            || $importancia.val() == '' 
            || $cor.val() == '') 
        {
            Swal.fire('Erro!', 'Preencha todos os campos', 'error');
            return;
        }
        else{
            $acao.val('criar_disciplina');
            $formDisciplina.submit();
        }
    });

});