<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;

use Livewire\Component;
use DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Password extends Component
{
    public $password, $old_password, $password_confirmation;
    protected $listeners = ['redirectToHome'];
    
    protected function rules() {
        return [
            'old_password' => ['required'],
            'password' => ['required', 'min:7'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }
    public function redirectToHome() {
        return redirect()->route('dashboard');
    }
    public function resetInputs()
    {
       $this->password = '';
       $this->old_password = '';
       $this->password_confirmation = '';
    }
    
    public function render()
    {
        return view('livewire.profile.password')->extends('layouts.app');
    }
    
    public function update() {
        $this->validate();
        $pass = Auth::user()->password;
        if(Hash::check($this->old_password, $pass)) {
            try {
                DB::beginTransaction();
                $user = User::where('id', Auth::user()->id)->update(['password' => Hash::make($this->password)]);
                DB::commit();
                $this->resetInputs();
                $this->emit('passwordUpdated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('passwordUpdateFailed', $e->getMessage());
                return $e->getMessage();
            }
        } else {
            $this->resetInputs();
            $this->emit('passwordNotFound');
        }
    }
}
