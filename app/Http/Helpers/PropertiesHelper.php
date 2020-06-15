<?php
/**
 * Created by PhpStorm.
 * User: Thasso
 * Date: 1/24/2019
 * Time: 12:10 PM
 */

namespace App\Http\Helpers;

class PropertiesHelper
{

    public static function normalize($attribute)
    {
        $result = '';

        $attribute = strtolower($attribute);
        $explodes = explode('_', $attribute);
        foreach ($explodes as $word) {
            if (empty($result)) {
                $result .= $word;
            } else {
                $result .= ucfirst($word);
            }
        }
        return $result;
    }
}
