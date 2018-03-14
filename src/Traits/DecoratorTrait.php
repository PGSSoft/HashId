<?php

namespace Pgs\HashIdBundle\Traits;

trait DecoratorTrait
{
    protected $object;

    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $arguments)
    {
        if (!method_exists($this->object, $method)) {
            throw new \BadMethodCallException(sprintf('Object %s has no %s() method.', get_class($this->object), $method));
        }

        return call_user_func_array(array($this->object, $method), $arguments);
    }
}
