<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class SlackNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($firstName, $lastName, $country, $phone, $email, $referralID)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->country = $country;
        $this->phone = $phone;
        $this->email = $email;
        $this->referralID = $referralID;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the slack representation of the notification.
     * 
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
                    ->to('#bolt')
                    ->content('*Name:* '.$this->firstName.' '.$this->lastName."\n".
                              '*Email:* '.$this->email."\n".
                              '*Phone:* '.$this->phone."\n".
                              '*Country:* '.$this->country."\n".
                              '*Referral ID:* '.$this->referralID."\n");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
