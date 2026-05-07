var $form1 = $('#form1');
var $acao = $('#acao');
var $cronometro = $('#cronometro');
var $btnIniciarPausar = $('#btnIniciarPausar');
var $btnPausar = $('#btnPausar');
var $btnParar = $('#btnParar');
var $modo = $('#modo');
var $btnTemporizador = $('#btnTemporizador');
var $btnCronometro = $('#btnCronometro');
var $disciplina_id = $("#disciplina_id");
var $tempo_inicial = $("#tempo_inicial");
var $tempo_final = $("#tempo_final");


var $duracao_estudo = $("#duracao_estudo");
var $btnSalvarEstudo = $("#btnSalvarEstudo");

var primeira_vez = true;
var rodando = false;
var intervalo;
var tempoAtual = 0;
var tempoInicialTemporizador = 0;

$(document).ready(function() {
    console.log(dataHoraLocal());

    let tempoDigitado = '000000';


    // =========================
    // MODO CRONÔMETRO
    // =========================
    $btnCronometro.on('click', function(){

        $modo.val('cron');

        $btnCronometro.prop("disabled", true);
        $btnTemporizador.prop("disabled", false);

        $cronometro.attr('contenteditable', false);

        pararCronometro();

        tempoDigitado = '000000';

        $cronometro.text('00:00:00');

    });


    // =========================
    // MODO TEMPORIZADOR
    // =========================
    $btnTemporizador.on('click', function(){

        $modo.val('temp');

        $btnTemporizador.prop("disabled", true);
        $btnCronometro.prop("disabled", false);

        $cronometro.attr('contenteditable', true);

        pararCronometro();

        tempoDigitado = '000000';

        atualizarDisplay();

        $cronometro.focus();

    });


    // =========================
    // DIGITAÇÃO DO TEMPORIZADOR
    // =========================
    $cronometro.on('keydown', function(e){

        if($modo.val() !== 'temp' || rodando){
            e.preventDefault();
            return;
        }

        // números
        if(e.key >= '0' && e.key <= '9'){

            e.preventDefault();

            tempoDigitado += e.key;

            tempoDigitado = tempoDigitado.slice(-6);

            atualizarDisplay();
        }

        // backspace
        else if(e.key === 'Backspace'){

            e.preventDefault();

            tempoDigitado = tempoDigitado.slice(0, -1);

            tempoDigitado = tempoDigitado.padStart(6, '0');

            atualizarDisplay();
        }

        else{
            e.preventDefault();
        }

    });


    // =========================
    // INICIAR / PAUSAR
    // =========================
    $btnIniciarPausar.on('click', function() {

        if(primeira_vez == true){

            $tempo_inicial.val(dataHoraLocal());

            primeira_vez = false;

        }

        if(rodando === false){
            if($disciplina_id.val() == ''){
                alert('Selecione uma disciplina para estudar primeiro');
                return false;
            }
            $disciplina_id.prop("disabled", true);
            $btnCronometro.prop("disabled", true);
            $btnTemporizador.prop("disabled", true);
            $btnSalvarEstudo.prop("disabled", true);
            rodando = true;

            // muda texto
            $btnIniciarPausar.text('⏸ Pausar');

            if($modo.val() == 'cron'){

                iniciarCronometro();

            }
            else{

                iniciarTemporizador();

            }
        }
        else{
            pausarCronometro();
            $btnSalvarEstudo.prop("disabled", false);
            // muda texto
            $btnIniciarPausar.text('▶ Continuar');

        }

    });

    // =========================
    // PARAR
    // =========================
    $btnParar.on('click', function() {

        let confirmar = confirm('Deseja realmente parar o cronômetro? \nSe parar o cronômetro todo progresso será perdido');

        if(confirmar)
        {
            pararCronometro();
            window.location.href = window.location.pathname;
        }

    });

    $btnSalvarEstudo.on("click", function(){

        let duracaoEstudo = 0;

        // CRONÔMETRO
        if($modo.val() == 'cron'){

            duracaoEstudo = tempoAtual;

        }

        // TEMPORIZADOR
        else{

            duracaoEstudo = tempoInicialTemporizador - tempoAtual;

        }

        // envia para input hidden
        $disciplina_id.prop("disabled", false);
        $duracao_estudo.val(duracaoEstudo);
        $tempo_final.val(dataHoraLocal());
        $acao.val("salvar_estudo");
        $form1.submit();

    });



    // =========================
    // FUNÇÕES
    // =========================

    function atualizarDisplay(){

        let formatado =
            tempoDigitado.slice(0,2) + ':' +
            tempoDigitado.slice(2,4) + ':' +
            tempoDigitado.slice(4,6);

        $cronometro.text(formatado);

    }


    function atualizarDisplaySegundos(totalSegundos){

        let horas = Math.floor(totalSegundos / 3600);

        let minutos = Math.floor((totalSegundos % 3600) / 60);

        let segundos = totalSegundos % 60;

        horas = String(horas).padStart(2, '0');
        minutos = String(minutos).padStart(2, '0');
        segundos = String(segundos).padStart(2, '0');

        $cronometro.text(`${horas}:${minutos}:${segundos}`);

    }

    function iniciarCronometro() {

        clearInterval(intervalo);

        intervalo = setInterval(function(){

            tempoAtual++;

            atualizarDisplaySegundos(tempoAtual);

        }, 1000);

    }


    function iniciarTemporizador() {

        clearInterval(intervalo);

        let partes = $cronometro.text().split(':');

        let horas = parseInt(partes[0]);
        let minutos = parseInt(partes[1]);
        let segundos = parseInt(partes[2]);

        tempoAtual = (horas * 3600) + (minutos * 60) + segundos;

        // guarda tempo inicial
        tempoInicialTemporizador = tempoAtual;

        intervalo = setInterval(function(){

            // terminou
            if(tempoAtual <= 0){

            tempoAtual = 0;

            atualizarDisplaySegundos(0);

            // simula pausa
            $btnIniciarPausar.click();

            Swal.fire({
                title: 'Tempo finalizado!',
                text: 'Seu estudo foi concluído com sucesso.',
                icon: 'success',
                confirmButtonText: 'Salvar estudo'
            }).then((result) => {

                if(result.isConfirmed){

                    // simula clique no botão salvar
                    $btnSalvarEstudo.click();

                }

            });

            return;
        }

            tempoAtual--;

            atualizarDisplaySegundos(tempoAtual);

        }, 1000);

    }


    function pausarCronometro() {
        clearInterval(intervalo);
        rodando = false;
    }


    function pararCronometro() {

        clearInterval(intervalo);

        rodando = false;

        tempoAtual = 0;

        $cronometro.text('00:00:00');

        // volta texto inicial
        $btnIniciarPausar.text('▶ Iniciar');

    }

    function dataHoraLocal() {

    let agora = new Date();

    return agora.getFullYear() + '-' +
        String(agora.getMonth() + 1).padStart(2, '0') + '-' +
        String(agora.getDate()).padStart(2, '0') + ' ' +
        String(agora.getHours()).padStart(2, '0') + ':' +
        String(agora.getMinutes()).padStart(2, '0') + ':' +
        String(agora.getSeconds()).padStart(2, '0');

}

});