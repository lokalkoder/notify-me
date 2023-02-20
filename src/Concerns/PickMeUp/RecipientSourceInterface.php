<?php

namespace Lokalkoder\NotifyMe\Concerns\PickMeUp;

use Illuminate\Database\Eloquent\Builder;

interface RecipientSourceInterface
{
    /**
     * Definition of additional where clause to limit recipient source listing.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeNotifyMeRecipient(Builder $query): Builder;

    /**
     * Definition of recipient email.
     *
     * @return string|null
     */
    public function getRecipientNotifierAttribute(): ?string;
}
