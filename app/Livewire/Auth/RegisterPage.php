<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[Title('register')]

class RegisterPage extends Component
{
    Public $name;
    Public $email;
    Public $password;
    Public $password_confirmation;

    Public function save(){
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:4|max:255|confirmed'
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'password_confirmation' => $this->password_confirmation
        ]);

        auth()->login($user);

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
