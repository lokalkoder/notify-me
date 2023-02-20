<?php

namespace Lokalkoder\NotifyMe\Concerns\PickMeUp;

use Carbon\Carbon;

interface ContentExtractionInterface
{
    /**
     * Definition for reference id field.
     *
     * @return string
     */
    public function notifyMeIdentifier(): string;

    /**
     * Definition of notification header.
     *
     * @return string
     */
    public function notifyMeSubject(): string;

    /**
     * Definition of notification summary.
     *
     * @return string
     */
    public function notifyMeSummary(): string;

    /**
     * Definition of notification content.
     *
     * @return mixed
     */
    public function notifyMeContent(): mixed;

    /**
     * Definition of notification date & time.
     * @return Carbon|null
     */
    public function notifyMeWhen(): ?Carbon;

    /**
     * Definition of notification receiver.
     * @return mixed
     */
    public function notifyMeReceiver(): mixed;
}
