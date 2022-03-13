<?php

namespace App\Notifications;

use App\Models\Lineman;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class Dispatch extends Notification
{
    use Queueable;

    protected $units;

    public function __construct($units)
    {
        $this->units = $units;
    }

    public function via($notifiable)
    {
        return ['firebase'];
    }

    public function toFirebase(Lineman $lineman)
    {
        if (!$lineman->fcm_token) return;

        $units_count = count($this->units);

        return (new FirebaseMessage)
            ->withTitle('Dispatch Notification')
            ->withBody('Assigned to ' . $units_count . ' location' . $units_count > 1 ? 's' : '')
            ->withPriority('high')->asMessage($lineman->fcmTokens);
    }
}
