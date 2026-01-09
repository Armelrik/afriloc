<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Paiement;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentList extends Component
{
    use WithPagination;

    public $statusFilter = '';
    public $search = '';
    public $methodFilter = '';

    protected $queryString = ['statusFilter' => ['except' => ''], 'search' => ['except' => ''], 'methodFilter' => ['except' => '']];

    public function render()
    {
        $query = Paiement::with(['reservation.bien']);

        if ($this->statusFilter) {
            $query->where('statut', $this->statusFilter);
        }

        if ($this->methodFilter) {
            $query->where('methode_paiement', $this->methodFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('reference_transaction', 'like', '%' . $this->search . '%')
                  ->orWhere('numero_recu', 'like', '%' . $this->search . '%')
                  ->orWhereHas('reservation.client', function ($u) {
                      $u->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $payments = $query->latest()->paginate(15);

        $stats = [
            'total' => Paiement::sum('montant'),
            'completed' => Paiement::where('statut', 'VALIDE')->sum('montant'),
            'pending' => Paiement::where('statut', 'EN_ATTENTE')->count(),
            'failed' => Paiement::where('statut', 'ECHOUE')->count(),
        ];

        return view('livewire.admin.payments.payment-list', [
            'payments' => $payments,
            'stats' => $stats,
        ])->layout('layouts.admin');
    }

    public function clearFilters()
    {
        $this->reset(['statusFilter', 'search', 'methodFilter']);
    }

    public function viewDetails($id)
    {
        // Redirect to payment details page
        return redirect()->route('admin.payments.show', $id);
    }

    public function markAsCompleted($id)
    {
        $payment = Paiement::findOrFail($id);
        $payment->marquerValide();
        
        session()->flash('message', 'Payment marked as completed.');
    }

    public function refund($id)
    {
        $payment = Paiement::findOrFail($id);
        $payment->update(['statut' => 'REMBOURSE']);
        
        session()->flash('message', 'Payment refunded.');
    }
}


