<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message->load(['sender', 'receiver']);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'message' => $this->message->message,
            'status' => $this->message->status,
            'type' => $this->message->type,
            'attachment' => $this->message->attachment,
            'attachment_type' => $this->message->attachment_type,
            'attachment_name' => $this->message->attachment_name,
            'attachment_size' => $this->message->attachment_size,
            'attachment_extension' => $this->message->attachment_extension,
            'attachment_mime_type' => $this->message->attachment_mime_type,
            'created_at' => $this->message->created_at,
            'updated_at' => $this->message->updated_at,
            'sender' => [
                'id' => $this->message->sender->id,
                'name' => $this->message->sender->name,
                'email' => $this->message->sender->email,
            ],
            'receiver' => [
                'id' => $this->message->receiver->id,
                'name' => $this->message->receiver->name,
                'email' => $this->message->receiver->email,
            ],
            'attachment_url' => $this->message->attachment_url,
            'attachment_thumbnail_url' => $this->message->attachment_thumbnail_url,
            'preview' => $this->message->preview,
            'is_sender' => $this->message->is_sender,
            'is_receiver' => $this->message->is_receiver,
            'room_id' => $this->message->room_id,
            'date' => $this->message->date,
            'time' => $this->message->time,
        ];
    }
}
