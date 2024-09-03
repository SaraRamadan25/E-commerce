<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     *
     * @param array $orderDetails
     * @return void
     */
    public $orderDetails;
    public $totalQuantity;
    public $totalAmount;

    public function __construct($orderDetails, $totalQuantity, $totalAmount)
    {
        $this->orderDetails = $orderDetails;
        $this->totalQuantity = $totalQuantity;
        $this->totalAmount = $totalAmount;
    }

    public function build()
    {
        return $this->view('emails.order-confirmation')
            ->with([
                'orderDetails' => $this->orderDetails,
                'totalQuantity' => $this->totalQuantity,
                'totalAmount' => $this->totalAmount,
            ]);
    }
}
