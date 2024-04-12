<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendProductCreatedMailNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    } 

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(object $notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {        
        
        return (new MailMessage)
                    ->line('Product: ' . $this->product->name . 'created success')
                    ->action('Show product', $this->product)
                    ->line('Product Tastcase');
    }

}
