<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public array $orderDetails;

    /**
     * Create a new message instance.
     *
     * @param array $orderDetails
     * @return void
     */
    public function __construct(array $orderDetails)
    {
        $this->orderDetails = $orderDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.order-confirmation')
            ->with('orderDetails', $this->orderDetails);
    }
}
