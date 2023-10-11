<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProductSoldNotification extends Notification
{
    use Queueable;

    protected $product;
    protected $orderDetailsForNotif;

    public function __construct(Product $product, $orderDetailsForNotif)
    {
        $this->product = $product;
        $this->orderDetailsForNotif = $orderDetailsForNotif;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Your product has been sold.')
            ->line('Product Description: ' . $this->product->prod_description) // Add this line
            ->line('Order Details: ' . $this->orderDetailsForNotif) // Add this line
            ->action('View Order Details', url('/sales'))
            ->line('Thank you for using our platform!');
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
