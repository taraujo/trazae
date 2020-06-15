<?php
/**
 * Created by PhpStorm.
 * User: Thasso
 * Date: 1/28/2019
 * Time: 4:40 PM
 */

namespace App\Http\Helpers;

class AttributesHelper
{

    /**
     * @param $property
     * @return string
     */
    public static function normalize($property)
    {
        $result = '';

        $explodes = preg_split('/(?=[A-Z])/', $property);
        foreach ($explodes as $word) {
            if (empty($result)) {
                $result .= $word;
            } else {
                $result .= '_' . strtolower($word);
            }
        }
        return $result;
    }
}
