<?php

namespace BikeShare\Channels;

use Bikeshare\Exceptions\CouldNotSendEuroSmsNotification;
use BikeShare\Http\Services\Sms\EuroSms;
use GuzzleHttp\Client;
use \Illuminate\Notifications\Notification;

class EuroSmsChannel
{

    /**
     * Send the given notification.
     *
     * @param  mixed                                 $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws CouldNotSendEuroSmsNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toEuroSms($notifiable);

        if (! isset($message->to) || empty($message->to)) {
            if (! $to = $notifiable->routeNotificationFor('eurosms')) {
                throw CouldNotSendEuroSmsNotification::phoneNotProvided();
            }
            $message->to = $to;
        }

        $params = $message->toArray();

        $service = (new EuroSms(
            config('bike-share.sms.connections.eurosms'),
            new Client()
        ))->makeRequest($params);
    }
}
