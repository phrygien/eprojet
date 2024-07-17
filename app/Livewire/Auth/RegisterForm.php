<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Mary\Traits\Toast;

class RegisterForm extends Component
{
    use Toast;

    #[Validate('required|max:255')]
    public string $name;

    #[Validate('required|email|max:255|unique:users,email')]
    public string $email;

    #[Validate('required|min:6|same:confirm_password')]
    public string $password;

    #[Validate('required|min:6|same:password')]
    public string $confirm_password;

    public function save()
    {
        $this->validate();

        User::create([
         'name' => $this->name,
         'email' => $this->email,
         'password' => Hash::make($this->password)
        ]);

        $credentials = [
             'email' => $this->email,
             'password' => $this->password,
         ];

         Auth::attempt($credentials);

       $this->success('Welcome '.$this->name.' You have successfully registered & logged in!');

         $this->redirect(
             url: route('pages:home'),
         );
    }

    public function render()
    {
        return view('livewire.auth.register-form');
    }
}
