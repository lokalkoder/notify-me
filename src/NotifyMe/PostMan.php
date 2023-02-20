<?php

namespace Lokalkoder\NotifyMe\NotifyMe;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Lokalkoder\NotifyMe\NotifyMe\Models\NotifyMe;

class PostMan
{
    /**
     * @var NotifyMe
     */
    protected NotifyMe $model;

    /**
     * @param $notifyme
     */
    public function __construct($notifyme)
    {
        $this->model = $notifyme;
    }

    /**
     * Execute mail delivery.
     * @return void
     */
    public function send()
    {
        foreach ($this->model->recipients as $recipient)
        {
            Mail::to($recipient)->send($this->message());
        }
    }

    protected function markSend()
    {

    }

    /**
     * Definition mailable.
     * @return NotifyMeMail
     */
    protected function message()
    {
        $connection = config('notify-me.queue.mail.connection');
        $queue = config('notify-me.queue.mail.name');

        return (new NotifyMeMail($this->model))->onConnection($connection)->onQueue($queue);
    }
}
