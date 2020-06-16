<?php

namespace App\Http\Enumerations;

abstract class TipoVeiculo extends Enum
{
    const MOTO = 1;
    const PICK_UP = 2;
    const CAMINHAO = 3;

    private const LABELS = [
        self::MOTO => "Moto",
        self::PICK_UP => "Pick Up",
        self::CAMINHAO => "Caminhão",
    ];

    /**
     * Get Label
     *
     * @param int $value
     * @return void
     */
    public static function getLabel($value)
    {
        return self::LABELS[$value];
    }
}
