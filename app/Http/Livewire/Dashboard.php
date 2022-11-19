<?php

namespace App\Http\Livewire;

use App\Events\NewRegistered;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('dashboard');
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect('/');
    }
}
