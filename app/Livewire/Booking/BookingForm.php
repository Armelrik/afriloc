<?php

namespace App\Livewire\Booking;

use App\Models\Bien;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;

class BookingForm extends Component
{
    public $propertyId;
    public $property;
    
    // Customer Information
    public $customer_name = '';
    public $customer_email = '';
    public $customer_phone = '';
    public $num_people = 1;
    public $comments = '';
    
    // Booking Details - Dynamic based on frequency
    public $start_date;
    public $rental_duration = 1;
    public $end_date;
    
    // Calculated fields
    public $calculatedCosts = [];
    public $minDate;
    
    // Success modal
    public $showSuccessModal = false;
    public $createdReservationId = null;

    // Protected properties for type casting
    protected $casts = [
        'num_people' => 'integer',
        'rental_duration' => 'integer',
    ];

    public function mount($propertyId)
    {
        $this->propertyId = $propertyId;
        $this->property = Bien::with(['promoteur.user'])->publie()->findOrFail($propertyId);
        
        // Set minimum date to today
        $this->minDate = now()->format('Y-m-d');
        
        // Set default start date based on frequency
        if (in_array($this->property->frequence_location, ['mensuel', 'annuel'])) {
            // For monthly/yearly rentals, start date is immediate after acceptance
            $this->start_date = now()->addDays(3)->format('Y-m-d');
        } else {
            // For daily/weekly rentals, set to tomorrow
            $this->start_date = now()->addDay()->format('Y-m-d');
        }
        
        // Pre-fill if user is logged in
        if (Auth::check()) {
            $this->customer_name = Auth::user()->nom . ' ' . Auth::user()->prenom;
            $this->customer_email = Auth::user()->email;
            $this->customer_phone = Auth::user()->telephone ?? '';
        }
        
        // Initialize costs
        $this->calculateDatesAndCosts();
    }

    protected function rules()
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'num_people' => 'required|integer|min:1',
            'rental_duration' => 'required|integer|min:1',
            'comments' => 'nullable|string|max:1000',
        ];

        // Add date validation based on frequency
        if (in_array($this->property->frequence_location, ['quotidien', 'hebdomadaire'])) {
            $rules['start_date'] = 'required|date|after_or_equal:today';
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'customer_name.required' => 'Le nom complet est requis',
            'customer_email.required' => 'L\'email est requis',
            'customer_email.email' => 'L\'email doit être valide',
            'customer_phone.required' => 'Le téléphone est requis',
            'num_people.required' => 'Le nombre de personnes est requis',
            'num_people.min' => 'Au moins 1 personne est requise',
            'rental_duration.required' => 'La durée est requise',
            'rental_duration.min' => 'La durée minimale est 1',
            'start_date.required' => 'La date d\'arrivée est requise',
            'start_date.after_or_equal' => 'La date d\'arrivée ne peut pas être dans le passé',
        ];
    }

    public function updatedStartDate()
    {
        $this->calculateDatesAndCosts();
    }

    public function updatedRentalDuration()
    {
        $this->calculateDatesAndCosts();
    }

    public function calculateDatesAndCosts()
    {
        if (!$this->property) {
            return;
        }

        // Ensure rental_duration is an integer
        $duration = (int) $this->rental_duration;
        if ($duration < 1) {
            $duration = 1;
            $this->rental_duration = 1;
        }

        // Calculate end date based on frequency and duration
        $startDate = $this->start_date ? Carbon::parse($this->start_date) : Carbon::now()->addDays(3);
        
        switch ($this->property->frequence_location) {
            case 'quotidien':
                $this->end_date = $startDate->copy()->addDays($duration)->format('Y-m-d');
                break;
            case 'hebdomadaire':
                $this->end_date = $startDate->copy()->addWeeks($duration)->format('Y-m-d');
                break;
            case 'mensuel':
                $this->end_date = $startDate->copy()->addMonths($duration)->format('Y-m-d');
                break;
            case 'annuel':
                $this->end_date = $startDate->copy()->addYears($duration)->format('Y-m-d');
                break;
            default:
                $this->end_date = $startDate->copy()->addMonths($duration)->format('Y-m-d');
                break;
        }

        // Calculate costs
        $this->calculatedCosts = $this->calculateTotalCost();
    }

    private function calculateTotalCost()
    {
        if (!$this->property || !$this->property->prix_location) {
            return [
                'base_rent' => 0,
                'total_rent' => 0,
                'deposit' => 0,
                'platform_commission' => 0,
                'promoter_amount' => 0,
                'total_due' => 0,
            ];
        }

        $baseRent = (float) $this->property->prix_location;
        $duration = (int) $this->rental_duration;
        
        // Ensure duration is at least 1
        if ($duration < 1) {
            $duration = 1;
        }
        
        // Total rent for the entire duration
        $totalRent = $baseRent * $duration;
        
        // Deposit (from property or default to 2 periods)
        $deposit = $this->property->depot_garantie 
            ? (float) $this->property->depot_garantie 
            : ($baseRent * 2);
        
        // Platform commission = 1 month (one period) only
        $platformCommission = $baseRent;
        
        // Total due = Total Rent + Deposit + Commission (1 month)
        $totalDue = $totalRent + $deposit + $platformCommission;
        
        // Amount for promoter (total rent - commission of 1 month)
        $promoterAmount = $totalRent - $platformCommission;

        return [
            'base_rent' => $baseRent,
            'total_rent' => $totalRent,
            'deposit' => $deposit,
            'platform_commission' => $platformCommission,
            'promoter_amount' => $promoterAmount,
            'total_due' => $totalDue,
        ];
    }

    public function submit()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            session()->flash('error', 'Vous devez être connecté pour effectuer une réservation.');
            return redirect()->route('login');
        }

        $this->validate();

        try {
            DB::beginTransaction();

            // Create reservation
            $reservation = Reservation::create([
                'client_id' => Auth::id(),
                'bien_id' => $this->propertyId,
                'date_debut' => $this->start_date,
                'date_fin' => $this->end_date,
                'nombre_personnes' => (int) $this->num_people,
                'montant_total' => (float) $this->calculatedCosts['total_due'],
                'statut' => 'EN_ATTENTE',
                'commentaires' => $this->comments,
                'date_reservation' => now(),
            ]);

            // TODO: Create payment record if needed
            // TODO: Send notification to property owner
            // TODO: Send confirmation email to customer

            DB::commit();

            // Store reservation ID and show success modal
            $this->createdReservationId = $reservation->id;
            $this->showSuccessModal = true;

        } catch (\Exception $e) {
            DB::rollBack();
            
            session()->flash('error', 'Une erreur est survenue lors de la réservation. Veuillez réessayer.');
            
            \Log::error('Booking error: ' . $e->getMessage(), [
                'property_id' => $this->propertyId,
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function closeModal()
    {
        $this->showSuccessModal = false;
    }

    public function viewReservation()
    {
        if ($this->createdReservationId) {
            return redirect()->route('reservations.show', $this->createdReservationId);
        }
    }

    public function render()
    {
        return view('livewire.booking.booking-form')->layout('layouts.app');
    }
}