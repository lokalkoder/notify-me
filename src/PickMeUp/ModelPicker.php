<?php

namespace Lokalkoder\NotifyMe\PickMeUp;

use ReflectionException;
use Throwable;

class ModelPicker
{
    protected $model;

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public function __construct(string $class, $identifier, bool $useUUid = false)
    {
        $class = (new ClassPicker($class))->getClass();

        $this->model = $class->where(($useUUid) ? 'uuid' : $class->notifyMeIdentifier(), $identifier)->first();
    }

    public function notifier(): array
    {
        return [
            'subject' => $this->model->notifyMeSubject(),
            'summary' => $this->model->notifyMeSummary(),
            'content' => $this->model->notifyMeContent(),
            'date' => $this->model->notifyMeWhen(),
            'receiver' => $this->model->notifyMeReceiver(),
        ];
    }
}
