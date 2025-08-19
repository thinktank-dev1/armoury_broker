<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

class HowItWorks extends Component
{
    public $data = [];

    public function mount(){
        $this->data = [
            1 => [
                'icon' => 'linearicons-list',
                'step' => "Step 1",
                "title" => "LIST YOUR ITEM",
                "description" => 'Seller creates product listing with specifications, images, and pricing.',
            ],
            2 => [
                'icon' => 'linearicons-cart',
                'step' => "Step 2",
                "title" => "BUYER MAKES PURCHASE",
                "description" => 'Buyer finds item and clicks "Buy Now" - order created with unique ID.',
            ],
            3 => [
                'icon' => 'linearicons-alarm',
                'step' => "Step 3",
                "title" => "SALE NOTIFICATION",
                "description" => 'Seller automatically notified: "Sale pending - awaiting payment".',
            ],
            4 => [
                'icon' => 'linearicons-credit-card',
                'step' => "Step 4",
                "title" => "SECURE PAYMENT",
                "description" => 'Buyer completes payment via EFT or card into secure Armoury Broker escrow account.',
            ],
            5 => [
                'icon' => 'linearicons-vault',
                'step' => "Step 5",
                "title" => "FUNDS SECURED",
                "description" => 'Payment verified and held safely in escrow - both parties notified.',
            ],
            6 => [
                'icon' => 'linearicons-truck',
                'step' => "Step 6",
                "title" => "SHIP ITEM",
                "description" => 'Seller receives shipping/dealer stocking instructions and reminders.',
            ],
            7 => [
                'icon' => 'linearicons-arrows-merge',
                'step' => "Step 7",
                "title" => "DELIVERY TRACKING",
                "description" => 'Seller confirms dispatch - buyer receives tracking notification.',
            ],
            8 => [
                'icon' => 'linearicons-truck',
                'step' => "Step 8",
                "title" => "DELIVERY COMPLETE",
                "description" => 'Buyer receives item, inspects, and confirms "Order Complete"',
            ],
            9 => [
                'icon' => 'linearicons-credit-card',
                'step' => "Step 9",
                "title" => "PAYMENT RELEASED",
                "description" => 'Funds automatically released from escrow to sellers wallet.',
            ],
            10 => [
                'icon' => 'linearicons-credit-card',
                'step' => "Step 10",
                "title" => "TRANSACTION COMPLETE",
                "description" => 'Seller can withdraw payment to bank account - transaction finished.',
            ],
        ];
    }

    #[Layout('components.layouts.landing')]
    public function render(){
        return view('livewire.landing.how-it-works');
    }
}
