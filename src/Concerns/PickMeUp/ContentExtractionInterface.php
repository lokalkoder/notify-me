<?php

namespace Lokalkoder\NotifyMe\Concerns\PickMeUp;

use Carbon\Carbon;

interface ContentExtractionInterface
{
    /**
     * Definition for reference id field.
     */
    public function notifyMeIdentifier(): string;

    /**
     * Definition of notification header.
     */
    public function notifyMeSubject(): string;

    /**
     * Definition of notification summary.
     */
    public function notifyMeSummary(): string;

    /**
     * Definition of notification content.
     */
    public function notifyMeContent(): mixed;

    /**
     * Definition of notification date & time.
     */
    public function notifyMeWhen(): ?Carbon;

    /**
     * Definition of notification receiver.
     */
    public function notifyMeReceiver(): mixed;
}
