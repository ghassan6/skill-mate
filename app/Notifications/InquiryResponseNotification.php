<?php

namespace App\Notifications;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InquiryResponseNotification extends Notification
{
    use Queueable;

    public $inquiry;
    public $response; // 'accepted' or 'rejected'
    public $custom_message;

    public function __construct(Inquiry $inquiry, $response, $custom_message = null)
    {
        $this->inquiry = $inquiry;
        $this->response = $response;
        $this->custom_message = $custom_message;
    }

    public function via($notifiable)
    {
        // You can add other channels as needed (mail, broadcast, etc.)
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your Inquiry Has Been ' . ucfirst($this->response))
                    ->greeting('Hello ' . $notifiable->first_name . '!')
                    ->line('Your inquiry regarding the service "' . $this->inquiry->service->title . '" has been ' . $this->response . '.')
                    ->action('View Inquiry', url(route('inquiries.show', $this->inquiry->id)))
                    ->line('Thank you for using our platform!');
    }

    public function toArray($notifiable)
    {
        return [
            'inquiry_id'=> $this->inquiry ? $this->inquiry->id : null,
            'service_title'=> $this->inquiry ? $this->inquiry->service->title : 'N/A',
            'service_id'=> $this->inquiry ? $this->inquiry->service->id : null,
            'response'=> $this->response,
            'custom_message'=> $this->custom_message,
            'message'=> "Your inquiry has been " . $this->response . "ed",
        ];
    }


}
