<?php

namespace App\Models\Services;

use App\Notifications\MailNotification;
use App\Notifications\SlackNotification;
use Notification;

class NotificationService
{
    public function sendEmail($firstName, $lastName, $email)
    {
        Notification::route('mail', $email)
            ->notify(new MailNotification($firstName, $lastName, $email));
    }

    public function sendSlackNotification($firstName, $lastName, $country, $phone, $email, $referralID)
    {
        $slack_channel = config('integration.slack_channel');
        Notification::route('slack', $slack_channel)
            ->notify(new SlackNotification($firstName, $lastName, $country, $phone, $email, $referralID));
    }
}