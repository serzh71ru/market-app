<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredCompanyController extends Controller
{
    public function create(): View
    {
        return view('auth.registerCompany');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'abbreviated_name' => ['required', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Company::class],
            'phone' => ['required', 'string', 'min:18', 'max:18', 'unique:'.Company::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $company = Company::create([
            'abbreviated_name' => $request->abbreviated_name,
            'contact_name' => $request->contact_name,
            'email' => $request->email,
            'phone' =>$request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($company));

        Auth::guard('company')->login($company);

        return redirect(RouteServiceProvider::PROFILE);
    }
}
