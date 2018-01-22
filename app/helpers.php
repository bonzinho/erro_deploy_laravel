<?php

// ************************
// Helper com utilidades criado por Vitor Bonzinho.
// ************************

/**
 * Retorna data e hora.
 *
 * @param   bool    $hora   Se vai retornar hora também
 * @return  string
 */
function getData($hora)
{
    // retorna, mas poderia ser "echo", whatever
    return ($hora ? date("d/m/Y H:i") : date("d/m/Y")) ;
}