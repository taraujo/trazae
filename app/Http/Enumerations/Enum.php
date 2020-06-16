<?php

namespace App\Http\Enumerations;

use ReflectionClass;

abstract class Enum
{
    protected $value;

    /**
     * @return mixed
     * @throws \ReflectionException
     */
    public static function values()
    {
        $reflect = new ReflectionClass(get_called_class());
        return collect($reflect->getConstants());
    }

    /**
     * Validates if the type given is part of this enum class
     *
     * @param string $checkValue
     * @return bool
     * @throws \ReflectionException
     */
    public static function isValidEnumValue($checkValue)
    {
        $reflector = new ReflectionClass(get_called_class());
        foreach ($reflector->getConstants() as $validValue) {
            if ($validValue == $checkValue) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $value Value for this display type
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * With a magic getter you can get the value from this enum using
     * any variable name as in:
     *
     * <code>
     *   $myEnum = new MyEnum(MyEnum::start);
     *   echo $myEnum->v;
     * </code>
     *
     * @param string $property
     * @return string
     */
    public function __get($property)
    {
        return $this->value;
    }

    /**
     * With a magic setter you can set the enum value using any variable
     * name as in:
     *
     * <code>
     *   $myEnum = new MyEnum(MyEnum::Start);
     *   $myEnum->v = MyEnum::End;
     * </code>
     *
     * @param string $property
     * @param string $value
     * @throws Exception Throws exception if an invalid type is used
     */
    public function __set($property, $value)
    {
        $this->setValue($value);
    }

    /**
     * If the enum is requested as a string then this function will be automatically
     * called and the value of this enum will be returned as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }
}
