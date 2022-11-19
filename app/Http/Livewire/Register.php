<?php

namespace App\Http\Livewire;

use App\Events\NewRegistered;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Register extends Component
{
    public $emailSent = false;
    public $email;
    public $password;
    public $code;
    public $verification_code;
    public $user;

    public function render()
    {
        return view('register');
    }

    public function login()
    {
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $this->user = User::where('email', $this->email)->first();

        Auth::logout($this->user);

        if (!$this->user->email_verified_at) {
            $this->verification_code = rand(10000, 99999);
            event(new NewRegistered($this->user, $this->verification_code));
            $this->emailSent = true;
        }else{
            Auth::login($this->user);
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }

    public function register()
    {
        $this->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $this->verification_code = rand(10000, 99999);

        $this->user = User::create([
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        event(new NewRegistered($this->user, $this->verification_code));

        $this->emailSent = true;
    }

    public function submit()
    {
        if ($this->code == $this->verification_code) {
            $this->user->email_verified_at = now();
            $this->user->save();
            Auth::login($this->user);
            return redirect()->intended(RouteServiceProvider::HOME);
        }else{
            throw ValidationException::withMessages([
                'code' => trans('validation.verification_code'),
            ]);
        }
    }
}
