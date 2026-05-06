<?php

class Tools
{
    public static function formatar_nome_disciplina($nome)
    {
        $nome = strtolower($nome);
        $nome = ucfirst($nome);
        return $nome;
    }
}