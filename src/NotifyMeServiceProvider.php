<?php

namespace Lokalkoder\NotifyMe;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;
use Lokalkoder\NotifyMe\Commands\NotificationScheduler;
use Lokalkoder\NotifyMe\Components\Layout;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NotifyMeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('notify-me')
            ->hasConfigFile(['notify-me'])
            ->hasRoute('notify-me')
            ->hasViews()
            ->hasViewComponents('notify-me', Layout::class)
            ->hasTranslations()
            ->hasMigrations(['create_notify_me_table'])
            ->hasAssets()
            ->hasCommands([NotificationScheduler::class])
            ->hasInstallCommand(function(InstallCommand $command) {
                $command->startWith(function(InstallCommand $command) {
                        $command->info('Initiating Notify Me Installation');
                    })
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->copyAndRegisterServiceProviderInApp()
                    ->askToStarRepoOnGitHub('lokalkoder/notify-me')
                    ->endWith(function(InstallCommand $command) {
                        $command->callSilently("vendor:publish", [
                            '--tag' => "notify-me-assets",
                        ]);
                        $command->info('May the force with you...');
                    });


            });
    }

    public function registeringPackage()
    {
        $this->booting(function () {
            foreach ($this->getMailListener() as $event => $listeners) {
                foreach (array_unique($listeners, SORT_REGULAR) as $listener) {
                    Event::listen($event, $listener);
                }
            }
        });
    }

    protected function getMailListener()
    {
        return [
            MessageSending::class => config('notify-me.listener.mail.sending', []),

            MessageSent::class => config('notify-me.listener.mail.sent', []),
        ];
    }
}
