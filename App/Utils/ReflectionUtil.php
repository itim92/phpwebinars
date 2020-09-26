<?php


namespace App\Utils;


class ReflectionUtil
{
    public function setPrivatePropertyValue($object, string $propertyName, $propertyValue)
    {
        $reflectionModel = new \ReflectionObject($object);
        $reflectionId = $reflectionModel->getProperty($propertyName);
        $reflectionId->setAccessible(true);
        $reflectionId->setValue($object, $propertyValue);
        $reflectionId->setAccessible(false);
    }
}