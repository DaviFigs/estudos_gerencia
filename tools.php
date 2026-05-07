<?php

class Tools
{
    public static function formatar_nome_disciplina($nome)
    {
        $nome = strtolower($nome);
        $nome = ucfirst($nome);
        return $nome;
    }

    public function segundosParaHorario($segundos)
{
    $horas = floor($segundos / 3600);

    $minutos = floor(($segundos % 3600) / 60);

    $segundos_restantes = $segundos % 60;

    return sprintf(
        '%02d:%02d:%02d',
        $horas,
        $minutos,
        $segundos_restantes
    );
}
}