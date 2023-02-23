<?php

use Illuminate\Support\Facades\Route;
use Lokalkoder\NotifyMe\Actions\NotifyMe;
use Lokalkoder\NotifyMe\Actions\PickMeUp;

Route::middleware(['web', 'auth'])->group(function ($route) {
    $route->get('/pick-me', PickMeUp::class)->name('pick.me');
    $route->get('/notify-me', NotifyMe::class)->name('notify.me');
    $route->post('/notify-me', [NotifyMe::class, 'notifyMe'])->name('notify.post');
    $route->put('/notify-update', [NotifyMe::class, 'notifyUpdate'])->name('notify.update');
    $route->get('/recipients', [PickMeUp::class, 'getRecipientsSource'])->name('pick.recipients');

    $route->post('/notififications', [NotifyMe::class, 'getNotifications'])->name('notifications');
});
