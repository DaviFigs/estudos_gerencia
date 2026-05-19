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

    public function verificarPeriodoDia()
    {
        $horaAtual = (int) date('H');

        // 00:00 até 11:59
        if ($horaAtual >= 0 && $horaAtual < 12) {
            return 'tenis.jfif';
        }

        // 12:00 até 23:59
        return 'gatinho.png';
    }
}