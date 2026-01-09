<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Paiement;
use Livewire\Component;

class PaymentDetail extends Component
{
    public $payment;
    public $showValidateModal = false;
    public $showRefundModal = false;
    public $showFailModal = false;

    public function mount($id)
    {
        $this->payment = Paiement::with([
            'reservation.client',
            'reservation.bien.promoteur',
            'paiementMobileMoney',
            'paiementCarte',
            'commission'
        ])->findOrFail($id);
    }

    public function openValidateModal()
    {
        $this->showValidateModal = true;
    }

    public function openRefundModal()
    {
        $this->showRefundModal = true;
    }

    public function openFailModal()
    {
        $this->showFailModal = true;
    }

    public function validatePayment()
    {
        $this->payment->marquerValide();
        session()->flash('success', 'Paiement validé avec succès.');
        $this->closeModals();
        $this->payment->refresh();
    }

    public function refund()
    {
        $this->payment->update(['statut' => 'REMBOURSE']);
        session()->flash('success', 'Paiement remboursé avec succès.');
        $this->closeModals();
        $this->payment->refresh();
    }

    public function fail()
    {
        $this->payment->marquerEchoue();
        session()->flash('success', 'Paiement marqué comme échoué.');
        $this->closeModals();
        $this->payment->refresh();
    }

    public function closeModals()
    {
        $this->showValidateModal = false;
        $this->showRefundModal = false;
        $this->showFailModal = false;
    }

    public function render()
    {
        return view('livewire.admin.payments.payment-detail')->layout('layouts.admin');
    }
}

