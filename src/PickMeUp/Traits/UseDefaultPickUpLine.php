<?php

namespace Lokalkoder\NotifyMe\PickMeUp\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait UseDefaultPickUpLine
{
    /**
     * Definition for reference id field.
     *
     * @return string
     */
    public function notifyMeIdentifier(): string
    {
        return 'id';
    }

    /**
     * Definition for reference id field.
     *
     * @return string
     */
    public function notifyMeSubject(): string
    {
        if (method_exists($this, 'getNotificationSubjectAttribute')) {
            return ($this instanceof Model) ? $this->notificationSubject : $this->getNotificationSubjectAttribute();
        }

        return __('notify-me::pickme.header');
    }

    /**
     * Definition of notification summary.
     *
     * @return mixed
     */
    public function notifyMeSummary(): string
    {
        if (method_exists($this, 'getNotificationSummaryAttribute')) {
            return ($this instanceof Model) ? $this->notificationSummary : $this->getNotificationSummaryAttribute();
        }

        return __('notify-me::pickme.summary');
    }

    /**
     * Definition of notification content.
     *
     * @return mixed
     */
    public function notifyMeContent(): mixed
    {
        if (method_exists($this, 'getNotificationMessageAttribute')) {
            return ($this instanceof Model) ? $this->notificationMessage : $this->getNotificationMessageAttribute();
        }

        return __('notify-me::pickme.message');
    }

    /**
     * Definition of notification date & time.
     * @return Carbon|null
     */
    public function notifyMeWhen(): ?Carbon
    {
        if (method_exists($this, 'getNotificationDatetimeAttribute')) {
            return ($this instanceof Model) ? $this->notificationDatetime : $this->getNotificationDatetimeAttribute();
        }

        return null;
    }

    /**
     * Definition of notification receiver.
     * @return mixed
     */
    public function notifyMeReceiver(): mixed
    {
        return [];
    }
}
