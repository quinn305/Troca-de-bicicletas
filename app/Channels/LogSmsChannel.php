<?php
namespace BikeShare\Channels;

use Bikeshare\Exceptions\CouldNotSendLogSmsNotification;
use Illuminate\Notifications\Notification;

class LogSmsChannel
{

    /**
     * Send the given notification.
     *
     * @param  mixed                                 $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws CouldNotSendLogSmsNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toLogSms($notifiable);

        if (! isset($message->to) || empty($message->to)) {
            if (! $to = $notifiable->routeNotificationFor('logsms')) {
                throw CouldNotSendLogSmsNotification::phoneNotProvided();
            }
            $message->to = [$to];
        }

        $messageArray = $message->toArray();
        \Log::useDailyFiles(storage_path().'/logs/sms.log');
        \Log::notice(
            'SMS',
            'Send sms to [' . $messageArray['phones'] . '] with text:' . PHP_EOL . $messageArray['text']
        );
    }
}
