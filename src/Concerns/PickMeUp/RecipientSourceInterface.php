<?php

namespace Lokalkoder\NotifyMe\Concerns\PickMeUp;

use Illuminate\Database\Eloquent\Builder;

interface RecipientSourceInterface
{
    /**
     * Definition of additional where clause to limit recipient source listing.
     */
    public function scopeNotifyMeRecipient(Builder $query): Builder;

    /**
     * Definition of recipient email.
     */
    public function getRecipientNotifierAttribute(): ?string;
}
