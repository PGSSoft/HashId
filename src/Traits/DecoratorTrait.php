<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\Traits;

use BadMethodCallException;

trait DecoratorTrait
{
    protected $object;

    /**
     * @throws BadMethodCallException
     *
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        if (!method_exists($this->object, $method)) {
            $message = sprintf('Object %s has no %s() method.', \get_class($this->object), $method);
            throw new BadMethodCallException($message);
        }

        return \call_user_func_array([$this->object, $method], $arguments);
    }
}
