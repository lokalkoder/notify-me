<?php

namespace Lokalkoder\NotifyMe\PickMeUp;

use Lokalkoder\NotifyMe\Concerns\PickMeUp\ContentExtractionInterface;
use Lokalkoder\NotifyMe\Concerns\PickMeUp\RecipientSourceInterface;
use Lokalkoder\NotifyMe\Exceptions\PickMeUpException;
use ReflectionClass;
use ReflectionException;
use Throwable;

class ClassPicker
{
    protected ReflectionClass $class;

    /**
     * @throws ReflectionException
     */
    public function __construct(string $class)
    {
        $this->class = new ReflectionClass($class);
    }

    /**
     * @throws Throwable
     */
    public function getClass()
    {
        return $this->isClassConcernExist(ContentExtractionInterface::class) ? $this->class->newInstance() : null;
    }

    /**
     * @throws ReflectionException
     * @throws PickMeUpException
     */
    public function getRecipientSource()
    {
        return $this->isClassConcernExist(RecipientSourceInterface::class) ? $this->class->newInstance() : null;
    }

    /**
     * @throws PickMeUpException
     */
    protected function isClassConcernExist(string $interface): bool
    {
        if (! $this->class->implementsInterface($interface)) {
            throw new PickMeUpException();
        }

        return true;
    }
}
