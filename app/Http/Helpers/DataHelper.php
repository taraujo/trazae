<?php

namespace App\Http\Helpers;

use App\Exceptions\RegraException;
use Carbon\Carbon;

class DataHelper
{
    /**
     * Converte a data padrão utilizada em bases de dados para o formato informado
     *
     * @param date $date
     * @param string $format
     * @return string
     */
    public static function dateToString($date, $format = 'd/m/Y')
    {
        if (empty($date) || trim($date) == "") {
            return null;
        }
        return Carbon::parse($date)->format($format);
    }

    /**
     * Converte uma data (string) em Carbon
     *
     * @param $data
     * @return mixed
     */
    public static function stringToCarbonDate($data)
    {
        if (!isset($data) || empty($data)) {
            return null;
        }
        if (Carbon::hasFormat($data, 'd/m/Y')) {
            return Carbon::createFromFormat('d/m/Y', $data);
        } elseif (Carbon::hasFormat($data, 'Y-m-d')) {
            return Carbon::createFromFormat('Y-m-d', $data);
        } elseif (Carbon::hasFormat($data, 'd/m/y H:i:s')) {
            return Carbon::createFromFormat('d/m/y H:i:s', $data);
        } elseif (Carbon::hasFormat($data, 'Y-m-d H:i:s')) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $data);
        } elseif (Carbon::hasFormat($data, 'H:i:s')) {
            return Carbon::createFromFormat('H:i:s', $data);
        }
        return $data;
    }

    /**
     * Verifica se a hora atual está no intervalo informado
     *
     * @param $horaInicial
     * @param $horaFinal
     * @return bool
     * @throws RegraException
     */
    public static function isHoraAtualEstaNoIntervalo($horaInicial, $horaFinal)
    {
        $horaAtual = Carbon::now();

        $horaInicial = self::getCarbonDate($horaInicial);
        $horaFinal = self::getCarbonDate($horaFinal);
        if (!$horaAtual instanceof Carbon || !$horaFinal instanceof Carbon) {
            throw new RegraException("O formato de data/hora informado está inválido e não pode ser identificado!");
        }

        if ($horaAtual->greaterThanOrEqualTo($horaInicial) && $horaAtual->lessThanOrEqualTo($horaFinal)) {
            return true;
        }
        return false;
    }
}
