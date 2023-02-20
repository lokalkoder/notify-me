<?php

namespace Lokalkoder\NotifyMe\PickMeUp\Traits;

use Illuminate\Database\Eloquent\Builder;

trait UseDefaultRecipientModel
{
    /**
     * Definition of additional where clause to limit recipient source listing.
     */
    public function scopeNotifyMeRecipient(Builder $query): Builder
    {
        return $query;
    }

    /**
     * Definition of recipient email.
     */
    public function getRecipientNotifierAttribute(): ?string
    {
        return 'email';
    }
}
