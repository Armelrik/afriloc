<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payment;
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
        $query = Payment::with(['user', 'booking.property']);

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->methodFilter) {
            $query->where('payment_method', $this->methodFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('transaction_id', 'like', '%' . $this->search . '%')
                  ->orWhere('payment_reference', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($u) {
                      $u->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $payments = $query->latest()->paginate(15);

        $stats = [
            'total' => Payment::sum('amount'),
            'completed' => Payment::completed()->sum('amount'),
            'pending' => Payment::pending()->count(),
            'failed' => Payment::where('status', 'failed')->count(),
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
}


