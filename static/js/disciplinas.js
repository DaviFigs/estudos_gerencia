var $formDisciplina = $('#formDisciplina');
var $acao = $('#acao');
var $btnCriarDisciplina = $('#btnCriarDisciplina');
var $email = $('#email');
var $btnExcluirDisciplina = $('.btnExcluirDisciplina');

var $id_disciplina_excluir = $('#id_disciplina_excluir');
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


    $btnExcluirDisciplina.on('click', function()
    {
        console.log("testando")
        var id_disciplina = $(this).data('id');
        if(confirm('Deseja realmente excluir esta disciplina?'))
        {
            $acao.val('excluir_disciplina');
            $id_disciplina_excluir.val(id_disciplina);
            $formDisciplina.submit();
        }
    });

});