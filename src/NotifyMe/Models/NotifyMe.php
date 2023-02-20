<?php

namespace Lokalkoder\NotifyMe\NotifyMe\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class NotifyMe extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory;
    use GeneratesUuid;
    use Auditable;

    protected $table = 'notify_me';

    protected $casts = [
        'recipients' => 'array',
        'source' => 'array',
        'assignee' => 'array',
    ];
}
