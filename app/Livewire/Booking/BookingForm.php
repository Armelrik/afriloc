<?php

namespace App\Livewire\Booking;

use App\Models\Property;
use App\Services\BookingService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookingForm extends Component
{
    public $propertyId;
    public $property;
    
    public $customer_name = '';
    public $customer_email = '';
    public $customer_phone = '';
    public $start_date;
    public $end_date;
    public $num_people = 1;
    public $rental_duration = 1;
    public $rental_frequency = 'monthly';
    public $comments = '';
    
    public $calculatedCosts = [];

    public function mount($propertyId)
    {
        $this->propertyId = $propertyId;
        $this->property = Property::findOrFail($propertyId);
        $this->rental_frequency = $this->property->rental_frequency;
        
        if (Auth::check()) {
            $this->customer_name = Auth::user()->name;
            $this->customer_email = Auth::user()->email;
        }
        
        $this->calculateCosts();
    }

    protected function rules()
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'num_people' => 'required|integer|min:1',
            'rental_duration' => 'required|integer|min:1',
            'rental_frequency' => 'required|in:daily,weekly,monthly,yearly',
        ];
    }

    public function updatedRentalDuration()
    {
        $this->calculateCosts();
    }

    public function updatedRentalFrequency()
    {
        $this->calculateCosts();
    }

    public function calculateCosts()
    {
        $bookingService = app(BookingService::class);
        $this->calculatedCosts = $bookingService->calculateTotalCost(
            $this->property,
            $this->rental_duration,
            $this->rental_frequency
        );
    }

    public function submit()
    {
        $this->validate();

        $bookingService = app(BookingService::class);
        
        $booking = $bookingService->processBooking([
            'property_id' => $this->propertyId,
            'user_id' => Auth::id(),
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'num_people' => $this->num_people,
            'rental_duration' => $this->rental_duration,
            'rental_frequency' => $this->rental_frequency,
            'comments' => $this->comments,
        ]);

        session()->flash('success', __('Booking request submitted successfully!'));
        
        return redirect()->route('properties.show', $this->propertyId);
    }

    public function render()
    {
        return view('livewire.booking.booking-form')->layout('layouts.app');
    }
}
