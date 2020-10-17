<?php


namespace App\Model;


abstract class AbstractModel implements \ArrayAccess
{
    public function offsetExists($offset)
    {
        return property_exists($this, $offset);
    }

    public function offsetGet($offset)
    {
//        // Ниже, кусок кода, если свойства в модели делать private
//        $reflectionObject = new \ReflectionObject($this);
//        $reflectionProperty = $reflectionObject->getProperty($offset);
//        $reflectionProperty->setAccessible(true);
//
//        return $reflectionProperty->getValue($this);

        try {
            $getter = $this->getGetterName($offset);
            if (method_exists($this, $getter)) {
                return $this->{$getter}();
            }
        } catch (\Throwable $e) {

        }

        return $this->{$offset};
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    protected function getGetterName($offset) {
        return 'get' . ucfirst($offset);
    }

    abstract public function getId(): int;
}