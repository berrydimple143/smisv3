<?php

namespace App\Http\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Component;

class Register extends Component
{	    
    public $email = '';
    public $password = '';
    public $passwordConfirmation = '';

    public function register()
    {
        $this->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:7', 'confirmed', "regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/"],
            'password_confirmation' => ['required', 'min:7'],
        ]);

        $user = User::create([
            'email' => $this->email,            
            'password' => Hash::make($this->password),
        ]);

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended(route('login'));
    }
    public function render()
    {
        return view('livewire.auth.register')->extends('layouts.auth');
    }
}
