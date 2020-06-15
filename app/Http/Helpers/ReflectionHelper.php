<?php
/**
 * Created by PhpStorm.
 * User: Thasso
 * Date: 1/28/2019
 * Time: 1:24 PM
 */

namespace App\Http\Helpers;

use App\Http\Entities\Base\BaseEntity;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use ReflectionException;

class ReflectionHelper
{
    /**
     * @param $clazz
     * @param array $array
     * @return mixed
     * @throws ReflectionException
     */
    public static function converterArrayParaVO($clazz, array $array = []) : object
    {
        try {
            $reflector = new ReflectionClass($clazz);
            $instance = $reflector->newInstance();

            foreach ($array as $prop => $value) {
                $propertyNormalize = PropertiesHelper::normalize($prop);

                if ($reflector->hasProperty($propertyNormalize)) {
                    $set = $reflector->getMethod('set' . ucfirst($propertyNormalize));
                    $set->invoke($instance, $value);
                }
            }
            return $instance;
        } catch (ReflectionException $exception) {
            \Log::info($exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @param $instance
     * @return array
     * @throws ReflectionException
     */
    public static function converterVOParaArray($instance) : array
    {
        $arr = array ();

        try {
            $reflectorVO = new ReflectionClass($instance);
            $properties = $reflectorVO->getProperties();

            foreach ($properties as $property) {
                $attributeNormalize = AttributesHelper::normalize($property->name);

                $get = $reflectorVO->getMethod('get' . $property->name);

                $arr[$attributeNormalize] = $get->invoke($instance);
            }
            return $arr;
        } catch (ReflectionException $exception) {
            \Log::info($exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @param Model $entity
     * @param $clazz
     * @return mixed
     * @throws ReflectionException
     */
    public static function converterEntidadeParaVO($entity, $clazz)
    {
        try {
            $reflector = new ReflectionClass($clazz);
            $vo = $reflector->newInstance();

            $attributtes = $entity->getAttributes();

            foreach ($attributtes as $attributte => $value) {
                $propertyNormalize = PropertiesHelper::normalize($attributte);

                if ($reflector->hasProperty($propertyNormalize)) {
                    $set = $reflector->getMethod('set' . ucfirst($propertyNormalize));
                    $set->invoke($vo, $value);
                }
            }
            return $vo;
        } catch (\ReflectionException $exception) {
            \Log::info($exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @param $vo
     * @param BaseEntity $entity
     * @return mixed
     * @throws ReflectionException
     */
    public static function converterVOParaEntidade($vo, $entity)
    {
        try {
            $reflectorVO = new ReflectionClass($vo);
            $properties = $reflectorVO->getProperties();

            foreach ($properties as $property) {
                $attributeNormalize = AttributesHelper::normalize($property->name);

                if ($entity->isFillable($attributeNormalize)) {
                    $get = $reflectorVO->getMethod('get' . $property->name);
                    $entity->setAttribute($attributeNormalize, $get->invoke($vo));
                }
            }
            return $entity;
        } catch (\ReflectionException $exception) {
            \Log::info($exception->getMessage());
            throw $exception;
        }
    }
}
