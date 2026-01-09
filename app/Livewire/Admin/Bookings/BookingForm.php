<?php

namespace App\Livewire\Admin\Bookings;

use App\Models\Reservation;
use App\Models\Bien;
use App\Models\User;
use Livewire\Component;

class BookingForm extends Component
{
    public $bookingId = null;
    public $isEdit = false;
    
    public $client_id = '';
    public $bien_id = '';
    public $date_debut = '';
    public $date_fin = '';
    public $nombre_personnes = 1;
    public $montant_total = '';
    public $statut = 'EN_ATTENTE';
    public $commentaires = '';

    public function mount($id = null)
    {
        if ($id) {
            $this->bookingId = $id;
            $this->isEdit = true;
            $booking = Reservation::findOrFail($id);
            
            $this->client_id = $booking->client_id;
            $this->bien_id = $booking->bien_id;
            $this->date_debut = $booking->date_debut ? $booking->date_debut->format('Y-m-d') : '';
            $this->date_fin = $booking->date_fin ? $booking->date_fin->format('Y-m-d') : '';
            $this->nombre_personnes = $booking->nombre_personnes ?? 1;
            $this->montant_total = $booking->montant_total ?? '';
            $this->statut = $booking->statut ?? 'EN_ATTENTE';
            $this->commentaires = $booking->commentaires ?? '';
        }
    }

    public function updatedBienId()
    {
        if ($this->bien_id && $this->date_debut && $this->date_fin) {
            $this->calculateAmount();
        }
    }

    public function updatedDateDebut()
    {
        if ($this->bien_id && $this->date_debut && $this->date_fin) {
            $this->calculateAmount();
        }
    }

    public function updatedDateFin()
    {
        if ($this->bien_id && $this->date_debut && $this->date_fin) {
            $this->calculateAmount();
        }
    }

    public function calculateAmount()
    {
        if (!$this->bien_id || !$this->date_debut || !$this->date_fin) {
            return;
        }

        $bien = Bien::find($this->bien_id);
        if (!$bien) {
            return;
        }

        $debut = \Carbon\Carbon::parse($this->date_debut);
        $fin = \Carbon\Carbon::parse($this->date_fin);
        $jours = $debut->diffInDays($fin);

        // Calcul basique selon la fréquence
        $prix = $bien->prix_location ?? 0;
        $frequence = $bien->frequence_location ?? 'MENSUEL';

        switch ($frequence) {
            case 'QUOTIDIEN':
                $this->montant_total = $prix * $jours;
                break;
            case 'HEBDOMADAIRE':
                $this->montant_total = $prix * ceil($jours / 7);
                break;
            case 'MENSUEL':
                $this->montant_total = $prix * ceil($jours / 30);
                break;
            case 'ANNUEL':
                $this->montant_total = $prix * ceil($jours / 365);
                break;
            default:
                $this->montant_total = $prix;
        }
    }

    protected function rules()
    {
        return [
            'client_id' => 'required|exists:users,id',
            'bien_id' => 'required|exists:biens,id',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
            'nombre_personnes' => 'required|integer|min:1',
            'montant_total' => 'required|numeric|min:0',
            'statut' => 'required|in:EN_ATTENTE,CONFIRME,ANNULE,TERMINE',
            'commentaires' => 'nullable|string|max:1000',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'client_id' => $this->client_id,
            'bien_id' => $this->bien_id,
            'date_debut' => $this->date_debut,
            'date_fin' => $this->date_fin,
            'nombre_personnes' => $this->nombre_personnes,
            'montant_total' => $this->montant_total,
            'statut' => $this->statut,
            'commentaires' => $this->commentaires,
        ];

        if ($this->isEdit) {
            $booking = Reservation::findOrFail($this->bookingId);
            $booking->update($data);
            
            if ($this->statut == 'CONFIRME' && !$booking->date_confirmation) {
                $booking->update(['date_confirmation' => now()]);
            }
            
            session()->flash('success', 'Réservation modifiée avec succès.');
        } else {
            $data['date_reservation'] = now();
            $booking = Reservation::create($data);
            session()->flash('success', 'Réservation créée avec succès.');
        }

        return redirect()->route('admin.bookings.show', $booking->id);
    }

    public function render()
    {
        $clients = User::whereHas('roles', function ($q) {
            $q->where('name', 'client');
        })->get();
        
        $biens = Bien::where('disponibilite', 'DISPONIBLE')
            ->where('est_publie', true)
            ->with('promoteur')
            ->get();

        return view('livewire.admin.bookings.booking-form', [
            'clients' => $clients,
            'biens' => $biens,
        ])->layout('layouts.admin');
    }
}

