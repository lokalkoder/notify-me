<?php

namespace Lokalkoder\NotifyMe\NotifyMe\Listener;

use Illuminate\Database\Eloquent\Model;

class NotifyMeSent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $notifyMe = $event->data['content'];

        if (! $notifyMe->is_recur) {
            $notifyMe->has_notified = true;
        } else {
            $sourceModel = app()->make(data_get($notifyMe, 'source.model'))->find(data_get($notifyMe, 'source.id'));

            if ($sourceModel instanceof Model) {
                $notifyMe->date = $sourceModel->notificationDatetime;
            }
        }

        $notifyMe->saveQuietly();
    }
}
