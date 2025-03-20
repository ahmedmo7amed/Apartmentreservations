<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showLoginForm()
    {
        return Inertia::render('Auth/CustomerLogin');
    }

    public function showRegistrationForm(): Response
    {
        return Inertia::render('Auth/CustomerRegister');
    }

    public function index()
    {
        return Inertia::render('Customers/Index');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if (Auth::attempt(array_merge($credentials, ['type' => 'customer']))) {
            return redirect()->intended('/');

        }
        return redirect()->back()->with('error', ' بيانات التسجيل غير صحيحة');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Inertia::render('Customers/Create');
    }

    /**
     * Display the specified resource.
     */

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // إبطال الجلسة
        $request->session()->regenerateToken(); // إعادة إنشاء توكن الحماية
        return redirect('/'); // إعادة توجيه المستخدم إلى الصفحة الرئيسية
    }

    public function register(RegisterRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'customer',
            'phone' => $request->phone,
            'country' => $request->country_id,
            'address' => $request->address,
        ]);
        $user->assignRole('Customer');
        event(new Registered($user));

        Auth::login($user);
        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'redirect' => route('login'), // تأكد أن هذا المسار موجود
        ]);
    }
    public function show(string $id)
    {
        return Inertia::render('Customers/Show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Customers/Edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'country_id' => 'required',
        ]);

        $customer = Customer::find($id);
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->address = $request->address;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->country_id = $request->country_id;
        $customer->update();
        return redirect(route('customers.index')->with('success', 'Customer updated successfully'));
    }

    public function verify()
    {
        return view('authentication.verify');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully']);
    }
    public function resendVerification(Request $request)
    {
        $user = Auth::user();
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home')->with('success', 'Your email is already verified');
        }
        $user->sendEmailVerificationNotification();
        return redirect()->back()->with('success', 'Verification link sent successfully');
    }

//
//    /**
//     * Store a newly created resource in storage.
//     */
//    //'first_name', 'last_name', 'address', 'phone', 'email', 'country_id'
//    public function store(Request $request)
//    {
//        $request = $request->validate([
//            'first_name' => 'required',
//            'last_name' => 'required',
//            'address' => 'required',
//            'phone' => 'required',
//            'email' => 'required|string|lowercase|email|max:255|unique:'.Customer::class,
//            'country_id' => 'required',
//            'password' => ['required', 'confirmed', Rules\Password::defaults()],
//        ]);
//
//        $customer = new Customer();
//        $customer->first_name = $request->first_name;
//        $customer->last_name = $request->last_name;
//        $customer->address = $request->address;
//        $customer->phone = $request->phone;
//        $customer->email = $request->email;
//        $customer->country_id = $request->country_id;
//        $customer->password = Hash::make($request->password);
//        Auth::guard('customers')->login();
//        $customer->assignRole('Customer');
//
//
//        $customer->save();
//    }

}
