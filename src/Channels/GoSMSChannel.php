<?php

namespace Zorb\GoSMS\Channels;

use Illuminate\Notifications\Notification;
use Zorb\GoSMS\GoSMS;

class GoSMSChannel
{
    /**
     * @param $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toGoSMS($notifiable);

        (new GoSMS())->send(
            $message->getRecipient(),
            $message->getContent()
        );
    }
}
