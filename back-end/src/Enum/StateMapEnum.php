<?php

namespace App\Enum;

enum StateMapEnum: string
{
    case A_FAIRE = 'a_faire';
    case EN_COURS = 'en_cours';
    case TERMINEE = 'terminee';
}