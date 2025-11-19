<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginModal extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $showModal = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    protected $listeners = ['openLoginModal'];

    public function openLoginModal()
    {
        $this->showModal = true;
        $this->reset(['email', 'password', 'remember']);
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['email', 'password', 'remember']);
        $this->resetValidation();
    }

    public function switchToRegister()
    {
        $this->showModal = false;
        $this->dispatch('openRegisterModal');
    }

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            
            $user = Auth::user();
            
            // Role-based redirection
            if ($user->isAdmin()) {
                return redirect()->intended('/admin');
            } elseif ($user->isPromoter()) {
                if ($user->promoter && $user->promoter->status === 'approved') {
                    return redirect()->intended('/promoter/dashboard');
                } else {
                    return redirect()->route('promoter.pending');
                }
            } elseif ($user->isClient()) {
                return redirect()->intended('/my/dashboard');
            }
            
            return redirect()->intended('/');
        }

        $this->addError('email', __('messages.auth.invalid_credentials'));
    }

    public function render()
    {
        return view('livewire.auth.login-modal');
    }
}
