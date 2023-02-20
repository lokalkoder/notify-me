<?php

namespace Lokalkoder\NotifyMe\PickMeUp;

use Lokalkoder\NotifyMe\Exceptions\PickMeUpException;
use ReflectionException;

class RecipientPicker
{
    protected $source;

    /**
     * @throws ReflectionException|PickMeUpException
     */
    public function __construct()
    {
        $this->source = (new ClassPicker(config('notify-me.pick-me.recipient.source')))->getRecipientSource();
    }

    public function recipients()
    {
        return $this->source->notifyMeRecipient()->get($this->source->recipientNotifier);
    }
}
