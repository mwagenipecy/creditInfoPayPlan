<?php

namespace App\Livewire\Payment;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Plan extends Component
{

    public $showModal = false;
 
    public $planName;
    public $statementCount = 1;
    public $amount = 2500;

    public $network;
    public $phone;
    public $acceptTerms = false;

    protected $rules = [
        'network' => 'required|string',
        'phone' => 'required|min:9',
        'statementCount' => 'required|integer|min:1',
        'acceptTerms' => 'accepted'
    ];


    public function updatedStatementCount()
    {
        $this->amount = $this->statementCount * 2500;
    }

    public function openModal($planName, $defaultAmount)
    {
        $this->planName = $planName;
        $this->statementCount = $defaultAmount / 2500;
        $this->updatedStatementCount();
        $this->phone = '';
        $this->network = '';
        $this->acceptTerms = false;
        $this->showModal = true;
    }



    public function submitPayment()
    {
        $this->validate();

        sleep(2); // simulate loading delay

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.selcom.token'),
            'Content-Type' => 'application/json'
        ])->post('https://api.selcommobile.com/v1/payments/initiate', [
            'amount' => $this->amount,
            'mobile_number' => $this->phone,
            'network' => $this->network,
            'reference' => uniqid('STMNT-'),
            'description' => 'Purchase: ' . $this->planName,
           // 'merchant_id' => config('services.selcom.merchant_id'),
            //'callback_url' => route('payment.callback')
        ]);

        if ($response->successful()) {
            session()->flash('success', 'Payment initiated. Please confirm on your phone.');
            $this->showModal = false;
        } else {
            session()->flash('error', 'Payment failed: ' . $response->body());
        }
    }


    public function render()
    {
        return view('livewire.payment.plan');
    }
}
