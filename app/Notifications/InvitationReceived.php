<?php

namespace App\Notifications;

use App\Models\ItemList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitationReceived extends Notification
{
    use Queueable;

    public ItemList $list;

    /**
     * Create a new notification instance.
     */
    public function __construct(int $list_id)
    {
        $this->list = ItemList::find($list_id);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line(__('You received an invitation to participate in the list (:name)', ['name' => $this->list->name]))
            ->action('Show Invitation', url(route('invitations.show')))
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
            'title'     => __("Invitation received"),
            'body'      => __("You received an invitation to participate in the list (:name)", ['name' => $this->list->name]),
            'list_id' => $this->list_id ?? "error",
        ];
    }
}
