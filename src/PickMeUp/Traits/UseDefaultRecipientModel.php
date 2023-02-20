<?php

namespace Lokalkoder\NotifyMe\PickMeUp\Traits;

use Illuminate\Database\Eloquent\Builder;

trait UseDefaultRecipientModel
{

    /**
     * Definition of additional where clause to limit recipient source listing.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeNotifyMeRecipient(Builder $query): Builder
    {
        return $query;
    }

    /**
     * Definition of recipient email.
     *
     * @return string|null
     */
    public function getRecipientNotifierAttribute(): ?string
    {
        return 'email';
    }
}
