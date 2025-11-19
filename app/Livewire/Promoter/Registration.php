<?php

namespace App\Livewire\Promoter;

use App\Models\Promoter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Registration extends Component
{
    use WithFileUploads;

    public $step = 1;
    
    // Step 1: User account
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    
    // Step 2: Professional info
    public $company_name = '';
    public $phone = '';
    public $whatsapp = '';
    public $address = '';
    
    // Step 3: Identity documents
    public $identification_number = '';
    public $identification_document;
    
    // Step 4: Bank account (optional)
    public $bank_account = '';

    protected function rules()
    {
        $rules = [];
        
        if ($this->step === 1) {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
            ];
        } elseif ($this->step === 2) {
            $rules = [
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
            ];
        } elseif ($this->step === 3) {
            $rules = [
                'identification_number' => 'required|string',
                'identification_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ];
        }
        
        return $rules;
    }

    public function nextStep()
    {
        $this->validate();
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function submit()
    {
        if ($this->step === 4) {
            $this->validate([
                'bank_account' => 'nullable|string',
            ]);
            
            // Create user account
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
            
            $user->assignRole('promoter');
            
            // Upload document
            $documentPath = null;
            if ($this->identification_document) {
                $documentPath = $this->identification_document->store('promoter-documents', 'public');
            }
            
            // Create promoter profile
            Promoter::create([
                'user_id' => $user->id,
                'company_name' => $this->company_name,
                'phone' => $this->phone,
                'whatsapp' => $this->whatsapp,
                'address' => $this->address,
                'identification_number' => $this->identification_number,
                'identification_document' => $documentPath,
                'bank_account' => $this->bank_account,
                'status' => 'pending',
            ]);
            
            Auth::login($user);
            
            session()->flash('success', __('Your application has been submitted successfully. You will be notified once it is approved.'));
            
            return redirect()->route('promoter.pending');
        }
    }

    public function render()
    {
        return view('livewire.promoter.registration')->layout('layouts.app');
    }
}
