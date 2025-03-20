<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Inertia\Response;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return Inertia::render('Auth/CustomerLogin');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Debugging: Check if customer exists
        $customer = Customer::where('email', $request->email)->first();
        if (!$customer) {
            return back()->withErrors(['email' => 'Customer not found.'])->onlyInput('email');
        }

        if (!Hash::check($request->password, $customer->password)) {
            \Log::debug('Attempted password: ' . $request->password);
            \Log::debug('Stored password: ' . $customer->password);
            return back()->withErrors(['password' => 'Incorrect password.'])->onlyInput('email');
        }


        // Login manually instead of using attempt()
        Auth::guard('customers')->login($customer, $request->filled('remember'));

        return redirect()->intended('/flats');
    }

    public function logout(Request $request)
    {
        Auth::guard('customers')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/Customer/login');
    }

    public function showRegistrationForm(): Response
    {
        return Inertia::render('Auth/CustomerRegister');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:customers,email',
            'country_id' => 'Integer|exists:countries,id',  // تأكد من وجود جدول `countries`
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'country_id' => $request->country_id,  // إذا كان لديك حقل `country_id`
            'password' => bcrypt($request->password),
        ]);

        event(new Registered($customer));

        Auth::guard('customers')->login($customer);

        return redirect()->intended('/flats');
    }
}
