<?php

namespace Lokalkoder\NotifyMe\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;

class NotifyMe extends Action
{
    public function __invoke(Request $request)
    {
        return view(
            'notify-me::notify-me'
        );
    }

    public function getNotifications(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        return \Lokalkoder\NotifyMe\NotifyMe\Models\NotifyMe::whereYear('date', $year)
            ->whereMonth('date', $month + 1)
            ->get()
            ->map(function ($item) {
                return [
                    'notify_date' => Carbon::parse($item->date)->toDateTimeString(),
                    'notify_title' => $item->subject,
                    'notify_recipients' => collect($item->recipients)->implode(','),
                    'notify_message' => $item->message,
                    'notify_recur' => $item->is_recur,
                    'notify_notified' => $item->has_notified,
                    'notify_uuid' => $item->uuid,
                ];
            });

//       dd($notifications);
//
//        return [
//            [
//                'event_date' => now()->toISOString(),
//                'event_title' => "April Fool's Day",
//                'event_theme' => 'blue'
//            ]
//        ];
    }

    public function notifyMe(Request $request)
    {
        $emailInput = collect($request->input('email'))->mapWithKeys(function ($email, $index) {
            return ['email.'.$index => $email];
        })->toArray();

        $request->validate(
            [
                'email.*' => 'email|required',
                'date' => 'date|required',
            ],
            [
                'email.*' => 'Email :attribute must be valid',
            ],
            $emailInput,
        );

        $hour = ($request->input('ampm') == 'pm') ? $request->input('hours') + 12 : $request->input('hours');
        $date = Carbon::parse($request->input('date').' '.$hour.':'.$request->input('minutes'));

        $notification = new \Lokalkoder\NotifyMe\NotifyMe\Models\NotifyMe();
        $notification->recipients = $request->input('email');
        $notification->subject = $request->input('subject');
        $notification->message = $request->input('message');
        $notification->is_recur = $request->input('recur') === 'on';
        $notification->date = $date;
        $notification->source = ['id' => $request->input('id'), 'model' => $request->input('model')];
        $notification->assignee = auth()->user()->toArray();
        $notification->save();

        $request->session()->flash('status', $notification->subject.' Notification was successfully saved');

        return redirect($request->input('back') ?? route('notify.me'));
    }

    public function notifyUpdate(Request $request)
    {
        $notification = \Lokalkoder\NotifyMe\NotifyMe\Models\NotifyMe::whereUuid($request->input('notify'))->first();
        $notification->is_recur = $request->input('is_recur');
        $notification->save();
    }
}
