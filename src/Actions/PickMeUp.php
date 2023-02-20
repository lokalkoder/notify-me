<?php

namespace Lokalkoder\NotifyMe\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lokalkoder\NotifyMe\PickMeUp\ModelPicker;
use Lokalkoder\NotifyMe\PickMeUp\RecipientPicker;

class PickMeUp extends Action
{
    /**
     * @throws \ReflectionException
     * @throws \Throwable
     */
    public function __invoke(Request $request)
    {
        return view(
            'notify-me::pick-me',
            [
                'notifier' => (new ModelPicker($request->get('model'), $request->get('id')))->notifier(),
                'recipients' => $this->getRecipients(),
                'back' => $request->server('HTTP_REFERER')
            ]
        );
    }

    /**
     * @return JsonResponse
     */
    public function getRecipientsSource()
    {
        return response()->json($this->getRecipients());
    }

    /**
     * Recipients listing.
     * @return mixed
     */
    protected function getRecipients()
    {
        return (new RecipientPicker())->recipients();
    }
}
