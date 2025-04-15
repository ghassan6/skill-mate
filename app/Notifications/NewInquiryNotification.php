<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Inquiry;

class NewInquiryNotification extends Notification
{
    use Queueable;

    public $inquiry;

    /**
     * Create a new notification instance.
     */
    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail' , 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('You received a new inquiry')
        ->greeting('Hello ' . $notifiable->first_name . '!')
        ->line('You have received a new inquiry regarding your service.')
        ->action('View Inquiry', url('/inquiries')) // adjust URL accordingly
        ->line('Thank you for using Skill Mate!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'inquiry_id' => $this->inquiry->id,
            'service_title' => $this->inquiry->service->title,
            'message' => $this->inquiry->message,
        ];
    }
}
