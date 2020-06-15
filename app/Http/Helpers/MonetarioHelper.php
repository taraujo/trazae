<?php
namespace App\Http\Helpers;

use PhpParser\Node\Expr\Cast\Double;

/**
 * Created by PhpStorm.
 * User: Djair
 * Date: 25/06/2018
 * Time: 10:01
 */

class MonetarioHelper
{
    /**
     * @param $value
     * @return string
     */
    /**
     *
     * A função formata o valor para o padrão do banco
     *
     * @param $value
     * @return mixed
     */

    public static function extenso($valor = 0, $maiusculas = false)
    {

        $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("", "", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
            "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");

        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
            "sessenta", "setenta", "oitenta", "noventa");

        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
            "dezesseis", "dezessete", "dezoito", "dezenove");

        $u = array("", "um", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

        $z = 0;
        $rt = '';

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
        for ($i = 0; $i < count($inteiro); $i++) {
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++) {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }

        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count($inteiro) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000") {
                $z++;
            } elseif ($z > 0) {
                $z--;
            }
            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0)) {
                $r .= (($z > 1) ? " de " : "") . $plural[$t];
            }
            if ($r) {
                $rt = $rt .
                    ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") .
                    $r;
            }
        }

        if (!$maiusculas) {
            return ($rt ? $rt : "zero");
        } else {
            return (MonetarioHelper::upper($rt) ? MonetarioHelper::upper($rt) : "ZERO");
        }
    }

    public static function numeroExtenso($valor = 0, $maiusculas = false)
    {

        $singular = array("", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos",
            "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis",
            "dezessete", "dezoito", "dezenove");
        $u = array("", "um", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

        $z = 0;
        $rt = '';

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
        for ($i = 0; $i < count($inteiro); $i++) {
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++) {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }

        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count($inteiro) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000") {
                $z++;
            } elseif ($z > 0) {
                $z--;
            }
            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0)) {
                $r .= (($z > 1) ? " de " : "") . $plural[$t];
            }
            if ($r) {
                $rt = $rt .
                    ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") .
                    $r;
            }
        }

        if (!$maiusculas) {
            return ($rt ? $rt : "zero");
        } else {
            return (upper($rt) ? upper($rt) : "ZERO");
        }
    }

    public static function upper($_Str)
    {

        $_Str = strtoupper(trim($_Str));

        $Minusculo = array
        ("á", "à", "ã", "â", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "õ", "ô",
            "ö", "ú", "ù", "û", "ü", "ç");

        $Maiusculo = array
        ("Á", "À", "Ã", "Â", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Õ", "Ô",
            "Ö", "Ú", "Ù", "Û", "Ü", "Ç");

        for ($X = 0; $X < count($Minusculo); $X++) {
            $_Str = str_replace($Minusculo[$X], $Maiusculo[$X], $_Str);
        }
        return $_Str;
    }

    /**
     * Formata o campo para salvar no banco,
     *
     * @param unknown $value utilizando ponto (.) como separador
     * @return number
     */
    public static function formatarMoedaBanco($value)
    {
        if (empty($value) || $value == "0,00" || $value == " ") {
            $value = "0,00";
        }

        return (double)$value;
    }

    public static function formatarMoedaAmericana($valor)
    {
        if (empty($value) || $value == "0,00" || trim($value) == "") {
            $value = "0,00";
        }

        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $valor); //remove os pontos e substitui a virgula pelo ponto
        return (double)$valor; //retorna o valor formatado para gravar no banco
    }

    /**
     * A função formata o valor para o padrão visualizado no Brasil
     *
     * @param $value
     * @return string
     */
    //Verifica se o valor esta em reais
    public static function formatoReal($valor)
    {
        $valor = (string)$valor;
        $regra = "/^[0-9]{1,3}([.]([0-9]{3}))*[,]([.]{0})[0-9]{0,2}$/";
        if (preg_match($regra, $valor)) {
            return true;
        } else {
            return false;
        }
    }

    public static function formatarMoedaLabel($value)
    {
        if (empty($value) || $value == "0,00") {
            $value = "0,00";
            return 0;
        }
        return number_format($value, 2, ',', '.');
    }

    public static function formatarValoresNumericosObject($object)
    {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                if (is_numeric($value)) {
                    $object->$key = MonetarioHelper::formatarMoedaLabel($value);
                }
            }

            return $object;
        } else {
            return false;
        }
    }

    public static function formatarValoresNumericosArray($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_numeric($value)) {
                    $array[$key] = MonetarioHelper::formatarMoedaLabel($value);
                }
            }

            return $array;
        } else {
            return false;
        }
    }

    public static function moedaAmericana($valor)
    {
        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $valor); //remove os pontos e substitui a virgula pelo ponto
        return (double)$valor; //retorna o valor formatado para gravar no banco
    }

    /**
     *
     * Essa função converte valores padrão Febraban ou seja, com 2 casas decimais sem vírgula
     * para o valor que será inserido no banco
     *
     * @param String valor
     * @return Double
     *
     */
    public static function formatarMoedaXmlParaBanco($value)
    {
        if ($value != null && trim($value) != "") {
            if (intval($value) == 0) {
                return 0;
            }
            return intval($value) / 100;
        }

        return 0;
    }

    /**
     * Essa função converte valores padrão do banco para XML, ou seja, remove os pontos e virgulas.
     *
     * @param unknown $value
     */
    public static function formatarMoedaBancoParaXml($value)
    {
        if ($value != null && trim($value) != "") {
            if (intval($value) == 0) {
                return 0;
            }
            return intval($value * 100);
        }

        return 0;
    }
}
