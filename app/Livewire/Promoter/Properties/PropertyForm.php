<?php

namespace App\Livewire\Promoter\Properties;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class PropertyForm extends Component
{
    use WithFileUploads;

    public $propertyId = null;
    public $title_fr, $title_en, $description_fr, $description_en;
    public $type, $price, $rental_frequency = 'monthly';
    public $monthly_rent, $deposit_amount, $advance_payment;
    public $bedrooms, $bathrooms, $area;
    public $location, $address, $latitude, $longitude;
    public $is_for_rent = true, $is_for_sale = false;
    public $featured = false;
    public $images = [];
    public $video_url;

    public function mount($id = null)
    {
        if ($id) {
            $this->propertyId = $id;
            $property = Property::where('promoter_id', Auth::user()->promoter->id)->findOrFail($id);
            
            $this->fill($property->only([
                'title_fr', 'title_en', 'description_fr', 'description_en',
                'type', 'price', 'rental_frequency', 'monthly_rent', 
                'deposit_amount', 'advance_payment', 'bedrooms', 'bathrooms', 
                'area', 'location', 'address', 'latitude', 'longitude',
                'is_for_rent', 'is_for_sale', 'featured', 'video_url'
            ]));
        }
    }

    protected function rules()
    {
        return [
            'title_fr' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_fr' => 'required|string',
            'description_en' => 'nullable|string',
            'type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'rental_frequency' => 'required|in:daily,weekly,monthly,yearly',
            'monthly_rent' => 'nullable|numeric|min:0',
            'deposit_amount' => 'nullable|numeric|min:0',
            'advance_payment' => 'nullable|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'area' => 'required|numeric|min:0',
            'location' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_for_rent' => 'boolean',
            'is_for_sale' => 'boolean',
            'video_url' => 'nullable|url',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'promoter_id' => Auth::user()->promoter->id,
            'title_fr' => $this->title_fr,
            'title_en' => $this->title_en,
            'description_fr' => $this->description_fr,
            'description_en' => $this->description_en,
            'type' => $this->type,
            'price' => $this->price,
            'rental_frequency' => $this->rental_frequency,
            'monthly_rent' => $this->monthly_rent,
            'deposit_amount' => $this->deposit_amount ?? 0,
            'advance_payment' => $this->advance_payment ?? 0,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'area' => $this->area,
            'location' => $this->location,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'is_for_rent' => $this->is_for_rent,
            'is_for_sale' => $this->is_for_sale,
            'featured' => $this->featured,
            'video_url' => $this->video_url,
            'availability_status' => 'available',
            'status' => 'available',
        ];

        if ($this->propertyId) {
            $property = Property::where('promoter_id', Auth::user()->promoter->id)->findOrFail($this->propertyId);
            $property->update($data);
            session()->flash('success', __('Property updated successfully'));
        } else {
            Property::create($data);
            session()->flash('success', __('Property created successfully'));
        }

        return redirect()->route('promoter.properties');
    }

    public function render()
    {
        return view('livewire.promoter.properties.property-form')->layout('layouts.app');
    }
}
