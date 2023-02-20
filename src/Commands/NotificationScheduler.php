<?php

namespace Lokalkoder\NotifyMe\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Lokalkoder\NotifyMe\NotifyMe\Models\NotifyMe;
use Lokalkoder\NotifyMe\NotifyMe\PostMan;

class NotificationScheduler extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify-me:run {--date= : Date of notification}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run notification scheduler';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->getNotificationData()
            ->each(function ($notifiable) {
                (new PostMan($notifiable))->send();
            });
    }

    protected function getNotificationData()
    {
        $tz = config('app.timezone');
        $date = Carbon::parse($this->option('date'), $tz) ?? now($tz);

        return NotifyMe::where('date', '<=', $date)
            ->where('has_notified', false)
            ->cursor();
    }
}
