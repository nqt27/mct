<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class FormSubmitted extends Notification
{
    use Queueable;

    private $formData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($formData)
    {
        $this->formData = $formData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; // Lưu thông báo vào database
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Có liên hệ mới ',
            'type' => 'contact',
            'name' => $this->formData['name'],
            'phone' => $this->formData['phone'],
            'email' => $this->formData['email'],
            'content' => $this->formData['content'],
            'submitted_at' => now()->toDateTimeString(),
        ];
    }
}
