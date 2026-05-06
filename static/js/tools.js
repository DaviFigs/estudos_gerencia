function mostrarMensagem(tipo, titulo, mensagem, acao) {

    Swal.fire({
        icon: tipo,
        title: titulo,
        text: mensagem,
        confirmButtonText: "OK"
    }).then(() => {

        if (acao === 'redirect') {
            window.location.href = '../views/home.php';
        }
        else if (acao === 'renew') {
            window.location.href = window.location.pathname;
        }
        else if(acao ==='login'){
            window.location.href = '../views/login.php';
        }

    });
}