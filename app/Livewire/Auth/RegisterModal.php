<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RegisterModal extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ];

    protected $listeners = ['openRegisterModal'];

    public function openRegisterModal()
    {
        $this->showModal = true;
        $this->reset(['name', 'email', 'password', 'password_confirmation']);
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'email', 'password', 'password_confirmation']);
        $this->resetValidation();
    }

    public function switchToLogin()
    {
        $this->showModal = false;
        $this->dispatch('openLoginModal');
    }

    public function register()
    {
        $this->validate();

        // Create user with client role by default
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Assign client role
        $user->assignRole('client');

        // Login the user
        Auth::login($user);
        session()->regenerate();

        // Redirect to client dashboard
        return redirect()->route('client.dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register-modal');
    }
}
